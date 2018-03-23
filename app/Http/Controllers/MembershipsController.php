<?php namespace App\Http\Controllers;

use App\DataModels\MembershipDataModel;
use Activity;
use App\Managers\AuthManager;
use App\Managers\BillingManager;
use App\Managers\RegistrationManager;
use App\Models\Agent;
use App\Models\Company;
use App\Models\CompanyPaymentMethod;
use App\Models\Customer;
use App\Models\Membership;
use App\Models\TrialCustomer;
use Auth;
use Carbon\Carbon;
use Flash;
use Input;
use Illuminate\Http\Request;
use Redirect;
use Validator;
use DataFilter;
use DataGrid;

class MembershipsController extends Controller
{

    public function index()
    {
        $authManager = new AuthManager();
        $customers = Customer::with('vehicle', 'membership', 'adder', 'company', 'user')
            ->where('type','=','customer');
        if (Input::get('source') == 'archived') {
            $customers = $customers->onlyTrashed();
        }
        if (Input::get('submit', 'search') === 'Expired') {
            $customers = $customers->whereRaw('DATE(`expiration_date`) < "'.date('Y-m-d').'"');
        }
        if (Input::get('submit', 'search') === 'Active') {
            $customers = $customers->whereRaw('DATE(`expiration_date`) > "'.date('Y-m-d').'"');
        }
        if (Input::get('submit', 'search') === 'Renewal') {
            $range = \App\Models\Settings::find(1);
            //$range = intval($range->value) * (24 * 60 * 60);
            $today = Carbon::now()->toDateString();
            $due_renewal_date = Carbon::now()->addDays($range->value)->toDateString();
            //$customers = $customers->whereRaw('(UNIX_TIMESTAMP(`expiration_date`)-'.$range.') < '.time());
            $customers = $customers->whereBetween('expiration_date',[$today,$due_renewal_date]);
        }
        if (!$authManager->isAnyRole(['master', 'finance', 'sales'])) {
            $customers = $customers->where('company_id', '=', $this->getCompanyIDOrNull());
        }
        if (Input::get('start_date') != "") {
            $start_date_filter = Input::get('start_date');
            Input::merge(['start_date' => '']);
            $customers = $customers->where(\DB::raw('DATE_FORMAT(start_date,"%Y-%m-01")'), '=', $start_date_filter);
        }
        $customers->orderBy('start_date', 'DESC');
        $filter = DataFilter::source($customers);

        $filter->add('customer.membership', 'membership',
            'select')->options(['' => 'membership'] + Membership::lists("membership_name", "id"));

        $filter->add('company_id', 'Company ID',
            'select')->options(['' => 'Company'] + Company::orderBy('name')->lists("name", "id"));
        $filter->add('accept_terms', 'accept_terms', 'select')->options([
            '' => 'Terms accepted',
            '0' => 'no',
            '1' => 'Yes'
        ]);
        $filter->add('vehicle_registration', 'Vehicle Registration', 'text');
        $filter->add('vehicle_registration', 'Vehicle Registration', 'text');
        //$filter->add('expiration_date', 'Date ranges', 'daterange')->format('m  /Y', 'en');
        $dates = Customer::where('type','=','customer')->groupBy(\DB::raw('Year(start_date),Month(start_date)'))
            ->get([
                \DB::raw('DATE_FORMAT(start_date,"%M %Y") as `value`')
                ,
                \DB::raw('DATE_FORMAT(start_date,"%Y-%m-01") as `key`')
            ])->toArray();
        $dates_filter = array();
        foreach ($dates as $date) {
            $dates_filter[$date['key']] = $date['value'];
        }
        //dd($dates);
        $filter->add('start_date', 'Date range', 'select')->options(['' => 'Start Date'] + $dates_filter);
        $filter->submit('search');
        $filter->submit('Expired', 'BL',
            ['class' => 'btn btn-danger', 'name' => 'submit', 'title' => 'Expired Memberships']);
        $filter->submit('download_csv', 'BL',
            ['class' => 'btn btn-primary form-btn csv', 'name' => 'submit', 'title' => 'Download CSV']);
        $filter->submit('download_excel', 'BL',
            ['class' => 'btn btn-primary form-btn excel', 'name' => 'submit', 'title' => 'Download Excel']);
        $filter->reset('reset');

        $filter->build();

        $grid = DataGrid::source($filter);
        if (Input::get('submit', 'search') === 'download_excel' || Input::get('submit', 'search') === 'download_csv') {

            $grid = $this->getFieldsForDownload($grid);
        } else {

            $grid = $this->getFieldsForGrid($grid);
        }
        if (!Input::get('source') == 'archived') {
            $grid->link(url('home/customer?source=archived'), "Deleted Records", "TR",
                array('class' => 'btn btn-info'));
        }
        // $grid->link('/user/register/company',"New Company", "TR");
        $grid->orderBy('id', 'asc');

        if (Input::get('submit', 'search') === 'download_csv') {
            return $grid->buildCSV('MemberShips', 'Y-m-d.His', true, ['delimiter' => ',']);
        }
        if (Input::get('submit', 'search') === 'download_excel') {
            return $grid->buildExcel('MemberShips', 'Y-m-d.His', true);

        }
        $grid->paginate(20);

        return view('home.master.customer', compact('filter', 'grid'));

    }

    public function getRegister()
    {


        $type = $this->getTypeNameForActiveUser();
        $payment_method = (new CompanyPaymentMethod())->getByCompanyId($this->getCompanyIDOrNull());

        $memberships = $this->getMemberShipsAvailable();

        $companies = Company::getCompanies();

        return view('memberships.register', array(
            'memberships' => $memberships,
            'payment_method' => $payment_method,
            'companies' => $companies,
            'logged_in' => $type
        ));
    }

    /**
     * master account can avoid payments
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postRegister(Request $request)
    {

        if (($validation_message_bag = $this->validateForm()) !== true) {
            return redirect()->back()->withErrors($validation_message_bag)->withInput();
        }
        $company_id = $this->getCompanyIDOrNull();
        $membership_data_model = new MembershipDataModel($request,
            ['company_id' => $company_id, 'added_by' => Auth::user()->id]);


        $can_bypass_payment = false;
        $can_bypass_notification = false;
        if ((new AuthManager())->isAnyRole(['master', 'sales', 'finance']) && $request->get('bypass_payment') == 1) {

            $can_bypass_payment = true;
        }
        if ((new AuthManager())->isAnyRole([
                'master',
                'sales',
                'finance'
            ]) && $request->get('bypass_notification') == 1
        ) {

            $can_bypass_notification = true;
        }
        $payment_return = [];
        if (!$can_bypass_payment) {
            $billing_manager = new BillingManager();
            $payment_status = $billing_manager->processPayment($company_id, $membership_data_model->membership);

            if (!$payment_status) {
                Flash::error("Your payment wasn't successful .".$billing_manager->error);

                return redirect()->back()->withInput();
            }
            $payment_return = $billing_manager->payment_return;
        }


        $registration_manager = new RegistrationManager();
        $user = $registration_manager->createMembership($membership_data_model, $can_bypass_notification);

        if (!$user) {

            Flash::error('Registration failed. The email provided has already been registered in the system, please provide a new email address.');

            return redirect()->back()->withInput();
        }

        Activity::addMember($membership_data_model->user_id,
            "registered member with username :  {$membership_data_model->username}");
        if ($can_bypass_payment) {
            Activity::pyPassedPayment($membership_data_model->user_id,
                "bypassed Payment for the user with username :  {$membership_data_model->username}");

        } else {
            Activity::paymentCompleted($membership_data_model->user_id, json_encode($payment_return));
        }
        if ($can_bypass_notification) {
            Activity::pyPassedNotification($membership_data_model->user_id,
                "bypassed notification for the user with username :  {$membership_data_model->username}");
        }

        Flash::success("{$membership_data_model->first_name} was added successfully");

        return redirect()->back();

    }

    public function getArchive($customer_id)
    {
        if (!$this->auth_manager->hasAccess(['members.delete'])) {
            Flash::error('You don\'t have access to do such action');

            return Redirect::back();

        }

        $customer = Customer::find($customer_id);
        if (!$customer) {
            Flash::error("Member not found");
        } else {
            $customer->delete();
            Flash::success("Member named " . $customer->first_name . " " . $customer->last_name . " was deleted successfully");
        }
//        $user_id = $customer->user_id;
//        $customer->is_archived =  1;
//        $customer->save();
        return Redirect::route('memberships');
    }

    private function validateForm()
    {

        $validator = Validator::make(Input::all(), [

            'vehicle_registration' => 'required',
            'fuel' => 'required',
            'colour' => 'required',
            'make' => 'required',
            'model' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'address_line_1' => 'required',
            'county' => 'required',
            'phone_number' => 'required',
            'nct' => 'required',
            'odometer_reading' => 'required',
            'odometer_type' => 'required',
            'username' => 'required',
            'membership_type' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }


    private function getFieldsForGrid(\Zofe\Rapyd\DataGrid\DataGrid $grid)
    {

        $grid->add('vehicle_registration', 'Vehicle Registration');
        $grid->add('phone_number', 'Phone Number');
        $grid->add('membership.membership_name', 'Membership');
        //$grid->add('membership_id', 'Membership ID');
        //$grid->add('title', 'Title');
        $grid->add('{{$first_name}} {{$last_name}}', 'Full Name');
        $grid->add('user.email', 'Email');
        $grid->add('start_date|date[m/d/Y]', 'Start Date');
        if (!Input::get('source') == 'archived'){

            $grid->edit(url('/user/edit/customer'), 'Edit', 'show'.(($this->auth_manager->hasAccess(['members.edit']))?'|modify':''))->style('width:60px;');
        }
        $grid->row(function ($row) {
            $row->style('cursor: pointer;');
        });

        return $grid;
    }

    /**
     * @param DataGrid $grid
     * @return DataGrid
     */
    private function getFieldsForDownload(\Zofe\Rapyd\DataGrid\DataGrid $grid)
    {
        //Form Name
        //Submission Date
        $grid->add('membership_id', 'CarTow Membership ID', true);
        $grid->add('company.name', 'Company or Dealership Name');
        //Agent Full Name
        $grid->add('adder.username', 'Members Full Name');
        $grid->add('email', 'Members E-mail');
        $grid->add('address_line_1', 'Members Address');
        $grid->add('phone_number', 'Members Phone Number');
        //Preffered next of kin Phone Number
        //Odometer Reading
        //Odometer Type
        //Tax renewal date (optional for friendly reminders)
        //NCT renewal date (optional for friendly reminders)
        $grid->add('membership.membership_name', 'Membership Type', 'text');
        $grid->add('start_date|date[m/d/Y]', 'Start date for cover');
        $grid->add('expiration_date|date[m/d/Y]', 'End date for cover');
        //Receipt of member payment received by agent
        //  	Verification
        //Receipt of member payment received by agent
        $grid->add('vehicle_registration', 'Vehicle Registration');
        $grid->add('title', 'Title');
        $grid->add('{{$first_name}} {{$last_name}}', 'Full Name');
        $grid->add('status', 'Status');
        $grid->add('number_of_assists', 'Number of Assists');
        $grid->row(function ($row) {
            if ($row->cell('adder.username')->value === '{{$adder->username}}') {
                $row->cell('adder.username')->value = 'Online';
            }

//                        $row->cell('checkbox')->value = '<input type="checkbox" name="" id="" />';

            if ($row->cell('company.name')->value === '{{$company->name}}') {
                $row->cell('company.name')->value = '-';
            }

            if (strtotime($row->cell('expiration_date')->value) < time()) {
                $row->style('color:#FF0000');
                $row->cell('status')->value = 'Expired';
            } else {
                $row->cell('status')->value = 'Active';
            }

        });


        return $grid;
    }

    /**
     * @param $type
     * @return array
     */
    private function getMemberShipsAvailable()
    {
        $membership_repository = new Membership();
        if ((new AuthManager())->isAnyRole(['master', 'sales', 'finance'])) {
            $memberships = $membership_repository->getMemberships();

            return $memberships;
        } else {
            $company_id = $this->getCompanyIDOrNull();

            $memberships = $membership_repository->getCompanyMemberships($company_id);

            return $memberships;

        }
    }

    /**
     * @return mixed|string
     */
    private function getTypeNameForActiveUser()
    {
        $type = Auth::user()->account_type;

        switch ($type) {
            case 1:
                $type = 'master';
                break;

            case 2:
                $type = 'subuser';
                break;

            case 3:
                $type = 'company';
                break;

            case 4:
                $type = 'agent';
                break;

            case 5:
                $type = 'customer';
                break;
        }

        return $type;
    }

    /**
     * @return mixed
     */
    private function getCompanyIDOrNull()
    {
        $company_id = Agent::where('user_id', '=', Auth::user()->id)->pluck('company_id');

        return $company_id;

    }

    public function getRenewMembership() {
        $customer_id = Input::get('customer_id');
        $membership_id = Input::get('membership_id');
        $type = $this->getTypeNameForActiveUser();
        $payment_method = (new CompanyPaymentMethod())->getByCompanyId($this->getCompanyIDOrNull());
        $memberships = $this->getMemberShipsAvailable();

        return view('memberships.renew', array(
            'memberships' => $memberships,
            'membership_id' => $membership_id,
            'customer_id' => $customer_id,
            'payment_method' => $payment_method,
            'logged_in' => $type
        ));
    }

    public function postRenewMembership() {
        //$req = Input::all();
        //dd($req);
        $customer_id = Input::get('customer_id');
        $membership_id = Input::get('membership_id');
        $company_id = $this->getCompanyIDOrNull();

        $can_bypass_payment = false;
        if ((new AuthManager())->isAnyRole(['master', 'sales', 'finance']) && Input::get('bypass_payment') == 1) {

            $can_bypass_payment = true;
        }
        $payment_return = [];
        if (!$can_bypass_payment) {
            $billing_manager = new BillingManager();
            $payment_status = $billing_manager->processPayment($company_id, $membership_id);

            if (!$payment_status) {
                Flash::error("Your payment wasn't successful .".$billing_manager->error);

                return redirect()->back()->withInput();
            }
            $payment_return = $billing_manager->payment_return;
        }

        $agent = Auth::user();
        if(!$customer_id || !$membership_id || !$agent) {
            Flash::error('Required input is missing or no user is logged in');
            return redirect()->back();
        }
        $agent_id = $agent->id;
        $customer = Customer::find($customer_id);
        $date_diff = $customer->expiration_date->diff(new Carbon());
        if($date_diff->invert == 1){
            Flash::error('This membership has not been expired yet, and can not be renewed');
            return redirect()->back();
        }
        $membership = Membership::find($membership_id);
        if(!$membership) {
            Flash::error('This membership is either deleted or can\'t be found');
            return redirect()->back();
        }
        $membership_duration = explode(' ',$membership->duration)[0];
        $new_start_date = Carbon::createFromFormat('Y-m-d',Input::get('start_date'));
        $the_start_date = Carbon::createFromFormat('Y-m-d',Input::get('start_date'));
        $new_expiry_date = $the_start_date->addMonths($membership_duration)->format('Y-m-d');
        $registration_manager = new RegistrationManager();
        $update_status = $registration_manager->renewCustomerMembership($customer,
            $new_start_date, $new_expiry_date);
        if(!$update_status) {
            Flash::error('There has been an error while trying to renew the membership');
            return redirect()->back();
        }
        Activity::renewMembership($agent_id,'Renewed a membership with id : '.$customer->membership_id.
            ' & vehicle registration : '.$customer->vehicle_registration);
        if ($can_bypass_payment) {
            Activity::pyPassedPayment($agent_id,
                "bypassed Payment for the user with username :  {$agent->username}");

        } else {
            Activity::paymentCompleted($agent_id, json_encode($payment_return));
        }
        Flash::success('The membership has been renewed successfully');
        return redirect()->back();
    }

    public function trialsIndex()
    {
        $customers = TrialCustomer::orderBy('start_date','DESC');

        $grid = DataGrid::source($customers);
        $grid->add('{{$first_name}} {{$last_name}}', 'Name');
        $grid->add('address_line', 'Address line');
        $grid->add('start_date', 'Start date');
        $grid->add('expiration_date', 'Expiry date');
        $grid->add('myvehicle_ref', 'MyVehicle no');
        //$grid->orderBy('id', 'asc');

        $grid->paginate(20);

        return view('home.master.trial-customer', compact('grid'));

    }
}

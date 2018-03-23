<?php

namespace App\Http\Controllers;

use App\Managers\AuthManager;
use App\Models\Agent;
use App\Models\Company;
use App\Models\CompanyPaymentMethod;
use App\Models\Customer;
use App\Models\CustomerServices;
use App\Models\LoginTypes;
use App\Models\Membership;
use App\Models\PromotionalCodes;
use App\Models\Role;
use App\Models\Settings;
use App\Models\Status;
use App\Models\User;
use App\Models\Task;
use Auth;
use Carbon\Carbon;
use DataGrid;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        if (Auth::check()) {

            $user = new User();
            if ($user->checkStatus(Auth::user()->id) === 0) {
                Auth::logout();
            }
        }
    }


    public function getIndex()
    {

        return redirect()->to('dashboard');


    }

    public function getApplegreen()
    {
        return view('applegreenmain');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getUsermanagement()
    {
        $grid = DataGrid::source((new User())->with('role'));
        $grid->add('id', 'ID', true)->style('width:100px');
        $grid->add('{{$first_name}} {{$last_name}}', 'Full name');

        $grid->add('username', 'Username');
        $grid->add('account_type', 'Type', 'account_type');

        $grid->add('status', 'Status', 'status');

        $grid->add('role.role_id', 'Role');
        $grid->edit(url('/user/edit/usermanagement'), 'Edit', 'show|modify|delete')->style('width:85px;');
        // $grid->link('/user/edit',"New", "TR");

        $grid->row(function ($row) {
            $row->style('cursor: pointer;');
            $row->cell('role.role_id')->value = Role::getRoleNameById($row->cell('role.role_id')->value);
            $row->cell('status')->value = Status::getById($row->cell('status')->value);
            $row->cell('account_type')->value = LoginTypes::getById($row->cell('account_type')->value);

        });
        $grid->orderBy('id', 'asc');
        $grid->paginate(10);

        return view('home.master.usermanagement', compact('grid'));

    }

    /**
     * @return mixed
     */
    public function getCompany()
    {

        $grid = DataGrid::source(Company::whereNotIn('id',[6,14])->with('company_poc'));
        $grid->add('id', 'ID')->style('display:none');
       $grid->add('status', 'status')->style('display:none');
        //$grid->add('code', 'Code');
        $grid->add('name', 'Name');
        $grid->add('website', 'Payment Method');
        $grid->add('address', 'Address');
        $grid->add('{{ $company_poc->name }}', 'Point of Contact');
        $grid->add('{{ $company_poc->email }}', 'Email');
        $grid->add('{{ $company_poc->phone_number }}', 'Phone Number');
        // $grid->add('{{ implode(", ", $memberships->lists("name")) }}','Memberships');
        // $grid->add('{{ $memberships->name }}','Memberships');

            $grid->add('actions','actions');



        $grid->edit(url('/user/edit/company'), 'Edit', 'show|modify|delete')->style('width:85px;');
        // $grid->link('/user/register/company',"New Company", "TR
        //");
        $grid->row(function ($row) {
            $payment_name = CompanyPaymentMethod::join('payment_methods','company_payment_method.payment_method_id','=','payment_methods.id')
                ->where('company_payment_method.company_id','=',$row->cell('id')->value)->pluck('name');

            $row->cell('website')->value = $payment_name;
            $row->style('cursor: pointer;');
            $row->cell('id')->style('display:none');
            $row->cell('status')->style('display:none');
            if((new AuthManager())->isAnyRole(['finance'])){
                $row->cell('actions')->value = link_to("reports/memberships-sold?search=1&company_id=".$row->cell('id')->value,"View Memberships");
            }else{
                $row->cell('actions')->value = link_to("user/force-login/".$row->cell('id')->value,"login").' or '
                                            .link_to("reports/memberships-sold?search=1&company_id=".$row->cell('id')->value,"View Memberships");
            }

            if($row->cell('status')->value == 0 ) {
                //$row->cell('actions')->style('display:none');
                $row->cell('actions')->value = link_to("company/activate/".$row->cell('id')->value,"Activate");
                $row->attributes(['class'=>'de-active','style'=>'cursor: pointer;']);
            }

        });
        $grid->orderBy('id', 'asc');
        $grid->paginate(10);


        return view('home.master.company',
            compact('grid'));
    }

    /**
     * @return mixed
     */
    public function getAgent()
    {

        $agents = Agent::with('type', 'user', 'company', 'role');
        /*      if (!$authManager->hasAccess(['master','finance'])) {*/
        $agents = $agents->where('company_id', '=', $this->getCompanyIDOrNull());
        $agents = $agents->whereNotIn('user_id', [186,3]);
        /*}*/

        $grid = DataGrid::source($agents->with('company'));
        //$grid->add('user.id', 'ID')->style('width:100px');
        $grid->add('{{$user->first_name}} {{$user->last_name}}', 'Full name');

        $grid->add('phone_number', 'Phone Number');
        $grid->add('user.email', 'Email');
        $grid->add('user.username', 'username');

        $grid->add('company.name', 'Company');
        $grid->add('role.role_id', 'Role');
        $grid->row(function ($row) {

            $row->cell('role.role_id')->value = Role::getRoleNameById($row->cell('role.role_id')->value);

        });
        // $grid->add('email','Email');
        // $grid->add('added_by','Added_by');

        $grid->edit(url('/user/edit/agent'), 'Edit', 'show|modify|delete')->style('width:85px;');
        // $grid->link('/user/register/company',"New Company", "TR");
        $grid->row(function ($row) {
            $row->style('cursor: pointer;');
        });
        $grid->orderBy('id', 'asc');
        $grid->paginate(10);


        return view('home.master.agent',
            compact('grid'));
    }

    /**
     * @return mixed
     */
    public function getMemberships()
    {
        $grid = DataGrid::source(new Membership());
        $grid->add('id', 'ID', true)->style('width:100px');
        $grid->add('membership_name', 'Name');
        $grid->add('price', 'Gross');
        $grid->add('vat','VAT');
        $grid->add('net','NET');
        $grid->add('duration', 'Duration');
        $grid->add('code', 'Code');
        $grid->add('number_of_callouts', 'Number of Callouts');

        $grid->edit(url('/user/edit/memberships'), 'Edit', 'show|modify|delete')->style('width:85px;');
        $grid->row(function ($row) {
            $row->style('cursor: pointer;');
            $row->cell('net')->value = round(($row->cell('price')->value * 100)/123,2);
            $row->cell('vat')->value = $row->cell('price')->value - $row->cell('net')->value;

        });
        // $grid->link('/user/register/company',"New Company", "TR");
        $grid->orderBy('id', 'asc');
        $grid->paginate(10);

        return view('home.master.memberships',
            compact('grid'));
    }
    /**
     * @return mixed
     */
    public function getPromotionalCodes()
    {


        $grid = DataGrid::source(new PromotionalCodes());
        $grid->add('id', 'ID', true)->style('width:100px');
        $grid->add('name', 'Name');
        $grid->add('code', 'code');
        $grid->add('discount', 'discount');
        $grid->add('date_start', 'date_start');
        $grid->add('date_end', 'date_end');
        $grid->add('uses_total', 'uses_total');
        $grid->add('uses_customer', 'uses_customer');
        $grid->add('date_added', 'date_added');

        $grid->edit(url('/user/edit/codes'), 'Edit', 'show|modify|delete')->style('width:85px;');
        $grid->row(function ($row) {
            $row->style('cursor: pointer;');
        });
        // $grid->link('/user/register/company',"New Company", "TR");
        $grid->orderBy('id', 'asc');
        $grid->paginate(10);

        return view('home.master.codes',
            compact('grid'));
    }

    /**
     * @return mixed
     */
    public function getSettings()
    {
        $grid = DataGrid::source(new Settings());
        // $grid->add('id','ID');
        $grid->add('item', 'Item');
        $grid->add('value', 'Value');

        $grid->edit(url('/user/edit/settings'), 'Edit', 'modify')->style('width:85px;');
        $grid->row(function ($row) {
            $row->style('cursor: pointer;');
        });
        // $grid->link('/user/register/company',"New Company", "TR");
        $grid->orderBy('id', 'asc');
        $grid->paginate(10);


        return view('home.master.settings',
            compact('grid'));
    }

    /**
     * @return mixed
     */
    public function getReports()
    {
        $c = new Customer();
        $number_of_new_memberships = $c->newMemberships();


        return view('home.master.reports',
            compact('number_of_new_memberships'));
    }

    /**
     * @return mixed
     */
    public function getNewMemberships()
    {
        $grid = DataGrid::source(Customer::with('membership')->where('start_date', '>',
            (time() - (7 * 24 * 60 * 60)))->where('completed', '=', 0));

        $grid->add('general_checkbox', '<input type="checkbox" id="general_checkbox_all" />');
        $grid->add('id', 'ID');
        $grid->add('start_date|date[m/d/Y]', 'Start Date');
        $grid->add('vehicle_registration', 'Vehicle Registration');
        $grid->add('membership.membership_name', 'Membership');
        $grid->add('membership_id', 'Membership ID');
        $grid->add('first_name', 'First Name');
        $grid->add('last_name', 'Last Name');
        $grid->add('have_nct', 'NCT');
        $grid->add('accept_terms', 'T&C');
        $grid->add('certificate', 'Certificate');
        $grid->add('welcome_pack', 'Welcome Pack');
        

        $grid->row(function ($row) {

            $row->cell('general_checkbox')->value = '<input type="checkbox" id="general_checkbox" member-id="' . $row->cell('id')->value . '" />';

            if ($row->cell('have_nct')->value == 1) {
                $row->cell('have_nct')->value = '<div style="text-align:center;"><i class="fa fa-check-circle fa-4x text-success"></i></div>';
            } else {
                $row->cell('have_nct')->value = '';
            }
            if ($row->cell('certificate')->value == 1) {
                $row->cell('certificate')->value = '<div style="text-align:center;"><i class="fa fa-check-circle fa-4x text-success"></i></div>';
            } else {
                $row->cell('certificate')->value = '';
            }

            if ($row->cell('welcome_pack')->value == 1) {
                $row->cell('welcome_pack')->value = '<div style="text-align:center;"><i class="fa fa-check-circle fa-4x text-success"></i></div>';
            } else {
                $row->cell('welcome_pack')->value = '';
            }
            if ($row->cell('accept_terms')->value == 1) {
                $row->cell('accept_terms')->value = '<div style="text-align:center;"><i class="fa fa-check-circle fa-4x text-success"></i></div>';
            } else {
                $row->cell('accept_terms')->value = '';
            }

            if (strtotime($row->cell('start_date')->value) < (time() - (24 * 60 * 60))) {
                $row->style('color:#FF0000');
            }
            
            $row->cell('start_date')->value =  date_format(date_create($row->cell('start_date')->value),'Y-m-d');

        });
       // $grid->edit(url('/user/edit/settings'), 'Edit', 'modify');
        $grid->orderBy('start_date', 'asc');
        $grid->paginate(10);

        return view('home.master.reports.newmemberships',
            compact('grid'));
    }

    public function getServices()
    {
        $services = CustomerServices::with(['services','customer']);
        $filter = \DataFilter::source($services);
        $filter->add('customer.vehicle_registration', 'Vehicle Registration', 'text');
        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();
        $grid = DataGrid::source($filter);
        $grid->add('customer.vehicle_registration', 'Vehicle Registration');
        $grid->add('{{$customer->first_name}} {{$customer->last_name}}', 'Customer Name');
        $grid->add('services.type', 'Service');
        $grid->add('created_at', 'Created at');
        $grid->edit(url('service/edit'), 'Edit','show');

        /*$grid->row(function ($row) {
            $row->style('cursor: pointer;');
        });*/

        $grid->paginate(20);

        return view('home.master.services_grid', compact('filter','grid'));
    }

    public function getServiceEdit()
    {
        $id = \Input::get('modify',\Input::get('show',\Input::get('update',null)));
        $member_service = CustomerServices::find($id);
        //Bringg order details fetching
        //Bringg main variables
        $access_token = "N9bc41LoQNBy4bNrRf71";
        $secret_key = "_yweM8d7N3QG7b5HWkTB";
        $company_id = 11133;
        $data_string = array(
            'access_token' => $access_token,
            'timestamp' => date('Y-m-d H:i:s'),
            'company_id' => $company_id
        );
        $signature = hash_hmac("sha1", http_build_query($data_string), $secret_key);
        $data_string["signature"] = $signature;
        $content = json_encode($data_string);
        $recovery_driver = 'N/A';
        $driver_notes = $member_service->note;
        $job_created_time = 'N/A';
        $started_at_time = 'N/A';
        $arrival_time = 'N/A';
        $attachments = [];
        $notes= [];

        if($member_service->bringg_id != null) {
            $url = 'https://developer-api.bringg.com/partner_api/tasks/'.$member_service->bringg_id;
            $ch=curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Content-Length: ' . strlen($content)));
            $json_response = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if($status == 200) {
                $bringg_order = json_decode($json_response, true);
                $order_notes = $bringg_order['task_notes'];
                foreach($order_notes as $note){
                    if($note['type']=='TaskNote' && $note['user_id']==null){
                        $driver_notes = $note['note'];
                    } elseif($note['type']=='TaskNote' && $note['user_id']!=null){
                        $note_time = new Carbon($note['created_at']);
                        $notes[] = ['by'=>$note['author_name'], 'note'=>$note['note'],
                            'time'=>$note_time->toDayDateTimeString()];
                    }
                    if($note['type']=='TaskPhoto' || $note['type']=='Signature'){
                        $attachments[] = ['by'=>$note['author_name'], 'url'=>$note['url'],
                            'type'=>$note['type']];
                    }
                }
                $started_at = new Carbon($bringg_order['started_time']);
                $started_at_time = $started_at->toDayDateTimeString();
                $created_at = new Carbon($bringg_order['created_at']);
                $job_created_time = $created_at->toDayDateTimeString();
                $customer_location = $bringg_order['way_points'][0];
                $arrival = new Carbon($customer_location['checkin_time']);
                $arrival_time = $arrival->toDayDateTimeString();
                //Get driver details
                if($bringg_order['user_id']!=null) {
                    $url = 'http://developer-api.bringg.com/partner_api/users/' . $bringg_order['user_id'];
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
                    curl_setopt($ch, CURLOPT_HTTPHEADER,
                        array('Content-Type:application/json',
                            'Content-Length: ' . strlen($content))
                    );
                    $json_response = curl_exec($ch);
                    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    if ($status == 200) {
                        $driver_details = json_decode($json_response, true);
                        $recovery_driver = $driver_details['name'];
                    }
                }
            }
        }

        $member_service->recovery_driver = $recovery_driver;
        $member_service->driver_notes = $driver_notes;
        $member_service->job_created_time = $job_created_time;
        $member_service->started_at_time = $started_at_time;
        $member_service->arrival_time = $arrival_time;
        $member_service->attachments = $attachments;
        $member_service->notes = $notes;

        /*$edit = \DataEdit::source($member_service)->attr('id', 'memberEditForm');
        $edit->add('customer.vehicle_registration', 'Vehicle Registration', 'text');
        $edit->add('customer.first_name', 'Customer Name', 'text');
        $edit->add('services.type', 'Service Type', 'text');
        $edit->add('client_company', 'Client Company', 'text');
        $edit->add('recovery_driver', 'Recovery Driver', 'text');
        $edit->add('note', 'Note', 'text');
        $edit->add('driver_notes', 'Driver\'s Note', 'text');
        $edit->add('vehicle_lat', 'Location Latitude', 'text');
        $edit->add('vehicle_lon', 'Location Longitude', 'text');
        $edit->add('vehicle_dest', 'Vehicle Destination', 'text');
        $edit->add('created_at', 'Created at', 'text');
        $edit->ignore_edit = true;*/
        return view('home.master.services_grid', ['member_service'=>$member_service]);
    }

    private function getCompanyIDOrNull()
    {
        $company_id = Agent::where('user_id', '=', Auth::user()->id)->pluck('company_id');

        return $company_id;

    }
}

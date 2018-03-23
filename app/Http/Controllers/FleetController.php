<?php namespace App\Http\Controllers;

use Activity;
use App\DataModels\CompanyDataModel;
use App\DataModels\MembershipDataModel;
use App\Enums\AccountTypes;
use App\Http\Requests\UserListImport;
use App\Managers\AuthManager;
use App\Managers\RegistrationManager;
use App\Models\Agent;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Fleet;
use App\Models\FleetMember;
use App\Models\Membership;
use App\Models\User;
use App\Models\Vehicle;
use Auth;
use Carbon\Carbon;
use Flash;
use Input;
use Illuminate\Http\Request;
use Redirect;
use Validator;
use DataFilter;
use DataGrid;
use DataEdit;
use Sentinel;
use Illuminate\Support\MessageBag;

class FleetController extends Controller
{

    public function index(){
        $fleets = new Fleet();
        $grid = DataGrid::source($fleets);
        $grid = $this->getFieldsForGrid($grid);
        $grid->orderBy('id', 'asc');
        $grid->paginate(20);
        return view('home.master.fleet', compact('grid'));
    }

    public function getMembers(){
        $authManager = new AuthManager();
        $customers = Customer::with('vehicle', 'membership', 'adder', 'company', 'user','fleetMember')
            ->where('type','=','fleet');
        //dd($customers->orderBy('id','DESC')->first()->fleetMember->fleet_id);
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
            $range = intval($range->value) * (24 * 60 * 60);
            $customers = $customers->whereRaw('(UNIX_TIMESTAMP(`expiration_date`)-'.$range.') < '.time());
        }
        if (!$authManager->isAnyRole(['master', 'finance', 'sales'])) {
            $customers = $customers->where('company_id', '=', $this->getCompanyIDOrNull());
        }
        if (Input::get('start_date') != "") {
            $start_date_filter = Input::get('start_date');
            Input::merge(['start_date' => '']);
            $customers = $customers->where(\DB::raw('DATE_FORMAT(start_date,"%Y-%m-01")'), '=', $start_date_filter);
        }
        if (Input::get('fleetMember_fleet_id') != "") {
            $customers = $customers->whereHas('fleetMember', function($q)
            {
                $q->where('fleet_id', '=', Input::get('fleetMember_fleet_id'));
            });
            Input::merge(['fleetMember_fleet_id' => '']);
        }
        $customers->orderBy('id', 'DESC');
        $filter = DataFilter::source($customers);

        $filter->add('customer.membership', 'membership',
            'select')->options(['' => 'membership'] + Membership::lists("membership_name", "id"));

        $filter->add('company_id', 'Company ID',
            'select')->options(['' => 'Company'] + Company::orderBy('name')->lists("name", "id"));
        $filter->add('fleetMember.fleet_id', 'Fleet', 'select')
            ->options(['' => 'Fleet'] + Fleet::orderBy('name')->lists("name", "id"));
        $filter->add('vehicle_registration', 'Vehicle Registration', 'text');
        $filter->add('vehicle_registration', 'Vehicle Registration', 'text');
        //$filter->add('expiration_date', 'Date ranges', 'daterange')->format('m  /Y', 'en');
        $dates = Customer::where('type','=','fleet')->groupBy(\DB::raw('Year(start_date),Month(start_date)'))
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
//dd($filter);
        $grid = DataGrid::source($filter);

        if (Input::get('submit', 'search') === 'download_excel' || Input::get('submit', 'search') === 'download_csv') {

            $grid = $this->getFieldsForDownload($grid);
        } else {

            $grid = $this->getFieldsForMembersGrid($grid);
        }
        if (Input::get('submit', 'search') === 'download_csv') {
            return $grid->buildCSV('MemberShips', 'Y-m-d.His', true, ['delimiter' => ',']);
        }
        if (Input::get('submit', 'search') === 'download_excel') {
            return $grid->buildExcel('MemberShips', 'Y-m-d.His', true);
        }
        if (!Input::get('source') == 'archived') {
            $grid->link(url('fleet/members?source=archived'), "Deleted Records", "TR",
                array('class' => 'btn btn-info'));
        }
        // $grid->link('/user/register/company',"New Company", "TR");
        $grid->orderBy('id', 'asc');

        $grid->paginate(20);

        return view('home.master.fleet_members', compact('filter', 'grid'));
    }

    public function getFleet(){
        $companies = Company::all();
        $memberships = Membership::all();
        $fleets = null;
        $fleet = null;
        $fleet_company = null;
        $fleet_membership = null;
        $fleet_id = Input::get('modify');
        if($fleet_id != null){
            $fleet = Fleet::find($fleet_id);
            $fleet_company = Company::find($fleet->company_id);
            $fleet_membership = Membership::find($fleet->membership_id);
        }
        $update = Input::get('update');
        if($update != null){
            $fleets = Fleet::all();
        }
        return view('memberships.fleet',['companies'=>$companies,'fleet'=>$fleet,'fleets'=>$fleets,
            'fleet_company'=>$fleet_company,'fleet_membership'=>$fleet_membership,'memberships'=>$memberships]);
    }

    public function postFleet(Request $request, UserListImport $importer){
        $fleet_array = $importer->get()->toArray();
        //dd($fleet_array);
        $missing_flag = 0;
        $missing_entries = [];
        $fleet = null;
        $start_date = Carbon::now();
        $expiry_date = Carbon::now()->addYear();
        if($request->has('fleet_id')) {
            $fleet = Fleet::find($request->fleet_id);
            $start_date = Carbon::now()->addDays(2);
            $sd = Carbon::now()->addDays(2);
            $the_membership = Membership::find($fleet->membership_id);
            $membership_duration = explode(' ',$the_membership->duration)[0];
            $expiry_date = $sd->addMonths($membership_duration)->toDateString();
        }
        $create_a_membership = 0;
        $membership_id = $request->has('fleet_id')? $fleet->membership_id : $request->membership_type;
        $company_id = $request->has('fleet_id')? $fleet->company_id : $request->company;
        $fleet_name = $request->has('fleet_id')? $fleet->name : $request->fleet_name;
        $membership_start_date = $request->has('fleet_id')? $start_date : $request->start_date;
        $membership_expiration = $request->has('fleet_id')? $expiry_date : $request->membership_expiration;
        $operation = 'created';
        if($membership_id == 'create_membership'){
            $membership_id = $this->addMembership(['membership_name'=>$request->membership_name,
                'price'=>$request->price, 'duration'=>$request->duration,
                'code'=>$request->membership_code,'number_of_callouts'=>$request->number_of_callouts]);
            $md = new Carbon($membership_start_date);
            $membership_expiration = $md->addMonths($request->duration)->toDateString();
            $create_a_membership = 1;
        }
        if($request->has('fleet_id')){
            $operation = 'updated';
        } else {
            $fleet = new Fleet();
            $fleet->company_id = $request->company;
            $fleet->membership_id = $membership_id;
        }
        $fleet->name = $fleet_name;
        $fleet->save();

        $fleet_name = explode(' ',$fleet_name);
        $first_name = $fleet_name[0];
        $last_name = isset($fleet_name[1])? $fleet_name[1] : ' ';
//dd($request);
        //$company_id = $this->getCompanyIDOrNull();
        if($company_id == 'create_company'){
            $company_memberships = $request->memberships;
            if($create_a_membership == 1){
                $company_memberships[] = $membership_id;
            }
            $company_request = Request::create(url('fleet'),'POST',['code'=>$request->code,
                'company_name'=>$request->company_name, 'website'=>$request->website,
                'address'=>$request->address, 'memberships'=>$company_memberships,
                'payment_method'=>$request->payment_method, 'username'=>$request->username,
                'poc_name'=>$request->poc_name, 'poc_email'=>$request->poc_email,
                'poc_number'=>$request->poc_number]);
            $company_id = $this->addCompany($company_request);
            if($company_id instanceof MessageBag){
                return redirect()->back()->withErrors($company_id);
            }
        }
        $company = Company::find($company_id);
        if(!$company){
            return redirect()->back()->withErrors('This company wasn\'t found in the system');
        }
        $company_poc = $company->company_poc;
        $address_line = $company->address;
        $phone_number = $company_poc->phone_number;
        $user_name = explode(' ',$company_poc->name);
        $user_first_name = $user_name[0];
        $user_last_name = isset($user_name[1])? $user_name[1] : ' ';
        $user = User::where('email','=',$company_poc->email)->first();
        if($user == null) {
            $credentials = [
                'email' => $company_poc->email,
                'password' => 'P@$$w0rd',
                'first_name' => $user_first_name,
                'last_name' => $user_last_name,
                'username' => $company_poc->email,
                'account_type' => AccountTypes::customer
            ];
            $user = $this->createUser($credentials, 10);
            if (!$user) {
                return redirect()->back->withErrors('There was a problem while creating the main user account');
            }
        }
        foreach($fleet_array as $fleet_member){
            /*if (($validation_message_bag = $this->validatemember($fleet_member)) !== true) {
                return redirect()->back()->withErrors($validation_message_bag)->withInput();
            }*/
            /*if(isset($fleet_member['name'])){
                $the_name = explode(' ',$fleet_member['name']);
                $first_name = $the_name[0];
                $last_name = $the_name[1];
            }*/
            if(isset($fleet_member['first_name'])){
                $first_name = $fleet_member['first_name'];
                $last_name = ' ';
            }
            if(isset($fleet_member['last_name'])){
                $last_name = $fleet_member['last_name'];
            }
            if(isset($fleet_member['start_date'])){
                $membership_start_date = $fleet_member['start_date'];
                $membership_duration = $request->membership_duration;
                $date = new Carbon($membership_start_date);
                $membership_expiration = $date->addMonths($membership_duration)->toDateString();
            }
            if(isset($fleet_member['email'])){
                $user = User::where('email','=',$fleet_member['email'])->first();
                if($user == null) {
                    $credentials = [
                        'email' => $fleet_member['email'],
                        'password' => 'P@$$w0rd',
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'username' => $fleet_member['email'],
                        'account_type' => AccountTypes::customer
                    ];
                    $user = $this->createUser($credentials, 10);
                    if (!$user) {
                        return redirect()->back->withErrors('There was a problem while creating the main user account');
                    }
                }
            }
            $email = $user->email;
            if(isset($fleet_member['address'])){
                $address_line = $fleet_member['address'];
            }
            if(isset($fleet_member['home_phone_no'])){
                $phone_number = $fleet_member['home_phone_no'];
            }
            if(isset($fleet_member['mobile_phone_no'])){
                $phone_number = $fleet_member['mobile_phone_no'];
            }
            $fleet_member = Request::create(url('fleet'),'POST',$fleet_member);
            $fleet_member->request->add([
                'first_name'=>$first_name,
                'last_name'=>$last_name,
                'address_line_1'=>$address_line,
                'email'=>$email,
                'phone_number'=>$phone_number,
                'membership_type'=>$membership_id,
                'start_date'=>$membership_start_date,
                'membership_expiration'=>$membership_expiration
            ]);
            $fleet_member->vehicle_registration = str_replace(' ', '', $fleet_member->vehicle_registration);
            $status = $this->addFleetMember($fleet_member,$fleet->id,$company_id,$user);
            if($status == 0){
                $missing_flag = 1;
                $missing_entries[] = $fleet_member->vehicle_registration;
            }
        }
        $message = "The fleet \"{$fleet->name}\" was {$operation} successfully";
        if($missing_flag == 1){
            $message .= "<br/> BUT <br/> There was an error retrieving vehicle info for
                the following vehicle registrations and thus weren\'t added:
                <br/> <ul>";
            foreach($missing_entries as $entry){
                $message.="<li>{$entry}</li>";
            }
            $message.='</ul>';
        }
        Flash::success($message);
        return redirect()->back();
    }

    public function addFleetMember($member,$fleet_id,$company_id,$user) {
        $vms_resp = $this->getVehicle($member->vehicle_registration);
        //$vehicle = ['make'=>'Lada','model'=>'1992','fuel'=>'85','transmission'=>'manual','colour'=>'black'];
        //dd($vehicle);
        libxml_use_internal_errors(true);
        $xml = @simplexml_load_string($vms_resp);
        if($xml!==FALSE && $xml!=null) {
            if ($xml->error_code === '10') {
                return redirect()->back()->withErrors('No data available from VMS for vehicle registration ' . $member->vehicle_registration);
            } else {
                if ($xml->error_code === '100' || $xml->error_code === '101' || $xml->error_code === '102' || $xml->error_code === '103' || $xml->error_code === '104' || $xml->error_code === '105')
                    return 0;
            }
        } else {
            if(!isset($vms_resp['vehicle'])){
                return 0;
            } else {
                $vehicle = $vms_resp['vehicle'];
                $member->request->add([
                    'make' => isset($vehicle['make']) ? $vehicle['make'] : '-',
                    'model' => isset($vehicle['model']) ? $vehicle['model'] : '-',
                    'version' => isset($vehicle['version']) ? $vehicle['version'] : '-',
                    'engineSize' => isset($vehicle['engineSize']) ? $vehicle['engineSize'] : '-',
                    'fuel' => isset($vehicle['fuel']) ? $vehicle['fuel'] : '-',
                    'transmission' => isset($vehicle['transmission']) ? $vehicle['transmission'] : '-',
                    'colour' => isset($vehicle['colour']) ? $vehicle['colour'] : '-',
                    'odometer_type' => 'k',
                    'odometer_reading' => '0'
                ]);
            }
        }

        $membership_data_model = new MembershipDataModel($member,
            ['company_id' => $company_id, 'added_by' => Auth::user()->id]);

        /*$can_bypass_payment = false;
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
        }*/


        $registration_manager = new RegistrationManager();
        $fleet_user_id = $registration_manager->createMembership($membership_data_model,true,true,true,$user,'fleet');

        if (!$fleet_user_id) {

            Flash::error('Registration failed. The user has missing data.');

            return redirect()->back()->withInput();
        }

        Activity::addMember($membership_data_model->user_id,
            "Fleet member registered with vehicle reg :  {$membership_data_model->vehicle_registration}");
        /*if ($can_bypass_payment) {
            Activity::pyPassedPayment($membership_data_model->user_id,
                "bypassed Payment for the user with username :  {$membership_data_model->username}");

        } else {
            Activity::paymentCompleted($membership_data_model->user_id, json_encode($payment_return));
        }
        if ($can_bypass_notification) {
            Activity::pyPassedNotification($membership_data_model->user_id,
                "bypassed notification for the user with username :  {$membership_data_model->username}");
        }*/

        //Flash::success("{$membership_data_model->first_name} was added successfully");

        //return redirect()->back();

        $fleet_member = new FleetMember();
        $fleet_member->fleet_id = $fleet_id;
        $fleet_member->member_id = $fleet_user_id;
        $fleet_member->save();

        return $fleet_member->id;
    }

    public function getDeleteFleet($id){
        $fleet = Fleet::find($id);
        return view('home.master.fleet_delete',['fleet'=>$fleet]);
    }

    public function postDeleteFleet($id){
        $fleet = Fleet::find($id);
        if(!$fleet){
            return redirect()->back()->withErrors('No Fleet found with this id');
        }
        $fleet_members = FleetMember::where('fleet_id','=',$id)->lists('member_id','id');
        //dd($fleet_members);
        foreach($fleet_members as $the_id=>$member_id){
            $customer = Customer::find($member_id);
            if($customer) {
                Vehicle::destroy($customer->vehicle->id);
                Customer::destroy($member_id);
            }
            FleetMember::destroy($the_id);
        }
        Fleet::destroy($id);
        Flash::success('Customers & Fleet deleted successfully');
        return redirect()->back();
    }

    private function validateMember($member){

        $validator = Validator::make($member, [
            'vehicle_registration' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }

    private function getCompanyIDOrNull(){
        $company_id = Agent::where('user_id', '=', Auth::user()->id)->pluck('company_id');

        return $company_id;
    }

    private function getVehicle($reg = null){
        if ($reg == null) {
            return ['status' => false];
        }

        $url = "https://www.vms.ie/api/valuationlookup/$reg?user=311solution&key=di-7jo21rt2589&output=json";

        /*$curl = curl_init();
        curl_setopt_array($curl, array(
            //CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER => 'Content-type: application/json',
            CURLOPT_URL => $url,
            //CURLOPT_POST => 1,
        ));*/

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($ch);
        curl_close($ch);

        $resp = json_decode(trim($resp), TRUE);

        return $resp;
    }

    private function createUser($credentials, $role_id = 10){
        try {
            $user = Sentinel::registerAndActivate($credentials);
            unset($credentials['email'], $credentials['password']);
            foreach ($credentials as $key => $attribute) {
                $user->{$key} = $attribute;
            }
            $user->save();
            $this->addRoleToUser($user, $role_id);
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }
        return $user;
    }
    private function addRoleToUser($user, $role_id){
        $role = Sentinel::findRoleById($role_id);
        $role->users()->attach($user);

        return true;
    }

    public function getMemberShipsAvailableForCompany(){
        $company_id = Input::get('company_id');
        $membership_repository = new Membership();
        //$company_id = $this->getCompanyIDOrNull();
        if($company_id=='6'){
            $memberships = $membership_repository->getMemberships();
        } else {
            $memberships = $membership_repository->getCompanyMemberships($company_id);
        }
        return $memberships;
    }

    private function getFieldsForGrid(\Zofe\Rapyd\DataGrid\DataGrid $grid){
        $grid->add('id', 'ID')->style('display:none');
        $grid->add('name', 'Fleet Name');
        $grid->add('actions','View');
        if($this->auth_manager->hasAccess(['members.edit'])){
            $grid->edit(url('/fleet/add'), 'Update', ('|modify'))->style('width:60px;');
            $grid->add('dlt','Delete');
        }
        $grid->row(function ($row) {
            $row->cell('id')->style('display:none');
            $row->cell('actions')->value = link_to("fleet/members?fleetMember_fleet_id=".$row->cell('id')->value,"View members");
            if($this->auth_manager->hasAccess(['members.edit'])) {
                $row->cell('dlt')->value = link_to("fleet/delete/" . $row->cell('id')->value, "Delete");
            }
            $row->style('cursor: pointer;');
        });
        return $grid;
    }

    private function getFieldsForMembersGrid(\Zofe\Rapyd\DataGrid\DataGrid $grid){
        $grid->add('vehicle_registration', 'Vehicle Registration');
        $grid->add('phone_number', 'Phone Number');
        $grid->add('membership.membership_name', 'Membership');
        //$grid->add('membership_id', 'Membership ID');
        //$grid->add('title', 'Title');
        $grid->add('fleetMember.fleet.name', 'Fleet Name');
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

    private function getFieldsForDownload(\Zofe\Rapyd\DataGrid\DataGrid $grid){
        //Form Name
        //Submission Date
        //$grid->add('membership_id', 'CarTow Membership ID', true);
        $grid->add('vehicle_registration', 'Vehicle Registration');
        $grid->add('company.name', 'Company Name');
        $grid->add('membership.membership_name', 'Membership Type', 'text');
        $grid->add('start_date|date[m/d/Y]', 'Start date');
        $grid->add('expiration_date|date[m/d/Y]', 'End date');
        //Agent Full Name
        $grid->add('{{$first_name}} {{$last_name}}', 'Full Name');
        $grid->add('email', 'E-mail');
        $grid->add('address_line_1', 'Address');
        $grid->add('phone_number', 'Phone Number');
        //Preffered next of kin Phone Number
        //Odometer Reading
        //Odometer Type
        //Tax renewal date (optional for friendly reminders)
        //NCT renewal date (optional for friendly reminders)
        //Receipt of member payment received by agent
        //  	Verification
        //Receipt of member payment received by agent
        //$grid->add('title', 'Title');
        //$grid->add('adder.username', 'Agent Full Name');
        $grid->add('status', 'Status');
        $grid->add('number_of_assists', 'Number of Assists');
        $grid->row(function ($row) {
            /*if ($row->cell('adder.username')->value === '{{$adder->username}}') {
                $row->cell('adder.username')->value = 'Online';
            }
            if ($row->cell('company.name')->value === '{{$company->name}}') {
                $row->cell('company.name')->value = '-';
            }*/
            if (strtotime($row->cell('expiration_date')->value) < time()) {
                $row->style('color:#FF0000');
                $row->cell('status')->value = 'Expired';
            } else {
                $row->cell('status')->value = 'Active';
            }
        });
        return $grid;
    }

    private function addCompany(Request $request)
    {
        if (($validation_message_bag = $this->validateCompanyData()) !== true) {
            return $validation_message_bag;
        }
        $company_data_model = new CompanyDataModel($request);
        $company_manager = new RegistrationManager();
        $response = $company_manager->createCompany($company_data_model);
        //Flash::success("A company account for {$company_data_model->company_name} was created successfully");
        return $response['account_id'];
    }
    private function validateCompanyData()
    {
        $validator = Validator::make(Input::all(), [
            'code' => 'required',
            'company_name' => 'required',
            'memberships' => 'required',
            'payment_method' => 'required',
            'username' => 'required|unique:users',
            'poc_name' => 'required',
            'poc_email'=> 'required|email|unique:users,email'
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        return true;
    }

    private function addMembership($data) {
        $name = $data['membership_name'];
        $price = $data['price'];
        $duration = $data['duration'];
        $code = $data['code'];
        $number_of_callouts = $data['number_of_callouts'];
        if (($validation_message_bag = $this->validateMembershipData($data)) !== true) {
            return redirect()->back()->withErrors($validation_message_bag)->withInput();
        }
        $membership = new Membership();
        $membership->membership_name = $name;
        $membership->price = $price;
        $membership->duration = $duration;
        $membership->code = $code;
        $membership->number_of_callouts = $number_of_callouts;
        $membership->save();
        //$response = $membership->register($name, $price, $duration, $code, $number_of_callouts);
        /*if ($response) {
            Flash::success('Membership has been added successfully');
        }*/
        return $membership->id;
    }
    private function validateMembershipData($data)
    {
        $validator = Validator::make($data, [
            'membership_name' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'code' => 'required'
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        return true;
    }
}
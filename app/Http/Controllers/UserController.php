<?php

namespace App\Http\Controllers;

use App\DataModels\AgentDataModel;
use App\DataModels\CouponDataModel;
use App\Enums\AccountTypes;
use App\Http\Requests\CreateAgentRequest;
use App\Managers\ActivityManager;
use App\Managers\AuthManager;
use App\Managers\RegistrationManager;
use App\Models\Agent;
use App\Models\Applegreencode;
use App\Models\ClientCompany;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Master;
use App\Models\Membership;
use App\Models\Notification;
use App\Models\PromotionalCodes;
use App\Models\ServiceTypes;
use App\Models\Settings;
use App\Models\Status;
use App\Models\Subuser;
use App\Models\Toll;
use App\Models\User;
use App\Models\CustomerServices;
use Auth;
use Carbon\Carbon;
use Sentinel;
use Exception;
use Flash;
use DB;
use Input;
use Redirect;
use Session;
use Stripe;
use DataEdit;
use ZipArchive;
use Validator;
use DataGrid;
use GuzzleHttp\Client as GuzzleClient;

class UserController extends Controller
{


    public function __construct()
    {
        Controller::__construct();
        $this->middleware('auth', ['except' => ['getVehicle','getCheckCouponCode']]);
    }

    public function getRegister($registration)
    {

        $type = $this->getAccountTypeName();

        switch ($registration) {

            case 'master':

                $roles = DB::table('roles')->get(['id', 'slug', 'name']);

                return view('auth.register', array(
                    'registration' => $registration,
                    'roles' => $roles,
                    'logged_in' => $type
                ));
                break;


            case 'memberships':

                return view('auth.register.memberships', array(
                    'logged_in' => $type
                ));
                break;
            case 'codes':

                return view('auth.register', array(
                    'registration' => $registration,
                    'logged_in' => $type
                ));
                break;
        }

    }

    // public function

    public function postRegister($registration)
    {
        $response = array('error' => '', 'message' => '');
        switch ($registration) {

            case 'master':
                $username = Input::get('username');
                $email = Input::get('email');
                $password = Input::get('password');
                $password_confirmation = Input::get('password_confirmation');
                $first_name = Input::get('first_name');
                $last_name = Input::get('last_name');
                $role = Input::get('role');
                $credentials = [
                    'email' => $email,
                    'password' => $password,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'username' => $username,
                    'type' => AccountTypes::master
                ];
                try {
                    $user = Sentinel::registerAndActivate($credentials);
                } catch (Exception $e) {
                    Flash::error('Registration failed. The email provided has already been registered in the system, please provide a new email address.');

                    return redirect()->back()->withInput();
                }

                $role = Sentinel::findRoleById($role);
                $role->users()->attach($user);
                $response = array('error' => 0, 'message' => 'User created Successfully ');
                break;


            case 'memberships':
                $name = Input::get('membership_name');
                $price = Input::get('price');
                $duration = Input::get('duration');
                $code = Input::get('code');
                $number_of_callouts = Input::get('number_of_callouts');
                if (($validation_message_bag = $this->validateMembershipsForm()) !== true) {
                    return redirect()->back()->withErrors($validation_message_bag)->withInput();
                }
                
                $membership = new Membership();

                $response = $membership->register($name, $price, $duration, $code, $number_of_callouts);
                if ($response) {
                    Flash::success('Membership has been added successfully');
                }

                break;
            case 'codes':
                $coupon_data_model = new CouponDataModel();


                $membership = new PromotionalCodes();

                $response = $membership->register($coupon_data_model);
                if ($response) {
                    Flash::success('Promotional Code has been added successfully');
                }


                break;

        }

        if (array_key_exists('error', $response) && $response['error'] === 1) {
            return Redirect::back()->with('errors', $response['message']);
        }
       
        return Redirect::back();

    }
    
    private function validateMembershipsForm()
    {
        $validator = Validator::make(Input::all(), [
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

    public function getApplegreencheck($applegreen_code)
    {

        $a = new Applegreencode();
        $check = $a->checkApplgreencode($applegreen_code);

        return $check;

    }

    /*	public function postApplegreenform() {

    $m = new Membership();
    $memberships = $m->getMembership(5);

    $applegreen_code = Input::get('applegreen_code');
    $registration_id = Input::get('registration_id');

    $a = new Applegreencode();
    $check = $a->checkApplgreencode($applegreen_code);

    if($check['error'] === 0) {
    // return view('applegreen',array('memberships'=>$memberships));
    return view('applegreen',array('error_message'=>'','code'=>$applegreen_code,'valid'=>true,'memberships'=>$memberships, 'registration_id' => $registration_id));
    } else {
    if($check['error'] === 1)
    return view('applegreen',array('error_message'=>$check['message'],'code'=>$applegreen_code,'valid'=>false,'memberships'=>array(), 'registration_id' => 0));
    }

    }*/


    public function getVehicle($reg = null, $reading = null, $type = null)
    {
        if ($reg == null) {
            return ['status' => false];
        }
        $url = '';
        if (!empty($reading)) {
            $url = "https://www.vms.ie/api/valuationlookup/$reg/$reading/$type?user=311solution&key=di-7jo21rt2589&output=json";
        } else {
            $url = "https://www.vms.ie/api/valuationlookup/$reg?user=311solution&key=di-7jo21rt2589&output=json";
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            // CURLOPT_SSL_VERIFYPEER => false,
            // CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_RETURNTRANSFER => 1,
            // CURLOPT_HEADER => 'Content-type: application/json',
            CURLOPT_URL => $url,
            // CURLOPT_POST => 1,
        ));

        $resp = curl_exec($curl);

        curl_close($curl);

        return $resp;
        /*header('Content-type: application/json');
        echo json_encode($resp);*/
        // return $resp_array;

    }

    public function getCheckCouponCode($code = null)
    {
        if ($code == null) {
            return ['status' => false];
        }

        $code = PromotionalCodes::where('code', '=', $code)->where('date_end', '>', date('Y-m-d'))->where('date_start',
            '<=', date('Y-m-d'))->first();
        if ($code) {
            $code->status = true;

            return $code;
        }

        return ['status' => false];
        /*header('Content-type: application/json');
        echo json_encode($resp);*/
        // return $resp_array;

    }

    public function anyEdit($tab)
    {
        $edit = array();
        switch ($tab) {
            case 'memberships':
                $membership_id = (Input::get('modify')) ? Input::get('modify') : (Input::get('show')) ? Input::get('show') : null;
                // if (Input::get('do_delete')==1) return  "not the first";
                $edit = DataEdit::source(new Membership())->attr('id', 'membershipEditForm');
                // $edit->label('Edit Membership');
                // $edit->link("rapyd-demo/filter","Articles", "TR")->back();
                $edit->add('membership_name', 'Name<span class="orange-header">*</span>', 'text')->rule('required');
                $edit->add('price', 'Gross Price<span class="orange-header">*</span>', 'text')->rule('required');
                $edit->add('duration', 'Duration<span class="orange-header">*</span>', 'text')->rule('required');
                $edit->add('code', 'Code<span class="orange-header">*</span>', 'text')->rule('required');
                if($membership_id != NULL)
                    $edit->link(url("user/edit/memberships?delete=$membership_id"), 'DELETE', 'TR', 
                    ['class' => 'btn btn-danger']);
                // $edit->add('body','Body', 'redactor');
                /*
                          $edit->add('detail.note','Note', 'textarea')->attributes(array('rows'=>2));
                          $edit->add('detail.note_tags','Note tags', 'text');
                          $edit->add('author_id','Author','select')->options(Author::lists("firstname", "id"));
                          $edit->add('publication_date','Date','date')->format('d/m/Y', 'it');
                          $edit->add('photo','Photo', 'image')->move('uploads/demo/')->fit(240, 160)->preview(120,80);
                          $edit->add('public','Public','checkbox');
                          $edit->add('categories.name','Categories','tags');
                */


                break;
            case 'codes':

                $edit = DataEdit::source(new PromotionalCodes());


                $edit->add('name', 'Name', 'text');
                $edit->add('code', 'Code', 'text');
                $edit->add('discount', 'Discount', 'text');
                $edit->add('date_start', 'Start Date', 'date')->format('d/m/Y', 'it')->attr('type','date');
                $edit->add('date_end', 'End Date', 'date');
                $edit->add('uses_total', 'Usage Limit', 'text');
                $edit->add('uses_customer', 'Customers Limit', 'text');
                $edit->add('date_added', 'Added At', 'date')->mode('readonly');


                break;


            case 'usermanagement':

                $delete_id = Input::get('do_delete');
                if (!empty($delete_id)) {
                    $u = new User();
                    $user = $u->getTypeId($delete_id);
                    switch ($user['account_type']) {
                        case 1:
                            $m = new Master();
                            $response = $m->deleteMasterAccount($delete_id);

                            if ($response['error'] === 1) {
                                return "Couldn't delete user";
                            }

                            break;

                        case 2:
                            $s = new Subuser();
                            $response = $s->deleteSubuserAccount($delete_id);

                            if ($response['error'] === 1) {
                                return "Couldn't delete user";
                            }

                            break;

                        case 3:
                            $c = new Company();
                            $response = $c->deleteCompanyAccount($delete_id);

                            if ($response['error'] === 1) {
                                return "Couldn't delete user";
                            }

                            break;

                        case 4:
                            $a = new Agent();
                            $response = $a->deleteAgentAccount($delete_id);

                            if ($response['error'] === 1) {
                                return "Couldn't delete user";
                            }

                            break;

                    }

                }

                $edit = DataEdit::source(new User());
                $edit->add('username', 'Username', 'text');
                $edit->add('first_name', 'First name', 'text');
                $edit->add('last_name', 'Last name', 'text');
                // $edit->add('type.type', 'Type', 'select')->options(LoginTypes::lists("type", "id"));
                $edit->add('status.status', 'Status', 'select')->options(Status::lists('status', 'id'));

                break;


            case 'agent':
                $agent_id = Input::get('modify',Input::get('show',Input::get('update',Input::get('delete',null))));
                $delete_id = Input::get('do_delete');
                $check_do_delete = Input::get('do_delete',null);
                if (!empty($delete_id)) {
                    $u = new User();
                    $response = $u->deleteUserAccount($delete_id, 4);

                    if ($response['error'] === 1) {
                        return "Couldn't delete user";
                    }

                }
                $agent = Agent::find($agent_id);
                $edit = DataEdit::source(new Agent())->attr('id', 'agentEditForm');
                if($agent != NULL) {
                    $edit->add('user.first_name', 'First Name', 'text');
                    $edit->add('user.last_name', 'Last Name', 'text');
                    $edit->add('phone_number', 'Phone Number', 'text');
                    $edit->add('user.email', 'Email<span class="orange-header">*</span>', 'text')
                        ->rule('unique:users,email,'.$agent->user_id);
                    $edit->add('company.name', 'Company', 'text');
                // $edit->add('code','Code', 'text');
                    $check_delete = Input::get('delete',null);
                    if($check_delete == NULL) {
                        $edit->link(url("user/edit/agent?delete=$agent_id"), 'DELETE', 'TR', 
                        ['class' => 'btn btn-danger']);
                    }
                }
                if($check_do_delete != NULL){
                    $edit->link(url("home/agent"), 'Back to table', 'TR', 
                    ['class' => 'btn btn-primary']);
                }
                break;
            case 'customer':

                //case show or modify
                $customer_id = Input::get('modify',Input::get('show',Input::get('update',null)));
                if(!$customer_id){
                    Flash::warning('You can\'t access this url without a valid member id  ');
                    return Redirect::back();
                }
                $customer = Customer::find($customer_id);

                $edit = DataEdit::source(new Customer())->attr('id', 'memberEditForm');

                $edit->link(url("/user/services/$customer_id"), 'Add Service', 'TR');
                if ($this->auth_manager->hasAccess(['members.delete'])) {

                    $edit->link(url("customer/archive/$customer_id"), 'Delete', 'TR',
                        ['class' => 'btn btn-danger']);
                }
                //enable renew membership button if membership has expired
                $date_diff = $customer->expiration_date->diff(new \Carbon\Carbon());
                if($date_diff->invert == 0){
                    $edit->link(url("customer/renew-membership?customer_id=".$customer_id."&membership_id=".$customer->membership),
                        'Renew Membership', 'TR',['class' => 'btn btn-primary']);
                }

                $edit->add('membership_id', 'Membership ID', 'text');
                $edit->add('start_date', 'Membership Start Date','date',['required'=>'required'])->format('Y-m-d','it');

                //case update customer
                if(Input::get('update'))
                {
                    $membership_for_user = Membership::withTrashed()->find($customer->membership);

                    if($membership_for_user){
                        $membership_duration = $membership_for_user->duration;
                        $durationSplit = explode(' ',$membership_duration);
                        $number_of_months = $durationSplit[0];
                        $start_date = Input::get('start_date');
                        $expirationDate = date('Y-m-d', strtotime("+$number_of_months months", strtotime($start_date)));
                        $edit->add('expiration_date', 'Membership End Date', 'date')->format('Y-m-d','en')->updateValue($expirationDate);
                    }


                }
                $edit->add('number_of_assists', 'Call Outs', 'text');
                $edit->add('title', 'Title', 'text');
                $edit->add('first_name', 'First Name<span class="orange-header">*</span>', 'text')->rule('required');
                $edit->add('company.name', 'Company','text');
                $edit->add('adder.username', 'Added By','text');
                $edit->add('last_name', 'Last Name<span class="orange-header">*</span>', 'text')->rule('required');
                $edit->add('user.email', 'Email<span class="orange-header">*</span>', 'text')->rule('required|unique:users,email,'.$customer->user_id);
                $edit->add('address_line_1', 'Address Line 1<span class="orange-header">*</span>', 'text')->rule('required');
                $edit->add('address_line_2', 'Address Line 2', 'text');
                $edit->add('town', 'Town', 'text');
                $edit->add('county', 'County<span class="orange-header">*</span>', 'text')->rule('required');
                $edit->add('postal_code', 'Postal Code', 'text');
                $edit->add('phone_number', 'Phone Number<span class="orange-header">*</span>', 'text')->rule('required');
                $edit->add('nok_phone_number', 'Next of Kin', 'text');


                $edit->add('vehicle_registration', 'Vehicle ID<span class="orange-header">*</span>', 'text')->rule('required');
                $edit->add('vehicle.make', 'Make<span class="orange-header">*</span>', 'text')->rule('required');
                $edit->add('vehicle.model', 'Model<span class="orange-header">*</span>', 'text')->rule('required');
                $edit->add('vehicle.version_type', 'Version Type', 'text');
                $edit->add('vehicle.engine_size', 'Engine Size', 'text');
                $edit->add('vehicle.fuel_type', 'Fuel Type<span class="orange-header">*</span>', 'text')->rule('required');
                $edit->add('vehicle.transmission', 'Transmission', 'text');
                $edit->add('vehicle.colour', 'Colour<span class="orange-header">*</span>', 'text')->rule('required');
                if (!$this->auth_manager->hasAccess(['members.edit'])) {

                    $edit->ignore_edit = true;
                }


                // $edit->add('code','Code', 'text');

                break;

            case 'settings':

                $edit = DataEdit::source(new Settings());

                $edit->add('value', 'Value', 'text');
                // $edit->add('code','Code', 'text');

                break;

        }

        return $edit->view("home.master.$tab", compact('edit'));
    }

    /*	public function getAutogenerate($password) {
    if($password === 'sherifa216') {
    $c = new Customer();
    $c->autogenerate_codes();
    }
    }*/


    public function getServices($customer_id)
    {
        $customer = Customer::find($customer_id);
        if(!$customer){
            return redirect()->back()->withErrors(['No user was found with this ID']);
        }
        $logged_in = Auth::user()->account_type;
        $user_id = Auth::user()->id;

        $n = new Notification();
        $notifications = $n->getNotifications($user_id);
        $unread = $n->getUnreadNotifications($user_id);
        $unread = intval($unread);

        $current_customer_services = CustomerServices::with('services')
                ->where('customer_id','=',$customer_id);
        $grid = DataGrid::source($current_customer_services);
        $grid->add('id', 'ID')->style('width:50px');
        $grid->add('services.type','Service');
        $grid->add('note','Note');
        $grid->add('created_at','Created at');

        $customer_type = $customer->type;
        $flag_28_days = CustomerServices::where('customer_id','=',$customer_id)
                ->whereRaw('created_at > DATE_SUB(now(),INTERVAL 28 DAY)')->count() > 0;
        $flag_exceed_requests = $customer->number_of_assists >= 3;
        $flag_expired_membership = Customer::where('id','=',$customer_id)
                ->get(array(DB::raw('datediff(expiration_date,now()) as expiry')))
                ->first()->expiry < 0;
        
        switch ($logged_in) {
            case 1:
                $logged_in = 'master';
                break;

            case 2:
                $logged_in = 'subuser';
                break;

            case 3:
                $logged_in = 'company';
                break;

            case 4:
                $logged_in = 'agent';
                break;

            case 5:
                $logged_in = 'customer';
                break;
        }

        $service_types = ServiceTypes::getTypes();
        $vehicle_reg = $customer->vehicle_registration;

        $max_distance = \App\Models\Settings::find(3);
        $max_distance = $max_distance->value;
        $extra_mileage_tax = \App\Models\Settings::find(4);
        $extra_mileage_tax = $extra_mileage_tax->value;

        $client_companies = ClientCompany::all();
        $tolls = Toll::with('theTax')->get();

        return view("home.master.services", compact('service_types', 'notifications', 'unread',
            'customer_id', 'grid', 'flag_28_days', 'flag_exceed_requests', 'client_companies',
            'flag_expired_membership', 'customer_type', 'vehicle_reg', 'max_distance',
            'extra_mileage_tax', 'tolls'));
    }

    public function postAddservice()
    {
        $user = Auth::user();
        $customer_id = Input::get('customer_id');
        $service_id = Input::get('service_id');
        $note = Input::get('note');
        $client_company = explode('-',Input::get('client_company'));
        $company_name = $client_company[0];
        $company_tag = (int)$client_company[1];
        $address = Input::get('address');
        $latitude = Input::get('lat');
        $longitude = Input::get('lon');
        //$destination_latitude = Input::get('dest_lat');
        //$destination_longitude = Input::get('dest_lon');
        $destination = Input::get('vehicle_destination');
        //$time_stamp = new Carbon(Input::get('time_stamp'));
        $time_stamp = new Carbon('now');
        $eta_span = \App\Models\Settings::find(2);
        $eta = $time_stamp->addMinutes((int)$eta_span->value)->format('h:i A');
        $service = ServiceTypes::find($service_id);
        $service_name = $service->type;
        $cs = Customer::find($customer_id);
        $customer_name = $cs->title . ' ' . $cs->first_name . ' ' . $cs->last_name;
        $customer_phone = $cs->phone_number;
        if(Input::get('member_name')!=null){
            $customer_name = Input::get('member_name');
        }
        if(Input::get('member_phone')!=null){
            $customer_phone = Input::get('member_phone');
        }
        //vehicle details
        $make = Input::get('make');
        $model = Input::get('model');
        $version = Input::get('version');
        $engine_size = Input::get('engine-size');
        $fuel = Input::get('fuel');
        $transmission = Input::get('transmission');
        $colour = Input::get('colour');

        //Bringg main variables
        $access_token = "N9bc41LoQNBy4bNrRf71";
        $secret_key = "_yweM8d7N3QG7b5HWkTB";
        $company_id = 11133;

        //Bringg get customer by phone
        $customer_bringg_id = null;
        $url = 'http://developer-api.bringg.com/partner_api/customers/phone/'.$customer_phone;
        $data_string = array('access_token' => $access_token,'timestamp' => date('Y-m-d H:i:s'),'company_id' => $company_id);
        $signature = hash_hmac("sha1", http_build_query($data_string), $secret_key);
        $data_string["signature"] = $signature;
        $content = json_encode($data_string);
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type:application/json','Content-Length: '.strlen($content)));
        $json_response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ( $status == 200 ) {
            $response = json_decode($json_response, true);
            $customer_bringg_id = $response['customer']['id'];
        }

        //Bringg customer creation if not available
        if($customer_bringg_id == null) {
            $url = 'http://developer-api.bringg.com/partner_api/customers';
            $data_string = array('access_token' => $access_token, 'timestamp' => date('Y-m-d H:i:s'),
                'name' => $customer_name, 'company_id' => $company_id,
                'email' => $cs->email, 'phone' => $cs->phone_number, 'address' => $cs->address_line_1);
            $signature = hash_hmac("sha1", http_build_query($data_string), $secret_key);
            $data_string["signature"] = $signature;
            $content = json_encode($data_string);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Content-Length: ' . strlen($content)));
            $json_response = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($status != 200) {
                return redirect()->back()->withErrors(['There was an error during creating a customer entry on Bringg servers, please try again later']);
            }
            curl_close($ch);
            $response = json_decode($json_response, true);
            $customer_bringg_id = $response['customer']['id'];
        }

        //Bringg Task creation
        $full_note = '';
        //$formatted_note = [['Note','Value']];
        if($note != ''){
            $full_note .= $note.'. ';
            //$formatted_note[] = ['HQ note',$note];
        }
        $full_note .= 'ETA: '.$eta.'. Vehicle Reg: '.$cs->vehicle_registration.
            '. Vehicle details; Make: '.$make.', Model: '.$model.', Version: '.$version
            .', Colour: '.$colour.', Engine size: '.$engine_size.', Fuel: '.$fuel.
            ', Transmission: '.$transmission.'.';
        $service_title = "$cs->vehicle_registration - $service_name - ETA: $eta";
        /*$formatted_note[] = ['Vehicle Reg',$cs->vehicle_registration];
        $formatted_note[] = ['Make',$make];
        $formatted_note[] = ['Model',$model];
        $formatted_note[] = ['Version',$version];
        $formatted_note[] = ['Colour',$colour];
        $formatted_note[] = ['Engine size',$engine_size];
        $formatted_note[] = ['Fuel',$fuel];
        $formatted_note[] = ['Transmission',$transmission];*/

        $customer_bringg_id_second = $customer_bringg_id;
        if($service_name == 'Re-delivery'){
            $customer_bringg_id_second = '4646986';
        }

        if($destination != ''){
            $full_note.='. Customer\'s destination: '.$destination;
            //Multiple way points
            $url = 'https://developer-api.bringg.com/partner_api/tasks/create_with_way_points';
            $data_string = array(
                'access_token' => $access_token,
                'timestamp' => date('Y-m-d H:i:s'),
                'company_id' => $company_id,
                'customer_id' => $customer_bringg_id,
                'title' => $service_title,
                'team_id' => 10991,
                'asap' => 1,
                'note' => $full_note,
                'tag_id' => $company_tag,
                'way_points' => json_encode(array(
                    array(
                        'customer_id' => $customer_bringg_id,
                        'address' => $address,
                        'lat' => $latitude,
                        'lng' => $longitude,
                        'note' => $full_note,
                        'formatted_note' => '',
                    ),
                    array(
                        'customer_id' => $customer_bringg_id_second,
                        'address' => $destination,
                        'silent' => 1,
                        /*'lat' => $destination_latitude,
                        'lng' => $destination_longitude,*/
                    )
                ))
            );
        } else {
            //Single way point
            $url = 'http://developer-api.bringg.com/partner_api/tasks';
            $data_string = array(
                'access_token' => $access_token,
                'timestamp' => date('Y-m-d H:i:s'),
                'company_id' => $company_id,
                'customer_id' => $customer_bringg_id,
                'title' => $service_title,
                'team_id' => 10991,
                'asap' => 1,
                'address' => $address,
                'lat' => $latitude,
                'lng' => $longitude,
                'note' => $full_note,
                'formatted_note' => '',
                'tag_id' => $company_tag
            );
        }

        $signature = hash_hmac("sha1", http_build_query($data_string), $secret_key);
        $data_string["signature"] = $signature;
        $content = json_encode($data_string);

        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type:application/json',
                'Content-Length: ' . strlen($content))
        );
        $json_response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ( $status != 200 ) {
            die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($ch) . ", curl_errno " . curl_errno($ch));
        }
        curl_close($ch);
        $response = json_decode($json_response, true);
        $bringg_task_id = $response['task']['id'];
        //Bringg task creation end

        $service = new ServiceTypes();
        $response = $service->addService($customer_id, $service_id, $bringg_task_id,$company_name, $note,
            $address, $latitude, $longitude, $destination, $user);

        if ($response['error'] !== 0) {
            return redirect()->back()->withErrors(['There was an error during processing, please try again later']);
        }
        return Redirect::to("user/edit/customer?show=$customer_id");
    }

    public function getVehicleids()
    {
        $c = new Customer();
        $vehicle_ids = $c->getVehicleIDs();

        return json_encode($vehicle_ids);
    }

    public function postCertificatedone()
    {

        $members_ids = Input::get('members_ids');
        $c = new Customer();

        foreach ($members_ids as $member_id) {

            $c->certificateDone($member_id);

        }

    }
    
    
    public function postWelcomepacksent()
    {

        $members_ids = Input::get('members_ids');
        $c = new Customer();

        foreach ($members_ids as $member_id) {

            $c->welcomePackSent($member_id);

        }

    }

    public function postMemberscompleted()
    {

        $members_ids = Input::get('members_ids');
        $c = new Customer();
        $members_failedCompletion=[];
        foreach ($members_ids as $member_id) {
            if($c->checkMemberCompleted($member_id)){
                $c->memberCompleted($member_id);
            }else{
               $members_failedCompletion[]= $member_id;
            }           

        }
        if(is_array($members_failedCompletion) && !empty($members_failedCompletion)){
            return \Response::json(array('status'=>'fail','failedMembers'=>$members_failedCompletion));
        }  else {
            return \Response::json(array('status'=>'success'));
        }
        
    }

    public function postCertificate()
    {

//        $members_ids = json_decode(Input::get('members_ids'),true);
        $members_ids = Input::get('members_ids');

        $c = new Customer();
        $img_array = array();
        $zip = new ZipArchive();
        $temp = tempnam(public_path('uploads/certificates/'), 'cert_');

        if ($zip->open($temp, ZipArchive::CREATE) !== true) {
            exit("cannot open <$temp>\n");
        }

        foreach ($members_ids as $member_id) {

            $member = $c->getInfo($member_id);
            if (!is_array($member)) {
                return false;
            }
            $name = $member['first_name'] . ' ' . $member['last_name'];
            $membership_number = $member['membership_id'];
            $membership_grade = $member['membership_name'];
            $vehicle_registration_number = $member['vehicle_registration'];
            $expiry_date = $member['expiration_date'];


            // Create Image From Existing FiregisterAgentle
            $jpg_image = imagecreatefromjpeg(public_path('certificate-img.jpg'));

            // Allocate A Color For The Text
            $black = imagecolorallocate($jpg_image, 0, 0, 0);

            // Set Path to Font File
            $font_path_bold = public_path('arialbd.ttf');
            $font_path = public_path('arial.ttf');

            // Print Text On Image
            imagettftext($jpg_image, 50, 0, 840, 1615, $black, $font_path_bold, $name); ///// Member Name
            imagettftext($jpg_image, 30, 0, 834, 1890, $black, $font_path, $membership_number);
            imagettftext($jpg_image, 30, 0, 834, 2055, $black, $font_path, $membership_grade);
            imagettftext($jpg_image, 30, 0, 834, 2230, $black, $font_path, $vehicle_registration_number);
            imagettftext($jpg_image, 30, 0, 834, 2397, $black, $font_path, $expiry_date);

            imagettftext($jpg_image, 20, 0, 557, 3050, $black, $font_path_bold, $name); ///// Member Name
            imagettftext($jpg_image, 20, 0, 675, 3135, $black, $font_path_bold, $vehicle_registration_number);
            imagettftext($jpg_image, 20, 0, 675, 3225, $black, $font_path_bold, $membership_number);
            imagettftext($jpg_image, 20, 0, 555, 3310, $black, $font_path_bold, $expiry_date);

            ob_start();

            // save Image to disk
            imagejpeg($jpg_image, public_path("uploads/certificates/$member_id.jpg"));
            $zip->addFile(public_path("uploads/certificates/$member_id.jpg"), "$member_id-$name.jpg");


            $img_array[$member_id] =  asset("uploads/certificates/$member_id.jpg");;

            // Clear Memory
            imagedestroy($jpg_image);

            ob_end_clean();
        }


        $zip->close();

        return ["zip" =>  asset('uploads'.explode('uploads',$temp)[1])];

        return $img_array;

        return response()->download($temp, 'name.zip');
    }

    /**
     * @return mixed|string
     */
    private function getAccountTypeName()
    {
        $type = '';
        if (Auth::check()) {
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

        return $type;
    }

    public function getRegisterAgent()
    {
        $roles = DB::table('roles');
        if (!$this->auth_manager->isAnyRole(['master', 'finance'])) {
            $roles = $roles->whereIn('slug', ['company_agent', 'company_master']);
        }
        else {
            $roles = $roles->whereIn('slug', ['master', 'sales', 'finance','customer_service']);
        }
        $roles = $roles->get(['id', 'slug', 'name']);

        return view('auth.register.agent', array(
            'roles' => $roles
        ));

    }

    public function postRegisterAgent(CreateAgentRequest $request)
    {

        $request->merge(['account_type' => AccountTypes::agent]);
        $request->merge(['company_id' => $this->getCompanyIDOrNull()]);

        $agent_data_model = new AgentDataModel($request);
        $registration_manager = new RegistrationManager();

        $agent = $registration_manager->createAgent($agent_data_model);
        if ($agent) {
            Flash::success('Registration Success and an email was sent to the Agent  ');
        } else {
            Flash::error('Registration failed. The email provided has already been registered in the system, please provide a new email address.');
        }

        return Redirect::back();


    }


    private function getCompanyIDOrNull()
    {
        $company_id = Agent::where('user_id', '=', Auth::user()->id)->pluck('company_id');

        return $company_id;

    }

    public function getForceLogin($id)
    {
        $user_to_login = User::join('agent_accounts', function ($join) use ($id) {
            $join->on('agent_accounts.user_id', '=', 'users.id');
            $join->on('agent_accounts.company_id', '=', DB::raw($id));
        })->join('role_users', function ($join) {
            $join->on('role_users.user_id', '=', 'users.id');
            $join->on('role_users.role_id', 'in', DB::raw('(9,1)'));
        })
            ->first(['users.id']);
        if (!$user_to_login) {
            /*  $company = Company::find($id);
              $company->delete();*/
            Flash::error('This Company have no associated agents');

            return Redirect::back();

        }
        /**
         * releasing the memory
         */
        $id = $user_to_login->id;
        $user_to_login = null;

        $current_user = Auth::user();
        if(!$current_user) {
            Flash::error('No user is logged in');
            return redirect('/');
        }

        if (Auth::loginUsingId($id)) {
            $user_data = Auth::user();
            try {
                $user = Sentinel::findById($user_data->id);
                Sentinel::login($user);
            } catch (\Exception $e) {
                \App::abort(500);
            }
            Session::put('force_login_switch_me_back', $current_user->id);
            (new ActivityManager())->userLogin($user_data->id, "Force Login by {$current_user->username}");

            return redirect()->intended('dashboard');
        }

        return redirect()->back();
    }

    public function getForceLoginBack()
    {
        $id = Session::get('force_login_switch_me_back');
        Session::forget('force_login_switch_me_back');
        if(!$id){
            return redirect()->back();
        }
        $current_user = Auth::user();

        if (Auth::loginUsingId($id)) {
            $user_data = Auth::user();


            try {
                $user = Sentinel::findById($user_data->id);

                $sentinel_user = Sentinel::loginAndRemember($user);
            } catch (\Exception $e) {
                $user = Sentinel::findById($user_data->id);

                $sentinel_user = Sentinel::loginAndRemember($user);
            }

            (new ActivityManager())->userLogin($user_data->id, "Force Login by {$current_user->username}");

            return redirect()->intended('dashboard');
        }

        return redirect()->back();
    }
}
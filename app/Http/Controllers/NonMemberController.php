<?php namespace App\Http\Controllers;

use Activity;
use App\Managers\AuthManager;
use App\Models\ClientCompany;
use App\Models\NonMemberService;
use App\Models\Notification;
use App\Models\ServiceComment;
use App\Models\ServiceQuote;
use App\Models\ServiceTypes;
use App\Models\Task;
use App\Models\Toll;
use App\Models\Settings;
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

class NonMemberController extends Controller
{
    public function getNonMemberService()
    {
        $user_id = Auth::user()->id;
        $auth_manager = new AuthManager();
        $user_type = 'normal';
        if($auth_manager->isRole('service_company')){
            $user_type = 'service_company';
        }
        $n = new Notification();
        $notifications = $n->getNotifications($user_id);
        $unread = $n->getUnreadNotifications($user_id);
        $unread = intval($unread);

        $service_types = ServiceTypes::getTypes();

        $max_distance = Settings::find(3);
        $max_distance = $max_distance->value;
        $extra_mileage_tax = Settings::find(4);
        $extra_mileage_tax = $extra_mileage_tax->value;

        $client_companies = ClientCompany::all();
        $tolls = Toll::with('theTax')->get();

        return view("home.master.standalone_services", compact('service_types', 'notifications', 'unread',
            'grid','user_type','max_distance','extra_mileage_tax','client_companies','tolls'));
    }

    public function postNonMemberService()
    {
        //dd(Input::all());
        $user = Auth::user();
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
        $to_pay = Input::get('to_pay');
        $override_reason = Input::get('override_reason');
        $eta_setting = Input::get('eta_setting');
        //$time_stamp = new Carbon(Input::get('time_stamp'));
        $time_stamp = new Carbon('now');
        if($eta_setting != '' && $eta_setting != null){
            $eta_setting_values = explode('-',$eta_setting);
            $eta_span = $eta_setting_values[0];
            $assigned_span = $eta_setting_values[1];
            $due_stamp = Carbon::now()->addMinutes((int)$eta_span)->toDateTimeString();
            $assigned_stamp = Carbon::now()->addMinutes((int)$assigned_span)->toDateTimeString();
            $eta = $time_stamp->addMinutes((int)$eta_span)->format('h:i A');
        } else {
            $eta_span = Settings::find(2);
            $assigned_span = Settings::where('code','=','assigned-status-kpi')->first();
            $due_stamp = Carbon::now()->addMinutes((int)$eta_span->value)->toDateTimeString();
            $assigned_stamp = Carbon::now()->addMinutes((int)$assigned_span->value)->toDateTimeString();
            $eta = $time_stamp->addMinutes((int)$eta_span->value)->format('h:i A');
        }
        $full_note = '';
        if($note != ''){
            $full_note .= $note.'. ';
        }
        $service_title = '';
        //$eta = $time_stamp->addMinutes((int)$eta_span->value)->format('h:i A');
        //Bringg main variables
        $access_token = "N9bc41LoQNBy4bNrRf71";
        $secret_key = "_yweM8d7N3QG7b5HWkTB";
        $company_id = 11133;
        if($service_id != 'CarTow.ie HQ order'){
            $service = ServiceTypes::find($service_id);
            $service_name = $service->type;
            $customer_name = Input::get('customer_name');
            $customer_phone = Input::get('customer_phone');
            $vehicle_reg = Input::get('vehicle_reg');

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
                    'name' => $customer_name, 'company_id' => $company_id, 'phone' => $customer_phone);
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
            $full_note .= 'ETA: '.$eta.'. Vehicle Reg: '.$vehicle_reg.'.';
            $service_title = "$vehicle_reg - $service_name - ETA: $eta";
            $make = Input::get('make');
            $model = Input::get('model');
            $version = Input::get('version');
            $engine_size = Input::get('engine-size');
            $fuel = Input::get('fuel');
            $transmission = Input::get('transmission');
            $colour = Input::get('colour');
            $full_note .= 'Vehicle details; Make: '.$make.', Model: '.$model.', Version: '.$version
                .', Colour: '.$colour.', Engine size: '.$engine_size.', Fuel: '.$fuel.
                ', Transmission: '.$transmission.'.';
        } else {
            $customer_bringg_id = '1692255';
            $service_name = $service_id;
            $customer_name = 'CarTow.ie';
            $customer_phone = '';
            $service_title = "$service_name";
            $vehicle_reg = 'N/A';
        }
        $customer_bringg_id_second = $customer_bringg_id;
        if($service_name == 'Re-delivery'){
            $customer_bringg_id_second = '4646986';
        }
        $quote_flag = 0;
        //Bringg Task creation
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
            $quote_flag = 1;
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

        $service = new NonMemberService();
        $response = $service->addNonMemberService($bringg_task_id, $vehicle_reg,
            $customer_name, $customer_phone, $service_id, $company_name, $note,
            $address, $latitude, $longitude, $destination, $user, $to_pay,
            $override_reason, 'open', $due_stamp, $assigned_stamp);

        if ($response['error'] !== 0) {
            return redirect()->back()->withErrors(['There was an error during processing, please try again later']);
        }

        if($quote_flag == 1) {
            $service_quote = new ServiceQuote();
            $service_quote->service_id = $response['id'];
            $service_quote->service_type = 'non member';
            $service_quote->total_distance = Input::get('total_distance');
            $service_quote->extra_distance = Input::get('extra_distance');
            $service_quote->extra_distance_tax = Input::get('extra_distance_tax');
            $service_quote->tolls = Input::get('tolls');
            $service_quote->total = Input::get('quote-total');
            $service_quote->save();
        }

        Flash::success('Service added successfully');
        return Redirect::back();
    }

    public function nonMemberServiceIndex()
    {
        //$authManager = new AuthManager();
        $non_member_services = new NonMemberService;
        $non_member_services = $non_member_services->orderBy('id', 'DESC');
        $filter = DataFilter::source($non_member_services);
        $filter->add('vehicle_reg', 'Vehicle Registration', 'text');
        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();
        $grid = DataGrid::source($filter);
        $grid = $this->getFieldsForNonMemberServiceGrid($grid);
        //$grid->orderBy('id', 'asc');

        $grid->paginate(20);

        return view('home.master.nonmember_services', compact('filter','grid'));
    }

    public function nonMemberService()
    {
        $id = Input::get('modify',Input::get('show',Input::get('update',null)));
        $non_member_service = NonMemberService::find($id);
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
        $driver_notes = $non_member_service->note;
        $job_created_time = 'N/A';
        $started_at_time = 'N/A';
        $arrival_time = 'N/A';
        $attachments = [];
        $notes = [];
        $location = 'N/A';
        $destination = 'N/A';

        if($non_member_service->bringg_id != null) {
            $url = 'https://developer-api.bringg.com/partner_api/tasks/'.$non_member_service->bringg_id;
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
                $created_at = new Carbon($bringg_order['created_at']);
                //$job_created_time = $created_at->toDayDateTimeString();
                $job_created_time = $created_at->format('D, M j, Y H:i');
                $order_due = new Carbon($non_member_service->due_time);
                $due_time = $order_due->format('D, M j, Y H:i');
                if($bringg_order['status'] != 0 && $bringg_order['status'] != 1) {
                    $started_at = new Carbon($bringg_order['started_time']);
                    //$started_at_time = $started_at->toDayDateTimeString();
                    $started_at_time = $started_at->format('D, M j, Y H:i');
                    $customer_location = $bringg_order['way_points'][0];
                    $arrival = new Carbon($customer_location['checkin_time']);
                    //$arrival_time = $arrival->toDayDateTimeString();
                    $arrival_time = $arrival->format('D, M j, Y H:i');
                }
                $service_way_points = $bringg_order['way_points'];
                $location = ($service_way_points[0]['address']!=null)? $service_way_points[0]['address'] : 'N/A';
                $destination = (count($service_way_points)==2)? $service_way_points[1]['address'] : 'N/A';
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

        $non_member_service->recovery_driver = $recovery_driver;
        $non_member_service->driver_notes = $driver_notes;
        $non_member_service->job_created_time = $job_created_time;
        $non_member_service->started_at_time = $started_at_time;
        $non_member_service->arrival_time = $arrival_time;
        $non_member_service->attachments = $attachments;
        $non_member_service->notes = $notes;
        $non_member_service->cc_comments = $non_member_service->comments()->where('service_type','=','non member')->get()->toArray();
        $non_member_service->quote = $non_member_service->the_quote()->where('service_type','=','non member')->first();
        $non_member_service->location = $location;
        $non_member_service->destination = $destination;
        $non_member_service->due_time = $due_time;
        /*$edit = DataEdit::source(new NonMemberService())->attr('id', 'memberEditForm');
        $edit->add('vehicle_reg', 'Vehicle Registration', 'text');
        $edit->add('customer_name', 'Customer Name', 'text');
        $edit->add('service.type', 'Service Type', 'text');
        $edit->add('client_company', 'Client Company', 'text');
        $edit->add('note', 'Note', 'text');
        $edit->add('vehicle_lat', 'Location Latitude', 'text');
        $edit->add('vehicle_lon', 'Location Longitude', 'text');
        $edit->add('vehicle_dest', 'Vehicle Destination', 'text');
        $edit->add('created_at', 'Created at', 'text');
        $edit->ignore_edit = true;*/
        return view('home.master.nonmember_services', ['non_member_service'=>$non_member_service]);
    }

    public function getTaskAdd()
    {
        $edit = DataEdit::source(new Task())->attr('id', 'taskEditForm');
        $edit->add('account_name', 'Account Name<span class="orange-header">*</span>', 'select')->options(['Northside Dublin,10991'=>'Northside Dublin','Default Team,10989'=>'Default Team'])->rule('required');
        $edit->add('tag_name', 'Tag Name', 'text');
        $edit->add('vehicle_reg', 'Vehicle Reg<span class="orange-header">*</span>', 'text')->rule('required');
        $edit->add('driver_details', 'Driver Details<span class="orange-header">*</span>', 'text')->rule('required');
        $edit->add('address', 'Address', 'text');
        $edit->add('dest_lat', 'Destination Latitude<span class="orange-header">*</span>', 'text')->rule('required');
        $edit->add('dest_lon', 'Destination Longitude<span class="orange-header">*</span>', 'text')->rule('required');
        $edit->add('ram', 'RAM', 'text');
        $edit->add('fault', 'Fault<span class="orange-header">*</span>', 'text')->rule('required');
        $edit->add('notes', 'Notes', 'text');
        return view('home.master.task',['edit'=>$edit,'status'=>'add']);
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postTaskAdd(Request $request)
    {

        if (($validation_message_bag = $this->validateForm()) !== true) {
            return redirect()->back()->withErrors($validation_message_bag)->withInput();
        }

        $task = new Task();
        $task->fill($request->all());
        $task->save();
        //Activity::addMember($membership_data_model->user_id,
        //    "registered member with username :  {$membership_data_model->username}");

        Flash::success("Task was added successfully");

        return redirect()->back();
    }

    private function validateForm()
    {

        $validator = Validator::make(Input::all(), [

            'account_name' => 'required',
            'vehicle_reg' => 'required',
            'driver_details' => 'required',
            'dest_lan' => 'required',
            'dest_lon' => 'required',
            'fault' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }

    private function getFieldsForNonMemberServiceGrid(\Zofe\Rapyd\DataGrid\DataGrid $grid)
    {

        $grid->add('vehicle_reg', 'Vehicle Registration');
        //$grid->add('membership.membership_name', 'Membership');
        //$grid->add('membership_id', 'Membership ID');
        //$grid->add('title', 'Title');
        $grid->add('customer_name', 'Customer Name');
        $grid->add('customer_phone', 'Phone Number');
        //$grid->add('user.email', 'Email');
        $grid->add('created_at|date[m/d/Y]', 'Created at');
        $grid->edit(url('/nonmember/edit/service'), 'Edit', 'show')->style('width:60px;');
        /*$grid->row(function ($row) {
            $row->style('cursor: pointer;');
        });*/

        return $grid;
    }

    public function postComment(){
        $current_user = Auth::user();
        if(!$current_user)
            return redirect()->back()->withErrors('No user is currently logged in');
        $data = Input::all();
        $comment = new ServiceComment();
        $comment->service_id = $data['service_id'];
        $comment->service_type = 'non member';
        $comment->added_by = $current_user->first_name.' '.$current_user->last_name;
        $comment->comment = $data['comment'];
        $comment->save();
        return redirect()->back()->with('message','Comment added successfully');
    }

    public function completeService($id){
        $service = NonMemberService::find($id);
        if(!$service){
            return redirect()->back()->withErrors(['No service was found with this ID']);
        }
        $current_user = Auth::user();
        $service->status = 'complete';
        $service->completed_by = $current_user->first_name.' '.$current_user->last_name;
        $service->save();
        return redirect()->to('services/open')->with('message','Service status changed to complete');
    }

    public function addEta(){
        $data = Input::all();
        $non_member_service = NonMemberService::find($data['id']);
        if(!$non_member_service){
            return redirect()->back()->withErrors(['No service was found with this ID']);
        }
        $current_due = new Carbon($non_member_service->due_time);
        $current_due->addMinutes($data['extra_eta']);
        $non_member_service->due_time = $current_due->toDateTimeString();
        $non_member_service->save();
        return redirect()->back()->with('message','ETA added successfully');
    }

    public function getAttachments($id){
        $non_member_service = NonMemberService::find($id);
        if(!$non_member_service){
            return redirect()->back()->withErrors(['No service was found with this ID']);
        }
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
        $attachments = [];
        if($non_member_service->bringg_id != null) {
            $url = 'https://developer-api.bringg.com/partner_api/tasks/'.$non_member_service->bringg_id;
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
                    if($note['type']=='TaskPhoto' || $note['type']=='Signature'){
                        $attachments[] = ['by'=>$note['author_name'], 'url'=>$note['url'],
                            'type'=>$note['type']];
                    }
                }
            }
        }
        return view('home.master.nonmember_service_attachments',
            ['attachments'=>$attachments, 'non_member_service_id'=>$non_member_service->id]);
    }
}
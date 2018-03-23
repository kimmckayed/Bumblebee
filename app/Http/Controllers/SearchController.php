<?php namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerServices;
use App\Models\NonMemberService;
use Carbon\Carbon;
use DataGrid;

class SearchController extends Controller
{
    public function getCustomerSearch(){
        return view('search.customer');
    }

    public function getCustomerByVehicleReg($vehicle_reg) {
        $customer = Customer::with(['vehicle','company'])
            ->where('vehicle_registration','=',$vehicle_reg)->first();

        return json_encode($customer);
    }

    public function getServicesSearch(){
        return view('search.services');
    }

    public function servicesByVehicleReg() {
        $vehicle_reg = \Input::get('vehicle_reg');
        $services = CustomerServices::with(['services','customer'])
            ->whereHas('customer', function ($query) use ($vehicle_reg) {
            $query->where('vehicle_registration', '=', $vehicle_reg);
        });
        $nonmember_services = NonMemberService::with(['service'])
            ->where('vehicle_reg', '=', $vehicle_reg)->get();
        //->get()->toArray();
        //dd($services);
        /*$grid = DataGrid::source($services);
        $grid->add('id', 'ID')->style('width:50px');
        $grid->add('{{$customer->first_name}} {{$customer->last_name}}','Name');
        $grid->add('customer.vehicle_registration','Vehicle registration');
        $grid->add('services.type','Service');
        $grid->add('note','Note');
        $grid->add('{{$vehicle_address}} ({{$vehicle_lat}},{{$vehicle_lon}})','Location');
        $grid->add('vehicle_dest','Destination');
        $grid->add('created_at','Created at');*/

        $services = $services->get();
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
        foreach($services as $service){
            $recovery_driver = 'N/A';
            $driver_notes = $service->note;
            $job_created_time = 'N/A';
            $started_at_time = 'N/A';
            $arrival_time = 'N/A';
            $attachments = [];
            $notes = [];

            if($service->bringg_id != null) {
                $url = 'https://developer-api.bringg.com/partner_api/tasks/'.$service->bringg_id;
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
                    $url = 'http://developer-api.bringg.com/partner_api/users/'.$bringg_order['user_id'];
                    $ch=curl_init();
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
                    if ($status== 200) {
                        $driver_details = json_decode($json_response, true);
                        $recovery_driver = $driver_details['name'];
                    }
                }
            }

            $service->recovery_driver = $recovery_driver;
            $service->driver_notes = $driver_notes;
            $service->job_created_time = $job_created_time;
            $service->started_at_time = $started_at_time;
            $service->arrival_time = $arrival_time;
            $service->attachments = $attachments;
            $service->notes = $notes;
        }
        foreach($nonmember_services as $service){
            $recovery_driver = 'N/A';
            $driver_notes = $service->note;
            $job_created_time = 'N/A';
            $started_at_time = 'N/A';
            $arrival_time = 'N/A';
            $attachments = [];
            $notes = [];

            if($service->bringg_id != null) {
                $url = 'https://developer-api.bringg.com/partner_api/tasks/'.$service->bringg_id;
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

            $service->recovery_driver = $recovery_driver;
            $service->driver_notes = $driver_notes;
            $service->job_created_time = $job_created_time;
            $service->started_at_time = $started_at_time;
            $service->arrival_time = $arrival_time;
            $service->attachments = $attachments;
            $service->notes = $notes;
        }
        return view('search.services',['grid'=>null, 'services'=>$services,
            'nonmember_services'=>$nonmember_services]);
    }

    public function currentOpenServices(){
        //Bringg variables
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
        //Current open tasks from Bringg
        $grid_services = [];
        $local_tasks_ids = [];
        $eta_setting = \App\Models\Settings::find(2);
        $assigned_status_kpi = \App\Models\Settings::where('code','=','assigned-status-kpi')->first();
        $url = 'https://developer-api.bringg.com/partner_api/tasks/open';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Content-Length: ' . strlen($content)));
        $json_response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($status == 200) {
            $open_services = json_decode($json_response);
            foreach($open_services as $bringg_service) {
                $id = null;
                $cartow_rep = 'N/A';
                $note_flag = 0;
                $local_task = NonMemberService::where('bringg_id','=',$bringg_service->id)->first();
                if($local_task) {
                    $id = $local_task->id;
                    $local_tasks_ids[] = $local_task->id;
                    $cartow_rep = $local_task->added_by;
                    if($local_task->comments()->count() > 0) $note_flag++;
                }
                $created_at = new Carbon($bringg_service->created_at);
                $service_way_points = $bringg_service->way_points;
                //if($bringg_service->id == '11831972') dd($service_way_points);
                $service_progress = 0;
                $live_eta = 'N/A';
                for($i=0;$i<count($service_way_points);$i++){
                    //if($service_way_points[$i]->done == true) $service_progress++;
                    if($service_way_points[$i]->checkin_time != null) $service_progress++;
                    if($service_way_points[$i]->eta != null) {
                        $eta_c = new Carbon($service_way_points[$i]->eta);
                        $live_eta = $eta_c->format('H:i');
                    }
                }
                $progress = ($service_progress/count($service_way_points))*100;
                $location = ($service_way_points[0]->address!=null)? $service_way_points[0]->address : 'N/A';
                $destination = (count($service_way_points)==2)? $service_way_points[1]->address : 'N/A';
                $loc_array = explode(',',$location); end($loc_array);
                $loc = prev($loc_array);
                $des_array = explode(',',$destination); end($des_array);
                $des = prev($des_array);
                $due_by = $created_at->addMinutes($eta_setting->value)->toDateTimeString();
                $created_at = new Carbon($bringg_service->created_at);
                $assigned_status = $created_at->addMinutes($assigned_status_kpi->value)->toDateTimeString();
                $created_at = new Carbon($bringg_service->created_at);
                $current_time = Carbon::now()->toDateTimeString();
                $row_color = '';
                $title_array = explode('-',$bringg_service->title);
                if($due_by < $current_time && $progress == 0){
                    $row_color = '#d63434';
                } elseif ($bringg_service->status == 0 && $assigned_status < $current_time) {
                    $row_color = '#f07d04';
                }
                $grid_services[] = [
                    'id' => $id,
                    'bringg_id' => $bringg_service->id,
                    'status' => url(asset('images/task-icons/'.$bringg_service->status.'.png')),
                    'title' => $bringg_service->title,
                    'created_at' => $created_at->format('d-m-Y g:i A'),
                    'driver' => ($bringg_service->user_id != null)? $bringg_service->user->name : 'N/A',
                    'progress' => $progress,
                    'location' => $location,
                    'destination' => $destination,
                    'loc' => $loc,
                    'des' => $des,
                    'note' => ($note_flag > 0)? url(asset('images/task-icons/note.png')) : url(asset('images/task-icons/no-note.png')),
                    'due_by' => $created_at->addMinutes($eta_setting->value)->format('H:i'),
                    'live_eta' => $live_eta,
                    'row_color' => $row_color,
                    'cartow_rep' => $cartow_rep,
                    'vehicle_reg' => $title_array[0],
                    'service_type' => ($id != null)? $local_task->service->type : $title_array[1]
                ];
            }
        }
        usort($grid_services,function($a, $b) {
            return strtotime($a['due_by']) - strtotime($b['due_by']);
        });
        //dd($grid_services);
        //Open services which are done on Bringg
        $open_services = NonMemberService::where('status','=','open')->whereNotIn('id',$local_tasks_ids)->get();
        $grid_open_services = [];
        foreach($open_services as $key=>$service) {
            $due_time = new Carbon($service->due_time);
            $due_by = $due_time->format('H:i');
            if($service->bringg_id != null && $service->bringg_id != '') {
                $url = 'https://developer-api.bringg.com/partner_api/tasks/'.$service->bringg_id;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Content-Length: ' . strlen($content)));
                $json_response = curl_exec($ch);
                $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                if ($status == 200) {
                    $bringg_service = json_decode($json_response);
                    //dd($bringg_service);
                    $created_at = new Carbon($bringg_service->created_at);
                    $service_way_points = $bringg_service->way_points;
                    $service_progress = 0;
                    $live_eta = 'N/A';
                    for($i=0;$i<count($service_way_points);$i++){
                        if($service_way_points[$i]->done == true) $service_progress++;
                        if($service_way_points[$i]->eta != null) {
                            $eta_c = new Carbon($service_way_points[$i]->eta);
                            $live_eta = $eta_c->format('H:i');
                        }
                    }
                    $progress = ($service_progress/count($service_way_points))*100;
                    $location = ($service_way_points[0]->address!=null)? $service_way_points[0]->address : 'N/A';
                    $destination = (count($service_way_points)==2)? $service_way_points[1]->address : 'N/A';
                    $loc_array = explode(',',$location); end($loc_array);
                    $loc = prev($loc_array);
                    $des_array = explode(',',$destination); end($des_array);
                    $des = prev($des_array);
                    //$eta_setting = \App\Models\Settings::find(2);
                    $assigned_status_kpi = \App\Models\Settings::where('code','=','assigned-status-kpi')->first();
                    //$due_by = $created_at->addMinutes($eta_setting->value)->toDateTimeString();
                    $assigned_status = $created_at->addMinutes($assigned_status_kpi->value)->toDateTimeString();
                    $current_time = Carbon::now()->toDateTimeString();
                    $row_color = '';
                    $title_array = explode('-',$bringg_service->title);
                    if($bringg_service->status == 4) {
                        //$row_color = '#409325';
                        $row_color = '#0BCCBB';
                    } elseif($bringg_service->status == 7) {
                        $row_color = '#a5a5a5';
                    } elseif($due_by < $current_time && ($progress == 0)){
                        $row_color = '#d63434';
                    } elseif ($bringg_service->status == 0 && $assigned_status < $current_time) {
                        $row_color = '#f07d04';
                    }
                    $grid_open_services[] = ['id' => $service->id,
                        'bringg_id' => $service->bringg_id,
                        'status' => url(asset('images/task-icons/'.$bringg_service->status.'.png')),
                        'title' => $bringg_service->title,
                        'created_at' => $created_at->format('d-m-Y g:i A'),
                        'driver' => ($bringg_service->user_id != null)? $bringg_service->user->name : 'N/A',
                        'progress' => $progress,
                        'location' => $location,
                        'destination' => $destination,
                        'loc' => $loc,
                        'des' => $des,
                        'note' => ($service->comments()->count() > 0)? url(asset('images/task-icons/note.png')) : url(asset('images/task-icons/no-note.png')),
                        'due_by' => $due_by,
                        'live_eta' => $live_eta,
                        'row_color' => $row_color,
                        'cartow_rep' => $service->added_by,
                        'vehicle_reg' => $title_array[0],
                        'service_type' => $service->service->type
                    ];
                } else {
                    $grid_open_services[] = ['id' => $service->id,
                        'bringg_id' => $service->bringg_id,
                        'status' => 'N/A',
                        'title' => $service->vehicle_reg,
                        'created_at' => $service->created_at,
                        'driver' => 'N/A',
                        'progress' => 0,
                        'location' => 'N/A',
                        'destination' => 'N/A',
                        'loc' => 'N/A',
                        'des' => 'N/A',
                        'note' => ($service->comments()->count() > 0)? url(asset('images/task-icons/note.png')) : url(asset('images/task-icons/no-note.png')),
                        'due_by' => $due_by,
                        'live_eta' => 'N/A',
                        'row_color' => '',
                        'cartow_rep' => $service->added_by,
                        'vehicle_reg' => $service->vehicle_reg,
                        'service_type' => $service->service->type
                    ];
                }
            } else {
                $grid_open_services[] = ['id' => $service->id,
                    'bringg_id' => $service->bringg_id,
                    'status' => 'N/A',
                    'title' => $service->vehicle_reg,
                    'created_at' => $service->created_at,
                    'driver' => 'N/A',
                    'progress' => 0,
                    'location' => 'N/A',
                    'destination' => 'N/A',
                    'loc' => 'N/A',
                    'des' => 'N/A',
                    'note' => ($service->comments()->count() > 0)? url(asset('images/task-icons/note.png')) : url(asset('images/task-icons/no-note.png')),
                    'due_by' => $due_by,
                    'live_eta' => 'N/A',
                    'row_color' => '',
                    'cartow_rep' => $service->added_by,
                    'vehicle_reg' => $service->vehicle_reg,
                    'service_type' => $service->service->type
                ];
            }
        }
        usort($grid_open_services,function($a, $b) {
            return strtotime($a['due_by']) - strtotime($b['due_by']);
        });
        return view('home.master.open-services',['services'=>$grid_services,
            'open_services'=>$grid_open_services]);
    }

    public function openServicesForView(){
        //Bringg variables
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
        //Current open tasks from Bringg
        $grid_services = [];
        $local_tasks_ids = [];
        $eta_setting = \App\Models\Settings::find(2);
        $assigned_status_kpi = \App\Models\Settings::where('code','=','assigned-status-kpi')->first();
        $url = 'https://developer-api.bringg.com/partner_api/tasks/open';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Content-Length: ' . strlen($content)));
        $json_response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($status == 200) {
            $open_services = json_decode($json_response);
            foreach($open_services as $bringg_service) {
                $id = null;
                $cartow_rep = 'N/A';
                $note_flag = 0;
                $local_task = NonMemberService::where('bringg_id','=',$bringg_service->id)->first();
                if($local_task) {
                    $id = $local_task->id;
                    $local_tasks_ids[] = $local_task->id;
                    $cartow_rep = $local_task->added_by;
                    if($local_task->comments()->count() > 0) $note_flag++;
                }
                $created_at = new Carbon($bringg_service->created_at);
                $service_way_points = $bringg_service->way_points;
                //if($bringg_service->id == '11831972') dd($service_way_points);
                $service_progress = 0;
                $live_eta = 'N/A';
                for($i=0;$i<count($service_way_points);$i++){
                    //if($service_way_points[$i]->done == true) $service_progress++;
                    if($service_way_points[$i]->checkin_time != null) $service_progress++;
                    if($service_way_points[$i]->eta != null) {
                        $eta_c = new Carbon($service_way_points[$i]->eta);
                        $live_eta = $eta_c->format('H:i');
                    }
                }
                $progress = ($service_progress/count($service_way_points))*100;
                $location = ($service_way_points[0]->address!=null)? $service_way_points[0]->address : 'N/A';
                $destination = (count($service_way_points)==2)? $service_way_points[1]->address : 'N/A';
                $loc_array = explode(',',$location); end($loc_array);
                $loc = prev($loc_array);
                $des_array = explode(',',$destination); end($des_array);
                $des = prev($des_array);
                $due_by = $created_at->addMinutes($eta_setting->value)->toDateTimeString();
                $created_at = new Carbon($bringg_service->created_at);
                $assigned_status = $created_at->addMinutes($assigned_status_kpi->value)->toDateTimeString();
                $created_at = new Carbon($bringg_service->created_at);
                $current_time = Carbon::now()->toDateTimeString();
                $row_color = '';
                $title_array = explode('-',$bringg_service->title);
                if($due_by < $current_time && $progress == 0){
                    $row_color = '#d63434';
                } elseif ($bringg_service->status == 0 && $assigned_status < $current_time) {
                    $row_color = '#f07d04';
                }
                $grid_services[] = [
                    'id' => $id,
                    'bringg_id' => $bringg_service->id,
                    'status' => url(asset('images/task-icons/'.$bringg_service->status.'.png')),
                    'title' => $bringg_service->title,
                    'created_at' => $created_at->format('d-m-Y g:i A'),
                    'driver' => ($bringg_service->user_id != null)? $bringg_service->user->name : 'N/A',
                    'progress' => $progress,
                    'location' => $location,
                    'destination' => $destination,
                    'loc' => $loc,
                    'des' => $des,
                    'note' => ($note_flag > 0)? url(asset('images/task-icons/note.png')) : url(asset('images/task-icons/no-note.png')),
                    'due_by' => $created_at->addMinutes($eta_setting->value)->format('H:i'),
                    'live_eta' => $live_eta,
                    'row_color' => $row_color,
                    'cartow_rep' => $cartow_rep,
                    'vehicle_reg' => $title_array[0],
                    'service_type' => ($id != null)? $local_task->service->type : $title_array[1]
                ];
            }
        }
        usort($grid_services,function($a, $b) {
            return strtotime($a['due_by']) - strtotime($b['due_by']);
        });
        //dd($grid_services);
        //Open services which are done on Bringg
        $open_services = NonMemberService::where('status','=','open')->whereNotIn('id',$local_tasks_ids)->get();
        $grid_open_services = [];
        foreach($open_services as $key=>$service) {
            $due_time = new Carbon($service->due_time);
            $due_by = $due_time->format('H:i');
            if($service->bringg_id != null && $service->bringg_id != '') {
                $url = 'https://developer-api.bringg.com/partner_api/tasks/'.$service->bringg_id;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Content-Length: ' . strlen($content)));
                $json_response = curl_exec($ch);
                $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                if ($status == 200) {
                    $bringg_service = json_decode($json_response);
                    //dd($bringg_service);
                    $created_at = new Carbon($bringg_service->created_at);
                    $service_way_points = $bringg_service->way_points;
                    $service_progress = 0;
                    $live_eta = 'N/A';
                    for($i=0;$i<count($service_way_points);$i++){
                        if($service_way_points[$i]->done == true) $service_progress++;
                        if($service_way_points[$i]->eta != null) {
                            $eta_c = new Carbon($service_way_points[$i]->eta);
                            $live_eta = $eta_c->format('H:i');
                        }
                    }
                    $progress = ($service_progress/count($service_way_points))*100;
                    $location = ($service_way_points[0]->address!=null)? $service_way_points[0]->address : 'N/A';
                    $destination = (count($service_way_points)==2)? $service_way_points[1]->address : 'N/A';
                    $loc_array = explode(',',$location); end($loc_array);
                    $loc = prev($loc_array);
                    $des_array = explode(',',$destination); end($des_array);
                    $des = prev($des_array);
                    //$eta_setting = \App\Models\Settings::find(2);
                    $assigned_status_kpi = \App\Models\Settings::where('code','=','assigned-status-kpi')->first();
                    //$due_by = $created_at->addMinutes($eta_setting->value)->toDateTimeString();
                    $assigned_status = $created_at->addMinutes($assigned_status_kpi->value)->toDateTimeString();
                    $current_time = Carbon::now()->toDateTimeString();
                    $row_color = '';
                    $title_array = explode('-',$bringg_service->title);
                    if($bringg_service->status == 4) {
                        //$row_color = '#409325';
                        $row_color = '#0BCCBB';
                    } elseif($bringg_service->status == 7) {
                        $row_color = '#a5a5a5';
                    } elseif($due_by < $current_time && ($progress == 0)){
                        $row_color = '#d63434';
                    } elseif ($bringg_service->status == 0 && $assigned_status < $current_time) {
                        $row_color = '#f07d04';
                    }
                    $grid_open_services[] = ['id' => $service->id,
                        'bringg_id' => $service->bringg_id,
                        'status' => url(asset('images/task-icons/'.$bringg_service->status.'.png')),
                        'title' => $bringg_service->title,
                        'created_at' => $created_at->format('d-m-Y g:i A'),
                        'driver' => ($bringg_service->user_id != null)? $bringg_service->user->name : 'N/A',
                        'progress' => $progress,
                        'location' => $location,
                        'destination' => $destination,
                        'loc' => $loc,
                        'des' => $des,
                        'note' => ($service->comments()->count() > 0)? url(asset('images/task-icons/note.png')) : url(asset('images/task-icons/no-note.png')),
                        'due_by' => $due_by,
                        'live_eta' => $live_eta,
                        'row_color' => $row_color,
                        'cartow_rep' => $service->added_by,
                        'vehicle_reg' => $title_array[0],
                        'service_type' => $service->service->type
                    ];
                } else {
                    $grid_open_services[] = ['id' => $service->id,
                        'bringg_id' => $service->bringg_id,
                        'status' => 'N/A',
                        'title' => $service->vehicle_reg,
                        'created_at' => $service->created_at,
                        'driver' => 'N/A',
                        'progress' => 0,
                        'location' => 'N/A',
                        'destination' => 'N/A',
                        'loc' => 'N/A',
                        'des' => 'N/A',
                        'note' => ($service->comments()->count() > 0)? url(asset('images/task-icons/note.png')) : url(asset('images/task-icons/no-note.png')),
                        'due_by' => $due_by,
                        'live_eta' => 'N/A',
                        'row_color' => '',
                        'cartow_rep' => $service->added_by,
                        'vehicle_reg' => $service->vehicle_reg,
                        'service_type' => $service->service->type
                    ];
                }
            } else {
                $grid_open_services[] = ['id' => $service->id,
                    'bringg_id' => $service->bringg_id,
                    'status' => 'N/A',
                    'title' => $service->vehicle_reg,
                    'created_at' => $service->created_at,
                    'driver' => 'N/A',
                    'progress' => 0,
                    'location' => 'N/A',
                    'destination' => 'N/A',
                    'loc' => 'N/A',
                    'des' => 'N/A',
                    'note' => ($service->comments()->count() > 0)? url(asset('images/task-icons/note.png')) : url(asset('images/task-icons/no-note.png')),
                    'due_by' => $due_by,
                    'live_eta' => 'N/A',
                    'row_color' => '',
                    'cartow_rep' => $service->added_by,
                    'vehicle_reg' => $service->vehicle_reg,
                    'service_type' => $service->service->type
                ];
            }
        }
        usort($grid_open_services,function($a, $b) {
            return strtotime($a['due_by']) - strtotime($b['due_by']);
        });
        return view('home.master.open-services-for-view',['services'=>$grid_services,
            'open_services'=>$grid_open_services]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Sherifa
 * Date: 7/16/2015
 * Time: 1:25 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class NonMemberService extends Eloquent
{
    protected $table = 'non_member_services';

    public function service()
    {
        return $this->hasOne('App\Models\ServiceTypes', 'id', 'service_id');
    }

    public function addNonMemberService($bringg_id, $vehicle_reg, $customer_name, $customer_phone,
        $service_id, $company_name, $note, $vehicle_address, $vehicle_lat, $vehicle_lon,
        $vehicle_dest, $user, $to_pay, $override_reason, $status, $due_time, $assigned_due_time)
    {
        $result = array();
        
        $non_member_service = new NonMemberService();
        $non_member_service->bringg_id = $bringg_id;
        $non_member_service->vehicle_reg = $vehicle_reg;
        $non_member_service->customer_name = $customer_name;
        $non_member_service->customer_phone = $customer_phone;
        $non_member_service->service_id = $service_id;
        $non_member_service->client_company = $company_name;
        $non_member_service->note = $note;
        $non_member_service->vehicle_address = $vehicle_address;
        $non_member_service->vehicle_lat = $vehicle_lat;
        $non_member_service->vehicle_lon = $vehicle_lon;
        $non_member_service->vehicle_dest = $vehicle_dest;
        $non_member_service->added_by = $user->first_name.' '.$user->last_name;
        $non_member_service->to_pay = $to_pay;
        $non_member_service->override_reason = $override_reason;
        $non_member_service->status = $status;
        $non_member_service->due_time = $due_time;
        $non_member_service->assigned_due_time = $assigned_due_time;
        $insert = $non_member_service->save();

        if ($insert === true) {
            $result['error'] = 0;
            $result['message'] = 'Service added';
            $result['id'] = $non_member_service->id;
        } else {
            $result['error'] = 1;
            $result['message'] = 'Service not added';
            $result['id'] = null;
        }

        return $result;
    }

    public function comments()
    {
        return $this->hasMany('App\Models\ServiceComment', 'service_id', 'id');
    }

    public function the_quote()
    {
        return $this->hasOne('App\Models\ServiceQuote', 'service_id', 'id');
    }
}
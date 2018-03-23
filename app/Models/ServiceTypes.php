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

class ServiceTypes extends Eloquent
{

    protected $table = 'service_types';
    public $timestamps = false;

    /**
     *
     */
    public static function getTypes()
    {
        $types = ServiceTypes::all()->toArray();
        return $types;
    }

    public function addService($customer_id, $service_id, $bringg_id, $company_name, $note, $vehicle_address, $vehicle_lat, $vehicle_lon, $vehicle_dest, $user)
    {
        $result = array();
        
        $customer_services = new CustomerServices();
        $customer_services->customer_id = $customer_id;
        $customer_services->service_id = $service_id;
        $customer_services->bringg_id = $bringg_id;
        $customer_services->client_company = $company_name;
        $customer_services->note = $note;
        $customer_services->vehicle_address = $vehicle_address;
        $customer_services->vehicle_lat = $vehicle_lat;
        $customer_services->vehicle_lon = $vehicle_lon;
        $customer_services->vehicle_dest = $vehicle_dest;
        $customer_services->added_by = $user->first_name.' '.$user->last_name;
        $insert = $customer_services->save();

        if ($insert === true) {
            DB::table('customers')->where('id','=',$customer_id)->increment('number_of_assists');
            $result['error'] = 0;
            $result['message'] = 'Service added';
        } else {
            $result['error'] = 1;
            $result['message'] = 'Service not added';
        }

        return $result;
    }

}
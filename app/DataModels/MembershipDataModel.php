<?php namespace App\DataModels;

use Symfony\Component\HttpFoundation\Request;

class MembershipDataModel
{
    public $user_id = null;
    public $title;
    public $first_name;
    public $last_name;
    public $email;
    public $address_line_1;
    public $address_line_2;
    public $town;
    public $county;
    public $postal_code;
    public $phone_number;
    public $nok_phone_number;
    public $vehicle_registration;
    public $have_nct;
    public $odometer_reading;
    public $odometer_type;
    public $membership;
    public $start_date;
    public $membership_expiration;
    public $colour;
    public $transmission;
    public $fuel;
    public $engine_size;
    public $version;
    public $model;
    public $make;
    public $added_by;
    public $company_id;
    public $username;
    public $password;
    

    /**
     * @param Request $request
     * @param array $extra_info
     */
    public function __construct(Request $request,array $extra_info=[])
    {

        $this->title = $request->get('title');
        $this->first_name = $request->get('first_name');
        $this->last_name = $request->get('last_name');
        $this->email = $request->get('email');
        $this->address_line_1 = $request->get('address_line_1');
        $this->address_line_2 = $request->get('address_line_2');
        $this->town = $request->get('town');
        $this->county = $request->get('county');
        $this->postal_code = $request->get('postal_code');
        $this->phone_number = $request->get('phone_number');
        $this->nok_phone_number = $request->get('nok_phone_number');
        $this->vehicle_registration = $request->get('vehicle_registration');
        $this->have_nct = $request->get('nct',0);
        $this->odometer_reading = $request->get('odometer_reading');
        $this->odometer_type = $request->get('odometer_type');
        $this->membership = $request->get('membership_type');
        $this->start_date = ($request->get('start_date'));
        $this->membership_expiration = $request->get('membership_expiration');
        $this->colour = $request->get('colour');
        $this->transmission = $request->get('transmission');
        $this->fuel = $request->get('fuel');
        $this->engine_size = $request->get('engine-size');
        $this->version = $request->get('version');
        $this->model = $request->get('model');
        $this->make = $request->get('make');
        $this->added_by = null;
        $this->username = $request->get('username');
        $this->password =  mt_rand(100000,1000000);
        $this->company_id = array_key_exists('company_id',$extra_info)?$extra_info['company_id']:false;
        $this->added_by = array_key_exists('added_by',$extra_info)?$extra_info['added_by']:false;



    }

}
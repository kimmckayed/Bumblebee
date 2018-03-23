<?php namespace App\DataModels;

use App\Enums\OrderStatuses;
use App\Models\Orders;
use Carbon\Carbon;
use Request;

class OrderDataModel{
    public $order_id;
    public $invoice_no;
    public $invoice_prefix;
    public $customer_id;
    public $firstname;
    public $lastname;
    public $email;
    public $telephone;
    public $fax;
    public $custom_field;
    public $payment_firstname;
    public $payment_lastname;
    public $payment_company;
    public $payment_address_1;
    public $payment_address_2;
    public $payment_city;
    public $payment_postcode;
    public $payment_country;
    public $payment_country_id;
    public $payment_zone;
    public $payment_zone_id;
    public $payment_address_format;
    public $payment_custom_field;
    public $payment_method;
    public $payment_code;
    public $comment;
    public $total;
    public $order_status_id;
    public $commission;
    public $tracking;
    public $currency_value;
    public $currency_code;
    public $ip;
    public $forwarded_ip;
    public $user_agent;
    public $date_added;
    public $date_modified;

    /**
     * @param $order
     */
    public function __construct($order) {

        $this->invoice_no = "new";
        $this->invoice_prefix = $order['invoice_prefix'];
        $this->customer_id = $order['customer_id'];
        $this->firstname =$order['firstname'];
        $this->email = $order['email'];
        $this->telephone = $order['telephone'];
        $this->payment_firstname = $order['payment_firstname'];
        $this->payment_company =$order['payment_company'];
        $this->payment_address_1 = $order['payment_address_1'];
        $this->payment_city ='asd';
        $this->payment_postcode =1214 ;
        $this->payment_country ='asda' ;
        $this->payment_country_id =5454 ;
        $this->payment_zone ='asd';
        $this->payment_zone_id =5454;
        $this->payment_address_format ='adssad' ;
        $this->payment_custom_field ='asdsas' ;
        $this->comment =$order['comment'];
        $this->total = 100;
        $this->order_status_id = OrderStatuses::pending ;
        $this->commission =54545 ;
        $this->tracking ='asdd' ;
        $this->currency_value ='asdas' ;
        $this->currency_code ='adas' ;
        $this->ip = Request::getClientIp();
        $this->forwarded_ip = Request::getClientIp();
        $this->user_agent ='asssdsa';
        $this->date_added =Carbon::now() ;
        $this->date_modified =Carbon::now() ;
    }



    public function changeStatus($status)
    {
        $this->order_status_id=$status;
    }


}
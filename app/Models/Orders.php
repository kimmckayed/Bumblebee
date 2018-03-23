<?php
namespace App\Models;

use App\DataModels\OrderDataModel;
use App\Enums\OrderStatuses;
use Illuminate\Database\Eloquent\Model as Eloquent;
use DB;

class Orders extends Eloquent
{

	protected $table = 'oc_order';
    public $timestamps = false;
    protected $primaryKey = 'order_id';
    public function products()
    {
        return $this->hasMany('App\Models\OrderProduct', 'order_id', 'order_id');
    }

    public function newOrder(OrderDataModel &$order_data_model){
        Eloquent::unguard();
        $order = new Orders($this->dataModelToArray($order_data_model));
        if(!$order->save())
            return false;
        $order_data_model->order_id=$order->order_id;
        $order_data_model->invoice_no=$order_data_model->invoice_prefix.'_'.$order->order_id;
        $order->invoice_no =$order_data_model->invoice_no;
        if(!$order->save())
            return false;

        return true;
    }

    public function processPayment($order_id, $payment_code)
    {
        $this->addPaymentCode($order_id,$payment_code);
        $this->changeStatus($order_id,OrderStatuses::accepted);
    }

    public function changeStatus($order_id,$status){
        $order=Orders::find($order_id);
        $order->order_status_id=$status;
        $order->save();

    }
    public function findById($order_id){
        return Orders::find( $order_id);
    }

    public function addPaymentCode($order_id, $payment_code)
    {
        $order=(new Orders())->find($order_id);
        $order->payment_code=$payment_code;
        $order->save();
    }
    public function dataModelToArray(OrderDataModel $order_data_model){
        return [
            'invoice_no'=> $order_data_model->invoice_no,
            'invoice_prefix'=>$order_data_model->invoice_prefix,
            'customer_id'=> $order_data_model->customer_id,
            'firstname'=> $order_data_model->firstname,
            'lastname'=> $order_data_model->lastname,
            'email'=> $order_data_model->email,
            'telephone'=> $order_data_model->telephone,
            'fax'=> $order_data_model->fax,
            'custom_field'=> $order_data_model->custom_field,
            'payment_firstname'=> $order_data_model->payment_firstname,
            'payment_lastname'=> $order_data_model->payment_lastname,
            'payment_company'=> $order_data_model->payment_company,
            'payment_address_1'=> $order_data_model->payment_address_1,
            'payment_address_2'=> $order_data_model->payment_address_2,
            'payment_city'=> $order_data_model->payment_city,
            'payment_postcode'=> $order_data_model->payment_postcode,
            'payment_country'=> $order_data_model->payment_country,
            'payment_country_id'=> $order_data_model->payment_country_id,
            'payment_zone'=> $order_data_model->payment_zone,
            'payment_zone_id'=> $order_data_model->payment_zone_id,
            'payment_address_format'=> $order_data_model->payment_address_format,
            'payment_custom_field'=> $order_data_model->payment_custom_field,
            'payment_method'=> $order_data_model->payment_method,
            'payment_code'=> $order_data_model->payment_code,
            'comment'=> $order_data_model->comment,
            'total'=> $order_data_model->total,
            'order_status_id'=> $order_data_model->order_status_id,
            'commission'=> $order_data_model->commission,
            'tracking'=> $order_data_model->tracking,
            'currency_value'=> $order_data_model->currency_value,
            'currency_code'=> $order_data_model->currency_code,
            'ip'=> $order_data_model->ip,
            'forwarded_ip'=> $order_data_model->forwarded_ip,
            'user_agent'=> $order_data_model->user_agent,
            'date_added'=> $order_data_model->date_added,
            'date_modified'=> $order_data_model->date_modified
        ];
    }




}
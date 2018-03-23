<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class CustomerServices extends Eloquent
{
    protected $table = 'customers_services';
    public $timestamps = true;

    public static function getCustomerServices() {
        $customer_services = CustomerServices::get();
        $customer_services = $customer_services->toArray();
        return $customer_services;
    }
    
    public function services() {
        return $this->hasOne('App\Models\ServiceTypes', 'id', 'service_id');
    }

    public function customer() {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id')->withTrashed();
    }
}
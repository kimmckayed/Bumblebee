<?php namespace App\DataModels;

use Illuminate\Http\Request;
use Input;

/**
 * @property mixed name
 */
class CouponDataModel
{
    public $name;
    public $code;
    public $type;
    public $discount;
    public $logged;
    public $total;
    public $date_start;
    public $date_end;
    public $uses_total;
    public $uses_customer;
    public $status;
    public $date_added;

    public function __construct(array $extra_info = [])
    {
        $this->name = Input::get('name');
        $this->code = Input::get('code');
        $this->type = Input::get('discount', 'main');
        $this->discount = Input::get('discount',0);
        $this->logged = Input::get('logged',0);
        $this->total = Input::get('total', 0);
        $this->date_start = Input::get('date_start',date('Y-m-d'));
        $this->date_end = Input::get('date_end',date('Y-m-d'));
        $this->uses_total = Input::get('uses_total',10000);
        $this->uses_customer = Input::get('uses_customer',1);
        $this->status = Input::get('status',0);
        $this->date_added = Input::get('date_added',date('Y-m-d H:i:s'));


    }
}
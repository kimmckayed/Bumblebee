<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Toll extends Eloquent
{
    protected $table = 'tolls';
    protected $guarded = ['id'];

    public function theTax()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax');
    }

    public function taxValue() {
        $tax = Tax::find($this->tax);
        if(!$tax) return null;
        return $tax->value;
    }
}
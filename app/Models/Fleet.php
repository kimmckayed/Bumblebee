<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Fleet extends Eloquent
{
    protected $table = 'fleets';

    //protected $guarded = ['id'];

    public static function getFleets()
    {
        $fleets = Fleet::all();

        return $fleets;
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }
}
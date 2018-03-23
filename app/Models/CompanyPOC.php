<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CompanyPOC extends Eloquent
{

	protected $table = 'poc';
	public $timestamps = false;

	public function company()
    {
        return $this->hasOne('App\Models\Company','main_poc','id');
    }
}
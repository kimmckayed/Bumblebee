<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class PocToCompany extends Eloquent
{

	protected $table = 'poc_to_company';
	protected $primaryKey = 'poc_id';
	public $timestamps = false;

	/*public function company()
    {
        return $this->hasOne('App\Models\Company','main_poc','id');
    }*/
}
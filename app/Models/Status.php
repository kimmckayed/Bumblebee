<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;

class Status extends Eloquent
{

	protected $table = 'statuses';

	// protected $table = 'master_accounts';
	public static function getStatuses() {
		$statuses = Status::get();
		$statuses = $statuses->toArray();
		return $statuses;
	}

    public static function getById($id) {
        $status =  Status::whereId($id)->pluck('status');
        return ($status !== null)?$status:'none';
    }

	public function users()
    {
        return $this->hasMany('App\Models\User','status','id');
    }

}
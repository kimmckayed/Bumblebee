<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;

class Department extends Eloquent
{

	protected $table = 'departments';

	// protected $table = 'master_accounts';
	public static function getDepartments() {
		$departments = Department::get();
		$departments = $departments->toArray();
		return $departments;
	}

/*	public function master() {

		return $this->hasMany('App\Models\Master','department','id');

	}*/

}
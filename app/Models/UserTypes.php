<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;

class UserTypes extends Eloquent
{

	protected $table = 'sub_user_types';

	// protected $table = 'master_accounts';
	public static function getUserTypes() {
		$sub_user_types = UserTypes::get();
		$sub_user_types = $sub_user_types->toArray();
		return $sub_user_types;
	}

	/*public function users()
    {
        return $this->hasMany('App\User','account_id','id');
    }*/

}
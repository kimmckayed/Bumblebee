<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;

class LoginTypes extends Eloquent
{

	protected $table = 'login_account_types';

	// protected $table = 'master_accounts';
	public static function getLoginTypes() {
		$login_types = LoginTypes::get();
		$login_types = $login_types->toArray();
		return $login_types;
	}
    public static function getById($id) {
        $type =  LoginTypes::whereId($id)->pluck('type');
        return ($type !== null)?$type:'none';
    }

	public function users()
    {
        return $this->hasMany('App\Models\User','account_id','id');
    }

}
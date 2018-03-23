<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;

class Notification extends Eloquent
{

	protected $table = 'notifications';
	public $timestamps = false;

/*	public static function getCompanies() {
		$companies = Company::all();
		return $companies;
	}*/

/*	public function company_poc()
    {
        return $this->hasOne('App\Models\CompanyPOC','id','main_poc');
    }

    public function agents()
    {
        return $this->hasMany('App\Models\Company','id','company_id');
    }*/

/*	public function getInfo($account_id) {

		// $account = Company::where('id', '=',$account_id);
		$account = DB::table('company_accounts')->where('id', '=', $account_id)->get();
		return $account;

	}*/

	public function newNotification($user_id, $text) {
		DB::table('notifications')->insert(['user_id' => $user_id, 'text' => $text, 'created_at' => time()]);
	}

	public function newMasterNotifications($text) {
		$master = new Master();
		$accounts = $master->getAllMasterAccounts();
		foreach ($accounts as $account) {
			DB::table('notifications')->insert(['user_id' => $account['id'], 'text' => $text, 'created_at' => time()]);
		}
	}

	public function getUnreadNotifications($user_id) {
		$unread = DB::table('notifications')->where('user_id', '=', $user_id)->where('is_read','=',0)->count();
		return $unread;
	}

	public function getNotifications($user_id) {
		$notifications = DB::table('notifications')->where('user_id', '=', $user_id)->orderBy('created_at', 'desc')->get();

		if(count($notifications) > 0) {
			foreach ($notifications as $key=>$notification) {
				$time = $notification['created_at'];
				$now = time();
				$difference = $now - intval($time);

				$ago = '';

				if($difference < 60) ///less than one min
					$ago = 'just now';

				if($difference > 60 && $difference < 60*60) ///less than one hour
				{
					$ago = intval($difference/60);

					if($ago > 1)
						$ago .= ' mins';
					else
						$ago .=' min';
				}

				if($difference > 60*60 && $difference < 60*60*24) ///less than one day
				{
					$ago = intval($difference/(60*60));

					if($ago > 1)
						$ago .= ' hours';
					else
						$ago .= ' hour';
				}

				if($difference > 60*60*24 && $difference < 60*60*24*30) ///less than one month
				{
					$ago = intval($difference/(60*60*24));

					if($ago > 1)
						$ago .= ' days';
					else
						$ago .= ' day';
				}

				$notifications[$key]['ago'] = $ago; 

			}
		}
		return $notifications;
	}

/*	public function notifications_read() {

	}*/

}
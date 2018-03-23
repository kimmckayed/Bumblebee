<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;

class Applegreencode extends Eloquent
{

	protected $table = 'applegreen_codes';

	public function checkApplgreencode($code) {
		$result = array();
		$count = DB::table('applegreen_codes')->where('applegreen_code',$code)->count();
		if($count > 0) {
			$count1 = DB::table('applegreen_codes')->where('applegreen_code',$code)->where('used',0)->count();
			if($count1 > 0) {
				$result['error'] = 0;
				$result['message'] = 'Found';
			} else {
				$result['error'] = 1;
				$result['message'] = 'This code has already been used';
			}
		} else {
			$result['error'] = 1;
			$result['message'] = 'Invalid Apple Green code';
		}

		return $result;

	}

	public function codeUsed($code,$customer_id) {
		$result = array();

		$query = DB::table('applegreen_codes')->where('applegreen_code',$code)->update(['used' => 1, 'customer_id' => $customer_id]);
		if($query === true) {
			$result['error'] = 0;
			$result['message'] = 'Code updated';
		} else {
			$result['error'] = 1;
			$result['message'] = 'Code not updated';
		}

		return $result;
	}

	public function autogenerate_codes() {
		$membership_id = 1;
		while($membership_id <= 10000) {

			$random_code = rand(1000000000,9999999999);
			$count = DB::table('applegreen_codes')->where('applegreen_code',$random_code)->count();
			if($count === 0) {
				DB::table('applegreen_codes')->insert(['id'=>$membership_id,'applegreen_code'=>'APL-'.$random_code]);
				$membership_id++;
			}
		}
	}

}
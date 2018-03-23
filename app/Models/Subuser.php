<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Subuser extends Eloquent
{

    protected $table = 'agent_accounts';
    public $timestamps = false;

    public function type()
    {
        return $this->belongsTo('App\Models\UserTypes', 'user_type');
    }

    /*    public function status()
    {
    return $this->belongsTo('App\Models\Status','status');
    }*/

    public function getInfo($account_id)
    {

        $account = DB::table('agent_accounts')->where('id', '=', $account_id)->first();

        return $account;

    }

    public function getUserTypes()
    {
        $types = DB::table('sub_user_types')->get();

        return $types;
    }

    public function register(
        $user_type,
        $username,
        $password,
        $password_confirmation,
        $first_name,
        $last_name,
        $mobile_number,
        $email,
        $address,
        $nok_first_name,
        $nok_last_name,
        $nok_phone_number,
        $nok_address,
        $added_by,
        $company_id
    ) {
        // var_dump($department);exit;
        $result = array();
        $users = DB::table('users')->where('username', '=', $username)->where('account_type', '=', 2)->count();

        if ($users === 0) {
            if ($password === $password_confirmation) {
                $nok_id = DB::table('next_of_kin')->insertGetId([
                    'first_name' => $nok_first_name,
                    'last_name' => $nok_last_name,
                    'phone_number' => $nok_phone_number,
                    'address' => $nok_address
                ]);
                $account_id = DB::table('agent_accounts')->insertGetId([
                    'user_type' => $user_type,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'mobile_number' => $mobile_number,
                    'email_address' => $email,
                    'home_address' => $address,
                    'next_of_kin' => $nok_id,
                    'added_by' => $added_by,
                    'company_id'=>$company_id
                ]);
                $query = DB::table('users')->insert([
                    'username' => $username,
                    'password' => bcrypt($password),
                    'account_type' => 2,
                    'account_id' => $account_id,
                    'created_at' => time()
                ]);
                // DB::insert('insert into users (username, password, account_type, account_id, created_at) values (?, ?)', [$username, $password, 1, $account_id,time()]);

                if ($query === true) {
                    $result['error'] = 0;
                    $result['message'] = 'User inserted';
                } else {
                    $result['error'] = 1;
                    $result['message'] = 'User not inserted';
                }
            } else {
                $result['error'] = 1;
                $result['message'] = 'Passwords do not match';
            }
        } else {
            $result['error'] = 1;
            $result['message'] = 'Username already taken';
        }

        return $result;

    }

    public function deleteSubuserAccount($account_id)
    {
        /*if(!empty($account_id)) {
        var_dump($account_id);exit;
        }*/
        $result = array('error' => '', 'message' => '');

        if (!empty($account_id)) {
            $query = DB::table('agent_accounts')->where('id', '=', $account_id)->delete();

            if ($query === true) {
                $result['error'] = 0;
                $result['message'] = 'Subuser Deleted';
            } else {
                $result['error'] = 1;
                $result['message'] = 'Deletion Failed';
            }
        }

    }

}

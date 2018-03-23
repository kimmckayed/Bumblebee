<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Master extends Eloquent
{

    protected $table = 'master_accounts';
    public $timestamps = false;

    public function department()
    {
        return $this->hasOne('App\Models\Role','user_id','id');
    }

    public function getDepartments()
    {
        $departments = Department::getDepartments();

        return $departments;
    }

    public function getInfo($account_id)
    {
        $account = Master::find($account_id);

        return $account;
    }

    public function getAllMasterAccounts()
    {
        $accounts = DB::table('users')->where('account_type', '=', 1)->get();

        return $accounts;
    }

    /**
     * @param $username
     * @param $password
     * @param $password_confirmation
     * @param $first_name
     * @param $last_name
     * @param $department
     * @return array
     */
    public function register($username, $password, $password_confirmation, $first_name, $last_name, $department)
    {
        // var_dump($department);exit;
        $result = array();
        $users = DB::table('users')->where('username', '=', $username)->where('account_type', '=', 1)->count();

        if ($users === 0) {
            if ($password === $password_confirmation) {
                $account_id = DB::table('master_accounts')->insertGetId([
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'department' => $department
                ]);
                $query = DB::table('users')->insert([
                    'username' => $username,
                    'password' => bcrypt($password),
                    'account_type' => 1,
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


    public function deleteMasterAccount($account_id)
    {
        if (!empty($account_id)) {
          DB::table('master_accounts')->where('id', '=', $account_id)->delete();
        }

    }

}
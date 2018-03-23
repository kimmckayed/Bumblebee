<?php namespace App\DataModels;

use Symfony\Component\HttpFoundation\Request;

class UserDataModel
{
    public $username;
    public $email;
    public $password;
    public $permissions;
    public $first_name;
    public $last_name;
    public $account_type;
    public $status;
    public function __construct(Request $request,array $extra_info=[])
    {
        $this->username = $request->get('username');
        $this->email = $request->get('email');
        $this->password = $request->get('password', mt_rand(100000,1000000));
        $this->first_name = $request->get('first_name');
        $this->last_name = $request->get('last_name');
        $this->account_type = $request->get('account_type');
        $this->status = $request->get('status',1);
        $this->permissions = array_key_exists('permissions',$extra_info)?$extra_info['permissions']:null;
        $this->role = $request->get('role',7);
    }
}
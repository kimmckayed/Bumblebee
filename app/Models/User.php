<?php
namespace App\Models;

use App\Models\UserTypes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function type()
    {
        return $this->belongsTo('App\Models\LoginTypes', 'account_type');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status');
    }

    public function role()
    {
        return $this->hasOne('App\Models\Role');
    }

    public function checkStatus($id)
    {

        $user = DB::table('users')->where('id', '=', $id)->get();
        if ($user[0]['status'] == '1') {
            return 1;
        } else {
            return 0;
        }

    }

    public function cartowUsers()
    {
        $number = 0;
        $number = DB::table('users')->where('account_type', '=', 2)->orWhere('account_type', '=', 1)->count();

        return $number;
    }

    public function myCompanyCartowUsers()
    {
        $company_id  = Agent::where('user_id','=',$this->id)->first()->company_id;
        $number=Agent::where('company_id', '=', $company_id)->whereNotIn('user_id',['186'])->count();
        return $number;
    }

    public function deleteUserAccount($account_id, $account_type)
    {
        if ($account_type === 3) {

            $c = new Company();
            $c->deleteCompanyAgents($account_id);

        }


        if (!empty($account_id)) {
            $query = DB::table('users')->where('account_id', '=', $account_id)->where('account_type', '=',
                $account_type)->delete();

            if ($query === true) {
                return true;
            }
        }


        return false;

    }

    public function getTypeId($user_id)
    {


        $result = array('error' => '', 'message' => '');
        $user = array();

        if (!empty($user_id)) {
            $user = DB::table('users')->select('account_id', 'account_type')->where('id', '=', $user_id)->first();
            // $user = $user[0];
        }

        // var_dump($user);exit;
        return $user;
    }

}

<?php
namespace App\Models;

use App\DataModels\AgentDataModel;
use App\Enums\AccountTypes;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;

class Agent extends Eloquent
{

    protected $table = 'agent_accounts';
    public $timestamps = false;

    public function type()
    {
        return $this->belongsTo('App\Models\UserTypes', 'user_type');
    }

    public function company()
    {
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function role()
    {
        return $this->hasOne('App\Models\Role','user_id','user_id');
    }
    public function getByAccountId($account_id)
    {
        return $this->where('id', '=', $account_id)->first();
    }

    public function getInfo($account_id)
    {
        $account = $this->where('id', '=', $account_id)->get();
        $account = $account[0];

        return $account;
    }

    public function activeAgents($company_id = null)
    {
        $number = 0;

        if (!empty($company_id)) {
            $number = $this->join('users', 'users.id', '=','agent_accounts.user_id')
                ->where('users.account_type', '=', 4)->where('users.status', '=',1)
                ->where('agent_accounts.company_id', '=', $company_id)->count();
        } else {
            $number = $this->join('users', 'users.id', '=','agent_accounts.user_id')
                ->where('users.account_type', '=', 4)->where('users.status', '=',1)->count();
        }

        return $number;

    }

    public function getStatuses()
    {
        $statuses = Status::getStatuses();

        return $statuses;
    }

    public function add(
        AgentDataModel $agent_data_model
    ) {


        $agent = new Agent();
        $agent->user_id = $agent_data_model->user_id;
        $agent->company_id = $agent_data_model->company_id;
        $agent->added_by = $agent_data_model->added_by;
        $agent->phone_number = $agent_data_model->phone_number;
        if ($agent->save()) {
            return $agent;
        } else {
            return false;
        }


    }

    public function deleteAgentAccount($account_id)
    {
        /*if(!empty($account_id)) {
            var_dump($account_id);exit;
        }*/
        $result = array('error' => '', 'message' => '');

        if (!empty($account_id)) {
            $query = DB::table('agent_accounts')->where('id', '=', $account_id)->delete();

            if ($query === true) {
                $result['error'] = 0;
                $result['message'] = 'Agent Deleted';
            } else {
                $result['error'] = 1;
                $result['message'] = 'Deletion Failed';
            }
        }

    }

}
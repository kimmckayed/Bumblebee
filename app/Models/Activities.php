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

class Activities extends Eloquent
{

    protected $table = 'agent_activities';
    public $timestamps = false;


    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function entryBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'entry_by');
    }

}
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class FleetMember extends Eloquent
{
    protected $table = 'fleet_members';
    protected $guarded = ['id'];

    public function fleet()
    {
        return $this->hasOne('App\Models\Fleet', 'id', 'fleet_id');
    }

    public function member()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'member_id');
    }
}
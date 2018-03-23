<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Task extends Eloquent
{

    protected $table = 'tasks';

    protected $fillable = ['fleet_name','tag_name','vehicle_reg','driver_details',
        'dest_lan','dest_lon','ram','fault','notes'];

    protected $guarded = 'id';
}
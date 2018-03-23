<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class ServiceComment extends Eloquent
{

    protected $table = 'service_cc_comments';
    public $timestamps = true;
    protected $dates = ['created_at','updated_at'];

}
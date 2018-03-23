<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class ClientCompany extends Eloquent
{
    protected $table = 'client_companies';
    public $timestamps = false;
    protected $guarded = ['id'];
}
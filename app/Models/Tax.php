<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Tax extends Eloquent
{
    protected $table = 'taxes';
    public $timestamps = false;
    protected $guarded = ['id'];
}
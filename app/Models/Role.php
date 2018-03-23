<?php
namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Role extends Eloquent
{

    protected $table = 'role_users';

    public static function getRoleNameById($id)
    {
        $name =  DB::table('roles')->whereId($id)->pluck('name');
        return ($name !== null)?$name:'none';


    }

}
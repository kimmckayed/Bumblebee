<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Membership extends Eloquent
{
    use SoftDeletes;

    protected $table = 'memberships';
    public $timestamps = false;
    protected $dates = ['deleted_at'];

    // protected $table = 'master_accounts';

    /*    public function companies()
    {
    return $this->belongsToMany('App\Models\Company','companies_memberships','memberships','id');
    }
     */
    public static function getMemberships()
    {
        $memberships = Membership::get();
        $memberships = $memberships->toArray();

        return $memberships;
    }

    public static function getMembership($id)
    {
        $membership = Membership::where('id', '=', $id)->get()->toArray();
        if (isset($membership[0])) {
            $membership = $membership[0];
        } else {
            $membership = NULL;
        }

        return $membership;
    }

    public static function getCartowMemberships()
    {
        $memberships = Membership::where('code', 'like', 'CTMBR%')->get()->toArray();

        return $memberships;
    }

    public static function getCompanyMemberships($company_id)
    {

        $company = DB::table('company_accounts')->where('id', '=', $company_id)->get();

        $company = $company[0];

        $memberships_array = json_decode($company['memberships'], true);
        $memberships = array();

        foreach ($memberships_array as $membership) {
            $membership_found = Membership::getMembership($membership);
            if($membership_found != NULL){
                $memberships[] = $membership_found;
            }
        }

        // var_dump($memberships);exit;
        return $memberships;
    }

    public function register($name, $price, $duration, $code, $number_of_callouts)
    {
        // var_dump($name);exit;
        $result = array();

        $duration = $duration . ' months';
        $insert = DB::insert('insert into memberships (membership_name, price, duration, code, number_of_callouts) values (?, ?, ?, ?, ?)',
            [$name, $price, $duration, $code, $number_of_callouts]);
        if ($insert === true) {
            $result['error'] = 0;
            $result['message'] = 'Membership inserted';
        } else {
            $result['error'] = 1;
            $result['message'] = 'Membership not inserted';
        }

        return $result;
    }

}

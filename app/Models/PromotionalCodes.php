<?php
namespace App\Models;

use App\DataModels\CouponDataModel;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class PromotionalCodes extends Eloquent
{

    protected $table = 'promotional_code';
    public $timestamps = false;

    public function checkApplgreencode($code)
    {
        $result = array();
        $count = DB::table('applegreen_codes')->where('applegreen_code', $code)->count();
        if ($count > 0) {
            $count1 = DB::table('applegreen_codes')->where('applegreen_code', $code)->where('used', 0)->count();
            if ($count1 > 0) {
                $result['error'] = 0;
                $result['message'] = 'Found';
            } else {
                $result['error'] = 1;
                $result['message'] = 'This code has already been used';
            }
        } else {
            $result['error'] = 1;
            $result['message'] = 'Invalid Apple Green code';
        }

        return $result;

    }

    public function codeUsed($code, $customer_id)
    {
        $result = array();

        $query = DB::table('applegreen_codes')->where('applegreen_code', $code)->update([
            'used' => 1,
            'customer_id' => $customer_id
        ]);
        if ($query === true) {
            $result['error'] = 0;
            $result['message'] = 'Code updated';
        } else {
            $result['error'] = 1;
            $result['message'] = 'Code not updated';
        }

        return $result;
    }

    public function autogenerate_codes()
    {
        $membership_id = 1;
        while ($membership_id <= 10000) {

            $random_code = rand(1000000000, 9999999999);
            $count = DB::table('applegreen_codes')->where('applegreen_code', $random_code)->count();
            if ($count === 0) {
                DB::table('applegreen_codes')->insert([
                    'id' => $membership_id,
                    'applegreen_code' => 'APL-' . $random_code
                ]);
                $membership_id++;
            }
        }
    }
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
            $memberships[] = Membership::getMembership($membership);

        }

        // var_dump($memberships);exit;
        return $memberships;
    }

    public function register(CouponDataModel $coupon_data_model)
    {

        Eloquent::unguard();


        return  PromotionalCodes::create([
            'name' => $coupon_data_model->name,
            'code' => $coupon_data_model->code,
            'type' => $coupon_data_model->discount,
            'discount' => $coupon_data_model->discount,
            'logged' => $coupon_data_model->logged,
            'total' => $coupon_data_model->total,
            'date_start' => $coupon_data_model->date_start,
            'date_end' => $coupon_data_model->date_end,
            'uses_total' => $coupon_data_model->uses_total,
            'uses_customer' => $coupon_data_model->uses_customer,
            'status' => $coupon_data_model->status,
            'date_added' => $coupon_data_model->date_added
        ]);



    }

}

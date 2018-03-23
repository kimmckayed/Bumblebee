<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

class Customer extends Eloquent
{
    use SoftDeletes;

    protected $table = 'customers';
    public  $timestamps= true;
    protected $dates = ['deleted_at','created_at','updated_at','start_date','expiration_date'];
    protected $guarded = ['id'];

    public function vehicle()
    {
        return $this->hasOne('App\Models\Vehicle', 'id', 'vehicle_id');
    }

    public function adder()
    {
        return $this->hasOne('App\Models\User', 'id', 'added_by');
    }
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function membership()
    {
        return $this->hasOne('App\Models\Membership', 'id', 'membership')->withTrashed();
    }
    public function membership_detail()
    {
        return $this->hasOne('App\Models\Membership', 'id', 'membership')->withTrashed();
    }

    public function company()
    {
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }

    public function getMemberships()
    {
        $memberships = Membership::getMemberships();

        return $memberships;
    }

    public function getCustomersByAgent($id)
    {
        $customers = Customer::where('added_by', '=', $id)->get();

        return $customers;
    }

    public function getInfo($account_id)
    {
        $account = DB::table('customers')->join('memberships', 'customers.membership', '=',
            'memberships.id')->where('customers.id', '=', $account_id)->first();

        return $account;

    }

    public function dueRenewal($company_id = null, $agent_login_id = null)
    {

        $number = 0;
        // $today = date('Y-m-d',time());
        // var_dump($today);exit;

        //$range = DB::select(DB::raw('SELECT value FROM settings where id = 1'));
        //$range = $range[0]['value'];
        //$range = intval($range) * (24 * 60 * 60); //Range in days

        // $number = DB::table('customers')->where(DB::raw('UNIX_TIMESTAMP(expiration_date) as expiry_date'),'>', )->count();
        $range = \App\Models\Settings::find(1);
        $today = Carbon::now()->toDateTimeString();
        $due_renewal_date = Carbon::now()->addDays($range->value)->toDateTimeString();
        $number = $this->whereBetween('expiration_date',[$today,$due_renewal_date]);
        if (!empty($company_id)) {
            //$number = DB::select(DB::raw('SELECT * FROM customers WHERE company_id = ' . $company_id . ' AND (UNIX_TIMESTAMP(expiration_date) - ' . $range . ') < ' . time()));
            $number->where('company_id','=',$company_id);
        } elseif (!empty($agent_login_id)) {
            //$number = DB::select(DB::raw('SELECT * FROM customers WHERE added_by = ' . $agent_login_id . ' AND (UNIX_TIMESTAMP(expiration_date) - ' . $range . ') < ' . time()));
            $number->where('added_by','=',$agent_login_id);
        } else {
            //$number = DB::select(DB::raw('SELECT * FROM customers WHERE (UNIX_TIMESTAMP(expiration_date) - ' . $range . ') < ' . time()));
        }

        // var_dump(date('Y-m-d'));exit;
        // $number = DB::table('customers')->where(DB::raw('DATE(`expiration_date`)'),'>',date('Y-m-d'))->count();
        // var_dump($number);exit;
        // $active_customers = DB::table('customers')->where(DB::raw('UNIX_TIMESTAMP(expiration_date)'),'>', time())->get();
        // var_dump(count($number));exit;

        return count($number->get());

    }

    public function activeCustomers($company_id = null, $agent_login_id = null)
    {

        $number = 0;
        // $today = date('Y-m-d',time());
        // var_dump($today);exit;
        if (!empty($company_id)) {
            $number = $this->where('company_id', '=',
                $company_id)->where(DB::raw('UNIX_TIMESTAMP(expiration_date)'), '>', time())->count();
        } elseif (!empty($agent_login_id)) {
            $number = $this->where('added_by', '=',
                $agent_login_id)->where(DB::raw('UNIX_TIMESTAMP(expiration_date)'), '>', time())->count();
        } else {
            $number = $this->where(DB::raw('UNIX_TIMESTAMP(expiration_date)'), '>', time())->count();
        }

        // var_dump(date('Y-m-d'));exit;
        // $number = DB::table('customers')->where(DB::raw('DATE(`expiration_date`)'),'>',date('Y-m-d'))->count();
        // var_dump($number);exit;
        // $active_customers = DB::table('customers')->where(DB::raw('UNIX_TIMESTAMP(expiration_date)'),'>', time())->get();
        // var_dump($active_customers);exit;

        return $number;

    }

    public function activeCustomersValue($company_id = null, $agent_login_id = null)
    {

        $value = 0;
        // $today = date('Y-m-d',time());
        // var_dump($today);exit;
        // $number = DB::table('customers')->where(DB::raw('UNIX_TIMESTAMP(expiration_date)'),'>', time())->count();

        // var_dump(date('Y-m-d'));exit;
        if (!empty($company_id)) {
            $value = $this->join('memberships', 'customers.membership', '=',
                'memberships.id')->where('customers.company_id', '=',
                $company_id)->where(DB::raw('UNIX_TIMESTAMP(customers.expiration_date)'), '>',
                time())->sum('memberships.price');
        } elseif (!empty($agent_login_id)) {
            $value = $this->join('memberships', 'customers.membership', '=',
                'memberships.id')->where('customers.added_by', '=',
                $agent_login_id)->where(DB::raw('UNIX_TIMESTAMP(customers.expiration_date)'), '>',
                time())->sum('memberships.price');
        } else {
            $value = $this->join('memberships', 'customers.membership', '=',
                'memberships.id')->whereRaw('customers.expiration_date > now()')->sum('memberships.price');
        }
        return $value;

    }
    
    public function totalCustomersValue($company_id = null, $agent_login_id = null)
    {
        $value = 0;
        if (!empty($company_id)) {
            $value = DB::table('customers')->join('memberships', 'customers.membership', '=',
                'memberships.id')->where('customers.company_id', '=',
                $company_id)->sum('memberships.price');
        } elseif (!empty($agent_login_id)) {
            $value = DB::table('customers')->join('memberships', 'customers.membership', '=',
                'memberships.id')->where('customers.added_by', '=',
                $agent_login_id)->sum('memberships.price');
        } else {
            $value = DB::table('customers')->join('memberships', 'customers.membership', '=',
                'memberships.id')->sum('memberships.price');
        }
        return $value;
    }
    
    public function customersValueByCompany(){
        $values_array = DB::table('customers')->join('memberships', 'customers.membership', '=',
                'memberships.id')->join('company_accounts', 'customers.company_id', '=',
                'company_accounts.id')->select('company_accounts.name as name',
                DB::raw('SUM(memberships.price) as sum'))
                ->groupBy('customers.company_id')->orderBy('sum', 'desc')->limit('5')->get();
        /*        DB::raw("SELECT company_accounts.name , SUM(memberships.price) as sum"
                . " FROM `customers` JOIN `memberships` JOIN `company_accounts`"
                . " ON customers.membership = memberships.id"
                . " AND customers.company_id = company_accounts.id"
                . " GROUP BY customers.company_id ORDER BY `sum` DESC ")->getValue();*/
        return $values_array;
    }

    public function expiredCustomers($company_id = null, $agent_login_id = null)
    {

        $number = 0;
        // $today = date('Y-m-d',time());
        // var_dump($today);exit;
        // $number = DB::table('customers')->where(DB::raw('UNIX_TIMESTAMP(expiration_date)'),'>', time())->count();

        // var_dump(date('Y-m-d'));exit;
        if (!empty($company_id)) {
            $number = $this->where('company_id', '=',
                $company_id)->where(DB::raw('DATE(`expiration_date`)'), '<', date('Y-m-d'))->count();
        } elseif (!empty($agent_login_id)) {
            $number = $this->where('added_by', '=',
                $agent_login_id)->where(DB::raw('DATE(`expiration_date`)'), '<', date('Y-m-d'))->count();
        } else {
            $number = $this->where(DB::raw('DATE(`expiration_date`)'), '<', date('Y-m-d'))->count();
        }
        // var_dump($number);exit;
        // $active_customers = DB::table('customers')->where(DB::raw('UNIX_TIMESTAMP(expiration_date)'),'>', time())->get();
        // var_dump($active_customers);exit;

        return $number;
    }

    public function certificateDone($member_id)
    {

        $affectedRows = Customer::where('id', '=', $member_id)->update(['certificate' => 1]);

    }
 public function welcomePackSent($member_id)
    {

        $affectedRows = Customer::where('id', '=', $member_id)->update(['welcome_pack' => 1]);

    }
    public function checkMemberCompleted($member_id)
    {
           
        $c = Customer::find($member_id);
        if (!is_null($c->accept_terms) && $c->certificate && $c->welcome_pack){
            return true;
        }else{
            return false;
        }
    }
    public function memberCompleted($member_id)
    {
           
        $affectedRows = Customer::where('id', '=', $member_id)->update(['completed' => 1]);

    }

    public function expiredCustomersValue($company_id = null, $agent_login_id = null)
    {

        $value = 0;
        // $today = date('Y-m-d',time());
        // var_dump($today);exit;
        // $number = DB::table('customers')->where(DB::raw('UNIX_TIMESTAMP(expiration_date)'),'>', time())->count();

        // var_dump(date('Y-m-d'));exit;
        if (!empty($company_id)) {
            $value = $this->join('memberships', 'customers.membership', '=',
                'memberships.id')->where('customers.company_id', '=',
                $company_id)->where(DB::raw('UNIX_TIMESTAMP(customers.expiration_date)'), '<',
                time())->sum('memberships.price');
        } elseif (!empty($agent_login_id)) {
            $value = $this->join('memberships', 'customers.membership', '=',
                'memberships.id')->where('customers.added_by', '=',
                $agent_login_id)->where(DB::raw('UNIX_TIMESTAMP(customers.expiration_date)'), '<',
                time())->sum('memberships.price');
        } else {
            $value = $this->join('memberships', 'customers.membership', '=',
                'memberships.id')->where(DB::raw('UNIX_TIMESTAMP(customers.expiration_date)'), '<',
                time())->sum('memberships.price');
        }
        // $value = DB::table('customers')->join('memberships', 'customers.membership', '=', 'memberships.id')->where(DB::raw('UNIX_TIMESTAMP(customers.expiration_date)'),'>', time())->get();
        // var_dump($number);exit;
        // $active_customers = DB::table('customers')->where(DB::raw('UNIX_TIMESTAMP(expiration_date)'),'>', time())->get();
        return $value;

    }

    /**
     * @param $company
     * @param $title
     * @param $first_name
     * @param $last_name
     * @param $email
     * @param $address_line_1
     * @param $address_line_2
     * @param $town
     * @param $county
     * @param $postal_code
     * @param $phone_number
     * @param $nok_phone_number
     * @param $vehicle_registration
     * @param $odometer_reading
     * @param $odometer_type
     * @param $membership
     * @param $start_date
     * @param $membership_expiration
     * @param $added_by
     * @param $vehicle_id
     * @param $user_id
     * @return array
     * @deprecated
     */
    public function register(
        $company,
        $title,
        $first_name,
        $last_name,
        $email,
        $address_line_1,
        $address_line_2,
        $town,
        $county,
        $postal_code,
        $phone_number,
        $nok_phone_number,
        $vehicle_registration,
        $odometer_reading,
        $odometer_type,
        $membership,
        $start_date,
        $membership_expiration,
        $added_by,
        $vehicle_id,
    $user_id
    ) {

        $result = array();




        if (is_int($user_id) === true) {
            $result['error'] = 0;
            $result['message'] = 'User inserted';
            $result['customer_id'] = $user_id;
        } else {
            $result['error'] = 1;
            $result['message'] = 'User not inserted';
            $result['customer_id'] = 0;
        }


        return $result;
    }

    public function newMemberships()
    {

        $week = time() - (7 * 24 * 60 * 60);
        $number = Customer::with('membership')->where('start_date', '>',
            $week)->where('completed', '=', 0)->count();

        return $number;

    }

    public function getVehicleIDs()
    {

        $vehicle_ids = Customer::select('vehicle_registration')->get()->toArray();
        $ids = array();
        foreach ($vehicle_ids as $key => $vehicle_id) {

            /*$vehicle_ids[$key];*/
            $ids[] = $vehicle_ids[$key]['vehicle_registration'];

        }

        return $ids;

    }
    /*public function checkApplgreencode($code) {
        $result = array();
        $count = DB::table('applegreen_codes')->where('applegreen_code',$code)->count();
        if($count > 0) {
            $result['error'] = 0;
            $result['message'] = 'Found';
        } else {
            $result['error'] = 1;
            $result['message'] = 'Not found';
        }

        return $result;

    }

    public function autogenerate_codes() {
        $membership_id = 1;
        while($membership_id <= 10000) {

            $random_code = rand(1000000000,9999999999);
            $count = DB::table('applegreen_codes')->where('applegreen_code',$random_code)->count();
            if($count === 0) {
                DB::table('applegreen_codes')->insert(['id'=>$membership_id,'applegreen_code'=>'APL-'.$random_code]);
                $membership_id++;
            }
        }
    }*/

    /*	public function register_with_cd($company,$title,$first_name,$last_name,$email,$home_address,$phone_number,$nok_phone_number,$vehicle_registration,$odometer_reading,$odometer_type,$membership,$start_date,$cd_first_name,$cd_last_name,$cd_number,$security_code,$expiration_date,$added_by) {

            /*$users = DB::table('users')->where('username', '=', $username)->where('account_type','=',1)->count();

            if($users === 0) {
                if($password === $password_confirmation) {
                    $account_id = DB::table('master_accounts')->insertGetId(['first_name' => $first_name, 'last_name' => $last_name, 'department'=>$department]);*/
    // $cd_info_id = DB::table('credit_card_info')->insertGetId(['first_name' => $cd_first_name, 'last_name' => $cd_last_name, 'cd_number' => $cd_number, 'security_code' => $security_code, 'expiration_date' => $expiration_date]);
    // DB::table('customers')->insert(['company_id'=> $company ,'title' => $title, 'first_name' => $first_name, 'last_name'=> $last_name, 'email'=> $email, 'address'=> $home_address, 'phone_number'=> $phone_number, 'nok_phone_number'=> $nok_phone_number, 'vehicle_registration'=> $vehicle_registration, 'odometer_reading'=> $odometer_reading, 'odometer_type'=> $odometer_type, 'membership'=> $membership, 'start_date'=>$start_date, 'expiration_date'=>$membership_expiration, 'cd_info'=> $cd_info_id, 'added_by'=> $added_by]);
    // DB::insert('insert into users (username, password, account_type, account_id, created_at) values (?, ?)', [$username, $password, 1, $account_id,time()]);
    /*}
}*/

    // }

    public function scopeMembershipsearch($query, $membership_id)
    {

        return $query->where('membership_id', 'like', "%$membership_id%");

    }

    public function scopeVehiclesearch($query, $vehicle_registration)
    {

        return $query->where('vehicle_registration', 'like', "%$vehicle_registration%");

    }

    public function scopeSearchfrom($query, $from)
    {
        $from = strtotime($from);

        return $query->where('expiration_date', '>', $from);

    }

    public function scopeSearchto($query, $to)
    {
        $to = strtotime($to);

        return $query->where('expiration_date', '<', $to);

    }

    public function fleetMember()
    {
        return $this->belongsTo('App\Models\FleetMember', 'id', 'member_id');
    }
}
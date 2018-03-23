<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Company extends Eloquent
{

    protected $table = 'company_accounts';
    public $timestamps = false;

    public static function getCompanies()
    {
        $companies = Company::all();

        return $companies;
    }

    public function poc()
    {
        return $this->hasManyThrough('App\Models\CompanyPOC', 'App\Models\PocToCompany', 'company_id', 'id');
    }

    public function company_poc()
    {
        return $this->hasOne('App\Models\CompanyPOC', 'id', 'main_poc');
    }

    public function accounts_poc()
    {
        return $this->hasOne('App\Models\CompanyPOC', 'id', 'accounts_poc');
    }

    public function companyPaymentMethods()
    {
        return $this->hasOne('App\Models\CompanyPaymentMethod', 'id', 'company_id');
    }

    public function agents()
    {
        return $this->hasMany('App\Models\Company', 'id', 'company_id');
    }

    public function memberships()
    {
        return $this->hasOne('App\Models\Membership', 'id', 'memberships');
    }

    public function activeCompanies()
    {
        $number = Company::where('status', '=', 1)->whereNotIn('name',['cartow'])->count();
        return $number;
    }

    public function getInfo($account_id)
    {

        // $account = Company::where('id', '=',$account_id);
        $account = DB::table('company_accounts')->where('id', '=', $account_id)->get();

        return $account;

    }

    public function companiesReport()
    {

        $result = array();

        $min = 365 * (24 * 60 * 60);

        $min = time() - $min;
        $max = time();

        $query = DB::table('company_accounts')->join('customers', 'customers.company_id', '=',
            'company_accounts.id')->join('memberships', 'customers.membership', '=',
            'memberships.id')->where('start_date', '>', $min)->where('start_date', '<',
            $max)->groupBy('company_id')->sum('memberships.price');

        // var_dump($query);exit;

        return $result;

    }

    public function getStatuses()
    {
        $statuses = Status::getStatuses();

        return $statuses;
    }

    public function getMemberships()
    {
        $memberships = Membership::getMemberships();

        return $memberships;
    }

    public function add(

        $code,
        $company_name,
        $website,
        $address,
        $memberships_json,
        $added_by,
        $main_poc_id,
        $accounts_poc_id,
        $status = 0
    ) {

        $result = array();


        $account_id = DB::table('company_accounts')->insertGetId([
            'code' => $code,
            'name' => $company_name,
            'website' => $website,
            'address' => $address,
            'main_poc' => $main_poc_id,
            'accounts_poc' => $accounts_poc_id,
            'memberships' => $memberships_json,
            'added_by' => $added_by,
            'status' => $status
        ]);

        if ($account_id) {
            $result['error'] = 0;
            $result['account_id'] = $account_id;
            $result['message'] = 'User inserted';
        } else {
            $result['error'] = 1;
            $result['message'] = 'User not inserted';
        }


        return $result;

    }

    public function deleteCompanyAccount($account_id)
    {
        /*if(!empty($account_id)) {
            var_dump($account_id);exit;
        }*/
        $result = array('error' => '', 'message' => '');

        if (!empty($account_id)) {
            $query = DB::table('company_accounts')->where('id', '=', $account_id)->delete();

            if ($query === true) {
                $result['error'] = 0;
                $result['message'] = 'Company Deleted';
            } else {
                $result['error'] = 1;
                $result['message'] = 'Deletion Failed';
            }
        }

    }

    public function deleteCompanyAgents($account_id)
    {

        $agents_ids = DB::table('agent_accounts')->select('id')->where('company_id', '=', $account_id)->get();
        // var_dump($agents_ids[0]);exit;
        $a = new Agent();
        $u = new User();

        foreach ($agents_ids as $agent) {
            $id = $agent['id'];
            $a->deleteAgentAccount($id);
            $u->deleteUserAccount($id, 4);
        }
    }

    public function updateMemberships($company_id, $json_string)
    {

        $query = DB::table('company_accounts')->where('id', '=',
            $company_id)->update(array('memberships' => $json_string));

        // var_dump($query);exit;
        return true;

    }

}
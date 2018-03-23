<?php namespace App\DataModels;

use Auth;
use Illuminate\Http\Request;

class CompanyDataModel
{
    public $username;
    public $password;
    public $code;
    public $company_name;
    public $website;
    public $address;
    public $poc_name;
    public $poc_email;
    public $poc_number;
    public $poc_name_2;
    public $poc_email_2;
    public $poc_number_2;
    public $company_status;
    public $memberships_json;
    public $payment_method;
    public $payment_method_check;
    public $added_by;
    /**
     * @var AgentDataModel
     */
    public $agent_data_model;

    /**
     * @param Request $request
     * @param array $extra_info
     */
    public function __construct(Request $request,array $extra_info=[])
    {
        $this->username = $request->get('username');
        $this->password = $request->get('password');
        $this->code = $request->get('code');
        $this->company_name = $request->get('company_name');
        $this->website = $request->get('website');
        $this->address = $request->get('address');
        $this->poc_name = $request->get('poc_name');
        $this->poc_email = $request->get('poc_email');
        $this->poc_number = $request->get('poc_number');
        $this->poc_name_2 = $request->get('poc_name_2');
        $this->poc_email_2 = $request->get('poc_email_2');
        $this->poc_number_2 = $request->get('poc_number_2');
        $this->company_status = $request->get('company_status');
        $this->memberships_json = '[]';
        $this->memberships = $request->get('memberships');
        if (is_array($this->memberships)) {
            $this->memberships_json = json_encode($this->memberships);
        }
        $this->payment_method = $request->get('payment_method');
        $this->payment_method_check = $request->get('payment_method_check',1);



        /**
         * TODO remove added by from here
         * D of logged in user
         */
        $this->agent_data_model=  new AgentDataModel($request,$extra_info);
        $this->added_by = Auth::user()->id;


    }

}
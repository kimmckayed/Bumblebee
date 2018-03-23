<?php namespace App\DataModels;

use Illuminate\Http\Request;

class AgentDataModel
{
    public $phone_number;
    public $user_id;
    public $company_id;
    public $added_by;
    /**
     * @var UserDataModel
     */
    public $user_data_model;
    public function __construct(Request $request,array $extra_info=[])
    {
        $this->phone_number = $request->get('agent_phone_number');
        $this->user_id = $request->get('user_id');
        $this->company_id = $request->get('company_id');
        $this->added_by = $request->get('added_by');
        $this->user_data_model=  new UserDataModel($request,$extra_info);
    }
}
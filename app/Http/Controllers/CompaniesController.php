<?php

namespace App\Http\Controllers;

use App\DataModels\CompanyDataModel;


use App\Managers\AuthManager;
use App\Managers\RegistrationManager;
use App\Models\Agent;
use App\Models\Company;
use App\Models\CompanyPOC;
use App\Models\PocToCompany;
use App\Models\User;


use Illuminate\Http\Request;
use Input;
use Redirect;

use Validator;
use Flash;
use DataEdit;

class CompaniesController extends Controller
{

    public function getRegister()
    {
        $company = new Company();
        $statuses = $company->getStatuses();
        $memberships = $company->getMemberships();
        $registration = 'company';
        $type = '';

        return view('company.register', array(
            'registration' => $registration,
            'statuses' => $statuses,
            'memberships' => $memberships,
            'logged_in' => $type,

        ));

    }

    public function postRegister(Request $request)
    {

        if (($validation_message_bag = $this->validateForm()) !== true) {
            return redirect()->back()->withErrors($validation_message_bag)->withInput();
        }

        $company_data_model = new CompanyDataModel($request);

        $company_manager = new RegistrationManager();
        $company_manager->createCompany($company_data_model);
        Flash::success("A company account for {$company_data_model->company_name} was created successfully");

        return Redirect::route('register_customer_view');

    }

    public function  postAddPoc(Request $request)
    {

        if (($validation_message_bag = $this->validatePocForm()) !== true) {
            Flash::warning('Form Validation Error');

            return redirect()->back()->withErrors($validation_message_bag)->withInput();
        }


        $poc = new CompanyPOC();
        $poc->name = $request->get('name');
        $poc->email = $request->get('email');;
        $poc->phone_number = $request->get('number');
        $poc->save();


        $poc_to_company = new PocToCompany();
        $poc_to_company->poc_id = $poc->id;
        $poc_to_company->company_id = $request->get('company_id');
        $poc_to_company->save();


        Flash::success('Poc added successfully');

        return redirect()->back();

    }

    public function  getActivate($company_id)
    {

        if ((new AuthManager())->isAnyRole(['finance', 'master'])) {

            Company::whereId($company_id)->whereStatus(0)->update(['status' => '1']);
            $user_id =  Agent::where('company_id','=',$company_id)->pluck('user_id');
            User::whereId($user_id)->update(['status'=>'1']);
        }
        Flash::success('activated successfully');

        return redirect()->back();

    }

    public function anyManage()
    {
        $company_id = (!empty(Input::get('modify'))) ? Input::get('modify') : ((!empty(Input::get('show'))) ? Input::get('show') : null);

        $delete_id = Input::get('do_delete');
        if (!empty($delete_id)) {
            $user_repository = new User();
            $response = $user_repository->deleteUserAccount($delete_id, 3);

            if ($response) {
                return 'Couldn\'t delete user';
            }

        }

        $edit = DataEdit::source(new Company())->attributes(['id'=>"customerEditForm"]);
        // $edit->label('Edit Membership');
        if($company_id != NULL )
            $edit->link(url("user/edit/company?delete=$company_id"), 'DELETE', 'TR', 
            ['class' => 'btn btn-danger']);
        if ((new AuthManager())->isAnyRole([
                'finance',
                'master'
            ]) && Company::whereId($company_id)->whereStatus(0)->pluck('id')
        ) {
            $edit->link(url("company/activate/$company_id"), 'Activate', 'TR',
                ['class' => 'btn btn-primary pull-left']);
        }

        $edit->text('code', 'Code<span class="orange-header">*</span>')->rule('required');
        $edit->text('name', 'Name<span class="orange-header">*</span>')->rule('required');
        $edit->text('website', 'Website');
        $edit->text('address', 'Address');

        $edit->text('company_poc.name', 'contact\'s name');
        $edit->text('company_poc.email', 'Contact\'s email<span class="orange-header">*</span>')->rule('required|email');
        $edit->text('company_poc.phone_number', 'contact\'s phone');

        $edit->text('accounts_poc.name', 'Accountant\'s name');
        $edit->text('accounts_poc.email', 'Accountant\'s email');
        $edit->text('accounts_poc.phone_number', 'Accountant\'s phone');
        $company = Company::find($company_id);
        $list_of_poc = [];
        if (isset($company)) {
            $list_of_poc = $company->poc;
        }


        return $edit->view('company.manage', compact('edit', 'company_id', 'list_of_poc'));
    }

    private function validateForm()
    {

        $validator = Validator::make(Input::all(), [
            'code' => 'required',
            'company_name' => 'required',
            'memberships' => 'required',
            'payment_method' => 'required',
            'username' => 'required|unique:users',
            'poc_email'=> 'required|email|unique:users,email'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }

    private function validatePocForm()
    {

        $validator = Validator::make(Input::all(), [
            'company_id' => 'required',
            'name' => 'required',
            'email' => 'email'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }

}

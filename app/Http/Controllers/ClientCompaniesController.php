<?php

namespace App\Http\Controllers;

use App\Managers\AuthManager;
use App\Models\ClientCompany;
use App\Models\Tax;
use App\Models\Toll;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Validator;
use Flash;
use DataEdit;
use DataGrid;

class ClientCompaniesController extends Controller
{
    public function getIndex(){
        $grid = DataGrid::source(new ClientCompany());
        $grid->add('name', 'Name');
        $grid->add('maximum_allowance', 'Maximum allowance');
        $grid->edit(url('/client-company/edit'), 'Edit', 'show|modify')->style('width:60px;');

        return view('client-company.manage',['grid'=>$grid]);
    }

    public function getSingle($name) {
        $client_company = ClientCompany::where('name','=',$name)->first();
        return json_encode($client_company);
    }

    public function getRegister()
    {
        return view('client-company.register');
    }

    public function postRegister(Request $request)
    {
        if (($validation_message_bag = $this->validateForm()) !== true) {
            return redirect()->back()->withErrors($validation_message_bag)->withInput();
        }

        $client_company = new ClientCompany();
        $client_company->name = $request->get('name');
        $client_company->maximum_allowance = $request->get('maximum_allowance');
        $client_company->additional_value = $request->get('additional_value');
        $client_company->covered = $request->get('covered');
        $client_company->call_out_value = ($request->get('call_out_value')==null || $request->get('call_out_value')=='')? '0' : $request->get('call_out_value');
        $client_company->additional_tolls = ($request->get('additional_tolls')==null)? '0' : $request->get('additional_tolls');
        $client_company->bringg_id = ($request->get('bringg_id')==null||$request->get('bringg_id')=='')? '8380' : $request->get('bringg_id');
        $client_company->distance_unit = $request->get('distance_unit');
        $client_company->save();

        Flash::success("A client company account for {$client_company->name} was created successfully");

        return redirect::to(url('client-company'));
    }

    public function anyEdit()
    {
        $company_id = (Input::get('modify')) ? Input::get('modify') : (Input::get('show')) ? Input::get('show') : null;

        /*$delete_id = Input::get('do_delete');
        if (!empty($delete_id)) {
            $client_company = ClientCompany::find($delete_id);
            if($client_company != null) {
                $client_company->delete();
            }
        }*/

        $edit = DataEdit::source(new ClientCompany())->attributes(['id'=>"customerEditForm"]);
        if($company_id != NULL )
            $edit->link(url("client-company/edit/?delete=$company_id"), 'DELETE', 'TR',
            ['class' => 'btn btn-danger']);

        $edit->text('name', 'Name<span class="orange-header">*</span>')->rule('required');
        $edit->text('maximum_allowance', 'Maximum allowance (in distance unit)');
        $edit->text('additional_value', 'Additional value per extra distance unit');
        $edit->add('covered', 'Covered', 'radiogroup')->options(['0'=>'no','1'=>'yes']);
        $edit->text('call_out_value', 'Call out value');
        $edit->add('additional_tolls', 'Additional tolls accepted', 'radiogroup')->options(['0'=>'no','1'=>'yes']);
        $edit->text('bringg_id', 'Bringg tag ID');
        $edit->add('distance_unit', 'Unit of distance', 'select')->options(['km'=>'Kilometers','m'=>'Miles']);

        return $edit->view('client-company.manage', compact('edit', 'company_id'));
    }

    private function validateForm()
    {
        $validator = Validator::make(Input::all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        return true;
    }

    public function getTaxIndex() {
        $grid = DataGrid::source(new Tax());
        $grid->add('name', 'Name');
        $grid->add('value', 'Value (%)');
        $grid->edit(url('/tax/edit'), 'Edit', 'show|modify')->style('width:60px;');

        return view('client-company.tax-manage',['grid'=>$grid]);
    }

    public function getTaxAdd()
    {
        return view('client-company.tax-add');
    }

    public function postTaxAdd(Request $request)
    {
        if (($validation_message_bag = $this->validateTaxForm()) !== true) {
            return redirect()->back()->withErrors($validation_message_bag)->withInput();
        }

        $tax = new Tax();
        $tax->name = $request->get('name');
        $tax->value = $request->get('value');
        $tax->save();

        Flash::success("The tax {$tax->name} was created successfully");

        return redirect::to(url('tax'));
    }

    private function validateTaxForm()
    {
        $validator = Validator::make(Input::all(), [
            'name' => 'required',
            'value' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        return true;
    }

    public function anyTaxEdit()
    {
        $tax_id = (Input::get('modify')) ? Input::get('modify') : (Input::get('show')) ? Input::get('show') : null;

        $edit = DataEdit::source(new Tax())->attributes(['id'=>"customerEditForm"]);
        if($tax_id != NULL )
            $edit->link(url("tax/edit/?delete=$tax_id"), 'DELETE', 'TR',
                ['class' => 'btn btn-danger']);

        $edit->text('name', 'Name<span class="orange-header">*</span>')->rule('required');
        $edit->text('value', 'Value<span class="orange-header">*</span>')->rule('required');

        return $edit->view('client-company.tax-manage', compact('edit', 'tax_id'));
    }

    public function getTollIndex() {
        $grid = DataGrid::source(new Toll());
        $grid->add('name', 'Name');
        $grid->add('cost', 'Cost');
        $grid->edit(url('/toll/edit'), 'Edit', 'show|modify')->style('width:60px;');

        return view('client-company.toll-manage',['grid'=>$grid]);
    }

    public function getTollAdd()
    {
        $taxes = Tax::all();
        return view('client-company.toll-add',['taxes'=>$taxes]);
    }

    public function postTollAdd(Request $request)
    {
        if (($validation_message_bag = $this->validateTollForm()) !== true) {
            return redirect()->back()->withErrors($validation_message_bag)->withInput();
        }

        $toll = new Toll();
        $toll->name = $request->get('name');
        $toll->cost = $request->get('cost');
        $toll->tax = $request->get('tax');
        $toll->save();

        Flash::success("The toll {$toll->name} was created successfully");

        return redirect::to(url('toll'));
    }

    private function validateTollForm()
    {
        $validator = Validator::make(Input::all(), [
            'name' => 'required',
            'cost' => 'required',
            'tax' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        return true;
    }

    public function anyTollEdit()
    {
        $toll_id = (Input::get('modify')) ? Input::get('modify') : (Input::get('show')) ? Input::get('show') : null;

        $edit = DataEdit::source(new Toll())->attributes(['id'=>"customerEditForm"]);
        if($toll_id != NULL )
            $edit->link(url("toll/edit/?delete=$toll_id"), 'DELETE', 'TR',
                ['class' => 'btn btn-danger']);

        $edit->text('name', 'Name<span class="orange-header">*</span>')->rule('required');
        $edit->text('cost', 'Cost<span class="orange-header">*</span>')->rule('required');
        $edit->add('tax', 'Tax<span class="orange-header">*</span>','select')->options(Tax::lists('name','id'))->rule('required');

        return $edit->view('client-company.toll-manage', compact('edit', 'tax_id'));
    }
}

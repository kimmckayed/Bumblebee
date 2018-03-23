<?php
namespace App\Http\Controllers;


use App\Models\Agent;
use App\Models\Company;
use DataGrid;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Enums\AccountTypes;

class AgentsController extends Controller {

    public function index(){
        $current_user = \Auth::user();
        if(!$current_user) {
            return redirect()->back()->withErrors('There is no user currently logged in');
        }
        $current_agent = Agent::where('user_id','=',$current_user->id)->first();
        if(!$current_agent) {
            return redirect()->back()->withErrors('This user doesn\'t have an agent account');
        }
        $company_id = $current_agent->company_id;
        $company = Company::find($company_id);
        if(!$company) {
            return redirect()->back()->withErrors('This agent doesn\'t belong to a company');
        }
        $agents = null;
        if($company->name = 'cartow') {
            $agents = Agent::with('type', 'company', 'role', 'user')->join('users', 'users.id', '=',
                'agent_accounts.user_id')->where('users.account_type', '=', 4)->where('users.status', '=',1)
                ->orderBy('company_id');
        } else {
            $agents = Agent::with('type', 'company', 'role', 'user')->join('users', 'users.id', '=',
                'agent_accounts.user_id')->where('users.account_type', '=', 4)->where('users.status', '=',1)
                ->where('agent_accounts.company_id', '=', $company_id);
        }
        $grid = DataGrid::source($agents);

        $grid = $this->getFieldsForGrid($grid);

        return view('home.master.companyagents', compact('grid'));
    }

    private function getFieldsForGrid(\Zofe\Rapyd\DataGrid\DataGrid $grid)
    {
        $grid->add('{{$first_name}} {{$last_name}}', 'Full Name');
        $grid->add('phone_number', 'Phone Number');
        $grid->add('user.email', 'Email');
        $grid->add('company.name', 'Company');
        $grid->add('role.role_id', 'Role');
        $grid->row(function ($row) {
            $row->cell('role.role_id')->value = Role::getRoleNameById($row->cell('role.role_id')->value);
        });

        return $grid;
    }
}

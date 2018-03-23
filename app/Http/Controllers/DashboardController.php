<?php

namespace App\Http\Controllers;

use App\Managers\AuthManager;
use Auth;
use App\Models\Agent;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Master;
use App\Models\Membership;
use App\Models\Notification;
use App\Models\Settings;
use App\Models\Subuser;
use App\Models\User;
use Sentinel;

class DashboardController extends Controller
{
    public function getDashboard()
    {
        $permissions = new AuthManager();
        $widgets = [];

        $user_model = Auth::user();
        $company_id = null;
        $agent_id = null;
        if ($permissions->isAnyRole(['company_master','company_agent'])) {
            $agent_account = Agent::where('user_id','=',$user_model->id)->first();
            if(!$agent_account) {
                Auth::logout();
                Sentinel::logout();
                return \Redirect::to('auth/login')->withErrors('This user does not have an associated account');
            }
            $company_id = $agent_account->company_id;
        }
        if($permissions->isAnyRole(['company_agent'])){
            $agent_id = $user_model->id;
        }

        if ($permissions->hasAccess(['widgets.top.cartow_users'])) {
            try{
                $cartow_users = $user_model->myCompanyCartowUsers();
                $widgets['top']['cartow_users'] = ['value' => $cartow_users];
            }catch (\Exception $e){
                Auth::logout();
                Sentinel::logout();
                return \Redirect::to('auth/login');
            }
        }

        if ($permissions->hasAccess(['widgets.top.active_companies'])) {
            $com = new Company();
            $active_companies = $com->activeCompanies();
            $widgets['top']['active_companies'] = ['value' => $active_companies];
        }

        $customer_model = new Customer();

        if ($permissions->hasAccess(['widgets.top.active_memberships'])) {
            $active_memberships = $customer_model->activeCustomers($company_id,$agent_id);
            $widgets['top']['active_memberships'] = ['value' => $active_memberships];
        }

        if ($permissions->hasAccess(['widgets.top.active_memberships_value'])) {
            $active_memberships_value = $customer_model->activeCustomersValue($company_id,$agent_id);
            $active_memberships_value_net = ($active_memberships_value * 100) / 123;
            //$active_memberships_value_vat = $active_memberships_value - $active_memberships_value_net;
            $widgets['top']['active_memberships_value'] = ['value' => floor($active_memberships_value_net)];
        }

        if ($permissions->hasAccess(['widgets.top.expired_memberships'])) {
            $expired_memberships = $customer_model->expiredCustomers($company_id,$agent_id);
            $widgets['top']['expired_memberships'] = ['value' => $expired_memberships];
        }

        if ($permissions->hasAccess(['widgets.top.expired_memberships_value'])) {
            $expired_memberships_value = $customer_model->expiredCustomersValue($company_id,$agent_id);
            $expired_memberships_value_net = ($expired_memberships_value * 100) / 123;
            //$expired_memberships_value_vat = $expired_memberships_value - $expired_memberships_value_net;
            $widgets['top']['expired_memberships_value'] = ['value' => floor($expired_memberships_value_net)];
        }

        if ($permissions->hasAccess(['widgets.top.due_renewal'])) {
            $due_renewal = $customer_model->dueRenewal($company_id,$agent_id);
            $widgets['top']['due_renewal'] = ['value' => $due_renewal];
        }

        if ($permissions->hasAccess(['widgets.top.active_agents'])) {
            $active_agents = (new Agent())->activeAgents($company_id);
            $widgets['top']['active_agents'] = ['value' => $active_agents];
        }
        $total_memberships_value = $customer_model->totalCustomersValue($company_id,$agent_id);
        
        if ($permissions->hasAccess(['widgets.middle.company_activities'])) {
                $memberships_value_by_company = $customer_model->customersValueByCompany();
                $widgets['middle']['company_activities'] = ['companies_total'=>$total_memberships_value,
                'companies' => $memberships_value_by_company];
        }
        if ($permissions->hasAccess(['widgets.middle.sales_summary'])) {            
            $total_memberships_vat=0;
            $total_memberships_net =0;
            if ($permissions->isAnyRole(['master','finance','sales'])) {
                $total_memberships_net = ($total_memberships_value * 100) / 123;
                $total_memberships_vat  = $total_memberships_value - $total_memberships_net;
                $widgets['middle']['sales_summary'] = [
                    'total' => floor($total_memberships_value),
                    'vat' => floor($total_memberships_vat),
                    'net' => floor($total_memberships_net)
                ];
            }
            else{
                $widgets['top']['sales_summary'] = [
                    'total' => $total_memberships_value,
                    'vat' => $total_memberships_vat,
                    'net' => $total_memberships_net
                ];
            }
        }
        
        return view('home.master.dashboard', ['widgets' => $widgets]);

    }


}
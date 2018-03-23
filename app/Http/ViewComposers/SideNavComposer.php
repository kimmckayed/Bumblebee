<?php namespace App\Http\ViewComposers;

use App\Models\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class SideNavComposer {





    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

        $active_memberships = 0;
        $active_memberships_value = 0;
        $expired_memberships = 0;
        $expired_memberships_value = 0;
        $active_agents = 0;
        $active_companies = 0;
        $due_renewal = 0;
        $cartow_users = 0;

        $view->with(compact( 'cartow_users', 'active_memberships',
            'active_memberships_value', 'expired_memberships', 'expired_memberships_value', 'active_agents',
            'active_companies', 'due_renewal'));
    }

}
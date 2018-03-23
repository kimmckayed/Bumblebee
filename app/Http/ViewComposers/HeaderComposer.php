<?php namespace App\Http\ViewComposers;

use App\Models\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class HeaderComposer {





    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $user_id = Auth::user()->id;
        $notification = new Notification();
        $notifications = $notification->getNotifications($user_id);
        $unread =(int)( $notification->getUnreadNotifications($user_id));


        $view->with( compact( 'notifications', 'unread'));
    }

}
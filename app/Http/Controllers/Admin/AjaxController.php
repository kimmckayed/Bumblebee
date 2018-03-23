<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Sentinel;


class AjaxController extends Controller
{


    public function getReadNotification()
    {
        Notification::where('user_id', '=', Sentinel::getUser()->id)->update(['is_read' => 1]);

        return ['status' => true];


    }


}
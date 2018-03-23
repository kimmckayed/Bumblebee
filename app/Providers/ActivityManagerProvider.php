<?php namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class ActivityManagerProvider extends ServiceProvider {


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        App::bind('activity', function()
        {
            return new App\Managers\ActivityManager();
        });

    }

}
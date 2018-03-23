<?php namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer('layouts.common.header', 'App\Http\ViewComposers\HeaderComposer');
        View::composer('layouts.common.side_nav', 'App\Http\ViewComposers\SideNavComposer');


    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
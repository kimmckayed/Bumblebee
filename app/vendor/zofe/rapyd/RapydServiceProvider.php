<?php namespace  App\vendor\zofe\rapyd;

use Illuminate\Html\FormBuilder;
use Illuminate\Html\HtmlBuilder;
use Illuminate\Support\ServiceProvider;
use Zofe\Rapyd\Facades\Rapyd ;
class RapydServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Rapyd::setContainer($this->app);
   
        $this->app->booting(function () {
       
            
            $loader  =  \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('DataGrid'  , 'App\vendor\zofe\rapyd\Facades\DataGrid'  );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
    
}

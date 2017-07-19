<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // adding blade syntax for @break and @continue
        Blade::extend(function($value){
            return preg_replace('/(\s*)@(break|continue)(\s*)/', '$1<?php $2; ?>$3', $value);
        });

        /*Blade::directive('datetime', function($expression) {
            return "<?php echo with{$expression}->format('m/d/Y H:i'); ?>";
        });*/
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        // Manually registering provider only if the environment is set to
//        // development. That prevents a loading failure in PROD when the
//        // package is not present.
//        if ($this->app->environment('development')) {
//            $this->app->register('Libern\SqlLogging\SqlLoggingServiceProvider');
//        }
    }
}

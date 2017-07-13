<?php
namespace Sroutier\LESKModules\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
	/**
     * Bootstrap the application services.
     *
     * @return void
     */
	public function boot()
	{
		//
	}

	/**
     * Register the application services.
     *
     * @return void
     */
	public function register()
	{
		$driver = ucfirst(config('modules.driver'));

		if ($driver == 'Custom') {
			$namespace = config('modules.custom_driver');
		} else {
			$namespace = 'Sroutier\LESKModules\Repositories\\'.$driver.'Repository';
		}

		$this->app->bind('Sroutier\LESKModules\Contracts\RepositoryInterface', $namespace);
	}
}

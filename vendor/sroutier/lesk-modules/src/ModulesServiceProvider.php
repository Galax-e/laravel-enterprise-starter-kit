<?php
namespace Sroutier\LESKModules;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
	/**
	 * @var bool $defer Indicates if loading of the provider is deferred.
	 */
	protected $defer = false;

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__.'/../config/modules.php' => config_path('modules.php'),
		], 'config');

		$modules = $this->app['modules'];

		$modules->register();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(
			__DIR__.'/../config/modules.php', 'modules'
		);

		$this->app->register('Sroutier\LESKModules\Providers\RepositoryServiceProvider');

		$this->app->register('Sroutier\LESKModules\Providers\MigrationServiceProvider');

		$this->app->register('Sroutier\LESKModules\Providers\ConsoleServiceProvider');

		$this->app->register('Sroutier\LESKModules\Providers\GeneratorServiceProvider');

		$this->app->singleton('modules', function ($app) {
			$repository = $app->make('Sroutier\LESKModules\Contracts\RepositoryInterface');

			return new \Sroutier\LESKModules\Modules($app, $repository);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return string
	 */
	public function provides()
	{
		return ['modules'];
	}
}

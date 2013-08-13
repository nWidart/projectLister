<?php namespace Nwidart\ProjectLister;

use Illuminate\Support\ServiceProvider;

class ProjectListerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
	  $this->package('nwidart/ProjectLister');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['ProjectLister'] = $this->app->share(function($app)
		{
			return new ProjectLister;
		});

		$this->app->booting(function()
		{
		  $loader = \Illuminate\Foundation\AliasLoader::getInstance();
		  $loader->alias('ProjectLister', 'Nwidart\ProjectLister\Facades\ProjectLister');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('ProjectLister');
	}

}

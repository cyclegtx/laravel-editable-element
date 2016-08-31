<?php namespace Cyclegtx\LaravelEditableElement;

use Illuminate\Support\ServiceProvider;

class CEditableServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
	    $this->publishes([
	        __DIR__.'/js' => base_path('public/js/ceditable'),
	    ]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}

<?php namespace Cyclegtx\LaravelEditableElement;

use Illuminate\Support\ServiceProvider;

class EditableServiceProvider extends ServiceProvider {

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
		//
		include __DIR__.'/routes.php';
        $this->app->make('Cyclegtx\LaravelEditableElement\EditableController');
        $this->app->alias('laravel-editable-element-field', 'Cyclegtx\LaravelEditableElement\Field');
	}

}

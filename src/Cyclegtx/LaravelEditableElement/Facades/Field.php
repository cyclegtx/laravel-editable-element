<?php  namespace Cyclegtx\LaravelEditableElement\Facades;

use Illuminate\Support\Facades\Facade;

class Field extends Facade {

    public static function getFacadeAccessor()
    {
        return 'laravel-editable-element-field';
    }
}

<?php namespace Cyclegtx\LaravelEditableElement;

class CEditableBuilder {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function __construct()
    {
    }
    public static function create($class, $ins){
        if (!class_exists($class)) {
            throw new \InvalidArgumentException(
                'ORM class with name ' . $class . ' does not exist.'
            );
        }
        $editable = new $class();
        $editable->build($ins);
        return $ins;
    }
    public static function script(){
        $script = "<script>";
        $script .= file_get_contents(__DIR__.'/js/ceditable.js');
        $script .= "</script>";
        return $script;
    }
}

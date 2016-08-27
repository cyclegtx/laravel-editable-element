<?php namespace Cyclegtx\LaravelEditableElement;
use Illuminate\Contracts\View\Factory as View;

class EditableFields {

	protected $attributes = array();
	public function __construct()
	{
		//$this->collection = $coll;
		//$this->data = $this->collection->toArray()['data'];
		//
	}
	public function getAttributes()
	{
		return $this->attributes;
	}
	public function getAttribute($key)
	{
		$inAttributes = array_key_exists($key, $this->attributes);
		if ($inAttributes)
		{
			return $this->attributes[$key];
		}
	}
	public function add($name,$type,$value){
		$this->attributes[$name] = $this->drawBaseHtml($name,$type,$value);
		return $this;
	}
	public function make($name,$type,$value){
		return $this->drawBaseHtml($name,$type,$value);
	}
	private function drawBaseHtml($name,$type,$value){
		switch ($type) {
			case 'text':
				return '<input type="text" name="'.$name.'" value="'.$value.'">';
				break;
			case 'number':
				return '<input type="number" name="'.$name.'" value="'.$value.'">';
				break;
			
			default:
				# code...
				break;
		}

	}

	public function __get($name){
		return $this->getAttribute($name);
	}
}

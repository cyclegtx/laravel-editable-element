<?php namespace Cyclegtx\LaravelEditableElement;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;


class CEditable extends BaseController {
    use ValidatesRequests;


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	protected $Model=null;
    protected $route = "";
    protected $fields = [];

    public function __construct(){
        $this->buildFields();
        if (!class_exists($this->Model)) {
            throw new \InvalidArgumentException(
                'ORM class with name ' . $this->Model . ' does not exist.'
            );
        }
    }
    public function buildFields(){

    }
    public function add($name, $type = 'text', array $options = [])
    {
        if (!$name || trim($name) == '') {
            throw new \InvalidArgumentException(
                'Please provide valid field name for class ['. get_class($this) .']'
            );
        }

        $this->fields[$name] = new Field($name,$type,$this,$options);
        return $this;
    }
    public function addField(Field $field){
        $this->fields[$field->name] = $field;
    }
    public function build($ins){
        if($ins instanceof \Illuminate\Database\Eloquent\Model){
            foreach($this->fields as $field){
                $name = $field->name;
                if($ins->$name !== null){
                    $key = 'xEditable_'.$name;
                    $ins->$key = $field->render($ins);
                }
            }

        }else if($ins instanceof \Illuminate\Pagination\LengthAwarePaginator || $ins instanceof \Illuminate\Database\Eloquent\Collection){
            $ins->each(function($v){
                foreach($this->fields as $field){
                    $name = $field->name;
                    if($v->$name !== null){
                        $key = 'xEditable_'.$name;
                        $v->$key = $field->render($v);
                    }
                }
            });
        }
    }
    protected function buildField($field){

    }
    public function store(){
        $data = \Request::Input("data");
        $name = $data['name'];
        $value = \Request::Input("value");

        if(!array_key_exists($name,$this->fields)){
            return $this->fail('未找到此字段');
        }

        $this->doValidate($name,$value);

        return $this->fields[$name]->edit($data['id'],$value);
    }

    public function doValidate($name,$value){
        if(array_key_exists("rules",$this->fields[$name]->options)){
            $validator = $this->getValidationFactory()->make(
                    [$name=>$value], 
                    [$name => $this->fields[$name]->options['rules']
                ]);
            if ($validator->fails()){
                $errors =  "";
                foreach ($validator->errors()->all() as $error) {
                    $errors .= $error;
                }
                return $this->fail($errors);
            }
        }
    }
    public function success($msg = 'sucess'){
        return [
                'status'=>1,
                'msg'=>$msg,
                'data'=>null
                ];
    }
    public function fail($msg = ''){
        return [
                'status'=>0,
                'msg'=>$msg,
                'data'=>null
                ];
    }

    public static function create($class, $ins){
        if (!class_exists($class)) {
            throw new \InvalidArgumentException(
                'CEditable class with name ' . $class . ' does not exist.'
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

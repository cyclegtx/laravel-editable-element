<?php namespace Cyclegtx\LaravelEditableElement;

class Field {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	protected $Model=null;
    protected static $url = 'cyclegtx/editable'; 
	protected $ORM;
    public function __construct($id)
    {
    	$modelObj = new $this->Model();
        $this->ORM = $modelObj->find($id);
    }
    protected static function getUrlClassName($class){
        return str_replace("\\",":",$class);
    }
    protected static function getUrl($name,$id,$class){
    	return url('cyclegtx/editable').'/'.static::getUrlClassName($class).'/'.$name.'/'.$id;
    }
    public static function text($ins,$name){
        return '<input type="text" onChange="changeContent(this)" data-editable-data="'.static::buildEditableData($ins,$name).'" value="'.$ins->$name.'">';

    }
    public static function number($ins,$name){
        return '<input type="number" onChange="changeContent(this)" data-editable-data="'.static::buildEditableData($ins,$name).'" value="'.$ins->$name.'">';
    }
    public static function buildEditableData($ins,$name){
        $data = array(
                "url"=>url(static::$url),
                "name"=>$name,
                "id"=>$ins->getKey(),
                "orm"=>get_class($ins),
                "handler"=>get_called_class()
            );
        return htmlspecialchars(json_encode($data));
    }
    public static function editPreHandler($data,$content){
        $ORM = $data['orm'];
        $name = $data['name'];
        $id = $data['id'];
        if(get_called_class() != get_class()){
            $classname = get_called_class();
            $ins = new $classname($id);
            $ins->edit($name,$content);
        }else{
            $ins = $ORM::find($id);
            $ins->$name = $content;
            $res = $ins->save();
            dump($res);
        }
    }
    public function __set($name,$value){
    	$this->ORM->$name = $value;
    	$res = $this->ORM->save();
    	return $res;
    }
}

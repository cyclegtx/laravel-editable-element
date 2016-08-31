<?php namespace Cyclegtx\LaravelEditableElement;

class Field {
     /**
     * Name of the field
     *
     * @var
     */
    public $name;

    /**
     * Type of the field
     *
     * @var
     */
    public $type = 'text';

    public $parent;

    /**
     * All options for the field
     *
     * @var
     */
    public $options = [];


    /**
     * @param             $name
     * @param             $type
     * @param Form        $parent
     * @param array       $options
     */
    public function __construct($name, $type,CEditable $parent, array $options = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->parent = $parent;
        $this->options = $options;
    }
    /**
     * @param array $options
     * @param bool  $showLabel
     * @param bool  $showField
     * @param bool  $showError
     * @return string
     */
    public function render($ins = null)
    {
        $name = $this->name;
        if(in_array($this->type,['text','number','email'])){
            return '<input type="'.$this->type
                    .'" onChange="cEditable(this)" data-cEditable="'
                    .$this->buildData($ins).'" value="'.$ins->$name.'">';
        }
    }
    public function buildData($ins){
        $url = isset($this->options['route'])?$this->options['route']:$this->parent->route;
        $data = array(
                "url"=>url($url),
                "name"=>$this->name,
                "id"=>$ins->getKey(),
                "csrf"=>csrf_token()
            );
        return htmlspecialchars(json_encode($data));
    }
    public function edit($id,$value){
        $name = $this->name;
        $ORM = $this->parent->Model;
        $ins = $ORM::find($id);
        $ins->$name = $value;
        if($ins->save()){
            return $this->parent->success();
        }else{
            return $this->parent->fail();
        }
        
    }
}

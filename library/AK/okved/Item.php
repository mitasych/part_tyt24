<?php
class AK_okved_Item extends AK_Data_Entity_Extended
{
    protected $id;
    protected $code;
    protected $name;
    protected $parent_id;
    protected $parent_code;
    protected $node_count;
    /**
     * @return unknown
     */
    public function getId ()
    {
        return $this->id;
    }
    public function getName ()
    {
        return $this->name;
    }
    public function getCode ()
    {
        return $this->code;
    }
    public function getParent_id ()
    {
        return $this->parent_id;
    }
    public function getNode_count ()
    {
        return $this->node_count;
    }
    
    public function setId ($value)
    {
        $this->id = $value;
        return $this;
    }
    
    /**
     *
     */
    public function __construct ($value = null)
    {
        parent::__construct('class_okved', array(
            'id' => 'id' ,
            'code' => 'code' ,
            'name' => 'name' ,
            'parent_id' => 'parent_id' ,
            'parent_code' => 'parent_code' ,
            'node_count' => 'node_count'));
        $this->loadBySql("SELECT * FROM `class_okved` WHERE `id` = ".$value);
    }

    /**
     * SET & GET Creator
     */
    //-------------------------------------------------------------------------------------------------------------------
}

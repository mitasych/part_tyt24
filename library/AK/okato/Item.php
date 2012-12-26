<?php
class AK_okato_Item extends AK_Data_Entity_Extended
{
    protected $id;
    protected $code;
    protected $name;
    protected $additional_info;
    protected $parent_id;


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

    public function getShortName ()
    {
        $str = $this->name;
        
        $mass = explode(" ", $str);
		$mass[0] = empty($mass[0])?'':$mass[0];
		$mass[1] = empty($mass[1])?'':$mass[1];
		$mass[2] = empty($mass[2])?'':$mass[2];
        $str = $mass[0]." ".$mass[1]." ".$mass[2];
        return $str;
    }
    public function getCode ()
    {
        return $this->code;
    }

    public function getCity ()
    {
        return $this->additional_info;;
    }

     public function getParent_id ()
    {
        return $this->parent_id;
    }

    /**
     *
     */
    public function __construct ($value = 1)
    {
        parent::__construct('class_okato', array(
            'id' => 'id' ,
            'code' => 'code' ,
            'name' => 'name' ,
            'additional_info' => 'additional_info' ,
            'parent_id' => 'parent_id'));
        $this->loadBySql("SELECT * FROM `class_okato` WHERE `id` = ".$value);
    }


    /**
     * SET & GET Creator
     */
    //-------------------------------------------------------------------------------------------------------------------
}

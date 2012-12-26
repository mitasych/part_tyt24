<?php
class AK_company_ItemShort extends AK_Data_Entity_Extended
{
    protected $id;
    protected $name;
    protected $okato_id;
    protected $zerolevel_id;
    protected $firstlevel_id;
    protected $secondlevel_id;
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
    public function getOkato_id ()
    {
        return $this->okato_id;
    }

    public function getZerolevel_id ()
    {
        return $this->zerolevel_id;
    }

    public function getfirstlevel_id ()
    {
        return $this->firstlevel_id;
    }

    public function getsecondlevel_id ()
    {
        return $this->secondlevel_id;
    }
    /**
     *
     */
    public function __construct ($value = null)
    {
        parent::__construct('class_company_short5_2', array(
            'id' => 'id' ,
            'name' => 'name' ,
            'okato_id' => 'okato_id' ,
            'zerolevel_id' => 'zerolevel_id' ,
            'firstlevel_id' => 'firstlevel_id' ,
            'secondlevel_id' => 'secondlevel_id' ));

        $this->loadBySql("SELECT * FROM `class_company_short5_2` WHERE `id` = ".$value);
    }

    /**
     * SET & GET Creator
     */
    //-------------------------------------------------------------------------------------------------------------------
}

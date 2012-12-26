<?php
class AK_okved_Menu extends AK_Data_Entity_Extended
{
    protected $id;
    protected $name;
    protected $parent_id;
    protected $count;
    
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
    public function getParent_id ()
    {
        return $this->parent_id;
    }
    public function getCount ()
    {
        return $this->count;
    }

    /**
     *
     */
    public function __construct ($value = null)
    {   
        
        parent::__construct('okved_level', array(
            'id' => 'id' ,
            'name' => 'name' ,
            'parent_id' => 'parent_id' ,
            'count' => 'count'));
        $this->loadBySql("SELECT * FROM `okved_level` WHERE `id` = ".$value);
        
    }

    /**
     * SET & GET Creator
     */
    //-------------------------------------------------------------------------------------------------------------------
}

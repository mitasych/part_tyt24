<?php
class AK_Menu_Item extends AK_Data_Entity
{
    private $id;
    private $description;
    private $alias;
    
    public function getId ()
    {
        return $this->id;
    }
    
    
    public function getDescription ()
    {
        return $this->description;
    }
    
    public function getAlias ()
    {
        return $this->alias;
    }
    
    public function setId ($value)
    {
        $this->id = $value;
        return $this;
    }
    
    public function setDescription ($value)
    {
        $this->description = $value;
        return $this;
    }
    
    public function setAlias ($value)
    {
        $this->alias = $value;
        return $this;
    }
    
    /**
     * 
     */
    public function __construct ($value = null)
    {
        parent::__construct(DBT_PREFIX . '_menus__items', array(
            'id' => 'id' , 
            'description' => 'description',
            'alias' => 'alias'
            ));
        $this->load($value);
    }
    
    //FOR LISTER
    public function getFiltervalue ()
    {
        return $this->id;
    }
    
    
}

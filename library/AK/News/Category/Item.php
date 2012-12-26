<?php
class AK_News_Category_Item extends AK_Data_Entity
{
    private $id;
    private $title;
    
    
    public function getId ()
    {
        return $this->id;
    }
    
    
    public function getTitle ()
    {
        return $this->title;
    }
    
    public function setId ($value)
    {
        $this->id = $value;
        return $this;
    }
    
    public function setTitle ($value)
    {
        $this->title = $value;
        return $this;
    }
    
    /**
     * 
     */
    public function __construct ($value = null)
    {
        parent::__construct(DBT_PREFIX . '_news__categories', array(
            'id' => 'id' , 
            'title' => 'title'
            ));
        $this->load($value);
    }

}

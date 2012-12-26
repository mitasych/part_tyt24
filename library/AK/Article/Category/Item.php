<?php
class AK_Article_Category_Item extends AK_Data_Entity
{
    private $id;
    private $title;
    private $isFree = 1;
    
    
    public function getId ()
    {
        return $this->id;
    }
    
    
    public function getTitle ()
    {
        return $this->title;
    }
    
    public function getIsFree ()
    {
        return $this->isFree;
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
    
    public function setIsFree ($value)
    {
        $this->isFree = empty($value)?0:1;
        return $this;
    }
    
    /**
     * 
     */
    public function __construct ($value = null)
    {
        parent::__construct(DBT_PREFIX . '_articles__categories', array(
            'id' => 'id' , 
            'title' => 'title',
            'is_free' => 'isFree'
            ));
        $this->load($value);
    }
    
    //-------------------------------------------------------------------------------------------------------------------
	  /**
     * FOR LISTER
     */
    public function getIsFreeColored()
    {
        $result = empty($this->isFree) ? '<font color=red>Фиксированные</font>' : '<font color=blue>Свободные</font>';
        return $result;
    }
    //-------------------------------------------------------------------------------------------------------------------

}

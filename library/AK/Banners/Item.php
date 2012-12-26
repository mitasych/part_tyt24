<?php
class AK_Banners_Item extends AK_Data_Entity
{
    public $id;
    public $isimage;
    public $code;
    public $image_path;
    public $count;
    public $isActive;
    public $name;
    public $key;
    public $position;
    public $priority;
    public $image_href;
    
  
    /**
     *
     */
    public function __construct ($value = null)
    {
        parent::__construct('banners', array(
            'id' => 'id' ,
            'isimage' => 'isimage',
            'code' => 'code',
            'image_path' => 'image_path',
            'count' => 'count',
            'isActive' => 'isActive',
            'name' => 'name',
            'key' => 'key' ,
            'position' => 'position',
            'priority' => 'priority',
            'image_href' => 'image_href'
            ));
        $this->load($value);

            
    }

   
  
}

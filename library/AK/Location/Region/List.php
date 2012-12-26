<?php
class AK_Location_Region_List extends AK_Order_Abstract_List	{

 public function __construct()
    {
		  parent::__construct(); 
    }


 public function getList(){
		$db = Zend_Registry::get('DBTYT24');
		$query = $db->select();
		
		
		$query->from('subregions AS A', 'A.*');
		$items = $this->_db->fetchAll($query);
	
		return $items;

	}

public function getCount()
    {
       // if (null === $this->elementsCount) {
          $this->setCount();
       // }
        return $this->elementsCount;
    }


}
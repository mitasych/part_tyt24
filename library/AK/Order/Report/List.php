<?php

class AK_Order_Report_List extends AK_Order_Abstract_List
{
    private $elementsCount = null;
    
    public function __construct()
    {
		  parent::__construct(); 
    }
 /**
     * 
     */
    public function getList($id=0)
    {
    	$query = $this->_db->select();
    	if ( $this->isAsAssoc() ) {
            $fields = array();
            //~ $fields[] = ( $this->getAssocKey() === null ) ? 'A.name' : $this->getAssocKey();
            //~ $fields[] = ( $this->getAssocValue() === null ) ? 'A.name' : $this->getAssocValue();
            $fields[] = ( $this->getAssocKey() === null ) ? 'A.id' : $this->getAssocKey();
            $fields[] = ( $this->getAssocValue() === null ) ? 'A.title' : $this->getAssocValue();
            $query->from('order_report AS A', $fields);	
    	} else {
    	    $query->from('order_report AS A', 'A.*');
    	}
    	if ( $this->getWhere() ) $query->where($this->getWhere());
    	if ( !empty($id) ) $query->where('A.active = 1');
    
        if ( $this->getCurrentPage() !== null && $this->getListSize() !== null ) {
            $query->limitPage($this->getCurrentPage(), $this->getListSize());
        }
        if ( $this->getOrder() !== null ) {
            $query->order($this->getOrder());
        }
        if ( $this->isAsAssoc() ) {
        	$items = $this->_db->fetchPairs($query);
        } else {
            $items = $this->_db->fetchAll($query);
	        foreach ( $items as &$item ) $item = new AK_Order_Report($item);
        }
        //$this->setCount(count($items));
        return $items;
    }
    
    /**
     * return number of all items
     * @return int count
     */
    public function getCount()
    {
       // if (null === $this->elementsCount) {
          $this->setCount();
       // }
        return $this->elementsCount;
    }
    
    public function setCount($value=null) {
      
      if (empty($value)) {
        $query = $this->_db->select();
        $query->from('order_report AS A', 'COUNT(A.id)');
        if ( $this->getWhere() ) $query->where($this->getWhere());
        
        $this->elementsCount =$this->_db->fetchOne($query);
      } else {
        $this->elementsCount = $value;
      }  
        return $this;
    }
}

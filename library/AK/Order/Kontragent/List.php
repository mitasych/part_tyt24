<?php

class AK_Order_Kontragent_List extends AK_Order_Abstract_List
{
    private $actual = false;
    private $elementsCount = null;
    
    public function __construct()
    {
		parent::__construct(); 
    }

    public function setActual($val) {
        $this->actual = (boolean) $val;
    }
 /**
     * 
     */
    public function getList()
    {
    	$query = $this->_db->select();
    	if ( $this->isAsAssoc() ) {
            $fields = array();
            $fields[] = ( $this->getAssocKey() === null ) ? 'A.id' : $this->getAssocKey();
            $fields[] = ( $this->getAssocValue() === null ) ? 'A.title' : $this->getAssocValue();
            $query->from('orders_kontragents AS A', $fields);
    	} else {
    	    $query->from('orders_kontragents AS A', 'A.*');
    	}

        if ($this->actual) {
            $query->distinct();
            $query->joinLeft('orders_users__kontragents AS B', 'A.id = B.kontragent_id', null);
            $query->joinLeft('orders_users__monitoring_tarifs AS C', 'C.user_id = B.user_id', null);
            $query->where('C.end_date_kurator >= ?', time());
        }

    	if ( $this->getWhere() ) $query->where($this->getWhere());
    
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
	        foreach ( $items as &$item ) $item = new AK_Order_Kontragent($item);
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
        //}
        return $this->elementsCount;
    }
    
    public function setCount($value=null) {
      
      if (empty($value)) {
        $query = $this->_db->select();
        $query->from('orders_kontragents AS A', 'COUNT(A.id)');
        if ($this->actual) {
            $query->distinct();
            $query->joinLeft('orders_users__kontragents AS B', 'A.id = B.kontragent_id', null);
            $query->joinLeft('orders_users__monitoring_tarifs AS C', 'C.user_id = B.user_id', null);
            $query->where('C.end_date_kurator >= ?', time());
        }
        if ( $this->getWhere() ) $query->where($this->getWhere());
        
        $this->elementsCount =$this->_db->fetchOne($query);
      } else {
        $this->elementsCount = $value;
      }  
        return $this;
    }
}

<?php

class AK_Order_Relation_List extends AK_Order_Abstract_ListTyt24
{

    private $elementsCount = null;
    
    public function __construct()
    {
		parent::__construct(); 
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
            $fields[] = ( $this->getAssocValue() === null ) ? 'A.id' : $this->getAssocValue();
            $query->from('orders_relations AS A', $fields);
    	} else {
    	    $query->from('orders_relations AS A', 'A.*')
            ->joinLeft('orders_form_balans AS B', 'B.id = A.zakaz_id AND A.zakaz_type_id = '.AK_Order_ZakazTypes::OPERATIONS, null)
            ->joinLeft('orders_form_contragent_check AS C', 'C.id = A.zakaz_id AND A.zakaz_type_id = '.AK_Order_ZakazTypes::CONTRAGENT_CHECK, null)
            ->joinLeft('orders_form_monitoring_tarif AS D', 'D.id = A.zakaz_id AND A.zakaz_type_id = '.AK_Order_ZakazTypes::MONITORING, null)
            ->joinLeft('orders_form_base AS E', 'E.id = A.zakaz_id AND A.zakaz_type_id = '.AK_Order_ZakazTypes::BASES, null);

    	}
//
        if ( $this->getWhere() ) $query->where($this->getWhere());
    
        if ( $this->getCurrentPage() !== null && $this->getListSize() !== null ) {
            $query->limitPage($this->getCurrentPage(), $this->getListSize());
        }
        if ( $this->getOrder() !== null ) {
            $query->order($this->getOrder());
        }
       // print $query->__toString();die;
        if ( $this->isAsAssoc() ) {
        	$items = $this->_db->fetchPairs($query);
        } else {
            $items = $this->_db->fetchAll($query);
	        foreach ( $items as &$item ) $item = new AK_Order_Relation($item);
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
        $query->from('orders_relations AS A', 'COUNT(A.id)')
          ->joinLeft('orders_form_balans AS B', 'B.id = A.zakaz_id AND A.zakaz_type_id = '.AK_Order_ZakazTypes::OPERATIONS, 'B.status AS status')
            ->joinLeft('orders_form_contragent_check AS C', 'C.id = A.zakaz_id AND A.zakaz_type_id = '.AK_Order_ZakazTypes::CONTRAGENT_CHECK, 'C.status AS status')
            ->joinLeft('orders_form_monitoring_tarif AS D', 'D.id = A.zakaz_id AND A.zakaz_type_id = '.AK_Order_ZakazTypes::MONITORING, 'D.status AS status')
          ->joinLeft('orders_form_base AS E', 'E.id = A.zakaz_id AND A.zakaz_type_id = '.AK_Order_ZakazTypes::BASES, 'E.status AS status')
          ->group('A.id');

        if ( $this->getWhere() ) $query->where($this->getWhere());
        
        $this->elementsCount =$this->_db->fetchOne($query);
      } else {
        $this->elementsCount = $value;
      }  
        return $this;
    }
}

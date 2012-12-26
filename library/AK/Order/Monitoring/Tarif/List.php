<?php

class AK_Order_Monitoring_Tarif_List extends AK_Order_Abstract_List {

    private $elementsCount = null;

    public function __construct() {
        parent::__construct();
    }
    /**
     *
     */
    public function getList() {
        $query = $this->_db->select();
        if ( $this->isAsAssoc() ) {
            $fields = array();
            $fields[] = ( $this->getAssocKey() === null ) ? 'A.id' : $this->getAssocKey();
            $fields[] = ( $this->getAssocValue() === null ) ? 'A.id' : $this->getAssocValue();
            $query->from('orders_monitoring__tarif AS A', $fields);
        }
        else {
            $query->from('orders_monitoring__tarif AS A', 'A.*');
        }

        if ( $this->getWhere() ) $query->where($this->getWhere());

        if ( $this->getCurrentPage() !== null && $this->getListSize() !== null ) {
            $query->limitPage($this->getCurrentPage(), $this->getListSize());
        }
        if ( $this->getOrder() !== null ) {
            $query->order($this->getOrder());
        }
        else {
            $query->order('A.order ASC');
        }
		if ( $this->isAsAssoc() ) {
            $items = $this->_db->fetchPairs($query);
        }
        else {
            $items = $this->_db->fetchAll($query);
            foreach ( $items as &$item ) $item = new AK_Order_Monitoring_Tarif($item);
        }
        //$this->setCount(count($items));
		
		//var_dump($items);exit();
        return $items;
    }



    /**
     * return number of all items
     * @return int count
     */
    public function getCount() {
        // if (null === $this->elementsCount) {
        $this->setCount();
        //}
        return $this->elementsCount;
    }

    public function setCount($value=null) {

        if (empty($value)) {
            $query = $this->_db->select();
            $query->from('orders_monitoring__tarif AS A', 'COUNT(A.id)');
            if ( $this->getWhere() ) $query->where($this->getWhere());

            $this->elementsCount =$this->_db->fetchOne($query);
        }
        else {
            $this->elementsCount = $value;
        }
        return $this;
    }
	
	
	/** 
	* @voodoo
 	*/
	
	public function getMinimal(){
	  $query = $this->_db->select();
	  $query->from('orders_monitoring__tarif AS A','A.num')->where("type = 'Minimal' ");
	  $result = $this->_db->fetchOne($query);
	  return $result;
	}

    public function getTestTarifCount() {
	  $query = $this->_db->select();
	  $query->from('orders_monitoring__tarif AS A','A.num')->where("type = 'Test' ");
	  $result = $this->_db->fetchOne($query);
	  return $result;     
    }	
	
	public function getAllUserTarifs($userId){
      $query = $this->_db->select();
      $query->from('orders_users__monitoring_tarifs AS A')->where('A.user_id = ?',$userId);
	  $items = $this->_db->fetchAll();
	  
      foreach ( $items as &$item ) $item = new AK_Order_Monitoring_Tarif($item);
	  return $items;	  
	}
	
}

<?php

class AK_Order_Report_OfList extends AK_Order_Abstract_List
{
    private $elementsCount = null;
    
    public function __construct()
    {
		  parent::__construct(); 
    }
 /**
     * 
     */
    public function getList($id = 0, $reg_code = 0, $report_id = 0)
    {
    	$query = $this->_db->select();
    	if ( $this->isAsAssoc() ) {
            $fields = array();
            $fields[] = ( $this->getAssocKey() === null ) ? 'A.name' : $this->getAssocKey();
            $fields[] = ( $this->getAssocValue() === null ) ? 'A.name' : $this->getAssocValue();
            $query->from('order_report_regions AS A', $fields);	
    	} else {
    	    $query->from('order_report_regions AS A', 'A.*');
    	    $query->join('order_report', 'A.order_report_id = order_report.id', array('order_report_title' => 'order_report.title'));
    	    $query->join('orders_region__inn', 'A.region_code = orders_region__inn.code', array('order_report_region' => 'orders_region__inn.capital'));
    	}
    	if ( $this->getWhere() ) $query->where($this->getWhere());
    	if ( !empty($id) ) $query->where('A.active = 1');
    	if ( !empty($report_id) ) {
    		$query->where('A.order_report_id = ?', $report_id);
    	}
    	if ( !empty($reg_code) ) {
    		$query->where('A.region_code = ?', $reg_code);
    	}
    
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
            //echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($items); echo'</pre>';die;
	        foreach ( $items as &$item ){
	        	 $item = new AK_Order_Ofreport($item);
	        }
            //echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($items); echo'</pre>';die;
        }
        //$this->setCount(count($items));
//         echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($query->assemble()); echo'</pre>';die;
//         echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($items); echo'</pre>';die;
        return $items;
    }
    
    public function getOfreportByCodeAndReport($reg_code, $report_id){
    	$query = $this->_db->select();
    	$query->from('order_report_regions AS A', 'A.*');
    	$query->join('order_report', 'A.order_report_id = order_report.id', array('order_report_title' => 'order_report.title'));
    	$query->join('orders_region__inn', 'A.region_code = orders_region__inn.code', array('order_report_region' => 'orders_region__inn.title'));
    	$query->where('A.order_report_id = ?', $report_id);
    	$query->where('A.region_code = ?', $reg_code);
    	
    	$row = $this->_db->fetchRow($query);
    	
    	$obj = new AK_Order_Ofreport($row);
    	
    	return $obj;
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
        $query->from('order_report_regions AS A', 'COUNT(A.id)');
        if ( $this->getWhere() ) $query->where($this->getWhere());
        
        $this->elementsCount =$this->_db->fetchOne($query);
      } else {
        $this->elementsCount = $value;
      }  
        return $this;
    }
}

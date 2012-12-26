<?php

class AK_Order_PricesList extends AK_Order_Abstract_List
{
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
            $fields[] = ( $this->getAssocValue() === null ) ? 'A.title' : $this->getAssocValue();
            $query->from('orders_prices AS A', $fields);
    	} else {
    	    $query->from('orders_prices AS A', 'A.id');
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
            $items = $this->_db->fetchCol($query);
	        foreach ( $items as &$item ) $item = new AK_Order_Prices ($item);
        }
        return $items;
    }

    /**
     * return number of all items
     * @return int count
     */
    public function getCount()
    {
        $query = $this->_db->select();
        $query->from('orders_prices AS A', 'COUNT(*)');
        if ( $this->getWhere() ) $query->where($this->getWhere());

        return $this->_db->fetchOne($query);
    }



}

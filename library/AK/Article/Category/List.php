<?php

class AK_Article_Category_List extends AK_Abstract_List
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
            $fields[] = ( $this->getAssocKey() === null ) ? 'nc.id' : $this->getAssocKey();
            $fields[] = ( $this->getAssocValue() === null ) ? 'nc.title' : $this->getAssocValue();
            $query->from(DBT_PREFIX.'_articles__categories AS nc', $fields);	
    	} else {
    	    $query->from(DBT_PREFIX.'_articles__categories AS nc', 'nc.id');
    	}
    	if ( $this->getWhere() ) $query->where($this->getWhere());
    
        if ( $this->getCurrentPage() !== null && $this->getListSize() !== null ) {
            $query->limitPage($this->getCurrentPage(), $this->getListSize());
        }
        if ( $this->getOrder() !== null ) {
            $query->order($this->getOrder());
        }
        //print $query->__toString();
        if ( $this->isAsAssoc() ) {
        	$items = $this->_db->fetchPairs($query);
        } else {
            $items = $this->_db->fetchCol($query);
	        foreach ( $items as &$item ) $item = new AK_Article_Category_Item($item);
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
        $query->from(DBT_PREFIX.'_articles__categories AS nc', 'COUNT(nc.id)');
        if ( $this->getWhere() ) $query->where($this->getWhere());
        
        return $this->_db->fetchOne($query);
    }
}

<?php

class AK_Article_List extends AK_Abstract_List
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
            $fields[] = ( $this->getAssocKey() === null ) ? 'ai.id' : $this->getAssocKey();
            $fields[] = ( $this->getAssocValue() === null ) ? 'ai.title' : $this->getAssocValue();
            $query->from(DBT_PREFIX.'_articles__items AS ai', $fields);
            $query->joinLeft(DBT_PREFIX.'_rewrite__names AS B', 'B.entity_id = ai.id AND B.entity_type_id = 2', null);
    	} else {
    	    $query->from(DBT_PREFIX.'_articles__items AS ai', 'ai.id');
            $query->joinLeft(DBT_PREFIX.'_rewrite__names AS B', 'B.entity_id = ai.id AND B.entity_type_id = 2', null);
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
	        foreach ( $items as &$item ) $item = new AK_Article_Item($item);
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
        $query->from(DBT_PREFIX.'_articles__items AS ai', 'COUNT(ai.id)');
        $query->joinLeft(DBT_PREFIX.'_rewrite__names AS B', 'B.entity_id = ai.id AND B.entity_type_id = 2', null);
        if ( $this->getWhere() ) $query->where($this->getWhere());
        
        return $this->_db->fetchOne($query);
    }
    
    
}

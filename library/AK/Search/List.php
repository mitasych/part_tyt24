<?php

class AK_Search_List extends AK_Abstract_List
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
            $fields[] = ( $this->getAssocKey() === null ) ? 'A.EntBaseInfoCode' : $this->getAssocKey();
            $fields[] = ( $this->getAssocValue() === null ) ? 'A.Name' : $this->getAssocValue();
            $query->from('entbaseinfo AS A', $fields);
    	} else {
    	    $query->from('entbaseinfo AS A', 'A.EntBaseInfoCode');
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
	        foreach ( $items as &$item ) $item = new AK_Search_Item($item);
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
        $query->from('entbaseinfo AS A', 'COUNT(A.EntBaseInfoCode)');
        if ( $this->getWhere() ) $query->where($this->getWhere());

        return $this->_db->fetchOne($query);
    }
}

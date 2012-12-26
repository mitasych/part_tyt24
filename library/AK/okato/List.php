<?php

class AK_okato_List extends AK_Abstract_List
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
            $fields[] = ( $this->getAssocValue() === null ) ? 'A.name' : $this->getAssocValue();
            $fields[] = 'A.additional_info' ;
            $fields[] = 'A.code' ;
            $query->from('class_okato AS A', $fields);
    	} else {
    	    $query->from('class_okato AS A', 'A.id');
    	}
    	if ( $this->getWhere() ) $query->where($this->getWhere());

        if ( $this->getCurrentPage() !== null && $this->getListSize() !== null ) {
            $query->limitPage($this->getCurrentPage(), $this->getListSize());
        }
        if ( $this->getOrder() !== null ) {
            $query->order($this->getOrder());
        }
        if ( $this->isAsAssoc() ) {
        	$items = $this->_db->fetchAll($query);
        } else {
            $items = $this->_db->fetchCol($query);
	        foreach ( $items as &$item ) $item = new AK_okato_Item($item);
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
        $query->from('class_okato AS A', 'COUNT(A.id)');
        if ( $this->getWhere() ) $query->where($this->getWhere());

        return $this->_db->fetchOne($query);
    }
    


}

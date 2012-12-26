<?php

class AK_company_ListShort extends AK_Abstract_List
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
            $query->from('class_company_short5_2 AS A', $fields);
            if (strpos($this->getWhere(),"CNT.name")>0) // ЕСЛИ ИДЕТ ПОИСК В СТРОКЕ "ЧТО" то нужно искать по тегам - подключаем таблицы многие ко многим
            {
            $query->joinInner('class_company_names_tags_and_company_id AS CCNTAC', 'A.id = CCNTAC.company_id', null);
            $query->joinInner('class_company_names_tags AS CCNT', 'CCNTAC.tags_id = CCNT.id', null);
            }

    	} else {
    	    $query->from('class_company_short5_2 AS A', 'A.id');
            if (strpos($this->getWhere(),"CNT.name")>0) // ЕСЛИ ИДЕТ ПОИСК В СТРОКЕ "ЧТО" то нужно искать по тегам - подключаем таблицы многие ко многим
            {
            $query->joinInner('class_company_names_tags_and_company_id AS CCNTAC', 'A.id = CCNTAC.company_id', null);
            $query->joinInner('class_company_names_tags AS CCNT', 'CCNTAC.tags_id = CCNT.id', null);
            }
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
	        foreach ( $items as &$item ) $item = new AK_company_ItemShort($item);
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
        $query->from('class_company_short5_2 AS A', 'COUNT(*)');
        if (strpos($this->getWhere(),"CNT.name")>0) // ЕСЛИ ИДЕТ ПОИСК В СТРОКЕ "ЧТО" то нужно искать по тегам - подключаем таблицы многие ко многим
            {
            $query->joinInner('class_company_names_tags_and_company_id AS CCNTAC', 'A.id = CCNTAC.company_id', null);
            $query->joinInner('class_company_names_tags AS CCNT', 'CCNTAC.tags_id = CCNT.id', null);
            }
        if ( $this->getWhere() ) $query->where($this->getWhere());

        return $this->_db->fetchOne($query);
    }

    
}

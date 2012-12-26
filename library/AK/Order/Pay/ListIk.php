<?php

class AK_Order_Pay_ListIk extends AK_Order_Abstract_List
{
    private $elementsCount = null;
    private $res ;
    
    public function __construct()
    {
		  parent::__construct(); 
    }
 /**
     * 
     */
    public function getListXml($group = 0)//0 вывод всех, 1 вывод активных, 2 вывод под селект буквенное - вывод только под него попадающих
	{
		if(empty($res))
		{
			$dom = new DomDocument();
			$dom->load("paysystems.currencies.export.xml");
			$res = simplexml_import_dom($dom);
			$this->res = $res;
		}
		
		$ListPay3 = array();
		foreach($this->res->paysystem as $paysystem)
		{
			if ($paysystem['state'])
				if($group == 2)
					$ListPay3[(string) $paysystem['alias']] = (string) $paysystem.' / '.(string)$paysystem['currencyName'];
				else
				{
					//$ListPay3[(string) $paysystem['id']] = array();
					if (empty($group) || $group == (string) $paysystem)
					{
						$item = array();
						$item['alias'] = (string) $paysystem['alias'];
						$item['currency'] = (string) $paysystem['currencyName'];
						$item['exchange'] = (string) $paysystem['exchangeRate'];
						$item['title'] = (string) $paysystem;
						$ListPay3[(string) $paysystem['id']] = $item;
					}
				}
		}
		return $ListPay3;
	}
	
    public function getList($group = 0)
    {
    	$query = $this->_db->select();
    	if ( $this->isAsAssoc() ) {
            $fields = array();
            $fields[] = ( $this->getAssocKey() === null ) ? 'A.id' : $this->getAssocKey();
            $fields[] = ( $this->getAssocValue() === null ) ? 'A.name' : $this->getAssocValue();
            $query->from('interkassa_csv AS A', $fields);	
    	} else {
    	    $query->from('interkassa_csv AS A', 'A.*');
    	}
    	if ( $this->getWhere() ) $query->where($this->getWhere());
    
        if ( $this->getCurrentPage() !== null && $this->getListSize() !== null ) {
            $query->limitPage($this->getCurrentPage(), $this->getListSize());
        }
        if ( $this->getOrder() !== null ) {
            $query->order($this->getOrder());
        }
		if (!empty($group))
			$query->group('A.name');
        if ( $this->isAsAssoc() ) {
        	$items = $this->_db->fetchPairs($query);
	       
        } else {
            $items = $this->_db->fetchAll($query);
	        foreach ( $items as &$item ) $item = new AK_Order_Pay_ItemIk($item);
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
       // }
        return $this->elementsCount;
    }
    
    public function setCount($value=null) {
      
      if (empty($value)) {
        $query = $this->_db->select();
        $query->from('interkassa_csv AS A', 'COUNT(A.id)');
        if ( $this->getWhere() ) $query->where($this->getWhere());
        
        $this->elementsCount =$this->_db->fetchOne($query);
      } else {
        $this->elementsCount = $value;
      }  
        return $this;
    }
}

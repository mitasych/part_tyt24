<?php

class AK_Order_Kontragent extends AK_Data_EntityOrder {

    public $id;
    public $inn;
    public $title;
    public $region;
    public $country;
    public $otrasl;
    public $adress;
    public $rykov;
    public $reg_date;
    public $OKVED;
    public $company;
    
    public function __construct ($key = null, $val = null) {
        parent::__construct('orders_kontragents', array(
            'id' => 'id' ,
            'inn' => 'inn' ,
            'region' => 'region' ,
            'otrasl' => 'otrasl' ,
            'adress' => 'adress' ,
            'rykov' => 'rykov' ,
            'title' => 'title' ,
            'reg_date' => 'reg_date' ,
            'country' => 'country'));

        if ($key !== null) {
            if (!is_array($key)) {
                $this->pkColName = $key;
                $this->loadByPk($val);
                $this->pkColName = 'id';
            }
            else {
                $this->load($key);
            }
        }
        else {
            $this->pkColName = 'id';
        }
    }

    public function getAllEvent(){
        $db = Zend_Registry::get('DBORDER');
        $query = $db->select();  
        $query->from('orders_monitoring__events');
        $query->where('kontragent_id = ?', $this->id);
        $res = $db->fetchAll($query);
        //print_r($res);
        //exit();
        return $res;

    }


        public function getLastEvent(){
        $db = Zend_Registry::get('DBORDER');
        $query = $db->select();  
        $query->from('orders_monitoring__events');
        $query->where('kontragent_id = ?', $this->id);
        $query->order("event_date");
        $query ->limit(1);
        $res = $db->fetchAll($query);
        //print_r($res);
        //exit();
        return $res;

    }

        public function getEventType($id){
        $db = Zend_Registry::get('DBORDER');
        $query = $db->select();  
        $query->from('orders_monitoring__events_types');
        $query->where('id = ?', $id);
      //  return $query->__toString();

        $res = $db->fetchAll($query);

        return $res[0]['title'];

    }
	
    public function getOKVED() {
        if (null === $this->OKVED) {
        //    $this->OKVED = new AK_okved_List();
            $OKVED = new AK_okved_List();
			$OKVED->addWhere('code = \''.$this->otrasl.'\'');
			$OKVED = $OKVED->getList();
			$this->OKVED = $OKVED[0];
			//$OKVED=$OKVED;
        }
        return $this->OKVED;
    }
	
    public function getCompany() {
        if (null === $this->company) {
        //    $this->OKVED = new AK_okved_List();
            $company = new AK_company_Item($this->inn, 'inn');
			if (!empty($company->id))
				$this->company = $company;
			else
				$this->company = 0;
			//$OKVED=$OKVED;
        }
        return $this->company;
    }
}

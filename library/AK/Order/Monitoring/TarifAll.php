<?php

class AK_Order_Monitoring_TarifAll extends AK_Data_EntityOrder {

    public $id;
    public $name;

    public $type;
    public $reg1;
    public $reg2;
    public $reg3;
    public $simb;
    public $about;
    public $bonus;
    public $type2;
    public $isActive;
    private $typeItem;
    public $period1;
    public $period2;
    public $period3;
    public $period_sale1;
    public $period_sale2;
    public $period_sale3;
    public $period_active1;
    public $period_active2;
    public $period_active3;

	
    public function getIsActiveColored() {
        if ($this->isActive) {
            return '<font color=green>активен</font>';
        } else {
            return '<font color=red>не активен</font>';
        }

    }
    public function getTypeName() {
        if (empty($this->typeItem)) {
			$this->typeItem = new AK_Order_Monitoring_TarifType($this->type);
        } 
		return $this->typeItem->name;
        
    }
	
    public function getTypeItem() {
        if (empty($this->typeItem)) {
			$this->typeItem = new AK_Order_Monitoring_TarifType($this->type);
        } 
		return $this->typeItem;
        
    }
    public function getEventType($id) {
		if (empty($this->id))
			return false;
		
		$db = Zend_Registry::get('DBORDER');
		$query = $db->select();
		$query->from('orders_monitoring__tarif_conect AS A');
		$query->where('A.id_tarif = ?', $this->id);
		$query->where('A.id_price = ?', $id);
		// print($query);
		// die();
		$event = $db->fetchAll($query);
        if (empty($event)) {
			return false;
        } 
		else
		{
			return true;
		}
        

    }
    public function getTarifType($id) {
		if (empty($this->id))
			return false;
		
		$db = Zend_Registry::get('DBORDER');
		$query = $db->select();
		$query->from('orders_monitoring__tarif_conect_tarif AS A');
		$query->where('A.id_tarif = ?', $this->id);
		$query->where('A.id_price = ?', $id);
		$event = $db->fetchAll($query);
        if (empty($event)) {
			return false;
        } 
		else
		{
			return true;
		}
        

    }
    public function getTarifCountry($id) {
		if (empty($this->id))
			return '';
		
		$db = Zend_Registry::get('DBORDER');
		$query = $db->select();
		$query->from('orders_monitoring__tarif_conect_country AS A');
		$query->where('A.id_tarif = ?', $this->id);
		$query->where('A.id_country = ?', $id);
		$event = $db->fetchAll($query);
        if (empty($event)) {
			return '';
        } 
		else
		{
			return $event[0]['price'];
		}
        

    }
    public function getTarifCountryActive($id) {
		if (empty($this->id))
			return false;
		
		$db = Zend_Registry::get('DBORDER');
		$query = $db->select();
		$query->from('orders_monitoring__tarif_conect_country AS A');
		$query->where('A.id_tarif = ?', $this->id);
		$query->where('A.id_country = ?', $id);
		$event = $db->fetchAll($query);
        if (empty($event)) {
			return false;
        } 
		else
		{
			if (empty($event[0]['active']))
				return false;
			else
				return true;
		}
        

    }
    public function __construct ($val = null) {
        parent::__construct('orders_monitoring__tarif_all', array(
            'id' => 'id' ,
            'name' => 'name' ,
            'type' => 'type',
            'reg1' => 'reg1',
            'reg2' => 'reg2',
            'reg3' => 'reg3',
            'simb' => 'simb',
            'about' => 'about',
            'bonus' => 'bonus',
            'type2' => 'type2',
            'period1' => 'period1',
            'period2' => 'period2',
            'period3' => 'period3',
            'period_sale1' => 'period_sale1',
            'period_sale2' => 'period_sale2',
            'period_sale3' => 'period_sale3',
            'period_active1' => 'period_active1',
            'period_active2' => 'period_active2',
            'period_active3' => 'period_active3',
            'is_active' => 'isActive' 
            ));        
            $this->load($val);
			
			//$this->pM=(float)$this->pM/(float)$this->num;
			//$this->pK=(float)$this->pK/(float)$this->num;
			//$this->pH=(float)$this->pH/(float)$this->num;			
    }
}

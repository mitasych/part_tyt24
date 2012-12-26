<?php

class AK_Order_Monitoring_Tarif extends AK_Data_EntityOrder {

    public $id;
    public $num;

    public $pM;
    public $pK;
    public $pH;
    public $pY;

    public $order;
    public $isActive;
	public $type;
	public $tarif_id;
	
	public $lastEvent;

    public function getIsActiveColored() {
        if ($this->isActive) {
            return '<font color=green>активен</font>';
        } else {
            return '<font color=red>не активен</font>';
        }

    }
    public function getTarifAll() {
		$db = Zend_Registry::get('DBORDER');
		$query = $db->select();
		$query->from('orders_monitoring__tarif_conect_tarif AS A');
		$query->where('A.id_price = ?', $this->id);
		//$query->where('A.id_price = ?', $id);
		$tarif = $db->fetchAll($query);
        if (empty($tarif)) {
			return false;
        } 
		else
		{
			$arr = array();
			foreach($tarif as $a)
				$arr[]=new AK_Order_Monitoring_TarifAll($a['id_tarif']);
			return $arr;
		}
    }
    public function getTarifAllAct($id) {
		$db = Zend_Registry::get('DBORDER');
		$query = $db->select();
		$query->from('orders_monitoring__tarif_conect_tarif AS A');
		$query->where('A.id_price = ?', $this->id);
		$query->where('A.id_tarif = ?', $id);
		$tarif = $db->fetchAll($query);
		
        if (empty($tarif)) {
			return false;
        } 
		else
		{
			return true;
		}
        
    }
    public function getLastEvent() {
		if (empty($this->lastEvent))
		{
			$db = Zend_Registry::get('DBORDER');
			$query = $db->select();
			$query->from('orders_monitoring__events AS A', 'A.id');
			$query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE tarif_id = ?)', $this->tarif_id)
				  ->order('A.event_date DESC')
				  ->limit(1);
			$res = intval($db->fetchOne($query));
			$this->lastEvent = new AK_Order_Monitoring_Event($res);
		}
		return $this->lastEvent;
        
    }
    public function __construct ($val = null) {
        parent::__construct('orders_monitoring__tarif', array(
            'id' => 'id' ,
            'num' => 'num' ,
            'p_m' => 'pM',
            'p_k' => 'pK',
            'p_h' => 'pH',
            'p_y' => 'pY',
            'order' => 'order',
            'is_active' => 'isActive',
            'tarif_id' => 'tarif_id',
			'type' => 'type'            
            ));        
            $this->load($val);
			
			//$this->pM=(float)$this->pM/(float)$this->num;
			//$this->pK=(float)$this->pK/(float)$this->num;
			//$this->pH=(float)$this->pH/(float)$this->num;			
    }
}

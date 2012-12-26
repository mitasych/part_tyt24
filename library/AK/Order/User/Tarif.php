<?php

class AK_Order_User_Tarif extends AK_Data_EntityOrder {

    public $id;
    public $userId;
    public $tarifId;
    public $startDate;
    public $endDateUser;
    public $endDateKurator;
	public $dateNextMon;
	public $dateEndMon;
    public $m;
    public $period = 7;
	public $count;
	public $all_id;
	public $price_one;
	public $order;
	public $lastEvent;
	public $history;
	public $country;
 
    private $Tarif = null;
    
    public function getCountry() {
        return  $this->country;
        }

public function getTarif() {
        if (null === $this->Tarif) {
            $this->Tarif = new AK_Order_Monitoring_Tarif($this->tarifId);
        }
		

		
   		//Zend_Debug::dump($this->Tarif);exit();
        return $this->Tarif;
    }

    public function lastInsertIdAddOne() {
    	$db = Zend_Registry::get('DBORDER');
			$query = $db->select()->from(
				     'orders_users__monitoring_tarifs',
				     array(				        
				         'max' => new Zend_Db_Expr('MAX(id)')
				     )
					); 

        return  $db->fetchOne($query)+1;
        } 

   public function getLastEvent() {
		if (empty($this->lastEvent))
		{
			$db = Zend_Registry::get('DBORDER');
			$query = $db->select();
			$query->from('orders_monitoring__events AS A', 'A.id');
			$query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE tarif_id = '.$this->tarifId.') AND A.event_date < '.$this->dateEndMon )
				  ->order('A.event_date DESC')
				  ->limit(1);
		//	print $query;
		//	die();
			$res = intval($db->fetchOne($query));
			
			$this->lastEvent = new AK_Order_Monitoring_Event($res);
		}
		return $this->lastEvent;
        
    }
    public function getStartDateFormatted() {
        return date('d.m.Y', $this->startDate);
    }

    public function getEndDateUserFormatted() {
		$setting = new AK_Order_Settings();
		
        if ($this->endDateUser - time() <= $setting->get('timered') ) {
            return ''.date('d.m.Y', $this->endDateUser).'';
        }
        return ''.date('d.m.Y', $this->endDateUser).'';
    }

    public function getEndDateKuratorFormatted() {
		$setting = new AK_Order_Settings();
        if ($this->endDateKurator - time() <= $setting->get('timered') ) {
            return date('d.m.Y', $this->endDateKurator);
        }
        return ''.date('d.m.Y', $this->endDateKurator).'';
    }
    // public function getEndDate() {
    //     return $this->endDateKurator;
    
    // }


    public function getDaysLeft() {
        return ($this->endDateKurator - time())/(60*60*24);
    }
	
    public function getActual() {
		$a = ($this->endDateKurator < mktime())?0:1;
        return $a;
    }

        public function getActualRed() { //604800
		$a = ($this->endDateKurator < mktime()+604800)?0:1;
        return $a;
    }
	
	
	// ���� ���������� ����������� 
	public function getNextMonDate() {
	    return date('d-m-Y', $this->dateNextMon);
	}
	 public function getTarifId($id) {
			$db = Zend_Registry::get('DBORDER');
			$query = $db->select('tarif_id');
			$query->from('orders_users__monitoring_tarifs AS A');
			$query->where('A.id=?',$id);
			$res = $db->fetchAll($query);
			$res =$res[0]['tarif_id'];
			return $res;			
			     
    }

    	 public function getTarifFromId($id) {
			$db = Zend_Registry::get('DBORDER');
			$query = $db->select('tarif_id');
			$query->from('orders_users__monitoring_tarifs AS A');
			$query->where('A.id=?',$id);
			$res = $db->fetchAll($query);
			$res =$res[0];
			return $res;			
			     
    }



	// расчет остатка с текушего счета 
	public function getResidue() {
     $redisue = 0;
	 $day = 60*60*24;
	 $total_sum = $this->count*$this->price_one;
	 
	 $redisue = ceil( (time () - $this->startDate)/$day); //дней прошло с начала старта мониторинга 
     $per = $this->checkPeriod($this->m); // период мониторинга 
     $price_in_one = $total_sum/$per; // стоимость за один день 
	 $redisue *= $price_in_one; // потрачено на мониториг ( прошло дней * на стоимость)	 
     $redisue = $total_sum - $redisue ;
	 $redisue = ceil($redisue); 
	 
     return $redisue;	 
    }	
	
	private function checkPeriod($period) {
	 
	 switch ($period) {
	  case '1': return 30;
	  case '3': return 90;
	  case '6': return 180;
	  case '12': return 360;	 
	 }
	 
	}
	
     public function __construct ($val = null) {
        parent::__construct('orders_users__monitoring_tarifs', array(
            'id' => 'id' ,
            'm' => 'm' ,
            'period' => 'period' ,
            'user_id' => 'userId' ,
            'tarif_id' => 'tarifId',
            'start_date' => 'startDate',
            'end_date_user' => 'endDateUser',
            'end_date_kurator' => 'endDateKurator',
			'date_next_mon' => 'dateNextMon',
			'count' => 'count',
			'all_id' => 'all_id',
            'price_one' => 'price_one',         
            'order' => 'order'            
            ));

        
            $this->load($val); 
			$dateNextMon = $this->dateNextMon+$this->period*86400;
			$this->dateEndMon=$this->dateNextMon;
			$this->dateNextMon=($dateNextMon < $this->endDateUser)?$dateNextMon: ('-');
			
			
    }
	
	public function getMaxTarifId(){
	    $db = Zend_Registry::get('DBORDER');
	    $id = $this->id;
		$query = "SELECT MAX(tarif_id) AS max FROM orders_users__monitoring_tarifs";
    	$res = $db->fetchCol($query);
		$max = (int)$res[0];
		return $max;
	}
	public function getTarifAll(){
	    if (!empty($this->all_id))
			return new AK_Order_Monitoring_TarifAll($this->all_id);
		else
			return null;
	}
	
	public function getEventCount($id_e){
		$db = Zend_Registry::get('DBORDER');
	    $id = $this->id;
		$query = "SELECT SUM(count) AS sum FROM orders_monitoring__statistic WHERE tarif_id = ".$this->id." and type_e = ".$id_e;
    	$res = $db->fetchCol($query);
		$sum = (int)$res[0];
		//print $query;
		return $sum;
		
	    if (!empty($this->all_id))
			return new AK_Order_Monitoring_TarifAll($this->all_id);
		else
			return null;
	}
	
}

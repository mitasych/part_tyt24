<?php

class AK_Order_Form_MonitoringTarif extends AK_Order_ZakazBase {

    public $m;
    public $tarifId;	
    public $ptSkidka; //скидка с пред тарифа
    public $uSkidka; //персональная скижка	
    public $period;
	
	public $mon_count; // кол-во мониторингов
	public $mon_price; // цена 
	public $mon_discount; // скидка
	public $new_tarif_id;
	public $new_tarif;
	public $price_one;
	public $between;
	public $paid_between;
	public $price_in_order;
	
    
    public $tableName = 'orders_form_monitoring_tarif';

	
	// формируется цена со скидкой
	    public function getInfo() {
        if ($this->m) {
            $tarif = new AK_Order_Monitoring_Tarif($this->tarifId);
            
        }
        return $tarif;
    }

   public function getInfo2() {
        if ($this->m) {
            $tarif = new AK_Order_User_Tarif($this->tarifId);
        }
        return $tarif;
    }
    public function getVarPrice($forceSkidkaU = false, $forceSkidkaPT = false) {
        
		$s = empty($this->ptSkidka)?0:$this->ptSkidka;
		$u = empty($this->uSkidka)?0:$this->uSkidka;
		
        if ($this->m) {
            $tarif = new AK_Order_Monitoring_Tarif($this->tarifId);
            
			if ($forceSkidkaU) {
                $u = 0;
            }
			
            if ($forceSkidkaPT) {
                $s = 0;
            }

            $per = AK_Order_Monitoring_Tarif_Period_Collection::getPeriodByPeriod($this->period);
            $pskidka = $per->skidka;

			
			// формируем общую сумму
            $total=$this->mon_price-$this->mon_price*$u;			
			
			return $total;
			 
            // switch(intval($this->m)) {
                // case 1: $c = ($tarif->pM-$tarif->pM*$pskidka/100); return ceil($c-$u*$c/100-$s);
                    // break;
                // case 3: $c = ($tarif->pK-$tarif->pK*$pskidka/100); return ceil($c-$u*$c/100-$s);
                    // break;
                // case 6: $c = ($tarif->pH-$tarif->pH*$pskidka/100); return ceil($c-$u*$c/100-$s);
                    // break;
                // case 12: $c = ($tarif->pY-$tarif->pY*$pskidka/100); return ceil($c-$u*$c/100-$s);
                    // break;

            // }
			
			
        }
        return null;
    }

    public function getPriceString() {

        $res = $this->getVarPrice(). ' руб.';
        if (!empty($this->ptSkidka) || !empty($this->uSkidka)) {
            $res.=' (скидка '.intval($this->getVarPrice(true, true)-$this->getVarPrice()).' руб.)';
        }

        return $res;
    }


	// добавляем 
    public function getIsMulti() {
        return true;
    }

	
	/* Old method  */
	
/*     public function getInfoString() {

        $result = '';
        if ($this->m) {
            $tarif = new AK_Order_Monitoring_Tarif($this->tarifId);
            $result.= 'Мониторинг. Тариф: '.$tarif->num.'-'.$this->m;
            if (!empty($this->ptSkidka) || !empty($this->uSkidka)) {
                $result.=' (скидка '.intval($this->getVarPrice(true, true)-$this->getVarPrice()).' руб.)';
            }
        }
        return $result;
    } */
	
	/* Voodoo */	
    public function getInfoString() {
        
		$per = AK_Order_Monitoring_Tarif_Period_Collection::getPeriodByPeriod($this->period);
		
        $result = '';
        if ($this->m) {
            $tarif = new AK_Order_Monitoring_Tarif($this->tarifId);
            $result.= 'Мониторинг. Тариф: '.$this->mon_count.'-'.$this->m.'-'.$this->checkPeriod($this->period);
            if (!empty($this->ptSkidka) || !empty($this->uSkidka)) {
                $result.=' (скидка '.$this->mon_discount.' руб.)';
            }
        }
        return $result;
    }
    
	/* Voodoo */
    private function checkPeriod($per) {
	  switch ($per) {
        case 7: return "1";
        case 14: return "2";
		case 28: return "4";
      }	  
    }

    public function setCount($id,$count) {
        $this->update($this->tablename, array( 'mon_count' => $count),$this->quoteInto('id = ?',$id));   
    }	
	
	public function getPriceInOrder(){
	 /// return parent::ge
	  
	}

    public function __construct ($value = null) {

        parent::__construct($this->tableName);

        $this->addField('m');
        $this->addField('period');
        $this->addField('tarif_id', 'tarifId');
        $this->addField('mon_count');
        $this->addField('new_tarif');
		$this->addField('price_one');
		$this->addField('between');
		$this->addField('paid_between');		
		
        $this->load($value);
        
        if (Zend_Registry::isRegistered('User')) {
            $user = Zend_Registry::get('User');
            if (!empty($user->id)) {
                $this->uSkidka = (int)$user->monitoringTarifSkidka;
            }
        }

//        
//        $periodList = new AK_Order_Monitoring_Tarif_Period_List;
//            $periodList->returnAsAssoc(true)->addWhere('A.is_active = 1')->setAssocValue('A.skidka');
//            $periodList = $periodList->getList();
//
//            if (!empty($user->id) && $user->getActualTarifInfo() && $user->getActualTarifInfo()->period && key_exists($user->getActualTarifInfo()->period, $periodList)) {
//
//                $this->uSkidka =  $periodList[$user->getActualTarifInfo()->period];
//                //$this->uSkidka = (int)$user->monitoringTarifSkidka;
//            }
//

    }
}

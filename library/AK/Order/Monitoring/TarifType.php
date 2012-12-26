<?php

class AK_Order_Monitoring_TarifType extends AK_Data_EntityOrder {

    public $id;
    public $name;
    public $active;
    public $about;

    public $simbol;
	
    public function __construct ($val = null) {
        parent::__construct('orders_monitoring__tarif_type', array(
            'id' => 'id' ,
            'name' => 'name' ,
            'active' => 'active' ,
            'about' => 'about' ,
            'simbol' => 'simbol'
            ));        
            $this->load($val);
			
			//$this->pM=(float)$this->pM/(float)$this->num;
			//$this->pK=(float)$this->pK/(float)$this->num;
			//$this->pH=(float)$this->pH/(float)$this->num;			
    }
}

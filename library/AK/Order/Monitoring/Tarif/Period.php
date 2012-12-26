<?php

class AK_Order_Monitoring_Tarif_Period extends AK_Data_EntityOrder {

    public $id;
    public $title;

    public $cnt;
    public $skidka = 0;
    
    public $order;
    public $isActive;
	public $type;

    public function getIsActiveColored() {
        if ($this->isActive) {
            return '<font color=green>активен</font>';
        } else {
            return '<font color=red>не активен</font>';
        }

    }
    public function __construct ($val = null) {
        parent::__construct('orders_monitoring__tarif_period', array(
            'id' => 'id' ,
            'title' => 'title' ,
            'skidka' => 'skidka',
            'cnt' => 'cnt',
            'order' => 'order',
            'is_active' => 'isActive',
			'type' => 'type'		 
            
            ));

        
            $this->load($val);
    }
}

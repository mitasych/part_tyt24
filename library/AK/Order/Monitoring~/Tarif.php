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

    public function getIsActiveColored() {
        if ($this->isActive) {
            return '<font color=green>активен</font>';
        } else {
            return '<font color=red>не активен</font>';
        }

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
            'is_active' => 'isActive'
            
            ));

        
            $this->load($val);
    }
}

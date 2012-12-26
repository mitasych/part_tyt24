<?php

class AK_Order_Monitoring_Event_Type extends AK_Data_EntityOrder {

    public $id;
    public $order;
    public $title;

    
    public function __construct ($val = null) {
        parent::__construct('orders_monitoring__events_types', array(
            'id' => 'id' ,
            'order' => 'order',
            'title' => 'title'
            
            ));

        
            $this->load($val);
    }
}

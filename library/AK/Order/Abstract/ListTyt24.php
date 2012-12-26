<?php
abstract class AK_Order_Abstract_ListTyt24 extends AK_Abstract_List{
    
    public function  __construct() {
        $this->_db = Zend_Registry :: get('DBORDER');
    }
}
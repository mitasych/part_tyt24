<?php

class AK_Order_Settings {

    private $_db;

    public function __construct() {
        $this->_db = Zend_Registry :: get('DBORDER');
    }

    public function get($key){
        $val = $this->_db->fetchRow("SELECT * FROM `orders_settings` WHERE `key`='".$key."'");
        return $val['value'];
    }

    public function set($key, $val){
        if ($this->_db->query($this->_db->quoteInto('REPLACE INTO `orders_settings` SET `value`= ?, `key`="'.$key.'"', $val))) return true;
        else return false;
    }


}

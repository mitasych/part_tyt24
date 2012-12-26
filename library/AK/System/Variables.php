<?php

class AK_System_Variables {

    private $_db;

    public function __construct() {
        $this->_db = Zend_Registry :: get('DB');
    }

    public function get($key){
        $val = $this->_db->fetchRow("SELECT * FROM `".DBT_PREFIX."_system__variables` WHERE `name`='".$key."'");
        switch ($val['type']){
          case "int": return intval($val['value']); break;
          default : return $val['value'];
        }
    }

    public function set($key, $val, $type = 'str'){
        if ($this->_db->query("UPDATE `".DBT_PREFIX."_system__variables` SET `value`='".$val."', `type`='".$type."' WHERE `name`='".$key."'")) return true;
        else return false;
    }

}

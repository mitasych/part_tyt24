<?php
class AK_Data_EntityTyt24Order extends AK_Data_Entity {
    public function __construct ($tableName = false, $fields = null) {
        parent::__construct($tableName, $fields);
        $this->_db = Zend_Registry::get("DBTYT24ORDER");

    }

    public function updateDB(){
        $this->_db = Zend_Registry::get("DBTYT24ORDER");
    }
}

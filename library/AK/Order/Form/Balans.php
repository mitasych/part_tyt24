<?php

class AK_Order_Form_Balans extends AK_Order_ZakazBase {

    public $val;
    
    public $tableName = 'orders_form_balans';

    public function getIsMulti() {//разрешено ли добавлять несколько элементов одного типа
        return false;
    }

    public function getIsUnique() {//надо ли при добавлении удалять все элементы из корзины
        return true;
    }

    public function getIsUniqueType() {//надо ли при добавлении удалять элементы других типов
        return true;
    }

    public function getInfoString() {

        $result = '';
        if ($this->val) {
            $result.= 'Сумма: '.$this->val;
        }
        return $result;
    }

    public function getPriceString() {

        return $this->getVarPrice(). ' руб.';
    }

    public function getVarPrice() {
        return $this->val;
    }

    public function __construct ($value = null) {

        parent::__construct($this->tableName);
        
        $this->addField('val');
       
        $this->load($value);
    }
}

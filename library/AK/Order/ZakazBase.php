<?php

abstract class AK_Order_ZakazBase extends AK_Data_EntityOrder {

    public $id;
    public $typeId; //не группа, именно заказ
    public $status;
    public $result;
    public $createdDate;
    public $updatedDate;
    public $defaultPriceHash;
    public $priceInOrder;

    private $PricesObject = null;

    public function getVarPrice() {
        return null;
    }

    public static function getId(){
        return null;
    }

    public function getIsMulti() {//разрешено ли добавлять несколько элементов одного типа
        return true;
    }

    public function getIsUniqueType() {//надо ли при добавлении удалять элементы других типов
        return false;
    }

    public function getIsUnique() {//надо ли при добавлении удалять все элементы из корзины
        return false;
    }

    public function getPricesObject() {
        if (null === $this->PricesObject) {
			$off = empty($this->off)?0:$this->off;
			$isoff = empty($this->isoff)?0:$this->isoff;
            $this->PricesObject = new AK_Order_Prices($this->typeId, $off, $isoff);
        }
        return $this->PricesObject;
    }

    public function getRelation() {
        $rl = new AK_Order_Relation_List();
        $rl->addWhere('A.zakaz_id = '.$this->id);
        $rl = $rl->getList();
        return $rl[0];
    }

    abstract public function getInfoString();
    abstract public function getPriceString();

    public function __construct ($tableName) {

        parent::__construct($tableName, array(
            'id' => 'id' ,
            'type_id' => 'typeId' ,
            'status' => 'status' ,
            'result' => 'result' ,
            'created_date' => 'createdDate',
            'updated_date' => 'updatedDate',
            'default_price_hash' => 'defaultPriceHash',
            'price_in_order' => 'priceInOrder'
        ));
    }
}

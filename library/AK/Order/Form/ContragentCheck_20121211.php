<?php

class AK_Order_Form_ContragentCheck extends AK_Order_ZakazBase {

    public $name;
    public $inn;
    public $ogrn;
    public $country;
    public $addr;
    public $isfiz;
    public $fizf;
    public $fizi;
    public $fizo;
    public $off;
    public $isoff;
    public $srochnist;
    public $type_obj;
    public $area;
    public $k_number;
    public $copy_red;
    public $copy_var;


    public $tableName = 'orders_form_contragent_check';

    public function getInfoString() {

        $result = '';
        if ($this->name) {
            $result.= 'Название: '.$this->name;
        }
        if ($this->inn) {
            $result.= 'ИНН: '.$this->inn;
        }
        if ($this->ogrn) {
            $result.= 'ОГРН: '.$this->ogrn;
        }
		if ($this->typeId == 28)
			if ($this->copy_var)
				$result.= 'Документы: '.$this->copy_var;
		if ($this->typeId == 29)
		{
			if ($this->addr)
				$result.= 'Адресс: '.$this->addr.' ';
			if ($this->area)
				$result.= 'Площадь: '.$this->area.' ';
			if ($this->k_number)
				$result.= 'Кадастровый номер: '.$this->k_number.' ';
		}		
      /*  if ($this->off) {
            $result.= ' Официальная ';
			if ($this->isoff) {
				$result.= ' срочная ';
			}
			else
				$result.= ' обычная ';
		}
		else
            $result.= ' Информационная ';*/
			

        return $result;
    }

    public function getPriceString() {
        if ($this->priceInOrder === null) {
            return 'цена требует уточнения';
        } else {
            return $this->priceInOrder. ' руб.';
        }

    }

   /* public function getPricesObject() {
        if (null === $this->PricesObject) {
            $this->PricesObject = new AK_Order_Prices($this->typeId, $this->off, $this->isoff);
        }
        return $this->PricesObject;
    }*/

    public function __construct ($value = null) {

        parent::__construct($this->tableName);
        
        $this->addField('name');
        $this->addField('inn');
        $this->addField('ogrn');
        $this->addField('country');
        $this->addField('addr');
        $this->addField('isfiz');
        $this->addField('fizf');
        $this->addField('fizi');
        $this->addField('fizo');
        $this->addField('srochnist');
        $this->addField('off');
        $this->addField('isoff');
        $this->addField('type_obj');
        $this->addField('area');
        $this->addField('k_number');
        $this->addField('copy_red');
        $this->addField('copy_var');


        $this->load($value);
    }
}

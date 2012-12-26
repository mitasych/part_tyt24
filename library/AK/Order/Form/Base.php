<?php

class AK_Order_Form_Base extends AK_Order_ZakazBase {

    public $company;
    public $cprofile;
    public $name;
    public $email;
    public $secondname;
    public $phone;
    public $text;
    public $isphone;
    public $isemail;
    public $isfax;
    public $isenum;
    public $enumfrom;
    public $enumto;
    public $isfinp;
    public $finptext;

    public $tableName = 'orders_form_base';

     public function getInfoString() {

        $c = '';

        if ($this->isphone) {
            $c.='телефон';
        }
        if ($this->isemail) {
            if (!empty($c)) {
                $c.=', ';
            }
            $c.='email';
        }
        if ($this->isfax) {
            if (!empty($c)) {
                $c.=', ';
            }
            $c.='факс';
        }
        if ($this->isenum) {
            if (!empty($c)) {
                $c.=', ';
            }
            $c.='период: с '.$this->enumfrom.' по '.$this->enumto;
        }
        if ($this->isfinp) {
            if (!empty($c)) {
                $c.='; ';
            }
            $c.='финансовые показатели: '.$this->finptext;
        }
        return htmlspecialchars($this->text).'<br>'.htmlspecialchars($c);
    }

    public function getPriceString() {
        if ($this->priceInOrder === null) {
            return 'цена требует уточнения';
        }
        else {
            return $this->priceInOrder. ' руб.';
        }

    }

    public function getIsUniqueType() {//надо ли при добавлении удалять элементы других типов
        return true;
    }

    public function __construct ($value = null) {

        parent::__construct($this->tableName);

        $this->addField('company');
        $this->addField('cprofile');
        $this->addField('name');
        $this->addField('email');
        $this->addField('secondname');
        $this->addField('phone');
        $this->addField('text');
        $this->addField('isphone');
        $this->addField('isemail');
        $this->addField('isfax');
        $this->addField('isenum');
        $this->addField('enumfrom');
        $this->addField('enumto');
        $this->addField('isfinp');
        $this->addField('finptext');

        $this->load($value);
    }
}

<?php

class AK_Order_Item extends AK_Data_EntityOrder {

    public $id;

    //user
    public $company;
    public $email; //

    //common
    public $placeCreated;
    public $dateCreated;
    public $dateUpdated;
    public $secretCode;
    public $price;

    public $additionalInfo;
    public $status;//статус общий
    public $priority;
    public $money;
    public $number;

    public $zaku;
    public $platu;
    public $telmob;
    public $telgor;
    public $addr;
    public $metro;
    public $ather;
    public $ik;
    public $relationsUser;



    private $ZakazList = null;


    public function getPriceString() {
        if ($this->price === null) {
            return 'цена требует уточнения';
        } else {
            return $this->price. ' руб.';
        }

    }
    public function __construct ($key = null, $val = null) {
        parent::__construct('orders', array(
            'id' => 'id' ,

            'company' => 'company' ,
            'email' => 'email' ,

            'place_created' => 'placeCreated' ,
            'date_created' => 'dateCreated' ,
            'date_updated' => 'dateUpdated' ,
            'secret_code' => 'secretCode' ,
            'price' => 'price' ,

            'additional_info' => 'additionalInfo' ,
            'priority' => 'priority',
            'money' => 'money',
            'number' => 'number',
            'status' => 'status',
			
            'telmob' => 'telmob',
            'telgor' => 'telgor',
            'addr' => 'addr',
            'metro' => 'metro',
            'ather' => 'ather',
            'ik' => 'ik',

            'zaku' => 'zaku',
            'platu' => 'platu'));

        if ($key !== null) {
            if (!is_array($key)) {
                $this->pkColName = $key;
                $this->loadByPk($val);
                $this->getRelListUser();
            }
            else {
                $this->load($key);
            }
        }
        else {
            $this->pkColName = 'id';
        }
    }



    public function getDateСreatedFormatted () {
        return date('d-m-Y H:i:s', $this->dateCreated);
    }

    public function getDateUpdatedFormatted () {
        return date('d-m-Y H:i:s', $this->dateUpdated);
    }

	public function getDateUpdatedFor() {
		$setting = new AK_Order_Settings();
        return mktime(date("H", $this->dateUpdated), date("i", $this->dateUpdated), date("s", $this->dateUpdated), date("n", $this->dateUpdated), date("j", $this->dateUpdated)+$setting->get('dayofinvoce'), date("Y", $this->dateUpdated));//date('d-m-Y H:i:s', $this->dateUpdated);
    }
	
    public function getPriorityLabel () {
        $list = AK_Order_Enum::getPList();
        return $this->priority?$list[$this->priority]:'';
    }

    public function getMoneyLabel () {
        if ($this->money) {
            $type_pay = new AK_Order_Pay_Item($this->money);

            return $type_pay->title;
        }
        return '';
    }
	
	public function getMoney () {
        if ($this->money) {
           //$money = new AK_Order_Pay_Item($this->money);
		   return $this->money;
        }
        return '';
    }

    public function getStatusLabel () {
        $list = AK_Order_OrderStatus::getList();
        return $this->status?$list[$this->status]:'';
    }

    public function isBalans() {
        if (!$this->id) {
            return AK_Order_Basket::isBalans();
        }
        $list = $this->getZakazList();
        if (!empty($list) && count($list) == 1 && $list[0] instanceof AK_Order_Form_Balans) {
            return true;
        } else {
            return false;
        }
    }
   
    public function getZakazList() {
        if (null === $this->ZakazList) {
            $this->ZakazList = array();
            $rl = new AK_Order_Relation_List();
            $rl->addWhere('A.order_id = '.$this->id);
            $rl = $rl->getList();
            foreach($rl as $ri) {
                $this->ZakazList[] = $ri->getZakaz();
            }

        }
        return $this->ZakazList;
    }

    public function getRelList() {
        $rl = new AK_Order_Relation_List();
        $rl->addWhere('A.order_id = '.$this->id);
        $rl = $rl->getList();

        return $rl;

    }
    public function getRelListNumber() {

        $r2 = new AK_Order_List();
        $r2->addWhere('A.number = '.$this->number);
        $r2 = $r2->getList();
        foreach ($r2 as $value) {
            $finish = $value->id;
        }

        $rl = new AK_Order_Relation_List();

        $rl->addWhere('A.order_id = '.$finish);
        $rl = $rl->getList();

        return $rl;

    }

    public function getRelListUser() {

        $rl = new AK_Order_Relation_List();

        $rl->addWhere('A.order_id = '.$this->id);
        $rl = $rl->getList();

        $this->relationsUser = $rl['0']->userId;


    }    
    //получние массива цен сгруппированных по типу и ценой елемента с учетом количества - для отправки квитанций
    public function getTotalPrices() {

        //ордер создан, все цены есть
        
        $countArray = array();

        foreach ($this->getZakazList() as $item) {
            if (!isset($countArray[$item->typeId])) {
                $countArray[$item->typeId] = 0;
            }

            $countArray[$item->typeId]++ ;
        }


        $resultArray = array();

        foreach ($countArray as $type=>$cnt) {
            $price = new AK_Order_Prices($type);
            $priceAmountByCnt = $price->getPriceByCount($cnt);
            if (null === $priceAmountByCnt) {// цена требует уточнения либо вводимая цена
                //метод используется  для вставки в квитанции , поэтому среди элементов не может быть с неопределенной ценой, она есть в getVarPrice

                $elements = array();
                foreach ($this->getZakazList() as $item) {
                   if ($item->typeId == $type){
                       $elements[] =  $item;
                   }
                }

                $tp = 0;
                foreach ($elements as $element) {
                    $tp+=$element->priceInOrder;
                }
                $resultArray[] = array('type' => $type, 'count' => $cnt, 'price'=> null, 'pricecnt' => $tp );
            } else {
                $resultArray[] = array('type' => $type, 'count' => $cnt, 'price'=> $priceAmountByCnt, 'pricecnt' => $priceAmountByCnt*$cnt );
            }
            
        }

        return $resultArray;
    }
	
	public function getServis() {
        $rl = new AK_Order_Relation_List();
        $rl->addWhere('A.order_id = '.$this->id);
      //  $rl->setLimit(1,0);
        $rl = $rl->getList();
		foreach($rl as $it)
		{

			if (!empty($it->zakazTypeId))
			{
				switch ($it->zakazTypeId) {
					case AK_Order_ZakazTypes::CONTRAGENT_CHECK:
						return 'Отчетность';
						break;
					case AK_Order_ZakazTypes::BASES:
						return 'БД предприятий';
						break;
					case AK_Order_ZakazTypes::OPERATIONS:
						return 'Баланс';
						break;
					case AK_Order_ZakazTypes::MONITORING:
						return 'Мониторинг';
						break;
					default: throw new exception('Incorrect zakaz type');
				}
			}
		}
        return '';
    }


    public function getServisSelect() {
        $rl = new AK_Order_Relation_List();
        $rl->addWhere('A.order_id = '.$this->id);
      //  $rl->setLimit(1,0);
        $rl = $rl->getList();
        foreach($rl as $it)
        {

            if (!empty($it->zakazTypeId))
            {
                switch ($it->zakazTypeId) {
                    case AK_Order_ZakazTypes::CONTRAGENT_CHECK:
                        $id_zakaz_types = AK_Order_ZakazTypes::CONTRAGENT_CHECK;
                        $zakaz_types_name_and_id = new Option();
                        $zakaz_types_name_and_id->id = $id_zakaz_types;
                        $zakaz_types_name_and_id->name = "Отчетность";
                        return $zakaz_types_name_and_id;
                        break;
                    case AK_Order_ZakazTypes::BASES:
                        $id_zakaz_types = AK_Order_ZakazTypes::BASES;
                        $zakaz_types_name_and_id = new Option();
                        $zakaz_types_name_and_id->id = $id_zakaz_types;
                        $zakaz_types_name_and_id->name = "БД предприятий";
                        return $zakaz_types_name_and_id;
                        break;
                    case AK_Order_ZakazTypes::OPERATIONS:
                        $id_zakaz_types = AK_Order_ZakazTypes::OPERATIONS;
                        $zakaz_types_name_and_id = new Option();
                        $zakaz_types_name_and_id->id = $id_zakaz_types;
                        $zakaz_types_name_and_id->name = "Баланс";
                        return $zakaz_types_name_and_id;
                        break;
                    case AK_Order_ZakazTypes::MONITORING:
                        $id_zakaz_types = AK_Order_ZakazTypes::MONITORING;
                        $zakaz_types_name_and_id = new Option();
                        $zakaz_types_name_and_id->id = $id_zakaz_types;
                        $zakaz_types_name_and_id->name = "Мониторинг";
                        return $zakaz_types_name_and_id;
                        break;
                    default: throw new exception('Incorrect zakaz type');
                }
            }
        }
        return '';
    }


	public function getURL($to = 1) {
		if ($to == 2)
			$url = '/users/schet/id/'.$this->id;
		else
			$url = '/users/akt/id/'.$this->id;
	   
		return $url;
	}

}

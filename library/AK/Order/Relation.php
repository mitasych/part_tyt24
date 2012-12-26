<?php

class AK_Order_Relation extends AK_Data_EntityOrder {

    public $id;
    public $orderId;
    public $zakazId;
    public $zakazTypeId;
    public $zakazSubtypeId;
    public $kuratorId;
    public $userId;
    public $fileName;
    public $fileTitle;

    private $Kurator = null;
    private $Zakaz = null;
    private $Order = null;

    public function __construct ($value = null) {
        parent::__construct('orders_relations', array(
            'id' => 'id' ,
            'order_id' => 'orderId' ,
            'zakaz_id' => 'zakazId' ,
            'zakaz_type_id' => 'zakazTypeId' ,
            'zakaz_subtype_id' => 'zakazSubtypeId',
            'kurator_id' => 'kuratorId',
            'user_id' => 'userId',
            'file_name' => 'fileName',
            'file_title' => 'fileTitle'
        ));

        $this->load($value);
    }

    public function getZakaz() {

        if (null === $this->Zakaz) {
            switch ($this->zakazTypeId) {
                case AK_Order_ZakazTypes::CONTRAGENT_CHECK:
                    $this->Zakaz = new AK_Order_Form_ContragentCheck($this->zakazId);
                    break;
                case AK_Order_ZakazTypes::BASES:
                    $this->Zakaz = new AK_Order_Form_Base($this->zakazId);
                    break;
                case AK_Order_ZakazTypes::OPERATIONS:
                    $this->Zakaz = new AK_Order_Form_Balans($this->zakazId);
                    break;
                case AK_Order_ZakazTypes::MONITORING:
                    $this->Zakaz = new AK_Order_Form_MonitoringTarif($this->zakazId);
                    break;
                default: throw new exception('Incorrect zakaz type');
            }
        }

        return $this->Zakaz;
    }

    public function getOrder() {

        if (null === $this->Order) {
            $this->Order = new AK_Order_Item('id', $this->orderId);
        }

        return $this->Order;
    }


    public function getOrderEmail() {
        return $this->getOrder()->email;
    }

    public function getOrderCompany() {
        return $this->getOrder()->company;
    }

    public function getOrderMoney() {
        if (empty($this->getOrder()->money)) return '';
        $list = AK_Order_Enum::getOOList();
        return $list[$this->getOrder()->money];
    }

    public function approve ($view) {
        $zakaz =  $this->getZakaz();
        $zakaz->status = AK_Order_ZakazStatus::PAID;
        $zakaz->updatedDate = time();
        $zakaz->save();

        $order = new AK_Order_Item('id', $this->orderId);

        $do = true;
        foreach ($order->getZakazList() as $z) {
            if ($z->status != AK_Order_ZakazStatus::PAID) {
                $do = false;
            }
        }
        if ($do) {
            $order->status = AK_Order_OrderStatus::PAID;
            $order->dateUpdated = time();
            $order->save();
            AK_Order_Collection::sendOrderPaidClient($order);
            AK_Order_Collection::sendOrderPaidKurator($order, $view);

        }

        if ($zakaz instanceof AK_Order_Form_Balans) {
            $this->doit();
        }
    }

    public function doit () {
        $zakaz =  $this->getZakaz();
        $zakaz->status = AK_Order_ZakazStatus::DONE;
        $zakaz->updatedDate = time();
        $zakaz->save();

        $order = new AK_Order_Item('id', $this->orderId);

        $do = true;
        foreach ($order->getZakazList() as $z) {
            if ($z->status != AK_Order_ZakazStatus::DONE) {
                $do = false;
            }
        }
        if ($do) {
            $order->status = AK_Order_OrderStatus::READY;
            $order->dateUpdated = time();
            $order->save();
            AK_Order_Collection::sendOrderReady($order);

        }

        if ($zakaz instanceof AK_Order_Form_Balans) {
            $user = new AK_Order_User('id', $this->userId);
            $user->balans = $user->balans+$zakaz->val;
            $user->save();
        }
    }



    public function getKuratorName () {
        if (empty($this->kuratorId)) {
            $_name = 'Не привязан';
        }
        else {
            $_name = $this->getKurator()->name;
        }

        return $_name;
    }

    public function getKurator() {
        if (null === $this->KuratorId) {
            $this->Kurator = new AK_Administrator('id', $this->kuratorId);
        }

        return $this->Kurator;
    }

    public function getZakazInfoString () {
        return $this->getZakaz()->getInfoStringAdmin();
    }

    public function getZakazInfoStringSimple () {
        return $this->getZakaz()->getInfoStringSimple();
    }

    public function getZakazGroupInfo () {

        $order = new AK_Order_Item('id', $this->orderId);
        return "Номер/код: ".$order->number.'/'.$order->secretCode."<br>Заказчик : ".$order->zaku."<br>Плательщик : ".$order->platu;
    }

    public function getZakazTypeName() {
        return $this->getZakaz()->getPricesObject()->getName();
    }

    public function getZakazGroupName() {
        return $this->getZakaz()->getPricesObject()->getGroupName();
    }

    public function getZakazStatusLabel () {
        $list = AK_Order_ZakazStatus::getList();
        return $this->getZakaz()->status?$list[$this->getZakaz()->status]:'';
    }

    public function getZakazCreatedDateFormatted () {
        return date('d-m-Y H:i:s', $this->getZakaz()->createdDate);
    }

    public function getZakazUpdatedDateFormatted () {
        return date('d-m-Y H:i:s', $this->getZakaz()->updatedDate);
    }

    public function getZakazPriceInOrder () {
        return $this->getZakaz()->priceInOrder;
    }

    public function getZakazPriceDetect () {
        if ($this->getZakaz()->status == AK_Order_ZakazStatus::PRICE_NOT_DETECTED) {
            $result="<a href='/admin/kurator/setprice/id/".$this->id."/'>".'Указать'."</a>";
            return $result;
        }

        return $this->getZakazPriceInOrder();

    }

    public function getAttachedFileAdmin() {
        $result = '';
        if ($this->fileName) {
            $result.= '<a target="_blank" href="'.SITE_URL.'/upload/files/'.$this->fileName.'"><font color=green>'.$this->fileTitle.'</font></a><br>';
            $t = '<font color=blue>Изменить</font>';
        }
        else {
            $t = '<font color=red>Прикрепить</font>';
        }

        $result.="<a href='/admin/kurator/attach/id/".$this->id."/'>".$t."</a>";
        return $result;
    }

    public function getAttachedFileUser() {
        $result = '';
        if ($this->fileName) {
            $result.= '<a target="_blank" href="'.SITE_URL.'/upload/files/'.$this->fileName.'"><font color=green>'.$this->fileTitle.'</font></a>';
        }
        return $result;
    }



}

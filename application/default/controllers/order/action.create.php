<?php
//$_SESSION['ORDER_IN_PROGRESS'] = false;
if (empty($_SESSION['ORDER_IN_PROGRESS'])) {
   // $this->_redirect('/order/basket/');
}

$ListPay2 = new AK_Order_Pay_ListType();
$this->view->ListPay2 = $ListPay2->returnAsAssoc(true)->getList();
$ListPay = new AK_Order_Pay_List();
$ListPay->setOrder('group');



$status = $this->_user->status;

foreach ($ListPay->getListWhere() as $value) {
    if($value->user_status==""){} else{
           $userStatusArray = unserialize($value->user_status);
            foreach ($userStatusArray as $valueArray) {

                if($valueArray == "$status"){
                    $payList[] = $value;
                }

            } 
    }

  
}

$this->view->ListPay = $payList;


if ($this->_user->id && !AK_Order_Basket::isBalans()) {
    if (AK_Order_Basket::isTotalAmountDefined() && AK_Order_Basket::getTotalAmount() > $this->_user->balans) {
        $this->_redirect('/order/basket/');
    }


    $this->params = array();    
    $this->params['name'] = $this->_user->organization;
    $this->params['email'] = $this->_user->email;
    $this->params['priority'] = AK_Order_Enum::P_MEDIUM;
    $this->params['money'] = AK_Order_Enum::O_REGISTERED;
    $this->params['zaku'] = '';
    $this->params['platu'] = '';

}
else {
    $this->params = $this->getRequest()->getParams();
}

$pItems =  AK_Order_Enum::getPList();
$this->view->pItems = $pItems;

$oItems =  AK_Order_Enum::getOList();
$this->view->oItems = $oItems;


$form = new AK_Form('createForm', 'post', '/order/create/');

$form->addRule('email', 'required', 'Введите Email');
$form->addRule('email', 'email', 'Введите правильный Email');

if (AK_Order_Basket::isTotalAmountDefined()) {
    $form->addRule('money', 'required', 'Выберите способ оплаты');
}

//$form->addRule('priority', 'required', 'Выберите приоритет');

if ($form->isPostBack()) {

    if (AK_Order_Basket::isTotalAmountDefined()) {
        if (empty($this->params['money']) || !AK_Order_Enum::isInO($this->params['money'])) {
          //  $form->addRule('money1', 'required',  'Выберите способ оплаты');
        }

       // if (!empty($this->params['money']) && $this->params['money'] == AK_Order_Enum::O_BEZNAL) {
       //     $form->addRule('zaku', 'required',  'Введите заказчика');
       //     $form->addRule('platu', 'required',  'Введите плательщика');
       // }

    }


   // if (empty($this->params['priority']) || !AK_Order_Enum::isInP($this->params['priority'])) {
    //    $form->addRule('priority1', 'required',  'Выберите приоритет');
   // }
}
else {
    if (!($this->_user->id && !AK_Order_Basket::isBalans())) {
        $this->params['priority'] = AK_Order_Enum::P_MEDIUM;
        $this->params['money'] = AK_Order_Enum::O_NAL;
    }
}

if ($form->validate($this->params) || ($this->_user->id && !AK_Order_Basket::isBalans()) ) {
    $sendOrderKurator = false;
    $sendOrderCreatedNoprice = false;
    $sendBeznalKurator = false;
        $sendNalKurator = false;

    $redirectToEmoney = false;
    $redirectToEmoney2 = false;
    $redirectToWEBmoney = false;
    $redirectToRegistered = false;
    $redirectToMonitorng = false;
    $_SESSION['ORDER_IN_PROGRESS'] = true;
    //order
    $order = new AK_Order_Item();
    $order->company = (empty($this->params['company'])?'': $this->params['company']);
    $order->email = $this->params['email'];
    $order->placeCreated = SITE_URL;
    $order->dateCreated = time();
    $order->dateUpdated = $order->dateCreated;
    $order->secretCode = AK_Common_Functions::generatePassword(12);
    while (AK_Order_Validate::isSecretCodeExists($order->secretCode)) {
        $order->secretCode = AK_Common_Functions::generatePassword(12);
    }
    $order->status = AK_Order_OrderStatus::CREATED;
    $order->additionalInfo = '';
    $order->priority = $this->params['priority'];
    $order->kuratorId = null;
    $order->number = AK_Order_Schet::get();
    $order->zaku = (empty($this->params['zaku'])?'': $this->params['zaku']);
    $order->platu = (empty($this->params['platu'])?'': $this->params['platu']);
    $order->telmob = (empty($this->params['telmob'])?'': $this->params['telmob']);
    $order->telgor = (empty($this->params['telgor'])?'': $this->params['telgor']);
    $order->addr = (empty($this->params['addr'])?'': $this->params['addr']);
    $order->metro = (empty($this->params['metro'])?'': $this->params['metro']);
    $order->ather = (empty($this->params['ather'])?'': $this->params['ather']);

    if (!AK_Order_Basket::isTotalAmountDefined()) {
        $order->status = AK_Order_OrderStatus::PRICE_NOT_DETECTED;
        $this->params['money'] = null;
        $sendOrderCreatedNoprice = true;
    }
    else {
	   
		$maneyitem = new AK_Order_Pay_Item($this->params['money']);
        if ($maneyitem->type_pay == 1) {
            
            AK_Order_Collection::sendBeznalClient($order);
            $order->money = $this->params['money'];
            $order->price = AK_Order_Basket::getTotalAmount();
            $order->status = AK_Order_OrderStatus::WAITING_FOR_PAYMENT;
            $order->save();
            $sendBeznalKurator = true;
        }
        elseif ($maneyitem->type_pay == 0) {
            
            
            AK_Order_Collection::sendNalClient($order);
            $order->money = $this->params['money'];
            $order->price = AK_Order_Basket::getTotalAmount();
            $order->status = AK_Order_OrderStatus::WAITING_FOR_PAYMENT;
            $order->save();
            $sendNalKurator = true;
        }
        elseif ($maneyitem->type_pay == 2) {
            $redirectToEmoney = true;
            $order->money = $this->params['money'];
            $order->price = AK_Order_Basket::getTotalAmount();
            $order->status = AK_Order_OrderStatus::WAITING_FOR_PAYMENT;
            $order->ik = $this->params['price_pay'];
            $order->save();
            AK_Order_Collection::sendOrderCreatedClient($order);
            $sendOrderKurator = true;
        }
        elseif ($maneyitem->type_pay == 3) {
            $redirectToWEBmoney = true;
            $order->money = $this->params['money'];
            $order->price = AK_Order_Basket::getTotalAmount();
            $order->status = AK_Order_OrderStatus::WAITING_FOR_PAYMENT;
            $order->save();
            AK_Order_Collection::sendOrderCreatedClient($order);
            $sendOrderKurator = true;
        }
        elseif ($this->params['money'] == AK_Order_Enum::O_REGISTERED) {
            $redirectToRegistered = true;
            $order->money = $this->params['money'];
            $order->price = AK_Order_Basket::getTotalAmount();
            $order->status = AK_Order_OrderStatus::WAITING_FOR_PAYMENT;
            $order->save();
            $sendOrderKurator = true;
        }


    }

    //zakaz
    foreach (AK_Order_Basket::getItems() as $id => $item) {
        $item->updateDB();
        $pricesObj = $item->getPricesObject();

        if (null === $pricesObj->getPriceByCount(1) && null === $item->getVarPrice()) {
            $item->status = AK_Order_ZakazStatus::PRICE_NOT_DETECTED;
        }
        else {
            $item->status = AK_Order_ZakazStatus::WAITING_FOR_PAYMENT;
            $item->priceInOrder = AK_Order_Basket::getElementPrice($id);
        }


        $item->result = '';
        $item->createdDate = $order->dateCreated;
        $item->updatedDate = $order->dateCreated;
        $item->defaultPriceHash = $pricesObj->price;

        $item->save();
        $price = new AK_Order_Prices($item->typeId);
        $relation = new AK_Order_Relation();
        $relation->orderId = $order->id;
        $relation->zakazId = $item->id;
        $relation->zakazTypeId = $price->group;
        $relation->zakazSubtypeId = $item->typeId;
        $relation->kuratorId = null;
        $relation->userId = empty($this->_user->id)?null:$this->_user->id;
        $relation->save();

    }

    if ($sendOrderKurator) {
        AK_Order_Collection::sendOrderCreatedKurator($order, $this->view);
    }
    if ($sendOrderCreatedNoprice) {
        AK_Order_Collection::sendOrderCreatedNoprice($order, $this->view);
    }
    if ($sendBeznalKurator) {
        AK_Order_Collection::sendBeznalKurator($order, $this->view);
    }
    if ($sendNalKurator) {
        AK_Order_Collection::sendNalKurator($order, $this->view);
    }


    if ($redirectToRegistered) {

        $this->_user->balans = $this->_user->balans - AK_Order_Basket::getTotalAmount();
        $this->_user->save();

        $orderItem = $order;

        $orderItem->status = AK_Order_OrderStatus::PAID;
        $orderItem->dateUpdated = time();
        
        $orderItem->save();
        AK_Order_Collection::sendOrderPaidClient($orderItem);
        AK_Order_Collection::sendOrderPaidKurator($orderItem, $this->view);
        $zlist = $orderItem->getZakazList();
        foreach ($zlist as $zakaz) {
            $zakaz->updatedDate = time();
            $zakaz->status = AK_Order_ZakazStatus::PAID;


            if ($zakaz->typeId == AK_Order_ZakazTypes::MONITORING_TARIF) {
                $tarif = new AK_Order_User_Tarif();
                $tarif->userId = $this->_user->id;
                $tarif->tarifId = $zakaz->tarifId;
                $tarif->startDate = time();
                $tarif->endDateUser = $tarif->startDate + $zakaz->m*30*24*60*60;
                $tarif->endDateKurator = $tarif->endDateUser;
                $tarif->m = $zakaz->m;
                $tarif->save();
                $zakaz->status = AK_Order_ZakazStatus::DONE;

                if (count($zlist) == 1) {
                    $orderItem->status = AK_Order_OrderStatus::DONE;
                    $orderItem->save();
                    $redirectToMonitorng = true;
                }
            }

            $zakaz->save();
        }
    }

    AK_Order_Basket::clear();
    unset($_SESSION['ORDER_IN_PROGRESS']);

    if ($redirectToRegistered) {
        if ($redirectToMonitorng) {
            $this->_redirect('/monitoring/');
        }
        $this->_redirect('/order/show/sc/'.$order->secretCode.'/');
    }
    elseif ($redirectToEmoney) {
        $this->_redirect('/order/epay/sc/'.$order->secretCode.'/');
    }
    elseif ($redirectToEmoney2) {
        $this->_redirect('/order/epay2/sc/'.$order->secretCode.'/');
    }
    elseif ($redirectToWEBmoney) {
        $this->_redirect('/order/wepay/sc/'.$order->secretCode.'/');
    }
    else {
        $this->_redirect('/order/created/sc/'.$order->secretCode.'/');
    }


}
else {
    $form->setDefaults($this->params);
    $this->view->form = $form;
}
$this->view->fparams = $this->params;

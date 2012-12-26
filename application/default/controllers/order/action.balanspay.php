<?php

$sc = $this->getRequest()->getParam('sc');
$order = new AK_Order_Item('secret_code', $sc);

$ListPay2 = new AK_Order_Pay_ListType();
$this->view->ListPay2 = $ListPay2->returnAsAssoc(true)->getList();

$ListPay = new AK_Order_Pay_List();
$payList = array();
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
if (empty($order->id) || $order->status != AK_Order_OrderStatus::WAITING_FOR_PAYMENT || empty($order->price)) {
    $this->_redirect('/order/basket/');
}

if ($this->_user->id && !$order->isBalans()) {
    if ($order->price > $this->_user->balans) {
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


$form = new AK_Form('createForm', 'post', '/order/pay/');

$form->addRule('email', 'required', 'Введите Email');
$form->addRule('email', 'email', 'Введите правильный Email');

$form->addRule('money', 'required', 'Выберите способ оплаты');

//$form->addRule('priority', 'required', 'Выберите приоритет');

if ($form->isPostBack()) {

    if (empty($this->params['money']) || !AK_Order_Enum::isInO($this->params['money'])) {
        $form->addRule('money1', 'required',  'Выберите способ оплаты');
    }

    if (!empty($this->params['money']) && $this->params['money'] == AK_Order_Enum::O_BEZNAL) {
        $form->addRule('zaku', 'required',  'Введите заказчика');
        $form->addRule('platu', 'required',  'Введите плательщика');
    }

    //if (empty($this->params['priority']) || !AK_Order_Enum::isInP($this->params['priority'])) {
  //      $form->addRule('priority1', 'required',  'Выберите приоритет');
    //}
}
else {
    if (!$this->_user->id) {
        $this->params['priority'] = AK_Order_Enum::P_MEDIUM;
        $this->params['money'] = AK_Order_Enum::O_NAL;
    }
}

if ($form->validate($this->params) || ($this->_user->id && !$order->isBalans()) ) {
    $redirectToEmoney = false;
    $redirectToEmoney2 = false;
    $redirectToWEBmoney = false;
    $redirectToRegistered = false;

//    $order->company = (empty($this->params['company'])?'': $this->params['company']);
//    $order->email = $this->params['email'];

    $order->additionalInfo = '';
    $order->priority = $this->params['priority'];
    $order->kuratorId = null;
//    $order->number = AK_Order_Schet::get();
    $order->zaku = (empty($this->params['zaku'])?'': $this->params['zaku']);
    $order->platu = (empty($this->params['platu'])?'': $this->params['platu']);

    $order->telmob = (empty($this->params['telmob'])?'': $this->params['telmob']);
    $order->telgor = (empty($this->params['telgor'])?'': $this->params['telgor']);
    $order->addr = (empty($this->params['addr'])?'': $this->params['addr']);
    $order->metro = (empty($this->params['metro'])?'': $this->params['metro']);
    $order->ather = (empty($this->params['ather'])?'': $this->params['ather']);

	
	$maneyitem = new AK_Order_Pay_Item($this->params['money']);
    
	//if ($this->params['money'] == AK_Order_Enum::O_BEZNAL) {
    if ($maneyitem->type_pay == 1) {
        $order->money = $this->params['money'];
        $order->save();
        AK_Order_Collection::sendBeznalClient($order);
        AK_Order_Collection::sendBeznalKurator($order, $this->view);
    }
    //elseif ($this->params['money'] == AK_Order_Enum::O_NAL) {
    elseif ($maneyitem->type_pay == 0) {
        $order->money = $this->params['money'];
        $order->save();
        AK_Order_Collection::sendNalClient($order);
        AK_Order_Collection::sendNalKurator($order, $this->view);
    }
    //======================================================================
    //elseif ($this->params['money'] == AK_Order_Enum::O_EMONEY) {
    elseif ($maneyitem->type_pay == 2) {
        $redirectToEmoney = true;
        $order->money = $this->params['money'];
        $order->ik = $this->params['price_pay'];
        $order->save();
        AK_Order_Collection::sendOrderCreatedClient($order);
        AK_Order_Collection::sendOrderCreatedKurator($order, $this->view);
    }
   /* elseif ($this->params['money'] == AK_Order_Enum::O_EMONEY2) {
        $redirectToEmoney2 = true;
        $order->money = $this->params['money'];
        $order->save();
        AK_Order_Collection::sendOrderCreatedClient($order);
        AK_Order_Collection::sendOrderCreatedKurator($order, $this->view);
    }*/
    //elseif ($this->params['money'] == AK_Order_Enum::O_WEBMONEY) {
    elseif ($maneyitem->type_pay == 3) {
        $redirectToWEBmoney = true;
        $order->money = $this->params['money'];
        $order->save();
        AK_Order_Collection::sendOrderCreatedClient($order);
        AK_Order_Collection::sendOrderCreatedKurator($order, $this->view);
    }
    elseif ($this->params['money'] == AK_Order_Enum::O_REGISTERED) {
        $redirectToRegistered = true;
        $order->money = $this->params['money'];
        $order->save();
        AK_Order_Collection::sendOrderCreatedKurator($order, $this->view);
    }
    else {
        $order->money = $this->params['money'];
        $order->save();
    }



    if ($redirectToRegistered) {

        $this->_user->balans = $this->_user->balans - $order->price;
        $this->_user->save();

        $orderItem = $order;

        $orderItem->status = AK_Order_OrderStatus::PAID;
        $orderItem->dateUpdated = time();
        $orderItem->save();
        AK_Order_Collection::sendOrderPaidClient($orderItem);
        AK_Order_Collection::sendOrderPaidKurator($orderItem, $this->view);
        foreach ($orderItem->getZakazList() as $zakaz) {
            $zakaz->updatedDate = time();
            $zakaz->status = AK_Order_ZakazStatus::PAID;
            $zakaz->save();
        }

        $this->_redirect('/order/show/sc/'.$order->secretCode.'/');

    }


    if ($redirectToEmoney) {
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
$this->view->orderItem = $order;
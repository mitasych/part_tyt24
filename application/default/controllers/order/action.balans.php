<?php

if (!$this->view->user->isAuthenticated() || !$this->view->user->getId()) {
    $this->_redirect(SITE_URL);
}
if(!empty($this->params['col'])){
    $col = $this->params['col']; 
} else{
    $col = "";     
}
if($col > 0)
	$this->view->Basket = new AK_Order_Basket;
else
	$col= 0;




$this->view->col = $col;

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
//==============================================================================
$pItems =  AK_Order_Enum::getPList();
$this->view->pItems = $pItems;

$oItems =  AK_Order_Enum::getOList();
$this->view->oItems = $oItems;

if ($this->getRequest()->isXmlHttpRequest()) {

    if (isset($_REQUEST['money_type']))     
        $money_type=$_REQUEST['money_type']; 

    if (isset($_REQUEST['money_type'])==""){
        $money_type = "";
    } 

    if (isset($_REQUEST['pay_variant']))     
        $pay_variant=$_REQUEST['pay_variant']; 

    if (isset($_REQUEST['pay_variant'])==""){
        $pay_variant = "";
    } 

    $this->_user->getSavePay($money_type, $pay_variant);
}

if($this->_user->save_pay==""){
    $paySettings = "";
}else{
    $paySettings = unserialize($this->_user->save_pay);
}


$form = new AK_Form('createForm', 'post', '/order/balans/');

$form->addRule('balans', 'required', 'Введите сумму');
$form->addRule('balans', 'numeric', 'Введите правильную сумму');

$form->addRule('money', 'required', 'Выберите способ оплаты');

if ($form->isPostBack()) {

   /* if (empty($this->params['money']) || !AK_Order_Enum::isInO($this->params['money'])) {
        $form2->addRule('money1', 'required',  'Выберите способ оплаты');
    }*/

    /*if (!empty($this->params['money']) && $this->params['money'] == 4) {
        $form2->addRule('zaku', 'required',  'Введите заказчика');
        $form2->addRule('platu', 'required',  'Введите плательщика');
    }*/

   // $this->params['priority'] = AK_Order_Enum::P_URGENT;
}
else {
   // $this->params['priority'] = AK_Order_Enum::P_URGENT;
   // $this->params['money'] = AK_Order_Enum::O_NAL;
}

if ($form->validate($this->params)) {

    $item = new AK_Order_Form_Balans();

    $item->val = intval($this->params['balans']);

    $item->typeId = AK_Order_ZakazTypes::OPERATIONS_BALANS;
    AK_Order_Basket::clear();
    
    AK_Order_Basket::add($item);
       
    include_once (APP_DIR . '/' . MODULE_NAME . '/controllers/order/action.create2.php');
}
else {
    if (!$form->isPostback() && !empty($this->_user->id)) {
        $this->params['email'] = $this->_user->email;
    }
    $form->setDefaults($this->params);
    $this->view->form = $form;
}


//==============================================================================

$this->view->fparams = $this->params;

//==============================================================================
$currentInfo = new AK_Article_Item();
$currentInfo->loadByRewriteName('balans');
$this->view->currentInfo = $currentInfo;

$this->view->TITLE = 'Пополнение баланса';

if ($currentInfo->getMetaTitle()) {
    $this->view->TITLE = $currentInfo->getMetaTitle();
}
elseif ($currentInfo->getTitle()) $this->view->TITLE = $currentInfo->getTitle();
if ($currentInfo->getMetaKeywords()) {
    $this->view->KEYWORDS = $currentInfo->getMetaKeywords();
}
if ($currentInfo->getMetaDescription()) {
    $this->view->DESCRIPTION = $currentInfo->getMetaDescription();
}

$this->view->Basket = new AK_Order_Basket;

$settings = new AK_Order_Settings();

$this->view->minimumvaluemoney = $settings->get('minimumvaluemoney');
if($this->_user->save_pay=="") {} else{
$this->view->money_type_save = $paySettings["1"];
$this->view->pay_variant_save = $paySettings["2"];
}
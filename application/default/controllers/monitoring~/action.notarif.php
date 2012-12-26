<?php

$tarifsList = new AK_Order_Monitoring_Tarif_List();
$tarifsList->addWhere('A.is_active = 1');
$this->view->tarifsList = $tarifsList->getList();


//==============================================================================
$form = new AK_Form('tarifForm', 'post', SITE_URL.'/monitoring/notarif/');

$form->addRule('m', 'required', 'Выберите тариф');

if ($form->isPostBack()) {

    $res = false;
    if (!empty($this->params['m'])) {
        $parts = explode('-',$this->params['m']);
        if (count($parts) == 2) {
            $tarif = new AK_Order_Monitoring_Tarif($parts[0]);
            if ($tarif->id && in_array(intval($parts[1]),array(1,3,6,12)) ){
                $res = true;
            }
        }
    }

    if (!$res) {
        $form->addRule('m1', 'required', 'Выберите тариф.');
    }
}

if ($form->validate($this->params)) {

    $item = new AK_Order_Form_MonitoringTarif();

    $item->m = $parts[1];
    $item->tarifId = $parts[0];
    
    $item->typeId = AK_Order_ZakazTypes::MONITORING_TARIF;

    AK_Order_Basket::add($item);

    $this->_redirect('/monitoring/notarif/');
}
else {
    $form->setDefaults($this->params);
    $this->view->form = $form;
}
//==============================================================================

$this->view->fparams = $this->params;

//==============================================================================
$currentInfo = new AK_Article_Item();
$currentInfo->loadByRewriteName('notarif');
$this->view->currentInfo = $currentInfo;

$this->view->TITLE = 'Выбор тарифа';

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
$this->view->form = $form;

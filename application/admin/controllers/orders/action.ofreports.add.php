<?php

$this->params = $this->getRequest()->getParams();

$this->params['id'] = isset($this->params['id']) ? intval($this->params['id']) : null;
$currentItem = new AK_Order_Ofreport($this->params['id']);
//
$ListRegions = new AK_Order_Report_ListRegions();
$this->view->ListRegions = $ListRegions->returnAsAssoc(true)->getList();
//

$form = new AK_Form('editItem', 'post', MODULE_URL . '/orders/ofreports.add/');
// $form->addRule('title', 'required', 'Введите название');
//$form->addRule('code', 'required', 'Введите код');

if ($form->isPostback()) {
    $form->setDefaults($this->params);
}

if ($form->validate($this->params)) {

    $currentItem->order_report_id = $this->params['order_report'];
    $currentItem->region_code = $this->params['region_code'];
    $currentItem->price2 = $this->params['price2'];
    $currentItem->term2 = $this->params['term2'];
    $currentItem->price3 = $this->params['price3'];
    $currentItem->term3 = $this->params['term3'];
    $currentItem->price_shipping = $this->params['price_shipping'];
    $currentItem->term_shipping = $this->params['term_shipping'];
    $currentItem->note = $this->params['note'];
    $currentItem->active = empty($this->params['active']) ? 0 : 1;
    $currentItem->flag1 = empty($this->params['flag1']) ? 0 : 1;
    $currentItem->flag2 = empty($this->params['flag2']) ? 0 : 1;
    $currentItem->flag3 = empty($this->params['flag3']) ? 0 : 1;
    $currentItem->save();

    $this->_redirect(MODULE_URL . '/orders/ofreports/');
}

$this->view->form = $form;
$this->view->currentItem = $currentItem;



$ordersList = new AK_Order_Report_List;



//~ echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($ordersList->returnAsAssoc(true)->getList()); echo'</pre>';die;
// $categoriesList->addWhere("A.menu_id = '1'");
$this->view->ordersList = $ordersList->returnAsAssoc(true)->getList();



// echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($this->view->ordersList); echo'</pre>';die;

$this->view->BODY_CONTENT_FILE = "orders/ofreports.add.tpl";

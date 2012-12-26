<?php

$this->params= $this->getRequest()->getParams();

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;  
$currentItem = new AK_Location_Country($this->params['id']);

$form = new AK_Form('editItem', 'post', MODULE_URL.'/orders/country.add/');
$form->addRule('name', 'required', 'Введите название');
$form->addRule('code', 'required', 'Введите код');

if ($form->isPostback()){
  $form->setDefaults($this->params);  
}

if ($form->validate($this->params)){
    
    $currentItem->name = $this->params['name'];
    $currentItem->code = $this->params['code'];
    $currentItem->monitoringList = empty($this->params['monitoringList'])?0:1;
    $currentItem->registerList = empty($this->params['registerList'])?0:1;
     
    $currentItem->save();

    $this->_redirect(MODULE_URL.'/orders/countries.list/');
}

$this->view->form = $form;
$this->view->currentItem = $currentItem;

$this->view->BODY_CONTENT_FILE = "orders/country.add.tpl";

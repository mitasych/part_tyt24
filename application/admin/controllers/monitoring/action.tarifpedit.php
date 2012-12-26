<?php

$this->params  = $this->getRequest()->getParams();

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;  
$currentItem = new AK_Order_Monitoring_Tarif_Period($this->params['id']);

$form = new AK_Form('editItem', 'post', MODULE_URL.'/monitoring/tarifpedit/');

if ($form->isPostback()) {
    $this->params['isActive'] = empty($this->params['isActive'])?0:1;
    $form->setDefaults($this->params);
}


if ($form->validate($this->params)) {

    $currentItem->isActive = ($this->params['isActive'])?1:0;
    
    $currentItem->title = ($this->params['title']);
    $currentItem->cnt = intval($this->params['cnt']);
    $currentItem->skidka = intval($this->params['skidka']);
    

    $currentItem->order = intval($this->params['order']);

    $currentItem->save();

    $this->_redirect(MODULE_URL.'/monitoring/tarifsp/');
}

$this->view->form = $form;
$this->view->currentItem = $currentItem;
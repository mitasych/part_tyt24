<?php

$this->params  = $this->getRequest()->getParams();

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;  
$currentItem = new AK_Order_Monitoring_TarifType($this->params['id']);

$form = new AK_Form('editTpe', 'post', MODULE_URL.'/monitoring/kategoredit/');

if ($form->isPostback()) {
    $form->setDefaults($this->params);
}


if ($form->validate($this->params)) {

    $currentItem->name = ($this->params['name']);
    $currentItem->simbol = ($this->params['simbol']);
    $currentItem->about = ($this->params['about']);
    $currentItem->active = empty($this->params['active'])?0:1;
    $currentItem->order = intval($this->params['order']);

    $currentItem->save();

    $this->_redirect(MODULE_URL.'/monitoring/kategortypes/');
}

$this->view->form = $form;
$this->view->currentItem = $currentItem;
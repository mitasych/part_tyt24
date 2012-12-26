<?php

$this->params  = $this->getRequest()->getParams();

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;  
$currentItem = new AK_Order_Monitoring_Tarif($this->params['id']);

$form = new AK_Form('editItem', 'post', MODULE_URL.'/monitoring/tarifedit/');

if ($form->isPostback()) {
    $this->params['isActive'] = empty($this->params['isActive'])?0:1;
    $form->setDefaults($this->params);
}


if ($form->validate($this->params)) {

    $currentItem->isActive = ($this->params['isActive'])?1:0;
    
    $currentItem->num = intval($this->params['num']);
    $currentItem->pM = intval($this->params['pM']);
    $currentItem->pK = intval($this->params['pK']);
    $currentItem->pH = intval($this->params['pH']);
    $currentItem->pY = intval($this->params['pY']);

    $currentItem->order = intval($this->params['order']);

    $currentItem->save();

    $this->_redirect(MODULE_URL.'/monitoring/tarifs/');
}

$this->view->form = $form;
$this->view->currentItem = $currentItem;
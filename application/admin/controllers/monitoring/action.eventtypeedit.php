<?php

$this->params  = $this->getRequest()->getParams();

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;  
$currentItem = new AK_Order_Monitoring_Event_Type($this->params['id']);

$form = new AK_Form('editItem', 'post', MODULE_URL.'/monitoring/eventtypeedit/');

if ($form->isPostback()) {
    $form->setDefaults($this->params);
}


if ($form->validate($this->params)) {

    $currentItem->title = ($this->params['title']);
    $currentItem->description = ($this->params['description']);
    $currentItem->order = intval($this->params['order']);

    $currentItem->save();

    $this->_redirect(MODULE_URL.'/monitoring/eventtypes/');
}

$this->view->form = $form;
$this->view->currentItem = $currentItem;
<?php

$this->params  = $this->getRequest()->getParams();

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
$this->params['a'] = isset($this->params['a'])?($this->params['a']):null;
$this->view->a=$this->params['a'];

$currentItem = new AK_Order_Kontragent('id', $this->params['id']);

$form = new AK_Form('editItem', 'post', MODULE_URL.'/monitoring/kontragentedit/');

$form->addRule('inn', 'required', 'Введите ИНН');

if (!empty($this->params['inn'])) {
    $form->addRule('inn2',  'callback',  'Введите правильный ИНН', array('func' => 'isINNNotValid','params' =>$this->params['inn']));

    if (!($currentItem->id && $currentItem->inn == $this->params['inn'])) {
        $form->addRule('inn3',  'callback',  'Контрагент с таким ИНН уже есть в списке мониторинга', array('func' => 'isINNExists','params' =>$this->params['inn']));
    }
}

if ($form->isPostback()) {
    $form->setDefaults($this->params);
}


if ($form->validate($this->params)) {

    $currentItem->inn = ($this->params['inn']);
    $currentItem->title = ($this->params['title']);
    $currentItem->region = ($this->params['region']);
    $currentItem->country = ($this->params['country']);
    $currentItem->save();

    $this->_redirect(MODULE_URL.'/monitoring/'.(empty($this->params['a'])?'kontragents':$this->params['a']).'/');
}

$this->view->form = $form;
$this->view->currentItem = $currentItem;

function isINNExists($Values) {

    $db = Zend_Registry::get('DBORDER');
    $select = $db->select();
    $select->from('orders_kontragents AS A', 'A.id')
        ->where('A.inn = ?', $Values);
    $res = $db->fetchOne($select);

    if (!(boolean) $res) {
        return false;
    }
    return true;
}


function isINNNotValid($Values) {
    if (AK_Order_Validate::CheckINN($Values)) {
        return false;
    }
    return true;
}
<?php

$eventTypes = new AK_Order_Monitoring_Event_Type_List();
$this->view->eventTypes = $eventTypes->returnAsAssoc()->getList();

$this->params  = $this->getRequest()->getParams();

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
$this->params['kontragent_id'] = isset($this->params['kontragent_id'])?intval($this->params['kontragent_id']):null;

$this->params['a'] = isset($this->params['a'])?($this->params['a']):null;
$this->view->a=$this->params['a'];

if (isset($this->params['idaskid'])) {
    $this->params['kontragent_id'] = $this->params['id'];
    $kontragent = new AK_Order_Kontragent('id', $this->params['kontragent_id']);
    $currentItem = new AK_Order_Monitoring_Event();
    $currentItem->kontragentId = $kontragent->id;
} else {
    $currentItem = new AK_Order_Monitoring_Event($this->params['id']);
    if (empty($currentItem->kontragentId)) {
        $kontragent = new AK_Order_Kontragent('id', $this->params['kontragent_id']);
        $currentItem->kontragentId = $kontragent->id;
    } else {
        $kontragent = new AK_Order_Kontragent('id', $currentItem->kontragentId);
    }
    
}

$this->view->kontragent = $kontragent;

$form = new AK_Form('editItem', 'post', MODULE_URL.'/monitoring/eventedit/');

$form->addRule('type_id', 'required', 'Введите Тип');
$form->addRule('event_date', 'required', 'Введите дату события');
$form->addRule('content', 'required', 'Введите Текст');

if ($form->isPostback()) {
    $form->setDefaults($this->params);
} else {
    $currentItem->eventDate = time();
}


if ($form->validate($this->params)) {
    if (isset($this->params['event_date']))
    {
       //"%d-%m-%Y %H:%M:%S"
       if (! $this->params['event_date'] = mktime(substr($this->params['event_date'],11,2), substr($this->params['event_date'],14,2), substr($this->params['event_date'],17,2), substr($this->params['event_date'],3,2), substr($this->params['event_date'],0,2), substr($this->params['event_date'],6,4) )) $this->params['event_date'] = time();
       //print $this->params['createDate'].' '.date('d-m-Y H:i:s', $this->params['createDate']);
    }else {
        $this->params['event_date'] = time();
    }
    $currentItem->dateCreated = time();
    $currentItem->typeId = ($this->params['type_id']);
    $currentItem->eventDate = $this->params['event_date'];
    $currentItem->content = ($this->params['content']);

    $sendEmail = false;
    if (!$currentItem->id) {
        $sendEmail = true;
    }

    $currentItem->save();

    if ($sendEmail) {
        AK_Order_Collection::sendEventCreatedClient($currentItem);
    }

    $this->_redirect(MODULE_URL.'/monitoring/'.(empty($this->params['a'])?'events':$this->params['a']).'/');
}

$this->view->form = $form;
$this->view->currentItem = $currentItem;
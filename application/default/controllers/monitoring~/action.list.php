<?php

$periodList = AK_Order_Enum::getPeriodList();
$this->view->periodList = $periodList;

$kontragentsList = new AK_Order_User_Kontragent_List();
$kontragentsList->addWhere('A.user_id = ?', $this->_user->id);
$this->view->kontragentsList = $kontragentsList->getList();


$form = new AK_Form('innForm', 'post', SITE_URL.'/monitoring/list/');

$form->addRule('inn', 'required', 'Введите ИНН');

if (!empty($this->params['inn'])) {
    $form->addRule('inn2',  'callback',  'Введите правильный ИНН', array('func' => 'isINNNotValid','params' =>$this->params['inn']));
    $form->addRule('inn3',  'callback',  'Контрагент с таким ИНН уже есть в списке мониторинга', array('func' => 'isINNExists','params' =>$this->params['inn']));

    if ($kontragentsList->getCount()>=$this->_user->getTarifInfo()->getTarif()->num) {
        $form->addRule('inn4',  'required',  'Вы не можете добавить еще одного контрагента');
    }
}


if ($form->validate($this->params)) {

    $kontragent = new AK_Order_Kontragent('inn', $this->params['inn']);
    if (empty($kontragent->id)) {
        $kontragent->inn = $this->params['inn'];
        $kontragent->title = '';
        $kontragent->region = '';
        $kontragent->country = '';
        $kontragent->save();
    }

    $kRelation = new AK_Order_User_Kontragent();
    $kRelation->userId = $this->_user->id;
    $kRelation->kontragentId = $kontragent->id;
    $kRelation->save();
    
    $this->_redirect('/monitoring/list/');
}
else {
    $form->setDefaults($this->params);
    $this->view->form = $form;
}
$this->view->fparams = $this->params;



//==============================================================================
$form2 = new AK_Form('settForm', 'post', SITE_URL.'/monitoring/list/');

$form2->addRule('period', 'required', 'Выберите периодичность рассылки');
if ($form2->isPostBack()) {
    if (empty($this->params['period']) || !AK_Order_Enum::isInPeriod($this->params['period'])) {
        $form2->addRule('period1', 'required',  'Выберите периодичность рассылки');
    }
}

if ($form2->validate($this->params)) {

    $this->_user->getTarifInfo()->period = $this->params['period'];
    $this->_user->getTarifInfo()->save();

    $this->_redirect('/monitoring/list/');
}
else {
    $form2->setDefaults($this->params);
    $this->view->form2 = $form2;
}
//==============================================================================





$currentInfo = new AK_Article_Item();
$currentInfo->loadByRewriteName('monitoringlist');
$this->view->currentInfo = $currentInfo;

$this->view->TITLE = 'Список мониторинга';

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



function isINNNotValid($Values) {
    if (AK_Order_Validate::CheckINN($Values)) {
        return false;
    }
    return true;
}


function isINNExists($Values) {

    $db = Zend_Registry::get('DBORDER');
    $select = $db->select();
    $select->from('orders_users__kontragents AS A', 'A.kontragent_id')
        ->joinLeft('orders_kontragents AS B', 'B.id = A.kontragent_id', null)
        ->where('B.inn = ?', $Values);
    $res = $db->fetchOne($select);
    
    if (!(boolean) $res) {
        return false;
    }
    return true;
}


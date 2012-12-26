<?php

$form = new AK_Form('send-form', 'post', SITE_URL.'/sms/index/');
$this->view->form = $form;

// $db = Zend_Registry::get('DBORDER');
// $query = $db->select();
// $query->from('address_book AS A', 'A.*');
// $addr = $db->fetchAll($query);

$obj = new AK_Order_Sms_DbTable_AddressBook($this->_user->id);
$addr = $obj->getAll();
//Zend_Debug::dump($addr);
$this->view->addr = $addr;

$tpl = $obj->getTpl();
$tpl_arr = array();
foreach ($tpl as $t) {
    $tpl_arr[0] = 'Выберите';
	$tpl_arr[$t['id']] = $t['name_tpl'];
}

$this->view->name_tpl = $tpl_arr;

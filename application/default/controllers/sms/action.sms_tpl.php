<?php

$obj = new AK_Order_Sms_DbTable_AddressBook($this->_user->id);
$tpl = $obj->getTpl();
//Zend_Debug::dump($addr);
$this->view->sms_tpl = $tpl;

$addr = $obj->getAll();
//Zend_Debug::dump($addr);
$this->view->addr = $addr;

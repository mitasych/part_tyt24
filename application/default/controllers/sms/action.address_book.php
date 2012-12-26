<?php

$obj = new AK_Order_Sms_DbTable_AddressBook($this->_user->id);
$addr = $obj->getAll();
//Zend_Debug::dump($addr);
$this->view->address_book = $addr;


$arr_sex = $obj->getSex();
$sex_arr = array();
foreach ($arr_sex as $sex) {
	$sex_arr[$sex['code']] = $sex['title'];
}

$arr_status = $obj->getStatus();
$status_arr = array();
foreach ($arr_status as $st) {
	$status_arr[$st['code']] = $st['title'];
}
$this->view->arr_status = $status_arr; //Zend_Debug::dump($status_arr);
$this->view->arr_sex = $sex_arr;

// $curPage = empty($_POST['page'])?'':$_POST['page'];print_r($curPage);echo "<br>";
// $rowsPerPage = empty($_POST['rows'])?'':$_POST['rows'];print_r($rowsPerPage);echo "<br>";
// $sortingField = empty($_POST['sidx'])?'':$_POST['sidx'];print_r($sortingField);echo "<br>";
// $sortingOrder = empty($_POST['sord'])?'':$_POST['sord'];print_r($sortingOrder);echo "<br>";


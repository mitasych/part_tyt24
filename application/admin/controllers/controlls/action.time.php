<?php
$time = new AK_Timer_List();
$time = $time->setOrder('A.time DESC')->setOrder('A.id DESC')->setListSize(50)->setCurrentPage(1)->getList();
$this->view->time = $time;

?>

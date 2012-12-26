<?php

$newsList = new AK_News_List();
$newsList = $newsList->setOrder('create_date DESC')->setCurrentPage(1)->setListSize(10)->getList();


$this->view->RequestUrl = $this->_request->getRequestUri();
$this->view->newsList = $newsList;

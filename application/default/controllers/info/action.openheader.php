<?php

$burl = (!empty($_GET['burl']))?$_GET['burl']:'http://b2b-help.ru/';
$this->view->burl = $burl;
$this->view->setLayout('openheader.tpl');
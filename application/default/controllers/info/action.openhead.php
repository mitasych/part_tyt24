<?php

$oarray = array ();
$barray = array ();//'http://www.beltransavto.ru', 'http://tut.by');
$ourl = (!empty($_GET['ourl']))?$_GET['ourl']:'';
$burl = (!empty($_GET['burl']))?$_GET['burl']:'http://b2b-help.ru/';
//if (!in_array($ourl,$oarray)) $ourl = '';
//if (!in_array($burl,$barray)) $burl = '';

$this->view->ourl = $ourl;
$this->view->burl = $burl;
$this->view->setLayout('openhead.tpl');
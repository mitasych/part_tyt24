<?php

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
$currentItem = new AK_Order_Monitoring_TarifAll($this->params['id']);
$currentItem->delete();
$this->_redirect(MODULE_URL.'/monitoring/tarifsall/');

<?php

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
$currentItem = new AK_Article_Item($this->params['id']);
$currentItem->delete();
$this->_redirect(MODULE_URL.'/articles/list/');

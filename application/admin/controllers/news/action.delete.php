<?php

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
$currentItem = new AK_News_Item($this->params['id']);
$currentItem->delete();
$this->_redirect(MODULE_URL.'/news/list/');

<?php

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
$currentCategory = new AK_Article_Category_Item($this->params['id']);
$currentCategory->delete();
$this->_redirect(MODULE_URL.'/articles/categories.list/');

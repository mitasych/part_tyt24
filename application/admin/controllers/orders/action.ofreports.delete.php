<?php
$this->params = $this->getRequest()->getParams();
$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
$currentItem = new AK_Order_Ofreport($this->params['id']);
$currentItem->delete();
$this->_redirect(MODULE_URL.'/orders/ofreports/');

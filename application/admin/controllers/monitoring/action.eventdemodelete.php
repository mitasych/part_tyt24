<?php
$this->params = $this->getRequest()->getParams();
$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
$currentItem = new AK_Order_Monitoring_Event($this->params['id']);
$currentItem->delete();
$this->_redirect(MODULE_URL.'/monitoring/'.(empty($this->params['a'])?'events':$this->params['a']).'/');

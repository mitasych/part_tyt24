<?php

$user = Zend_Registry :: get("User");
$user = new AK_Order_User();
$user->logout();

$this->_redirect(SITE_URL);

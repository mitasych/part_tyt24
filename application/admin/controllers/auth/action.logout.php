<?php

$administrator = Zend_Registry :: get("Administrator");
$administrator = new AK_Administrator();
if ($administrator->isAuthenticated()){
  $administrator->logout();
}

$this->_redirect('/'.MODULE_NAME.'/auth/login/');

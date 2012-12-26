<?php

$_SESSION['admin_id'] = ( !isset($_SESSION['admin_id']) ) ? null : $_SESSION['admin_id'];
$administrator = new AK_Administrator('id', $_SESSION['admin_id']);

if ( !(AK_Administrator :: isAdministratorExists('id', $_SESSION['admin_id']) && $administrator->isAuthenticated()) && CONTROLLER_NAME !== 'auth' && ACTION_NAME !== 'login'){
    header('location: /'.MODULE_NAME.'/auth/login/');
    exit;
} 

Zend_Registry :: set('Administrator', $administrator);
$this->view->administrator = $administrator;

require_once (CONFIG_DIR . '/' . MODULE_NAME . '/topmenu.config.php');
$this->view->top_menu_hash = $aTopMenu;

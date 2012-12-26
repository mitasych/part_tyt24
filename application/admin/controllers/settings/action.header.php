<?php

$_variables = new AK_System_Variables();

$form = new AK_Form('editItem', 'post', MODULE_URL.'/settings/header/');

if ($form->isPostback()){
    $form->setDefaults($this->params);  
} else {
    $this->view->header = $_variables->get('header');
}

if ($form->validate($this->params)){
    
    $_variables->set('header', $this->params['header'], 'str');
    $this->_redirect(MODULE_URL.'/settings/');
}

$this->view->form = $form;

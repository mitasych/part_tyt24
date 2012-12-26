<?php

$_variables = new AK_System_Variables();

$form = new AK_Form('editItem', 'post', MODULE_URL.'/settings/phone2/');
//$form->addRule('phone2', 'required', 'Телефон');


if ($form->isPostback()){
    $form->setDefaults($this->params);  
} else {
    $this->view->phone2 = $_variables->get('phone2');
}

if ($form->validate($this->params)){
    
    $_variables->set('phone2', $this->params['phone2'], 'str');
    $this->_redirect(MODULE_URL.'/settings/');
}

$this->view->form = $form;

<?php

$_variables = new AK_System_Variables();

$form = new AK_Form('editItem', 'post', MODULE_URL.'/settings/phone/');
//$form->addRule('phone', 'required', 'Телефон');


if ($form->isPostback()){
    $form->setDefaults($this->params);  
} else {
    $this->view->phone = $_variables->get('phone');
}

if ($form->validate($this->params)){
    
    $_variables->set('phone', $this->params['phone'], 'str');
    $this->_redirect(MODULE_URL.'/settings/');
}

$this->view->form = $form;

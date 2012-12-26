<?php

$_variables = new AK_System_Variables();

$form = new AK_Form('editItem', 'post', MODULE_URL.'/settings/info/');
//$form->addRule('email_info', 'required', 'Введите e-mail');
$form->addRule('email_info', 'emptyemail', 'Введите корректный e-mail');

if ($form->isPostback()){
    $form->setDefaults($this->params);  
} else {
    $this->view->email_info = $_variables->get('email_info');
}

if ($form->validate($this->params)){
    
    $_variables->set('email_info', $this->params['email_info'], 'str');
    $this->_redirect(MODULE_URL.'/settings/');
}

$this->view->form = $form;

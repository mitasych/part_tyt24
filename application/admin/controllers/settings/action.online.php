<?php

$_variables = new AK_System_Variables();

$form = new AK_Form('editItem', 'post', MODULE_URL.'/settings/online/');
$form->addRule('email_online', 'required', 'Введите e-mail');
$form->addRule('email_online', 'email', 'Введите корректный e-mail');

if ($form->isPostback()){
    $form->setDefaults($this->params);  
} else {
    $this->view->email_online = $_variables->get('email_online');
}

if ($form->validate($this->params)){
    
    $_variables->set('email_online', $this->params['email_online'], 'str');
    $this->_redirect(MODULE_URL.'/settings/');
}

$this->view->form = $form;

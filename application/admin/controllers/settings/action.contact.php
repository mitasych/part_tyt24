<?php

$_variables = new AK_System_Variables();

$form = new AK_Form('editItem', 'post', MODULE_URL.'/settings/contact/');
$form->addRule('email_contact', 'required', 'Введите e-mail');
$form->addRule('email_contact', 'email', 'Введите корректный e-mail');

if ($form->isPostback()){
    $form->setDefaults($this->params);  
} else {
    $this->view->email_contact = $_variables->get('email_contact');
}

if ($form->validate($this->params)){
    
    $_variables->set('email_contact', $this->params['email_contact'], 'str');
    $this->_redirect(MODULE_URL.'/settings/');
}

$this->view->form = $form;

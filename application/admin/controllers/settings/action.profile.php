<?php

$_variables = new AK_System_Variables();

$form = new AK_Form('editItem', 'post', MODULE_URL.'/settings/profile/');
$form->addRule('profile', 'required', 'Введите профиль');

if ($form->isPostback()){
    $form->setDefaults($this->params);  
} else {
    $this->view->copyright = $_variables->get('profile');
}

if ($form->validate($this->params)){
    
    $_variables->set('profile', $this->params['profile'], 'str');
    $this->_redirect(MODULE_URL.'/settings/');
}

$this->view->form = $form;

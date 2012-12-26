<?php

$_variables = new AK_System_Variables();

$form = new AK_Form('editItem', 'post', MODULE_URL.'/settings/copyright/');
$form->addRule('copyright', 'required', 'Введите правовую информацию');

if ($form->isPostback()){
    $form->setDefaults($this->params);  
} else {
    $this->view->copyright = $_variables->get('site_copyright_information');
}

if ($form->validate($this->params)){
    
    $_variables->set('site_copyright_information', $this->params['copyright'], 'str');
    $this->_redirect(MODULE_URL.'/settings/');
}

$this->view->form = $form;

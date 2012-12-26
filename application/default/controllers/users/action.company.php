<?php

$form = new AK_Form('NewCompanyForm', 'post', SITE_URL.'/users/company/');
$form->addRule('Adress',        'required',  'Ведите адресс');
$form->addRule('organization', 'required',  'Введите Наименование организации');
$form->addRule('innogrn', 'required',  'Введите ИНН/ОГРН');
$form->addRule('RDoljnost', 'required',  'Введите Должность руководителя');
$form->addRule('Rukovoditel', 'required',  'Введите ФИО руководителя');
$form->addRule('email',        'required',  'Введите Email');
$form->addRule('email',        'email',     'Введите правильный Email');

$form->addRule('verify_code',  'required',  'Введите код подтверждения');

$form->addRule('inn', 'required', 'Введите ИНН');

if (!empty($this->params['inn'])) {
    $form->addRule('inn',  'callback',  'Введите правильный ИНН', array('func' => 'isINNNotValid','params' =>$this->params['inn']));
    $form->addRule('inn',  'callback',  'Контрагент с таким ИНН уже есть в списке мониторинга', array('func' => 'isINNExists','params' =>$this->params['inn']));
}

if ($form->validate($this->params)) {
    $this->_redirect(SITE_URL.'/users/company/');
}
else {

    $this->params['verify_code'] = '';
    $form->setDefaults($this->params);
    $this->view->form = $form;
}

$this->view->fparams = $this->params;
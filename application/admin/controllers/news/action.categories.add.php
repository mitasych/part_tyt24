<?php

$form = new AK_Form('edit', 'post', MODULE_URL.'/news/categories.add/');
$form->addRule('title', 'required', 'Введите заголовок');

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;

$currentCategory = new AK_News_Category_Item($this->params['id']);

$form->setDefaults($this->params);

if ($form->validate($this->params)){

    $currentCategory->setTitle($this->params['title']);
    $currentCategory->save();

    $this->_redirect(MODULE_URL.'/news/categories.list/');
}

$this->view->form = $form;
$this->view->currentCategory = $currentCategory;

$this->view->BODY_CONTENT_FILE = "news/categories-add.tpl";

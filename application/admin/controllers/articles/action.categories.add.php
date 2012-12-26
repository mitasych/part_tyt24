<?php

$form = new AK_Form('edit', 'post', MODULE_URL.'/articles/categories.add/');
$form->addRule('title', 'required', 'Введите заголовок');

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;

$currentCategory = new AK_Article_Category_Item($this->params['id']);

if ($form->isPostback()){
  $this->params['isFree'] = empty($this->params['isFree'])?0:1;
  $form->setDefaults($this->params);  
}



if ($form->validate($this->params)){

    $currentCategory->setTitle($this->params['title']);
    $currentCategory->setIsFree($this->params['isFree']);
    $currentCategory->save();

    $this->_redirect(MODULE_URL.'/articles/categories.list/');
}

$this->view->form = $form;
$this->view->currentCategory = $currentCategory;

$this->view->BODY_CONTENT_FILE = "articles/categories-add.tpl";

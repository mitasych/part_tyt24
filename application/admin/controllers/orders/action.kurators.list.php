<?php

$lister = new AK_Data_Lister(new AK_Order_Kurator_List(), $this->getRequest(), 'kurators');

$lister->addLoopVar('id');

$lister->setDefaultSortOrder('id');
$lister->setDefaultSortDirection('DESC');

$lister->PARAM_SCRIPT = MODULE_URL.'/orders/kurators.list/';
$lister->PARAM_OPTION_DELIM = '<span style="font-size:20px; color:#CCCCCC;">&nbsp;|&nbsp;</span>';
$_button = new AK_Data_Lister_Button();
//$_button->setNAME('DELETE')
//        ->setAction(MODULE_URL.'/articles/mass.delete/')
//        ->setConfirm('Вы действительно хотите удалить выбранные статьи?')
//        ->setTYPE('submit')
//        ->setVALUE('удалить')
//        ->setCLASS('submit')
//        ->setWIDTH('');
$lister->addButton($_button);
//------------------------------------------------------------------------------------------------------------------
$_field = new AK_Data_Lister_Field();
$_field->setIsPrimary(true);
$_field->setSQL_FIELD('id')->setTEXT_LABEL('№')->setSORTING(true)->setSORT_FIELD('A.id');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('login')->setTEXT_HTML(true)->setTEXT_LABEL('Логин')->setSORTING(true)->setSORT_FIELD('A.login');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('email')->setTEXT_LABEL('E-mail')->setSORTING(true)->setSORT_FIELD('A.email');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('description')->setTEXT_LABEL('Описание')->setSORTING(true)->setSORT_FIELD('A.description');
$lister->addField($_field);

//------------------------------------------------------------------------------------------------------------------
//$_option = new AK_Data_Lister_Option();
//$_option->setTEXT_LABEL('<font color=blue>Войти как пользователь</font>')->setLINK_HREF(MODULE_URL.'/users/loginas/')->setLINK_TARGET('_blank');
//$lister->addOption($_option);
//------------------------------------------------------------------------------------------------------------------
$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/edit.png" />')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/orders/kuratoredit/');
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/bascket.png" />')->setLINK_CLASS('tableBottomRight')->setLINK_HREF(MODULE_URL.'/orders/kuratordelete/')->setLINK_EVENT('onclick = "return confirm(\'Удалить данного куратора?\');"');
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<font color=black>права</font>')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/orders/kuratorrightedit/');
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<font color=black>войти</font>')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/orders/kuratorlogin/');
$lister->addOption($_option);

$_toplink = new AK_Data_Lister_TopLink();
$_toplink->setTEXT_LABEL('Добавить')->setTEXT_STRONG(false)->setLINK_HREF(MODULE_URL.'/orders/kuratoredit/');
$lister->addTopLink($_toplink);

$this->view->LISTER_OUTPUT = $lister->getOutput();

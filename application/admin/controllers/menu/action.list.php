<?php

$lister = new AK_Data_Lister(new AK_Menu_List(), $this->getRequest());
$lister->setNamespace('menu');
$lister->PARAM_PAG_PANEL = false;
$lister->addLoopVar('id');
$lister->addLoopVar('filtervalue');
//------------------------------------------------------------------------------------------------------------------
$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('id')->setTEXT_LABEL('№')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('description')->setTEXT_LABEL('Заголовок')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('alias')->setTEXT_LABEL('Псевдоним')->setTEXT_STRONG(true)->setSORTING(false);
$lister->addField($_field);
//------------------------------------------------------------------------------------------------------------------
$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<font color=green>Элементы</font>')->setLINK_HREF(MODULE_URL.'/menu/links.list/filterfield/menu_id/');
$lister->addOption($_option);
//------------------------------------------------------------------------------------------------------------------
$_toplink = new AK_Data_Lister_TopLink();
$_toplink->setTEXT_LABEL('Элементы меню')->setLINK_HREF(MODULE_URL.'/menu/links.list/');
$lister->addTopLink($_toplink);
//------------------------------------------------------------------------------------------------------------------


$this->view->LISTER_OUTPUT = $lister->getOutput();
$this->view->BODY_CONTENT_FILE = "menu/list.tpl"; 

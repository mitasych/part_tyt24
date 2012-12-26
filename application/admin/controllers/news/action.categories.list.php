<?php

$lister = new AK_Data_Lister(new AK_News_Category_List(), $this->getRequest(), 'newscategories');
$lister->PARAM_PAG_PANEL = false;
$lister->addLoopVar('id');
//------------------------------------------------------------------------------------------------------------------
$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('id')->setTEXT_LABEL('№')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('title')->setTEXT_LABEL('Заголовок')->setSORTING(false);
$lister->addField($_field);
//------------------------------------------------------------------------------------------------------------------
$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<font color=green>Изменить</font>')->setLINK_HREF(MODULE_URL.'/news/categories.edit/');
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<font color=red>Удалить</font>')->setLINK_HREF(MODULE_URL.'/news/categories.delete/')->setLINK_EVENT('onclick = "return confirm(\'Удалить данную категорию?\');"');
$lister->addOption($_option);
//------------------------------------------------------------------------------------------------------------------
$_toplink = new AK_Data_Lister_TopLink();
$_toplink->setTEXT_LABEL('Добавить категорию')->setLINK_HREF(MODULE_URL.'/news/categories.add/');
$lister->addTopLink($_toplink);
//------------------------------------------------------------------------------------------------------------------


$this->view->LISTER_OUTPUT = $lister->getOutput();

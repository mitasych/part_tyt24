<?php

$lister = new AK_Data_Lister(new AK_Article_Category_List(), $this->getRequest(), 'articlecategories');

$lister->PARAM_PAG_PANEL = false;
$lister->addLoopVar('id');
$lister->PARAM_OPTION_DELIM = '<span style="font-size:20px; color:#CCCCCC;">&nbsp;|&nbsp;</span>';
//------------------------------------------------------------------------------------------------------------------
$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('id')->setTEXT_LABEL('№')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('title')->setTEXT_LABEL('Заголовок')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('isFreeColored')->setTEXT_LABEL('Тип статей')->setSORTING(false)->setTEXT_HTML(true);
$lister->addField($_field);
//------------------------------------------------------------------------------------------------------------------
$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/edit.png" />')->setLINK_CLASS('tableBottomsNext')->setLINK_HREF(MODULE_URL.'/articles/categories.edit/');
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/bascket.png" />')->setLINK_CLASS('tableBottomRight')->setLINK_HREF(MODULE_URL.'/articles/categories.delete/')->setLINK_EVENT('onclick = "return confirm(\'Удалить данную категорию?\');"');
$lister->addOption($_option);
//------------------------------------------------------------------------------------------------------------------
$_toplink = new AK_Data_Lister_TopLink();
$_toplink->setTEXT_LABEL('Добавить категорию')->setLINK_HREF(MODULE_URL.'/articles/categories.add/');
$lister->addTopLink($_toplink);
//------------------------------------------------------------------------------------------------------------------


$this->view->LISTER_OUTPUT = $lister->getOutput();

<?php

$lister = new AK_Data_Lister(new AK_News_List(), $this->getRequest(), 'news');

$lister->addLoopVar('id');

$lister->setDefaultSortOrder('id');
$lister->setDefaultSortDirection('DESC');

$lister->PARAM_SCRIPT = MODULE_URL.'/news/list/';
$lister->PARAM_OPTION_DELIM = '<span style="font-size:20px; color:#CCCCCC;">&nbsp;|&nbsp;</span>';
//------------------------------------------------------------------------------------------------------------------
$_button = new AK_Data_Lister_Button();
$_button->setNAME('DELETE')
        ->setAction(MODULE_URL.'/news/mass.delete/')
        ->setConfirm('Вы действительно хотите удалить выбранные новости?')
        ->setTYPE('submit')
        ->setVALUE('Удалить выбранные')
        ->setCLASS('submit')
        ->setWIDTH('');
$lister->addButton($_button);
//------------------------------------------------------------------------------------------------------------------
$_field = new AK_Data_Lister_Field();
$_field->setIsPrimary(true);
$_field->setSQL_FIELD('id')->setTEXT_LABEL('№')->setSORTING(true)->setSORT_FIELD('A.id');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('title')->setTEXT_LABEL('Заголовок')->setSORTING(true)->setSORT_FIELD('A.title');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('contentTruncated')->setTEXT_LABEL('Содержимое')->setSORTING(true)->setSORT_FIELD('A.content');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('rewriteName')->setTEXT_LABEL('Псевдоним')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('categoryTitle')->setTEXT_LABEL('Категория')->setSORTING(true)->setSORT_FIELD('A.category_id'); 
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('isActiveColored')->setTEXT_LABEL('Активность')->setTEXT_HTML(true)->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('hideDateColored')->setTEXT_LABEL('Скрыть дату')->setTEXT_HTML(true)->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('creatorLogin')->setTEXT_LABEL('Создатель')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('createDateFormatted')->setTEXT_LABEL('Создана')->setSORTING(true)->setSORT_FIELD('A.create_date');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('SEO')->setTEXT_LABEL('SEO (T/K/D)')->setTEXT_HTML(true)->setSORTING(false)->setTEXT_STRONG(true);
$lister->addField($_field);
//------------------------------------------------------------------------------------------------------------------
$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/edit.png" />')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/news/edit/');
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/bascket.png" />')->setLINK_CLASS('tableBottomRight')->setLINK_HREF(MODULE_URL.'/news/delete/')->setLINK_EVENT('onclick = "return confirm(\'Удалить данную новость?\');"');
$lister->addOption($_option);
//------------------------------------------------------------------------------------------------------------------
$_toplink = new AK_Data_Lister_TopLink();
$_toplink->setTEXT_LABEL('Добавить новость')->setLINK_HREF(MODULE_URL.'/news/add/');
$lister->addTopLink($_toplink);
//------------------------------------------------------------------------------------------------------------------

$this->view->LISTER_OUTPUT = $lister->getOutput();

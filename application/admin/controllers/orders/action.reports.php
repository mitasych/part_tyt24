<?php

$lister = new AK_Data_Lister(new AK_Order_Report_List(), $this->getRequest(), 'order_reports');

$lister->addLoopVar('id');

$lister->setDefaultSortOrder('id');
$lister->setDefaultSortDirection('ASC');

$lister->PARAM_SCRIPT = MODULE_URL.'/orders/reports/'; 

$_button = new AK_Data_Lister_Button();
$lister->addButton($_button);
//------------------------------------------------------------------------------------------------------------------
$_field = new AK_Data_Lister_Field();
$_field->setIsPrimary(true);
$_field->setSQL_FIELD('id')->setTEXT_LABEL('№')->setSORTING(true)->setSORT_FIELD('A.id');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('order')->setTEXT_LABEL('Сорт.')->setSORTING(true)->setSORT_FIELD('A.order');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('report_menu')->setTEXT_LABEL('Меню отчётов')->setSORTING(true)->setSORT_FIELD('A.report_menu');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('title')->setTEXT_LABEL('Название')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('url')->setTEXT_LABEL('Адрес')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('price')->setTEXT_HTML(true)->setTEXT_LABEL('Цена')->setSORTING(false);
$lister->addField($_field);
$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('price2')->setTEXT_HTML(true)->setTEXT_LABEL('Цена 2')->setSORTING(false);
$lister->addField($_field);
$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('price3')->setTEXT_HTML(true)->setTEXT_LABEL('Цена 3')->setSORTING(false);
$lister->addField($_field);



//------------------------------------------------------------------------------------------------------------------
$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/edit.png" />')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/orders/reports.edit/');
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/bascket.png" />')->setLINK_CLASS('tableBottomRight')->setLINK_HREF(MODULE_URL.'/orders/reports.delete/')->setLINK_EVENT('onclick = "return confirm(\'Удалить данный элемент?\');"');
$lister->addOption($_option);


//------------------------------------------------------------------------------------------------------------------
$_toplink = new AK_Data_Lister_TopLink();
$_toplink->setTEXT_LABEL('Добавить элемент')->setLINK_HREF(MODULE_URL.'/orders/reports.add/');
$lister->addTopLink($_toplink);
//------------------------------------------------------------------------------------------------------------------


$this->view->LISTER_OUTPUT = $lister->getOutput();

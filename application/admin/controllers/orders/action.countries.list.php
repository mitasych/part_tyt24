<?php

$lister = new AK_Data_Lister(new AK_Location_Country_List(), $this->getRequest(), 'location_countries');

$lister->addLoopVar('id');

$lister->setDefaultSortOrder('id');
$lister->setDefaultSortDirection('ASC');

$lister->PARAM_SCRIPT = MODULE_URL.'/orders/countries.list/'; 

$_button = new AK_Data_Lister_Button();
$lister->addButton($_button);
//------------------------------------------------------------------------------------------------------------------
$_field = new AK_Data_Lister_Field();
$_field->setIsPrimary(true);
$_field->setSQL_FIELD('id')->setTEXT_LABEL('№')->setSORTING(true)->setSORT_FIELD('A.id');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('name')->setTEXT_LABEL('Название')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('code')->setTEXT_LABEL('Код')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('monitoringListFormatted')->setTEXT_HTML(true)->setTEXT_LABEL('Использовать в<br>списке мониторинга')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('registerListFormatted')->setTEXT_HTML(true)->setTEXT_LABEL('Использовать в<br>списке личного кабинета')->setSORTING(false);
$lister->addField($_field);


//------------------------------------------------------------------------------------------------------------------
$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/edit.png" />')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/orders/country.edit/');
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/bascket.png" />')->setLINK_CLASS('tableBottomRight')->setLINK_HREF(MODULE_URL.'/orders/country.delete/')->setLINK_EVENT('onclick = "return confirm(\'Удалить данный элемент?\');"');
$lister->addOption($_option);


//------------------------------------------------------------------------------------------------------------------
$_toplink = new AK_Data_Lister_TopLink();
$_toplink->setTEXT_LABEL('Добавить элемент')->setLINK_HREF(MODULE_URL.'/orders/country.add/');
$lister->addTopLink($_toplink);
//------------------------------------------------------------------------------------------------------------------


$this->view->LISTER_OUTPUT = $lister->getOutput();

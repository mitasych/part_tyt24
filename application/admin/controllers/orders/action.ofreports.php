<?php


$lister = new AK_Data_Lister(new AK_Order_Report_Oflist(), $this->getRequest(), 'order_reports');


$lister->addLoopVar('id');

$lister->setDefaultSortOrder('id');
$lister->setDefaultSortDirection('ASC');

$lister->PARAM_SCRIPT = MODULE_URL.'/orders/ofreports/'; 

$_button = new AK_Data_Lister_Button();
$lister->addButton($_button);
//------------------------------------------------------------------------------------------------------------------
$_field = new AK_Data_Lister_Field();
$_field->setIsPrimary(true);
$_field->setSQL_FIELD('id')->setTEXT_LABEL('№')->setSORTING(true)->setSORT_FIELD('A.id');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('order_report_title')->setTEXT_LABEL('Отчёт')->setSORTING(true)->setSORT_FIELD('A.order_report_id');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('region_code')->setTEXT_LABEL('Код региона')->setSORTING(true)->setSORT_FIELD('A.region_code');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('order_report_region')->setTEXT_LABEL('Регион')->setSORTING(true)->setSORT_FIELD('A.region_code');
$lister->addField($_field);


$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('price2')->setTEXT_HTML(true)->setTEXT_LABEL('Цена 2')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('price3')->setTEXT_HTML(true)->setTEXT_LABEL('Цена 3')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('price_shipping')->setTEXT_HTML(true)->setTEXT_LABEL('Цена доставки')->setSORTING(false);
$lister->addField($_field);



//------------------------------------------------------------------------------------------------------------------
$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/edit.png" />')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/orders/ofreports.edit/');
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/bascket.png" />')->setLINK_CLASS('tableBottomRight')->setLINK_HREF(MODULE_URL.'/orders/ofreports.delete/')->setLINK_EVENT('onclick = "return confirm(\'Удалить данный элемент?\');"');
$lister->addOption($_option);


//------------------------------------------------------------------------------------------------------------------
$_toplink = new AK_Data_Lister_TopLink();
$_toplink->setTEXT_LABEL('Добавить элемент')->setLINK_HREF(MODULE_URL.'/orders/ofreports.add/');
$lister->addTopLink($_toplink);
//------------------------------------------------------------------------------------------------------------------

//echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($lister->getOutput()); echo '</pre>'; die();
$this->view->LISTER_OUTPUT = $lister->getOutput();

<?php

$lister = new AK_Data_Lister(new AK_Order_Kontragent_List(), $this->getRequest(), 'kontragents');

$lister->addLoopVar('id');

$lister->setDefaultSortOrder('inn');
$lister->setDefaultSortDirection('ASC');

$lister->PARAM_SCRIPT = MODULE_URL.'/monitoring/kontragents/';
$lister->PARAM_OPTION_DELIM = '<span style="font-size:20px; color:#CCCCCC;">&nbsp;|&nbsp;</span>';
$_button = new AK_Data_Lister_Button();
//$_button->setNAME('SORT')
//        ->setAction(MODULE_URL.'/monitoring/mass.tarif.sort/')
//        ->setTYPE('submit')
//        ->setVALUE('сортировать')
//        ->setCLASS('submit')
//        ->setWIDTH('');
$lister->addButton($_button);
//------------------------------------------------------------------------------------------------------------------

$_field = new AK_Data_Lister_Field();
$_field->setIsPrimary(true);
$_field->setSQL_FIELD('id')->setTEXT_LABEL('№')->setSORTING(true)->setSORT_FIELD('A.id');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
//$_field->setIsSorting(true);
$_field->setSQL_FIELD('inn')->setTEXT_LABEL('ИНН')->setSORTING(true)->setSORT_FIELD('A.inn');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('title')->setTEXT_LABEL('Название')->setSORTING(true)->setSORT_FIELD('A.title');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('region')->setTEXT_LABEL('Регион')->setSORTING(true)->setSORT_FIELD('A.region');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('country')->setTEXT_LABEL('Страна')->setSORTING(true)->setSORT_FIELD('A.country');
$lister->addField($_field);



//------------------------------------------------------------------------------------------------------------------
$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/edit.png" />')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/monitoring/kontragentedit/');
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/bascket.png" />')->setLINK_CLASS('tableBottomRight')->setLINK_HREF(MODULE_URL.'/monitoring/kontragentdelete/')->setLINK_EVENT('onclick = "return confirm(\'Удалить ?\');"');
$lister->addOption($_option);

$_toplink = new AK_Data_Lister_TopLink();
$_toplink->setTEXT_LABEL('Добавить')->setTEXT_STRONG(false)->setLINK_HREF(MODULE_URL.'/monitoring/kontragentedit/');
$lister->addTopLink($_toplink);

$this->view->LISTER_OUTPUT = $lister->getOutput();

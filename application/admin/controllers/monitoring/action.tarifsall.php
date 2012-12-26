<?php

$lister = new AK_Data_Lister(new AK_Order_Monitoring_Tarif_ListAll(), $this->getRequest(), 'tarifall');
		
$lister->addLoopVar('id');

$lister->setDefaultSortOrder('id');
$lister->setDefaultSortDirection('ASC');

$lister->PARAM_SCRIPT = MODULE_URL.'/monitoring/tarifs/';
$lister->PARAM_OPTION_DELIM = '<span style="font-size:20px; color:#CCCCCC;">&nbsp;|&nbsp;</span>';
$_button = new AK_Data_Lister_Button();
// $_button->setNAME('SORT')
        // ->setAction(MODULE_URL.'/monitoring/mass.tarif.sort/')
        // ->setTYPE('submit')
        // ->setVALUE('сортировать')
        // ->setCLASS('submit')
        // ->setWIDTH('');
$lister->addButton($_button);
//------------------------------------------------------------------------------------------------------------------

$_field = new AK_Data_Lister_Field();
$_field->setIsPrimary(true);
$_field->setSQL_FIELD('id')->setTEXT_LABEL('№')->setSORTING(true)->setSORT_FIELD('A.id');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('name')->setTEXT_LABEL('Название')->setSORTING(true)->setSORT_FIELD('A.name');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('TypeName')->setTEXT_LABEL('Категория')->setSORTING(true)->setTEXT_HTML(true)->setSORT_FIELD('A.type');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('isActiveColored')->setTEXT_LABEL('Статус')->setSORTING(true)->setTEXT_HTML(true)->setSORT_FIELD('A.is_active');
$lister->addField($_field);


//------------------------------------------------------------------------------------------------------------------
$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/edit.png" />')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/monitoring/tarifalledit/');
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/bascket.png" />')->setLINK_CLASS('tableBottomRight')->setLINK_HREF(MODULE_URL.'/orders/tarifalldelete/')->setLINK_EVENT('onclick = "return confirm(\'Удалить ?\');"');
$lister->addOption($_option);

$_toplink = new AK_Data_Lister_TopLink();
$_toplink->setTEXT_LABEL('Добавить')->setTEXT_STRONG(false)->setLINK_HREF(MODULE_URL.'/monitoring/tarifalledit/');
$lister->addTopLink($_toplink);



$this->view->LISTER_OUTPUT = $lister->getOutput();

//var_dump($this->view->LISTER_OUTPUT);exit();

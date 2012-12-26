<?php

$lister = new AK_Data_Lister(new AK_Order_Monitoring_Tarif_Period_List(), $this->getRequest(), 'tarifp');

$lister->addLoopVar('id');

$lister->setDefaultSortOrder('order');
$lister->setDefaultSortDirection('ASC');

$lister->PARAM_SCRIPT = MODULE_URL.'/monitoring/tarifsp/';
$lister->PARAM_OPTION_DELIM = '<span style="font-size:20px; color:#CCCCCC;">&nbsp;|&nbsp;</span>';
$_button = new AK_Data_Lister_Button();
$_button->setNAME('SORT')
        ->setAction(MODULE_URL.'/monitoring/mass.tarifp.sort/')
        ->setTYPE('submit')
        ->setVALUE('сортировать')
        ->setCLASS('submit')
        ->setWIDTH('');
$lister->addButton($_button);
//------------------------------------------------------------------------------------------------------------------

$_field = new AK_Data_Lister_Field();
$_field->setIsPrimary(true);
$_field->setSQL_FIELD('id')->setTEXT_LABEL('№')->setSORTING(true)->setSORT_FIELD('A.id');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setIsSorting(true);
$_field->setSQL_FIELD('order')->setTEXT_LABEL('П.Н.')->setSORTING(true)->setSORT_FIELD('A.order');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('title')->setTEXT_LABEL('Заголовок')->setSORTING(true)->setSORT_FIELD('A.title');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('cnt')->setTEXT_LABEL('Кол-во дней')->setSORTING(true)->setSORT_FIELD('A.cnt');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('skidka')->setTEXT_LABEL('Скидка %')->setSORTING(true)->setSORT_FIELD('A.skidka');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('isActiveColored')->setTEXT_LABEL('Статус')->setSORTING(true)->setTEXT_HTML(true)->setSORT_FIELD('A.is_active');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('type')->setTEXT_LABEL('Тип');
$lister->addField($_field);


//------------------------------------------------------------------------------------------------------------------
$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/edit.png" />')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/monitoring/tarifpedit/');
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/bascket.png" />')->setLINK_CLASS('tableBottomRight')->setLINK_HREF(MODULE_URL.'/orders/tarifpdelete/')->setLINK_EVENT('onclick = "return confirm(\'Удалить ?\');"');
$lister->addOption($_option);

$_toplink = new AK_Data_Lister_TopLink();
$_toplink->setTEXT_LABEL('Добавить')->setTEXT_STRONG(false)->setLINK_HREF(MODULE_URL.'/monitoring/tarifpedit/');
$lister->addTopLink($_toplink);

$this->view->LISTER_OUTPUT = $lister->getOutput();

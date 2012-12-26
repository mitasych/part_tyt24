<?php
$db = Zend_Registry::get('DBORDER');
$query = $db->select();
$query->from('orders_monitoring__events_status AS A');
$this->view->do = $db->fetchAll($query);

$lister = new AK_Data_Lister(new AK_Order_Monitoring_Event_List(), $this->getRequest(), 'events');

$lister->addLoopVar('id');

$lister->setDefaultSortOrder('dateCreatedFormatted');
$lister->setDefaultSortDirection('ASC');

$lister->PARAM_SCRIPT = MODULE_URL.'/monitoring/events/';
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
$_field->setSQL_FIELD('dateCreatedFormatted')->setTEXT_LABEL('Дата создания')->setSORTING(true)->setSORT_FIELD('A.date_created');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('eventTypeTitle')->setTEXT_LABEL('Тип')->setSORTING(true)->setSORT_FIELD('A.typeId');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('eventDateFormatted')->setTEXT_LABEL('Дата события')->setSORTING(true)->setSORT_FIELD('A.event_date');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('kontragentInn')->setTEXT_LABEL('Контрагент')->setSORTING(true)->setSORT_FIELD('A.kontragent_id');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('content')->setTEXT_LABEL('Текст')->setSORTING(false);
$lister->addField($_field);


//------------------------------------------------------------------------------------------------------------------
$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/edit.png" />')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/monitoring/eventedit/');
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/bascket.png" />')->setLINK_CLASS('tableBottomRight')->setLINK_HREF(MODULE_URL.'/monitoring/eventdelete/')->setLINK_EVENT('onclick = "return confirm(\'Удалить ?\');"');
$lister->addOption($_option);

//$_toplink = new AK_Data_Lister_TopLink();
//$_toplink->setTEXT_LABEL('Добавить')->setTEXT_STRONG(false)->setLINK_HREF(MODULE_URL.'/monitoring/eventedit/');
//$lister->addTopLink($_toplink);

$this->view->LISTER_OUTPUT = $lister->getOutput();

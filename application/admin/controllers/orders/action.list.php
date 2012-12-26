<?php

$lister = new AK_Data_Lister(new AK_Order_List(), $this->getRequest(), 'orders');

$lister->addLoopVar('id');

$lister->setDefaultSortOrder('id');
$lister->setDefaultSortDirection('DESC');

$lister->PARAM_SCRIPT = MODULE_URL.'/orders/list/';
$lister->PARAM_OPTION_DELIM = '<span style="font-size:20px; color:#CCCCCC;">&nbsp;|&nbsp;</span>';
$_button = new AK_Data_Lister_Button();
//$_button->setNAME('DELETE')
//        ->setAction(MODULE_URL.'/articles/mass.delete/')
//        ->setConfirm('Вы действительно хотите удалить выбранные статьи?')
//        ->setTYPE('submit')
//        ->setVALUE('удалить')
//        ->setCLASS('submit')
//        ->setWIDTH('');
$lister->addButton($_button);
//------------------------------------------------------------------------------------------------------------------

$_field = new AK_Data_Lister_Field();
$_field->setIsPrimary(true);
$_field->setSQL_FIELD('id')->setTEXT_LABEL('№')->setSORTING(true)->setSORT_FIELD('A.id');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('company')->setTEXT_LABEL('Название компании')->setSORTING(true)->setSORT_FIELD('A.company');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('email')->setTEXT_LABEL('E-mail')->setSORTING(true)->setSORT_FIELD('A.email');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('placeCreated')->setTEXT_LABEL('Откуда')->setSORTING(true)->setSORT_FIELD('A.place_created');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('dateСreatedFormatted')->setTEXT_LABEL('Создан')->setSORTING(true)->setSORT_FIELD('A.date_created');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('dateUpdatedFormatted')->setTEXT_LABEL('Обновлен')->setSORTING(true)->setSORT_FIELD('A.date_updated');
$lister->addField($_field);



$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('secretCode')->setTEXT_LABEL('Код')->setSORTING(true)->setSORT_FIELD('A.secret_code');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('number')->setTEXT_LABEL('Номер счета')->setSORTING(true)->setSORT_FIELD('A.number');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('zaku')->setTEXT_LABEL('Заказчик')->setSORTING(true)->setSORT_FIELD('A.zaku');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('platu')->setTEXT_LABEL('Плательщик')->setSORTING(true)->setSORT_FIELD('A.platu');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('price')->setTEXT_LABEL('Цена')->setSORTING(true)->setSORT_FIELD('A.price');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('additionalInfo')->setTEXT_LABEL('Доп. инфо')->setSORTING(true)->setSORT_FIELD('A.additional_info');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('priorityLabel')->setTEXT_LABEL('Приоритет')->setSORTING(true)->setSORT_FIELD('A.priority');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('moneyLabel')->setTEXT_LABEL('Способ оплаты')->setSORTING(true)->setSORT_FIELD('A.money');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('statusLabel')->setTEXT_LABEL('Статус')->setSORTING(true)->setSORT_FIELD('A.status');
$lister->addField($_field);

//------------------------------------------------------------------------------------------------------------------
//$_option = new AK_Data_Lister_Option();
//$_option->setTEXT_LABEL('<font color=blue>Войти как пользователь</font>')->setLINK_HREF(MODULE_URL.'/users/loginas/')->setLINK_TARGET('_blank');
//$lister->addOption($_option);
//------------------------------------------------------------------------------------------------------------------
//$_option = new AK_Data_Lister_Option();
//$_option->setTEXT_LABEL('<img src="/admin/images/edit.png" />')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/orders/kuratoredit/');
//$lister->addOption($_option);
//
//$_option = new AK_Data_Lister_Option();
//$_option->setTEXT_LABEL('<img src="/admin/images/bascket.png" />')->setLINK_CLASS('tableBottomRight')->setLINK_HREF(MODULE_URL.'/orders/kuratordelete/')->setLINK_EVENT('onclick = "return confirm(\'Удалить данного куратора?\');"');
//$lister->addOption($_option);
//
//$_toplink = new AK_Data_Lister_TopLink();
//$_toplink->setTEXT_LABEL('Добавить')->setTEXT_STRONG(false)->setLINK_HREF(MODULE_URL.'/orders/kuratoredit/');
//$lister->addTopLink($_toplink);

$this->view->LISTER_OUTPUT = $lister->getOutput();

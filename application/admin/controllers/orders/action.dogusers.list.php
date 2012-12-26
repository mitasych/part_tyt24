<?php

$list = new AK_Order_User_List();

$list->addWhere('A.is_deleted = 0 AND use_monitoring = 1 AND dogovor_created = 0');

$lister = new AK_Data_Lister($list, $this->getRequest(), 'dogusers');


$lister->addLoopVar('id');

$lister->setDefaultSortOrder('id');
$lister->setDefaultSortDirection('DESC');

$lister->PARAM_SCRIPT = MODULE_URL.'/orders/dogusers.list/';
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
//------------------------------------------------------------------------------------------------------------------
$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('fio')->setTEXT_HTML(true)->setTEXT_LABEL('Ф.И.О.')->setSORTING(true)->setSORT_FIELD('A.second_name');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('login')->setTEXT_HTML(true)->setTEXT_LABEL('Логин')->setSORTING(true)->setSORT_FIELD('A.login');
$lister->addField($_field);
//------------------------------------------------------------------------------------------------------------------
$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('email')->setTEXT_LABEL('E-mail')->setSORTING(true)->setSORT_FIELD('A.email');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('phone')->setTEXT_LABEL('Телефон')->setSORTING(true)->setSORT_FIELD('A.phone');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('monitoringTarifSkidkaFormatted')->setTEXT_HTML(true)->setTEXT_LABEL('Скидка <br> мониторинг (%)')->setSORTING(true)->setSORT_FIELD('A.monitoringTarifSkidka');
$lister->addField($_field);
//$_field = new AK_Data_Lister_Field();
//$_field->setSQL_FIELD('genderName')->setTEXT_LABEL('Пол')->setSORTING(true)->setSORT_FIELD('A.gender');
//$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('fromName')->setTEXT_LABEL('Откуда узнал')->setSORTING(true)->setSORT_FIELD('A.from');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('site')->setTEXT_LABEL('Где зарегистрировался')->setSORTING(true)->setSORT_FIELD('A.site');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('servicesStringAdmin')->setTEXT_HTML(true)->setTEXT_LABEL('Сервисы');
$lister->addField($_field);
//------------------------------------------------------------------------------------------------------------------
//$_field = new AK_Data_Lister_Field();
//$_field->setSQL_FIELD('subscribeFlagAsYesno')->setTEXT_LABEL('Получать новости')->setTEXT_HTML(true)->setSORTING(false);
//$lister->addField($_field);
////------------------------------------------------------------------------------------------------------------------
//$_field = new AK_Data_Lister_Field();
//$_field->setSQL_FIELD('vipiskaNotifyFlagAsYesno')->setTEXT_LABEL('Получать копию выписки')->setTEXT_HTML(true)->setSORTING(false);
//$lister->addField($_field);
////------------------------------------------------------------------------------------------------------------------
//$_field = new AK_Data_Lister_Field();
//$_field->setSQL_FIELD('aktNotifyFlagAsYesno')->setTEXT_LABEL('Получать акты')->setTEXT_HTML(true)->setSORTING(false);
//$lister->addField($_field);
//------------------------------------------------------------------------------------------------------------------
//$_option = new AK_Data_Lister_Option();
//$_option->setTEXT_LABEL('<font color=blue>Войти как пользователь</font>')->setLINK_HREF(MODULE_URL.'/users/loginas/')->setLINK_TARGET('_blank');
//$lister->addOption($_option);
//------------------------------------------------------------------------------------------------------------------
//$_option = new AK_Data_Lister_Option();
//$_option->setTEXT_LABEL('<img src="/admin/images/edit.png" />')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/orders/useredit/');
//$lister->addOption($_option);

if ($this->view->administrator->status == AK_Enum_AdminStatus::ADMIN) {
    $_option = new AK_Data_Lister_Option();
    $_option->setTEXT_LABEL('<img src="/admin/images/bascket.png" />')->setLINK_CLASS('tableBottomRight')->setLINK_HREF(MODULE_URL.'/orders/userdelete/')->setLINK_EVENT('onclick = "return confirm(\'Удалить пользователя?\');"');
    $lister->addOption($_option);

}

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<font color=black>войти</font>')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/orders/userlogin/');
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<font color=black>подтвердить</font>')->setLINK_CLASS('tableBottomNext')->setLINK_EVENT('onclick = "return confirm(\'Подтвердить?\');"')->setLINK_HREF(MODULE_URL.'/orders/approvemon/');
$lister->addOption($_option);
$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<font color=red>Заблокировать/разблокировать</font>')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/orders/userblock/')->setLINK_EVENT('onclick = "return confirm(\'Заблокировать/разблокировать пользователя?\');"');
$lister->addOption($_option);

//
//$_toplink = new AK_Data_Lister_TopLink();
//$_toplink->setTEXT_LABEL('Добавить')->setTEXT_STRONG(false)->setLINK_HREF(MODULE_URL.'/orders/useredit/');
//$lister->addTopLink($_toplink);

$this->view->LISTER_OUTPUT = $lister->getOutput();

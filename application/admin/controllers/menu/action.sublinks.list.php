<?php

$lister = new AK_Data_Lister(new AK_Menu_Sublink_List(), $this->getRequest(), 'menusublinks');

switch ($this->getRequest()->getParam('menu_id'))
{
    case '1':

        $switchmenu = 'Левого подменю';
        break;
    case '2':
        $switchmenu = 'Нижнего подменю';
        break;
    case '3' :
        $switchmenu = 'Верхнего подменю';
        break;
}


$lister->addLoopVar('id');

$lister->setDefaultSortOrder('queue');
$lister->setDefaultSortDirection('ASC');

$lister->PARAM_SCRIPT = MODULE_URL.'/menu/sublinks.list/'; 
$lister->PARAM_OPTION_DELIM = '<span style="font-size:20px; color:#CCCCCC;">&nbsp;|&nbsp;</span>';
//------------------------------------------------------------------------------------------------------------------
$_button = new AK_Data_Lister_Button();
$_button->setNAME('DELETE')
        ->setAction(MODULE_URL.'/menu/mass.sublink.delete/')
        ->setConfirm('Вы действительно хотите удалить выбранные элементы?')
        ->setTYPE('submit')
        ->setVALUE('удалить')
        ->setCLASS('submit')
        ->setWIDTH('');
$lister->addButton($_button);
//------------------------------------------------------------------------------------------------------------------
$_button = new AK_Data_Lister_Button();
$_button->setNAME('DELETE')
        ->setAction(MODULE_URL.'/menu/mass.sublink.sort/')
        ->setConfirm('')
        ->setTYPE('submit')
        ->setVALUE('отсортировать')
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
$_field->setSQL_FIELD('queue')->setTEXT_LABEL('П.Н.')->setSORTING(true)->setSORT_FIELD('A.queue');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('imagePosition')->setTEXT_LABEL('Изображение')->setSORTING(false)->setTEXT_HTML(true);
$lister->addField($_field);

if ($this->getRequest()->getParam('menu_id')==3) {
$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('Position')->setTEXT_LABEL('Номер левого меню')->setSORTING(false)->setTEXT_HTML(true);
$lister->addField($_field);
}
$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('title')->setTEXT_LABEL('Заголовок')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('parentLinkTitle')->setTEXT_LABEL('Пункт')->setSORTING(true)->setSORT_FIELD('A.link_id');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('link')->setTEXT_LABEL('Ссылка')->setTEXT_HTML(true)->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('isNoteColored')->setTEXT_LABEL('Под скрепкой')->setTEXT_HTML(true)->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('isRedColored')->setTEXT_LABEL('Выделение')->setTEXT_HTML(true)->setSORTING(false);
$lister->addField($_field);
//------------------------------------------------------------------------------------------------------------------
$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/edit.png" />')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/menu/sublink.edit/'.'menu_id/'.$this->getRequest()->getParam('menu_id').'/');
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/bascket.png" />')->setLINK_CLASS('tableBottomRight')->setLINK_HREF(MODULE_URL.'/menu/sublink.delete/')->setLINK_EVENT('onclick = "return confirm(\'Удалить данный элемент?\');"');
$lister->addOption($_option);
//------------------------------------------------------------------------------------------------------------------
if ($this->getRequest()->getParam('filterfield') && $this->getRequest()->getParam('filterfield') == 'linkId') {
    $_add = 'link_id/'.$this->getRequest()->getParam('filtervalue').'/'.'menu_id/'.$this->getRequest()->getParam('menu_id').'/';
}elseif (!empty($_SESSION['LISTER']['menusublinks']['FILTER']['FIELD']) && $_SESSION['LISTER']['menusublinks']['FILTER']['FIELD'] == 'linkId'){
    $_add = 'link_id/'.intval($_SESSION['LISTER']['menusublinks']['FILTER']['VALUE']).'/';
} else {
  $_add = '';
}
$_toplink = new AK_Data_Lister_TopLink();
$_toplink->setTEXT_LABEL('Добавить')->setTEXT_STRONG(false)->setLINK_HREF(MODULE_URL.'/menu/sublink.add/'.$_add);
$lister->addTopLink($_toplink);
$_SESSION['link_id']=intval($_SESSION['LISTER']['menusublinks']['FILTER']['VALUE']);
//------------------------------------------------------------------------------------------------------------------
$_filter = new AK_Data_Lister_Filter();
$_filter->field = 'linkId'; 
$_filter->label = 'Пункт';  
$_filter->type = 'select';
$_filter->where = 'A.link_id = ?';

$_list = new AK_Menu_Link_List();
$_list = $_list->returnAsAssoc(true)->setAssocValue('A.title')->getList(); 
foreach ($_list as $_k => &$_v) $_filter->variants[] = array('value'=>$_k,  'label'=>$_v);
  
$lister->addFilter($_filter);
//------------------------------------------------------------------------------------------------------------------


$this->view->LISTER_OUTPUT = $lister->getOutput();
$this->view->switchmenu = $switchmenu;

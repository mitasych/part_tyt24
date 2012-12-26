 <?php

$lister = new AK_Data_Lister(new AK_Menu_Link_List(), $this->getRequest(), 'menulinks');


switch ($this->getRequest()->getParam('menu_id'))
{
    case '1':

        $switchmenu = 'Левое меню';
        break;
    case '2':
        $switchmenu = 'Нижнее меню';
        break;
    case '3' :
        $switchmenu = 'Верхнее меню';
        break;
}

switch ($this->getRequest()->getParam('id'))
{
    case '1':
        
        $switchmenu = 'Левое Меню';
        break;
    case '2':
        $switchmenu = 'Нижнее Меню';
        break;
    case '3' :
        $switchmenu = 'Верхнее Меню';
        break;
}
$lister->addLoopVar('id');

$lister->setDefaultSortOrder('queue');
$lister->setDefaultSortDirection('ASC');

$lister->PARAM_SCRIPT = MODULE_URL.'/menu/links.list/'; 
$lister->PARAM_OPTION_DELIM = '<span style="font-size:20px; color:#CCCCCC;">&nbsp;|&nbsp;</span>';
//------------------------------------------------------------------------------------------------------------------
$_button = new AK_Data_Lister_Button();
$_button->setNAME('DELETE')
        ->setAction(MODULE_URL.'/menu/mass.link.delete/')
        ->setConfirm('Вы действительно хотите удалить выбранные элементы?')
        ->setTYPE('submit')
        ->setVALUE('удалить')
        ->setCLASS('submit')
        ->setWIDTH('');
$lister->addButton($_button);
//------------------------------------------------------------------------------------------------------------------
$_button = new AK_Data_Lister_Button();
$_button->setNAME('DELETE')
        ->setAction(MODULE_URL.'/menu/mass.link.sort/')
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
$_field->setSQL_FIELD('title')->setTEXT_LABEL('Заголовок')->setSORTING(false);
$lister->addField($_field);

// $_field = new AK_Data_Lister_Field();
// $_field->setSQL_FIELD('menuDescription')->setTEXT_LABEL('Меню')->setSORTING(true)->setSORT_FIELD('A.menu_id');
// $lister->addField($_field);

if ( $this->getRequest()->getParam('menu_id')!=2)
        {
    $_field = new AK_Data_Lister_Field();
    $_field->setSQL_FIELD('submenus')->setTEXT_LABEL('Подменю')->setSORTING(false)->setTEXT_HTML(true);
    $lister->addField($_field);
}

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('imagePosition')->setTEXT_LABEL('Позиция')->setSORTING(false)->setTEXT_HTML(true);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('link')->setTEXT_LABEL('Ссылка')->setTEXT_HTML(true)->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('listStrViewPages')->setTEXT_LABEL('Показ')->setTEXT_HTML(true)->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('isActiveColored')->setTEXT_LABEL('Активность')->setTEXT_HTML(true)->setSORTING(false);
$lister->addField($_field);


//$_field = new AK_Data_Lister_Field();
//$_field->setSQL_FIELD('isRedColored')->setTEXT_LABEL('Выделение')->setTEXT_HTML(true)->setSORTING(false);
//$lister->addField($_field);
//------------------------------------------------------------------------------------------------------------------
if ($this->getRequest()->getParam('filterfield') && $this->getRequest()->getParam('filterfield') == 'menu_id') {
    $_add = 'menu_id/'.$this->getRequest()->getParam('filtervalue').'/';
}elseif (!empty($_SESSION['LISTER']['menulinks']['FILTER']['FIELD']) && $_SESSION['LISTER']['menulinks']['FILTER']['FIELD'] == 'menu_id'){
    $_add = 'menu_id/'.intval($_SESSION['LISTER']['menulinks']['FILTER']['VALUE']).'/';
} else {
  $_add = '';
}
$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/edit.png" />')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/menu/link.edit/'.$_add);
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/bascket.png" />')->setLINK_CLASS('tableBottomRight')->setLINK_HREF(MODULE_URL.'/menu/link.delete/')->setLINK_EVENT('onclick = "return confirm(\'Удалить данный элемент?\');"');
$lister->addOption($_option);
//------------------------------------------------------------------------------------------------------------------

$_toplink = new AK_Data_Lister_TopLink();
$_toplink->setTEXT_LABEL('Добавить')->setTEXT_STRONG(false)->setLINK_HREF(MODULE_URL.'/menu/link.add/'.$_add);
$lister->addTopLink($_toplink);

//------------------------------------------------------------------------------------------------------------------
$_filter = new AK_Data_Lister_Filter();
$_filter->field = 'menu_id';
$_filter->label = 'Меню';  
$_filter->type = 'select';
$_filter->where = 'A.menu_id = ?';

$_list = new AK_Menu_List();
$_list = $_list->returnAsAssoc(true)->setAssocValue('A.description')->addWhere('A.id = 1')->getList(); 
foreach ($_list as $_k => &$_v) $_filter->variants[] = array('value'=>$_k,  'label'=>$_v);
  
$lister->addFilter($_filter);
$lister->noRenderFilters(1);
//------------------------------------------------------------------------------------------------------------------


$this->view->LISTER_OUTPUT = $lister->getOutput();
$this->view->switchmenu = $switchmenu;


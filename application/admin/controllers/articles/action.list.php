<?php
$Article_List = new AK_Article_List();

isset($this->params['infoBlock'])?$Article_List = $Article_List->addWhere('ai.category_id = 6'):'';
$lister = new AK_Data_Lister($Article_List, $this->getRequest(), 'articles');

$lister->addLoopVar('id');

$lister->setDefaultSortOrder('id');
$lister->setDefaultSortDirection('DESC');

$lister->PARAM_SCRIPT = MODULE_URL.'/articles/list/';
$lister->PARAM_OPTION_DELIM = '<span style="font-size:20px; color:#CCCCCC;">&nbsp;|&nbsp;</span>';
//------------------------------------------------------------------------------------------------------------------
$_button = new AK_Data_Lister_Button();
$_button->setNAME('DELETE')
        ->setAction(MODULE_URL.'/articles/mass.delete/')
        ->setConfirm('Вы действительно хотите удалить выбранные статьи?')
        ->setTYPE('submit')
        ->setVALUE('удалить')
        ->setCLASS('submit')
        ->setWIDTH('');
$lister->addButton($_button);
//------------------------------------------------------------------------------------------------------------------
$_field = new AK_Data_Lister_Field();
$_field->setIsPrimary(true);
$_field->setSQL_FIELD('id')->setTEXT_LABEL('№')->setSORTING(true)->setSORT_FIELD('ai.id');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('title')->setTEXT_LABEL('Заголовок')->setSORTING(true)->setSORT_FIELD('ai.title');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('contentTruncated')->setTEXT_LABEL('Содержимое')->setSORTING(true)->setSORT_FIELD('ai.content');
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('rewriteName')->setTEXT_LABEL('Псевдоним')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('Shapka')->setTEXT_LABEL('Шапка')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('categoryTitle')->setTEXT_LABEL('Категория')->setSORTING(true)->setSORT_FIELD('ai.category_id'); 
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('isActiveColored')->setTEXT_LABEL('Активность')->setTEXT_HTML(true)->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('creatorLogin')->setTEXT_LABEL('Создатель')->setSORTING(false);
$lister->addField($_field);

$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('createDateFormatted')->setTEXT_LABEL('Создана')->setSORTING(true)->setSORT_FIELD('ai.create_date');
$lister->addField($_field);

/*$_field = new AK_Data_Lister_Field();
$_field->setSQL_FIELD('SEO')->setTEXT_LABEL('SEO (T/K/D)')->setTEXT_HTML(true)->setSORTING(false)->setTEXT_STRONG(true);
$lister->addField($_field);
*/
//------------------------------------------------------------------------------------------------------------------
$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/edit.png" />')->setLINK_CLASS('tableBottomNext')->setLINK_HREF(MODULE_URL.'/articles/edit/');
$lister->addOption($_option);

$_option = new AK_Data_Lister_Option();
$_option->setTEXT_LABEL('<img src="/admin/images/bascket.png" />')->setLINK_CLASS('tableBottomRight')->setLINK_HREF(MODULE_URL.'/articles/delete/')->setLINK_EVENT('onclick = "return confirm(\'Удалить данную статью?\');"');
$lister->addOption($_option);
//------------------------------------------------------------------------------------------------------------------
$_toplink = new AK_Data_Lister_TopLink();
$_toplink->setTEXT_LABEL('Добавить')->setTEXT_STRONG(false)->setLINK_HREF(MODULE_URL.'/articles/add/');
$lister->addTopLink($_toplink);
//------------------------------------------------------------------------------------------------------------------
$_filter = new AK_Data_Lister_Filter();
$_filter->field = 'rewrite_name';
$_filter->label = 'Псевдоним';
$_filter->type = 'text';


if ($this->getRequest()->getParam('filterfield') && $this->getRequest()->getParam('filterfield') == 'rewrite_name') {
    $_filter->variant = $this->getRequest()->getParam('filtervalue');
} elseif (!empty($_SESSION['LISTER'][$lister->getNamespace()]['FILTER']['FIELD']) && isset($_SESSION['LISTER'][$lister->getNamespace()]['FILTER']['VALUE']) ) {
    $_filter->variant = $_SESSION['LISTER'][$lister->getNamespace()]['FILTER']['VALUE'];
} else {
    $_filter->variant = '';
}

$lister->addFilter($_filter);
$_filter->where = "B.rewrite_name LIKE '".prepareLike($_filter->variant)."%'";
//------------------------------------------------------------------------------------------------------------------
$this->view->LISTER_OUTPUT = $lister->getOutput();

<?php

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;  
$currentItem = new AK_News_Item($this->params['id']);
/*warning magic number for NEWS*/

$categoriesList = new AK_Menu_Sublink_List;
$categoriesList = $categoriesList->addWhere('A.link_id = ?', 49 );

$categoriesList2 = new AK_Menu_Link_List;
$categoriesList2 = $categoriesList2->addWhere('A.menu_id = ?', 3 );

$form = new AK_Form('editItem', 'post', MODULE_URL.'/news/add/');
$form->addRule('title', 'required', 'Введите заголовок');
$form->addRule('rewriteName', 'required', 'Введите псевдоним'); 
$form->addRule('rewriteName', 'rewritename', 'В псевдониме допустимы только латинские буквы, цифры, знаки "-" и "_"');
$form->addRule('rewriteName', 'callback', 'Псевдоним с таким именем уже существует',  array('func' => 'rewriteNameExists', 'params' => array('id' => $currentItem->getId(), 'EntityTypeId' => $currentItem->EntityTypeId,'rewriteName' => isset($this->params['rewriteName']) ? $this->params['rewriteName'] : '') ) );


if ($form->isPostback()){
  $this->params['isActive'] = empty($this->params['isActive'])?0:1;
    $this->params['hideDate'] = empty($this->params['hideDate'])?0:1;
  $form->setDefaults($this->params);  
}

if ($form->validate($this->params)){
    if (isset($this->params['createDate']))
    {
       //"%d-%m-%Y %H:%M:%S" 
       if (! $this->params['createDate'] = mktime(substr($this->params['createDate'],11,2), substr($this->params['createDate'],14,2), substr($this->params['createDate'],17,2), substr($this->params['createDate'],3,2), substr($this->params['createDate'],0,2), substr($this->params['createDate'],6,4) )) $this->params['createDate'] = time();
       //print $this->params['createDate'].' '.date('d-m-Y H:i:s', $this->params['createDate']); 
    }else {
        $this->params['createDate'] = time();     
    }
    //
    $currentItem->setTitle($this->params['title']);
    $currentItem->setContent($this->params['content']);
    $currentItem->setCreateDate($this->params['createDate']);
    $currentItem->setIsActive($this->params['isActive']);
    $currentItem->setHideDate($this->params['hideDate']);
    $currentItem->setCategoryId($this->params['categoryId']);
    $currentItem->setCreatorId($this->view->administrator->getId()); 
    
    $currentItem->setRewriteName($this->params['rewriteName']);
    $currentItem->setMetaTitle($this->params['metaTitle']);
    $currentItem->setMetaDescription($this->params['metaDescription']);
    $currentItem->setMetaKeywords($this->params['metaKeywords']);
    
    $currentItem->save();

    $this->_redirect(MODULE_URL.'/news/list/');
}

$this->view->form = $form;
$this->view->currentItem = $currentItem;
$this->view->categoriesList = $categoriesList->returnAsAssoc(true)->getList();
$this->view->categoriesList2 = $categoriesList2->returnAsAssoc(true)->getList();

$this->view->BODY_CONTENT_FILE = "news/add.tpl";







// callback function for rewrite name ----------------------------------------------------------------------------------
function rewriteNameExists($params)
{
    $_db = Zend_Registry :: get('DB');

    $where = $_db->quoteInto("rewrite_name = ?", $params['rewriteName']);
    
    $query = $_db->select()->from(DBT_PREFIX.'_rewrite__names', 'rewrite_name')->where($where)->where('entity_type_id = ?', $params['EntityTypeId']);
    
    if (!empty($params['id'])) {
        $query->where($_db->quoteInto("entity_id <> ?", $params['id']));
    }
    
    
    return $_db->fetchOne($query) ? true : false;
}
//-----------------------------------------------------------------------------------------------------------------------

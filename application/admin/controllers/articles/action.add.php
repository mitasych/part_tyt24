<?php

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;  
$currentItem = new AK_Article_Item($this->params['id']);

$categoriesList = new AK_Article_Category_List;

$form = new AK_Form('editItem', 'post', MODULE_URL.'/articles/add/');
//$form->addRule('title', 'required', 'Введите заголовок');
$form->addRule('rewriteName', 'required', 'Введите псевдоним'); 
$form->addRule('rewriteName', 'rewritename', 'В псевдониме допустимы только латинские буквы, цифры, знаки "-" и "_"');
$form->addRule('rewriteName', 'callback', 'Псевдоним с таким именем уже существует',  array('func' => 'rewriteNameExists', 'params' => array('id' => $currentItem->getId(), 'EntityTypeId' => $currentItem->EntityTypeId,'rewriteName' => isset($this->params['rewriteName']) ? $this->params['rewriteName'] : '') ) );


if ($form->isPostback()){
  $this->params['isActive'] = empty($this->params['isActive'])?0:1;
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
    $currentItem->setCategoryId($this->params['categoryId']);
    $currentItem->setCreatorId($this->view->administrator->getId()); 
    
    $currentItem->setRewriteName($this->params['rewriteName']);
    $currentItem->pic = $this->params['pic'];
    $currentItem->setMetaTitle($this->params['metaTitle']);
    $currentItem->setMetaDescription($this->params['metaDescription']);
    $currentItem->setMetaKeywords($this->params['metaKeywords']);
    
    $currentItem->save();

    $this->_redirect(MODULE_URL.'/articles/list/');
}

$this->view->form = $form;
$this->view->currentItem = $currentItem;
$this->view->categoriesList = $categoriesList->returnAsAssoc(true)->getList();

$this->view->BODY_CONTENT_FILE = "articles/add.tpl";




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

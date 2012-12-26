<?php

$this->params['page'] = isset($this->params['page'])?$this->params['page']:'';

$currentInfo = new AK_Article_Item();

$currentInfo->loadByRewriteName($this->params['page']);

    
//    if ($currentInfo->getIsActive() &&  !$currentInfo->getCategory()->getIsFree() )
//    {
//        return $currentInfo->getContent();
//    }
//    else
//    {
//        return '';
//    }
    
//$ida = AK_Info_Item::getIdByRewriteName($this->params['page']);
//$currentInfo = new AK_Info_Item(intval($ida));

if ( !$currentInfo->getId() || !$currentInfo->getIsActive())
{
    $this->_redirect(SITE_URL);
    //$this->view->BODY_CONTENT_FILE = 'info/notfound.tpl';
}
else 
{
    if ($currentInfo->getMetaTitle()) {
        $this->view->TITLE = $currentInfo->getMetaTitle();
    } elseif ($currentInfo->getTitle()) $this->view->TITLE = $currentInfo->getTitle();
    if ($currentInfo->getMetaKeywords()) {
        $this->view->KEYWORDS = $currentInfo->getMetaKeywords();
    }
    if ($currentInfo->getMetaDescription()) {
        $this->view->DESCRIPTION = $currentInfo->getMetaDescription();
    }
    
    $this->view->currentInfo = $currentInfo;
}

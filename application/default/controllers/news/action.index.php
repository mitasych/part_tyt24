<?php
  $old =1;
  $RequestUrl = $this->_request->getRequestUri();
  $this->view->RequestUrl = $RequestUrl;
  $_sublinks = new AK_Menu_Sublink_List();
  $_sublinks = $_sublinks->addWhere('A.link_id = ?', 49 )->setOrder('A.queue ASC')->getList();;

  foreach ($_sublinks as $_subkey => &$_sublink)
  {
    if ($RequestUrl===$_sublink->getLink())
    {
    $newsList = new AK_News_List();
    $newsList = $newsList->addWhere('category_id = ?',$_sublink->getId())->setOrder('create_date DESC')->setCurrentPage(1)->setListSize(10)->getList();
    $this->view->newsList = $newsList;
    $old=0;
    }
  }
  
/* old ---------------------------------- */
  if($old==1){
$this->params['alias'] = isset($this->params['alias'])?$this->params['alias']:'';

$currentInfo = new AK_News_Item();
$currentInfo->loadByRewriteName($this->params['alias']);
//id
if ( !$currentInfo->getId()) {
    $currentInfo = new AK_News_Item(intval($this->params['alias']));
}

if ( !$currentInfo->getId() || !$currentInfo->getIsActive())
{
    $this->_redirect(SITE_URL);
    //$this->view->BODY_CONTENT_FILE = 'info/notfound.tpl';
}
else 
{
    if ($currentInfo->getMetaTitle()) {
        $this->view->TITLE = $currentInfo->getMetaTitle();
    } else {
        $this->view->TITLE = $currentInfo->getTitle();
    }
    if ($currentInfo->getMetaKeywords()) {
        $this->view->KEYWORDS = $currentInfo->getMetaKeywords();
    }
    if ($currentInfo->getMetaDescription()) {
        $this->view->DESCRIPTION = $currentInfo->getMetaDescription();
    }
    
    $this->view->currentNews = $currentInfo;
}
  }
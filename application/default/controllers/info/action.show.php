<?php


if(empty($_SESSION['mySELECTED_MENU_ID'])) $_SESSION['mySELECTED_MENU_ID']=0;
$this->params['page'] = isset($this->params['page'])?$this->params['page']:'';
$this->params['lid'] = isset($this->params['lid'])?$this->params['lid']:'';
$this->params['sid'] = isset($this->params['sid'])?$this->params['sid']:'';

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
    $_menu = new AK_Menu_Item;
    $_menu->loadByField('alias', 'top_menu');
    $_links = new AK_Menu_Link_List;
    $_links = $_links->addWhere('A.is_active = 1')->addWhere('A.menu_id = ?', $_menu->getId())->setOrder('A.queue ASC')->getList();
         foreach ($_links as $_key => &$_link)
                {
                if($_link->getLink()===$this->_request->getRequestUri())
                {
                        $_SESSION['mySELECTED_MENU_ID']= $_link->getId();
                        $_SESSION['mySELECTED_LEFTMENU_ID'] = 0;
                }
                }
        $_sublinks = new AK_Menu_Sublink_List;
        $_sublinks = $_sublinks->setOrder('A.queue ASC')->getList();
         foreach ($_sublinks as $_key => &$_sublink)
                {
                if($_sublink->getLink()===$this->_request->getRequestUri())
                  if ($_sublink->getParentLink()->getmenu_id()==3)
                    {
                        $_SESSION['mySELECTED_SUBMENU_ID']= $_sublink->getId();
                        $_SESSION['mySELECTED_LEFTMENU_ID'] = $_sublink->getPositionId();
                        $_SESSION['mySELECTED_MENU_ID'] = $_sublink->getParentLink()->getId();
                        $this->view->left = $_SESSION['mySELECTED_LEFTMENU_ID'];
                    }

                }


    $this->view->currentInfo = $currentInfo;
    $this->view->RequestUrl = $this->_request->getRequestUri();

}

<?php
// name, delimiter
function smarty_function_getsession($params, &$smarty) {

    if (empty($_SESSION['mySELECTED_LEFTMENU_ID'])) $_SESSION['mySELECTED_LEFTMENU_ID'] = 0;
    if (empty($_SESSION['mySELECTED_MENU_ID'])) $_SESSION['mySELECTED_MENU_ID'] = 0;
    if (empty($_SESSION['mySELECTED_SUBMENU_ID'])) $_SESSION['mySELECTED_SUBMENU_ID'] = 0;
    //if ($params['alias']=='/') return ;//показывать или не показывать на главной выделеные пункты жирного меню
    $_content = '';
   // if (empty($params['controller'])) return $_content;
    if (empty($params['alias'])) return $_content;
    //if (empty($params['lid'])) return $_content;
   // if (empty($params['sid'])) return $_content;
    $_menu = new AK_Menu_Item;
    $_menu->loadByField('alias', 'top_menu');
    $_links = new AK_Menu_Link_List;
    $_links = $_links->addWhere('A.is_active = 1')->addWhere('A.menu_id = ?', $_menu->getId())->setOrder('A.queue ASC')->getList();
         foreach ($_links as $_key => &$_link)
                {
                if($_link->getLink()===$params['alias'])
                {

                        $_SESSION['mySELECTED_MENU_ID']= $_link->getId();
                        $_SESSION['mySELECTED_LEFTMENU_ID'] = 0;
                }
                
}
    $_sublinks = new AK_Menu_Sublink_List;
    $_sublinks = $_sublinks->setOrder('A.queue ASC')->getList();
         foreach ($_sublinks as $_key => &$_sublink)
                {
                if($_sublink->getLink()===$params['alias'])
                  if ($_sublink->getParentLink()->getmenu_id()==3)
                {
                        $_SESSION['mySELECTED_SUBMENU_ID']= $_sublink->getId();
                        $_SESSION['mySELECTED_LEFTMENU_ID'] = $_sublink->getPositionId();
                        $_SESSION['mySELECTED_MENU_ID'] = $_sublink->getParentLink()->getId();

                }

}
    
}

<?php
// name, delimiter
function smarty_function_mybreadcrumb($params, &$smarty) {
   
    $temp = '';
    $_content = '';

  //  if (empty($params['controller'])) return $_content;
  //  if (empty($params['alias'])) return $_content;
    /* Показываем на главное подменю для предприятий по-умолчанию */
    $main_page = false;
    if(empty($_SESSION['mySELECTED_MENU_ID']) || $_SESSION['mySELECTED_MENU_ID']==0)
    {
        $_SESSION['mySELECTED_MENU_ID']=46;
        $main_page = true;
    }
    //if (empty($params['lid'])) return $_content;
   // if (empty($params['sid'])) return $_content;
    
    $_sublinks = new AK_Menu_Sublink_List;
    $_sublinks = $_sublinks->addWhere('A.link_id = ?', $_SESSION['mySELECTED_MENU_ID'])->addWhere('A.note = 0')->setOrder('A.queue ASC')->getList();
    if (!empty($_sublinks))
       {
        $count = 0;
       foreach ($_sublinks as $_subkey => &$_sublink)
         {
           $count++;
         $_addclass = '';
         $_addclassli = '';
         if ($_sublink->getIsRed())
           {
           $_addclass=' red';
           $_addclassli=' class="red"';
           }
         $_addid = '';
        // if ($_sublink->getLink()==$params['alias']) $_addid=' id="active" ';
         if ($_sublink->getId()==$_SESSION['mySELECTED_SUBMENU_ID'])  $_addid=' id="active" ';
             
           if ($count==count($_sublinks)) $_content.='<li'.$_addid.' class="last" '.$_addclassli.'><a id="als'.$_sublink->getId().'" class="subm'.$_addclass.'" href="'.$_sublink->getLink().'">'.str_replace(' ',' ',$_sublink->getTitle()).'</a></li>';
           else                           $_content.='<li'.$_addid.$_addclassli.'><a id="als'.$_sublink->getId().'" class="subm'.$_addclass.'" href="'.$_sublink->getLink().'">'.str_replace(' ',' ',$_sublink->getTitle()).'</a></li>';
         }
       }
 
    
    if ($main_page == true) $_SESSION['mySELECTED_MENU_ID']=0;

    
    return $_content;
}

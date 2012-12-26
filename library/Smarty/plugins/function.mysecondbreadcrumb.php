<?php
// name, delimiter
function smarty_function_mysecondbreadcrumb($params, &$smarty) {
    
    
    $_content = '<ul id=left_menu>';

    if (empty($_SESSION['mySELECTED_LEFTMENU_ID'])) return $_content;
    if ($_SESSION['mySELECTED_LEFTMENU_ID']==0) return $_content;
     $_sublinks = new AK_Menu_Sublink_List;

     $_sublinks = $_sublinks->addWhere('A.is_show = ?', 1)->addWhere('A.link_id = ?',$_SESSION['mySELECTED_LEFTMENU_ID'])->getList();
    //$_links = снг, рос


     if (!empty($_sublinks)) {
         
                    foreach ($_sublinks as $_subkey => &$_sublink) {
                        $_addclass = '';
                        $_addclassli = '';
                        if ($_sublink->getIsRed()) {
                            $_addclass=' red';
                            $_addclassli=' class="red"';
                        }
                                         
                        $_content.='<li'.$_addclassli.'><a id="als'.$_sublink->getId().'" class="subm'.$_addclass.'" href="'.$_sublink->getLink().'">'.str_replace(' ',' ',$_sublink->getTitle()).'&nbsp;</a></li>';
                        
                    
                    
                    }}
      $_content.='</ul>';


           

    return $_content;
}

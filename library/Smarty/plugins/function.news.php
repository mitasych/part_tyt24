<?php
function smarty_function_news($params, &$smarty) {
    $_content = '';
 if($_SESSION['mySELECTED_MENU_ID']>0)
 {
    $newsList = new AK_News_List();
    $newsList = $newsList->addWhere('category_id = ?',$_SESSION['mySELECTED_MENU_ID'])->setOrder('create_date DESC')->setCurrentPage(1)->setListSize(10)->getList();
    $this->view->newslist = $newsList;
 }
 else
     return $_content;
   
}

?>

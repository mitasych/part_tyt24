<?php

$currentInfo = new AK_Article_Item();
$currentInfo->loadByRewriteName('profile');
$this->view->currentInfo = $currentInfo;

if ($currentInfo->getMetaTitle()) {
    $this->view->TITLE = $currentInfo->getMetaTitle();
} elseif ($currentInfo->getTitle()) { 
    $this->view->TITLE = $currentInfo->getTitle();
}

if ($currentInfo->getMetaKeywords()) {
    $this->view->KEYWORDS = $currentInfo->getMetaKeywords();
}

if ($currentInfo->getMetaDescription()) {
    $this->view->DESCRIPTION = $currentInfo->getMetaDescription();
}
/* inicialize */
$tmpName = "";
		$resultSubregions = array() ;
		$resultSubindustries = array() ;
                $_SESSION['mySELECTED_MENU_ID'] =0;
                $_SESSION['mySELECTED_SUBMENU_ID'] =0;
                $_SESSION['mySELECTED_LEFTMENU_ID'] =0;
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
                $time_start = microtime_float();
     
include_once('filters.php');

    $time_end = microtime_float();
      $time = $time_end - $time_start;
      $this->view->time = $time; /* время выполнения запроса в бд */

$this->view->RequestUrl = $this->_request->getRequestUri();


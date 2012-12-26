<?php

$currentInfo = new AK_Article_Item();
$currentInfo->loadByRewriteName('profile');
$this->view->currentInfo = $currentInfo;
$tmpName = "";
		$resultSubregions = array() ;
		$resultSubindustries = array() ;
                $_SESSION['mySELECTED_MENU_ID'] =0;
                $_SESSION['mySELECTED_SUBMENU_ID'] =0;
                $_SESSION['mySELECTED_LEFTMENU_ID'] =0;

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
  /*  $id = isset($this->params['id'])?$this->params['id']:'';
    $filter = new Zend_Filter_Alpha();
    $id = $filter->filter($id);*/
    
    //$id = substr($id, 0,2);
 $okved_menu = new AK_okved_MenuList();
 $top = empty($top)?array ("name" => '' , "id" => '' , "count" => ''):$top;
 if ($id=='*')  $okved_menu = $okved_menu->setOrder('A.name ASC')->returnAsAssoc(true)->getList();
 else           $okved_menu = $okved_menu->addWhere('A.name LIKE ?',$id."%")->setOrder('A.name ASC')->returnAsAssoc(true)->getList();

 

 foreach ($okved_menu as $key=>$value)
 { 
   $menu_level = $key;
   $company_count = new AK_company_ListShort();
   if ($menu_level>54)
     $company_count = $company_count->addWhere('A.secondlevel_id = ?',$menu_level)->getCount ();
   else
   {
      if ($menu_level>8)
          $company_count = $company_count->addWhere('A.firstlevel_id = ?',$menu_level)->getCount ();
      else
          $company_count = $company_count->addWhere('A.zerolevel_id = ?',$menu_level)->getCount ();
   }
          
   if ($company_count>0) 

     $hits[] = array("id" => $menu_level, "name" => $value , "count" => $company_count);
     if ($company_count>$top['count'])
                             $top =  array("id" => $menu_level, "name" => $value , "count" => $company_count);
   
 }

 if (empty($top)) $this->_redirect("/index/index/id/*/okato/$okato");
 $this->view->okvedtop = $top;
 $this->view->hits = $hits;
/* if ($id == '') $id='*';
 $this->view->id = $id;
*/
 $this->view->alf = array ("*", "А" , "Б" , "В" , "Г" , "Д" , "Е" , "Ё" , "Ж" , "З" , "И" , "К" , "Л" , "М" , "Н" , "О" , "П" , "Р" , "С" , "Т" , "У" , "Ф" , "Х" , "Ц" , "Ч" , "Ш" , "Щ" , "Э" , "Ю" , "Я" );


$okato = isset($this->params['okato'])?$this->params['okato']:'';
/*
$okato_menu = new AK_okato_List();
$okato_submenu = new AK_okato_List();
if ($okato=='')
{

  //$okato_menu = $okato_menu->addWhere('A.parent_id is null')->setOrder('A.id ASC')->setCurrentPage(1)->setListSize(100)->getList();
  $okato_menu = $okato_menu->addWhere('A.parent_id in (29554, 29553 ,29552,29551,29550,29549,29548,29543)')->setOrder('A.name ASC')->returnAsAssoc(true)->getList();
  foreach ( $okato_menu as $key=>$value)
    $goalokato[] = array( "id" => $key,  "name" => $value );


  /*foreach ( $okato_menu as $item)
  { //->setCurrentPage(1)->setListSize(9999)
    $goalokato[] = array( "id" => $item->getId(), "code" => $item->getCode(), "name" => $item->getName(), "subitems" => $okato_submenu->addWhere("A.parent_id =?",$item->getId())->setOrder('A.id ASC')->setCurrentPage(1)->setListSize(4)->getList() );
    $okato_submenu = new AK_okato_List();
  }*/
/*
}
else
{
    
  //$code = new AK_okato_Item($okato_id);
  //$coder = $code->getCode();
  //$len=strlen($coder);
  //$coder =str_replace('0', '', $coder); ;(isp v sly4ae func iz okatoexport zero_delet)
  $okato_menu = $okato_menu->addWhere("A.parent_id =?",$okato)->setOrder('A.name ASC')->returnAsAssoc(true)->getList();
  $cur_okato = new AK_okato_Item($okato);
  $this->view->current_okato = $cur_okato->getName();
   foreach ( $okato_menu as $key=>$value)
   {
    $type='';
    if (strpos($value,'/')!==false) {
        
        if(strpos($value,"Города")!== false)
                $type = 'г. ';
        if(strpos($value,"Поселки")!== false)
                $type = 'п. ';
        if(strpos($value,"Районы")!== false)
                $type = 'р-н. ';
        if(strpos($value,"Сельсоветы")!== false)
                $type = 'Сельсовет ';
        $value='';
    }
    
    $goalokato[] = array( "id" => $key,  "name" => $value, "subitems" => $okato_submenu->addWhere("A.parent_id =?",$key)->setOrder('A.name ASC')->returnAsAssoc(true)->getList(), "type" => $type);
    $okato_submenu = new AK_okato_List();
   }

}

$this->view->okatoM=$goalokato;
$this->view->okato=$okato;
*/

$this->view->RequestUrl = $this->_request->getRequestUri();


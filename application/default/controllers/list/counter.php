<?php

$okatostr = empty($okatostr)?'':$okatostr;
$strokved = empty($strokved)?'':$strokved;
$okved_menu = new AK_okved_MenuList();
$okato_menu = new AK_okato_List();
$time_start2 = microtime_float();
      if ($strwhat!='')
       {
         
         if ($okatostr!='') $strwhat2  = " AND $strwhat";
         else $strwhat2 = $strwhat;
         
       }

if ($okved=='')
{
    $okved_menu = $okved_menu->addWhere('A.parent_id is null')->setOrder('A.name ASC')->getList();
    
    foreach ( $okved_menu as $item)
    {   
        $menu_id = $item->getId();
        $ok_companylist_count = new AK_company_ListShort();
        if ($okatostr.$strwhat2=='') $str_okved_count = "A.zerolevel_id = '$menu_id'";
        else                         $str_okved_count = "A.zerolevel_id = '$menu_id' AND ".$okatostr.$strwhat2;

        
        $ok_companylist_count = $ok_companylist_count->addWhere($str_okved_count)->getCount();
        
        if ($ok_companylist_count>0)
        $okved_goal_count[] = array ("id" => $item->getId(), "name" => $item->getName(), "count" => $ok_companylist_count);
    }


}

if ($okved>8 and $okved<=54)
{
    $okved_menu = $okved_menu->addWhere('A.parent_id = ?',$okved)->setOrder('A.name ASC')->getList();
    foreach ( $okved_menu as $item)
    {
        $menu_id = $item->getId();
        $ok_companylist_count = new AK_company_ListShort();
        if ($okatostr.$strwhat2=='') $str_okved_count = "A.secondlevel_id = '$menu_id'";
        else                         $str_okved_count = "A.secondlevel_id = '$menu_id' AND ".$okatostr.$strwhat2;


        $ok_companylist_count = $ok_companylist_count->addWhere($str_okved_count)->getCount();
        if ($ok_companylist_count>0)
        $okved_goal_count[] = array ("id" => $item->getId(), "name" => $item->getName(), "count" => $ok_companylist_count);
    }
}
if ($okved<9 AND $okved>0)
{
    $okved_menu = $okved_menu->addWhere('A.parent_id = ?',$okved)->setOrder('A.name ASC')->getList();
    foreach ( $okved_menu as $item)
    {
        $menu_id = $item->getId();
        $ok_companylist_count = new AK_company_ListShort();
        if ($okatostr.$strwhat2=='') $str_okved_count = "A.firstlevel_id = '$menu_id'";
        else                         $str_okved_count = "A.firstlevel_id = '$menu_id' AND ".$okatostr.$strwhat2;


        $ok_companylist_count = $ok_companylist_count->addWhere($str_okved_count)->getCount();
        if ($ok_companylist_count>0)
        $okved_goal_count[] = array ("id" => $item->getId(), "name" => $item->getName(), "count" => $ok_companylist_count);
    }
}

if ($okved>54)
{   if ($okatostr.$strwhat2=='') $str_okved_count = "A.secondlevel_id = '$okved'";
    else                         $str_okved_count = "A.secondlevel_id = '$okved' AND ".$okatostr.$strwhat2;
    
    $okved_menu_item = new AK_okved_Menu($okved);
    {
        $menu_id = $okved_menu_item->getId();
        if($menu_id!=''){
        $ok_companylist_count = new AK_company_ListShort();
        $ok_companylist_count = $ok_companylist_count->addWhere($str_okved_count)->getCount();
        if ($ok_companylist_count>0)
        $okved_goal_count[] = array ("id" => $okved_menu_item->getId(), "name" => $okved_menu_item->getName(), "count" => $ok_companylist_count);
        }
    }
}

      if ($strwhat!='')
       {

          $strwhat  = " AND $strwhat";


       }

if($okato=='')
{
      $okato_menu = $okato_menu->addWhere('A.parent_id is null')->returnAsAssoc()->getList();
    
      foreach ( $okato_menu as $item)
          {
           $okatoItem = new AK_okato_Item($item['id']);

           $okato_id = $okatoItem->getId();
           
           $okato_list = new AK_okato_List();
           $okato_list = $okato_list->addWhere("A.parent_id = $okato_id")->returnAsAssoc()->getList();
           $str2='';

           $okatostr2 ='';
           foreach($okato_list as $item2)
                {

                    $itemcode = $item2['code'];

                    $okatostr2 .= "A.okato_id LIKE '$itemcode%' OR ";
                }
          $okatostr2[strlen($okatostr2)-3]=')'; //вырезаем последний OR
          $okatostr2[strlen($okatostr2)-2]=' ';
          $str2 = "(".$okatostr2;   // добавляем скобки

           if ($strokved.$strwhat=='')  $str_okato_count = $str2;
           else                        
             if ($strokved=='') $str_okato_count = $str2.$strwhat;
             else $str_okato_count = $strokved." AND ".$str2.$strwhat;
        
          
          $ok_companylist_count = new AK_company_ListShort();
          $ok_companylist_count = $ok_companylist_count->addWhere($str_okato_count)->getCount();
          
          if ($ok_companylist_count>0)
          $okato_goal_count[] = array( "id" => $item['id'],  "name" => $item['name'],  "count" => $ok_companylist_count  );
          
          }


}

else
{
  
     $okato_menu = $okato_menu->addWhere('A.parent_id =?',$okato)->returnAsAssoc()->getList();
     
     foreach ( $okato_menu as $item)
          {

             if ($strokved.$strwhat=='')  $str_okato_count = "A.okato_id LIKE '$item[code]%'";
             else
                if($strokved=='') $str_okato_count = "A.okato_id LIKE '$item[code]%'".$strwhat;
                else              $str_okato_count = $strokved." AND "."A.okato_id LIKE '$item[code]%'".$strwhat;

     
             $ok_companylist_count = new AK_company_ListShort();

             $ok_companylist_count = $ok_companylist_count->addWhere($str_okato_count)->getCount();
             if ($ok_companylist_count>0)
             $okato_goal_count[] = array( "id" => $item[id],  "name" => $item[name],  "count" => $ok_companylist_count  );
            
          }
     if ($okato_goal_count=='')
     {
         $item = new AK_okato_Item($okato);
         $menu_id = $item->getId();
         $menu_code = $item->getCode();
         $menu_name = $item->getName();
         if($menu_id!=''){
         if ($strokved.$strwhat=='')  $str_okato_count = "A.okato_id LIKE '$menu_code%'";
         else
           if ($strokved=='') $str_okato_count = "A.okato_id LIKE '$menu_code%'".$strwhat;
           else               $str_okato_count = $strokved." AND "."A.okato_id LIKE '$menu_code%'".$strwhat;
      
         $ok_companylist_count = new AK_company_ListShort();

         $ok_companylist_count = $ok_companylist_count->addWhere($str_okato_count)->getCount();
         if ($ok_companylist_count>0)
         $okato_goal_count[] = array( "id" => $menu_id,  "name" => $menu_name,  "count" => $ok_companylist_count  );
  
         }
     }

}

$this->view->okved_count = $okved_goal_count;
$this->view->okato_count = $okato_goal_count;

      $time_end2 = microtime_float();
      $time2 = $time_end2 - $time_start2;
     
      $TimeInBase = new AK_Timer_Item();
      $TimeInBase->setTime((float)$time2)
                 ->setWhat($str_okved_count."AND".$str_okato_count)
                 ->setController("LIST_counter");
                 //->setOkved() //нафига тут 2 этих параметра с пустыми скобками ума не приложу
                 //->setOkato();

       $TimeInBase->save();

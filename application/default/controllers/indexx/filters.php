<?php
function sort_menu($a, $b) {
    if ($a['count'] == $b['count']) {
        return 0;
    }
    return ($a['count'] > $b['count']) ? -1 : 1;
}
function delete_zero ($string)
{
    while($string[strlen($string)-1]=='0')
    {

        $string = substr($string, 0, -1);

    }
   return $string;
}

/* INITIALIZE */
      include_once(APP_DIR.'/default/initialize.php');
      $str='';
      $okatostr ='';
 /* END INITIALIZE */

          $time_start = microtime_float();
      /* OKATO */
           if ($okato!='')
           {

                              /*Т.к у ФЕДЕРАЛЬНЫХ ОКРУГОВ НЕТ КОДА ПО КОТОРОМУ МОЖНО ПРОИЗВЕСТИ ПОИСК,
                                то нужно производить поиск во элементах у которых стоит на него parent_id
                                тест производительности
                                SELECT *
                                FROM `class_company_short2`
                                WHERE `okato_id` LIKE '10%'
                                OR `okato_id` LIKE '99%'
                                OR `okato_id` LIKE '30%'
                                OR `okato_id` LIKE '44%'
                                OR `okato_id` LIKE '05%'
                                OR `okato_id` LIKE '98%'
                                OR `okato_id` LIKE '64%'
                                OR `okato_id` LIKE '77%'
                                ORDER BY `class_company_short2`.`id` ASC */
                                   // результат: 2,143 всего, запрос занял 0.0058 сек


           $okatoItem = new AK_okato_Item($okato);
           $okatocode = $okatoItem->getCode();
           $okato_id = $okatoItem->getId();
           if($okatocode=='') // Для ФО
             {
               $str='';
             
                $okato_list = new AK_okato_List();
                $okato_list = $okato_list->addWhere("A.parent_id = $okato_id")->getList();

                foreach($okato_list as $item)
                {
                    
                    $itemcode = $item->getCode();

                    $okatostr .= "A.okato_id LIKE '$itemcode%' OR ";
                }
                $okatostr[strlen($okatostr)-3]=')'; //вырезаем последний OR
                $okatostr[strlen($okatostr)-2]=' ';
                $str = "(".$okatostr;   // добавляем скобки
                
             }
           else {
             $str = "A.okato_id LIKE '$okatocode%'";
           }
           }
                               // END OKATO

  // OKVED

if ($id!='')
    include_once(APP_DIR.'/default/controllers/index/action.rubric.php');
else{

    $okved_menu = new AK_okved_MenuList();
    $top = array ("name" => '' , "id" => '' , "count" => '');

if ($okved=='')
       $okved_menu = $okved_menu->addWhere('A.parent_id is null')->setOrder('A.count DESC')->getList();
if ($okved>8)
{
       $cur_okved = new AK_okved_Menu($okved);
       $this->view->current_okved = $cur_okved->getName();
       $okved_menu = $okved_menu->addWhere('A.id =?',$cur_okved->getParent_id())->setOrder('A.name ASC')->getList();
}
if ($okved<9 AND $okved>0)
{
    $cur_okved = new AK_okved_Menu($okved);
    $this->view->current_okved = $cur_okved->getName();
    $okved_menu_first_level = $okved_menu->addWhere('A.parent_id is null')->setOrder('A.count DESC')->getList();
    $okved_menu = $okved_menu->addWhere('A.id =?',$okved)->setOrder('A.name ASC')->getList();
    
    $menu_first_level = array();  
    foreach ($okved_menu_first_level as $item) {
    	$menu_first_level[] = array("id" => $item->getId(), "name" => $item->getName());
    }
    $this->view->okvedMenuFirstLevel=$menu_first_level;
}
 $flag_redirect = true;

    foreach ( $okved_menu as $item)
    {   $counter1=0;

        $menu_id = $item->getId();
        $okved_submenu = new AK_okved_MenuList();
        $okved_submenu = $okved_submenu->addWhere("A.parent_id =?",$menu_id)->setOrder('A.id ASC')->getList();
        $submenu = array();
        foreach ($okved_submenu as $item2)
        { 
        
        //if ($counter1==3 && empty($show)) break;
          $ok_companylistCount = new AK_company_ListShort();
		  
		  $okved_subsubmenu = new AK_okved_MenuList();
          $subitem = $item2->getId();
          $secondlevel_id = '';
          $firstlevel_id = '';
          if ($subitem>54)
              {
                  if ($str=='') $count = $ok_companylistCount->addWhere("A.secondlevel_id = '$subitem'")->getCount();
                  else         $count = $ok_companylistCount->addWhere("A.secondlevel_id = '$subitem'")->addWhere($str)->getCount();
              }
          else
          {
              if ($str=='') $count = $ok_companylistCount->addWhere("A.firstlevel_id = '$subitem'")->getCount();
              else         $count = $ok_companylistCount->addWhere("A.firstlevel_id = '$subitem'")->addWhere($str)->getCount();
          }

          $okved_subsubmenu = $okved_subsubmenu->addWhere("A.parent_id  = '$subitem'")->getList();
		  
          $counter2=0;
		  $subsubmenu = array();
		  foreach ($okved_subsubmenu as $item3)
		  {      //if ($counter2==5 && empty($show)) break;
                         //есть элемент = не переходим на список
                         
                         $subsubitem = $item3->getId();
			 $ok_companylistSubCount = new AK_company_ListShort();
                         if ($str=='') $count2 = $ok_companylistSubCount->addWhere("A.secondlevel_id = '$subsubitem'")->getCount();
                         else          $count2 = $ok_companylistSubCount->addWhere("A.secondlevel_id = '$subsubitem'")->addWhere($str)->getCount();

                         if ($count2>$top['count'])
                             $top = array("id" => $item3->getId(), "name" => $item3->getName() , "count" => $count2 );

                         if ($okved=='' && $count2>0)
                         {
			 $subsubmenu[] = array("id" => $item3->getId(), "name" => $item3->getName() , "count" => $count2 );
                         $counter2++;
                         $flag_redirect = false;
                         }
                        if ($okved!='' && $count2>0)
                        {
                         $subsubmenu[] = array("id" => $item3->getId(), "name" => $item3->getName() , "count" => $count2 );
                         $flag_redirect = false;
                        }
		
                  }
      if(is_array($subsubmenu)){
      	uasort($subsubmenu, 'sort_menu');
      }
	  if ($okved=='' && $count>0)
          {   
              $counter1++;
              $submenu[] = array("id" => $item2->getId(), "name" => $item2->getName() , "count" => $count, "subitems" => $subsubmenu, "subcount" => count($subsubmenu) );
              unset($subsubmenu);
              
          }
          if ($okved!='' && $count>0)
          {
          $submenu[] = array("id" => $item2->getId(), "name" => $item2->getName() , "count" => $count, "subitems" => $subsubmenu, "subcount" => count($subsubmenu) );
          unset($subsubmenu);
          }
        }
        if(is_array($submenu)){
        	uasort($submenu, 'sort_menu');
        }
        if (count($submenu)>0)
            {
             $goalokved[] = array("id" => $item->getId(), "name" => $item->getName(), "subitems" => $submenu, "subcount" => count($submenu) );
             unset($submenu);
            }
        
    }
   if ($flag_redirect==true) {$this->_redirect("/list/index/what/$what/where/$where/okved/$okved/okato/$okato/"); }
}




// OKATO

$okato_menu = new AK_okato_List();
$okato_submenu = new AK_okato_List();
$okato_companyCount = new AK_company_ListShort();
 
if ($okato=='')
{

  if ($sort=='')
      {
      if ($show2!='') $okato_menu = $okato_menu->addWhere('A.parent_id is null')->setOrder('A.id ASC')->returnAsAssoc()->getList();
      else $okato_menu = $okato_menu->addWhere('A.parent_id is null')->setOrder('A.id ASC')->setCurrentPage(1)->setListSize(10)->returnAsAssoc()->getList();
      

  $count_max = 0;
  $okato_max = "";
      foreach ( $okato_menu as $item)
          {
		  
          /*if ($show2!='') $goalokato[] = array( "id" => $item[id],  "name" => $item[name]." /", "city" => $item[additional_info], "subitems" => $okato_submenu->addWhere("A.parent_id =?",$item[id])->setOrder('A.id ASC')->returnAsAssoc()->getList() );
          else $goalokato[] = array( "id" => $item[id],  "name" => $item[name]." /", "city" => $item[additional_info], "subitems" => $okato_submenu->addWhere("A.parent_id =?",$item[id])->setOrder('A.id ASC')->setCurrentPage(1)->setListSize(4)->returnAsAssoc()->getList() );
          $okato_submenu = new AK_okato_List();*/
          $asd = $okato_submenu->addWhere("A.name =?",$item['additional_info'])->setOrder('A.id ASC')->returnAsAssoc()->getList();
          $asd = $asd[0];
          $okato_submenu->clearWhere();
          if ($show2!=''){
          	$sub_items = $okato_submenu->addWhere("A.parent_id =?",$item['id'])->setOrder('A.id ASC')->returnAsAssoc()->getList();
          	$goalokato[] = array( "id" => $item['id'],  "name" => $item['name'], "city" => $item['additional_info'], "subitems" => $sub_items, "sity_id" => $asd['id'] );
          }
          else {
          	$sub_items = $okato_submenu->addWhere("A.parent_id =?",$item['id'])->setOrder('A.id ASC')->setCurrentPage(1)->setListSize(4)->returnAsAssoc()->getList();
          	$goalokato[] = array( "id" => $item['id'],  "name" => $item['name'], "city" => $item['additional_info'], "subitems" => $sub_items, "sity_id" => $asd['id']  );
          } 
          $okato_submenu->clearWhere();
              foreach($sub_items as $sub_item){
		    	if ($okved=='') {
		    		$count = $okato_companyCount->addWhere("A.okato_id LIKE '".$sub_item['code']."%'")->getCount();
		    		$okato_companyCount->clearWhere();
		    		if($count > $count_max) {
		    			$count_max = $count;
		    			$okato_max = $sub_item['name'];
		    		}
		    		$this->view->count_max = $count_max;
		    		$this->view->okato_max = $okato_max;
		    		//echo $count." ".$okato_max."<br>";
		    	}
		    	else {
		    		if($okved < 9){
		    			$count = $okato_companyCount->addWhere("A.okato_id LIKE '".$sub_item['code']."%'")->addWhere("A.zerolevel_id = '$okved'")->getCount();
		    			$okato_companyCount->clearWhere();
		    			if($count > $count_max) {
		    				$count_max = $count;
		    				$okato_max = $sub_item['name'];
		    			}
		    			$this->view->count_max = $count_max;
		    			$this->view->okato_max = $okato_max;
		    			//echo $count." ".$okato_max."<br>";
		    		}
		    		else {
		    			$count = $okato_companyCount->addWhere("A.okato_id LIKE '".$sub_item['code']."%'")->addWhere("A.firstlevel_id = '$okved'")->getCount();
		    			$okato_companyCount->clearWhere();
			    		if($count > $count_max) {
			    			$count_max = $count;
			    			$okato_max = $sub_item['name'];
			    		}
		    			$this->view->count_max = $count_max;
			    		$this->view->okato_max = $okato_max;
			    		//echo $count." ".$okato_max."<br>";
		    		}
		    	}
    		}
          }
      }
      
  else
      {
       $okato_menu = $okato_menu->addWhere('A.parent_id in (29554, 29553 ,29552,29551,29550,29549,29548,29543)')->setOrder('A.name ASC')->returnAsAssoc(true)->getList();
       foreach ( $okato_menu as $item)
       		if($item['additional_info'] == "") {$goalokato_city[] = array( "id" => $item['id'],  "name" => $item['name'], "city" => $item['additional_info']);}
       		else {
            	$goalokato[] = array( "id" => $item['id'],  "name" => $item['name'], "city" => $item['additional_info'] );
       		}
      $goalokato = array_merge($goalokato_city, $goalokato);
      }
}
else
{

  $cur_okato = new AK_okato_Item($okato);
  $this->view->current_okato = $cur_okato->getName();
  $okato_menu_first_level = $okato_menu->addWhere('A.parent_id is null')->setOrder('A.id ASC')->returnAsAssoc()->getList();
  $this->view->okato_menu_first_level = $okato_menu_first_level;
  $okato_menu->clearWhere();
 
/*  $okato_menu = $okato_menu->addWhere("A.parent_id =?",$okato)->setOrder('A.id ASC')->getList();

  foreach ( $okato_menu as $item)
  {
      
    $goalokato[] = array( "id" => $item->getId(), "code" => $item->getCode(), "name" => $item->getName(),  "shortname" => $item->getShortName(), "parrent_id" => $item->getParent_id(), "subitems" => $okato_submenu->addWhere("A.parent_id =?",$item->getId())->setOrder('A.name ASC')->getList() );
    $okato_submenu = new AK_okato_List();
  }*/
  $okato_menu = $okato_menu->addWhere("A.parent_id =?",$okato)->setOrder('A.name ASC')->returnAsAssoc(true)->getList();
  $cur_okato = new AK_okato_Item($okato);
  $this->view->current_okato = $cur_okato->getName();
  if ($cur_okato->getParent_id()!=null)
  {
  $parent_cur_okato = new AK_okato_Item($cur_okato->getParent_id());
  $this->view->parent_current_okato = array ("id" => $parent_cur_okato->getId(),"name" => $parent_cur_okato->getName());
  }
  else
  $this->view->parent_current_okato = array ("id" => '',"name" => "Регионы");
  $count_max = 0;
  $okato_max = "";
   foreach ( $okato_menu as $item)
   {
    $type='';
    if (strpos($item['name'],'/')!==false) {

        if(strpos($item['name'],"Города")!== false)
                $type = 'г. ';
        if(strpos($item['name'],"Поселки")!== false)
                $type = 'п. ';
        if(strpos($item['name'],"Районы")!== false)
                $type = 'р-н. ';
        if(strpos($item['name'],"Сельсоветы")!== false)
                $type = 'c/c. ';
        if(strpos($item['name'],"Улусы")!== false)
                $type = 'Улус ';
        if(strpos($item['name'],"Наслеги")!== false)
                $type = 'Насег ';

        $item['name']='';
    }
    $sub_items = $okato_submenu->addWhere("A.parent_id =?",$item['id'])->setOrder('A.name ASC')->returnAsAssoc(true)->getList();
    if($cur_okato->getParent_id()==null)
        $goalokato[] = array( "id" => $item['id'],  "name" => $item['name'], "city" => $item['additional_info'], "type" => $type);
    else
        $goalokato[] = array( "id" => $item['id'],  "name" => $item['name'], "city" => $item['additional_info'] , "subitems" => $sub_items, "type" => $type);
    $okato_submenu->clearWhere();
    foreach($sub_items as $sub_item){
    	if ($okved=='') {
    		$count = $okato_companyCount->addWhere("A.okato_id LIKE '".$sub_item['code']."%'")->getCount();
    		$okato_companyCount->clearWhere();
    		if($count > $count_max) {
    			$count_max = $count;
    			$okato_max = $sub_item['name'];
    		}
    		$this->view->count_max = $count_max;
		    $this->view->okato_max = $okato_max;
		    //echo $count." ".$okato_max."<br>";
    	}
    	else {
    		if($okved < 9){
    			$count = $okato_companyCount->addWhere("A.okato_id LIKE '".$sub_item['code']."%'")->addWhere("A.zerolevel_id = '$okved'")->getCount();
    			$okato_companyCount->clearWhere();
    			if($count > $count_max) {
    				$count_max = $count;
    				$okato_max = $sub_item['name'];
    			}
    			$this->view->count_max = $count_max;
		    	$this->view->okato_max = $okato_max;
		    	//echo $count." ".$okato_max."<br>";
    		}
    		else {
    			$count = $okato_companyCount->addWhere("A.okato_id LIKE '".$sub_item['code']."%'")->addWhere("A.firstlevel_id = '$okved'")->getCount();
    			$okato_companyCount->clearWhere();
	    		if($count > $count_max) {
	    			$count_max = $count;
	    			$okato_max = $sub_item['name'];
	    		}
    			$this->view->count_max = $count_max;
		    	$this->view->okato_max = $okato_max;
		    	//echo $count." ".$okato_max."<br>";
    		}
    	}
    }
   }

}


          $time_end = microtime_float();
          $time = $time_end - $time_start;
          $TimeInBase = new AK_Timer_Item();
          $TimeInBase->setTime((float)$time)
                 ->setWhat($str)
                 ->setController("Фильтры")
                 ->setOkved(null)
                 ->setOkato(null);

          $TimeInBase->save();

       
$this->view->okvedM=empty($goalokved)?'':$goalokved;
$this->view->okved=$okved;
$this->view->okatoM=$goalokato;
$this->view->okato=$okato;
$this->view->okvedtop=$top;
$this->view->show = $show;
$this->view->show2 = $show2;
if ($okato!='')
{
$cur_okato = new AK_okato_Item($okato);
$this->view->TITLE = $cur_okato->getName();
}
if ($okved!='' && $okato!='')
{
$cur_okved = new AK_okved_Menu($okved);
$this->view->TITLE .= " - ".$cur_okved->getName();
}
if ($okved!='' && $okato=='')
{
$cur_okved = new AK_okved_Menu($okved);
$this->view->TITLE = " ".$cur_okved->getName();

}
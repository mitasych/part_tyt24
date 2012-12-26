<?php
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
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
      $this->view->left = true;
      $this->view->left_counter = true;

    if (isset($this->params['_wf__searchForm']))
    {
     
     $this->_redirect("/list/index/what/$what/where/$where/okved/$okved/okato/$okato/page/$page/");
    }
      $this->view->okato = $okato;
      $this->view->okved = $okved;
      $this->view->what = $what;
      $this->view->where = $where;
      $this->view->page = $page;

    $ok = new AK_company_ListShort();
    
/* END INITIALIZE */


    /* WHERE */
    if ($where!='')
    {
    $WhereOkato = new AK_okato_List();

   // $WhereOkato = $WhereOkato->addWhere('')
    $test = new AK_okato_Item();


          $test->loadBySql("SELECT  CHAR_LENGTH(`name`) as s ,`id`, `name`
FROM `class_okato`
WHERE
`name` LIKE '%$where%'
 GROUP BY `s` LIMIT 1");
 
    $okato = $test->getId();

    }
	$str = '';

      /*END  WHERE */
      $time_start = microtime_float();
                        /* выбор варианта запроса в зависимости от поступивших фильтров */
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
$this->view->where = $okatoItem->getName();
           $okatocode = $okatoItem->getCode();
           $okato_id = $okatoItem->getId();

           if($okatocode=='')
             {
                $okato_list = new AK_okato_List();
                $okato_list = $okato_list->addWhere("A.parent_id = $okato_id")->getList();
                foreach($okato_list as $item)
                {

                    $itemcode = $item->getCode();

                    $okatostr .= "A.okato_id LIKE '$itemcode%' OR ";
                }
                $okatostr[strlen($okatostr)-3]=')'; //вырезаем последний OR
                $okatostr[strlen($okatostr)-2]=' ';
                $okatostr = "(".$okatostr;   // добавляем скобки
                $str = $okatostr;// END OKATO
             }
           else
             $okatostr = "A.okato_id LIKE '$okatocode%'";
             $str = $okatostr;// END OKATO
           }
           
      /* OKVED */

      
     if ($okved >0 && $okved <= 8)
        {
          $strokved = "A.zerolevel_id = '$okved'";
          if ($str=='') $str = "A.zerolevel_id = '$okved'";
          else          $str .= " AND A.zerolevel_id = '$okved'";
    
        }
     if ($okved > 8 && $okved <= 54)
        {
          $strokved = "A.firstlevel_id = '$okved'";
          if ($str=='') $str  = "A.firstlevel_id = '$okved'";
          else          $str .= " AND A.firstlevel_id = '$okved'";
        }
     if ($okved > 54)
      {
          $strokved = "A.secondlevel_id = '$okved'";
          if ($str=='') $str  = "A.secondlevel_id = '$okved'";
          else          $str .= " AND A.secondlevel_id = '$okved'";
      }

       /* END OKVED */

      /* WHAT */
      if ($what!='')
       {

         $strwhat =            "CCNT.name = '$what'";
         if ($str=='') $str  = "CCNT.name = '$what'";
         else          $str .= " AND CCNT.name = '$what'";
         
       }
       /* END WHAT */
      
  

       /* ЗАПРОС */
       if ($str=='')
       {
             $ok_count = $ok->getCount();
             $ok = $ok->setCurrentPage($page)->setListSize(15)->SetOrder('A.id ASC')->getList();

       }
       else
       {
           try
           {
           
           $ok_count = $ok->addWhere($str)->getCount();
           
           $ok = new AK_company_ListShort();
           
           $ok = $ok->addWhere($str)->setCurrentPage($page)->setListSize(15)->SetOrder('A.id ASC')->getList();
           
           }
          catch (Zend_Db_Exception $error) {
                //die($error);
                 die("<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><p style='font-size:11px;'>Извините, сайт находится на техническом обслуживании.");
                }
       }

                  

        
      $count = $ok_count;
      $model = new Tyt24_Models_Search();
      $count = count($model->search('предприятие', $okato, '', '11', $secondlevel_id));


      $time_end = microtime_float();
      $time = $time_end - $time_start;
      $this->view->time = $time; /* время выполнения запроса в бд */

      $TimeInBase = new AK_Timer_Item();
      $TimeInBase->setTime((float)$time)
                 ->setWhat($str)
                 ->setController("LIST");
                // ->setOkved() //хз зачем это тут. но с пустым аргументом оно не работает
                // ->setOkato(); //то же самое что выше

       $TimeInBase->save();
 

     include_once(APP_DIR.'/default/controllers/list/counter.php');
  if ($okato!='')
  {
  $cur_okato = new AK_okato_Item($okato);

  $this->view->current_okato = $cur_okato->getName();
  $this->view->okato = $okato;
  }
foreach ($ok as $hit)
{
  
  $company = new AK_company_Item($hit->getId());
  $INN_ARR[] = array("id" => $hit->getId(), "name" => $hit->getName() ,  "adress" => $company->getAdress(), "phone" => $company->getPhone(), "inn" => $company->getInn());
  
}

$this->view->hits = $INN_ARR;
$this->view->count = $count;
$pages = ceil($count / 15);

$this->view->pages = $pages;
$this->view->start = $page-5;
if ($page<6) $this->view->start = 1;


$zakItems =  AK_Order_ZakazTypes::getPriceListCC();
$this->view->zakItems = $zakItems;
$pricesOutput = array();
foreach ($zakItems as $key=>$value) {
    $_price = new AK_Order_Prices($key);
    $pricesOutput[$key] = $_price->getPricesOutput();
}
$this->view->pricesOutput = $pricesOutput;

if ($okato!='')
{
$cur_okato = new AK_okato_Item($okato);
$this->view->TITLE = "Предприятия - ".$cur_okato->getName();
}
if ($okved!='' && $okato!='')
{
$cur_okved = new AK_okved_Menu($okved);
$this->view->TITLE .= " - ".$cur_okved->getName();
}
if ($okved!='' && $okato=='')
{
$cur_okved = new AK_okved_Menu($okved);
$this->view->TITLE = "Предприятия - ".$cur_okved->getName();

}



/* Получение цен по отчетам */
$db_2 = Zend_Registry::get('DBORDER');

$query2 = $db_2->select();
$query2->from('order_report', array('price','text_mini'))
	   ->order('id');


$price_reports2 = $db_2->fetchAll($query2);

$this->view->price_reports = $price_reports2;


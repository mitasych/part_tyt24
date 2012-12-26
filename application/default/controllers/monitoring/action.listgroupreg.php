<?php
   
// Настройка
 $db1 = Zend_Registry::get("DBORDER");
      if (isset($_POST['save_setting'])){
          
          $data= $_POST;
          unset($data["save_setting"]);
         
          $data['id_user'] = $_SESSION['user_id'];
          unset($data['inform']);

          $queryC = $db1->select();
        $queryC->from('order_setting_list');
        $queryC->where('id_user = ?',$_SESSION['user_id']);
        $totalRows = $db1->fetchRow($queryC);

          if(empty($totalRows)){
          $count =  $db1->insert("order_setting_list",$data);
          } else {

            $where = $db1->quote('id_user = ?',$_SESSION['user_id']);
             $count = $db1->delete('order_setting_list',$where);
             $count =   $db1->insert("order_setting_list",$data);
          }

  }


$queryC = $db1->select();
        $queryC->from('order_setting_list');
        $queryC->where('id_user = ?',$_SESSION['user_id']);
        $totalRows = $db1->fetchRow($queryC);

        $this->view->datas = $totalRows;

  
$type = new AK_Order_Monitoring_Tarif_ListType();
$this->view->type = $type->getList();

if (!empty($this->params['delall']))
{
	//print 'fff';
//	print_r($this->params['delItem']);
	foreach ($this->params['delItem'] as $item)
	{
		 //print $item.'<br>';
		 $delK = new AK_Order_User_Kontragent($item);
		// print $delK->title.'<br>';
		 $delK->delete();
	}
}





if (!empty($this->params['did'])) {
    $uk = new AK_Order_User_Kontragent($this->params['did']);
    if (!empty($uk->id) && $uk->userId == $this->_user->id) {
        $uk->delete();
        $this->_redirect('/monitoring/list/');
    }
}



//Zend_Debug::3446033418

$countryList = new AK_Location_Country_List();
$countryList->returnAsAssoc()->setAssocKey('A.code')->setAssocValue('CONCAT(A.name," - ", A.code)')->addWhere('A.monitoring_list = 1');
$this->view->countryList = $countryList->getList();



//$periodList = AK_Order_Enum::getPeriodList();
//$this->view->periodList = $periodList;
$periodList = new AK_Order_Monitoring_Tarif_Period_List;
$periodList->returnAsAssoc(true)->addWhere('A.is_active = 1');
$this->view->periodList = $periodList->getList();

// Берем текущий тариф 

$allUserTarifs  = new AK_Order_User_Tarif_List();
$this->view->userTarifs = $allUserTarifs->getAllTarifs($this->_user->id);




if (!isset($_SESSION['current_mon_tarif']))
   $_SESSION['current_mon_tarif'] = $this->view->userTarifs[0]->tarifId;

if (isset( $_POST['all_tarifs']))
{
  $checked = $_POST['all_tarifs'];
  $_SESSION['current_mon_tarif'] = $checked;
  $this->view->current_mon_tarif = $_SESSION['current_mon_tarif'];
	  
}
else  	
 $this->view->current_mon_tarif = $_SESSION['current_mon_tarif'];
 
 
 
if (isset($_POST['all_tarifs'])) {
   if ($_POST['all_tarifs']=="1") {
	 $this->view->showAll = 1;
	 $this->view->current_mon_tarif = "1";
   }
   else 
	 $this->view->showAll = 0;		   
}


$this->view->current_user_tarif = $this->_user->getTarifById($_SESSION['current_mon_tarif']);


//Zend_Debug::dump($this->_user->getActualTarifInfo()->tarifId);exit();

//список контрагентов для текущего пользователя 
//Zend_Debug::dump($this->view->current_user_tarif); exit();

$tarif_id = $this->_user->getActualTarifInfo()->tarifId;	

$kontragentsList = new AK_Order_User_Kontragent_List();
$kontragentsList->addWhere('A.tarif_id = ?', $tarif_id);

$this->view->regions = $kontragentsList->getListRegion();
//print_r($this->view->regions);
if (!empty($this->params['filter_serch']))
{
	//print($this->params['filter_inn']);
	if (!empty($this->params['filter_inn']))
	{
		$kontragentsList->addWhere('B.inn = \''.$this->params['filter_inn'].'\'');
	}
	if (!empty($this->params['filter_name']))
	{
		$kontragentsList->addWhere('B.title LIKE \'%'.$this->params['filter_name'].'%\'');
	}
	if (!empty($this->params['filter_region']))
	{
		$kontragentsList->addWhere('B.region LIKE \''.$this->params['filter_region'].'\'');
	}
}
if (!empty($this->params['filter_serch2']))
{
	$this->params['filter_inn'] = '';
	$this->params['filter_name'] = '';
	$this->params['filter_name'] = '0';
}

$this->view->filter_inn = empty($this->params['filter_inn'])?'':$this->params['filter_inn'];
$this->view->filter_name = empty($this->params['filter_name'])?'':$this->params['filter_name'];
$this->view->filter_region = empty($this->params['filter_region'])?'':$this->params['filter_region'];

//$regions = $DB->select();

$this->view->kontragentsList = $kontragentsList->getList();
$this->view->kc = $kontragentsList->getCount();
$this->view->ka = $this->_user->getTarifInfo()->getTarif()->num;


$ttList = new AK_Order_Monitoring_Event_Type_List();
$this->view->ttList = $ttList->getList();

$form = new AK_Form('innForm', 'post', SITE_URL.'/monitoring/list/');




if(empty($_POST["csv"]) && !empty($_POST["title_one"])) {

$orderKontragent = new AK_Order_Kontragent("inn",$_POST['inn_one']);
if (empty($orderKontragent->title)){
 $orderKontragent->title= $_POST['title_one'];
 $orderKontragent->inn =  $_POST['inn_one'];

 $orderKontragent->save();
}
 $orderUserKontragent = new AK_Order_User_Kontragent($_POST['userid']);
 $orderUserKontragent->userId = $_POST['userid'];
 $orderUserKontragent->kontragentId = $orderKontragent->id;
 //var_dump ((int)()
    $tmp = $_POST['tarif_id_one'];
   $vuk =new AK_Order_User_Tarif();
   $tarifId = $vuk->getTarifId($_POST['tarif_id_one']);

 $orderUserKontragent->tarif_id = $tmp;
 $data = array();
 $data['user_id'] =  $_POST['userid'];
  $data['kontragent_id'] = $orderKontragent->id;
 $data['tarif_id'] =    $tarifId;
 $data['title'] =  $_POST['title_one'];

 $db = Zend_Registry::get("DBORDER");
 $result =    $db->insert('orders_users__kontragents',$data);

//print_r($orderUserKontragent);

} 
else
if (!empty($_FILES["csv"]["tmp_name"]) && is_uploaded_file($_FILES["csv"]["tmp_name"])) {


    $row = 1;
    if (($handle = fopen($_FILES["csv"]["tmp_name"], "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      //      var_dump($data[0]);
             $data = explode(";",$data[0]);
        //       var_dump($data);
            $num = count($data);
           //  echo "<p> $num fields in line $row: <br /></p>\n";
           //  print_r($data);
            
            
            $row++;

            if ($num >=1 ) {

                $_inn = $data[0];
                $_title = $data[1];
                $_country = $data[2];


                       $vuk =new AK_Order_User_Tarif();
                       $tempTarif = $vuk->getTarifFromId($_POST['tarif_id_one']);
                   


                if (!empty($_inn)  && $kontragentsList->getCount()<$tempTarif['count']) {

                    $kontragent = new AK_Order_Kontragent('inn', $_inn);
                      
                      
                    if (empty($kontragent->id)) {
                        $kontragent->inn = $_inn;
                        $kontragent->title = '';
                        $kontragent->region = getRegionByInn($_inn);
                        $kontragent->country = '';
                       
                       
                        $kontragent->save();
                                        }


                    $kRelation = new AK_Order_User_Kontragent();

                  //  $kRelation = $kRelation->createRow();

                    $kRelation->userId = $this->_user->id;

                    $kRelation->kontragentId = $kontragent->id;
                    $kRelation->title = $_title;

                    $kRelation->region = getRegionByInn($_inn);
                    $kRelation->country = $_country;
                       $vuk =new AK_Order_User_Tarif();
                       $tarifId = $vuk->getTarifId($_POST['tarif_id_one']);
                       $data = array();
                       $data['user_id'] =   $this->_user->id;
                       $data['kontragent_id'] = $kontragent->id;
                       $data['tarif_id'] =    $tarifId;
                       $data['title'] =  $kRelation->title;
                       $db = Zend_Registry::get("DBORDER");

                       $result =    $db->insert('orders_users__kontragents',$data);
     

                  ///  $kRelation->save();
          }
                  
                }
        //    }
           for ($c=0; $c < $num; $c++) {
               echo $data[$c] . "<br />\n";
           }
        }
        fclose($handle);

    }
    else {
        $form->addRule('csvcerr', 'required', 'Не возможно обработать файл');
    }

    $this->_redirect('/monitoring/list/');

}

 


if (isset($_POST['hid_id'])){

  $db = Zend_Registry::get("DBORDER");
  if ($_POST['copy']==true){
    $uk = new AK_Order_User_Kontragent();
  } else
   {$uk = new AK_Order_User_Kontragent($_POST['hid_id']); }
 


   $id_k = $uk->getKontragent()->id;
   $vuk =new AK_Order_User_Tarif();
   $tarifId = $vuk->getTarifId($_POST['k_id']);
   $auk = new AK_Order_Kontragent('id',$id_k);
        if (!$form->isPostback()) {
           $auk->inn =  $_POST['inn'];
           $auk->region = $_POST['region'] ;
           $auk->title= $_POST['title'] ;
           $uk->tarif_id = $tarifId;
           
       //    $auk->save();
           $data['user_id'] = $this->currentUser->id;
           $data['kontragent_id'] =$id_k;
           $data['tarif_id'] =    $tarifId;
           $data['title'] =  $_POST['title'];

            if ($_POST['copy']==true){
                // print_r($data);
                // exit();
                   $stmt = $db->query(
                  "INSERT INTO `tnved_testorder`.`orders_users__kontragents` (`user_id`, `kontragent_id`, `tarif_id`, `id`, `region`, `title`, `country`)
                   VALUES ('?', '?', '?', NULL, NULL, NULL, NULL);",
                  array($data['user_id'], $data['kontragent_id'],$data['tarif_id'],$data['title'])
                  );

            }
            else{


                $result = $db->update('orders_users__kontragents',$data,$db->quoteInto('id=?',$_POST['hid_id']));
         }


        }
}



$form->addRule('inn', 'required', 'Введите ИНН');

if (!empty($this->params['inn'])) {


    // проверка на пустоту и регион 
     if(!empty($this->params['country']) && $this->params['country']=='RU' ) {

        $form->addRule('inn2',  'callback',  'Введите правильный ИНН', array('func' => 'isINNNotValid','params' =>$this->params['inn']));
     }
    
    // проверка существуте лист данный контрагент в данном тарифе
     if ( !isset($uk) || !$uk->id || $uk->getKontragent()->inn != $this->params['inn']) {
         $form->addRule('inn3',  'callback',  'Контрагент с таким ИНН уже есть в списке мониторинга', array('func' => 'isINNExists','params' =>array($this->params['inn'],$this->_user->id)));
     }

    // чекаем макс кол-во компаний  
    if ($kontragentsList->getCount()>$this->_user->getActualTarifInfo()->count) {
           $form->addRule('inn4',  'required',  'Вы не можете добавить еще одного контрагента. Достигнуто максимальное количество компаний.');
     }
    // }
}
 // $uk->save();
//print file_get_contents('http://www.valaam-info.ru/fns/');die;
if(!empty($_POST['ok'])) {//print 'name=&address=&region=%C2%F1%E5+%F0%E5%E3%E8%EE%ED%FB&date=&num='.trim($_POST['c']).'&action=%C8%F1%EA%E0%F2%FC';die;
    $_POST['n'] = $this->params['title'];
    $_POST['c'] = $this->params['inn'];// = '7707291942';//%C2%F1%E5+%F0%E5%E3%E8%EE%ED%FB  %C8%F1%EA%E0%F2%FC
    $p = AK_Common_Functions::get_page('http://www.valaam-info.ru/fns/g.php', 'name='.trim($_POST['n']).'&address=&region=%C2%F1%E5+%F0%E5%E3%E8%EE%ED%FB&date=&num='.trim($_POST['c']).'&action=%C8%F1%EA%E0%F2%FC');
    $p = iconv('cp1251', 'utf-8', $p);
    //$p = get_page('http://egrul.nalog.ru/fns/g.php', 'name=&address=&region=%C2%F1%E5+%F0%E5%E3%E8%EE%ED%FB&date=&num='.trim($_POST['c']).'&action=%C8%F1%EA%E0%F2%FC');

   // preg_match('/<table border=1 cellpadding=3 cellspacing=1 bordercolor=".fff" bgcolor=.ffffff>.+<\/table>/isU', $p, $t);
    //
    preg_match('/<table border=\"1\" cellpadding=\"3\" cellspacing=\"1\" bgcolor=\".e0e0e0\">.+<\/table>/isU', $p, $t);
//$this->view->cres = $p;
    if (!empty($t[0])) {
        $t[0] = preg_replace('/table border=1 cellpadding=3 cellspacing=1/iU', 'table style="border:1px solid black; width:80%; "', $t[0]);
        $t[0] = preg_replace('/\<td/iU', '<td style="border:1px solid black; margin: 3px;"', $t[0]);
        $t[0] = preg_replace('/\<th/iU', '<th style="border:1px solid black; margin: 3px;"', $t[0]);
        $t[0] = preg_replace('/<a.*>/iU', '', $t[0]);
        $t[0] = preg_replace('/Новый поиск/iU', '', $t[0]);
        $t[0] = preg_replace('/Назад/iU', '', $t[0]);
        $t[0] = str_replace("</a>", "", $t[0]);
        $this->view->cres =  $t[0];
    }
}


$form4 = new AK_Form('addcompany', 'post', SITE_URL.'/monitoring/list/');



// добавление нового контрагента 
if (empty($_POST['ok']) && $form->validate($this->params)) {

    $kontragent = new AK_Order_Kontragent('inn', $this->params['inn']);
    if (empty($kontragent->id)) {
		$company = new AK_company_Item($this->params['inn'], 'inn');
		if (empty($company->id))
		{
			
			$kontragent->title = '';
		}
		else
		{
			$kontragent->title = $company->single_name;
			$kontragent->otrasl = $company->okved_id;
			$kontragent->adress = $company->adress;
			$kontragent->rykov = $company->rykov;
			$kontragent->reg_date = $company->reg_date;
		}
		
		$kontragent->inn = $this->params['inn'];
		$kontragent->region = getRegionByInn($this->params['inn']);
		//$kontragent->country = '';
		$kontragent->tarif_id = $this->_user->getActualTarifInfo()->tarifId;		
		$kontragent->save();
    }
    if (!empty($this->params['mid'])) {
        $kRelation = new AK_Order_User_Kontragent($this->params['mid']);
    }
    else {
        $kRelation = new AK_Order_User_Kontragent();
    }

    $kRelation->userId = $this->_user->id;
    $kRelation->kontragentId = $kontragent->id;
    $kRelation->title = $kontragent->title;
    $kRelation->region = (empty($this->params['region']))?getRegionByInn($this->params['inn']):$this->params['region'];
    $kRelation->country = (empty($this->params['country']))?$kontragent->country:$this->params['country'];
	$kRelation->tarif_id = $this->_user->getActualTarifInfo()->tarifId;	
    $kRelation->save();

    $this->_redirect('/monitoring/list/');
}
else {
    $form->setDefaults($this->params);
    $this->view->form = $form;
}
$this->view->fparams = $this->params;


    

//==============================================================================
//$periodList = AK_Order_Enum::getPeriodList();
//$this->view->periodList = $periodList;
//$periodList = new AK_Order_Monitoring_Tarif_Period_List;
//$periodList->returnAsAssoc(true)->addWhere('A.is_active = 1');
//$this->view->periodList = $periodList->getList();
//
//
//
//$form2 = new AK_Form('settForm', 'post', SITE_URL.'/monitoring/list/');
//
//$form2->addRule('period', 'required', 'Выберите периодичность рассылки');
//if ($form2->isPostBack()) {
//    if (empty($this->params['period']) || !key_exists($this->params['period'],$this->view->periodList)) {
//        $form2->addRule('period1', 'required',  'Выберите периодичность рассылки');
//    } elseif ((int)$this->params['period'] > $this->_user->getTarifInfo()->period ) {
//        $form2->addRule('period1', 'required',  'Нельзя увеличить период, возможно только уменьшение');
//    }
//}
//
//if ($form2->validate($this->params)) {
//
//    $this->_user->getTarifInfo()->period = $this->params['period'];
//    $this->_user->getTarifInfo()->save();
//
//    $this->_redirect('/monitoring/list/');
//}
//else {
//    $form2->setDefaults($this->params);
//    $this->view->form2 = $form2;
//}
//==============================================================================




$currentInfo = new AK_Article_Item();
$currentInfo->loadByRewriteName('monitoringlist');
$this->view->currentInfo = $currentInfo;

$this->view->TITLE = 'Контрагенты';

if ($currentInfo->getMetaTitle()) {
    $this->view->TITLE = $currentInfo->getMetaTitle();
}
elseif ($currentInfo->getTitle()) $this->view->TITLE = $currentInfo->getTitle();
if ($currentInfo->getMetaKeywords()) {
    $this->view->KEYWORDS = $currentInfo->getMetaKeywords();
}
if ($currentInfo->getMetaDescription()) {
    $this->view->DESCRIPTION = $currentInfo->getMetaDescription();
}



function isINNNotValid($Values) {
    if (AK_Order_Validate::CheckINN($Values)) {
        return false;
    }
    return true;
}


function isINNExists($Values) {

    $inn = $Values[0];
    $user_id = $Values[1];

 

    $db = Zend_Registry::get('DBORDER');
    $select = $db->select();
    $select->from('orders_users__kontragents AS A', 'A.kontragent_id')
        ->joinLeft('orders_kontragents AS B', 'B.id = A.kontragent_id', null)
		->joinLeft('orders_users__monitoring_tarifs AS C','A.user_id=C.user_id', null)
		->where(" A.user_id='".$user_id."' AND B.inn='".$inn."'");


    $res = $db->fetchCol($select);
    $res = (boolean) $res;
	
    if (!$res) {
        return false;
    }
	
	//Zend_Debug::dump($res);exit();
	
    return true;
}


function getRegionByInn($inn) {

    $db = Zend_Registry::get('DBORDER');
    $select = $db->select();
    $select->from('orders_region__inn AS A', 'A.title')
        ->where('A.code = ?', substr($inn,0,2));
    $res = $db->fetchOne($select);

    if (!empty($res)) {
        return $res;
    }
    return '';
}




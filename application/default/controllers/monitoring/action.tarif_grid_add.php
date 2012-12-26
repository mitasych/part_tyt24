<?php
/** Released Action**/


$type = new AK_Order_Monitoring_Tarif_ListType();
$this->view->type = $type->getList();

$typeEvent = new AK_Order_Monitoring_Event_Type_List();
$this->view->typeEvent = $typeEvent->getList();

$settings = new AK_Order_Settings();
$this->view->settings = $settings;

$tarif = new AK_Order_Monitoring_Tarif_ListAll();
$this->view->tarif = $tarif->getList();
// если создается новый тариф на базе старых
// суем старые в сессию
// затем создаем новый и удаляем прежние 
// рассчитываем остаток с предыдущих тарифов 

if (isset($_POST['tarif_checked'])) {
 $_SESSION['tarif_checked']=$_POST['tarif_checked']; 
}

if (isset($_SESSION['tarif_checked'])) {
  $delete_ids  = $_SESSION['tarif_checked'];
  $all = count($delete_ids);
  
  $this->view->total_residue=0;
  
  
  $this->view->show_delete_tarifs=1;
  
  for ($i=0;$i<$all;$i++) {
    $delete_tarifs[$i] = $this->currentUser->getTarifById($delete_ids[$i]);
    $residue = $this->currentUser->getActualTarifInfo()->getResidue();
	$delete_tarifs[$i]->residue = $residue;
    $this->view->total_residue += $residue;	
  }
  //Zend_Debug::dump($this->view->total_residue);exit();
  $this->view->delete_tarifs = $delete_tarifs;
  
  // остаток 
  $this->view->total_between = $this->view->total_residue;
  
  // общий баланс с остатком 
  $this->view->balans_residue = $this->view->total_residue+$this->currentUser->balans;
   
}




$tarifsList = new AK_Order_Monitoring_Tarif_List();
$tarifsList->addWhere('A.is_active = 1');
$this->view->tarifsList = $tarifsList->getList();


$this->view->tarifsThis = $this->params['tarifsThis'];
$this->view->tarifslllItem = new AK_Order_Monitoring_TarifAll($this->params['tarifsThis']);
//print_r($this->view->tarifslllItem);

$cur_per = 28;
$main=$this->view->tarifsList[0];
$this->view->itemMain = $main->pM;
$this->view->totalCount = $this->currentUser->getCountMon();
$minimal = $tarifsList->getMinimal();
$this->view->min_for_mon = $minimal;

//Zend_Debug::dump($minimal);exit();

// добавлен ли тариф в корзину 
if (isset($_SESSION['tarif_added']) && (isset($_SESSION['show_first_time'])) && (isset($_SESSION['showed']))  ) {

	$this->view->countTarif = count($this->view->tarifsList);
	$this->view->showRadios=true;
	$this->view->current = 0;

    //Zend_Debug::dump($_SESSION);exit();

	// $_SESSION['tarif_added'] = 1;
	// $_SESSION['monitoring_count'] = $mon_count;	
	// $_SESSION['monitoring_period'] = $item->period;
	// $_SESSION['monitoring_m'] = $item->m;	
	// $_SESSION['monitoring_price'] = $price;
	// $_SESSION['monitoring_discount'] = $discount; 

	if (isset($_SESSION['showed'])) {
		$this->view->refresh_period=$_SESSION['monitoring_period'];
		$this->view->monitoring_count = $_SESSION['monitoring_count'];
		$this->view->checked_period = $_SESSION['monitoring_m'];
		$this->view->minimal = $_SESSION['monitoring_count'];
		$this->view->show_new_tarif = 1;
		$this->view->totalCount = $_SESSION['monitoring_count'];
		$this->view->new_tarif_count = $_SESSION['monitoring_count'];
		$this->view->new_tarif_period = $_SESSION['new_tarif_period'];
		unset($_SESSION['showed']);
    }
    else {
	
	//Zend_Debug::dump($_POST);exit();
	$new_per = $_SESSION['new_tarif_period'];
	// если показали один раз    
	$this->view->new_tarif_period=$this->params['newTarifPeriod'];

    $this->view->refresh_period=$this->params['period'];
	 
	 if ($this->view->refresh_period==$cur_per) 
	  $this->view->show_cur_tarif=1;
     else $this->view->show_cur_tarif=0;

	 if ($this->view->refresh_period==$new_per) 
	  $this->view->show_new_tarif=1;
     else $this->view->show_new_tarif=0;
	 

	$this->view->minimal=$this->params['monitoring_count'];  
	$this->view->checked_period=$this->params['m'];  


    }	
}

else{
	$this->view->countTarif = count($this->view->tarifsList);
	$this->view->showRadios=true;
	$this->view->current = 0;
	
	if (!isset($this->params['monitoring_count'])) 	
     $this->view->minimal = $minimal;
	else 
	 $this->view->minimal = $this->params['monitoring_count'];

	
	$this->view->show_new_tarif = 0;	
	// check period
	if (!isset($this->params['period'])) {
	 $this->view->refresh_period=$cur_per;
	 
	 if ($this->view->refresh_period==$cur_per) 
	  $this->view->show_cur_tarif=1;
     else $this->view->show_cur_tarif=0;
	  
	}
	else {	
	 $this->view->refresh_period=$this->params['period'];
	 
	 if ($this->view->refresh_period==$cur_per) 
	  $this->view->show_cur_tarif=1;
     else $this->view->show_cur_tarif=0;
	}
	
	if (!isset($this->params['monitoring_count'])) 
	    $this->view->monitoring_count = $minimal;
	else {
	    $this->view->monitoring_count=$this->params['monitoring_count'];        		
	}


	if (!isset($this->params['m'])) {
	 $m = "1";
	 $id = "1";
	 $this->view->checked_period=$id."-".$m;
	 //Zend_Debug::dump($this->view->checked_period);exit();
	}	 
	else {  
	 $this->view->checked_period=$this->params['m'];  
	}
	
	
	//Zend_Debug::dump($this);exit();
	$this->view->new_tarif_period = 0;

	// delete prev tarif info
	unset($_SESSION['tarif_added']);
	unset($_SESSION['monitoring_count']);	
	unset($_SESSION['monitoring_period']);
	unset($_SESSION['monitoring_m']);	
	unset($_SESSION['monitoring_price']);
	unset($_SESSION['monitoring_discount']);
	unset($_SESSION['tarif_added']);
    unset($_SESSION['new_tarif_period']);
	if (isset($_SESSION['show_first_time'])) unset($_SESSION['show_first_time']);
}

// if (isset($_SESSION['refresh_period']))
 // if (isset($this->params['refresh_period']))
  // $this->view->refresh_period=$this->params['refresh_period'];
// else  
 // $this->view->refresh_period=7;

// if (isset($_SESSION['monitoring_count']))
 // if (isset($this->params['monitoring_count']))
 // $this->view->monitoring_count=$this->params['monitoring_count'];
// else  
 // $this->view->monitoring_count=10;
 
// if (isset($_SESSION['checked_period']))
 // if (isset($this->params['m'])) 
  // $this->view->checked_period=$this->params['m'];
 // else  
  // $this->view->checked_period='first'; 
 
//Zend_Debug::dump($this->view->minimal);exit();


// Изменить тариф
if(!empty($this->params['change'])) {

    $this->view->change = 1;
    if (!$this->currentUser->getActualTarifInfo()) {
        $this->_redirect('/monitoring/addtarif/');
    }
    $dneiIspolz = ceil((time()-$this->currentUser->getActualTarifInfo()->startDate)/(60*60*24));
    $ptSkidka = $this->currentUser->getActualTarifInfo()->m*30 - (int) $dneiIspolz;//print (1284152700+(60*60*24*60));die;
    if ($ptSkidka<0) $ptSkidka = 0;//dnei ostalos

    $uSkidka = 0;
    if (Zend_Registry::isRegistered('User')) {
            $user = Zend_Registry::get('User');
            if (!empty($user->id)) {
                $uSkidka = (int)$user->monitoringTarifSkidka;
            }
     }

    if ($ptSkidka) {

        $period = $this->currentUser->getActualTarifInfo()->period;
        $per = AK_Order_Monitoring_Tarif_Period_Collection::getPeriodByPeriod($period);
        $pskidka = $per->skidka;

        $tarif = new AK_Order_Monitoring_Tarif($this->currentUser->getActualTarifInfo()->tarifId);
        switch(intval($this->currentUser->getActualTarifInfo()->m)) {
            case 1: $c = intval($tarif->pM-$tarif->pM*$pskidka/100); $ptSkidka = intval($ptSkidka*($c-$c*$uSkidka/100)/30);
                break;
            case 3: $c = intval($tarif->pK-$tarif->pK*$pskidka/100); $ptSkidka = intval($ptSkidka*($c-$c*$uSkidka/100)/90);
                break;
            case 6: $c = intval($tarif->pH-$tarif->pH*$pskidka/100); $ptSkidka = intval($ptSkidka*($c-$c*$uSkidka/100)/180);
                break;
            case 12: $c = intval($tarif->pY-$tarif->pY*$pskidka/100); $ptSkidka = intval($ptSkidka*($c-$c*$uSkidka/100)/360);
                break;
            default: $ptSkidka = 0;
                break;
        }
    }



//$ostatok = $this->currentUser->getActualTarifInfo()->
}

//==============================================================================
$periodList = new AK_Order_Monitoring_Tarif_Period_List;
$periodList->returnAsAssoc(true)->addWhere('A.is_active = 1');
$this->view->periodList = $periodList->getList();

//Zend_Debug::dump($this->view->periodList); exit();



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


$form = new AK_Form('tarifForm', 'post', SITE_URL.'/monitoring/addtarif/');
$form->addRule('period', 'required', 'Выберите периодичность рассылки');
$form->addRule('m', 'required', 'Выберите тариф');

if ($form->isPostBack() && empty($this->params['refresh'])) {

    $res = false;
	
    if (!empty($this->params['m'])) {
        $parts = explode('-',$this->params['m']);
        if (count($parts) == 2) {
            $tarif = new AK_Order_Monitoring_Tarif($parts[0]);
            if ($tarif->id && in_array(intval($parts[1]),array(1,3,6,12)) ) {
                $res = true;
            }
        }
    }
    
	
	
    if (!$res) {
        $form->addRule('m', 'required', 'Выберите тариф.');
   }

    if (empty($this->params['period']) || !key_exists($this->params['period'],$this->view->periodList)) {
        $form2->addRule('period1', 'required',  'Выберите периодичность рассылки');
    }
}
else {
    if(!empty($this->params['change'])  && empty($this->params['refresh'])) {
        if ($this->currentUser->getActualTarifInfo()) {
            $this->params['m'] = $this->currentUser->getActualTarifInfo()->tarifId  .'-'.$this->currentUser->getActualTarifInfo()->m;
        }
    }
}

if (!empty($this->params['refresh']) && !empty($this->params['period']) && key_exists($this->params['period'],$this->view->periodList) ) {

    $per = AK_Order_Monitoring_Tarif_Period_Collection::getPeriodByPeriod($this->params['period']);
	
	if (!isset($_SESSION['tarif_added'])) {
		if (!isset($this->params['period'])) {
		$this->view->refresh_period=7;
		}  
		else {
		$this->view->refresh_period=$this->params['period'];	
		} 

	
		
	} 
    else {
      $this->view->refresh_period = $_SESSION['monitoring_period'];
      $per = AK_Order_Monitoring_Tarif_Period_Collection::getPeriodByPeriod($_SESSION['monitoring_period']);	  
    }	

   

   if (!isset($this->params['period']))
     $per = AK_Order_Monitoring_Tarif_Period_Collection::getPeriodByPeriod(7);
	 
   $this->params['skidka'] = $per->skidka;

   // базовый тариф со скидкой 
   $this->view->itemMain =$this->view->itemMain - $this->view->itemMain*$per->skidka/100;

	 if ($this->view->refresh_period==$cur_per) 
	  $this->view->show_cur_tarif=1;
     else $this->view->show_cur_tarif=0;   
   
   //Zend_Debug::dump($this->view->refresh_period);
   //Zend_Debug::dump($_SESSION);  
   //Zend_Debug::dump($cur_per); exit();
	
} elseif (!empty($this->params['change'])) {
  
	
    
   //Zend_Debug::dump($this->params['refresh']);exit();  
   if (!isset($this->params['period']))
     $per = AK_Order_Monitoring_Tarif_Period_Collection::getPeriodByPeriod(7);

	//$this->params['refresh']=1;
	if (isset($_SESSION['monitoring_period'])) {
	 $per_session = $_SESSION['monitoring_period'];
	 $per = AK_Order_Monitoring_Tarif_Period_Collection::getPeriodByPeriod($per_session); 	 
    }
    
	// check period	
	if (!isset($_SESSION['tarif_added'])) {

	   if (!isset($this->params['period']))
		 $this->view->refresh_period=7;
	   else {
		$this->view->refresh_period=$this->params['period'];
	   }	   
		 if ($this->view->refresh_period==$cur_per) 
		  $this->view->show_cur_tarif=1;
		 else $this->view->show_cur_tarif=0;	   
	} 
	else {
	  $this->view->refresh_period = $_SESSION['monitoring_period'];
	  $per = AK_Order_Monitoring_Tarif_Period_Collection::getPeriodByPeriod($per_session);	  
	}		 
	 
   // базовый тариф со скидкой 	 
	$this->params['skidka'] = $per->skidka;
   

   $this->view->itemMain = $this->view->itemMain - $this->view->itemMain*$per->skidka/100;

	 if ($this->view->refresh_period==$cur_per) 
	  $this->view->show_cur_tarif=1;
     else $this->view->show_cur_tarif=0;   
   
}

//Zend_Debug::dump($_SESSION);exit();

// voodoo

//Zend_Debug::dump($this->params['refresh']);exit();


if ( empty($this->params['refresh'])  && $form->validate($this->params)) {
    	
    $item = new AK_Order_Form_MonitoringTarif();

	

    
    $mon_count = $this->params['monitoring_count'];
    $price = $this->params['mon_price'];
	$discount = $this->params['mon_discount'];
	
	$item->period = $this->params['period'];
    $item->tarifId = $parts[0];
    $item->m = $parts[1]*30;	
	
	$item->mon_count = $mon_count;
	$item->mon_discount = $discount;
	$item->mon_price = $price;
	$item->new_tarif = 1;
    $item->price_one = $this->params['price_one'];
	$item->between = $this->params['residue_minus']; // сколько списать
	$item->paid_between = $this->params['between_residue']; // остаток 
	
	
	//Zend_Debug::dump($this->params);exit();	
	
	// тариф в сессию для повторного  показа юзеру 
	$_SESSION['tarif_added'] = 1;
    $_SESSION['monitoring_count'] = $mon_count;	
    $_SESSION['monitoring_period'] = $item->period;
    $_SESSION['monitoring_m'] = $this->params['m'];	
    $_SESSION['monitoring_price'] = $price;
	$_SESSION['monitoring_discount'] = $discount; 
	$_SESSION['tarif_id'] = $item->tarifId;
	$_SESSION['new_tarif_period'] = $item->m;
	$_SESSION['showed'] = 1;
    $_SESSION['show_first_time'] = 1;
	$_SESSION['action_add_new_tarif'] = 1;
	$_SESSION['between'] = $this->params['between'];


	
    $item->typeId = AK_Order_ZakazTypes::MONITORING_TARIF;

    if (!empty($ptSkidka)) $item->ptSkidka = $ptSkidka;
	
    if ($item->getVarPrice()<=0) $item->ptSkidka = 0;
	
    AK_Order_Basket::add($item);
	
    if(!empty($this->params['change'])) {
        $this->_redirect('/monitoring/addtarif/change/1/');
    }
    else {
        $this->_redirect('/monitoring/addtarif/');
    }

}
else {
    $form->setDefaults($this->params);
    $this->view->form = $form;
}
//==============================================================================

$this->view->fparams = $this->params;

//==============================================================================
$currentInfo = new AK_Article_Item();
$currentInfo->loadByRewriteName('notarif');
$this->view->currentInfo = $currentInfo;

$db = Zend_Registry::get('DBORDER');
$query = $db->select();
$query->from('orders_monitoring__tarif_conect_country AS A');
$query->where('A.id_tarif = ?', $this->view->tarifsThis);
$Countryses = $db->fetchAll($query);
$price_array = array();
foreach ( $Countryses as &$item)
{
	$item2 = new AK_Location_Country($item['id_country']);
	$item['name'] = $item2->name;
	$item['price'] = explode(';',$item['price']);
	foreach($item['price'] as &$pr)
	{
		if(!empty($pr))
		{
			$pr = explode(':',$pr);
			if(empty($price_array[$pr[0]]))
			{
				$price_array[$pr[0]] = array();
				$price_array[$pr[0]]['price'] = array();
			}
			$price_array[$pr[0]]['price'][$item['id_country']] = $pr[1];
		}
		
	}
}

$name_prev = 0;
foreach($price_array as $key=>&$arr)
{
	if ($name_prev > 0)
	{
		$price_array[$name_prev]['name'] = ($name_prev).' - '.($key-1);
	}
	$name_prev = $key;
} 
$price_array[$name_prev]['name'] = ($name_prev).' и более ';

//print_r($price_array);
//print_r($Countryses);
       
$this->view->Countryses = $Countryses;
$this->view->price_array = $price_array;
//print_r($this->view->price_array);

$this->view->TITLE = 'Добавление нового тарифа';

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

$this->view->Basket = new AK_Order_Basket;
$this->view->form = $form;
$this->view->skidka = $this->params['skidka'];
$this->view->tarif_ID = 1;


$this->view->setLayout('monitoring/tarif_grid_add.tpl');

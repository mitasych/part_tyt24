<?php
/** Released Action**/

//Zend_Debug::dump($_SESSION);exit();

// чекаем тарифы с Мониторинг - Главная 

if(isset($_POST['tarif_checked'])) {
 $tarif_ids = $_POST['tarif_checked'];
 $this->currentUser->getTarifById($tarif_ids[0]);
 $this->view->id_tarif_check = $this->currentUser->getActualTarifInfo()->tarifId;
 $_SESSION['current_mon_tarif'] = $this->view->id_tarif_check;
}

//Zend_Debug::dump($_SESSION);exit();


//Zend_Debug::dump($_POST);exit(); 


//Zend_Debug::dump($this->currentUser);exit();

$tarifsList = new AK_Order_Monitoring_Tarif_List();
$tarifsList->addWhere('A.is_active = 1');
$this->view->tarifsList = $tarifsList->getList();

// загружаем тек.тариф 
$cur_per = $this->currentUser->getActualTarifInfo()->period;

if (isset($_SESSION['current_mon_tarif'])) {
 $cur_per =$this->currentUser->getActualTarifInfo()->period;
}

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
		$this->view->id_tarif_check  = $this->currentUser->getTarifById($_SESSION['current_mon_tarif'])->tarifId;  
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

    if (isset($_SESSION['current_mon_tarif'])) {
	 $this->currentUser->getTarifById($_SESSION['current_mon_tarif']);	 
	 $this->view->id_tarif_check = $this->currentUser->getActualTarifInfo()->tarifId;
	 $_SESSION['current_mon_tarif'] = $this->view->id_tarif_check;
	 $cur_per = $this->currentUser->getActualTarifInfo()->period; 	 
	}
	
	$this->view->countTarif = count($this->view->tarifsList);
	$this->view->showRadios=true;
	$this->view->current = 0;
	$this->view->minimal = $this->currentUser->getCountMon();

	
	// показывать ли новый тариф 
	$this->view->show_new_tarif = 0;
	
	// проверяем текущую периодичность
	
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
	
	
   // Zend_Debug::dump($this->currentUser->getActualTarifInfo()->period);exit();   
	
	
	
	// кол-во компаний 
	if (!isset($this->params['monitoring_count'])) 
	    $this->view->monitoring_count = $minimal;
	else {
	    $this->view->minimal = $this->params['monitoring_count'];        		
	}


	if (!isset($this->params['m'])) {
	 $m = $this->currentUser->getActualTarifInfo()->m;
	 $id = $this->currentUser->getActualTarifInfo()->tarifId;
	 $this->view->checked_period="first";
	 if (isset($_POST['tarif_checked'])) {
	  $m = $this->currentUser->getActualTarifInfo()->m;
	  $id = $this->currentUser->getActualTarifInfo()->tarifId;
	  $this->view->checked_period=$id."-".$m;
	  
	  // чекаем периодичность 
	  
	  $temp_per = $this->currentUser->getActualTarifInfo()->period;
	  $cur_m = (int)$temp_per;
	  if ($cur_m != 7) 
	  $this->params['refresh']=1;

	   

	 }
	 //Zend_Debug::dump($this->view->checked_period);exit();
	}	 
	else {  
	 $this->view->checked_period=$this->params['m'];  
	}
	
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

// если периодичность изменяемого тарифа из Главная - Мониторинг не равна неделе 
// делаем скидку 
if (!empty($this->params['refresh']) && (isset($_POST['tarif_checked']))) {
	  $change_period = $this->currentUser->getActualTarifInfo()->period;
	  
	  $per = AK_Order_Monitoring_Tarif_Period_Collection::getPeriodByPeriod($change_period);
	  $this->params['skidka'] = $per->skidka;
	  $this->params['change'] = 1;
	  
  
}

// Изменить тариф
if(!empty($this->params['change'])) {



    $this->view->change = 1;
    if (!$this->currentUser->getActualTarifInfo()) {
        $this->_redirect('/monitoring/notarif/');
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

	    //Zend_Debug::dump($per->skidka);exit();		


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
    $residue = $c;
    $this->view->$residue;

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


$form = new AK_Form('tarifForm', 'post', SITE_URL.'/monitoring/notarif/');
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

	
   // проверка на скидку из Главное-Мониторинг	
    if (isset($_POST['tarif_checked'])){
	  $temp_per = $this->currentUser->getActualTarifInfo()->period;
	  $per = AK_Order_Monitoring_Tarif_Period_Collection::getPeriodByPeriod($temp_per);
      $this->params['skidka'] = $per->skidka;
	  $this->view->refresh_period = $temp_per;
      //Zend_Debug::dump($per->skidka);exit();	  
	}

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
    $item->m = $parts[1];	
	
	$item->mon_count = $mon_count;
	$item->mon_discount = $discount;
	$item->mon_price = $price;

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
	
	//Zend_Debug::dump($_SESSION);exit();


	
    $item->typeId = AK_Order_ZakazTypes::MONITORING_TARIF;

    if (!empty($ptSkidka)) $item->ptSkidka = $ptSkidka;
	
    if ($item->getVarPrice()<=0) $item->ptSkidka = 0;
	
    AK_Order_Basket::add($item);
	
    if(!empty($this->params['change'])) {
        $this->_redirect('/monitoring/notarif/change/1/');
    }
    else {
        $this->_redirect('/monitoring/notarif/');
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

$this->view->TITLE = 'Выбор тарифа';

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

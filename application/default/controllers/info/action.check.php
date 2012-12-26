<?php


if (empty($formurl)) {
    $formurl = '/info/check/';
}
//var_dump($this->params);
//Получение данных с страницы компании
if(!empty($this->params['cp_name']) && !empty($this->params['cp_inn'])){
	$this->view->cp_name = $this->params['cp_name'];
	$this->view->cp_inn = $this->params['cp_inn'];
}

$reports = new AK_Order_Report_List();
$reports = $reports->getList(1);

$oofreports = new AK_Order_Report_Oflist();
$ofreports = $oofreports->getList(1, 77);

$_sys_variables = new AK_System_Variables();
$this->view->sys_ofreports = $_sys_variables->get('official_reports');

//~ echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($_sys_variables->get('official_reports')); echo '</pre>'; die();

foreach($reports as $report){
	foreach($ofreports as $ofreport){
		if ($ofreport->order_report_id == $report->id) {
			$report->ofreport = $ofreport;
		}
	}
	
	$newreports[]=$report;
}
$listOfreports = $oofreports->getList(1, 0, 2);


$this->view->listOfreports = $listOfreports;
//var_dump($reports);
/*$zakItems =  AK_Order_ZakazTypes::getPriceListCC();
$this->view->zakItems = $zakItems;
*/
// $this->view->reports = $reports;
$this->view->reports = $newreports;

$this->view->settings = new AK_Order_Settings();
$disc = $this->view->settings->get('discount');

preg_match_all('/([0-9]+):([0-9\.]+)%/', $disc,$disc1);
$disc = $disc1;
$this->view->disc = $disc;

$maxdisc = 0;
$maxdics = "";
foreach($disc[2] as $v){
	
	
	if((float)$v > (float)$maxdisc){
		

		$maxdics = (float)$v;
		
	}
}

$this->view->maxdisc = (float)$maxdics;

$pricesOutput = array();
$zakItems=array();
$this->view->select_co = 1;
foreach ($reports as $key=>$value) {
	if(!empty($this->params['id']) && $this->params['id'] == $value->id)
	$this->view->select_co = $value->country;
		
	$zakItems[$value->id] = $value->title_order;
    $pricesOutput[$value->id] = $value->getPricesOutput();
}
$this->view->pricesOutput = $pricesOutput;
$this->params['id'] = empty($this->params['id'])?'2':$this->params['id'];

//==============================================================================
$form = new AK_Form('contactForm', 'post', $formurl);

$kontragentsList = new AK_Order_User_Kontragent_List();
$kontragentsList->addWhere('A.user_id = ?', $this->_user->id);

if ($this->params['fastmode']=='true') {
	
	if (!empty($this->params['add1']) && $this->params['add1']!=6 && !empty($this->params['cargoname2'])) {
		$form->addRule('cargoname2',  'callback',  'Введите правильный ИНН', array('func' => 'isINNNotValid','params' =>$this->params['cargoname2']));
	}
	
	if (!empty($this->params['add1']) && $this->params['add1']==6) {
		$form->addRule('destcountry',  'required',  'Выберите страну');
		$form->addRule('destcity',  'required',  'Введите адрес');
	}
	
	if (empty($this->params['add1']) || !key_exists($this->params['add1'], $zakItems)) {
		$form->addRule('add1',  'required',  'Выберите операцию');
	}
	
	if (!empty($this->params['isfiz'])&&!empty($this->params['add1'])&&$this->params['add1']==2 ) {
		$form->addRule('fizf',  'required',  'Введите фамилию');
		$form->addRule('fizi',  'required',  'Введите имя');
		$form->addRule('fizo',  'required',  'Введите отчество');
	}
	
	//

	$item = new AK_Order_Form_ContragentCheck();

	$company = new AK_company_Item( $this->params['cid']);

	$this->params['cargoname'] = $company->getName();
	$this->params['cargoname2'] = $cargo = $company->getInn();
	
	if (((mb_strlen($cargo, 'UTF-8')==10) && AK_Order_Validate::CheckINN_10($cargo)) || ((mb_strlen($cargo, 'UTF-8')==12) && AK_Order_Validate::CheckINN_12($cargo))) {
		$code = mb_substr($cargo, 0, 2, 'UTF-8');
	}
	elseif (mb_strlen($cargo, 'UTF-8')==13 && AK_Order_Validate::CheckINN_13($cargo)){
		$code = mb_substr($cargo, 3, 2, 'UTF-8');
	}
	
	$item->regionCode = $code;
	
	//echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($item->regionCode); echo'</pre>';die;

	$filter = new Zend_Filter_Alnum(true);
	$this->params['cargoname'] = $filter->filter($this->params['cargoname']);

	$item->name = $this->params['cargoname'];
	$item->inn = $this->params['cargoname2'];
	$item->ogrn = $this->params['cargoname3'];
	$item->country = $this->params['destcountry'];
	$item->addr = $this->params['destcity'];

	$item->isfiz = empty($this->params['isfiz'])?0:1;
	$item->fizf = empty($this->params['fizf'])?'':$this->params['fizf'];
	$item->fizi = empty($this->params['fizi'])?'':$this->params['fizi'];
	$item->fizo = empty($this->params['fizo'])?'':$this->params['fizo'];

	$item->typeId = $this->params['add1'];

	AK_Order_Basket::add($item);
	var_dump($item);
	include_once(APP_DIR.'/default/initialize.php');
	if ($what!='' || $okato!='' || $okved!=''  ) $this->_redirect("/list/index/what/$what/where//okved/$okved/okato/$okato/");
	if (isset($this->params['cid'])) $this->_redirect('/item/index/id/'.$this->params['cid'].'/');
	$this->_redirect($formurl);
}

if ($form->isPostBack()) {
	
	//echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($this->params); echo'</pre>';die;

    /*if (!empty($this->params['add1']) && $this->params['add1']!=6 && $this->params['add1']!=2 && $this->params['add1']!=3 && !empty($this->params['cargoname2']) && !($this->params['add1'] == 2 && $this->params['type_r'] == 0 && $this->params['isfiz'] == 1 ) ) {
        $form->addRule('cargoname2',  'callback',  'Введите правильный ИНН/ОГРН', array('func' => 'isINNNotValid','params' =>$this->params['cargoname2']));
    }
    if (!empty($this->params['add1']) && $this->params['add1']==2 && $this->params['isogrn']==0 && !($this->params['add1'] == 2 && $this->params['type_r'] == 0 && $this->params['isfiz'] == 1 )) {
        $form->addRule('cargoname2',  'callback',  'Введите правильный ИНН', array('func' => 'isINNNotValidEGRUL','params' =>$this->params['cargoname2']));
    }
    if (!empty($this->params['add1']) && $this->params['add1']==3 && $this->params['isogrn']==0) {
        $form->addRule('cargoname2',  'callback',  'Введите правильный ИНН', array('func' => 'isINNNotValidEGRIP','params' =>$this->params['cargoname2']));
    }*/
	
	if (empty($this->params['cargoname2'])) {
		$form->addRule('add1',  'required',  'Введите ИНН/ОГРН');
	}

    if (!empty($this->params['add1']) && $this->params['add1']==6) {
        $form->addRule('destcountry',  'required',  'Выберите страну');
        $form->addRule('destcity',  'required',  'Введите адрес');
    }

    if (empty($this->params['add1']) || !key_exists($this->params['add1'], $zakItems)) {
        $form->addRule('add1',  'required',  'Выберите операцию');
    }

    if (!empty($this->params['isfiz'])&&!empty($this->params['add1'])&&$this->params['add1']==2 ) {
        $form->addRule('fizf',  'required',  'Введите фамилию');
        $form->addRule('fizi',  'required',  'Введите имя');
        $form->addRule('fizo',  'required',  'Введите отчество');
    }

    if (!empty($this->params['add_to_monitoring'])) {

        $kontragent1 = new AK_Order_Kontragent('inn', $this->params['cargoname2']);
        if (!empty($kontragent1->id)) {
            $kontragentsList1 = new AK_Order_User_Kontragent_List();
            $kontragentsList1->addWhere('A.user_id = ?', $this->_user->id);
            $kontragentsList1->addWhere('A.kontragent_id = ?', $kontragent1->id);
            $kontragentsList1 = count($kontragentsList1->getList());
        }
        else {
            $kontragentsList1 = false;
        }


        if ($kontragentsList->getCount()>=$this->_user->getTarifInfo()->getTarif()->num) {
            $form->addRule('custommm',  'required',  'У Вас исчерпан лимит по количеству компаний в мониторинге, и для его увеличения Вам необходимо изменить тариф');
        }
        elseif ($kontragentsList1) {
            $form->addRule('custommm',  'required',  'Контрагент с таким ИНН уже есть в списке мониторинга');
        }
    }
    
    if (!empty($this->params['cargoname2']) && !empty($this->params['of_reports_regions']) && isset($this->params['isoff'])){
    	$cargo = $this->params['cargoname2'];
    	$code = 0;
    	if (((mb_strlen($cargo, 'UTF-8')==10) && AK_Order_Validate::CheckINN_10($cargo)) || ((mb_strlen($cargo, 'UTF-8')==12) && AK_Order_Validate::CheckINN_12($cargo))) {
    		$code = mb_substr($cargo, 0, 2, 'UTF-8');
    	}
    	elseif (mb_strlen($cargo, 'UTF-8')==13 && AK_Order_Validate::CheckINN_13($cargo)){
    		$code = mb_substr($cargo, 3, 2, 'UTF-8');
    	}
    	if ($code != $this->params['of_reports_regions']) {
    		$form->addRule('of_reports_regions', 'compare', 'В выбранном регионе не существует введённого ИНН/ОГРН ', array('rule' => '==', 'value' => $code));
    		
    	}
    }

}
else {
    $this->params['add1'] = isset($this->params['add1'])?$this->params['add1']:2;
    $this->params['isogrn'] = isset($this->params['isogrn'])?$this->params['isogrn']:0;
}

if ($form->validate($this->params)) {

    //print $this->params['add_to_monitoring'].'--'.$this->params['isogrn'].'---'.isINNNotValid($this->params['cargoname2']);die;
    //добавить в мониторинг 7707291942
    if (!empty($this->params['add_to_monitoring']) &&
        ($kontragentsList->getCount()<$this->_user->getTarifInfo()->getTarif()->num) &&
        empty($this->params['isogrn']) &&
        !(isINNNotValid($this->params['cargoname2']))) {

        $kontragent = new AK_Order_Kontragent('inn', $this->params['cargoname2']);
        if (empty($kontragent->id)) {
            $kontragent->inn = $this->params['cargoname2'];
            $kontragent->title = '';
            $kontragent->region = getRegionByInn($this->params['cargoname2']);
            $kontragent->country = '';
            $kontragent->save();
        }

        $kRelation = new AK_Order_User_Kontragent();

        $kRelation->userId = $this->_user->id;
        $kRelation->kontragentId = $kontragent->id;
        $kRelation->title = $this->params['cargoname'];
        $kRelation->region = getRegionByInn($this->params['cargoname2']);
        $kRelation->country = $kontragent->country;
        $kRelation->save();
    }

    $item = new AK_Order_Form_ContragentCheck();
    
    $item->name = $this->params['cargoname'];
    $item->inn = $this->params['cargoname2'];
    $item->ogrn = $this->params['cargoname3'];
    $item->country = $this->params['destcountry'];
    $item->addr = $this->params['destcity'];
	if ($this->params['add1'] == 29)
		$item->addr = $this->params['egrpa'];
	
	$item->regionCode = $this->params['of_reports_regions'];


    $item->isfiz = empty($this->params['isfiz'])?0:1;
    $item->fizf = empty($this->params['fizf'])?'':$this->params['fizf'];
    $item->fizi = empty($this->params['fizi'])?'':$this->params['fizi'];
    $item->fizo = empty($this->params['fizo'])?'':$this->params['fizo'];
    $item->off = empty($this->params['type_r'])?0:$this->params['type_r'];
    $item->isoff = empty($this->params['isoff'])?0:$this->params['isoff'];
    $item->srochnist = empty($this->params['isoff'])?0:$this->params['isoff'];
    
	$item->type_obj = empty($this->params['egrpv'])?0:$this->params['egrpv'];
	$item->area = empty($this->params['egrpp'])?0:$this->params['egrpp'];
	$item->k_number = empty($this->params['egrpk'])?0:$this->params['egrpk'];
		
    $item->copy_red = empty($this->params['cdrd'])?'':$this->params['cdrd'];
    $item->copy_var = '';
	if(!empty($this->params['cdd1']))
		$item->copy_var .= 'устав - '.$this->params['cdd1'].'; ';
	if(!empty($this->params['cdd2']))
		$item->copy_var .= 'учредительный договор - '.$this->params['cdd2'].'; ';
	if(!empty($this->params['cdd3']))
		$item->copy_var .= 'протокол собрания учредителей - '.$this->params['cdd3'].'; ';
	if(!empty($this->params['cdd4']))
		$item->copy_var .= 'решение о создании - '.$this->params['cdd4'].'; ';
	if(!empty($this->params['cdd5']))
		$item->copy_var .= 'свидетельство ИНН - '.$this->params['cdd5'].'; ';
	if(!empty($this->params['cdd6']))
		$item->copy_var .= 'свидетельсвто ОГРН - '.$this->params['cdd6'].'; ';
	//$item->copy_var = empty($this->params['cdrd'])?'':$this->params['cdrd'];

    $item->typeId = $this->params['add1'];
    
	$count = empty($this->params['offcount'])?1:$this->params['offcount'];
	

	for ($i=0;$i<$count;$i++)
		AK_Order_Basket::add($item);
	
	

    $this->_redirect($formurl);
}
else {
   
    $form->setDefaults($this->params);
    $this->view->form = $form;
}
//==============================================================================
$pItems =  AK_Order_Enum::getPList();
$this->view->pItems = $pItems;

$oItems =  AK_Order_Enum::getOList();
$this->view->oItems = $oItems;

if (!empty($this->params['money']))
	$pay_type=new AK_Order_Pay_Item($this->params['money']);
//print_r($pay_type);
$form2 = new AK_Form('createForm', 'post', $formurl);

$form2->addRule('email', 'required', 'Введите Email');
$form2->addRule('email', 'email', 'Введите правильный Email');

$form2->addRule('money', 'required', 'Выберите способ оплаты');

$form2->addRule('priority', 'required', 'Выберите приоритет');

if ($form2->isPostBack()) {

    if (empty($this->params['money']) || !AK_Order_Enum::isInO($this->params['money'])) {
        $form2->addRule('money1', 'required',  'Выберите способ оплаты');
    }

    if (!empty($this->params['money']) && $this->params['money'] == AK_Order_Enum::O_BEZNAL) {
        $form2->addRule('zaku', 'required',  'Введите заказчика');
        $form2->addRule('platu', 'required',  'Введите плательщика');
    }

    if (empty($this->params['priority']) || !AK_Order_Enum::isInP($this->params['priority'])) {
        $form2->addRule('priority1', 'required',  'Выберите приоритет');
    }
}
else {
    $this->params['priority'] = AK_Order_Enum::P_MEDIUM;
    $this->params['money'] = AK_Order_Enum::O_NAL;
}

if ($form2->validate($this->params)) {
    include_once (APP_DIR . '/' . MODULE_NAME . '/controllers/order/action.create.php');
}
else {
    if (!$form2->isPostback() && !empty($this->_user->id)) {
        $this->params['email'] = $this->_user->email;
    }
    $form2->setDefaults($this->params);
    $this->view->form2 = $form2;
}


//==============================================================================

$this->view->fparams = $this->params;

function isINNNotValid($Values) {
    if (AK_Order_Validate::CheckINN($Values)) {
        return false;
    }
    return true;
}
function isINNNotValidEGRUL($Values) {
	if ( !empty($Values) && (mb_strlen($Values, 'UTF-8')==10)){
		if (AK_Order_Validate::CheckINN_10($Values) ) {	
			return false;
		}
	}
    return true;
}
function isINNNotValidEGRIP($Values) {
    if ( !empty($Values) && (mb_strlen($Values, 'UTF-8')==12)){
		if (AK_Order_Validate::CheckINN_12($Values) ) {
			return false;
		}
	}
    return true;
}


//==============================================================================
$currentInfo = new AK_Article_Item();
$currentInfo->loadByRewriteName('check');
$this->view->currentInfo = $currentInfo;

$ListPay2 = new AK_Order_Pay_ListType();
$this->view->ListPay2 = $ListPay2->returnAsAssoc(true)->getList();

$ListPay = new AK_Order_Pay_List();
$this->view->ListPay = $ListPay->getList();

$this->view->TITLE = 'Форма заказа на проверку контрагента';

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

$list = new AK_Location_Country_List();
$this->view->countries = $list->returnAsAssoc()->setOrder('A.name ASC')->getList();


$ListContry = new AK_Order_Report_ListContry();

$this->view->ListContry = $ListContry->returnAsAssoc(true)->getList();

//$this->view->id_report = $this->params['id'];

function isINNExists($Values) {

    $db = Zend_Registry::get('DBORDER');
    $select = $db->select();
    $select->from('orders_users__kontragents AS A', 'A.kontragent_id')
        ->joinLeft('orders_kontragents AS B', 'B.id = A.kontragent_id', null)
        ->where('B.inn = ?', $Values);
    $res = $db->fetchOne($select);

    if (!(boolean) $res) {
        return false;
    }
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

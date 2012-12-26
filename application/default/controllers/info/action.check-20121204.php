<?php


if (empty($formurl)) {
    $formurl = '/info/check/';
}
$zakItems =  AK_Order_ZakazTypes::getPriceListCC();
$this->view->zakItems = $zakItems;

$pricesOutput = array();
foreach ($zakItems as $key=>$value) {
    $_price = new AK_Order_Prices($key);
    $pricesOutput[$key] = $_price->getPricesOutput();
}
$this->view->pricesOutput = $pricesOutput;


//==============================================================================
$form = new AK_Form('contactForm', 'post', $formurl);

if ($form->isPostBack() || $this->params['fastmode']=='true') {
    
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

}
else {
    $this->params['add1'] = isset($this->params['add1'])?$this->params['add1']:2;
    $this->params['isogrn'] = isset($this->params['isogrn'])?$this->params['isogrn']:0;
}

if ($form->validate($this->params) || $this->params['fastmode']=='true') {
  
    $item = new AK_Order_Form_ContragentCheck();
    
    $company = new AK_company_Item( $this->params['id']);
    
    $this->params['cargoname'] = $company->getName();
    $this->params['cargoname2'] = $company->getInn();

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
    if (isset($this->params['id'])) $this->_redirect('/item/index/id/'.$this->params['id'].'/');
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
}else {
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


//==============================================================================
$currentInfo = new AK_Article_Item();
$currentInfo->loadByRewriteName('check');
$this->view->currentInfo = $currentInfo;

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



$list = new AK_Location_Country_List();
$this->view->countries = $list->returnAsAssoc()->setOrder('A.name ASC')->getList();


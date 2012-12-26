<?php

if (empty($formurl)) {
    $formurl = '/info/base/';
}

if (!empty($_SESSION['ed'])) {
    $this->params = $_SESSION['ed'];
    $this->params = array(
        'company' => empty($this->params['company'])?'':$this->params['company'],
        'cprofile' => empty($this->params['cprofile'])?'':$this->params['cprofile'],
        'name' => $this->params['name'],
        'email' => $this->params['email'],
        'secondname' => $this->params['secondname'],
        'phone' => $this->params['phone']
    );
    unset($_SESSION['ed']);
}
//==============================================================================
$form = new AK_Form('contactForm', 'post', $formurl);
$form->addRule('company',  'required',  'Введите название компании');
$form->addRule('name',  'required',  'Введите имя');
$form->addRule('email',  'required',  'Введите email');
$form->addRule('email', 'email', 'Введите правильный Email');
$form->addRule('secondname',  'required',  'Введите фамилию');
$form->addRule('phone',  'required',  'Введите телефон');
$form->addRule('text',  'required',  'Введите текст запроса');


if ($form->isPostBack()) {

    if (!empty($this->params['isenum']) && empty($this->params['enumfrom']) && empty($this->params['enumto'])) {
        $form->addRule('isenum1',  'required',  'Введите количество сотрудников');
    }

    if (!empty($this->params['isfinp']) && empty($this->params['finptext'])) {
        $form->addRule('finptext',  'required',  'Введите финансовые показатели');
    }

}

if ($form->validate($this->params)) {

    $item = new AK_Order_Form_Base();

    $item->company = empty($this->params['company'])?'':$this->params['company'];
    $item->cprofile = empty($this->params['cprofile'])?'':$this->params['cprofile'];
    $item->name = $this->params['name'];
    $item->email = $this->params['email'];
    $item->secondname = $this->params['secondname'];
    $item->phone = $this->params['phone'];
    $item->text = $this->params['text'];
    $item->isphone = empty($this->params['isphone'])?0:1;
    $item->isemail = empty($this->params['isemail'])?0:1;
    $item->isfax = empty($this->params['isfax'])?0:1;
    $item->isenum = empty($this->params['isenum'])?0:1;
    $item->enumfrom = empty($this->params['enumfrom'])?null:intval($this->params['enumfrom']);
    $item->enumto = empty($this->params['enumto'])?null:intval($this->params['enumto']);
    $item->isfinp = empty($this->params['isfinp'])?0:1;
    $item->finptext = empty($this->params['finptext'])?'':$this->params['finptext'];


    $item->typeId = AK_Order_ZakazTypes::BASE_ITEM;

    AK_Order_Basket::add($item);
    $_SESSION['ed'] = $this->params;
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

if (AK_Order_Basket::isTotalAmountDefined()) {
    $form2->addRule('money', 'required', 'Выберите способ оплаты');
}

$form2->addRule('priority', 'required', 'Выберите приоритет');

if ($form2->isPostBack()) {

    if (AK_Order_Basket::isTotalAmountDefined()) {
        if (empty($this->params['money']) || !AK_Order_Enum::isInO($this->params['money'])) {
            $form2->addRule('money1', 'required',  'Выберите способ оплаты');
        }

        if (!empty($this->params['money']) && $this->params['money'] == AK_Order_Enum::O_BEZNAL) {
            $form2->addRule('zaku', 'required',  'Введите заказчика');
            $form2->addRule('platu', 'required',  'Введите плательщика');
        }

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

//==============================================================================
$currentInfo = new AK_Article_Item();
$currentInfo->loadByRewriteName('infobase');
$this->view->currentInfo = $currentInfo;

$this->view->TITLE = 'Форма заказа базы данных';

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
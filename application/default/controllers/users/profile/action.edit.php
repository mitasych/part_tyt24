<?php

$this->view->user=$this->_user;
 
$parent_id = $this->_user->id;
 
$db1 = Zend_Registry::get('DBORDER');
$query = $db1->select();
$query->from('orders_users__accounts AS U', 'U.*')->where('`parent_user`=?', $parent_id);
$sub_users = $db1->fetchAll($query);
$this->view->sub_users = $sub_users;

//Zend_Debug::dump($sub_users);


if (!$this->currentUser->getLogin() ) {
    $this->_redirect(SITE_URL);
}

if ($this->currentUser->id != $this->_user->id ) {
    $this->_redirect(SITE_URL);
}

$statusList = AK_Enum_UserStatus::getList();
$genderList = AK_Enum_Gender::getList();
$fromList = AK_Enum_From::getList();

$form = new AK_Form('editForm', 'post', SITE_URL.'/users/editprofile/');

if (empty($this->params['status']) || !AK_Enum_UserStatus::isIn($this->params['status'])) {
    $form->addRule('custom1', 'required',  'Выберите статус');
}
if (!empty($this->params['status']) && $this->params['status'] == 2) {
    $form->addRule('organization', 'required',  'Введите Наименование организации');
    $form->addRule('innogrn', 'required',  'Введите ИНН/ОГРН');
    $form->addRule('position', 'required',  'Введите Должность');
}

if (!empty($this->params['status']) && $this->params['status'] == 3) {
    $form->addRule('innogrn2', 'required',  'Введите ИНН/ОГРН');
}

if (!empty($this->params['newpass'])) {
    $form->addRule('newpassc', 'required',  'Введите подтверждение пароля');
    if (!empty($this->params['newpassc']) && $this->params['newpass'] != $this->params['newpassc']) {
        $form->addRule('newpasscc', 'required',  'Введенные пароли не совпадают');
    }
}

if (!empty($this->params['dogovor_notify_flag'])) {



    $form->addRule('dolj', 'required',  'Введите Должность руководителя');
    $form->addRule('df', 'required',  'Введите Фамилия');
    $form->addRule('di', 'required',  'Введите Имя');
    $form->addRule('do', 'required',  'Введите Отчество');
    $form->addRule('doljr', 'required',  'Введите Должность руководителя (в родительном падеже)');
    $form->addRule('dfr', 'required',  'Введите Фамилия (в родительном падеже)');
    $form->addRule('dir', 'required',  'Введите Имя (в родительном падеже)');
    $form->addRule('dor', 'required',  'Введите Отчество (в родительном падеже)');
   // $form->addRule('dn', 'required',  'Введите основание');
   // $form->addRule('dot', 'required',  'Введите дату');
     $form->addRule('uraddress', 'required',  'Введите юридический адрес');
}

//if (!empty($this->params['akt_notify_flag']) && !empty($this->params['status']) && $this->params['status'] != 1 ) {
//    $form->addRule('akt_email', 'required',  'Введите email');
//}
$this->params['status'] = isset($this->params['status'])?$this->params['status']:$this->_user->status;
$this->view->status = $this->params['status'];

$form->addRule('name',        'required',  'Ведите имя');
$form->addRule('second_name',        'required',  'Ведите фамилию');
$form->addRule('third_name',        'required',  'Ведите отчество');

if (empty($this->params['gender']) || !AK_Enum_Gender::isIn($this->params['gender'])) {
    $form->addRule('custom2', 'required',  'Выберите пол');
}


$form->addRule('email',        'required',  'Введите Email');
$form->addRule('email',        'email',     'Введите правильный Email');

$form->addRule('email',        'callback',  'Введенный Email уже существует',  array('func' => 'emailExist2', 'params' => array('email' => isset($this->params['email']) ? $this->params['email'] : '', 'user_id' => $this->_user->id ) ) );

$form->addRule('country', 'required',  'Выберите страну');

if ($form->validate($this->params)) {

    $user = new AK_Order_User('id', $this->_user->id);

    $user->setName($this->params['name'])
        ->setSecondName($this->params['second_name'])
        ->setThirdName($this->params['third_name'])
        ->setGender($this->params['gender'])
        ->setFrom($this->params['from'])
     //   ->setPassword(md5($this->params['pass']))
        ->setEmail($this->params['email']);
      //  ->setCreateDate(time());
    $user->subscribeFlag = empty($this->params['subscribe_flag'])?0:1;
    
    $user->phone = empty($this->params['phone'])?'':$this->params['phone'];
    $user->status = $this->params['status'];

    $user->organization = empty($this->params['organization'])?'':$this->params['organization'];
    $user->innogrn = empty($this->params['innogrn'])?'':$this->params['innogrn'];
    $user->position = empty($this->params['position'])?'':$this->params['position'];
    $user->innogrn2 = empty($this->params['innogrn2'])?'':$this->params['innogrn2'];
    $user->dolj = empty($this->params['dolj'])?'':$this->params['dolj'];
    $user->df = empty($this->params['df'])?'':$this->params['df'];
    $user->di = empty($this->params['di'])?'':$this->params['di'];
    $user->do = empty($this->params['do'])?'':$this->params['do'];

    $user->doljr = empty($this->params['doljr'])?'':$this->params['doljr'];
    $user->dfr = empty($this->params['dfr'])?'':$this->params['dfr'];
    $user->dir = empty($this->params['dir'])?'':$this->params['dir'];
    $user->dor = empty($this->params['dor'])?'':$this->params['dor'];
    $user->uraddress = empty($this->params['uraddress'])?'':$this->params['uraddress'];

 

    $user->dn = empty($this->params['dn'])?'':$this->params['dn'];
    $user->dot = empty($this->params['dot'])?'':$this->params['dot'];
    $user->akt_email = empty($this->params['akt_email'])?'':$this->params['akt_email'];

    $user->companyProfile = empty($this->params['companyProfile'])?'':$this->params['companyProfile'];

    $user->dogovorNotifyFlag = empty($this->params['dogovor_notify_flag'])?0:1;

    $user->country = intval($this->params['country']);
    $user->region = intval($this->params['region']);

    if (!empty($this->params['newpass'])) {
        $user->setPassword(md5($this->params['newpass']));
    }

    $user->save();

    $this->_redirect(SITE_URL.'/users/profile/');
}
else {

    if (!$form->isPostback()) {
        $this->params['subscribe_flag'] = $this->_user->subscribeFlag; 
    }
    $form->setDefaults($this->params);
    $this->view->form = $form;
}

$this->view->statusList = $statusList;
$this->view->genderList = $genderList;
$this->view->fromList = $fromList;
$this->view->fparams = $this->params;

$countryList = new AK_Location_Country_List();
$countryList->returnAsAssoc()->setAssocKey('A.id')->setOrder('A.name ASC')->addWhere('A.register_list = 1');
//Zend_Debug::dump($countryList->getList());

$id_arr = array();
$name_arr = array();
foreach ($countryList->getList() as $item) {
	$id_arr[$item['id']] = $item['name'];
}
//Zend_Debug::dump($id_arr);
$this->view->id_arr = $id_arr;
$this->view->countriesList = $countryList->getList();

$db2 = Zend_Registry::get('DBORDER');
$query = $db2->select();
$query->from('orders_region__inn AS A', 'A.*');
$regionList = $db2->fetchAll($query);
$region_arr = array();
foreach ($regionList as $reg) {
	$region_arr[$reg['code']] = $reg['title'];
}
//Zend_Debug::dump($this->_user);
$this->view->regionList = $region_arr;

 function emailExist2($params) {
        $email = $params['email'];
        $user_id = $params['user_id'];

        $_db = Zend_Registry :: get('DBORDER');

        $where = $_db->quoteInto("email = ? AND id <> '$user_id'", $email);
        $sql = $_db->select()->from('orders_users__accounts', 'id')->where($where);
        return $_db->fetchOne($sql) ? true : false;
    }
<?php

$this->params = $this->getRequest()->getParams();
$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
$currentItem = new AK_Order_User('id', $this->params['id']);





$statusList = AK_Enum_UserStatus::getList();
$genderList = AK_Enum_Gender::getList();
$fromList = AK_Enum_From::getList();


$form = new AK_Form('registrationForm', 'post', MODULE_URL.'/orders/useredit/');

if (empty($this->params['status']) || !AK_Enum_UserStatus::isIn($this->params['status'])) {
    $form->addRule('custom1', 'required',  'Выберите статус');
}

$form->addRule('login',        'required',  'Ведите имя пользователя');
$form->addRule('login',        'callback',  'Пользователь с таким именем уже существует', array('func' => 'AK_Order_Validate_Rules::loginExist2', 'params' => array('login' => isset($this->params['login']) ? $this->params['login'] : '', 'user_id' => $currentItem->id )));

if (empty($currentItem->id) || !empty($this->params['pass'])) {
    $form->addRule('pass',         'required',  'Введите пароль');
    $form->addRule('pass_confirm', 'required',  'Введите подтверждение пароля');
    $form->addRule('pass',         'compare',   'Подтеврждение пароля не совпадает с паролем', array('rule' => '==', 'value' => isset($this->params['pass_confirm'])?$this->params['pass_confirm']:''));
    $form->addRule('pass',         'minlength', 'Минимальная длина пароля 6 символов', array('min' => 6));
}


$form->addRule('name',        'required',  'Ведите имя');
$form->addRule('second_name',        'required',  'Ведите фамилию');
$form->addRule('third_name',        'required',  'Ведите отчество');

if (empty($this->params['gender']) || !AK_Enum_Gender::isIn($this->params['gender'])) {
    $form->addRule('custom2', 'required',  'Выберите пол');
}


$form->addRule('email',        'required',  'Введите Email');
$form->addRule('email',        'email',     'Введите правильный Email');
$form->addRule('email',        'callback',  'Введенный Email уже существует',  array('func' => 'emailExist2', 'params' => array('email' => isset($this->params['email']) ? $this->params['email'] : '', 'user_id' => $currentItem->id ) ) );
if ($form->isPostback()) {
    $currentItem->setLogin($this->params['login'])
        ->setName($this->params['login'])
        ->setSecondName($this->params['second_name'])
        ->setThirdName($this->params['third_name'])
        ->setGender($this->params['gender'])
        ->setFrom($this->params['from'])
        ->setEmail($this->params['email'])
        ->setCreateDate(time());
    $currentItem->subscribeFlag = empty($this->params['subscribe_flag'])?0:1;
    $currentItem->vipiskaNotifyFlag = empty($this->params['vipiska_notify_flag'])?0:1;
    $currentItem->dogovorNotifyFlag = empty($this->params['dogovor_notify_flag'])?0:1;
    $currentItem->aktNotifyFlag = empty($this->params['akt_notify_flag'])?0:1;
    $currentItem->phone = empty($this->params['phone'])?'':$this->params['phone'];
    $currentItem->status = $this->params['status'];
    if (!empty($this->params['pass'])) {
        $currentItem->setPassword(md5($this->params['pass']));
    }
}

if ($form->validate($this->params)) {

    $currentItem->save();

    $this->_redirect(MODULE_URL.'/orders/users.list/');
}
else {
    $form->setDefaults($this->params);
    $this->view->form = $form;
}

$this->view->statusList = $statusList;
$this->view->genderList = $genderList;
$this->view->fromList = $fromList;




 function emailExist2($params) {
        $email = $params['email'];
        $user_id = $params['user_id'];

        $_db = Zend_Registry :: get('DBORDER');

        $where = $_db->quoteInto("email = ? AND id <> '$user_id'", $email);
        $sql = $_db->select()->from('orders_users__accounts', 'id')->where($where);
        return $_db->fetchOne($sql) ? true : false;
    }



//
//
//
//$form = new AK_Form('editItem', 'post', MODULE_URL.'/orders/kuratoredit/');
//$form->addRule('login',        'required',  'Ведите имя пользователя');
//
//$form->addRule('login',        'callback',  'Пользователь с таким именем уже существует', array('func' => 'AK_Order_Validate_Rules::AdminLoginExist', 'params' => array('login' => isset($this->params['login']) ? $this->params['login'] : '', 'user_id' => $currentItem->id )));
//
//
//if (empty($currentItem->id) || !empty($this->params['password'])) {
//  $form->addRule('password',         'required',  'Введите пароль');
//  $form->addRule('password',         'minlength', 'Минимальная длина пароля 6 символов', array('min' => 6));
//}
//
//$form->addRule('email',        'required',  'Введите Email');
//$form->addRule('email',        'email',     'Введите правильный Email');
//
//
//$form->addRule('email',        'callback',  'Введенный Email уже существует',  array('func' => 'AK_Order_Validate_Rules::adminEmailExist', 'params' => array('email' => isset($this->params['email']) ? $this->params['email'] : '', 'user_id' => $currentItem->id ) ) );
//
//
//if ($form->isPostback()){
//  $form->setDefaults($this->params);
//}
//
//if ($form->validate($this->params)){
//
//    $currentItem->login = $this->params['login'];
//    if(!empty($this->params['password'])) $currentItem->password = md5($this->params['password']);
//    $currentItem->email = $this->params['email'];
//    $currentItem->status = AK_Enum_AdminStatus::KURATOR;
//    $currentItem->description = $this->params['description'];
//
//    $currentItem->save();
//
//    $this->_redirect(MODULE_URL.'/orders/kurators.list/');
//}
//
//$this->view->form = $form;


$this->view->currentItem = $currentItem;
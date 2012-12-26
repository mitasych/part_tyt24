<?php

$this->params = $this->getRequest()->getParams();

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;  
$currentItem = new AK_Administrator('id', $this->params['id']);

$form = new AK_Form('editItem', 'post', MODULE_URL.'/orders/kuratoredit/');
$form->addRule('login',        'required',  'Ведите имя пользователя');

$form->addRule('login',        'callback',  'Пользователь с таким именем уже существует', array('func' => 'adminLoginExist', 'params' => array('login' => isset($this->params['login']) ? $this->params['login'] : '', 'user_id' => $currentItem->id )));


if (empty($currentItem->id) || !empty($this->params['password'])) {
  $form->addRule('password',         'required',  'Введите пароль');
  $form->addRule('password',         'minlength', 'Минимальная длина пароля 6 символов', array('min' => 6));
}

$form->addRule('email',        'required',  'Введите Email');
$form->addRule('email',        'email',     'Введите правильный Email');


$form->addRule('email',        'callback',  'Введенный Email уже существует',  array('func' => 'adminEmailExist', 'params' => array('email' => isset($this->params['email']) ? $this->params['email'] : '', 'user_id' => $currentItem->id ) ) );


if ($form->isPostback()){
  $form->setDefaults($this->params);  
}

if ($form->validate($this->params)){

    $currentItem->login = $this->params['login'];
    if(!empty($this->params['password'])) $currentItem->password = md5($this->params['password']);
    $currentItem->email = $this->params['email'];
    $currentItem->status = AK_Enum_AdminStatus::KURATOR;
    $currentItem->description = $this->params['description'];
    
    $currentItem->save();

    $this->_redirect(MODULE_URL.'/orders/kurators.list/');
}

$this->view->form = $form;
$this->view->currentItem = $currentItem;

function adminEmailExist($params) {
        $email = $params['email'];
        $user_id = $params['user_id'];

        $_db = Zend_Registry :: get('DBORDER');

        $where = $_db->quoteInto("email = ? AND id <> '$user_id'", $email);
        $sql = $_db->select()->from('ak_administrators__accounts', 'id')->where($where);
        return $_db->fetchOne($sql) ? true : false;
    }

    function adminLoginExist($params) {
        $login = $params['login'];
        $user_id = $params['user_id'];

        $_db = Zend_Registry :: get('DBORDER');

        $where = $_db->quoteInto("login = ? AND id <> '$user_id'", $login);
        $query = $_db->select()->from('ak_administrators__accounts', 'id')->where($where);
        return $_db->fetchOne($query) ? true : false;
    }

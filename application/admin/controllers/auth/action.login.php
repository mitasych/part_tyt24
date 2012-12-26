<?php

$_variables = new AK_System_Variables();

if ($_variables->get('last_adminarea_access_attempt') < time() - 30*60 ) {
    $_variables->set('last_adminarea_access_attempt', '0', 'int');
    $_variables->set('critical_adminarea_access_attempt_count', '0', 'int');
}

if ($_variables->get('critical_adminarea_access_attempt_count')>4) {
    $this->view->setLayout('login.ban.tpl');
}
else {
    $_SESSION['admin_id'] = ( !isset($_SESSION['admin_id']) ) ? null : $_SESSION['admin_id'];
    $administrator = new AK_Administrator('id', $_SESSION['admin_id']);

    if (AK_Administrator :: isAdministratorExists('id', $_SESSION['admin_id']) && $administrator->isAuthenticated()) {
        $this->_redirect('/'.MODULE_NAME.'/');
    }

    $this->view->remindpass = isset($this->params['remindpass']);

    $form = new AK_Form('loginForm', 'post', '/'.MODULE_NAME.'/auth/login/');


    if (!$form->isPostBack()) {
        if(!empty($_COOKIE['saveadminlogin'])) $this->params['login'] = $_COOKIE['saveadminlogin'];
        if(!empty($_COOKIE['saveadminpassword'])) $this->params['pass'] = $_COOKIE['saveadminpassword'];
        if(!empty($_COOKIE['saveadminpassword']) || !empty($_COOKIE['saveadminlogin'])) {
            $this->view->remindpass = 1;
            $this->params['remindpass'] = 1;
            $_REQUEST['_wf__' . $form->name] = 1;
        }


    }

    $form->addRule('login',  'required',  'Введите имя пользователя');
    $form->addRule('pass',   'required',  'Введите пароль');
    $form->addRule('pass',   'callback',  'Неверное имя пользователя или пароль', array('func' => 'loginFailed', 'params' => array('login' => isset($this->params['login']) ? $this->params['login'] : '', 'password' => isset($this->params['pass']) ? $this->params['pass'] : '') ));

    if ($form->validate($this->params)) {

        $administrator = new AK_Administrator('login', $this->params['login']);
        $administrator->authenticate();

        setcookie("saveadminlogin",!empty($this->params['remindpass'])?$administrator->login:"",time()+60*60*24*365*10, '/');
        setcookie("saveadminpassword",!empty($this->params['remindpass'])?$this->params['pass']:"",time()+60*60*24*365*10, '/');

        $_variables->set('last_adminarea_access_attempt', '0', 'int');
        $_variables->set('critical_adminarea_access_attempt_count', '0', 'int');

        $this->_redirect('/'.MODULE_NAME.'/');

    }
    else {
        $_variables->set('critical_adminarea_access_attempt_count', $_variables->get('critical_adminarea_access_attempt_count')+1, 'int');
        $_variables->set('last_adminarea_access_attempt', time(), 'int');

        $form->setDefaults($this->params);
        $this->view->form = $form;
    }
    $this->view->setLayout('login.tpl');
}


function loginFailed($fields)
{
    return !AK_Administrator::validateLogin($fields['login'], $fields['password']);
}

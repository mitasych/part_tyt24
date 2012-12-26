<?php

if ( $this->view->user->isAuthenticated() )
{
    $this->_redirect(SITE_URL.'/users/profile/');
}

$form = new AK_Form('loginForm', 'post', SITE_URL.'/users/login/');

$form->addRule('login',  'required',  'Введите имя пользователя');
$form->addRule('pass',   'required',  'Введите пароль');
$form->addRule('pass',   'callback',  'Неверное имя пользователя или пароль', array('func' => 'loginFailed', 'params' => array('login' => isset($this->params['login']) ? $this->params['login'] : '', 'password' => isset($this->params['pass']) ? $this->params['pass'] : '') ));

if ($form->validate($this->params)){

    $user = new AK_Order_User('login', $this->params['login']);
    $user->authenticate();
    
    //Восстановление пароля
    if (!empty($user->newPassword)) {
          if (md5($this->params['pass']) == $user->newPassword) {
              $user->password = $user->newPassword;
          }
          
          $user->newPassword = '';
          $user->save();
    }
    
        $this->_redirect($user->getUserPath('profile'));
}
else
{
    $form->setDefaults($this->params);
    $this->view->form = $form;
}


function loginFailed($fields)
{
    return !AK_Order_User::validateLogin($fields['login'], $fields['password']);
}

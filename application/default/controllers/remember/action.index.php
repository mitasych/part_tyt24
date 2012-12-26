<?php



$captcha = AK_Captcha_Factory::getCaptcha(AK_Captcha_Enum::WAVE); 
$captcha->setRequest($this->getRequest())->setKey('verify_code');

$form = new AK_Form('rememberForm', 'post', SITE_URL.'/remember/index/'); 


$form->addRule('login',        'required',  'Ведите имя пользователя');

$form->addRule('email',        'required',  'Введите Email');
$form->addRule('email',        'email',     'Введите правильный Email');

$form->addRule('verify_code',  'required',  'Введите код подтверждения');
$form->addRule( 'verify_code',  
                'callback',  
                'Введите правильный код подтверждения', 
                array( 'func' => 'AK_Order_Validate_Rules::isCaptchaCodeNotValid',
                       'params' => $captcha
                     )
              );
$form->addRule('verify_code',  'callback',  'Неверное имя пользователя и(или) e-mail', array('func' => 'AK_Order_Validate_Rules::userEmailExist', 'params' => array('login' => isset($this->params['login']) ? $this->params['login'] : '', 'email' => isset($this->params['email']) ? $this->params['email'] : '')));

if ($form->validate($this->params)){

    $user = new AK_Order_User('login', $this->params['login']);
    $user->newPassword = AK_Common_Functions::generatePassword();
    
    $captcha->clear();    
    
    require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

    $mail = new PHPMailer();
    $body = 'Вы, либо кто-то другой сделали запрос на восстановление пароля на сайте '.SITE_NAME.'. Ваш новый пароль: '.$user->newPassword;
    $body = eregi_replace("[\]",'',$body);
    
    $mail->From       = CONTACT_EMAIL;
    $mail->FromName   = 'Администрация сайта '.SITE_NAME;
    $mail->Subject    = 'Запрос на восстановление пароля на сайте '.SITE_NAME;
    
    $mail->IsHTML(false);
    $mail->Body = $body;

    $mail->AddAddress($user->email, "");
    
    $user->newPassword = md5($user->newPassword);
    $user->save();
    
    $mail->Send();
    
   
    
    
    unset($_SESSION['imgLoc']);
    $this->_redirect(SITE_URL.'/remember/completed/');
} else {

    $this->params['verify_code'] = '';
    $form->setDefaults($this->params);
    $this->view->form = $form;
}

$this->view->verifyImage = $captcha->generateImage();

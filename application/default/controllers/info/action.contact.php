<?php
//sp@beltransavto.com
require(LIBRARY_DIR.'/b2evo_captcha/b2evo_captcha.config.php');
require_once(LIBRARY_DIR.'/b2evo_captcha/b2evo_captcha.class.php');

$imgLoc = (isset($_SESSION['imgLoc'])) ? $_SESSION['imgLoc'] : null;
$captchaValues = (isset($imgLoc) && isset($this->params['verify_code'])) ? array('key' => $imgLoc, 'userkey' => $this->params['verify_code']):'';
//print_r($captchaValues);

$this->view->TITLE = 'Обратная связь';
$form = new AK_Form('contactForm', 'post', '/info/contact/');

$form->addRule('login',        'required',  'Ведите имя пользователя');
$form->addRule('email',        'required',     'Введите Email');
$form->addRule('email',        'email',     'Введите правильный Email');
$form->addRule('phone',        'required',     'Введите телефон');
$form->addRule('text',         'required',  'Введите текст сообщения');

$form->addRule('verify_code',  'required',  'Введите код подтверждения');
$form->addRule('verify_code',  'callback',  'Введите правильный код подтверждения', array('func' => 'isCaptchaCodeNotValid','params' =>$captchaValues));

$this->params['phone'] = isset($this->params['phone'])?$this->params['phone']:'';
$this->params['company'] = isset($this->params['company'])?$this->params['company']:'';

if ($form->validate($this->params)) {

    $_variables = new AK_System_Variables();

    require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

    $mail = new PHPMailer();
    $body = $this->params['login'].(!empty($this->params['company'])?' Компания:'.$this->params['company'].'  ':'').(!empty($this->params['phone'])?' Тел:'.$this->params['phone'].'  ':'').' пишет: '.$this->params['text'];
    $body = eregi_replace("[\]",'',$body);

    $mail->From       = $this->params['email'];
    $mail->FromName   = $this->params['login'];
    $mail->Subject    = 'Заполнена форма обратной связи на сайте '.SITE_NAME.' ('.$_SERVER['SERVER_NAME'].')';

    $mail->IsHTML(false);
    $mail->Body = $body;

    $mail->AddAddress($_variables->get('email_contact'), "");
    if($mail->Send()) {
        $this->_redirect('/info/sentc/');

    }
}
else {

    $form->setDefaults($this->params);
    $this->view->form = $form;
}

$captcha = new b2evo_captcha($CAPTCHA_CONFIG);
$imgLoc = $captcha->get_b2evo_captcha();
$_SESSION['imgLoc'] = $imgLoc;
$this->view->verifyImage = $imgLoc;


//validate
function isCaptchaCodeNotValid($Values) {
    global $CAPTCHA_CONFIG;
    if ($Values === '') return true;

    $captcha = new b2evo_captcha($CAPTCHA_CONFIG);
    return ($captcha->validate_submit($Values['key'], $Values['userkey'])===0) ? true: false;
}

$currentInfo = new AK_Article_Item();
$currentInfo->loadByRewriteName('contacts');
$this->view->currentInfo = $currentInfo;

if ($currentInfo->getMetaTitle()) {
    $this->view->TITLE = $currentInfo->getMetaTitle();
} elseif ($currentInfo->getTitle()) $this->view->TITLE = $currentInfo->getTitle();
if ($currentInfo->getMetaKeywords()) {
    $this->view->KEYWORDS = $currentInfo->getMetaKeywords();
}
if ($currentInfo->getMetaDescription()) {
    $this->view->DESCRIPTION = $currentInfo->getMetaDescription();
}

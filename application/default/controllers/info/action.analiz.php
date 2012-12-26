<?php

require(LIBRARY_DIR.'/b2evo_captcha/b2evo_captcha.config.php');
require_once(LIBRARY_DIR.'/b2evo_captcha/b2evo_captcha.class.php');

$imgLoc = (isset($_SESSION['imgLoc'])) ? $_SESSION['imgLoc'] : null;
$captchaValues = (isset($imgLoc) && isset($this->params['verify_code'])) ? array('key' => $imgLoc, 'userkey' => $this->params['verify_code']):'';


$this->view->TITLE = 'Форма заказа на анализ';
$form = new AK_Form('contactForm', 'post', '/info/analiz/');

$form->addRule('verify_code',  'required',  'Введите код подтверждения');
$form->addRule('verify_code',  'callback',  'Введите правильный код подтверждения', array('func' => 'isCaptchaCodeNotValid','params' =>$captchaValues));


if ($form->validate($this->params)) {

    $body='Заявка на анализ прислана с сайта '.SITE_NAME.'<br><br><b>Контактная информация</b><br>';
    $body.='Название компании: '.htmlspecialchars($this->params['name']).'<br>';
    $body.='Контактное лицо: '.htmlspecialchars($this->params['contactperson']).'<br>';
    $body.='Телефон: '.htmlspecialchars($this->params['phone']).'<br>';
    $body.='E-mail: '.htmlspecialchars($this->params['email']).'<br>';

    $body.='<br><b>Анализ ВЭД</b><br>';

    $body.='Режим: '.htmlspecialchars($this->params['napr']).'<br>';
    $body.='Рынок: '.htmlspecialchars($this->params['shiptype']).'<br>';
    
    if (!empty($this->params['add1'])) {
        $body.='Код ТНВЭД: '.htmlspecialchars($this->params['cargoname']).'<br>';
        $body.='Краткое описание товара: '.htmlspecialchars($this->params['cargoname2']).'<br>';
    }

    if (!empty($this->params['add2'])) {
        $body.='Бренд: '.htmlspecialchars($this->params['brand']).'<br>';
    }

    if (!empty($this->params['add3'])) {
        $body.='Регион: '.htmlspecialchars($this->params['region']).'<br>';
    }

    if (!empty($this->params['add3'])) {
        $body.='Поставщик/Производитель: '.htmlspecialchars($this->params['postav']).'<br>';
    }

    if ($this->params['isperiod']) {
        $body.='Период: '.htmlspecialchars($this->params['period1']).' '.htmlspecialchars($this->params['period2']).' '.htmlspecialchars($this->params['period3']).'<br>';
    }

    $body.='<br><b>Условия</b><br>';
    $body.='Срок выполнения заказа: '.htmlspecialchars($this->params['srok']).'<br>';
    $body.='Способ оплаты: '.htmlspecialchars($this->params['oplata']).'<br><br>';

    $_variables = new AK_System_Variables();

    require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

    $mail = new PHPMailer();
    //$body = $this->params['text'];
    $body = eregi_replace("[\]",'',$body);

    $mail->From       = $this->params['email'];
    $mail->FromName   = $this->params['name'];
    $mail->Subject    = 'Заполнена форма заказа на анализ на сайте '.SITE_NAME.' ('.$_SERVER['SERVER_NAME'].')';

    $mail->AltBody = strip_tags(($body));
    $mail->MsgHTML($body);

    $mail->AddAddress($_variables->get('email_online'), "");
    if($mail->Send()) {
        $this->_redirect('/info/sentv/');

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
$this->view->fparams = $this->params;


//validate
function isCaptchaCodeNotValid($Values) {
    global $CAPTCHA_CONFIG;
    if ($Values === '') return true;

    $captcha = new b2evo_captcha($CAPTCHA_CONFIG);
    return ($captcha->validate_submit($Values['key'], $Values['userkey'])===0) ? true: false;
}

$currentInfo = new AK_Article_Item();
$currentInfo->loadByRewriteName('analiz');
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

<?php

require(LIBRARY_DIR.'/b2evo_captcha/b2evo_captcha.config.php');
require_once(LIBRARY_DIR.'/b2evo_captcha/b2evo_captcha.class.php');

$imgLoc = (isset($_SESSION['imgLoc'])) ? $_SESSION['imgLoc'] : null;
$captchaValues = (isset($imgLoc) && isset($this->params['verify_code'])) ? array('key' => $imgLoc, 'userkey' => $this->params['verify_code']):'';


$this->view->TITLE = 'Анкета';
$form = new AK_Form('contactForm', 'post', '/info/online/');




//$form->addRule('login',        'required',  'Ведите имя пользователя');
//$form->addRule('email',        'emptyemail',     'Введите правильный Email');
//$form->addRule('text',         'required',  'Введите текст сообщения');

$form->addRule('verify_code',  'required',  'Введите код подтверждения');
$form->addRule('verify_code',  'callback',  'Введите правильный код подтверждения', array('func' => 'isCaptchaCodeNotValid','params' =>$captchaValues));


if ($form->validate($this->params)) {



    $body='Заявка на перевозку груза прислана с сайта '.SITE_NAME.'<br><br>Название компании: '.$this->params['name'].'<br>Контактное лицо: '.$this->params['contactperson'].'<br>';
    $body.='Телефон: '.$this->params['phone'].'<br>';
    $body.='E-mail: '.$this->params['email'].'<br><br>';


    $body.='Способ доставки: '.$this->params['shiptype'].'<br>';

    $body.='Наименование груза (код ТНВЭД): '.$this->params['cargoname'].'<br>';
    $body.='АДР, класс: '.$this->params['adr'].'<br>';
    $body.='Вес груза (кг): '.$this->params['weight'].'<br>';
    $body.='Объем: '.$this->params['value'].'<br>';



    $body.='Страна(ы) загрузки: '.implode(', ',$this->params['source']).'<BR>';


    $body.='Город(а) загрузки: '.$this->params['sourcecity'].'<br><br>';
    $body.='Дата загрузки: '.$this->params['src_date'].'<br>';

    $body.='Страна разгрузки: '.$this->params['destcountry'].'<br>';

    $body.='Город разгрузки: '.$this->params['destcity'].'<br>';
    $body.='Дополнительная информация о перевозке: '.$this->params['note'].'<br><br>';
    $body.='<b>Дополнительные услуги:</b><br>';
    $body.='Таможенного оформления в стране отправления - '.(empty($this->params['add1'])?'Нет':'Да').'<br>';
    $body.='Таможенная очистка в стране назначения - '.(empty($this->params['add2'])?'Нет':'Да').'<br>';
    $body.='Страхование груза - '.(empty($this->params['add3'])?'Нет':'Да').'<br><br>';






    $_variables = new AK_System_Variables();

    require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

    $mail = new PHPMailer();
    //$body = $this->params['text'];
    $body = eregi_replace("[\]",'',$body);

    $mail->From       = $this->params['email'];
    $mail->FromName   = $this->params['name'];
    $mail->Subject    = 'Заполнена заявка на перевозку груза на сайте '.SITE_NAME.' ('.$_SERVER['SERVER_NAME'].')';

    //$mail->IsHTML(false);
    //$mail->Body = $body;
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


//validate
function isCaptchaCodeNotValid($Values) {
    global $CAPTCHA_CONFIG;
    if ($Values === '') return true;

    $captcha = new b2evo_captcha($CAPTCHA_CONFIG);
    return ($captcha->validate_submit($Values['key'], $Values['userkey'])===0) ? true: false;
}

$currentInfo = new AK_Article_Item();
$currentInfo->loadByRewriteName('onlinerequest');
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
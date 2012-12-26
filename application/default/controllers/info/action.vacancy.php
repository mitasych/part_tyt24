<?php
$formaction = isset($_POST['formaction'])?$_POST['formaction']:'';

$eduCount = isset($_POST['eduCount'])?$_POST['eduCount']:null;
$edu2Count = isset($_POST['edu2Count'])?$_POST['edu2Count']:null;
$workCount = isset($_POST['workCount'])?$_POST['workCount']:null; 
$langCount = isset($_POST['langCount'])?$_POST['langCount']:null; 
$pcexpCount = isset($_POST['pcexpCount'])?$_POST['pcexpCount']:null; 

if (!isset($eduCount)) {
        $eduCount = 1;
  }
  
    
  if (!isset($edu2Count)) {
        $edu2Count = 1;
  }
    
  if (!isset($workCount)) {
        $workCount = 1;
  }

  if (!isset($langCount)) {
        $langCount = 1;
  }
  if (!isset($pcexpCount)) {
        $pcexpCount = 0;
  }
 
  if ($formaction == "addEdu") {
        $eduCount++;
  }
  if ($formaction == "delEdu") {
        $eduCount--;
        if ($eduCount < 1) $eduCount = 1;
  }
  if ($formaction == "addEdu2") {
        $edu2Count++;
  }
  if ($formaction == "delEdu2") {
        $edu2Count--;
        if ($edu2Count < 1) $edu2Count = 1;
  }
  if ($formaction == "addWork") {
        $workCount++;
  }
  if ($formaction == "delWork") {
        $workCount--;
        if ($workCount < 1) $workCount = 1;
  }
  if ($formaction == "addLang") {
        $langCount++;
  }
  if ($formaction == "delLang") {
        $langCount--;
        if ($langCount < 1) $langCount = 1;
  }
  if ($formaction == "addPCExp") {
        $pcexpCount++;
  }
  if ($formaction == "delPCExp") {
        $pcexpCount--;
        if ($pxexpCount < 0) $pcexpCount = 0;
  }
  
  
   
  $mvar = $_POST;
  $mvar["date"] = date("d/m/Y", time());
  
  $this->view->mvar = $mvar;

  $this->view->eduCount = $eduCount;  
  $this->view->edu2Count = $edu2Count;
  $this->view->workCount = $workCount; 
  $this->view->langCount = $langCount; 
  $this->view->pcexpCount = $pcexpCount; 
  
  
  
require(LIBRARY_DIR.'/b2evo_captcha/b2evo_captcha.config.php');
require_once(LIBRARY_DIR.'/b2evo_captcha/b2evo_captcha.class.php');
$imgLoc = (isset($_SESSION['imgLoc'])) ? $_SESSION['imgLoc'] : null;
$captchaValues = (isset($imgLoc) && isset($this->params['verify_code'])) ? array('key' => $imgLoc, 'userkey' => $this->params['verify_code']):'';
$this->view->TITLE = 'Анкета кандидата';
$form = new AK_Form('vacancyForm', 'post', '/info/vacancy/');

$form->addRule('verify_code',  'required',  'Введите код подтверждения');
$form->addRule('verify_code',  'callback',  'Введите правильный код подтверждения', array('func' => 'isCaptchaCodeNotValid','params' =>$captchaValues));
    
if ($form->validate($this->params)){



$body='Анкета кандидата прислана с сайта '.SITE_NAME.'<br><br>Дата заполнения: '.$mvar["date"].'<br>Вакансия: '.$this->params['vacancy'].'<br>';
$body.='ФИО: '.$this->params['name'].'<br>';
$body.='Дата рождения: '.$this->params['birthdate'].'<br><br>';
$body.='Место прописки: '.$this->params['currentplace'].'<br><br>';
$body.='Адрес проживания: '.$this->params['address'].'<br><br>';
$body.='Семейное положение: '.$this->params['married'].'<br><br>';
$body.='Дети их возраст: '.$this->params['children'].'<br><br>';
$body.='Домашний телефон: '.$this->params['homephone'].'<br><br>';
$body.='Мобильный телефон: '.$this->params['cellphone'].'<br><br>';
$body.='E-mail: '.$this->params['email'].'<br><br>';


$body.='<br>Образование<br><br>';
foreach ($this->params['edu'] as $row) {
    $body.='Период обучения: '.$row['date'].'<br><br>';
    $body.='Название учреждения: '.$row['house'].'<br><br>';
    $body.='Специальность: '.$row['spec'].'<br><br>';
    $body.='Форма обучения: '.$row['type'].'<br><br>';
}
  
$body.='<br>Дополнительное образование, тренинги, семинары, курсы<br><br>';
foreach ($this->params['edu2'] as $row) {
    $body.='Период обучения: '.$row['date'].'<br><br>';
    $body.='Название учреждения: '.$row['house'].'<br><br>';
    $body.='Название курсов, семинаов, тренингов:'.$row['name'].'<br><br>';
}

$body.='<br>Опыт работы<br><br>';
foreach ($this->params['work'] as $row) {
    $body.='Название организации: '.$row['name'].'<br><br>';
    $body.='Период работы: '.$row['date'].'<br><br>';
    $body.='Должность: '.$row['title'].'<br><br>';
    $body.='Должностные обязанности: '.$row['desc'].'<br><br>';
}

$body.='<br>Владение иностранным языком<br><br>';
foreach ($this->params['lang'] as $row) {
    $body.='Название языка: '.$row['name'].'<br><br>';
    $body.='Степень владения: '.$row['level'].'<br><br>';
}

$body.='Компьютерные навыки: '.$this->params['knaviki'].'<br><br>';
$body.='Дополнительная информация: '.$this->params['note1'].'<br><br>';
$body.='Пожелания по оплате: '.$this->params['cost'].'<br><br>';
  
 
    
    $_variables = new AK_System_Variables();
    
    require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');
    $mail = new PHPMailer();
    //$body = $this->params['text'];
    $body = eregi_replace("[\]",'',$body);
    
    $mail->From       = $this->params['email'];
    $mail->FromName   = $this->params['name'];
    $mail->Subject    = 'Заполнена анкета кандидата на сайте '.SITE_NAME.' ('.$_SERVER['SERVER_NAME'].')';
    
    //$mail->IsHTML(false);
    //$mail->Body = $body;
    $mail->AltBody = strip_tags(($body));
    $mail->MsgHTML($body);
    
    $mail->AddAddress($_variables->get('email_online'), "");
    if($mail->Send()) {
        $this->_redirect('/info/sent/');
        
    }
} else {
    $this->params['verify_code'] = '';
    $form->setDefaults($this->params);
    $this->view->form = $form;
}
$captcha = new b2evo_captcha($CAPTCHA_CONFIG);
$imgLoc = $captcha->get_b2evo_captcha();
$_SESSION['imgLoc'] = $imgLoc;
$this->view->verifyImage = $imgLoc;
//validate
function isCaptchaCodeNotValid($Values)
{
    global $CAPTCHA_CONFIG;
    if ($Values === '') return true;
    $captcha = new b2evo_captcha($CAPTCHA_CONFIG);
    return ($captcha->validate_submit($Values['key'], $Values['userkey'])===0) ? true: false;
}

<?php

function isINNNotValid($Values) {
	
    if (AK_Order_Validate::CheckINN($Values)) {
        return false;
    }
    return true;
}

function genpass($number, $param = 1)
{
	$arr = array('a','b','c','d','e','f',
			'g','h','i','j','k','l',
			'm','n','o','p','r','s',
			't','u','v','x','y','z',
			'A','B','C','D','E','F',
			'G','H','I','J','K','L',
			'M','N','O','P','R','S',
			'T','U','V','X','Y','Z',
			'1','2','3','4','5','6',
			'7','8','9','0','.',',',
			'(',')','[',']','!','?',
			'&amp;','^','%','@','*','$',
			'&lt;','&gt;','/','|','+','-',
			'{','}','`','~');
	// Генерируем пароль
	$pass = "";
	for($i = 0; $i < $number; $i++)
	{
	if ($param>count($arr)-1)$param=count($arr) - 1;
	if ($param==1) $param=48;
	if ($param==2) $param=58;
	if ($param==3) $param=count($arr) - 1;
	// Вычисляем случайный индекс массива
	$index = rand(0, $param);
	$pass .= $arr[$index];
	}
	return $pass;
}

$statusList = AK_Enum_UserStatus::getList();
$genderList = AK_Enum_Gender::getList();
$fromList = AK_Enum_From::getList();

$captcha = AK_Captcha_Factory::getCaptcha(AK_Captcha_Enum::WAVE);
$captcha->setRequest($this->getRequest())->setKey('verify_code');

$form = new AK_Form('registrationForm', 'post', SITE_URL.'/registration/index/'); 

if (empty($this->params['status']) || !AK_Enum_UserStatus::isIn($this->params['status'])) {
    $form->addRule('custom1', 'required',  'Выберите статус');
}

$form->addRule('login',        'required',  'Введите имя пользователя');
$form->addRule('login',        'callback',  'Пользователь с таким именем уже существует', array('func' => 'AK_Order_Validate_Rules::loginExist', 'params' => isset($this->params['login']) ? $this->params['login'] : ''));
$form->addRule('pass',         'required',  'Введите пароль');
$form->addRule('pass_confirm', 'required',  'Введите подтверждение пароля');
$form->addRule('pass',         'compare',   'Подтверждение пароля не совпадает с паролем', array('rule' => '==', 'value' => isset($this->params['pass_confirm'])?$this->params['pass_confirm']:''));
$form->addRule('pass',         'minlength', 'Минимальная длина пароля 6 символов', array('min' => 6));

$form->addRule('name',        'required',  'Ведите имя');
$form->addRule('second_name',        'required',  'Ведите фамилию');
$form->addRule('third_name',        'required',  'Ведите отчество');




if (empty($this->params['gender']) || !AK_Enum_Gender::isIn($this->params['gender'])) {
    $form->addRule('custom2', 'required',  'Выберите пол');
}


if (!empty($this->params['status']) && $this->params['status'] == 2) {
    $form->addRule('organization', 'required',  'Введите Наименование организации');
    $form->addRule('innogrn', 'required',  'Введите ИНН/ОГРН');
    $form->addRule('position', 'required',  'Введите Должность');
	
	$form->addRule('innogrn',  'callback',  'Введите правильный ИНН', array('func' => 'isINNNotValid','params' =>$this->params['innogrn']));
}



if (!empty($this->params['status']) && $this->params['status'] == 3) {
    $form->addRule('innogrn2', 'required',  'Введите ИНН/ОГРН');
	$form->addRule('innogrn',  'callback',  'Введите правильный ИНН', array('func' => 'isINNNotValid','params' =>$this->params['innogrn']));
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
    $form->addRule('dn', 'required',  'Введите основание');
    $form->addRule('dot', 'required',  'Введите дату');
    $form->addRule('uraddress', 'required',  'Введите юридический адрес');
}

//if (!empty($this->params['akt_notify_flag']) && !empty($this->params['status']) && $this->params['status'] != 1 ) {
//    $form->addRule('akt_email', 'required',  'Введите email');
//}

$form->addRule('email',        'required',  'Введите Email');
$form->addRule('email',        'email',     'Введите правильный Email');
$form->addRule('email',        'callback',  'Введенный Email уже существует', array('func' => 'AK_Order_Validate_Rules::emailExist', 'params' => isset($this->params['email']) ? $this->params['email'] : ''));

$form->addRule('verify_code',  'required',  'Введите код подтверждения');
$form->addRule( 'verify_code',  
    'callback',
    'Введите правильный код подтверждения',
    array( 'func' => 'AK_Order_Validate_Rules::isCaptchaCodeNotValid',
    'params' => $captcha
    )
);


if ($form->validate($this->params)) {
	
    $captcha->clear();

    $user = new AK_Order_User();

    $pass_sip = $this->genpass(6, 1); // генерирует пароль из 6 символов содержащий буквы в верхнем и нижнем регистре
    //genpass(10, 2); // генерирует пароль из 10 символов содержащий буквы в верхнем и нижнем регистре, а также цифры от 0 до 9
    //genpass(10, 3); // генерирует пароль из 10 символов содержащий буквы в верхнем и нижнем регистре, цифры от 0 до 9 и все спец. символы. Пароль получится реально сложным)
    
    $user->setLogin($this->params['login'])
        ->setName($this->params['name'])
        ->setSecondName($this->params['second_name'])
        ->setThirdName($this->params['third_name'])
        ->setGender($this->params['gender'])
        ->setFrom($this->params['from'])
        ->setPassword(md5($this->params['pass']))
        ->setEmail($this->params['email'])
        ->setCreateDate(time());
    $user->subscribeFlag = empty($this->params['subscribe_flag'])?0:1;
    $user->vipiskaNotifyFlag = empty($this->params['vipiska_notify_flag'])?0:1;
  //  $user->vipiskaEmail = ' ';
    $user->dogovorNotifyFlag = empty($this->params['dogovor_notify_flag'])?0:1;
    $user->aktNotifyFlag = empty($this->params['akt_notify_flag'])?0:1;
    $user->phone = empty($this->params['phone'])?'':$this->params['phone'];
    $user->status = $this->params['status'];
    $user->site = SITE_URL;


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


    $user->dn = empty($this->params['dn'])?'':$this->params['dn'];
    $user->dot = empty($this->params['dot'])?'':$this->params['dot'];
    $user->akt_email = empty($this->params['akt_email'])?'':$this->params['akt_email'];
	
    $user->country = intval($this->params['country']);
    $user->password_sip = $pass_sip;

    $flag = $user->save();
    if ($flag == 1){
    	$id_lost = $user->getLostId();
    }
    
    //данные для BASIC авторизации
    $login = "admin";
    $password = "09FreeBSD09";
    
    $data_user = array('tech' => 'sip',
			    		'extension' => $id_lost,
			    		'name' => $this->params['login'],
            			'devinfo_secret' => $pass_sip
    );
    
    $post_data = http_build_query($data_user);
    
    
    //$url = "https://89.169.45.200/file.php?tech=sip&extension=$id_lost&name=".$this->params['login']."&devinfo_secret=".$this->params['pass'];
    $url = "https://89.169.45.200/file.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER,1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
    curl_setopt($ch, CURLOPT_VERBOSE,1);
    
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch,CURLOPT_USERPWD,$login . ":" . $password);
    $result = curl_exec($ch);

    if ($result === FALSE)
    {
    	echo "cURL Error: " . curl_error($ch);
    }
    curl_close($ch);
    //ERROR: this state should not exist

    $body='Здравствуйте, '.$this->params['second_name'].' '.$this->params['name'].' '.$this->params['third_name'].'!<br>';
    $body.='Вы зарегистрировались в информационно-справочной системе '.SITE_NAME.'.<br><br>';
    $body.='Логин: '.$this->params['login'].'<br>';
    $body.='Пароль: '.$this->params['pass'].'<br><br>';
    $body.='Приятной работы с нашей системой.<br><br>';
    $body.='С уважением,<br>';
    $body.=SITE_NAME;

    $_variables = new AK_System_Variables();

    require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

    $mail = new PHPMailer();
    $body = eregi_replace("[\]",'',$body);

    $mail->From       = $_variables->get('email_online');
    $mail->FromName   = 'Администрация сайта '.SITE_NAME;
    $mail->Subject    = 'Регистрация на сайте '.SITE_NAME;

    $mail->AltBody = strip_tags(($body));
    $mail->MsgHTML($body);

    $mail->AddAddress($this->params['email'], $this->params['second_name'].' '.$this->params['name'].' '.$this->params['third_name']);
    $mail->Send();


    $this->_redirect(SITE_URL.'/registration/completed/');
}
else {

    $this->params['verify_code'] = '';
    $form->setDefaults($this->params);
    $this->view->form = $form;
}

$this->view->verifyImage = $captcha->generateImage();

$this->view->statusList = $statusList;
$this->view->genderList = $genderList;
$this->view->fromList = $fromList;
$this->view->fparams = $this->params;
$this->view->time = time();

$countryList = new AK_Location_Country_List();
//$countryList->returnAsAssoc()->setAssocKey('A.id')->setOrder('A.name ASC')->addWhere('A.register_list = 1');

$this->view->countriesList = $countryList->getList();


//$db2 = Zend_Registry::get('DBTYT24');
$query = $this->_db->select();
$query->from('subregions AS A', 'A.*');
$regionList = $this->_db->fetchAll($query);

//Zend_Debug::dump($regionList);
$this->view->regionList = $regionList;



$query = $this->_db->select();
$query->from("source AS A",'A.*');
$sourceList = $this->_db->fetchAll($query);

$this->view->sourceList = $sourceList;
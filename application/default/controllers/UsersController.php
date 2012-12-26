<?php

class Option {
  public $number;
  public $text;
}

class UsersController extends AK_Controller_Action {
    public $currentUser;
    public $params;
    public function __construct (Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);
        $this->params = $this->_getAllParams();
        $this->currentUser = $this->_user;

        $this->view->currentUser = $this->currentUser;

    }
	
	/**
	* @author voodoo
	*/
    public function ordersAction () {
        
        if (!$this->currentUser->getLogin() ) {
            $this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            $this->_redirect(SITE_URL);
        }

        $this->params['page'] = empty($this->params['page'])?1:intval($this->params['page']);
        
        //var_dump($_POST);
        if (isset($_POST['sort']))		
         $sort_type=$_POST['sort'];
        if (isset($_POST['id_order']) && is_numeric($_POST['id_order']))		
         $id_order=$_POST['id_order'];
		else		
         $id_order='';
			

        if ($this->getRequest()->isXmlHttpRequest()) {

            if (isset($_REQUEST['id_sort_Servise']))     
                $sort_service=$_REQUEST['id_sort_Servise']; 
            if (!isset($sort_service) || $sort_service =="5")
                $sort_service='';  

            if (isset($_REQUEST['id_sort_Status']))     
                $sort_status=$_REQUEST['id_sort_Status']; 
            if (!isset($sort_status) || $sort_status =="5")
                $sort_status='';  

            if (isset($_REQUEST['id_sort_Plateji']))     
                $sort_Plateji=$_REQUEST['id_sort_Plateji']; 

            if(empty($sort_Plateji))
                $to = '';
            elseif ($sort_Plateji == 2)
                $to = 'minus';
            elseif($sort_Plateji == 3)
                $to = 'plus';
            else
                $to = '';

         

        } else {
            $sort_status=''; 
            $sort_service='';
            $sort_Plateji='';
            if(empty($this->params['to']))
                $to = '';
            elseif ($this->params['to'] == 1)
                $to = 'minus';
            elseif($this->params['to'] == 2)
                $to = 'plus';
            else
                $to = '';
        }



        if (isset($_POST['sort_type']))     
         $sort_type=$_POST['sort_type'];         
        isset($sort_type)?$sort_type_value = $sort_type:$sort_type_value = 5;
        if (!isset($sort_type))
         $sort_type='';

     
		if (isset($_POST['select_ord'])){	
         $select_ord_value=$_POST['select_ord'];
        } else {
            $select_ord_value = "";
        }
		 
		if (isset($_POST['id_order'])){		
         $id_order_value=$_POST['id_order'];
        } else {
            $id_order_value = "";
        }
		
		if (!isset($sort_type))
		 $sort_type='';
		//else
		// $sort_type=substr($sort_type,4);
		//var_dump($sort_type);

        $orders_all = $this->_user->getOrders($to,$sort_status, $id_order);

        if (!empty($sort_service))  {
            $orders = $this->_user->getOrdersService($orders_all, $sort_service);
        } else {
            $orders = $orders_all;
        }

		
        $url = '/users/orders/userid/'.$this->_user->id;
		    		
		if(!empty($this->params['to']))
			if ($this->params['to'] == 1)
				$url .= '/to/1';
			elseif($this->params['to'] == 2)
				$url .= '/to/2';
        $P = new AK_Common_Paging(count($orders), 20, $url);
        $this->view->paging = $P->makePaging($this->params['page']);
        $this->view->orders = array_slice($orders, 20*($this->params['page']-1), 20);
		
        $servis = array();
        // поле сервіс - для select
        foreach ($orders as $order2) {
            $servise=$order2->getServisSelect();
            if (!in_array($servise,$servis))
               $servis[]=$servise;
        }




        $types=$this->checkOptions($orders);
		$this->view->types=$types;
        //var_dump($orders);
        //$servis=$this->checkService($orders);        
        $this->view->servis=$servis;
        $this->view->sort_type_value=$sort_type_value;
        $this->view->select_ord_value=$select_ord_value;
        $this->view->id_order_value=$id_order;
        $this->view->sort_servicee=$sort_service;  
        $this->view->sort_statuse=$sort_status;    
        $this->view->sort_Plateji_val=$sort_Plateji;                
        $this->view->selected=$sort_type;
 

		//Zend_Debug::dump($types);exit();
	
    }
    public function docsAction () {
        if (!$this->currentUser->getLogin() ) {
            $this->_redirect(SITE_URL);
        }
		//Zend_Debug::dump("if1went");
		if(isset($_POST))
		{
			//Zend_Debug::dump("send_user or ..");exit();
			$act1 = empty($_POST['send_user'])?0:1;
			$act2 = empty($_POST['send_kurator'])?0:1;
			//print $act1.'='.$act2;
			$this->_user->akt_send_email = $act1;
			$this->_user->akt_send_kurator = $act2;
			$this->_user->save();
		}
		//Zend_Debug::dump("if2went");
        if ($this->currentUser->id != $this->_user->id ) {
			//Zend_Debug::dump("if3inside");
            $this->_redirect(SITE_URL);
        }
		//Zend_Debug::dump("if3went");
        $this->params['page'] = empty($this->params['page'])?1:intval($this->params['page']);
        
        //var_dump($_POST);
        if (isset($_POST['sort']))		
         $sort_type=$_POST['sort'];
        if (isset($_POST['id_order']) && is_numeric($_POST['id_order']))		
         $id_order=$_POST['id_order'];
		else		
         $id_order='';
			
		//else
		// $sort_type=substr($sort_type,4);
		//var_dump($sort_type);
		//Zend_Debug::dump("ifsortwent"); 
		
		$to = empty($this->params['to'])?0:$this->params['to'];
		//Zend_Debug::dump($to); //Zend_Debug::dump($sort_type); //Zend_Debug::dump($id_order); 
        $orders = $this->_user->getDoc($to,$sort_type, $id_order); //тут ошибка
		//Zend_Debug::dump("after ordera");	exit();  
        $url = '/users/orders/userid/'.$this->_user->id;
		//Zend_Debug::dump("after url"); 		
		if(!empty($this->params['to']))
			if ($this->params['to'] == 1)
				$url .= '/to/1';
			elseif($this->params['to'] == 2)
				$url .= '/to/2';
		//Zend_Debug::dump("after if url");  
			
        $P = new AK_Common_Paging(count($orders), 20, $url);
        $this->view->paging = $P->makePaging($this->params['page']);
        $this->view->orders = array_slice($orders, 20*($this->params['page']-1), 20);
		
		//Zend_Debug::dump("before_order");

		$status_list = AK_Order_ZakazTypes::getList();
        $types=$this->checkOptions($status_list);
		$this->view->types=$types;
		$this->view->to=empty($this->params['to'])?0:$this->params['to'];
		$this->view->selected=$sort_type;
		$this->view->user=$this->_user;
		//Zend_Debug::dump($types);exit();
	
    }
	
	/**
	* @author voodoo
	*/	

    private function checkOptions($orders) {
        $status_list = AK_Order_ZakazStatus::getList();
        $types=array();
        $return=array();    
         

        foreach ($orders as $order) {
            $status=$order->status;
            if (!in_array($status,$types))
               $types[]=$status;
        }

        $count=count($types);
        // foreach ($i=0;$i<$count;$i++) {
        foreach ($types as $key=>$item) {
            if(!empty($item)){
                $o= new Option();
                $o->number=$item;
                $o->text=$status_list[$item];
                $return[]=$o;     
            }
        }
        //var_dump($types);
        return $return;   
    }
    

    public function ordersmAction () {
        if (!$this->currentUser->getLogin() ) {
            $this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            $this->_redirect(SITE_URL);
        }

        $this->params['page'] = empty($this->params['page'])?1:intval($this->params['page']);

        $orders = $this->_user->getOrders('minus');

        $url = '/users/ordersm/userid/'.$this->_user->id;
        $P = new AK_Common_Paging(count($orders), 20, $url);
        $this->view->paging = $P->makePaging($this->params['page']);
        $this->view->orders = array_slice($orders, $this->params['page']*($this->params['page']-1), 20);
    }

    public function orderspAction () {
        if (!$this->currentUser->getLogin() ) {
            $this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            $this->_redirect(SITE_URL);
        }

        $this->params['page'] = empty($this->params['page'])?1:intval($this->params['page']);

        $orders = $this->_user->getOrders('plus');

        $url = '/users/ordersp/userid/'.$this->_user->id;
        $P = new AK_Common_Paging(count($orders), 20, $url);
        $this->view->paging = $P->makePaging($this->params['page']);
        $this->view->orders = array_slice($orders, $this->params['page']*($this->params['page']-1), 20);
    }

    public function platejiAction () {
        if (!$this->currentUser->getLogin() ) {
            $this->_redirect(SITE_URL);
        }


        if ($this->getRequest()->isXmlHttpRequest()) {

            if (isset($_REQUEST['id_sort_Servise']))     
                $sort_service=$_REQUEST['id_sort_Servise']; 
            if (!isset($sort_service) || $sort_service =="5")
                $sort_service='';  

            if (isset($_REQUEST['id_sort_Status']))     
                $sort_status=$_REQUEST['id_sort_Status']; 
            if (!isset($sort_status) || $sort_status =="5")
                $sort_status='';  

            if (isset($_REQUEST['id_sort_Plateji']))     
                $sort_Plateji=$_REQUEST['id_sort_Plateji']; 

            if(empty($sort_Plateji))
                $to = '';
            elseif ($sort_Plateji == 2)
                $to = 'minus';
            elseif($sort_Plateji == 3)
                $to = 'plus';
            else
                $to = '';

        } else {
            $sort_status=''; 
            $sort_service='';
            $sort_Plateji='';
            if(empty($this->params['to']))
                $to = '';
            elseif ($this->params['to'] == 1)
                $to = 'minus';
            elseif($this->params['to'] == 2)
                $to = 'plus';
            else
                $to = '';
        }


        if ($this->currentUser->id != $this->_user->id ) {
            $this->_redirect(SITE_URL);
        }
		
        if (isset($_POST['sort']))		
         $sort_type=$_POST['sort'];
        if (isset($_POST['id_order']) && is_numeric($_POST['id_order']))		
         $id_order=$_POST['id_order'];
		else		
         $id_order='';
        if (isset($_POST['select_ord'])){       
         $select_ord_value=$_POST['select_ord'];
        } else {
            $select_ord_value = "";
        }
		 
        if (isset($_POST['sort_type']))		
         $sort_type=$_POST['sort_type'];		 
		isset($sort_type)?$sort_type_value = $sort_type:$sort_type_value = 5;
		if (!isset($sort_type))
		 $sort_type='';
		//else
		// $sort_type=substr($sort_type,4);
		//var_dump($sort_type);
		if ($sort_type=='5' || $sort_type=='3')
		  $sort_type='';      
        $this->params['page'] = empty($this->params['page'])?1:intval($this->params['page']);
      		

        $orders_all = $this->_user->getOrders($to,$sort_status, $id_order);

        if (!empty($sort_service))  {
            $orders = $this->_user->getOrdersService($orders_all, $sort_service);
        } else {
            $orders = $orders_all;
        }
        

        $servis = array();
        // поле сервіс - для select
        foreach ($orders as $order2) {
            $servise=$order2->getServisSelect();
            if (!in_array($servise,$servis))
               $servis[]=$servise;
        }


        //фильтруэм заказы
     

        if($to =="plus"){
            foreach ($orders as $item) {
                if($item->status == 140 && $item->status != 130 && $item->status != 60 && $item->status != 20){
                    $orders[] = $item;
                }            
            }   
        } 
        else 
        {
            if($to =="minus"){
                foreach ($orders as $item) {
                        if($item->isBalans() != 11 && $item->status != 140 && $item->status != 130 && $item->status != 60 && $item->status != 20){
                        $orders[] = $item;
                    }            
                }  
            }
            else
            {
                foreach ($orders as $item) {
                    if($item->status != 130 && $item->status != 60 && $item->status != 20){
                        $orders[] = $item;
                    }            
                }   
            }
        }

        $url = '/users/plateji/userid/'.$this->_user->id;
		
		if(!empty($sort_Plateji))
			if ($sort_Plateji == 2)
				$url .= '/to/1';
			elseif($sort_Plateji == 3)
				$url .= '/to/2';

        $P = new AK_Common_Paging(count($orders), 20, $url);
        $types=$this->checkOptions($orders);
		$this->view->types=$types;
        $this->view->paging = $P->makePaging($this->params['page']);
        $this->view->orders = array_slice($orders, $this->params['page']*($this->params['page']-1), 20);
        $this->view->servis=$servis;
		$this->view->sort_type_value=$sort_type_value;
		$this->view->select_ord_value=$select_ord_value;
		$this->view->id_order_value=$id_order;
        $this->view->sort_servicee=$sort_service;  
        $this->view->sort_statuse=$sort_status;    
        $this->view->sort_Plateji_val=$sort_Plateji;                
		$this->view->selected=$sort_type;
    }

    public function platejipAction () {
        if (!$this->currentUser->getLogin() ) {
            $this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            $this->_redirect(SITE_URL);
        }

        $this->params['page'] = empty($this->params['page'])?1:intval($this->params['page']);

        $orders = $this->_user->getPayedOrders('plus');

        $url = '/users/platejip/userid/'.$this->_user->id;
        $P = new AK_Common_Paging(count($orders), 20, $url);
        $this->view->paging = $P->makePaging($this->params['page']);
        $this->view->orders = array_slice($orders, $this->params['page']*($this->params['page']-1), 20);
    }

    public function platejimAction () {
        if (!$this->currentUser->getLogin() ) {
            $this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            $this->_redirect(SITE_URL);
        }

        $this->params['page'] = empty($this->params['page'])?1:intval($this->params['page']);

        $orders = $this->_user->getPayedOrders('minus');

        $url = '/users/platejim/userid/'.$this->_user->id;
        $P = new AK_Common_Paging(count($orders), 20, $url);
        $this->view->paging = $P->makePaging($this->params['page']);
        $this->view->orders = array_slice($orders, $this->params['page']*($this->params['page']-1), 20);
    }

    public function logAction () {
		
		$user = new AK_Order_User('login', $this->params['login']);
		//print_r($user);
		if (!empty($user->id))
			if ($user->sckode == $this->params['sc'] && !empty($user->sckode) && $user->end_mon_demo > mktime())
				$user->authenticate();
				
        $this->_redirect(SITE_URL.'/users/profile/');
	
	}
    public function profileAction () {
        if (!$this->currentUser->getLogin() ) {
            $this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            $this->_redirect(SITE_URL);
        }

        if (!empty($_SESSION['mess'])) {
            $this->view->mess = $_SESSION['mess'];
            $_SESSION['mess'] = '';
        }
        //settings
        $form = new AK_Form('editForm', 'post', SITE_URL.'/users/profile/');

        if ($form->validate($this->params)) {

            $monitoring = $this->_user->useMonitoring;

            $this->_user->useBase = empty($this->params['use_base'])?0:1;
            $this->_user->useMonitoring = empty($this->params['use_monitoring'])?0:1;
            $this->_user->useReport = empty($this->params['use_report'])?0:1;
            $this->_user->useVed = empty($this->params['use_ved'])?0:1;
            
            $this->_user->save();

            // запрос на мониторинг 
		    //
			
			
            if ($monitoring == 0 && $this->_user->useMonitoring == 1 && !empty($this->params['monitoring_send_request'])) {
				$_variables = new AK_System_Variables();               
				$this->_user->mon_demo = 1;
                $this->_user->end_mon_demo = mktime(0,0,0,date('m'), date('d')+$_variables->get('demotime'), date('Y'));
				$sckode = md5(rand());
				$beg = rand(0,14);
				$sckode = substr($sckode, $beg, rand($beg+1,16)); 
				$sckode = md5($sckode);
				$this->_user->sckode = $sckode;
				$this->_user->save();
				
				$body='Здравствуйте, '.$this->_user->secondName.' '.$this->_user->name.' '.$this->_user->thirdName.'!<br>';
                $body.='Вы активировали услугу мониторинга в информационно-справочной системе '.SITE_NAME.'.<br><br>';
                $body.='Для работы с системой перейдите по <a href="'.SITE_URL.'/users/log/login/'.$this->_user->login.'/sc/'.$this->_user->sckode.'">ссылке</a><br><br>';
                $body.='С уважением,<br>';
                $body.=SITE_NAME;

                

                require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

				// мэйл юзеру
                $mail = new PHPMailer();
                $body = eregi_replace("[\]",'',$body);

                $mail->From       = $_variables->get('email_online');
                $mail->FromName   = 'Администрация сайта '.SITE_NAME;
                $mail->Subject    = 'Активация услуги мониторинга на сайте '.SITE_NAME;

                $mail->AltBody = strip_tags(($body));
                $mail->MsgHTML($body);

                $mail->AddAddress($this->_user->email, $this->_user->secondName.' '.$this->_user->name.' '.$this->_user->thirdName);
                $mail->Send();
				
                $_SESSION['mess'] = 'Запрос на активизацию услуги Мониторинг отправлен Администратору';				
            }

            $this->_redirect(SITE_URL.'/users/profile/');
        }
        else {

            if (!$form->isPostback()) {
                $this->params['use_base'] = $this->_user->useBase;
                $this->params['use_monitoring'] = $this->_user->useMonitoring;
                $this->params['use_report'] = $this->_user->useReport;
                $this->params['use_ved'] = $this->_user->useVed;
            }
            $form->setDefaults($this->params);
            $this->view->form = $form;
        }

        $this->view->fparams = $this->params;


    }
    public function loginAction () {
        include_once ('users/action.login.php');
    }
    public function logoutAction () {
        include_once ('users/action.logout.php');
    }
    public function editprofileAction () {
        include_once ('users/profile/action.edit.php');
    }
	
    public function aktAction () {
        include_once ('users/action.akt.php');
    }
	
    public function schetAction () {
        include_once ('users/action.schet.php');
    }
	
    public function aktsendAction () {
        include_once ('users/action.aktsend.php');
    }
    
    public function subUsersAction()
    {
    	$title = "Пользователи";
    	$this->view->title = $title;
    	
    	$this->view->user=$this->_user;
    	
    	$parent_id = $this->_user->id;
    	
    	$db2 = Zend_Registry::get('DBORDER');
		$query = $db2->select();
		$query->from('orders_users__accounts AS U', 'U.*')->where('`parent_user`=?', $parent_id);
		$sub_users = $db2->fetchAll($query);
		$this->view->sub_users = $sub_users;
    }
    
    public function addsubUsersAction()
    {
    	function isINNNotValid($Values) {
    	
    		if (AK_Order_Validate::CheckINN($Values)) {
    			return false;
    		}
    		return true;
    	}
    	
    	$title = "Добавление";
    	$this->view->title = $title;
    	
    	$form = new AK_Form('registrationForm', 'post', SITE_URL.'/users/addsub-users/');
    	
    	$form->addRule('login',        'required',  'Введите имя пользователя');
    	$form->addRule('login',        'callback',  'Пользователь с таким именем уже существует', array('func' => 'AK_Order_Validate_Rules::loginExist', 'params' => isset($this->params['login']) ? $this->params['login'] : ''));
    	$form->addRule('pass',         'required',  'Введите пароль');
    	$form->addRule('pass_confirm', 'required',  'Введите подтверждение пароля');
    	$form->addRule('pass',         'compare',   'Подтверждение пароля не совпадает с паролем', array('rule' => '==', 'value' => isset($this->params['pass_confirm'])?$this->params['pass_confirm']:''));
    	$form->addRule('pass',         'minlength', 'Минимальная длина пароля 6 символов', array('min' => 6));
    	
    	$form->addRule('name',        'required',  'Ведите имя');
    	$form->addRule('second_name',        'required',  'Ведите фамилию');
    	$form->addRule('third_name',        'required',  'Ведите отчество');
		
		$form->addRule('email',        'required',  'Введите Email');
		$form->addRule('email',        'email',     'Введите правильный Email');
		$form->addRule('email',        'callback',  'Введенный Email уже существует', array('func' => 'AK_Order_Validate_Rules::emailExist', 'params' => isset($this->params['email']) ? $this->params['email'] : ''));
		//Zend_Debug::dump($this->params);
		if ($form->validate($this->params)) {
			
		    $user = new AK_Order_User();
		
		    $pass_sip = $this->genpass(6, 1); // генерирует пароль из 6 символов содержащий буквы в верхнем и нижнем регистре
		    //genpass(10, 2); // генерирует пароль из 10 символов содержащий буквы в верхнем и нижнем регистре, а также цифры от 0 до 9
		    //genpass(10, 3); // генерирует пароль из 10 символов содержащий буквы в верхнем и нижнем регистре, цифры от 0 до 9 и все спец. символы. Пароль получится реально сложным)
		    
		    $user->setLogin($this->params['login'])
		        ->setName($this->params['name'])
		        ->setSecondName($this->params['second_name'])
		        ->setThirdName($this->params['third_name'])
		        ->setPassword(md5($this->params['pass']))
		        ->setEmail($this->params['email'])
		        ->setCreateDate(time());
		    $user->phone = empty($this->params['phone'])?'':$this->params['phone'];
		    $user->status = empty($this->params['status'])?1:$this->params['status'];
		    $user->site = SITE_URL;
		
		    $user->organization = $this->_user->organization;
		    $user->innogrn = $this->_user->innogrn;
		    $user->innogrn2 = $this->_user->innogrn2;
		
		    $user->parent_user = $this->_user->id;
		    $user->password_sip = $pass_sip;
		
		    $flag = $user->save();
		    if ($flag == 1){
		    	$id_lost = $user->getLostId();
		    }
		    
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
		
		
		    $this->_redirect(SITE_URL.'/users/sub-users/');
		}
		else {
		    $form->setDefaults($this->params);
		    $this->view->form = $form;
		}
		
		$this->view->fparams = $this->params;
		$this->view->time = time();
    }
    
    public function editsubUsersAction()
    {
    	$title = "Редактирование";
    	$this->view->title = $title;
    	
    	function isINNNotValid($Values) {
    		 
    		if (AK_Order_Validate::CheckINN($Values)) {
    			return false;
    		}
    		return true;
    	}
    	 
    	$statusList = AK_Enum_UserStatus::getList();
    	$genderList = AK_Enum_Gender::getList();
    	$fromList = AK_Enum_From::getList();
    	 
    	$form = new AK_Form('registrationForm', 'post', SITE_URL.'/users/editsub-users/');
    	 
    	if (!empty($this->params['newpass'])) {
    		$form->addRule('newpassc', 'required',  'Введите подтверждение пароля');
    		if (!empty($this->params['newpassc']) && $this->params['newpass'] != $this->params['newpassc']) {
    			$form->addRule('newpasscc', 'required',  'Введенные пароли не совпадают');
    		}
    	}
    	    	 
    	$form->addRule('name',        'required',  'Ведите имя');
    	$form->addRule('second_name',        'required',  'Ведите фамилию');
    	$form->addRule('third_name',        'required',  'Ведите отчество');
    	 
    	$form->addRule('email',        'required',  'Введите Email');
    	$form->addRule('email',        'email',     'Введите правильный Email');
    	$form->addRule('email',        'callback',  'Введенный Email уже существует', array('func' => 'emailExist2', 'params' => array('email' => isset($this->params['email']) ? $this->params['email'] : '', 'user_id' => $this->params['subid'] ) ) );
    	//Zend_Debug::dump($this->params);
    	if ($form->validate($this->params)) {
    		print_r($this->params['sub_id']);	
    		$user = new AK_Order_User('id', $this->params['sub_id']);
    	
    		    $user->setName($this->params['name'])
		        ->setSecondName($this->params['second_name'])
		        ->setThirdName($this->params['third_name'])
		        ->setEmail($this->params['email']);
		    $user->phone = empty($this->params['phone'])?'':$this->params['phone'];
		
		    if (!empty($this->params['newpass'])) {
		        $user->setPassword(md5($this->params['newpass']));
		    }
		
		    $user->save();
    	
    		$this->_redirect(SITE_URL.'/users/sub-users/');
    	}
    	else {
    	    $sub_id = $this->params['subid'];
    	    $this->view->sub_id = $sub_id;
    	    
    	    $db2 = Zend_Registry::get('DBORDER');
    	    $query = $db2->select();
    	    $query->from('orders_users__accounts AS U', 'U.*')->where('`id`=?', $sub_id);
    	    $sub_user = $db2->fetchAll($query);
    	    //Zend_Debug::dump($sub_user);
    	    $this->view->sub_user = $sub_user;
    		
		    $form->setDefaults($this->params);
		    $this->view->form = $form;
    	}
    	
    	$this->view->statusList = $statusList;
    	$this->view->genderList = $genderList;
    	$this->view->fromList = $fromList;
    	$this->view->fparams = $this->params;
    	$this->view->time = time();
    	
    function emailExist2($params) {
        $email = $params['email'];
        $user_id = $params['user_id'];

        $_db = Zend_Registry :: get('DBORDER');

        $where = $_db->quoteInto("email = ? AND id <> '$user_id'", $email);
        $sql = $_db->select()->from('orders_users__accounts', 'id')->where($where);
        return $_db->fetchOne($sql) ? true : false;
    }
    	 
    }
    
    public function deletesubUsersAction()
    {
        $sub_id = $this->params['subid'];
        $user = new AK_Order_User('id', $sub_id);
        $user->delete();
        
        $this->_redirect(SITE_URL.'/users/sub-users/');
    }
    
    private function genpass($number, $param = 1)
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
}

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
            //$this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
           // $this->_redirect(SITE_URL);
        }

        $this->params['page'] = empty($this->params['page'])?1:intval($this->params['page']);
        
        //var_dump($_POST);
        if (isset($_POST['sort']))		
         $sort_type=$_POST['sort'];
        if (isset($_POST['id_order']) && is_numeric($_POST['id_order']))		
         $id_order=$_POST['id_order'];
		else		
         $id_order='';
			
        if (isset($_POST['sort_type']))		
         $sort_type=$_POST['sort_type'];		 
		
		if (!isset($sort_type))
		 $sort_type='';
		//else
		// $sort_type=substr($sort_type,4);
		//var_dump($sort_type);
		if ($sort_type=='5')
		  $sort_type='';        		
		if(empty($this->params['to']))
			$to = '';
		elseif ($this->params['to'] == 1)
			$to = 'minus';
		elseif($this->params['to'] == 2)
			$to = 'plus';
		else
			$to = '';
        $orders = $this->_user->getOrders($to,$sort_type, $id_order);
		
        $url = '/users/orders/userid/'.$this->_user->id;
		    		
		if(!empty($this->params['to']))
			if ($this->params['to'] == 1)
				$url .= '/to/1';
			elseif($this->params['to'] == 2)
				$url .= '/to/2';
			
        $P = new AK_Common_Paging(count($orders), 20, $url);
        $this->view->paging = $P->makePaging($this->params['page']);
        $this->view->orders = array_slice($orders, 20*($this->params['page']-1), 20);
		
		$status_list = AK_Order_ZakazStatus::getList();
        $types=$this->checkOptions($status_list);
		$this->view->types=$types;
		$this->view->selected=$sort_type;
		Zend_Debug::dump($types);exit();
	
    }
    public function docsAction () {
        if (!$this->currentUser->getLogin() ) {
            //$this->_redirect(SITE_URL);
			$this->_redirect("getLogin");
        }
		if(!empty($_POST['akt']))
		{
			$act1 = empty($_POST['send_user'])?0:1;
			$act2 = empty($_POST['send_kurator'])?0:1;
			//print $act1.'='.$act2;
			$this->_user->akt_send_email = $act1;
			$this->_user->akt_send_kurator = $act2;
			$this->_user->save();
			$this->_redirect("akt");
		}
        if ($this->currentUser->id != $this->_user->id ) {
            //$this->_redirect(SITE_URL);
			$this->_redirect("currId");
        }

        $this->params['page'] = empty($this->params['page'])?1:intval($this->params['page']);
        
        //var_dump($_POST);
        if (isset($_POST['sort']))		
         $sort_type=$_POST['sort'];
        if (isset($_POST['id_order']) && is_numeric($_POST['id_order']))		
         $id_order=$_POST['id_order'];
		else		
         $id_order='';
			
        if (isset($_POST['sort_type']))		
         $sort_type=$_POST['sort_type'];		 
		
		if (!isset($sort_type))
		 $sort_type='';
		//else
		// $sort_type=substr($sort_type,4);
		//var_dump($sort_type);
		
		$to = empty($this->params['to'])?0:$this->params['to'];
        $orders = $this->_user->getDoc($to,$sort_type, $id_order);
		
        $url = '/users/orders/userid/'.$this->_user->id;
		    		
		if(!empty($this->params['to']))
			if ($this->params['to'] == 1)
				$url .= '/to/1';
			elseif($this->params['to'] == 2)
				$url .= '/to/2';
			
        $P = new AK_Common_Paging(count($orders), 20, $url);
        $this->view->paging = $P->makePaging($this->params['page']);
        $this->view->orders = array_slice($orders, 20*($this->params['page']-1), 20);
		
		$status_list = AK_Order_ZakazStatus::getList();
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
	private function checkOptions($status_list) {
    $orders = $this->_user->getOrders('','');
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
   	 return $return;	  
	}
	


    public function ordersmAction () {
        if (!$this->currentUser->getLogin() ) {
            //$this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            //$this->_redirect(SITE_URL);
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
            //$this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            //$this->_redirect(SITE_URL);
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
            //$this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            //$this->_redirect(SITE_URL);
        }
		
        if (isset($_POST['sort']))		
         $sort_type=$_POST['sort'];
        if (isset($_POST['id_order']) && is_numeric($_POST['id_order']))		
         $id_order=$_POST['id_order'];
		else		
         $id_order='';
			
        if (isset($_POST['sort_type']))		
         $sort_type=$_POST['sort_type'];		 
		
		if (!isset($sort_type))
		 $sort_type='';
		//else
		// $sort_type=substr($sort_type,4);
		//var_dump($sort_type);
		if ($sort_type=='5')
		  $sort_type='';      
        $this->params['page'] = empty($this->params['page'])?1:intval($this->params['page']);
      		
		if(empty($this->params['to']))
			$to = '';
		elseif ($this->params['to'] == 1)
			$to = 'minus';
		elseif($this->params['to'] == 2)
			$to = 'plus';
		else
			$to = '';
			
        $orders = $this->_user->getPayedOrders($to, $sort_type, $id_order);

        $url = '/users/plateji/userid/'.$this->_user->id;
		
		if(!empty($this->params['to']))
			if ($this->params['to'] == 1)
				$url .= '/to/1';
			elseif($this->params['to'] == 2)
				$url .= '/to/2';
        $P = new AK_Common_Paging(count($orders), 20, $url);
		$status_list = AK_Order_ZakazStatus::getList();
        $types=$this->checkOptions($status_list);
		$this->view->types=$types;
        $this->view->paging = $P->makePaging($this->params['page']);
        $this->view->orders = array_slice($orders, $this->params['page']*($this->params['page']-1), 20);
		$this->view->selected=$sort_type;
    }

    public function platejipAction () {
        if (!$this->currentUser->getLogin() ) {
            //$this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            //$this->_redirect(SITE_URL);
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
            //$this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            //$this->_redirect(SITE_URL);
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
				
        //$this->_redirect(SITE_URL.'/users/profile/');
	
	}
    public function profileAction () {
        if (!$this->currentUser->getLogin() ) {
            //$this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            //$this->_redirect(SITE_URL);
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

            //$this->_redirect(SITE_URL.'/users/profile/');
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
}

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TelemarketController
 *
 * @author andrey
 */
class TelemarketController  extends AK_Controller_Action {
        public $currentUser;
    public $params;

    public function __construct (Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);
        $this->currentUser = $this->_user;
        $this->view->currentUser = $this->currentUser;
        $this->params = $this->_getAllParams();

        if (!$this->currentUser->getLogin() ) {
        	$this->_redirect(SITE_URL);
        }
        
        if ($this->currentUser->id != $this->_user->id ) {
        	$this->_redirect(SITE_URL);
        }
    }
    
    
    
        public function indexAction () {

    }
        public function sipAction (){
        	$req = $this->getRequest();
        	
        	//принимаем занчение переданное аяксом
        	$code = $req->getParam('code',null);
        	
        	if (!empty($code)) // если там что нибудь есть выполняем запрос
        	{
        		// подключение к БД
        		$db2 = Zend_Registry::get('DBASTERISK');
        		// сам запрос
	        	$query = $db2->select();
	        	$query->from('tarifs AS T', 'T.*')->where('`code`=?', $code);
	        	$tarif = $db2->fetchAll($query);
				// подготовка параметров
				$iscode = $tarif[0]['code'];
				$isname = $tarif[0]['name'];
				$isprice = $tarif[0]['price'];
				// отправляем данные аяксу
				$this->_helper->json(array(
										'code' => $iscode,
										'name' => $isname,
										'price' => $isprice
									));
        	}
        	//передаем во view пароль для SIP
        	$this->view->pass = $this->_user->password_sip;
        	
        	// подключение и запрос к БД testorder
        	$db = Zend_Registry::get('DBORDER');
        	$query = $db->select();
        	$query->from('orders_users__accounts AS U', 'U.*')->where('`id`=?', $this->_user->id);
        	$user_data = $db->fetchAll($query);
        	//передаем во view баланс текущего пользоваетля
        	$this->view->balans = $user_data[0]['balans'];
        	
        	//принимаем занчение переданное аяксом
        	$summa = $req->getParam('summa',null);
        	if (!empty($summa)) // если там что нибудь есть выполняем запрос
        	{
        		$summa = str_replace(",", ".", $summa);
        		$new_balans = $user_data[0]['balans'] - $summa;
        		
        		$db = Zend_Registry::get('DBORDER');
        		$data = array(
        				'balans' => $new_balans,
        		);
        		$where = $this->_db->quoteInto('id = ?',$this->_user->id);
        		$db->update('orders_users__accounts', $data, $where);
        		
        		$this->_helper->json(array(
        				'balans' => $new_balans
        		));
        		
        	}
        }
    
    public function configxmlAction(){
			include_once('telemarket/action.config.xml.php');
	}
}

?>

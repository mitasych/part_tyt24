<?php

// function isINNNotValid($Values) {
  	
//   		if (AK_Order_Validate::CheckINN($Values)) {
//   			return false;
//    		}
//    		return true;
// }
    	
//     	$title = "Добавление";
//     	$this->view->title = $title;
    	
//     	$form = new AK_Form('address_bookForm', 'post', SITE_URL.'/sms/address-book-add/');
    	
//     	$form->addRule('name',        'required',  'Ведите имя');
//     	$form->addRule('surname',        'required',  'Ведите фамилию');
//     	$form->addRule('first_name',        'required',  'Ведите отчество');
		
// 		$form->addRule('email',        'required',  'Введите Email');
// 		$form->addRule('email',        'email',     'Введите правильный Email');
// 		$form->addRule('email',        'callback',  'Введенный Email уже существует', array('func' => 'AK_Order_Validate_Rules::emailExist', 'params' => isset($this->params['email']) ? $this->params['email'] : ''));
// 		Zend_Debug::dump($this->params);
		
$obj = new AK_Order_Sms_DbTable_AddressBook();
if ($this->params['oper'] == 'add') {
   
    $data = array(
    		'name' => htmlspecialchars(trim($this->params['name'])),
    		'surname' => htmlspecialchars(trim($this->params['surname'])),
    		'first_name' => htmlspecialchars(trim($this->params['last_name'])),
    		'status' => htmlspecialchars(trim($this->params['status'])),
    		'org' => htmlspecialchars(trim($this->params['org'])),
    		'position' => htmlspecialchars(trim($this->params['position'])),
    		'phone_number' => htmlspecialchars(trim($this->params['phone_number'])),
    		'add_date' => time(),
            'email' => htmlspecialchars(trim($this->params['email'])),
            'sex' => htmlspecialchars(trim($this->params['sex'])),
            'fax' => htmlspecialchars(trim($this->params['fax'])),
            'mobile_phone' => htmlspecialchars(trim($this->params['mobile_phone'])),
            'balans' => htmlspecialchars(trim($this->params['balans'])),
            'user_id' => $this->_user->id,
    );
	$obj->insert($data);
		    
// 		    $this->_redirect(SITE_URL.'/sms/address-book/');
}
// 		else {
// 		    $form->setDefaults($this->params);
// 		    $this->view->form = $form;
// 		}
		
		//$data_arr = $obj->getAll();		
		//Zend_Debug::dump($data_arr);
// 		$arr_sex = $obj->getSex();
// 		$sex_arr = array();
// 		foreach ($arr_sex as $sex) {
// 			$sex_arr[$sex['code']] = $sex['title'];
// 		}
		
// 		$arr_status = $obj->getStatus();
// 		$status_arr = array();
// 		foreach ($arr_status as $st) {
// 			$status_arr[$st['code']] = $st['title'];
// 		}
// 		$this->view->arr_status = $status_arr;
// 		$this->view->arr_sex = $sex_arr;
// 		$this->view->fparams = $this->params;
// 		$this->view->time = time();
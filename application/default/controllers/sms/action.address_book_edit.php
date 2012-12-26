<?php

$obj = new AK_Order_Sms_DbTable_AddressBook();

if ($this->params['oper'] == 'edit') {
    
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
    );
	$id = $this->params['id'];
    $where = $this->_db->quoteInto('id = ?',$id);
	$obj->update($data, $where);
    
//     $this->_redirect(SITE_URL.'/sms/address-book/');
}

if (!empty($this->params['id_favorites'])) {
	$data = array(
    		'favorites' => $this->params['favor']
	);
	$id_fav = $this->params['id_favorites'];
	$where = $this->_db->quoteInto('id = ?',$id_fav);
	$obj->update($data, $where);
}
		
// 		$id = 	$this->params['id'];
// 		$data_arr = $obj->getAll($id);
// 		$this->view->contact = $data_arr;
// 		$this->view->id = $id;
// 		//Zend_Debug::dump($data_arr);
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
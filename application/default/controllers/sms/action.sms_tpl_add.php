<?php

    	$title = "Добавление";
    	$this->view->title = $title;
    	
    	$obj = new AK_Order_Sms_DbTable_AddressBook();
    	
    	$form = new AK_Form('sms_tplForm', 'post', SITE_URL.'/sms/sms-tpl-add/');
    	
    	$form->addRule('name_tpl',        'required',  'Введите название шаблона');
    	$form->addRule('text_tpl',        'required',  'Введите текст сообщения');
		
		//Zend_Debug::dump($this->params);
		if ($form->validate($this->params)) {
		    
		    $data = array(
		    		'name_tpl' => htmlspecialchars(trim($this->params['name_tpl'])),
		    		'text_tpl' => htmlspecialchars(trim($this->params['text_tpl'])),
		            'user_id' => $this->_user->id,
		    );
		
			$obj->insertData('address_book__tpl', $data);
		    
		    $this->_redirect(SITE_URL.'/sms/sms-tpl/');
		}
		else {
		    $form->setDefaults($this->params);
		    $this->view->form = $form;
		}
		
		$add_tpl = $this->params['add_tpl'];
		$add_name = $this->params['add_name'];
		if (!empty($add_tpl)) {
		    $data_ajax = array(
		    		'name_tpl' => $add_tpl,
		    		'text_tpl' => $add_name,
		    		'user_id' => $this->_user->id,
		    );
		    $obj->insertData('address_book__tpl', $data_ajax);
		    
			$this->_helper->json(array('result' => 'OK'));;
		}
		
		//$data_arr = $obj->getAll();		
		//Zend_Debug::dump($data_arr);
		
		$addr = $obj->getAll();
		$this->view->addr = $addr;
		
		$this->view->fparams = $this->params;
		$this->view->time = time();
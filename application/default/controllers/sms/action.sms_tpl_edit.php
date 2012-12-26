<?php

    	$title = "Редактирование";
    	$this->view->title = $title;
    	
    	$obj = new AK_Order_Sms_DbTable_AddressBook($this->_user->id);
    	
    	$form = new AK_Form('sms_tplForm', 'post', SITE_URL.'/sms/sms-tpl-edit/');
    	
    	$form->addRule('name_tpl',        'required',  'Введите название шаблона');
    	$form->addRule('text_tpl',        'required',  'Введите текст сообщения');
		//Zend_Debug::dump($this->params);
		if ($form->validate($this->params)) {
		    
		    $type = $this->params['type'];
		    
		    if ($type == 1) 
		    {
		        $data = array(
		        		'name_tpl' => htmlspecialchars(trim($this->params['name_tpl'])),
		        		'text_tpl' => htmlspecialchars(trim($this->params['text_tpl'])),
		        );
		    	$id = $this->params['id'];
			    $where = $this->_db->quoteInto('id = ?',$id);
				$obj->updateData('address_book__tpl',$data, $where);
		    }
		    else {
		        $data = array(
		        		'name_tpl' => htmlspecialchars(trim($this->params['name_tpl'])),
		        		'text_tpl' => htmlspecialchars(trim($this->params['text_tpl'])),
		                'user_id' => $this->_user->id
		        );
		        $obj->insertData('address_book__tpl', $data);
		    }
			
		    
		    $this->_redirect(SITE_URL.'/sms/sms-tpl/');
		}
		else {
		    $form->setDefaults($this->params);
		    $this->view->form = $form;
		}
		
		$id = 	$this->params['id'];
		$data_arr = $obj->getTpl($id);
		$this->view->tpl_row = $data_arr;
		$this->view->id = $id;
		//Zend_Debug::dump($data_arr);
		
		$addr = $obj->getAll();
		$this->view->addr = $addr;
		
		$this->view->fparams = $this->params;
		$this->view->time = time();
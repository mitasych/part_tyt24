<?php
	//конект до бд testorder
	$db = Zend_Registry::get('DBORDER');

	//генерация secret_code
	$scode = AK_Common_Functions::generatePassword(12);
	while (AK_Order_Validate::isSecretCodeExists($scode)) {
       	$scode = AK_Common_Functions::generatePassword(12);
    }

	$order_data = array(
		'company' => (empty($this->params['company'])?'': $this->params['company']),
		'email' => $this->_user->email,
		'place_created' => SITE_URL,
		'date_created' => time(),
		'date_updated' => time(),
		'secret_code' => $scode,
		'price' => AK_Order_Basket::getTotalAmount(),
		'additional_info' => '',
		'status' => AK_Order_OrderStatus::PAID,
		'priority' => AK_Order_Enum::P_MEDIUM,
		'money' => null,
		'number' => AK_Order_Schet::get(),
		'zaku' => '',
		'platu' => '',
		'telmob' => '',
		'telgor' => '',
		'addr' => '',
		'metro' => '',
		'ather' => '',
		'ik' => '',
		'price_ik' => ''
	);

	//запись в бд
	$db->insert('orders', $order_data);
	$lastidorder = $db->lastInsertId();
	$query = $db->select();
	$query->from('orders');
	$query->where('id = ?', $lastidorder);
	$res = $db->fetchAll($query);
	$this->view->sc = $res[0]['secret_code'];

	//перебор всех елементов в заказе

	foreach (AK_Order_Basket::getItems() as $id => $item) {
		$aout = new AK_Order_User_Tarif();
		$last_id = $aout->lastInsertIdAddOne();

		if ($item->typeId==41){
			$data_tarif = array(
            'm' => $item->m,
            'period' => $item->period ,
            'user_id' => $_SESSION['user_id'] ,
            'tarif_id' => $last_id,
            'start_date' => time(),
            'end_date_user' => time()+($item->m*24*60*60),
            'end_date_kurator' => time()+($item->m*24*60*60),
			'date_next_mon' => time()+($item->period*24*60*60),
			'count' => $item->mon_count,
			'all_id' => $item->all_id,
            'price_one' => $item->price_one,         
            'order' => $item->mon_price,
            'history' => 0,
            'country' =>  $item->country_id 
				);
			$data_tarif_stat = array(
            'm' => $item->m,
            'period' => $item->period ,
            'user_id' => $_SESSION['user_id'] ,
            'tarif_id' => $last_id,
            'start_date' => time(),
            'end_date' => time()+($item->m*24*60*60),
			'mon_count' => $item->mon_count,			
				);
			$db->insert('orders_users__tarifs_stat', $data_tarif_stat);
			$db->insert('orders_users__monitoring_tarifs', $data_tarif);
			continue;
		}
		$pricesObj = $item->getPricesObject();
		$price = new AK_Order_Prices($item->typeId, $item->off, $item->isoff, $item->region_code);
		

		$data_form = array(
        	'type_id' => $item->typeId,
        	'status' => AK_Order_OrderStatus::PAID,
        	'result' => '',
        	'created_date' => $res[0]['date_created'],
        	'updated_date' => $res[0]['date_updated'],
        	'default_price_hash' => $price->price,
        	'price_in_order' => $price->price,
        	'name' => $item->name,
        	'inn' => $item->inn,
        	'ogrn' => null,
        	'country' => null,
        	'addr' => null,
        	'isfiz' => $item->isfiz,
        	'fizf' => $item->fizf,
        	'fizi' => $item->fizi,
        	'fizo' => $item->fizo,
        	'off' => null,
        	'srochnist' => null,
        	'isoff' => null,
        	'type_obj' => null,
        	'area' => null,
        	'k_number' => null,
        	'copy_red' => null,
        	'copy_var' => null
        );
		
		$db->insert('orders_form_contragent_check', $data_form);
		$lastidrelation = $db->lastInsertId();

		$relation_array = array(
			'order_id' => $lastidorder,
			'zakaz_id' => $lastidrelation,
			'zakaz_type_id' => $price->group,
			'zakaz_subtype_id' => $item->typeId,
			'kurator_id' => null,
			'file_name' => null,
			'file_title' => null,
			'user_id' => empty($this->_user->id)?null:$this->_user->id,
			'description' => ''
		);

        $db->insert('orders_relations', $relation_array);
        
	}

	$newBalans = $this->_user->balans - AK_Order_Basket::getTotalAmount();
	$set = array (
	    'balans' => ''.$newBalans.'',
	);

	$where = $db->quoteInto('id = ?', ''.$this->_user->id.'');
	$rows_affected = $db->update("orders_users__accounts", $set, $where);

    $this->_user->balans = $newBalans;

	AK_Order_Basket::clear();
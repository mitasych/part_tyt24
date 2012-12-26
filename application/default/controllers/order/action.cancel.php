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
		'status' => AK_Order_OrderStatus::CANCEL,
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

		$pricesObj = $item->getPricesObject();
		$price = new AK_Order_Prices($item->typeId, $item->off, $item->isoff, $item->regionCode);

		$data_form = array(
        	'type_id' => $item->typeId,
        	'status' => AK_Order_OrderStatus::CANCEL,
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

	//очистка корзины
	AK_Order_Basket::clear();

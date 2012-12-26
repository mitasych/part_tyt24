<?php
	//конект до бд testorder
	$db = Zend_Registry::get('DBORDER');

	//Обновлюємо поле status в таблиці orders
	$ordersRow = array (
	    'status' => AK_Order_OrderStatus::PAID,
		'date_updated' => time(),		
	);
	$where = $db->quoteInto('id = ?', ''.$ordersBasketId.'');
	$rows_affected = $db->update("orders", $ordersRow, $where);

	//Вибираємо всі записи з таблиці orders_relations де ід= (значення з скритого поля)
	$select = $db->select()
	             ->from('orders_relations')
	             ->where('order_id = ?', ''.$ordersBasketId.'');
	$stmt = $db->query($select);
	$result = $stmt->fetchAll();

	//Вводимо їх в цикл, для зміни статусів.
    foreach ($result as $value) {
		$ordersRowCheck = array (
		    'status' => AK_Order_OrderStatus::PAID,
		    'updated_date' => time(),		    
		);
		$where = $db->quoteInto('id = ?', ''.$value['zakaz_id'].'');
		$rows_affected = $db->update("orders_form_contragent_check", $ordersRowCheck, $where);
    }

    //Віднімання від загальної суми користувача ціну послуги.
	$newBalans = $this->_user->balans - $ordersBasketMoney;
	$newBalanss = $this->_user->balans - $ordersBasketMoney;
	$set = array (
	    'balans' => ''.$newBalans.'',
	);

	$where = $db->quoteInto('id = ?', ''.$this->_user->id.'');
	$rows_affected = $db->update("orders_users__accounts", $set, $where);

    $this->_user->balans = $newBalans;

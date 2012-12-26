<?
	//конект до бд testorder
	$db = Zend_Registry::get('DBORDER');

	$sc = $this->getRequest()->getParam('sc');
	$order = new AK_Order_Item('secret_code', $sc);

	$set = array (
	    'status' => AK_Order_OrderStatus::WAITING_FOR_PAYMENT,
	);

	$where = $db->quoteInto('id = ?', ''.$order->id.'');
	$rows_affected = $db->update("orders", $set, $where);
	$this->_redirect('/order/pay/sc/'.$sc.'/');
?>
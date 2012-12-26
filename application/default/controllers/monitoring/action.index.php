<?php


$db = Zend_Registry::get('DBORDER');
$query = $db->select();
// $query->from('orders_monitoring__events AS A', 'A.date_created');
// $query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id)
      // ->order('A.date_created DESC')
      // ->limit(1);
$query->from('orders_users__monitoring_tarifs AS A', 'A.date_next_mon');
$query->where(' user_id = ?', $this->_user->id)
      ->order('A.date_next_mon DESC')
      ->limit(1);

$res = intval($db->fetchOne($query));

$this->view->lastMonitoringDate = empty($res)?'Мониторинг не проводился':date('d.m.Y', $res);

$this->view->setting = new AK_Order_Settings();
// $db = Zend_Registry::get('DBORDER');
// $query = $db->select();
// $query->from('orders_monitoring__events AS A', 'A.id');
// $query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id)
      // ->order('A.event_date DESC')
      // ->limit(1);
// $res = intval($db->fetchOne($query));
$db = Zend_Registry::get('DBORDER');
$query = $db->select();
$query->from('orders_monitoring__events AS A', 'A.id');
$query->join('orders_users__kontragents AS B', 'B.kontragent_id = A.kontragent_id', '');
$query->join('orders_users__monitoring_tarifs AS C', 'C.tarif_id = B.tarif_id', '');
$query->where('C.user_id = ?', $this->_user->id)
	  ->where('C.date_next_mon > A.event_date')
      ->order('A.event_date DESC')
      ->limit(1);
$res = intval($db->fetchOne($query));
$this->view->lastEvent = new AK_Order_Monitoring_Event($res);

$periodList = new AK_Order_Monitoring_Tarif_Period_List;
$periodList->returnAsAssoc(true)->addWhere('A.is_active = 1');
$this->view->periodList = $periodList->getList();

$type = new AK_Order_Monitoring_Tarif_ListType();
$this->view->type = $type->getList();
$tarif = new AK_Order_Monitoring_Tarif_ListAll();
$this->view->tarif = $tarif->getList();
//Zend_Debug::dump($this->view->user->count);exit();
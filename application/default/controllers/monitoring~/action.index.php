<?php

$tarifsList = new AK_Order_Monitoring_Tarif_List();
$tarifsList->addWhere('A.is_active = 1');
$this->view->tarifsList = $tarifsList->getList();

$db = Zend_Registry::get('DBORDER');
$query = $db->select();
$query->from('orders_monitoring__events AS A', 'A.date_created');
$query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id)
      ->order('A.date_created DESC')
      ->limit(1);

$res = intval($db->fetchOne($query));

$this->view->lastMonitoringDate = empty($res)?'Мониторинг не проводился':date('d-m-Y', $res);

$db = Zend_Registry::get('DBORDER');
$query = $db->select();
$query->from('orders_monitoring__events AS A', 'A.id');
$query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id)
      ->order('A.event_date DESC')
      ->limit(1);
$res = intval($db->fetchOne($query));
$this->view->lastEvent = new AK_Order_Monitoring_Event($res);


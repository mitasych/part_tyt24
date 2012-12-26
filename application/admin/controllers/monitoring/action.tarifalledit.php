<?php

$this->params  = $this->getRequest()->getParams();

$settings = new AK_Order_Settings();
$this->view->settings = $settings;

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;  

$type = new AK_Order_Monitoring_Tarif_ListType();
$this->view->type = $type->getList();

$tarif = new AK_Order_Monitoring_Tarif_List();
$this->view->tarif = $tarif->setOrder('order')->getList();

$period = new AK_Order_Monitoring_Tarif_Period_List();
$this->view->period = $period->getList();

$typeList = new AK_Order_Monitoring_Event_Type_List();
$this->view->typeList = $typeList->getList();

$currentItem = new AK_Order_Monitoring_TarifAll($this->params['id']);

$form = new AK_Form('editItem', 'post', MODULE_URL.'/monitoring/tarifalledit/');

if ($form->isPostback()) {
    $this->params['isActive'] = empty($this->params['isActive'])?0:1;
    $form->setDefaults($this->params);
}


if ($form->validate($this->params)) {

    $currentItem->isActive = ($this->params['isActive'])?1:0;
    
    $currentItem->name = $this->params['name'];
    $currentItem->simb = $this->params['simb'];
    $currentItem->about = $this->params['about'];
    $currentItem->bonus = $this->params['bonus'];
    $currentItem->type = intval($this->params['type']);
    $currentItem->type2 = intval($this->params['type2']);
    $currentItem->reg1 = intval($this->params['reg1']);
    $currentItem->reg2 = intval($this->params['reg2']);
    $currentItem->reg3 = intval($this->params['reg3']);

    $currentItem->save();
	
	$db = Zend_Registry::get('DBORDER');
	$db->delete('orders_monitoring__tarif_conect', 'id_tarif = '.$currentItem->id);
			
	foreach ($this->view->typeList as $type)
	{
		// print $type->id.'<br>';
		if(!empty($this->params['event'][$type->id]))
		{
			$db = Zend_Registry::get('DBORDER');
			$data = array(
				'id_tarif' => $currentItem->id,
				'id_price' => $type->id
			);
			$db->insert('orders_monitoring__tarif_conect', $data);
		
		}
		else
		{
		
		}
	}
	$db = Zend_Registry::get('DBORDER');
	$db->delete('orders_monitoring__tarif_conect_tarif', 'id_tarif = '.$currentItem->id);
			
	foreach ($this->view->tarif as $type)
	{
		// print $type->id.'<br>';
		if(!empty($this->params['tarifs'][$type->id]))
		{
			$db = Zend_Registry::get('DBORDER');
			$data = array(
				'id_tarif' => $currentItem->id,
				'id_price' => $type->id
			);
			$db->insert('orders_monitoring__tarif_conect_tarif', $data);
		
		}
		else
		{
		
		}
	}
    $this->_redirect(MODULE_URL.'/monitoring/tarifsall/');
}

$this->view->form = $form;
$this->view->currentItem = $currentItem;
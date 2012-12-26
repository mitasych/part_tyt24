<?php

class Admin_OrdersController extends AK_Controller_Action {

    public function countriesListAction()     {include_once('orders/action.countries.list.php');}
    public function countryAddAction()       {include_once('orders/action.country.add.php');}
    public function countryEditAction()      {return $this->countryAddAction();}
    public function countryDeleteAction()    {include_once('orders/action.country.delete.php');}
	
	public function reportsAction()     {include_once('orders/action.reports.php');}
    public function reportsAddAction()       {include_once('orders/action.reports.add.php');}
    public function reportsEditAction()      {return $this->reportsAddAction();}
    public function reportsDeleteAction()    {include_once('orders/action.reports.delete.php');}
    
    public function ofreportsAction() {include_once 'orders/action.ofreports.php';}
    public function ofreportsAddAction() {include_once 'orders/action.ofreports.add.php';}
    public function ofreportsEditAction()      {return $this->ofreportsAddAction();}
    public function ofreportsDeleteAction()    {include_once('orders/action.ofreports.delete.php');}
	
	public function payAction()     {include_once('orders/action.pay.php');}
	public function paysortAction()     {include_once('orders/action.paysort.php');}
    public function payAddAction()       {include_once('orders/action.pay.add.php');}
    public function payEditAction()      {return $this->payAddAction();}
    public function payDeleteAction()    {include_once('orders/action.pay.delete.php');}
	
    public function listAction() {
        include_once('orders/action.list.php');
    }
    
    public function pricesAction() {
        include_once('orders/action.prices.php');
    }

    public function settingsAction() {
        include_once('orders/action.settings.php');
    }

    public function usersListAction() {
        include_once('orders/action.users.list.php');
    }
    public function ausersListAction() {
        include_once('orders/action.ausers.list.php');
    }
    public function dusersListAction() {
        include_once('orders/action.dusers.list.php');
    }
    public function dogusersListAction() {
        include_once('orders/action.dogusers.list.php');
    }
    public function pusersListAction() {
        include_once('orders/action.pusers.list.php');
    }
    public function userdeleteAction() {

       //$this->_redirect(MODULE_URL.'/orders/users.list/');//!!!!!!!!!!!!!!!!!!!!!!!
        
        $this->params = $this->getRequest()->getParams();
        $this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
        $currentItem = new AK_Order_User('id', $this->params['id']);
        $currentItem->isDeleted = 1;
        $currentItem->save();
        foreach ($currentItem->getOrders() as $order) {
            $order->status = AK_Order_OrderStatus::ARCHIVE;
            $order->save();
            foreach ($order->getZakazList() as $zakaz) {
                $zakaz->status = AK_Order_ZakazStatus::ARCHIVE;
                $zakaz->save();
            }
        }
        //$currentItem->delete();
        $this->_redirect(MODULE_URL.'/orders/users.list/');
    }

    public function userblockAction() {
        $this->params = $this->getRequest()->getParams();
        $this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
        $currentItem = new AK_Order_User('id', $this->params['id']);
        $currentItem->isBlocked = $currentItem->isBlocked?0:1;
        $currentItem->save();
        
        $this->_redirect(MODULE_URL.'/orders/users.list/');
    }

    public function userskidkaAction() {
        $this->params = $this->getRequest()->getParams();
        $this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
        $currentItem = new AK_Order_User('id', $this->params['id']);
        $currentItem->monitoringTarifSkidka = intval($this->getRequest()->getParam('sk'));
        if ($currentItem->monitoringTarifSkidka<0) $currentItem->monitoringTarifSkidka = 0;
        if ($currentItem->monitoringTarifSkidka>100) $currentItem->monitoringTarifSkidka = 100;
        $currentItem->save();

        $this->_redirect(MODULE_URL.'/orders/users.list/');
    }

    public function serviceblockAction() {
        $this->params = $this->getRequest()->getParams();
        $this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
        $currentItem = new AK_Order_User('id', $this->params['id']);
        switch ($this->params['s']) {
            case 'ved' : $currentItem->blockVed = $currentItem->blockVed?0:1; break;
            case 'monitoring' : $currentItem->blockMonitoring = $currentItem->blockMonitoring?0:1; break;
            case 'base' : $currentItem->blockBase = $currentItem->blockBase?0:1; break;
            case 'report' : $currentItem->blockReport = $currentItem->blockReport?0:1; break;
        }

        $currentItem->save();

        $this->_redirect(MODULE_URL.'/orders/users.list/');
    }

    public function approvemonAction() {
        $this->params = $this->getRequest()->getParams();
        $this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
        $currentItem = new AK_Order_User('id', $this->params['id']);
        $currentItem->dogovorCreated = 1;
        $currentItem->save();
        $this->_redirect(MODULE_URL.'/orders/dogusers.list/');
    }

    public function usereditAction() {
        include_once('orders/action.useredit.php');
    }


    public function kuratorsListAction() {
        include_once('orders/action.kurators.list.php');
    }
    public function kuratoreditAction() {
        include_once('orders/action.kuratoradd.php');
    }

    public function kuratorloginAction() {
        $this->params = $this->getRequest()->getParams();
        $this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
        $currentItem = new AK_Administrator('id', $this->params['id']);

        if (!$currentItem->id) $this->_redirect(MODULE_URL.'/orders/kurators.list/');
        $currentItem->authenticate();
        $this->_redirect('/'.MODULE_NAME.'/');

    }

    public function userloginAction() {
        $this->params = $this->getRequest()->getParams();
        $this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
        $currentItem = new AK_Order_User('id', $this->params['id']);

        if (!$currentItem->id) $this->_redirect(MODULE_URL.'/orders/users.list/');
        $currentItem->authenticate();
        $this->_redirect('/users/profile/');

    }

    public function kuratorrighteditAction() {
        $this->params = $this->getRequest()->getParams();
        $this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
        $currentItem = new AK_Administrator('id', $this->params['id']);

        if (!$currentItem->id) $this->_redirect(MODULE_URL.'/orders/kurators.list/');

        $r = new AK_Order_Kurator_Rights($currentItem->id);

        $pList = AK_Order_ZakazTypes::getPriceList();
        $gList = AK_Order_ZakazTypes::getGroupList();
        $mArray = array();
        foreach($gList as $k=>$v) {
            $mArray[] = array('gkey'=>$k, 'gval'=>$v, 'gp'=> array());
        }
        foreach($mArray as $k=>$v) {
            foreach ($pList as $k1=>$v1) {
                if ($k1>$mArray[$k]['gkey'] && (!isset($mArray[$k+1]) ||$k1<$mArray[$k+1]['gkey'])) {
                    $mArray[$k]['gp'][$k1] = $v1;
                }
            }
        }

        if (!empty($this->params['r'])) {
            $r->removeAll();
            $this->view->updateMessage='Изменения сохранены';
            foreach($this->params['r'] as $key => $val) {
                $r->add($key);
            }
        }

        $this->view->pList = $pList;
        $this->view->gList = $gList;
        $this->view->mList = $mArray;
        $this->view->r = $r;
    }
    public function kuratordeleteAction() {
        $this->params = $this->getRequest()->getParams();
        $this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;
        $currentItem = new AK_Administrator('id', $this->params['id']);
        if ($currentItem->status == AK_Enum_AdminStatus::KURATOR) $currentItem->delete();
        $this->_redirect(MODULE_URL.'/orders/kurators.list/');
    }

}

<?php

class Admin_ControllsController extends AK_Controller_Action
{
	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
    	parent::__construct($request, $response, $invokeArgs);
        $this->params = $this->_getAllParams(); 
    }

    public function timeAction()    {include_once('controlls/action.time.php');}
    public function bannersAction()    {include_once('controlls/action.banners.php');}
    public function bannersEditAction()    {include_once('controlls/action.banners.edit.php');}
    public function ordersAction()    {include_once('controlls/action.orders.php');}
    public function pricesAction()    {include_once('controlls/action.prices.php');}


}

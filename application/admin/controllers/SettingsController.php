<?php

class Admin_SettingsController extends AK_Controller_Action
{
	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
    	parent::__construct($request, $response, $invokeArgs);
    	$this->params = $this->_getAllParams();
    }

    public function indexAction()            {include_once('settings/action.index.php');}
    public function copyrightAction()         {include_once('settings/action.copyright.php');}
    public function contactAction()         {include_once('settings/action.contact.php');}
    public function onlineAction()         {include_once('settings/action.online.php');}
    public function infoAction()         {include_once('settings/action.info.php');}
    public function phoneAction()         {include_once('settings/action.phone.php');}
    public function phone2Action()         {include_once('settings/action.phone2.php');}
    public function profileAction()         {include_once('settings/action.profile.php');}
    public function headerAction()         {include_once('settings/action.header.php');}
    public function datafieldAction()         {include_once('settings/action.datafield.php');}
	public function ofreportsAction()         {include_once('settings/action.ofreports.php');}
}

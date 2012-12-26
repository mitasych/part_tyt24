<?php
abstract class AK_Controller_Action extends Zend_Controller_Action
{
    protected $_db;
    public function __construct (Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);
        $this->_db = Zend_Registry::get("DB");
        $this->_user = Zend_Registry::get("User");
        /**
         * 
         */
        define('ACTION_NAME', $request->getParam('action')); 
        define('CONTROLLER_NAME', $request->getParam('controller')); 
        define('MODULE_NAME', $request->getParam('module'));
        define('MODULE_URL', SITE_URL . '/' . ((MODULE_NAME == 'default') ? '' : MODULE_NAME));
        $this->view->MODULE_NAME = MODULE_NAME;
        $this->view->MODULE_URL = MODULE_URL;
        
        $this->view->ACTION_NAME = ACTION_NAME;
        $this->view->CONTROLLER_NAME = CONTROLLER_NAME;
        /**
         * 
         */
        if (file_exists(APP_DIR . '/' . MODULE_NAME . '/' . MODULE_NAME . '.php')) {
            require_once (APP_DIR . '/' . MODULE_NAME . '/' . MODULE_NAME . '.php');
        }
    }
    
    public function __call($methodName, $args)
    {
        if ('Action' == substr($methodName, -6)) {
            $this->_redirect404();
            exit;
            //require_once 'Zend/Controller/Action/Exception.php';
            //$action = substr($methodName, 0, strlen($methodName) - 6);
            //throw new Zend_Controller_Action_Exception(sprintf('Action "%s" does not exist and was not trapped in __call()', $action), 404);
        }

        require_once 'Zend/Controller/Action/Exception.php';
        throw new Zend_Controller_Action_Exception(sprintf('Method "%s" does not exist and was not trapped in __call()', $methodName), 500);
    }

    protected function _redirect404()
    {
        header('Location: /404.htm');
        exit;
    }
}

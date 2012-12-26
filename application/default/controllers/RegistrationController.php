<?php

class RegistrationController extends AK_Controller_Action
{
    public $params;
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);
        $this->params = $this->_getAllParams();
        $this->view->TITLE = 'Регистрация';
        //$this->_page->Template->assign('menuContent', '_design/menu_content/menu_content.tpl');
    }

    public function indexAction()           {include_once('registration/action.index.php');}
    public function completedAction()       {}
}

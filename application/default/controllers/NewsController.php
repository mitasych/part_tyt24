<?php

class NewsController extends AK_Controller_Action
{
    public $params;
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);
        $this->params = $this->_getAllParams();
        $this->view->NAV = 1;
       
    }
    
    public function indexAction()           {include_once('news/action.index.php');}
    public function showAction()           {include_once('news/action.index.php');}
    public function lastnewsAction()       {include_once('news/action.lastnews.php');}
    public function archiveAction()        {include_once('news/action.archive.php');}
}

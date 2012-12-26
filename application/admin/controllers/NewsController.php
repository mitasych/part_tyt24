<?php

class Admin_NewsController extends AK_Controller_Action
{
    public $params;

	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
    	parent::__construct($request, $response, $invokeArgs);
        
        $this->params = $this->_getAllParams(); 
    }

    public function indexAction()               {include_once('news/action.index.php');}
    public function categoriesListAction()      {include_once('news/action.categories.list.php');}
    public function categoriesAddAction()       {include_once('news/action.categories.add.php');}
    public function categoriesEditAction()      {return $this->categoriesAddAction();}
    public function categoriesDeleteAction()    {include_once('news/action.categories.delete.php');}
    
    public function listAction()                {include_once('news/action.list.php');}
    public function addAction()                 {include_once('news/action.add.php');}
    public function editAction()                {return $this->addAction();}
    public function deleteAction()              {include_once('news/action.delete.php');}
    //MASS
    public function massDeleteAction()          {include_once('news/action.mass.delete.php');}

}

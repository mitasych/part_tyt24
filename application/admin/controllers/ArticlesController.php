<?php

class Admin_ArticlesController extends AK_Controller_Action
{
    public $params;

	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
    	parent::__construct($request, $response, $invokeArgs);
        
        $this->params = $this->_getAllParams(); 
    }

    public function indexAction()               {include_once('articles/action.index.php');}
    public function categoriesListAction()      {include_once('articles/action.categories.list.php');}
    public function categoriesAddAction()       {include_once('articles/action.categories.add.php');}
    public function categoriesEditAction()      {return $this->categoriesAddAction();}
    public function categoriesDeleteAction()    {include_once('articles/action.categories.delete.php');}
    
    public function listAction()                {include_once('articles/action.list.php');}
    public function addAction()                 {include_once('articles/action.add.php');}
    public function editAction()                {return $this->addAction();}
    public function deleteAction()              {include_once('articles/action.delete.php');}
    //MASS
    public function massDeleteAction()          {include_once('articles/action.mass.delete.php');}

}

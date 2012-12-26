<?php

class Admin_MenuController extends AK_Controller_Action
{
    public $params;

	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
    	parent::__construct($request, $response, $invokeArgs);
        
        $this->params = $this->_getAllParams(); 
    }

    public function indexAction()             {return $this->listAction();}
    public function listAction()              {include_once('menu/action.list.php');}
    public function linksListAction()         {include_once('menu/action.links.list.php');}
    public function linkAddAction()           {include_once('menu/action.link.add.php');}
    public function linkEditAction()          {return $this->linkAddAction();}
    public function linkDeleteAction()        {include_once('menu/action.link.delete.php');}
    //MASS
    public function massLinkDeleteAction()    {include_once('menu/action.mass.link.delete.php');}
    public function massLinkSortAction()      {include_once('menu/action.mass.link.sort.php');}
    
    
    public function sublinksListAction()      {include_once('menu/action.sublinks.list.php');}
    public function sublinkAddAction()        {include_once('menu/action.sublink.add.php');}
    public function sublinkEditAction()       {return $this->sublinkAddAction();}
    public function sublinkDeleteAction()     {include_once('menu/action.sublink.delete.php');}
    //MASS
    public function massSublinkDeleteAction() {include_once('menu/action.mass.sublink.delete.php');}
    public function massSublinkSortAction()   {include_once('menu/action.mass.sublink.sort.php');}

}

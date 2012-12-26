<?php

class InfoController extends AK_Controller_Action
{
    public $params;
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);
        $this->params = $this->_getAllParams();
        
        $this->_helper->AjaxContext()
        ->addActionContext('ajaxofregions','json')
        ->addActionContext('ajaxofregionsbytype','json')
        ->addActionContext('ajaxofregionsbycargo','json')
        ->addActionContext('ajaxofshipdata','json');
//         ->initContext('json');
        
    }

    public function showAction()        {include_once('info/action.show.php');}
    public function shownewAction()     {include_once('info/action.shownew.php');
    }
    public function contactAction()     {include_once('info/action.contact.php');}
    public function onlineAction()      {include_once('info/action.online.php');}
    public function analizAction()      {include_once('info/action.analiz.php');}
    public function vacancyAction()     {include_once('info/action.vacancy.php');}
    public function sentAction()        {}
    public function sentvAction()       {}
    public function sentcAction()       {}

    public function rasstAction()       {include_once('info/action.rasst.php');}
    public function openheadAction()    {include_once('info/action.openhead.php');}
    public function openheaderAction()  {include_once('info/action.openheader.php');}
    public function valutagraficAction(){include_once('info/action.valutagrafic.php');}
    public function valutagraficdataAction(){include_once('info/action.valutagraficdata.php');}

    public function searchdocAction(){include_once('info/action.searchdoc.php');}
    public function searchviewAction(){include_once('info/action.searchview.php');}
    public function searchhelpAction(){include_once('info/action.searchhelp.php');}
    public function searchinfoAction(){include_once('info/action.searchinfo.php');}
    public function checkAction(){include_once('info/action.check.php');}
    public function baseAction(){include_once('info/action.base.php');}
    
    public function ajaxofregionsAction(){include_once('info/action.ajaxofregions.php');}
    public function ajaxofregionsbytypeAction(){include_once('info/action.ajaxofregionsbytype.php');}
    public function ajaxofregionsbycargoAction(){include_once('info/action.ajaxofregionsbycargo.php');}
    public function ajaxofshipdataAction(){include_once('info/action.ajaxofshipdata.php');}
}

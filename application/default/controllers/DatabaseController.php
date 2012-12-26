<?php
class DatabaseController extends AK_Controller_Action
{
    public $params;
    public function __construct (Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);
        $this->params = $this->_getAllParams();
    }
    public function updateAction() {
        $model = new Tyt24_Models_Search();
        $model->updateIndex();

    }
    
	public function indexAction()
	{
	include_once('database/action.index.php');

	}
	
	public function showAction() {
      
      

	    include_once('database/action.show.php');

		
		$subregions = Tyt24_Models_Subregions::getSubregions();
		

		$tmpName = "";
		$resultSubregions = array() ;
		

		foreach ( $subregions as $item ) {
			if ( $item->FOName != $tmpName ) {
				$tmpName = $item->FOName; 
				$resultSubregions[$tmpName] = array( "id" => $item->region_id, "name" => $item->FOName, "subitems" =>array() );
				$tmpItem = &$resultSubregions[$tmpName]["subitems"];
			}
			$tmpItem[] = $item->RegionName;
		}

		
		
		$this->view->subregions = $resultSubregions;
		
                $this->view->test = "Test!";
                
                //$this->_redirect('/list/index/what/'.$this->params['code'].'/where/');
    }

    public function avtocounterAction()        {$this->_redirect(SITE_URL.'/index/index/avto/');}
    public function sendtofriendAction()       {include_once('index/action.sendToFriend.php');}
    
}

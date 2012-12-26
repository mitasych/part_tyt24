<?php
class ReportsController extends AK_Controller_Action {
    public $currentUser;
    public $params;
    public function __construct (Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);
        $this->currentUser =  $this->_user;
        $this->params = $this->_getAllParams();
        $this->view->currentUser = $this->currentUser;
    }

    public function indexAction () {
        include_once ('reports/action.index.php');
    }
    
    public function orderAction () {
        //~ if (!$this->currentUser->getLogin() ) {
            //~ $this->_redirect(SITE_URL);
        //~ }
//~ 
        //~ if ($this->currentUser->id != $this->_user->id ) {
            //~ $this->_redirect(SITE_URL);
        //~ }

        $formurl = '/reports/order';
        include_once ('info/action.check.php');
    }

    public function listAction () {
        if (!$this->currentUser->getLogin() ) {
            $this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            $this->_redirect(SITE_URL);
        }


        $this->view->orders = $this->_user->getOrdersReport();



    }

    public function documentsAction () {
        if (!$this->currentUser->getLogin() ) {
            $this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            $this->_redirect(SITE_URL);
        }

        //settings
        $form = new AK_Form('editForm', 'post', SITE_URL.'/reports/documents/');

        if ($form->validate($this->params)) {

            $this->_user->vipiskaNotifyFlag = empty($this->params['vipiska_notify_flag'])?0:1;
            $this->_user->aktNotifyFlagReport = empty($this->params['akt_notify_flag_report'])?0:1;
            

            $this->_user->save();
            $this->_redirect(SITE_URL.'/reports/documents/');
        }
        else {

            if (!$form->isPostback()) {
                $this->params['vipiska_notify_flag'] = $this->_user->vipiskaNotifyFlag;
                $this->params['akt_notify_flag_report'] = $this->_user->aktNotifyFlagReport;
            }
            $form->setDefaults($this->params);
            $this->view->form = $form;
        }

        $this->view->fparams = $this->params;
    }

}

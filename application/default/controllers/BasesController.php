<?php
class BasesController extends AK_Controller_Action {

    public $currentUser;
    public $params;

    public function __construct (Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);
        $this->currentUser = $this->_user;
        $this->view->currentUser = $this->currentUser;
        $this->params = $this->_getAllParams();

    }

    public function indexAction () {
        if (!$this->currentUser->getLogin() ) {
            $this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            $this->_redirect(SITE_URL);
        }

        $formurl = '/bases/';
        include_once ('info/action.base.php');
    }

    public function listAction () {
        if (!$this->currentUser->getLogin() ) {
            $this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            $this->_redirect(SITE_URL);
        }

        $this->view->orders = $this->_user->getOrdersBase();




    }

    public function documentsAction () {
        if (!$this->currentUser->getLogin() ) {
            $this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id ) {
            $this->_redirect(SITE_URL);
        }

        //settings
        $form = new AK_Form('editForm', 'post', SITE_URL.'/bases/documents/');

        if ($form->validate($this->params)) {

            $this->_user->aktNotifyFlagBase = empty($this->params['akt_notify_flag_base'])?0:1;


            $this->_user->save();
            $this->_redirect(SITE_URL.'/bases/documents/');
        }
        else {

            if (!$form->isPostback()) {
                $this->params['akt_notify_flag_base'] = $this->_user->aktNotifyFlagBase;
            }
            $form->setDefaults($this->params);
            $this->view->form = $form;
        }

        $this->view->fparams = $this->params;
    }
}

<?php
class AK_Controller_Front extends Zend_Controller_Front
{
    public static function getInstance ()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    protected function __construct()
    {
         $this->_plugins = new Zend_Controller_Plugin_Broker();
    }
    
    /**
     *
     */
     public function getDispatcher()
    {
        /**
         * Instantiate the default dispatcher if one was not set.
         */
        if (!$this->_dispatcher instanceof Zend_Controller_Dispatcher_Interface) {
            require_once 'AK/Controller/Dispatcher/Standard.php';
            $this->_dispatcher = new AK_Controller_Dispatcher_Standard();
        }
        return $this->_dispatcher;
    }
    /**
     * 
     */
    public function dispatch (Zend_Controller_Request_Abstract $request = null, Zend_Controller_Response_Abstract $response = null)
    {
        if (! $this->getParam('noErrorHandler') && ! $this->_plugins->hasPlugin('Zend_Controller_Plugin_ErrorHandler')) {
            // Register with stack index of 100
            $this->_plugins->registerPlugin(new Zend_Controller_Plugin_ErrorHandler(), 100);
        }
        if (! $this->getParam('noViewRenderer') && ! Zend_Controller_Action_HelperBroker::hasHelper('viewRenderer')) {
            Zend_Controller_Action_HelperBroker::addHelper(new AK_Controller_Action_Helper_ViewRenderer());
        }
        /**
         * Instantiate default request object (HTTP version) if none provided
         */
        if (null !== $request) {
            $this->setRequest($request);
        } elseif ((null === $request) && (null === ($request = $this->getRequest()))) {
            // require_once 'Zend/Controller/Request/Http.php';
            $request = new Zend_Controller_Request_Http();
            $this->setRequest($request);
        }
        /**
         * Set base URL of request object, if available
         */
        if (is_callable(array(
            $this->_request , 
            'setBaseUrl'))) {
            if (null !== $this->_baseUrl) {
                $this->_request->setBaseUrl($this->_baseUrl);
            }
        }
        /**
         * Instantiate default response object (HTTP version) if none provided
         */
        if (null !== $response) {
            $this->setResponse($response);
        } elseif ((null === $this->_response) && (null === ($this->_response = $this->getResponse()))) {
            // require_once 'Zend/Controller/Response/Http.php';
            $response = new Zend_Controller_Response_Http();
            $this->setResponse($response);
        }
        /**
         * Register request and response objects with plugin broker
         */
        $this->_plugins->setRequest($this->_request)->setResponse($this->_response);
        /**
         * Initialize router
         */
        $router = $this->getRouter();
        $router->setParams($this->getParams());
        /**
         * Initialize dispatcher
         */
        $dispatcher = $this->getDispatcher();
        $dispatcher->setParams($this->getParams())->setResponse($this->_response);
        // Begin dispatch
        try {
            /**
             * Route request to controller/action, if a router is provided
             */
            /**
             * Notify plugins of router startup
             */
            $this->_plugins->routeStartup($this->_request);
            $router->route($this->_request);
            /**
             * Notify plugins of router completion
             */
            $this->_plugins->routeShutdown($this->_request);
            /**
             * Notify plugins of dispatch loop startup
             */
            $this->_plugins->dispatchLoopStartup($this->_request);
            /**
             *  Attempt to dispatch the controller/action. If the $this->_request
             *  indicates that it needs to be dispatched, move to the next
             *  action in the request.
             */
            do {
                $this->_request->setDispatched(true);
                /**
                 * Notify plugins of dispatch startup
                 */
                $this->_plugins->preDispatch($this->_request);
                /**
                 * Skip requested action if preDispatch() has reset it
                 */
                if (! $this->_request->isDispatched()) {
                    continue;
                }
                /**
                 * Dispatch request
                 */
                try {
                    $dispatcher->dispatch($this->_request, $this->_response);
                } catch (Exception $e) {
                    if ($this->throwExceptions()) {
                        throw $e;
                    }
                    $this->_response->setException($e);
                }
                /**
                 * Notify plugins of dispatch completion
                 */
                $this->_plugins->postDispatch($this->_request);
            } while (! $this->_request->isDispatched());
        } catch (Exception $e) {
            if ($this->throwExceptions()) {
                throw $e;
            }
            $this->_response->setException($e);
        }
        /**
         * Notify plugins of dispatch loop completion
         */
        try {
            $this->_plugins->dispatchLoopShutdown();
        } catch (Exception $e) {
            if ($this->throwExceptions()) {
                throw $e;
            }
            $this->_response->setException($e);
        }
        if ($this->returnResponse()) {
            return $this->_response;
        }
        $this->_response->sendResponse();
    }
}

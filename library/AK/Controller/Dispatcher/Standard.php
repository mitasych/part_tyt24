<?php


/** Zend_Loader */
//require_once 'Zend/Loader.php';

/** Zend_Controller_Dispatcher_Abstract */
//require_once 'Zend/Controller/Dispatcher/Abstract.php';

/** Zend_Controller_Request_Abstract */
//require_once 'Zend/Controller/Request/Abstract.php';

/** Zend_Controller_Response_Abstract */
//require_once 'Zend/Controller/Response/Abstract.php';

/** Zend_Controller_Action */
//require_once 'Zend/Controller/Action.php';

class AK_Controller_Dispatcher_Standard extends Zend_Controller_Dispatcher_Standard
{
    public function __construct(array $params = array())
    {
        parent::__construct($params);
    }
    
    
    
    public function dispatch(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response)
    {
        $this->setResponse($response);

        /**
         * Get controller class
         */
        if (!$this->isDispatchable($request)) {
            $controller = $request->getControllerName();
            if (!$this->getParam('useDefaultControllerAlways') && !empty($controller)) {
                //header('Location: /404.htm');
                //header('HTTP/1.0 404 Not Found', true, 404);
                header('Location: /404.htm');
                exit;//TODO add 404 log
                //require_once 'Zend/Controller/Dispatcher/Exception.php';
                //throw new Zend_Controller_Dispatcher_Exception('Invalid controller specified (' . $request->getControllerName() . ')');
            }

            $className = $this->getDefaultControllerClass($request);
        } else {
            $className = $this->getControllerClass($request);
            if (!$className) {
                $className = $this->getDefaultControllerClass($request);
            }
        }

        /**
         * Load the controller class file
         */
        $className = $this->loadClass($className);

        /**
         * Instantiate controller with request, response, and invocation
         * arguments; throw exception if it's not an action controller
         */
        
        
            $controller = new $className($request, $this->getResponse(), $this->getParams());
      
        
        
        if (!$controller instanceof Zend_Controller_Action) {
            require_once 'Zend/Controller/Dispatcher/Exception.php';
            throw new Zend_Controller_Dispatcher_Exception("Controller '$className' is not an instance of Zend_Controller_Action");
        }

        /**
         * Retrieve the action name
         */
        $action = $this->getActionMethod($request);

        /**
         * Dispatch the method call
         */
        $request->setDispatched(true);

        // by default, buffer output
        $disableOb = $this->getParam('disableOutputBuffering');
        $obLevel   = ob_get_level();
        if (empty($disableOb)) {
            ob_start();
        }

        try {
            $controller->dispatch($action);
        } catch (Exception $e) {
            // Clean output buffer on error
            $curObLevel = ob_get_level();
            if ($curObLevel > $obLevel) {
                do {
                    ob_get_clean();
                    $curObLevel = ob_get_level();
                } while ($curObLevel > $obLevel);
            }

            throw $e;
        }

        if (empty($disableOb)) {
            $content = ob_get_clean();
            $response->appendBody($content);
        }

        // Destroy the page controller instance and reflection objects
        $controller = null;
    }
    
    public function isDispatchable(Zend_Controller_Request_Abstract $request)
    {
        $className = $this->getControllerClass($request);
        if (!$className) {
            return false;
        }

        if (class_exists($className, false)) {
            return true;
        }

        $fileSpec    = $this->classToFilename($className);
        $dispatchDir = $this->getDispatchDirectory();
        $test        = $dispatchDir . DIRECTORY_SEPARATOR . $fileSpec;
        
        if (!file_exists($test) || !$fh = @fopen($test, 'r', true)) { //TODO проверка из Zend Loader, на более новом фрэймворке - проверка изменена
            return false;
        }

        return true;
    }

}

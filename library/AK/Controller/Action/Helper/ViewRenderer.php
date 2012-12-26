<?php
class AK_Controller_Action_Helper_ViewRenderer extends Zend_Controller_Action_Helper_ViewRenderer
{
    protected $_viewSuffix = 'tpl';
    /**
     * Retrieve front controller instance
     *
     * @return Zend_Controller_Front
     */
    public function getFrontController ()
    {
        if (null === $this->_frontController) {
            $this->_frontController = AK_Controller_Front::getInstance();
        }
        return $this->_frontController;
    }
    public function initView ($path = null, $prefix = null, array $options = array())
    {
        if (null === $this->view) {
            $this->setView(new AK_View_Smarty());
            
        }
        // Reset some flags every time
        $options['noController'] = (isset($options['noController'])) ? $options['noController'] : false;
        $options['noRender'] = (isset($options['noRender'])) ? $options['noRender'] : false;
        $this->_scriptAction = null;
        $this->_responseSegment = null;
        // Set options first; may be used to determine other initializations
        $this->_setOptions($options);
        // Get base view path
        if (empty($path)) {
            $path = $this->_getBasePath();
            if (empty($path)) {
                throw new Zend_Controller_Action_Exception('ViewRenderer initialization failed: retrieved view base path is empty');
            }
        }
        if (null === $prefix) {
            $prefix = $this->_generateDefaultPrefix();
        }
        // Determine if this path has already been registered
        $currentPaths = $this->view->getScriptPaths();
        $path = str_replace(array(
            '/' , 
            '\\'), DIRECTORY_SEPARATOR, $path);
        $pathExists = false;
        foreach ($currentPaths as $tmpPath) {
            if (strstr($tmpPath, $path)) {
                $pathExists = true;
                break;
            }
        }
        if (! $pathExists) {
            $this->view->addBasePath($path, $prefix);
        }
        // Register view with action controller (unless already registered)
        if ((null !== $this->_actionController) && (null === $this->_actionController->view)) {
            $this->_actionController->view = $this->view;
            $this->_actionController->viewSuffix = $this->_viewSuffix;
        }
    }
}

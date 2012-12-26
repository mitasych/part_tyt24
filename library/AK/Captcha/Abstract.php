<?php

abstract class AK_Captcha_Abstract 
{
    private $request;
    private $key;
    private $session;
    protected $keystring;
    private $caseSensitive = 0;
    protected $tempfolder;
    protected $maxlifetime = 300; //Maximum lifetime of a captcha (in seconds) before being deleted during garbage collection
    
    public function setRequest($value) {
        if (!($value instanceof Zend_Controller_Request_Abstract)) {
            throw new Exception ('incorrect request object');
        }
        
        $this->request = $value;
        return $this;
    }

    public function getRequest() {
        return $this->request;
    }

    public function validateSubmit() {
        if ( !$this->getRequest() ||
             !$this->getKey() ||
             !$this->getRequest()->getParam($this->getKey()) ) return false;
        
        if (!$this->caseSensitive) {
            $_keystring = strtolower($this->getKeystring());
            $_attempt = strtolower($this->getRequest()->getParam($this->getKey()));
        } else {
            $_keystring = $this->getKeystring();
            $_attempt = $this->getRequest()->getParam($this->getKey());
        }
        //print $_attempt.'---'.$_keystring; 
        if( $_keystring  == $_attempt) {
            return true;
        }
        
        return false;
    }
    
    public function isPostBack() {
        if ($this->request->getParam($this->key)) {
            return true;
        }
        return false;
    }
    
    public function clear() {
        unset($_SESSION['captcha'][$this->key]);
    }

    public function setKey($value) {
        if (empty($value)) {
            throw new Exception ('incorrect key value');
        }
        
        $this->key = $value;
        $this->session->$value = $value;
        return $this;
    }

    public function getKey() {
        return $this->key;
    }

    protected function setKeystring($value) {
        if (empty($value)) {
            throw new Exception ('incorrect keystring value');
        }
        
        $this->keystring = $value;
        $_SESSION['captcha'][$this->getKey()] = $this->keystring;
        return $this;
    }

    public function getKeystring() {
        if (empty($this->keystring) && !empty($_SESSION['captcha'][$this->getKey()]) ) {
            $this->keystring = $_SESSION['captcha'][$this->getKey()];
        }
        return $this->keystring;
    }
    
    public function __construct() {
        if (!isset($_SESSION['captcha'])) $_SESSION['captcha'] = array();
    }
        
}
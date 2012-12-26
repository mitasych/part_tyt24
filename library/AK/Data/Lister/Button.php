<?php
class AK_Data_Lister_Button
{
    private $NAME;
    private $TYPE;
    private $VALUE;
    private $CLASS;
    private $WIDTH;
    //private $EVENT;
    
    private $action;  //на какой экшен посылать массив ид
    private $confirm; //сообщение подтверждения 
    
    /**
     *
     */
    public function setAction ($value)
    {
        $this->action = $value;
        return $this;
    }
    public function getAction ()
    {
        return $this->action;
    }
    /**
     *
     */
    public function setConfirm ($value)
    {
        $this->confirm = $value;
        return $this;
    }
    public function getConfirm ()
    {
        return $this->confirm;
    }
    /**
     *
     */
    public function setNAME ($value)
    {
        $this->NAME = $value;
        return $this;
    }
    public function getNAME ()
    {
        return $this->NAME;
    }
    /**
     *
     */
    public function setTYPE ($value)
    {
        $this->TYPE = $value;
        return $this;
    }
    public function getTYPE ()
    {
        return $this->TYPE;
    }
    /**
    *
    */
    public function setVALUE ($value)
    {
        $this->VALUE = $value;
        return $this;
    }
    public function getVALUE ()
    {
        return $this->VALUE;
    }
    /**
     * Enter description here...
     *
     * @param unknown_type $value
     * @return unknown
     */
    public function setCLASS ($value)
    {
        $this->CLASS = $value;
        return $this;
    }
    public function getCLASS ()
    {
        return $this->CLASS;
    }
    /**
     *
     */
    public function setWIDTH ($value)
    {
        $this->WIDTH = $value;
        return $this;
    }
    public function getWIDTH ()
    {
        return $this->WIDTH;
    }
    /**
     *
     */
   // public function setEVENT ($value)
   // {
   //     $this->EVENT = $value;
   //     return $this;
   // }
   // public function getEVENT ()
   // {
   //     return $this->EVENT;
   // }
    /*$this->m_BUTTON[] = array(
	    "NAME"                      =>   "DELETE",
	    "TYPE"                      =>   "submit",
	    "VALUE"                     =>   "Удалить выбранных",
	    "CLASS"                     =>   "submit",
	    "WIDTH"                     =>   "",
	    "EVENT"                     =>   "onClick=\"return confirm('Вы действительно хотите удалить выбранных пользователей?');\"",
	);*/
    public function __construct ()
    {
        $this->setDefaults();
    }
    private function setDefaults ()
    {
        $this->setAction('');
        $this->setConfirm('');
        
        $this->setNAME('');
        $this->setTYPE('submit');
        $this->setVALUE('');
        $this->setCLASS('submit');
        $this->setWIDTH('');
       // $this->setEVENT('');
    }
}

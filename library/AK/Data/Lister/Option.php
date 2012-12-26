<?php
class AK_Data_Lister_Option
{
    
    private $TEXT_LABEL;
    private $TEXT_STRONG;
    private $TEXT_COLOR;
    private $LINK_HREF;
    private $LINK_ABS;
    private $LINK_CLASS;
    private $LINK_STYLE;
    private $LINK_EVENT;
    private $LINK_TARGET;
   
    /**
     * 
     */
    public function setTEXT_LABEL ($value)
    {
        $this->TEXT_LABEL = $value;
        return $this;
    }
    public function getTEXT_LABEL ()
    {
        return $this->TEXT_LABEL;
    }
    
    /**
     * 
     */
    public function setTEXT_STRONG ($value)
    {
        $this->TEXT_STRONG = $value;
        return $this;
    }
    public function getTEXT_STRONG ()
    {
        return $this->TEXT_STRONG;
    }
    /**
     * 
     */
    public function setTEXT_COLOR ($value)
    {
        $this->TEXT_COLOR = $value;
        return $this;
    }
    public function getTEXT_COLOR ()
    {
        return $this->TEXT_COLOR;
    }
    /**
     * 
     */
    public function setLINK_HREF ($value)
    {
        $this->LINK_HREF = $value;
        return $this;
    }
    public function getLINK_HREF ()
    {
        return $this->LINK_HREF;
    }
    /**
     * 
     */
    public function setLINK_ABS ($value)
    {
        $this->LINK_ABS = $value;
        return $this;
    }
    public function getLINK_ABS ()
    {
        return $this->LINK_ABS;
    }
    /**
     * 
     */
    public function setLINK_CLASS ($value)
    {
        $this->LINK_CLASS = $value;
        return $this;
    }
    public function getLINK_CLASS ()
    {
        return $this->LINK_CLASS;
    }
    /**
     * 
     */
    public function setLINK_STYLE ($value)
    {
        $this->LINK_STYLE = $value;
        return $this;
    }
    public function getLINK_STYLE ()
    {
        return $this->LINK_STYLE;
    }
    /**
     * 
     */
    public function setLINK_EVENT ($value)
    {
        $this->LINK_EVENT = $value;
        return $this;
    }
    public function getLINK_EVENT ()
    {
        return $this->LINK_EVENT;
    }
    /**
     * 
     */
    public function setLINK_TARGET ($value)
    {
        $this->LINK_TARGET = $value;
        return $this;
    }
    public function getLINK_TARGET ()
    {
        return $this->LINK_TARGET;
    }
   
    
    /*$this->m_OPTION[] = array(
	    "TEXT_LABEL"                =>   "<font color=green>Изменить</font><br />",
	    "TEXT_STRONG"               =>   false,
	    "TEXT_COLOR"                =>   "",
	    "LINK_HREF"                 =>   "administrators.php?action=edit_item",
	    "LINK_ABS"                  =>   true,
	    "LINK_CLASS"                =>   "options",
	    "LINK_STYLE"                =>   "",
	    "LINK_EVENT"                =>   "",
	    "LINK_TARGET"               =>   "",
	);*/
    
    public function __construct ()
    {
        $this->setDefaults();
    }
    private function setDefaults ()
    {
        $this->setTEXT_LABEL('');
        $this->setTEXT_STRONG(false);
        $this->setTEXT_COLOR('');
        $this->setLINK_HREF('');
        $this->setLINK_ABS(true);
        $this->setLINK_CLASS('options');
        $this->setLINK_STYLE('');
        $this->setLINK_EVENT('');
        $this->setLINK_TARGET('');
    }
    

}

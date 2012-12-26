<?php

class AK_Data_Lister_Field
{
    private $SQL_FIELD;
    //@todo удалить private $SQL_TABLE;
    private $FILTER_TYPE;
    private $FILTER_VARIANT;
    private $FILTER_LABEL;
    private $SORTING;
    private $SORT_FIELD;
    private $TEXT_LABEL;
    private $TEXT_LABEL_VALUE;
    private $TEXT_HTML;
    private $TEXT_STRONG;
    private $TEXT_COLOR;
    private $LINK_HREF;
    private $LINK_ABS;
    private $LINK_CLASS;
    private $LINK_STYLE;
    private $LINK_EVENT;
    private $LINK_TARGET;
    private $TD_WIDTH;
    private $TD_ALIGN;
    private $TD_VALIGN;
    private $TD_NOWRAP;
    private $TD_CLASS;
    private $TD_STYLE;
    private $TD_EVENT;
    
    private $isPrimary;
    private $isSorting;
    
    /**
     *  PRIMARY
     */
    public function setIsPrimary ($value)
    {
        $this->isPrimary = $value;
        return $this;
    }
    public function getIsPrimary ()
    {
        return $this->isPrimary;
    }
    /**
     *  SORTING
     */
    public function setIsSorting ($value)
    {
        $this->isSorting = $value;
        return $this;
    }
    public function getIsSorting ()
    {
        return $this->isSorting;
    }
    /**
     * 
     */
    public function setSQL_FIELD ($value)
    {
        $this->SQL_FIELD = $value;
        return $this;
    }
    public function getSQL_FIELD ()
    {
        return $this->SQL_FIELD;
    }
    /**
     * 
     */
    public function setFILTER_TYPE ($value)
    {
        $this->FILTER_TYPE = $value;
        return $this;
    }
    public function getFILTER_TYPE ()
    {
        return $this->FILTER_TYPE;
    }
    /**
     * 
     */
    public function setFILTER_VARIANT ($value)
    {
        $this->FILTER_VARIANT = $value;
        return $this;
    }
    public function getFILTER_VARIANT ()
    {
        return $this->FILTER_VARIANT;
    }
    /**
     * 
     */
    public function setFILTER_LABEL ($value)
    {
        $this->FILTER_LABEL = $value;
        return $this;
    }
    public function getFILTER_LABEL ()
    {
        return $this->FILTER_LABEL;
    }
    /**
     * 
     */
    public function setSORTING ($value)
    {
        $this->SORTING = $value;
        return $this;
    }
    public function getSORTING ()
    {
        return $this->SORTING;
    }
    /**
     * 
     */
    public function setSORT_FIELD ($value)
    {
        $this->SORT_FIELD = $value;
        return $this;
    }
    public function getSORT_FIELD ()
    {
        return $this->SORT_FIELD;
    }
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
    public function setTEXT_LABEL_VALUE ($value)
    {
        $this->TEXT_LABEL_VALUE = $value;
        return $this;
    }
    public function getTEXT_LABEL_VALUE ()
    {
        return $this->TEXT_LABEL_VALUE;
    }
    /**
     * 
     */
    public function setTEXT_HTML ($value)
    {
        $this->TEXT_HTML = $value;
        return $this;
    }
    public function getTEXT_HTML ()
    {
        return $this->TEXT_HTML;
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
    /**
     * 
     */
    public function setTD_WIDTH ($value)
    {
        $this->TD_WIDTH = $value;
        return $this;
    }
    public function getTD_WIDTH ()
    {
        return $this->TD_WIDTH;
    }
    /**
     * 
     */
    public function setTD_ALIGN ($value)
    {
        $this->TD_ALIGN = $value;
        return $this;
    }
    public function getTD_ALIGN ()
    {
        return $this->TD_ALIGN;
    }
    /**
     * 
     */
    public function setTD_VALIGN ($value)
    {
        $this->TD_VALIGN = $value;
        return $this;
    }
    public function getTD_VALIGN ()
    {
        return $this->TD_VALIGN;
    }
    /**
     * 
     */
    public function setTD_NOWRAP ($value)
    {
        $this->TD_NOWRAP = $value;
        return $this;
    }
    public function getTD_NOWRAP ()
    {
        return $this->TD_NOWRAP;
    }
    /**
     * 
     */
    public function setTD_CLASS ($value)
    {
        $this->TD_CLASS = $value;
        return $this;
    }
    public function getTD_CLASS ()
    {
        return $this->TD_CLASS;
    }
    /**
     * 
     */
    public function setTD_STYLE ($value)
    {
        $this->TD_STYLE = $value;
        return $this;
    }
    public function getTD_STYLE ()
    {
        return $this->TD_STYLE;
    }
    /**
     * 
     */
    public function setTD_EVENT ($value)
    {
        $this->TD_EVENT = $value;
        return $this;
    }
    public function getTD_EVENT ()
    {
        return $this->TD_EVENT;
    }
    /*$this->m_FIELD[] = array(
	    "SQL_FIELD"                 =>   "admin_id",
	    "SQL_TABLE"                 =>   "administrators",
	    "FILTER_TYPE"               =>   "text",
	    "FILTER_VARIANT"            =>   "",
	    "FILTER_LABEL"              =>   "",
	    "SORTING"                   =>   true,
	    "TEXT_LABEL"                =>   "ID",
	    "TEXT_LABEL_VALUE"          =>   "",
	    "TEXT_HTML"                 =>   false,
	    "TEXT_STRONG"               =>   false,
	    "TEXT_COLOR"                =>   "",
	    "LINK_HREF"                 =>   "",
	    "LINK_ABS"                  =>   true,
	    "LINK_CLASS"                =>   "",
	    "LINK_STYLE"                =>   "",
	    "LINK_EVENT"                =>   "",
	    "LINK_TARGET"               =>   "",
	    "TD_WIDTH"                  =>   "",
	    "TD_ALIGN"                  =>   "left",
	    "TD_VALIGN"                 =>   "top",
	    "TD_NOWRAP"                 =>   false,
	    "TD_CLASS"                  =>   "t_text",
	    "TD_STYLE"                  =>   "",
	    "TD_EVENT"                  =>   "",
	);*/
    public function __construct ()
    {
        $this->setDefaults();
    }
    private function setDefaults ()
    {
        $this->setSQL_FIELD('');
        $this->setFILTER_TYPE('text');
        $this->setFILTER_VARIANT('');
        $this->setFILTER_LABEL('');
        $this->setSORTING(true);
        $this->setTEXT_LABEL('');
        $this->setTEXT_LABEL_VALUE('');
        $this->setTEXT_HTML(false);
        $this->setTEXT_STRONG(false);
        $this->setTEXT_COLOR('');
        $this->setLINK_HREF('');
        $this->setLINK_ABS('false');
        $this->setLINK_CLASS('');
        $this->setLINK_STYLE('');
        $this->setLINK_EVENT('');
        $this->setLINK_TARGET('');
        $this->setTD_WIDTH('');
        $this->setTD_ALIGN('left');
        $this->setTD_VALIGN('top');
        $this->setTD_NOWRAP(false);
        $this->setTD_CLASS('t_text');
        $this->setTD_STYLE('');
        $this->setTD_EVENT('');
        
        $this->setIsPrimary(false);
        $this->setIsSorting(false);
    }
}

<?php
abstract class AK_Abstract_List 
{
	/**
	 * DB Connection object
	 */
	protected $_db;
	/**
	 * Current Page for list
	 */
	protected $_currentPage;
	/**
	 * number of items per page
	 */
	protected $_listSize;
	/**
	 * order string for results
	 */
	protected $_order;
	/**
	 * return results as assoc
	 */
	protected $_asAssoc = false;
	
	/**
	 * name of db field for assoc array key
	 */
	protected $_assocKey;
	
	/**
	 * name of db field for assoc array value
	 */
	protected $_assocValue;
	
	/**
	 * additional where for select
	 */
	protected $_where;
	
	 /**
     * ids of items for include
     */
    protected $_includeIds;
    
    /**
     * ids of items for exclude
     */
    protected $_excludeIds;
	
	/**
	 * Constructor
	 * @return void
	 * @author Artem Sukharev
	 */
	public function  __construct()
	{
		$this->_db = Zend_Registry :: get('DB');
	}
	
    /**
     * return current page
     * @return int current page
     * @author Artem Sukharev
     */
    public function getCurrentPage()
    {
        return $this->_currentPage;
    }
    
    /**
     * set current page
     */
    public function setCurrentPage($page)
    {
    	if ( !is_numeric($page) || $page < 1 ) $page = 1;
        $this->_currentPage = $page;
        return $this;
    }
	
    /**
     * return number of items per page
     * @author Artem Sukharev
     */
    public function getListSize()
    {
        return $this->_listSize;
    }

    /**
     * set number of items per page
     */
    public function setListSize($size)
    {
    	if ( !is_numeric($size) || $size < 1 ) $size = 1;
        $this->_listSize = $size;
        return $this;
    }

    
    /* мне немного стыдно за этот метод $this->getCount() :)  @author MSQ */
    
    public function getPagesCount()
    {//print $this->_listSize.' -- '.$this->_currentPage;
        if (empty($this->_listSize) && empty($this->_currentPage) ) return 1;
        
        return ceil($this->getCount()/$this->_listSize);
    }
    
    /**
     * return order string
     * @author Artem Sukharev
     */
    public function getOrder()
    {
        return $this->_order;
    }

    /**
     * set order string
     */
    public function setOrder($order)
    {
        $this->_order = $order;
        return $this;
    }
    
    /**
     * set assoc mode
     */
    public function returnAsAssoc($mode = true)
    {
    	$this->_asAssoc = (boolean) $mode;
    	return $this;
    }

    /**
     * return assoc mode
     * @return boolean
     * @author Artem Sukharev
     */
    public function isAsAssoc()
    {
    	return (boolean) $this->_asAssoc;
    }
    
    /**
     * set name of db field for assoc array key
     */
    public function setAssocKey($fieldName)
    {
    	$this->_assocKey = $fieldName;
    	return $this;
    }

    /**
     * set name of db field for assoc array key
     * @author Artem Sukharev
     */
    public function getAssocKey()
    {
    	return $this->_assocKey;    	
    }
    
    /**
     * set name of db field for assoc array value
     */
    public function setAssocValue($fieldName)
    {
        $this->_assocValue = $fieldName;
        return $this;
    }

    /**
     * set name of db field for assoc array value
     * @author Artem Sukharev
     */
    public function getAssocValue()
    {
        return $this->_assocValue;
    }
    
    /**
     * return additional where
     * @return string
     * @author Artem Sukharev
     */
    public function getWhere()
    {
        if ( $this->_where === null ) return '';
        else return join(' ', $this->_where); 
    }
    
    /**
     * add where as AND
     */
    public function addWhere($cond)
    {   
        if (func_num_args() > 1) {
            $val = func_get_arg(1);
            $cond = $this->_db->quoteInto($cond, $val);
        }
        if ($this->_where) {
            $this->_where[] = 'AND ' . $cond;
        } else {
            $this->_where[] = $cond;
        }
        return $this;
    }
    
    /**
     * add where as OR
     */
    public function addWhereOr($cond)
    {
        if (func_num_args() > 1) {
            $val = func_get_arg(1);
            $cond = $this->_db->quoteInto($cond, $val);
        }
        if ($this->_where) {
            $this->_where[] = 'OR ' . $cond;
        } else {
            $this->_where[] = $cond;
        }
        return $this;
    }
    
    /**
     * remove all aditional where for select
     */
    public function clearWhere()
    {
    	$this->_where = null;
    }
    
    /**
     * set include Ids
     */    
    public function setIncludeIds($newVal)
    {
    	if ( !is_array($newVal) ) $newVal = array($newVal);
    	$this->_includeIds = $newVal;
    	return $this;
    }
    
    /**
     * return include ids
     * @return array
     * @author Artem Sukharev
     */
    public function getIncludeIds()
    {
    	return $this->_includeIds;
    }

    /**
     * set exclude Ids
     */    
    public function setExcludeIds($newVal)
    {
        if ( !is_array($newVal) ) $newVal = array($newVal);
        $this->_excludeIds = $newVal;
        return $this;
    }
    
    /**
     * return exclude ids
     * @return array
     * @author Artem Sukharev
     */
    public function getExcludeIds()
    {
        return $this->_excludeIds;
    }
    
    /**
     * reset all params of list
     */
    public function resetList()
    {
        $this->_currentPage    = null;
        $this->_listSize       = null;
        $this->_asAssoc        = false;
        $this->_assocKey       = null;
        $this->_assocValue     = null;
        $this->_excludeIds     = null;
        $this->_includeIds     = null;
        $this->_listSize       = null;
        $this->_membersRole    = null;
        $this->_membersStatus  = null;
        $this->_order          = null;
        $this->clearWhere();
        return $this;
    }
    
    /**
     *  return list of all items
     *  @return array of objects
     *  @author Artem Sukharev
     */
    abstract public function getList();
    
    /**
     * return number of all items
     * @return int count
     * @author Artem Sukharev
     */
    abstract public function getCount();
}

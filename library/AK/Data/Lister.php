<?php
/**
 * AK FRAMEWORK
 *
 * @package    AK_Data_Lister
 * @copyright  Copyright (c) 2007
 * @author     Alexander Komarovski
 */
class AK_Data_Lister
{
    /**
     * AK_Abstract_List object
     *
     * @var instance of AK_Abstract_List
     */
    private $list;
    private $namespace;
    /**
     *
     */
    private $templatesEngine;
    private $template;
    /**
     * 
     */
	 private $imagesUrl;
     private $colspan; // var $m_colspan;
	/**
	 * 
	 */
     private $defaultSortDirection = "ASC";
     private $defaultSortOrder = null;
     private $currentSortDirection;
     private $currentSortOrder;
    /**
     * 
     */     
    private $buttons; //var $m_BUTTON;
    private $fields; //var $m_FIELD;
    private $records;//list->getList()
    private $toplinks;  //   var $m_TOP_LINK;   
    private $options;  // var $m_OPTION;
    private $filters;  //  var $m_FILTERS;  
    
    private $primaryField = null; //поле, являющееся первичным ключем
    private $sortingField = null; //поле, содердащее данные QUEUE
    
    public $currentFilterField;
    public $currentFilterValue; 
    
    public $filterEnabled = false;
    /**
     * 
     */
    public $PARAM_OPTION_ALIGN = "center";
    public $PARAM_OPTION_VALIGN = "top";
    public $PARAM_OPTION_NOWRAP = true;
    public $PARAM_OPTION_WIDTH = "";
    public $PARAM_OPTION_DELIM = "::";
    
    public $PARAM_SCRIPT;
    
    public $PARAM_PAG_PANEL = true;    //отображение пагинатора
    public $PARAM_EL_CHECKBOX = true; //чекбоксы для групповых действий
    public $PARAM_EL_SORTING = true;  //инпуты для групповой сортировки
    
    private $loopVars;//значения каких атрибутов крутить в списке    
    
    public $noRenderFilters;
        
        
        
    
 
    public function setList ($value)
    {
        if ($value instanceof AK_Abstract_List) {
            $this->list = $value;
        }
        return $this;
    }
    public function getList ()
    {
        return $this->list;
    }
    /**
     * 
     */
    public function setNamespace ($value)
    {
        $this->namespace = $value;
        return $this;
    }
    public function getNamespace ()
    {
        return $this->namespace;
    }
    /**
     * 
     */
    public function getButtons()
    {
    	return $this->buttons;
    }
	public function getRecords()
    {
    	return $this->records;
    }
	public function getFields()
    {
    	return $this->fields;
    }
    public function getTopLinks()
    {
        return $this->toplinks;
    }
    public function getOptions()
    {
        return $this->options;
    }
    public function getFilters()
    {
        return $this->filters;
    }
    
    public function getLoopVars()
    {
        return $this->loopVars;
    }
    /**
     * 
     */
	private function setImagesUrl($value)
    {
    	 $this->imagesUrl = $value;
         return $this;
    }
	public function getImagesUrl()
    {
    	return $this->imagesUrl;
    }
    
    /* PRIMARY, SORTING */
    public function getPrimaryField()
    {
        return $this->primaryField;
    }
    public function getSortingField()
    {
        return $this->sortingField;
    }
    
    /* COLSPAN */
    private function setColspan($value)
    {
         $this->colspan = $value;
         return $this;
    }
    public function getColspan()
    {
        return $this->colspan;
    }
    /* FILTER */
    private function setFilter($field=null, $value=null){
         if (isset($field) && isset($value)) {
            $_SESSION['LISTER'][$this->namespace]['FILTER']['FIELD'] = $field;
            $_SESSION['LISTER'][$this->namespace]['FILTER']['VALUE'] = $value;
            $this->setPaginatorPagenum(1);
         }
         
         return $this;
    }
    private function resetFilter(){
         unset($_SESSION['LISTER'][$this->namespace]['FILTER']);
    }
    /* SORTING */
    private function setSortDirection($value)
    {
         if (!empty($value)) {
            $this->sortDirection = $value;
            $_SESSION['LISTER'][$this->namespace]['SORT']['DIRECTION'] = $this->sortDirection;
         }
         
         return $this;
    }
    public function getSortDirection()
    {
        return $this->sortDirection;
    }
    private function setSortOrder($value)
    {
         if (!empty($value)) {
            $this->sortOrder = $value;
            $_SESSION['LISTER'][$this->namespace]['SORT']['ORDER'] = $this->sortOrder;
         }
         
         return $this;
    }
    public function getSortOrder()
    {
        return $this->sortOrder;
    }
    /* PAGINATOR */
    public function setPaginatorPerpage($value)
    {
         if (empty ($_SESSION['LISTER'][$this->namespace]['PAGINATOR']['PERPAGE']) ){
            $_SESSION['LISTER'][$this->namespace]['PAGINATOR']['PERPAGE'] = 20;
         }
         
         if (!empty($value)) {
            $_SESSION['LISTER'][$this->namespace]['PAGINATOR']['PERPAGE'] = $value;
         }
         return $this;
    }
    public function setPaginatorPagenum($value)
    {
         if (empty ($_SESSION['LISTER'][$this->namespace]['PAGINATOR']['PAGENUM']) ){
            $_SESSION['LISTER'][$this->namespace]['PAGINATOR']['PAGENUM'] = 1;
         }
         
         if (!empty($value)) {
            $_SESSION['LISTER'][$this->namespace]['PAGINATOR']['PAGENUM'] = $value;
         }
         return $this;
    }
    /* SORTING DEFAULTS */
    public function setDefaultSortDirection($value)
    {
         if (!empty($value) && empty($_SESSION['LISTER'][$this->namespace]['SORT']['DIRECTION']) ) {
            $this->defaultSortDirection = $value;
            $_SESSION['LISTER'][$this->namespace]['SORT']['DIRECTION'] = $this->defaultSortDirection;
         }
         
         return $this;
    }
    public function getDefaultSortDirection()
    {
        return $this->defaultSortDirection;
    }
    public function setDefaultSortOrder($value)
    {
         if (!empty($value) && empty($_SESSION['LISTER'][$this->namespace]['SORT']['ORDER']) ) {
            $this->defaultSortOrder = $value;
            $_SESSION['LISTER'][$this->namespace]['SORT']['ORDER'] = $this->defaultSortOrder;
         }
         
         return $this;
    }
    public function getDefaultSortOrder()
    {
        return $this->defaultSortOrder;
    }
    
    public function noRenderFilters($val=0)
    {
    	$this->noRenderFilters = $val;
    }
    
    
    /**
     *  CONSTRUCTOR
     */
    public function __construct ($list, $request, $namespace = 'undefined')
    {
        $this->setList($list);
             
        $this->setNamespace($namespace);
        
        
        $this->setSortOrder($request->getParam('order'));
        $this->setSortDirection($request->getParam('dir'));
        $this->setFilter($request->getParam('filterfield'), $request->getParam('filtervalue'));
        
        if ($request->getParam('filterreset')) $this->resetFilter(); 
        
        $this->setPaginatorPerpage($request->getParam('perpage'));
        $this->setPaginatorPagenum($request->getParam('pagenum'));
        
        /**
         * 
         */
        $this->templatesEngine = new Smarty();
        $this->templatesEngine->compile_dir = SMARTY_COMPILE_DIR.'/'.MODULE_NAME;
        $this->templatesEngine->template_dir = APP_DIR.'/'.MODULE_NAME.'/views/scripts';
        $this->template = 'lister/lister.tpl';
        /**
         * 
         */
		    $this->setImagesUrl(SITE_URL.'/admin/images/lister/');
        
        /**
         * 
         */
        $this->buttons = array();
        $this->fields = array();
        $this->options = array();
        $this->toplinks = array();
        $this->filters = array();
        
        $this->loopVars = array();
        /*
         * 
         * 
         * function Lister (&$REQ, $param = false, $_module = "", $useFilter = true)
    {
        BaseObject::BaseObject();
        $this->m_module = $_module;
        $this->m_useFilter = $useFilter;
        $this->m_REQ = &$REQ;
        $this->m_evals = array();
        $this->m_vars = array();
        
        $this->m_pages = array();
        $this->m_FIELD = array();
        $this->m_OPTION = array();
        $this->m_OPTION_HOR = array();
        $this->m_TOP_LINK = array();
        $this->m_BUTTON = array();
        $this->m_FILTERS = array();
        $this->all_sql = "";
        #   DETECT SUBMODE  ----------------------------------------
        if (isset($this->m_REQ["subaction"])) {
            switch ($this->m_REQ["subaction"]) {
                case "reset":
                    $this->resetAll();
                    break;
                case "save":
                    $this->reset();
                    break;
                case "set_order":
                    $this->setOrder();
                    break;
                case "set_page_count":
                    $this->setPageCount();
                    break;
                case "set_filter":
                    $this->setFilter();
                    break;
            }
        }
        $this->setCurrPage();
        #   SET DEFAULT VARABLES    --------------------------------
        if (! isset($_SERVER["SCRIPT_NAME"]))
            $_SERVER["SCRIPT_NAME"] = "?";
        if (! isset($this->m_REQ["action"]))
            $this->m_REQ["action"] = "";
        if (defined("TPL_PATH"))
            $fname = TPL_PATH . "/lister.tpl"; else
            $fname = "lister.tpl";
        $this->m_PARAM["PARAM_TEMPLATE"] = $fname;
        $this->m_PARAM["PARAM_SCRIPT"] = $_SERVER["SCRIPT_NAME"];
        $this->m_PARAM["PARAM_ACTION"] = $this->m_REQ["action"];
        $this->m_PARAM["PARAM_GROUP_ACTION"] = "";
        $this->m_PARAM["PARAM_PAG_PANEL"] = true;
        $this->m_PARAM["PARAM_EL_NUMBERING"] = true;
        $this->m_PARAM["PARAM_EL_CHECKBOX"] = true;
        $this->m_PARAM["PARAM_EL_RADIO"] = false;
        $this->m_PARAM["PARAM_GTD_WIDTH"] = "100%";
        $this->m_PARAM["PARAM_GTD_ALIGN"] = "";
        $this->m_PARAM["PARAM_OPTION_ALIGN"] = "center";
        $this->m_PARAM["PARAM_OPTION_VALIGN"] = "top";
        $this->m_PARAM["PARAM_OPTION_NOWRAP"] = false;
        $this->m_PARAM["PARAM_OPTION_WIDTH"] = "";
        $this->m_PARAM["PARAM_OPTION_DELIM"] = "::";
        $this->m_PARAM["pages_pre_list"] = 10;
        $this->init($param);
        if (! isset($_SESSION["element_pre_page"][$this->m_module]))
            $_SESSION["element_pre_page"][$this->m_module] = 40;
            #   INIT TEMPLATE   ----------------------------------------
        //$options = array('filename'          => $this->m_PARAM["PARAM_TEMPLATE"],
        //                'debug'             => 0,
        //               'global_vars'       => 1,
        //              'loop_context_vars' => 1);
        
    }
         */
    }
    
    
    
    
    
    /*
        По алиасу столбца возвращает поле в выборке с префиксами (getSORT_FIELD) для использовании в setOrder абстрактного списка
    */
    function getSQLFieldByFieldTitle ($value)
    {
        foreach ($this->fields as &$field) {
            if ($field->getSQL_FIELD() == $value) {
                return $field->getSORT_FIELD();
            }
        
        }
        
        return false;
    }
    
    // по назвнию поля возвращает вхере из массива фильтров
    public function getFilterWhereByField($field) {
        foreach ($this->filters as &$_v) {
            if ($_v->field == $field) return $_v->where;
        }
        return false;
    }
    
    
    /**
     * 
     */
    public function addField ($field)
    {
        $this->fields[] = $field;
        
        if ($field->getIsPrimary()){$this->primaryField = $field;}
        if ($field->getIsSorting()){$this->sortingField = $field;}
        
        return true;
    }
    /**
     * 
     */
    public function addButton ($button)
    {
        $this->buttons[] = $button;
        return true;
    }
    /**
     * 
     */
    function addOption ($option)
    {
        $this->options[] = $option;
        return true;
    }
    /**
     * 
     */
    function addTopLink ($toplink)
    {
        $this->toplinks[] = $toplink;
        return true;
    }
    /**
     * 
     */
    function addFilter ($filter)
    {
        $this->filters[] = $filter;
        return true;
    }
    /**
     * 
     */
    function addLoopVar ($value)
    {
        $this->loopVars[] = $value;
    }
    //==============================================================================================================================
    /**
     * Enter description here...
     *
     * @return unknown
     */
    public function getOutput ()
    {
    	//colspan
        $this->colspan = count($this->getFields());//количество полей
        if (count($this->getOptions()) >0) $this->colspan ++ ;//столбец опций
        if ($this->PARAM_EL_CHECKBOX && $this->getPrimaryField() && count($this->getButtons()) >0) $this->colspan ++ ;//столбец чекбоксов
        if ($this->PARAM_EL_SORTING && $this->getPrimaryField() && $this->getSortingField() && count($this->getButtons()) >0) $this->colspan ++ ;//столбец чекбоксов
        
            
       //ORDER
        if (!empty($_SESSION['LISTER'][$this->namespace]['SORT']['ORDER']) ) {
            $_direction = empty($_SESSION['LISTER'][$this->namespace]['SORT']['DIRECTION'])?'':' '.$_SESSION['LISTER'][$this->namespace]['SORT']['DIRECTION'];
            
            if (!in_array($_direction, array(' ASC', ' DESC') )) $_direction = '';
            //print $this->getSQLFieldByFieldTitle($_SESSION['LISTER'][$this->namespace]['SORT']['ORDER']);
            $this->list->setOrder($this->getSQLFieldByFieldTitle($_SESSION['LISTER'][$this->namespace]['SORT']['ORDER']).$_direction);
            
            if (!empty($_SESSION['LISTER'][$this->namespace]['SORT']['DIRECTION']) ) $this->setSortDirection($_SESSION['LISTER'][$this->namespace]['SORT']['DIRECTION']);
            if (!empty($_SESSION['LISTER'][$this->namespace]['SORT']['ORDER']) ) $this->setSortOrder($_SESSION['LISTER'][$this->namespace]['SORT']['ORDER']);
        }
        //print_r($_SESSION['LISTER'][$this->namespace]);
        
        //PAGINATOR
        if ($this->PARAM_PAG_PANEL && !empty($_SESSION['LISTER'][$this->namespace]['PAGINATOR']['PERPAGE']) ){
            $this->list->setListSize($_SESSION['LISTER'][$this->namespace]['PAGINATOR']['PERPAGE']);
            
            // print $this->list->getPagesCount(); 
            if (!empty($_SESSION['LISTER'][$this->namespace]['PAGINATOR']['PAGENUM']) && $_SESSION['LISTER'][$this->namespace]['PAGINATOR']['PAGENUM'] <= $this->list->getPagesCount())
            {
            //print 777;
                $this->list->setCurrentPage($_SESSION['LISTER'][$this->namespace]['PAGINATOR']['PAGENUM']);    
            } else {//print 88;
                $this->list->setCurrentPage(1);
            } 
          
        }
        //print($this->list->getOrder());
        
        //FILTER
        if (!empty($_SESSION['LISTER'][$this->namespace]['FILTER']['FIELD']) && isset($_SESSION['LISTER'][$this->namespace]['FILTER']['VALUE']) ) {
            $this->list->addWhere($this->getFilterWhereByField($_SESSION['LISTER'][$this->namespace]['FILTER']['FIELD']), ($_SESSION['LISTER'][$this->namespace]['FILTER']['VALUE']));
            $this->currentFilterField = $_SESSION['LISTER'][$this->namespace]['FILTER']['FIELD'];
            $this->currentFilterValue = ($_SESSION['LISTER'][$this->namespace]['FILTER']['VALUE']);
            $this->filterEnabled = true;            
        }
        
        
        $this->records = $this->list->getList();
    	  $this->templatesEngine->assign("LISTER", $this);
    	  
    	  $this->templatesEngine->assign("MODULE_URL", MODULE_URL);
    
    
        //print_r($_SESSION['LISTER'][$this->namespace]);
        //getCurrentPage(), $this->getListSize());
    
    
    
    	return $this->templatesEngine->fetch($this->template);
    	
    	
    	
        
    }
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
}

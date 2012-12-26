<?php
/**
 *
 */
class AK_View_Smarty extends Zend_View_Abstract
{
    protected $_smarty;
    private $layout = 'main.tpl';
    
    /**
     * Constructor
     */
    public function __construct ($extraParams = array())
    {
        $this->_smarty = Zend_Registry::get('Smarty');
        $this->_smarty->debugging = false;
        foreach ($extraParams as $key => $value) {
            $this->_smarty->$key = $value;
        }
    }
    public function _run ()
    {}
    
    /**
     * 
     */
    public function getLayout ()
    {
        return $this->layout;
    }
    public function setLayout ($value)
    {
        $this->layout = $value;
        return $this;
    }
    /**
     * Возвращение объекта шаблонизатора
     *
     * @return Smarty
     */
    public function getEngine ()
    {
        return $this->_smarty;
    }
    /**
     * Присвоение значения переменной шаблона
     *
     * @param string $key The variable name.
     * @param mixed $val The variable value.
     * @return void
     */
    public function __set ($key, $val)
    {
        $this->_smarty->assign($key, $val);
    }
    /**
     * Получение значения переменной
     *
     * @param string $key The variable name.
     * @return mixed The variable value.
     */
    public function __get ($key)
    {
        return $this->_smarty->get_template_vars($key);
    }
    /**
     * Позволяет проверять переменные через empty() и isset()
     *
     * @param string $key
     * @return boolean
     */
    public function __isset ($key)
    {
        return (null !== $this->_smarty->get_template_vars($key));
    }
    /**
     * Позволяет удалять свойства объекта через unset()
     *
     * @param string $key
     * @return void
     */
    public function __unset ($key)
    {
        $this->_smarty->clear_assign($key);
    }
    /**
     * Присвоение переменных шаблону
     *
     * Позволяет установить значение к определенному ключу или передать массив
     * пар ключ => значение
     *
     * @see __set()
     * @param string|array $spec Ключ или массив пар ключ => значение
     * @param mixed $value (необязательный) Если присваивается значение одной
     * переменной, то через него передается значение переменной
     * @return void
     */
    public function assign ($spec, $value = null)
    {
        if (is_array($spec)) {
            $this->_smarty->assign($spec);
            return;
        }
        $this->_smarty->assign($spec, $value);
    }
    /**
     * Удаление всех переменных
     */
    public function clearVars ()
    {
        $this->_smarty->clear_all_assign();
    }
    /**
     *  Processes a view and print the output.
     */
    public function render ($tpl_name)
    {
        $this->setCompiledDir(SMARTY_COMPILE_DIR . '/' . MODULE_NAME);
        $this->_smarty->template_dir = $this->getScriptPath('');
        if (empty($this->BODY_CONTENT_FILE)) $this->BODY_CONTENT_FILE = $tpl_name;
        //print $this->_smarty->template_dir; die;
        $this->_smarty->display($this->layout);
    }
    /**
     *  Processes a view and returns the output as string.
     */
    public function getContents ($tpl_name)
    {
        $this->setCompiledDir(SMARTY_COMPILE_DIR . '/' . MODULE_NAME);
        $this->_smarty->template_dir = $this->getScriptPath('');
        return ($this->_smarty->fetch($tpl_name));
    }
    /**
     *  Set dirictories for search templates
     */
    public function setCompiledDir ($dir)
    {
        $this->_smarty->compile_dir = $dir;
    }
    
     
}

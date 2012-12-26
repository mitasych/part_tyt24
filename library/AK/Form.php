<?php

class AK_Form
{
    /**
     * name of the form
     * @var string
     */
    public $name = '';

    /**
     * submit method of the form
     * @var enum (get|post)
     */
    public $method = 'post';

    /**
     * submit action of the form
     * @var string
     */
    public $action = '';

    /**
     * Array of default form values
     * @var  array
     */
    public $_defaults = array();

    /**
     * Array containing the form rules
     * @var  array
     */
    private $_rules = array();

    /**
     * Value for maxfilesize hidden element if form contains file input
     * @var  integer
     */
    public $_maxFileSize = 0;

    private $customErrorMessages = array();

    private $isValid = true;

    /**
     * form constructor
     * @param    string      $name          Form's name.
     * @param    string      $method        (optional)Form's method defaults to 'POST'
     * @param    string      $action        (optional)Form's action
     */
    public function __construct($name='', $method='post', $action='')
    {
        $this->name = $name;
        $this->method = strtolower($method);
        $this->action = ($action == '') ? $_SERVER['REQUEST_URI'] : $action;

        if (preg_match('/^([0-9]+)([a-zA-Z]*)$/', ini_get('upload_max_filesize'), $matches))
        switch (strtoupper($matches['2'])) {
            case 'G': $this->_maxFileSize = $matches['1'] * 1073741824; break;
            case 'M': $this->_maxFileSize = $matches['1'] * 1048576;    break;
            case 'K': $this->_maxFileSize = $matches['1'] * 1024;       break;
            default:  $this->_maxFileSize = $matches['1'];
        }
    }
    /**
     * Return true if form has been submitted
     * @author Artem Sukharev
     */
    public function isPostback()
    {
        return isset($_REQUEST['_wf__' . $this->name]);
    }
    /**
     * Return true if form is valid
     * @author Artem Sukharev
     */
    public function isValid()
    {
        return (bool) $this->isValid;
    }
    /**
     * Set for as valid or invalid
     * @author Artem Sukharev
     */
    public function setValid($status = true)
    {
        $this->isValid = (bool) $status;
    }
    /**
     * Return form rules
     * @author Artem Sukharev
     */
    public function getRules()
    {
        return $this->_rules;
    }
    /**
     * Validate form data
     * @param array $params
     * @return bool
     */
    public function validate($params)
    {
        // form not submitted, abort
        if (!$this->isPostback()) return false;

        $error = false;
//print_r($this->_rules);die;
        // check element rules
        foreach($this->_rules as $element => &$rules){
            $value = isset($params[$element]) ? $params[$element] : null;
            $element_errors_exists =false;
            foreach($rules as &$rule) {

                if  ($element_errors_exists) break;

                if ('server' == $rule['mode']) {
                    switch ($rule['type']){
                        case 'required':
                            if ('' == (string)$value) $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        case 'minlength':
                            $length = strlen((string)$value);
                            if ($length < $rule['options']['min']) $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        case 'maxlength':
                            $length = mb_strlen($value,'UTF-8');
                            if ($length > $rule['options']['max']) $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        case 'rangelength':
                            $length = strlen($value);
                            if ($length < $rule['options']['min'] || $length > $rule['options']['max'])
                            $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        case 'email':
                            $regex = '/^((\"[^\"\f\n\r\t\v\b]+\")|([\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+(\.[\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+)*))@((\[(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))\])|(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))|((([A-Za-z0-9\-])+\.)+[A-Za-z\-]+))$/';
                            if (preg_match($regex, $value)) {
                                if (function_exists('checkdnsrr')) {
                                    $tokens = explode('@', $value);
                                    if (!(checkdnsrr($tokens[1], 'MX') || checkdnsrr($tokens[1], 'A')))
                                    $rule['error'] = $error = $element_errors_exists = true;
                                }
                            } else $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        case 'emptyemail':
                            $regex = '/^((\"[^\"\f\n\r\t\v\b]+\")|([\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+(\.[\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+)*))@((\[(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))\])|(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))|((([A-Za-z0-9\-])+\.)+[A-Za-z\-]+))$/';
                            if (preg_match($regex, $value)) {
                                if (function_exists('checkdnsrr')) {
                                    $tokens = explode('@', $value);
                                    if (!(checkdnsrr($tokens[1], 'MX') || checkdnsrr($tokens[1], 'A')))
                                    $rule['error'] = $error = $element_errors_exists = true;
                                }
                            } elseif ($value !=='') $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        case 'lettersonly':
                            if (!preg_match('/^[a-zA-Z]+$/', $value)) $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        case 'alphanumeric':
                            if (!preg_match('/^[a-zA-Z0-9]+$/', $value)) $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        case 'rewritename':
                            if (!preg_match('/^[a-zA-Z0-9_-]+$/', $value)) $rule['error'] = $error = $element_errors_exists = true;
                            break;    
                        case 'numeric':
                            if (!preg_match('/(^-?\d\d*\.\d*$)|(^-?\d\d*$)|(^-?\.\d\d*$)/', $value)) $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        case 'integer_or_empty':
                            if (!preg_match('/^[0-9]*$/', $value)) $rule['error'] = $error = $element_errors_exists = true;
                            break;
                            
                        case 'url':
                            if (!preg_match('/^(ht|f)tp(s?)\:\/\/[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;%\$#_]*)?$/', $value) && $value!=="") $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        
                        //необязателен http:// etc    
                        case 'site':
                            if (!preg_match('/^(http(s?)\:\/\/){0,1}[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;%\$#_]*)?$/', $value) && $value!=="") $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        
                        case 'siteorabs':
                            if (!preg_match('/^(http(s?)\:\/\/){0,1}(\/){0,1}[0-9a-zA-Z]{0,1}([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\=\:\?\,\'\/\\\+&amp;%\$#_]*)?$/', $value) && $value!=="") $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        
                            
                        case 'nopunctuation':
                            if (!preg_match('/^[^().\/\*\^\?#!@$%+=,\"\'><~\[\]{}]+$/', $value)) $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        case 'norussian':
                            if (!preg_match('/^[^a-zA-Z]+$/', $value) && !empty($value)) $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        case 'nonzero':
                            if (!preg_match('/^-?[1-9][0-9]*/', $value)) $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        case 'regexp':
                            if (!preg_match($rule['options']['regexp'], $value)) $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        case 'callback':
                            if (call_user_func($rule['options']['func'], $rule['options']['params'])){
                                $rule['error'] = $error = $element_errors_exists = true;
                            }
                            break;
                        case 'compare':
                            $compareFn = create_function('$a, $b', 'return $a ' . $rule['options']['rule'] . ' $b;');
                            if (!$compareFn($value, $rule['options']['value'])) $rule['error'] = $error = $element_errors_exists = true;
                            break;
                        case 'uploadedfile':
                            if (!empty($_FILES[$element]["tmp_name"]) && !is_uploaded_file($_FILES[$element]["tmp_name"])) $rule['error'] = $error = $element_errors_exists = true;
                            break;

                        case 'uploadedimage':
                            if (!empty($_FILES[$element]["tmp_name"]) && is_uploaded_file($_FILES[$element]["tmp_name"]))
                            {
                                if ($data = getimagesize($_FILES[$element]["tmp_name"]))
                                {
                                    if (isset($data[2])) {
                                        if ( ($data[2]===1) || ($data[2]===2) || ($data[2]===3)) //GIF JPG PNG
                                        {
                                            break;
                                        }
                                    }
                                }
                                
                                $rule['error'] = $error = $element_errors_exists = true;
                            }
                            break;
                        
                        case 'uploadedswf':
                            if (!empty($_FILES[$element]["tmp_name"]) && is_uploaded_file($_FILES[$element]["tmp_name"]))
                            {
                                if ($data = getimagesize($_FILES[$element]["tmp_name"]))
                                {
                                    if (isset($data[2])) {
                                        if ( ($data[2]===4) || ($data[2]===13)) //swf swc
                                        {
                                            break;
                                        }
                                    }
                                }
                                
                                $rule['error'] = $error = $element_errors_exists = true;
                            } else $rule['error'] = $error = $element_errors_exists = true;
                            break;
                                  
                        case 'maxfilesize':
                            if (!empty($elementValue['error']) &&
                            (UPLOAD_ERR_FORM_SIZE == $elementValue['error'] || UPLOAD_ERR_INI_SIZE == $elementValue['error'])) {
                                return false;
                            }
                            return ($maxSize >= @filesize($elementValue['tmp_name']));
                            break;
                        case 'mimetype':
                            if (is_array($mimeType)) {
                                return in_array($elementValue['type'], $mimeType);
                            }
                            return $elementValue['type'] == $mimeType;
                            break;
                        case 'filename':
                            if (!preg_match($rule['options']['regex'], $value)) $rule['error'] = $error = $element_errors_exists = true;
                            break;
                    }
                }
            }
        }
        // no rules exeption, process
        return !$error;
    }

    /**
     * Sets the value of max file size
     * @param     int    $bytes    Size in bytes
     * @return    void
     */
    public function setMaxFileSize($bytes = 0)
    {
        if ($bytes > 0) $this->_maxFileSize = $bytes;
    }

    /**
     * Returns the value of MAX_FILE_SIZE hidden element
     * @return    int   max file size in bytes
     */
    public function getMaxFileSize()
    {
        return $this->_maxFileSize;
    }

    /**
     * Adds a validation rule for the given field
     * If the element is in fact a group, it will be considered as a whole.
     * @param    string     $element   Form element name
     * @param    string     $type      Rule type
     * @param    string     $message   Message to display for invalid data
     * @param    string     $options   (optional)Required for extra rule data
     * @param    string     $mode      (optional)Where to perform validation: "server", "client"
     */
    public function addRule($element, $type, $message, $options=null, $mode='server')
    {
        if (!isset($this->_rules[$element])) $this->_rules[$element] = array();
        $this->_rules[$element][] = array(
        'type'    => $type,
        'message' => $message,
        'options' => $options,
        'mode'    => $mode,
        'error'   => false
        );
    }

    /**
     * Initializes default form values
     * @param     array    $values       values used to fill the form
     * @return    void
     */
    public function setDefaults($values)
    {
        foreach ($values as $k=>$v) $this->_defaults[$k] = $v;
    }

    /**
     * set options array for select element
     *
     */
    public function setOptions()
    {

    }

    /**
     * Returns the client side validation script
     * @return    string    Javascript to perform validation, empty string if no 'client' rules were added
     */
    public function getValidationScript()
    {
        foreach ($this->_rules as $element => $rules) {
            foreach ($rules as $rule) {
                if ('client' == $rule['mode']) {
                }
            }
        }
        if (count($test) > 0) {
            return
            "<script type='text/javascript'>function validate_" . $this->name . "() {" .
            "  var value = ''; var errFlag = new Array(); var _qfGroups = {}; _qfMsg = '';" .
            "return true;}</script>";
        }
        return '';
    }

    /**
     * Moves an uploaded file into the destination
     * @param    string  form element name
     * @param    string  Destination directory path
     * @param    string  New file name
     * @return   bool    Whether the file was moved successfully
     */
    public function moveUploadedFile($name, $dest, $fileName = '')
    {
        if ($dest != '' && substr($dest, -1) != '/') $dest .= '/';
        $fileName = ($fileName != '') ? $fileName : $name;
        return move_uploaded_file($name, $dest . $fileName);
    }
}

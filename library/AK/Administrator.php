<?php

class AK_Administrator extends AK_Data_Entity
{
    public $id;
    public $login;
    public $password;
    public $email;

    public function __construct($key = null, $val = null)
    {
        parent::__construct(DBT_PREFIX.'_administrators__accounts', array(
        'id'               => 'id',
        'login'            => 'login',
        'email'            => 'email',
        'password'         => 'password',
        ));

        if ($key !== null){
            $this->pkColName = $key;
            $this->loadByPk($val);
        }
        else
        {
            $this->pkColName = 'id';
        }

    }

    /**
     * @return unknown
     */
    public function getId ()
    {
        return $this->id;
    }
    /**
     * @return unknown
     */
    public function getLogin ()
    {
        return $this->login;
    }
    /* public function getAdminPath( $action = null, $withslash = true )
    {
    if ( $this->UserPath === null ) {
    $this->setUserPath();
    }
    if ( $action !== null ) {
    if ( $this->isUsedNamedPath == false ) {
    return ($withslash) ? $this->UserPath.$action.'/userid/'.$this->id.'/' : $this->UserPath.$action.'/userid/'.$this->id;
    } else {
    return ($withslash) ? $this->UserPath.$action.'/' : $this->UserPath.$action;
    }
    } else {
    return $this->UserPath;
    }
    }*/

    /**
	 * Проверка аутентификации пользователя
	 */
    public function isAuthenticated()
    {
        return (!empty($_SESSION['admin_id'])) ? true : false;
    }

    /**
	 * Аутентификация пользователя
	 */
    public function authenticate()
    {
        $_SESSION['admin_id'] = $this->id;
    }

    /**
	 * Завершение сессии пользователя
	 */
    public function logout()
    {
        unset($_SESSION['admin_id']);
        setcookie("saveadminlogin","",time()-60*60*24*365*10, '/');
        setcookie("saveadminpassword","",time()-60*60*24*365*10, '/');
    }


    /**
	 * Валидация логина пользователя
	 * @param string $login
	 * @param string $password
	 * @return boolean
	 */
    public static function validateLogin($login, $password)
    {
        $db = Zend_Registry :: get('DB');
        $select = $db->select();
        $select->from(DBT_PREFIX.'_administrators__accounts', 'id')
        ->where('login = ?', $login)
        ->where('password = ?', md5($password));
        $res = $db->fetchOne($select);
        return (boolean) $res;
    }

    public static function isAdministratorExists($key, $value, $exclude = null)
    {
        if (empty($value)) return false; //after ZF update 06032008
        
        $db = Zend_Registry :: get('DB');
        if ( !in_array($key, array('id','login','email')) ) {
            return false;
        }
        $select = $db->select();
        $select->from(DBT_PREFIX.'_administrators__accounts','count(id) as count')
        ->where($key.' = ?', $value);
        //->where('status != ?', 'deleted');
        if ( $exclude !== null ) {
            $select->where($key.' NOT IN (?)', $exclude);
        }
        $res = $db->fetchOne($select);
        return (boolean) $res;
    }
}

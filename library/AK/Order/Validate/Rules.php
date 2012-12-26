<?php

class AK_Order_Validate_Rules {

    public static function isCaptchaCodeNotValid($captcha) {

        if (!($captcha instanceof AK_Captcha_Abstract)) return true;

        return (!$captcha->validateSubmit() ? true: false);

    }

    public static function loginExist($login) {
        $_db = Zend_Registry :: get('DBORDER');
        $where = $_db->quoteInto('login=?', $login);
        $query = $_db->select()->from('orders_users__accounts', 'id')->where($where);
        return $_db->fetchOne($query) ? true : false;
    }

    public static function emailExist($email) {
        $_db = Zend_Registry :: get('DBORDER');
        $where = $_db->quoteInto('email=?', $email);
        $query = $_db->select()->from('orders_users__accounts', 'id')->where($where);
        return $_db->fetchOne($query) ? true : false;
    }

    public static function userEmailExist($params) {
        $_db = Zend_Registry :: get('DBORDER');
        extract($params);
        $where1 = $_db->quoteInto('login=?', $login);
        $where2 = $_db->quoteInto('email=?', $email);
        $query = $_db->select()->from('orders_users__accounts', 'id')->where($where1)->where($where2);
        return $_db->fetchOne($query) ? false : true;
    }
    


    function adminEmailExist($params) {
        $email = $params['email'];
        $user_id = $params['user_id'];

        $_db = Zend_Registry :: get('DB');

        $where = $_db->quoteInto("email = ? AND id <> '$user_id'", $email);
        $sql = $_db->select()->from('ak_administrators__accounts', 'id')->where($where);
        return $_db->fetchOne($sql) ? true : false;
    }

    function adminLoginExist($params) {
        $login = $params['login'];
        $user_id = $params['user_id'];

        $_db = Zend_Registry :: get('DB');

        $where = $_db->quoteInto("login = ? AND id <> '$user_id'", $login);
        $query = $_db->select()->from('ak_administrators__accounts', 'id')->where($where);
        return $_db->fetchOne($query) ? true : false;
    }

    function emailExist2($params) {
        $email = $params['email'];
        $user_id = $params['user_id'];

        $_db = Zend_Registry :: get('DBORDER');

        $where = $_db->quoteInto("email = ? AND id <> '$user_id'", $email);
        $sql = $_db->select()->from('orders_users__accounts', 'id')->where($where);
        return $_db->fetchOne($sql) ? true : false;
    }

    function loginExist2($params) {
        $login = $params['login'];
        $user_id = $params['user_id'];

        $_db = Zend_Registry :: get('DBORDER');

        $where = $_db->quoteInto("login = ? AND id <> '$user_id'", $login);
        $query = $_db->select()->from('orders_users__accounts', 'id')->where($where);
        return $_db->fetchOne($query) ? true : false;
    }



}
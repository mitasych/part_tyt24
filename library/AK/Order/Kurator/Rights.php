<?php
class AK_Order_Kurator_Rights {

    public static $admin_id;

    public function __construct ($val = null) {
        if ($val !== null) {
           self::$admin_id = (int)$val;
        }
    }
    public static function remove ($rid) {
        $db = Zend_Registry::get('DBORDER');
        $db->query('delete from orders__kurators_permissions where kurator_id='.self::$admin_id.' AND permission_id = '.$rid);
    }

    public static function removeAll () {
        $db = Zend_Registry::get('DBORDER');
        $db->query('delete from orders__kurators_permissions where kurator_id='.self::$admin_id);
    }

    public static function get ($rid) {
        $db = Zend_Registry::get('DBORDER');
        $select = $db->select();
        $select->from('orders__kurators_permissions', 'id')->where('permission_id = ?', $rid)->where('kurator_id = ?', self::$admin_id);
        $res = $db->fetchOne($select);
        return (boolean) $res;
    }

    public static function add ($rid) {
        $db = Zend_Registry::get('DBORDER');
        $db->query('replace into orders__kurators_permissions set kurator_id='.self::$admin_id.' , permission_id = '.$rid);
    }
}

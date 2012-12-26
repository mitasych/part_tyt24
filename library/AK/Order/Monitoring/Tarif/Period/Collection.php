<?php

class AK_Order_Monitoring_Tarif_Period_Collection {
    public static function getPeriodByPeriod($val) {

        if (!empty($val)) {
            $db = Zend_Registry::get('DBORDER');
            $select = $db->select();
            $select->from('orders_monitoring__tarif_period', 'id')->where('cnt = ?', $val);
            $res = $db->fetchOne($select);
        }
        else {
            $res = null;
        }
        return new AK_Order_Monitoring_Tarif_Period($res);

    }
}
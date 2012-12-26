<?php

class AK_Order_Schet {

    public static function get(){

        $settings = new AK_Order_Settings();
        $val = $settings->get('incremental_schet');

        if (empty($val)) $val = '2107000';

        $v1 = substr($val,0,4);
        $v2 = substr($val,4);

        if ($v1 != date("dm")) {
            $v1 = date("dm");
            $v2 = '000';
        }

        $v2 = intval($v2);
        $v2++;
    
        if ($v2<10) {
            $v2 = '00'.$v2;
        } elseif ($v2<100) $v2 = '0'.$v2;

        $settings->set('incremental_schet',$v1.$v2);
        return $val;
    }
}

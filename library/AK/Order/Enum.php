<?php

class AK_Order_Enum {

    //==========================================================================
    const O_NAL = 1;
    const O_BEZNAL = 2;
    const O_EMONEY = 3;
    const O_WEBMONEY = 4;
    const O_REGISTERED = 5;
    const O_EMONEY2 = 6;
    
    const O_NAL_LABEL = 'Наличными Сбербанк России (3%)';
    const O_BEZNAL_LABEL = 'Безналичными (0 %)';
    const O_EMONEY_LABEL = 'электронными деньгами';
    const O_EMONEY2_LABEL = 'электронными деньгами';
    const O_WEBMONEY_LABEL = 'webmoney';

    public static function getOList() {
        $result = array();
        $result[] = array(self::O_NAL => self::O_NAL_LABEL);
        $result[] = array(self::O_BEZNAL => self::O_BEZNAL_LABEL);

        $settings = new AK_Order_Settings();
        if ($settings->get('webmoneyenabled')) {
            if ($v = $settings->get('webmoneyslot1')) {
                $result[] = array(self::O_WEBMONEY => $v);
            }
            if ($v = $settings->get('webmoneyslot2')) {
                $result[] = array(self::O_WEBMONEY => $v);
            }

        }
        if ($settings->get('interkassaenabled')) {
            if ($v = $settings->get('interkassaslot1')) {
                $result[] = array(self::O_EMONEY => $v);
            }
            if ($v = $settings->get('interkassaslot2')) {
                $result[] = array(self::O_EMONEY => $v);
            }
            if ($v = $settings->get('interkassaslot3')) {
                $result[] = array(self::O_EMONEY => $v);
            }
            if ($v = $settings->get('interkassaslot4')) {
                $result[] = array(self::O_EMONEY => $v);
            }

        }
        if ($settings->get('robokassaenabled')) {
            if ($v = $settings->get('robokassaslot1')) {
                $result[] = array(self::O_EMONEY2 => $v);
            }
            if ($v = $settings->get('robokassaslot2')) {
                $result[] = array(self::O_EMONEY2 => $v);
            }
            if ($v = $settings->get('robokassaslot3')) {
                $result[] = array(self::O_EMONEY2 => $v);
            }

        }
//        return array (
//            self::O_NAL => self::O_NAL_LABEL,
//            self::O_BEZNAL => self::O_BEZNAL_LABEL,
////            self::O_WEBMONEY => self::O_WEBMONEY_LABEL,
//            self::O_EMONEY => self::O_EMONEY_LABEL
//        );


        return $result;
    }

    public static function isInO ($id) {
        $_list = self::getOList();
        foreach($_list as $_item) {
            if (isset($_item[(int) $id])) {
                return true;
            }
        }
        
        return false;
    }
    //==========================================================================
    const P_LOW = 4;
    const P_MEDIUM = 5;
    const P_HIGH = 6;
    const P_URGENT = 7;

    const P_LOW_LABEL = 'низкая';
    const P_MEDIUM_LABEL = 'средняя';
    const P_HIGH_LABEL = 'высокая';
    const P_URGENT_LABEL = 'критическая';

    public static function getPList() {
        return array (
            self::P_LOW => self::P_LOW_LABEL,
            self::P_MEDIUM => self::P_MEDIUM_LABEL,
            self::P_HIGH => self::P_HIGH_LABEL,
            self::P_URGENT => self::P_URGENT_LABEL
        );
    }

    public static function isInP ($id) {
        $_list = self::getPList();
        if (isset($_list[(int) $id])) {
            return true;
        }
        return false;
    }

    //==========================================================================


    //==========================================================================
    const PER_WEEK = 20;
    const PER_2WEEK = 21;
    const PER_MONTH = 22;


    const PER_WEEK_LABEL = 'неделя';
    const PER_2WEEK_LABEL = '2 недели';
    const PER_MONTH_LABEL = 'месяц';

    public static function getPeriodList() {
        return array (
            self::PER_WEEK => self::PER_WEEK_LABEL,
            self::PER_2WEEK => self::PER_2WEEK_LABEL,
            self::PER_MONTH => self::PER_MONTH_LABEL
        );
    }

    public static function isInPeriod ($id) {
        $_list = self::getPeriodList();
        if (isset($_list[(int) $id])) {
            return true;
        }
        return false;
    }

    //==========================================================================

}
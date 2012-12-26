<?php

class AK_Enum_From {
    const P1 = 1;
    const P2 = 2;
    const P3 = 3;
    const P4 = 4;
    const P5 = 5;
    const P6 = 6;
    const P7 = 7;
    const P8 = 8;
    const P9 = 9;

    const P1_LABEL = 'Поисковые системы в интернете';
    const P2_LABEL = 'Переход с другого сайта';
    const P3_LABEL = 'От друзей/коллег';
    const P6_LABEL = 'Предложение по телефону';
    const P7_LABEL = 'Предложение по факсу';
    const P9_LABEL = 'Прочее';

    public static function getList() {
        return array (
            self::P1 => self::P1_LABEL,
            self::P2 => self::P2_LABEL,
            self::P3 => self::P3_LABEL,
            self::P6 => self::P6_LABEL,
            self::P7 => self::P7_LABEL,
            self::P9 => self::P9_LABEL
        );
    }

    public static function isIn ($id) {
        $_list = self::getList();
        if (isset($_list[(int) $id])) {
            return true;
        }
        return false;
    }
}

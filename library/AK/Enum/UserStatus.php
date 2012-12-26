<?php

class AK_Enum_UserStatus
{
	const UR = 2;
    const IP = 3;
    const FIZ = 1;

    const UR_LABEL = 'Юридическое лицо';
    const IP_LABEL = 'Индивидуальный предприниматель';
    const FIZ_LABEL = 'Физическое лицо';

    public static function getList() {
        return array (
                self::FIZ => self::FIZ_LABEL,
                self::UR => self::UR_LABEL,
                self::IP => self::IP_LABEL
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
<?php

class AK_Enum_Gender
{
	const FEMALE = 2;
    const MALE = 1;

    const MALE_LABEL = 'Мужской';
    const FEMALE_LABEL = 'Женский';
    
    public static function getList() {
        return array (
                self::MALE => self::MALE_LABEL,
                self::FEMALE => self::FEMALE_LABEL
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
<?php

class AK_Enum_AdminStatus
{
	const KURATOR = 2;
    const ADMIN = 1;

    const ADMIN_LABEL = 'Администратор';
    const KURATOR_LABEL = 'Куратор';
    
    public static function getList() {
        return array (
                self::ADMIN => self::ADMIN_LABEL,
                self::KURATOR => self::KURATOR_LABEL
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
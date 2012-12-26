<?php

class AK_Order_Validate {

    public static function CheckINN($Value) {
        return (((mb_strlen($Value, 'UTF-8')==10) && AK_Order_Validate::CheckINN_10($Value)) || ((mb_strlen($Value, 'UTF-8')==12) && AK_Order_Validate::CheckINN_12($Value)));
    }

    public static function CheckINN_10($Value) {//7713189873

        $INNMask = array(2,4,10,3,5,9,4,6,8,0); // весовые коэффициенты
        $Result = False;
        $Summa = 0;
        
        for ($i=0; $i<=9; $i++) {
            if (!in_array($Value[$i], array('0','1','2','3','4','5','6','7','8','9') )) return false;
            $Summa+=((int)($Value[$i])*$INNMask[$i]); // вычисляем контрольную сумму
        }

        $C = ($Summa % 11); // вычисляем контрольное число как остаток от деления контрольной суммы на 11
        if ($C>9) $C = ($C % 10);

        $Result = ($C == $Value[9]); // проверяем соответствие контрольного числа десятому знаку ИНН
        return $Result;
    }


    public static function CheckINN_12($Value) {
        $INNMask = array(3,7,2,4,10,3,5,9,4,6,8,0); // весовые коэффициенты

        $Result = False;
        $Summa = 0;
        for ($i=0; $i<=10; $i++) {
            if (!in_array($Value[$i], array('0','1','2','3','4','5','6','7','8','9') )) return false;
            $Summa += ((int)$Value[$i]*$INNMask[$i+1]); // вычисляем контрольную сумму по 11-ти знакам
        }
        $C_11 = ($Summa % 11); // вычисляем контрольное число(1)
        if ($C_11>9) $C_11 = ($C_11 % 10);

        if ($C_11 != $Value[10]) return false; // проверяем соответствие контрольного числа(1) одиннадцатому знаку ИНН


        $Summa = 0;
        for ($i=0; $i<=11; $i++) {

            if (!in_array($Value[$i], array('0','1','2','3','4','5','6','7','8','9') )) return false;
            $Summa += ((int)$Value[$i]*$INNMask[$i]); // вычисляем контрольную сумму по 12-ти знакам
        }

        $C_12 = ($Summa % 11); // вычисляем контрольное число(2)
        if ($C_12>9) $C_12 = (C_12 % 10);

        $Result = ($C_12 == $Value[11]); // проверяем соответствие контрольного числа(2) двенадцатому знаку ИНН
        return $Result;
    }

    public static function isSecretCodeExists($code) {
        $db = Zend_Registry::get('DBORDER');
        $select = $db->select();
        $select->from('orders', 'id')->where('secret_code = ?', $code);
        $res = $db->fetchOne($select);
        return (boolean) $res;

    }

    public static function isNumberExists($code) {
        $db = Zend_Registry::get('DBORDER');
        $select = $db->select();
        $select->from('orders', 'id')->where('number = ?', $code);
        $res = $db->fetchOne($select);
        return (boolean) $res;

    }

}
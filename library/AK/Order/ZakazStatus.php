<?php

class AK_Order_ZakazStatus {

    const CREATED = 10;
    
    const PRICE_NOT_DETECTED = 20;
    const PRICE_IN_PROGRESS = 30;
    const PRICE_DETECTED = 40;
    const PRICE_NOT_APPROVED_BY_CLIENT = 50;

    const WAITING_FOR_PAYMENT = 60;
    const PAID = 70;

    const IN_PROGRESS = 80;
    const DECLINED = 90;
    const READY = 100;
    const NOT_SATISFIED = 105;
    const DONE = 110;
    const ARCHIVE = 120;
    const CANCEL = 130;
    const BALANS_PAID = 140;


   //-----------------------------------------------
    const CREATED_LABEL = 'Заказ создан';

    const PRICE_NOT_DETECTED_LABEL = 'Цена требует уточнения';
    const PRICE_IN_PROGRESS_LABEL = 'Цена заказа уточняется';
    const PRICE_DETECTED_LABEL = 'Цена определена';
    const PRICE_NOT_APPROVED_BY_CLIENT_LABEL = 'Цена не подтверждена клиентом';

    const WAITING_FOR_PAYMENT_LABEL = 'Ожидается оплата';
    const PAID_LABEL = 'Оплачено';

    const IN_PROGRESS_LABEL = 'Заказ находится в обработке';
    const DECLINED_LABEL = 'Отклонено';
    const READY_LABEL = 'Заказ выполнен';
    const NOT_SATISFIED_LABEL = 'Заказ неудовлетворяет клиента';
    const DONE_LABEL = 'Заказ передан клиенту';
    const ARCHIVE_LABEL = 'Заказ помещен в архив';
    const CANCEL_LABEL = 'Заказ отложен';
    const BALANS_PAID_LABEL = 'Баланс пополнен';


    
    public static function getList() {
        return array (
                self::CREATED => self::CREATED_LABEL,
                self::PRICE_NOT_DETECTED => self::PRICE_NOT_DETECTED_LABEL,
                self::PRICE_IN_PROGRESS => self::PRICE_IN_PROGRESS_LABEL,
                self::PRICE_DETECTED => self::PRICE_DETECTED_LABEL,
                self::PRICE_NOT_APPROVED_BY_CLIENT => self::PRICE_NOT_APPROVED_BY_CLIENT_LABEL,
                self::WAITING_FOR_PAYMENT => self::WAITING_FOR_PAYMENT_LABEL,
                self::PAID => self::PAID_LABEL,
                self::IN_PROGRESS => self::IN_PROGRESS_LABEL,
                self::DECLINED => self::DECLINED_LABEL,
                self::READY => self::READY_LABEL,
                self::NOT_SATISFIED => self::NOT_SATISFIED_LABEL,
                self::DONE => self::DONE_LABEL,
                self::ARCHIVE => self::ARCHIVE_LABEL,
                self::CANCEL => self::CANCEL_LABEL,
                self::BALANS_PAID => self::BALANS_PAID_LABEL
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
<?php

class AK_Order_OrderStatus {

    const CREATED = 10;

    const PRICE_NOT_DETECTED = 20; //цена хотя бы одного элемента не определена - значит не определена и для всего заказа
    const WAITING_FOR_PAYMENT = 60;//цена определена, ожидается оплата

    const PAID = 70; // оплачено

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


    public static function getPayedList() {
        return array (
                self::PAID,
                self::IN_PROGRESS,
                self::DECLINED,
                self::READY,
                self::NOT_SATISFIED,
                self::DONE,
                self::ARCHIVE,
                self::CANCEL
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
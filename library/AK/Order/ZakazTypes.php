<?php

class AK_Order_ZakazTypes {

    //==========================================================================
    const CONTRAGENT_CHECK = 1;//также id группы

    const CONTRAGENT_VIP_EGRUL = 2;
    const CONTRAGENT_VIP_EGRIP = 3;
    const CONTRAGENT_BUSINESS_INFO = 4;
    const CONTRAGENT_BUSINESS_INFO_VED = 5;
    const CONTRAGENT_BUSINESS_INFO_EXTERNAL = 6;
    const CONTRAGENT_BUH_BALANS = 7;
    const CONTRAGENT_BUH_BALANS_ANALIZ = 8;
    const CONTRAGENT_BANKROT = 9;
	
    const CONTRAGENT_CHECK_LABEL = 'Проверка контрагента';

    const CONTRAGENT_VIP_EGRUL_LABEL = 'выписка из ЕГРЮЛ';
    const CONTRAGENT_VIP_EGRIP_LABEL = 'выписка из ЕГРИП';
    const CONTRAGENT_BUSINESS_INFO_LABEL = 'бизнес-справка';
    const CONTRAGENT_BUSINESS_INFO_VED_LABEL = 'бизнес-справка о резиденте';
    const CONTRAGENT_BUSINESS_INFO_EXTERNAL_LABEL = 'бизнес-справка о нерезиденте';
    const CONTRAGENT_BUH_BALANS_LABEL = 'бухгалтерский баланс';
	const CONTRAGENT_BUH_BALANS_ANALIZ_LABEL = 'бухгалтерский баланс с анализом';
    const CONTRAGENT_BANKROT_LABEL = 'сведения о банкротствах';
    //==========================================================================

    const OPERATIONS = 20;//также id группы
    const OPERATIONS_BALANS = 21;

    const OPERATIONS_LABEL = 'Операции';
    const OPERATIONS_BALANS_LABEL = 'пополнение баланса';


    //==========================================================================

    const MONITORING = 40;//также id группы
    const MONITORING_TARIF = 41;
	const MONITORING_KA = 42;
    const MONITORING_KLIENT = 43;
    const MONITORING_DEMO = 44;
    const MONITORING_EVENT = 45; //для куратора
    const MONITORING_EVENT_CANSEL = 46; 
    const MONITORING_EVENT_WTF = 47; 

    const MONITORING_LABEL = 'Мониторинг';
	const MONITORING_KA_LABEL = 'Контрагенты';
    const MONITORING_KLIENT_LABEL = 'Клиенты';
    const MONITORING_DEMO_LABEL = 'Демо';
    const MONITORING_TARIF_LABEL = 'Мониторинг';
    const MONITORING_EVENT_LABEL = 'События';
    const MONITORING_EVENT_CANSEL_LABEL = 'Отправка + и ?';
    const MONITORING_EVENT_WTF_LABEL = 'Отправка только +';


     //==========================================================================

    const BASES = 50;//также id группы
    const BASE_ITEM = 51;

    const BASES_LABEL = 'Базы данных';
    const BASE_ITEM_LABEL = 'База данных';
//==========================================================================


    public function getPrice($value) {
        if (self::isInPrice($value)) {
            return AK_Order_Prices::getPrice($value);
        }
        return 0;
    }

    public static function getPriceListCC() {
        return array (
            self::CONTRAGENT_VIP_EGRUL => self::CONTRAGENT_VIP_EGRUL_LABEL,
            self::CONTRAGENT_VIP_EGRIP => self::CONTRAGENT_VIP_EGRIP_LABEL,
            self::CONTRAGENT_BUH_BALANS => self::CONTRAGENT_BUH_BALANS_LABEL,
			self::CONTRAGENT_BUH_BALANS_ANALIZ => self::CONTRAGENT_BUH_BALANS_ANALIZ_LABEL,
            self::CONTRAGENT_BUSINESS_INFO => self::CONTRAGENT_BUSINESS_INFO_LABEL,
            self::CONTRAGENT_BUSINESS_INFO_VED => self::CONTRAGENT_BUSINESS_INFO_VED_LABEL,
            self::CONTRAGENT_BUSINESS_INFO_EXTERNAL => self::CONTRAGENT_BUSINESS_INFO_EXTERNAL_LABEL,
			self::CONTRAGENT_BANKROT => self::CONTRAGENT_BANKROT_LABEL
			
        );
    }

    public static function getPriceList() {
        return array (
            self::CONTRAGENT_VIP_EGRUL => self::CONTRAGENT_VIP_EGRUL_LABEL,
            self::CONTRAGENT_VIP_EGRIP => self::CONTRAGENT_VIP_EGRIP_LABEL,
            self::CONTRAGENT_BUH_BALANS => self::CONTRAGENT_BUH_BALANS_LABEL,
            self::CONTRAGENT_BUSINESS_INFO => self::CONTRAGENT_BUSINESS_INFO_LABEL,
            self::CONTRAGENT_BUSINESS_INFO_VED => self::CONTRAGENT_BUSINESS_INFO_VED_LABEL,
            self::CONTRAGENT_BUSINESS_INFO_EXTERNAL => self::CONTRAGENT_BUSINESS_INFO_EXTERNAL_LABEL,
            self::OPERATIONS_BALANS => self::OPERATIONS_BALANS_LABEL,
            self::CONTRAGENT_BUH_BALANS_ANALIZ => self::CONTRAGENT_BUH_BALANS_ANALIZ_LABEL,
            self::CONTRAGENT_BANKROT => self::CONTRAGENT_BANKROT_LABEL,
            //self::MONITORING_TARIF => self::MONITORING_TARIF_LABEL,
            self::MONITORING_KA => self::MONITORING_KA_LABEL,
            self::MONITORING_KLIENT => self::MONITORING_KLIENT_LABEL,
            self::MONITORING_DEMO => self::MONITORING_DEMO_LABEL,
            self::MONITORING_EVENT => self::MONITORING_EVENT_LABEL,
            self::MONITORING_EVENT_WTF => self::MONITORING_EVENT_WTF_LABEL,
            self::MONITORING_EVENT_CANSEL => self::MONITORING_EVENT_CANSEL_LABEL,
            self::BASE_ITEM => self::BASE_ITEM_LABEL
        );
    }

    public static function getGroupList() {
        return array (
            self::CONTRAGENT_CHECK => self::CONTRAGENT_CHECK_LABEL,
            self::OPERATIONS => self::OPERATIONS_LABEL,
            self::MONITORING => self::MONITORING_LABEL,
            self::BASES => self::BASES_LABEL
        );
    }

    public static function isInPrice ($id) {
        $_list = self::getPriceList();
        if (isset($_list[(int) $id])) {
            return true;
        }
        return false;
    }

}
<?php

class AK_Order_Dogovor extends AK_Data_EntityTyt24Order {

    public $id;

    /**
     * user
     * @var int
     */
    public $user;

    /**
     * common
     * @var date
     */
    public $placeCreated;

    /**
     * 
     * @var date
     */
    public $dateCreated;

    /**
     * 
     * @var date
     */
    public $dateUpdated;

    /**
     * @var string
     */
    public $secretCode;

    /**
     * @var int
     */
    public $zakazTypeId;

    /**
     * @var string
     */
    public $additionalInfo;

    /**
     * статус общий
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $priority;

    /**
     * @var string
     */
    public $money;

    /**
     * @var int
     */
    public $number;

    /**
     * @var int
     */
    public $zaku;

    /**
     * @var int
     */
    public $platu;

    /**
     * @var string
     */
    public $telmob;

    /**
     * @var string
     */
    public $telgor;

    /**
     * @var string
     */
    public $addr;

    /**
     * @var string
     */
    public $metro;

    /**
     * @var string
     */
    public $ather;

    /**
     * @var string
     */
    public $ik;
    /**
     * @param string $key 
     * @param  $user
     */
    public function __construct($key = null, $user = null) {
        if (!empty($user))
            $this->user = $user;
        if (!empty($key))
            $this->zakazTypeId = $key;
        $this->number = '';
        switch ($this->zakazTypeId) {
            case AK_Order_ZakazTypes::CONTRAGENT_CHECK:
                $this->number = 'О/';
                break;
            case AK_Order_ZakazTypes::BASES:
                $this->number = 'Б/';
                break;
            case AK_Order_ZakazTypes::OPERATIONS:
                $this->number = 'ББ/';
                break;
            case AK_Order_ZakazTypes::MONITORING:
                $this->number = 'М/';
                break;
            default: throw new exception('Incorrect zakaz type');
        }
        if ($user->status == 2 or $user->status == 3)
            $this->number .= $user->innogrn . '/';

        switch ($this->zakazTypeId) {
            case AK_Order_ZakazTypes::CONTRAGENT_CHECK:
                $this->dateUpdated = $user->dateReport;
                break;
            case AK_Order_ZakazTypes::BASES:
                $this->dateUpdated = $user->dateBase;
                break;
            case AK_Order_ZakazTypes::MONITORING:
                $this->dateUpdated = $user->dateMonitoring;
                break;
            default: throw new exception('Incorrect zakaz type');
        }
        $i = 0;
        if (!($this->dateUpdated > $user->dateReport))
            $i++;
        if (!($this->dateUpdated > $user->dateBase))
            $i++;
        if (!($this->dateUpdated > $user->dateMonitoring))
            $i++;
        $this->number .= $i . ' ';
    }
    /**
     * Выбрать сервис
     * @return string
     */
    public function getServis() {
        if (!empty($this->zakazTypeId)) {
            switch ($this->zakazTypeId) {
                case AK_Order_ZakazTypes::CONTRAGENT_CHECK:
                    return 'Отчетность';
                    break;
                case AK_Order_ZakazTypes::BASES:
                    return 'БД предприятий';
                    break;
                case AK_Order_ZakazTypes::OPERATIONS:
                    return 'Баланс';
                    break;
                case AK_Order_ZakazTypes::MONITORING:
                    return 'Мониторинг';
                    break;
                default: throw new exception('Incorrect zakaz type');
            }
        }

        return '';
    }
    /**
     *
     * @return string
     */
    public function getURL($to = null) {
        if (!empty($this->zakazTypeId)) {
            switch ($this->zakazTypeId) {
                case AK_Order_ZakazTypes::CONTRAGENT_CHECK:
                    return '/reports/dogovor';
                    break;
                case AK_Order_ZakazTypes::BASES:
                    return '/bases/dogovor';
                    break;
                case AK_Order_ZakazTypes::OPERATIONS:
                    return 'Баланс';
                    break;
                case AK_Order_ZakazTypes::MONITORING:
                    return '/monitoring/dogovor';
                    break;
                default: throw new exception('Incorrect zakaz type');
            }
        }

        return '';
    }

}

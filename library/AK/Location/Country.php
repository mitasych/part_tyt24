<?php

class AK_Location_Country extends AK_Data_EntityOrder
{
    public $id;
    public $name;
    public $code = '';
    public $monitoringList = 0;
    public $registerList = 0;
    /**
     * Constructor.
     *
     */
    public function getMonitoringListFormatted() {
        if (!empty($this->monitoringList)) {
            return '<font color=green>Да</font>';
        }
        return '<font color=red>Нет</font>';
    }

    public function getRegisterListFormatted() {
        if (!empty($this->registerList)) {
            return '<font color=green>Да</font>';
        }
        return '<font color=red>Нет</font>';
    }
	public function __construct($value = null)
	{
        parent::__construct('orders_location__countries', array(
            'id'   => 'id',
            'name' => 'name',
            'monitoring_list' => 'monitoringList',
            'register_list' => 'registerList',
            'code' => 'code'));
        $this->load($value);
	}
}

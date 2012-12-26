<?php

class AK_Order_Pay_Item extends AK_Data_EntityOrder
{
    public $id;
    public $title;
    public $text;
    public $url_sistem;
    public $url_pay;
    public $image;
    public $type_pay;
    public $type;
    public $typeName;
    public $typeItem;
    public $group;
    public $active;
    public $groupName;
    public $groupItem;
    public $sale;
    public $time;
    public $order;
    public $user_status;	
    /**
     * Constructor.
     *
     */
	public function __construct($value = null)
	{
        parent::__construct('orders_pay_variants', array(
            'id'   => 'id',
            'title' => 'title',
            'text' => 'text',
            'url_sistem' => 'url_sistem',
            'url_pay' => 'url_pay',
            'image' => 'image',
            'type' => 'type',
            'type_pay' => 'type_pay',
            'group' => 'group',
            'sale' => 'sale',
            'order' => 'order',
            'time' => 'time',
            'user_status' => 'user_status',            
            'active' => 'active'
			));
        $this->load($value);
		$this->typeItem = new AK_Order_Pay_ItemIk($this->type);
		$this->groupItem = new AK_Order_Pay_ItemType($this->group);
		$this->groupName = $this->groupItem->title;
		if ($this->type_pay == 0 )
			$this->typeName = 'Наличные (квитанции)';
		if ($this->type_pay == 1 )
			$this->typeName = 'Безналичные (поручительство)';
		if ($this->type_pay == 2 )
			$this->typeName = 'Интеркасса ('.$this->typeItem->name.')';
		if ($this->type_pay == 3 )
			$this->typeName = 'Другое ('.$this->url_sistem.')';
		//$this->typeName = $this->typeItem->name.' / '.$this->typeItem->currency;
		
	}
	
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
}

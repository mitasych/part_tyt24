<?php

class AK_Order_Pay_ItemType extends AK_Data_EntityOrder
{
    public $id;
    public $title;
    public $active;
    /**
     * Constructor.
     *
     */
	public function __construct($value = null)
	{
        parent::__construct('order_pay_type', array(
            'id'   => 'id',
            'title' => 'title',
            'active' => 'active'
			));
        $this->load($value);
	}
	
}

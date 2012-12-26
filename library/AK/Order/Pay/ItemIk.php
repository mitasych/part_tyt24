<?php

class AK_Order_Pay_ItemIk extends AK_Data_EntityOrder
{
    public $id;
    public $name;
    public $currency;
    public $alias;
    public $exchange;
    public $active;
    /**
     * Constructor.
     *
     */
	public function __construct($value = null)
	{
        parent::__construct('interkassa_csv', array(
            'id'   => 'id',
            'name' => 'name',
            'currency' => 'currency',
            'alias' => 'alias',
            'exchange' => 'exchange',
            'active' => 'active'
			));
        $this->load($value);
	}
	
}

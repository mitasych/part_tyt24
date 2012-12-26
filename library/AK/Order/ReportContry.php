<?php

class AK_Order_ReportContry extends AK_Data_EntityOrder
{
    public $id;
    public $title;
    public $id_count;
    /**
     * Constructor.
     *
     */
	public function __construct($value = null)
	{
        parent::__construct('orders_country', array(
            'id'   => 'id',
            'title' => 'title',
            'id_count' => 'id_count'
			));
        $this->load($value);
	}
}

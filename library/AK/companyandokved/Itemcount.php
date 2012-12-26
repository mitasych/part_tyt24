<?php
class AK_companyandokved_Itemcount extends AK_Data_Entity_Extended
{
    protected $count;
    public function getCount ()
    {
        return $this->count;
    }

    /**
     *
     */
    public function __construct ($value = null)
    {
        parent::__construct('class_companyandokved', array(
            'count(*)' => 'count'
            ));
        $this->loadBySql("SELECT count(*) FROM `class_companyandokved` WHERE `okved_id` = ".$value);
    }

    /**
     * SET & GET Creator
     */
    //-------------------------------------------------------------------------------------------------------------------
}

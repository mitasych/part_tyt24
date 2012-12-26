<?php
class AK_okved_okvedtest extends AK_Data_Entity_Extended
{
    protected $id;
    protected $local_id;
    protected $okved_code;
    protected $search_info;
    protected $okved_code_short;
    protected $zero;
    protected $copy_zero;
    protected $first;
    protected $copy_first;
    protected $second;
    protected $copy_second;
    protected $rybricator;
    
    /* @return unknown
     */
    public function getId ()
    {
        return $this->id;
    }
    public function getOkved_code_short ()
    {
        return $this->okved_code_short;
    }
    public function getName ()
    {
        return $this->search_info;
    }
    public function getZero ()
    {
        return $this->Zero;
    }
    public function getFirst ()
    {
        return $this->first;
    }

    public function getSecond ()
    {
        return $this->second;
    }

    /**
     *
     */
    public function __construct ($value = null)
    {
        parent::__construct('okved_test', array(
            'id' => 'id' ,
            'local_id' => 'local_id' ,
            'okved_code' => 'okved_code' ,
            'search_info' => 'search_info' ,
            'okved_code_short' => 'okved_code_short' ,
            'zero' => 'zero' ,
            'copy_zero' => 'copy_zero' ,
            'first' => 'first' ,
            'copy_first' => 'copy_first' ,
            'second' => 'second' ,
            'copy_second' => 'copy_second' ,
            'rybricator' => 'rybricator'));
        $this->loadBySql("SELECT * FROM `okved_test` WHERE `id` = ".$value);
    }


    /**
     * SET & GET Creator
     */
    //-------------------------------------------------------------------------------------------------------------------
}


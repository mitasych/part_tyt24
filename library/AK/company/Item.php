<?php
class AK_company_Item extends AK_Data_Entity_Extended
{
    protected $id;
    protected $name;
	protected $single_kind;
        protected $single_name;
    protected $count_worker;
    protected $adress;
    protected $rykov;
    protected $dolgn;
    protected $phone;
    protected $fax;
    protected $web;
    protected $email;
    protected $okato_id;
    protected $okved_id;
    protected $okpo;
    protected $ogrn;
    protected $inn;
    protected $reg_date;
    protected $zerolevel_id;
    protected $firstlevel_id;
    protected $secondlevel_id;
    /**
     * @return unknown
     */
    public function getId ()
    {
        return $this->id;
    }

    public function getSingle_name ()
    {
        return $this->single_name;
    }

    public function getZerolevel_id ()
    {
        return $this->zerolevel_id;
    }

    public function getFirstlevel_id ()
    {
        return $this->firstlevel_id;
    }

    public function getsecondlevel_id ()
    {
        return $this->secondlevel_id;
    }

    public function getAdress ()
    {
        return $this->adress;
    }

    public function getPhone ()
    {
        return $this->phone;
    }

    public function getName ()
    {
        return $this->single_kind;
    }
    public function getOkato ()
    {
        return $this->okato_id;
    }

    public function getOkatoName ()
    {
        return $this->okato_name;
    }

    public function getOkved ()
    {
        return $this->okved_id;
    }
    
    public function getEmail ()
    {
        return $this->email;
    }

    public function getWeb ()
    {
        return $this->web;
    }

    public function getFax ()
    {
        return $this->fax;
    }

    public function getInn()
    {
        return $this->inn;
    }
    /**
     *
     */
    public function __construct ($value = null)
    {
        parent::__construct('class_company5_2', array(
            'id' => 'id' ,
            'single_name' => 'single_name',
            'single_kind' => 'single_kind' ,
            'count_worker' => 'count_worker' ,
            'adress' => 'adress' ,
            'rykov' => 'rykov' ,
            'dolgn' => 'dolgn' ,
            'phone' => 'phone' ,
            'fax' => 'fax' ,
            'web' => 'web' ,
            'email' => 'email' ,
            'okato_id' => 'okato_id' ,
            'okved_id' => 'okved_id' ,
            'okpo' => 'okpo' ,
            'ogrn' => 'ogrn' ,
            'inn' => 'inn' ,
            'reg_date' => 'reg_date',
            'zerolevel_id' => 'zerolevel_id' ,
            'secondlevel_id' => 'secondlevel_id' ,
            'firstlevel_id' => 'firstlevel_id' ));

        $this->loadBySql("SELECT * FROM `class_company5_2` WHERE `id` = ".$value);
    }

    /**
     * SET & GET Creator
     */
    //-------------------------------------------------------------------------------------------------------------------
}

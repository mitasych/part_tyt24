<?php
class AK_Search_Item extends AK_Data_Entity
{

    private $EntBaseInfoCode;
    private $Name;
    private $INN;
    private $Region;
    private $FederalOkr;
    private $PrintFlag;


    public function getId ()
    {
        return $this->EntBaseInfoCode;
    }


    public function getName ()
    {
        return $this->Name;
    }

    public function getINN ()
    {
        return $this->INN;
    }

   

    /**
     *
     */
    public function __construct ($value = null)
    {
        parent::__construct('entbaseinfo', array(
            'EntBaseInfoCode' => 'EntBaseInfoCode' ,
            'Name' => 'Name',
            'INN' => 'INN',
            'Region' => 'Region',
            'FederalOkr' => 'FederalOkr',
            'PrintFlag' => 'PrintFlag' 

          
            ));
        $this->load($value);
    }

    /*/FOR LISTER
    public function getFiltervalue ()
    {
        return $this->id;
    }*/


}

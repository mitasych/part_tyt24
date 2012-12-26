<?php

class AK_Order_User_Kontragent extends AK_Data_EntityOrder {

    public $id;
    public $userId;
    public $kontragentId;
    public $region;
    public $country;
    public $title;
    public $favorites;
	public $tarif_id;

    private $Kontragent = null;

    public function getKontragent() {
        if (null === $this->Kontragent) {
            $this->Kontragent = new AK_Order_Kontragent('id', $this->kontragentId);
        }
        return $this->Kontragent;
    }
    
    public function __construct ($val = null,$id=null) {
        parent::__construct('orders_users__kontragents', array(
            'id' => 'id' ,
            'user_id' => 'userId' ,
            'region' => 'region' ,
            'title' => 'title' ,
            'favorites' => 'favorites' ,
            'country' => 'country' ,
            'kontragent_id' => 'kontragentId',
			'tarif_id' => 'tarif_id'			
            ));
          if ($id !== null) {
           
                $this->pkColName = 'kontragent_id';
                $this->loadByPk($id);
                $this->pkColName = 'id';
    
        }
        $this->load($val);
         
    }

}

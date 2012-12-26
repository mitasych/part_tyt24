<?php

class AK_Order_Monitoring_Event extends AK_Data_EntityOrder {

    public $id;
    public $dateCreated;
    public $typeId;
    public $kontragentId;
    public $eventDate;
    public $content;

    private $Type;
    private $Kontragent;

    public function getEventDateFormatted(){
        //return date('d-m-Y H:i:s', $this->eventDate);
        return date('d-m-Y', $this->eventDate);
    }

    public function getDateCreatedFormatted(){
        //return date('d-m-Y H:i:s', $this->dateCreated);
        return date('d-m-Y', $this->dateCreated);
    }

    public function getType(){
        if (null === $this->Type) {
            $this->Type = new AK_Order_Monitoring_Event_Type($this->typeId);
        }

        return $this->Type;
    }

    public function getKontragent(){
        if (null === $this->Kontragent) {
            $this->Kontragent = new AK_Order_Kontragent('id', $this->kontragentId);
        }

        return $this->Kontragent;
    }

    public function getEventTypeTitle(){
        return $this->getType()->title;
    }

    public function getKontragentInn(){
        return $this->getKontragent()->inn;
    }

    public function view() {
        if (empty($this->id)) {
            return false;
        }
        $user = Zend_registry::get('User');
        $db = Zend_Registry::get('DBORDER');
        $sql = "DELETE FROM orders_monitoring__events_views WHERE event_id = ".(int) $this->id." AND user_id = ".(int)($user->id);
        $db->query($sql);
        $sql = "INSERT INTO orders_monitoring__events_views SET event_id = ".(int) $this->id." , user_id = ".(int)($user->id);
        $db->query($sql);
    }

    public function isViewed() {
        if (empty($this->id)) {
            return false;
        }
        $user = Zend_registry::get('User');
        $db = Zend_Registry::get('DBORDER');
        $query = $db->select();
        $query->from('orders_monitoring__events_views AS A', new Zend_Db_Expr('COUNT(*) AS cnt'));
        $query->where('A.user_id = ?', $user->id);
        $query->where('A.event_id = ?', $this->id);
        return (boolean) $db->fetchOne($query);
    }
    
    public function __construct ($val = null) {
        parent::__construct('orders_monitoring__events', array(
            'id' => 'id' ,
            'date_created' => 'dateCreated' ,
            'type_id' => 'typeId',
            'kontragent_id' => 'kontragentId',
            'event_date' => 'eventDate',
            'content' => 'content'
            
            ));

        
            $this->load($val);
    }
}

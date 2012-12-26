<?php

class AK_Data_Comment extends AK_Data_Entity
{
    public $id;
    public $entityTypeId;
    public $entityId;
    public $creationDate;
    public $content;
    public $isApproved;
    public $author;
    
    
    public function __construct($value = null)
    {
        parent::__construct(DBT_PREFIX.'_entity__comments', array(
        'id'              => 'id',
        'entity_type_id'  => 'entityTypeId',
        'entity_id'       => 'entityId',
        'creation_date'   => 'creationDate',
        'content'         => 'content',
        'is_approved'     => 'isApproved',
        'author'         => 'author'
        ));
  
        $this->load($value); 
    }

	
	
  public function getCreator()
	{
		if ( $this->_creator === null ) {
            $this->_creator = new AK_User('id', $this->userId);
		}
		return $this->_creator;
	}
}

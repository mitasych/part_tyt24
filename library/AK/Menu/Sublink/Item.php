<?php
class AK_Menu_Sublink_Item extends AK_Data_Entity {
    private $id;
    private $linkId;
    private $title;
    private $link;
    private $queue;
    public $brif;
    public $image = '';
    public $position;
    public $isShow;
    private $isRed;
    public $isNote;
    private $ParentLink = null;

    public function getIsNote ()
    {
        return $this->isNote;
    }
    public function setIsNote ($value)
    {
        $this->isNote = $value;
        return $this;
    }

    public function getId () {
        return $this->id;
    }
    public function getIsRed () {
        return $this->isRed;
    }
    public function setIsRed ($value) {
        $this->isRed = $value;
        return $this;
    }
    public function getLinkId () {
        return $this->linkId;
    }

    public function getPositionId () {
        return $this->position;
    }


    public function getTitle () {
        return $this->title;
    }

    public function getLink () {
        return $this->link;
    }
    public function getQueue () {
        return $this->queue;
    }
    public function getParentLink () {
        if (null === $this->ParentLink) {
            $this->setParentLink();
        }
        return $this->ParentLink;
    }
    public function getImageFolder() {
        return 'menu_sub';
    }
    public function setId ($value) {
        $this->id = $value;
        return $this;
    }

    public function setLinkId ($value) {
        $this->linkId = $value;
        return $this;
    }

    public function setPosition ($value) {
        $this->position = $value;
        return $this;
    }


    public function setTitle ($value) {
        $this->title = $value;
        return $this;
    }

    public function setLink ($value) {
        $this->link = $value;
        return $this;
    }
    public function setQueue ($value) {
        $this->queue = intval($value);
        return $this;
    }

    public function setParentLink () {
        $this->ParentLink = new AK_Menu_Link_Item($this->linkId);
        return $this;
    }

    public function delete () {
        if (file_exists(UPLOAD_PATH."/menu_sub/".$this->image)) @unlink (UPLOAD_PATH."/menu_sub/".$this->image)   ;
        parent::delete();
    }


    /**
     *
     */
    public function __construct ($value = null) {
        parent::__construct(DBT_PREFIX . '_menus__items_sublinks', array(
            'id' => 'id' ,
            'link_id' => 'linkId',
            'title' => 'title',
            'link' => 'link',
            'queue' => 'queue',
            'brif' => 'brif',
            'image' => 'image',
            'position' => 'position',
            'is_red' => 'isRed',
            'is_show' => 'isShow',
             'note' => 'isNote'
        ));
        $this->load($value);
    }
    //-------------------------------------------------------------------------------------------------------------------
    /**
     * FOR LISTER
     */
    public function getParentLinkTitle () {
        return $this->getParentLink()->getTitle();
    }

    public function getImagePosition () {
        if($this->image) {
            return '<img src="'.SITE_URL.'/upload/menu_sub/'.$this->image.'" alt="" title="" /><br>Показывать: '.(empty($this->isShow)?'Нет':'Да');
        }
        return '';
    }
    public function getIsRedColored() {
        $result = empty($this->isRed) ? '<font color=red>Не выделен</font>' : '<font color=green>Выделен</font>';
        return $result;
    }
        public function getIsNoteColored()
    {
        $result = empty($this->isNote) ? '<font color=red>Нет</font>' : '<font color=green>Под скрепкой</font>';
        return $result;
    }


     public function getPosition() {
        
        $result = empty($this->position) ? '<font color=red>Не указывает на меню</font>' : "<font color=green>меню № $this->position";
        return $this->position;
    }
    
    public function getLinkByUrl($url) {
    	$query = $this->_db->select();
    	$query->from(DBT_PREFIX.'_menus__items_sublinks AS A', array('A.link_id', 'A.link'));
    	$query->joinLeft(array('TL' => DBT_PREFIX.'_menus__items_links'), 
    					'TL.id = A.link_id', 
    					array(
    							'TL_image'=>'image', 
    							'TL_title' => 'title',
    							'TL_link' => 'link',
    						)
    					);
    	$query->where('A.link = ?', $url);
    	
    	return $this->_db->fetchRow($query);
    }

}

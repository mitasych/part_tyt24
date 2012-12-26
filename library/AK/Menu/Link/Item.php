<?php
class AK_Menu_Link_Item extends AK_Data_Entity
{
    private $id;
    private $menu_id;
    private $title;
    private $link;
    private $queue;
    private $isRed;
    private $isActive;

    public $brif;
    public $image = '';
    public $position;
    public $isShow;
    public $isNote;
    public $view_pages;

    private $Menu = null;

    public function getBrif ()
    {
        return $this->brif;
    }
      
    public function getIsActive ()
    {
        return $this->isActive;
    }

    public function getIsNote ()
    {
        return $this->isNote;
    }
    public function getIsRed ()
    {
        return $this->isRed;
    }
    public function getId ()
    {
        return $this->id;
    }
    
    public function getmenu_id ()
    {
        return $this->menu_id;
    }
    
    public function getTitle ()
    {
        return $this->title;
    }
    
    public function getLink ()
    {
        return $this->link;
    }
    public function getQueue ()
    {
        return $this->queue;
    }
    public function getMenu ()
    {
        if (null === $this->Menu){
            $this->setMenu();
        }
        return $this->Menu;
    }
    
    public function setId ($value)
    {
        $this->id = $value;
        return $this;
    }
    
    public function setmenu_id ($value)
    {
        $this->menu_id = $value;
        return $this;
    }
    
    public function setTitle ($value)
    {
        $this->title = $value;
        return $this;
    }
    
    public function setLink ($value)
    {
        $this->link = $value;
        return $this;
    }
    public function setQueue ($value)
    {
        $this->queue = intval($value);
        return $this;
    }
    
    public function setMenu ()
    {
        $this->Menu = new AK_Menu_Item($this->menu_id);
        return $this;
    }
    public function setIsActive ($value)
    {
        $this->isActive = $value;
        return $this;
    }
    public function setIsNote ($value)
    {
        $this->isNote = $value;
        return $this;
    }

    public function setIsRed ($value)
    {
        $this->isRed = $value;
        return $this;
    }
    
    public function getImageFolder() {
        return 'menu';
    }
    /**
     * 
     */
    public function __construct ($value = null)
    {
        parent::__construct(DBT_PREFIX . '_menus__items_links', array(
            'id' => 'id' , 
            'menu_id' => 'menu_id',
            'title' => 'title',
            'link' => 'link',
            'queue' => 'queue',
            'is_active' => 'isActive',
            'is_red' => 'isRed',
            'brif' => 'brif',
            'image' => 'image',
            'position' => 'position',
            'is_show' => 'isShow',
            'note' => 'isNote',
            'view_pages' => 'view_pages',
            ));
        $this->load($value);

            $this->isShow = 0;
    }
    
    public function delete()
    {
        $_sublinks = new AK_Menu_Sublink_List; 
        $_sublinks = $_sublinks->addWhere('A.link_id = ?', $this->id)->getList();            
        
       foreach ($_sublinks as &$_sublink) {
            $_sublink->delete();
        
        } 
    
        parent :: delete();
    }
   //-------------------------------------------------------------------------------------------------------------------
	  /**
     * FOR LISTER
     */
    public function getMenuDescription ()
    {   
        return $this->getMenu()->getDescription();
    }
    public function getSubmenus ()
    {   
        $_result = '<a href="'.MODULE_URL.'/menu/sublinks.list/filterfield/linkId/filtervalue/'.$this->id.'/menu_id/'.$this->getmenu_id().'"><font color="#525984">Редактировать</font></a><br />';
        $_sublinks = new AK_Menu_Sublink_List();
        $_sublinks = $_sublinks->addWhere("A.link_id = ".$this->id)->getList();
        foreach($_sublinks as &$_sublink) {
            $_result.=$_sublink->getTitle().'<br />';
        }
        return $_result;
    }

     public function getIsActiveColored()
    {
        $result = empty($this->isActive) ? '<font color=red>Не активен</font>' : '<font color=green>Активен</font>';
        return $result;
    }
    
     public function getArViewPages()
    {
    	$result = $this->view_pages;
    	if (!empty($result)) {
    		$arPages = unserialize($this->view_pages);
    		$result = $arPages;
    	}
    	return $result;
    	
    }
    
     public function getStrViewPages()
    {
    	$result = $this->view_pages;
    	if (!empty($result)) {
    		$arPages = unserialize($this->view_pages);
    		$strPages = '';
    		foreach($arPages as $block => $blockPage){
    			foreach ($blockPage as $itemPage){
    				if ($block == 'not_view') {
    					$itemPage = '-'. $itemPage;
    				}
	    			$strPages .= $itemPage . "\n";
    			}
    		}
    		$strPages = substr($strPages, 0, -1);
    		$result = $strPages;
    	}
    	return $result;
    	
    }
    
     public function getListStrViewPages()
    {
    	$result = str_replace("\n", '<br>', $this->getStrViewPages());
        return $result;
    }

    public function getIsNoteColored()
    {
        $result = empty($this->isNote) ? '<font color=red>Нет</font>' : '<font color=green>Под скрепкой</font>';
        return $result;
    }


     public function getIsRedColored() {
        $result = empty($this->isRed) ? '<font color=red>Не выделен</font>' : '<font color=green>Выделен</font>';
        return $result;
    }
    
    public function getImagePosition ()
    {
        if($this->image){
        return '<img src="'.SITE_URL.'/upload/menu/'.$this->image.'" alt="" title="" /><br>Показывать: '.(empty($this->isShow)?'Нет':'Да');
        }
        return '';
    }
}

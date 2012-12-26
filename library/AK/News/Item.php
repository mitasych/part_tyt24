<?php
class AK_News_Item extends AK_Data_Entity_Extended
{
    protected $id;
    private $title;
    private $content;
    private $createDate;
    private $creatorId;
    private $isActive;
    private $hideDate;
    private $categoryId;
   
    private $Creator = null;
    private $Category = null;
    /**
     * @return unknown
     */
    public function getContent ()
    {
        return $this->content;
    }
    /**
     * @return unknown
     */
    public function getCreateDate ()
    {
        return $this->createDate;
    }
    public function getHideDate ()
    {
        return $this->hideDate;
    }
    /**
     * @return unknown
     */
    public function getCreatorId ()
    {
        return $this->creatorId;
    }
    /**
     * @return unknown
     */
    public function getCategoryId ()
    {
        return $this->categoryId;
    }
    /**
     * @return unknown
     */
    public function getId ()
    {
        return $this->id;
    }
    /**
     * @return unknown
     */
    public function getIsActive ()
    {
        return $this->isActive;
    }
    
    /**
     * @return unknown
     */
    public function getTitle ()
    {
        return $this->title;
    }
    /**
     * @param unknown_type $content
     */
    public function setContent ($value)
    {
        $this->content = $value;
        return $this;
    }
    /**
     * @param unknown_type $createDate
     */
    public function setCreateDate ($value)
    {
        $this->createDate = $value;
        return $this;
    }
    public function setHideDate ($value)
    {
        $this->hideDate = $value;
        return $this;
    }
    /**
     * @param unknown_type $creatorId
     */
    public function setCreatorId ($value)
    {
        $this->creatorId = $value;
        return $this;
    }
    /**/
    public function setCategoryId ($value)
    {
        $this->categoryId = $value;
        return $this;
    }
    /**
     * @param unknown_type $id
     */
    public function setId ($value)
    {
        $this->id = $value;
        return $this;
    }
    /**
     * @param unknown_type $isActive
     */
    public function setIsActive ($value)
    {
        $this->isActive = $value;
        return $this;
    }
    
    /**
     * @param unknown_type $title
     */
    public function setTitle ($value)
    {
        $this->title = $value;
        return $this;
    }
    /**
     * 
     */
    public function __construct ($value = null)
    {
        parent::__construct(DBT_PREFIX . '_news__items', array(
            'id' => 'id' , 
            'title' => 'title' , 
            'content' => 'content' , 
            'create_date' => 'createDate' , 
            'creator_id' => 'creatorId' , 
            'is_active' => 'isActive' ,
            'hide_date' => 'hideDate' ,
            'category_id' => 'categoryId'));
        $this->load($value);
    }
   
    /**
     * SET & GET Creator
     */
    public function setCreator ()
    {
        $this->Creator = new AK_Administrator('id', $this->creatorId);
        return $this;
    }
    public function getCreator ()
    {
        if ($this->Creator === null) {
            $this->setCreator();
        }
        return $this->Creator;
    }
    /**
     * SET & GET Category
     */
    public function setCategory ()
    {   if($this->categoryId>89)
        $this->Category = new AK_Menu_Sublink_Item($this->categoryId);
        else
        $this->Category = new AK_Menu_Link_Item ($this->categoryId);
       /* $this->Category = new AK_News_Category_Item($this->categoryId);*/
        return $this;
    }
    public function getCategory ()
    {
        if ($this->Category === null) {
            $this->setCategory();
        }
        return $this->Category;
    }
    //-------------------------------------------------------------------------------------------------------------------
	  /**
     * FOR LISTER
     */
    public function getSEO ()
    {   
        $result = empty($this->metaTitle) ? '<font color=red>-</font>' : '<font color=green>+</font>';
        $result .= empty($this->metaKeywords) ? '<font color=red>-</font>' : '<font color=green>+</font>';
        $result .= empty($this->metaDescription) ? '<font color=red>-</font>' : '<font color=green>+</font>';
        return $result;
    }
    
    public function getContentTruncated()
    {
        $result = strip_tags($this->content);
        if (mb_strlen($result,'utf-8') >250){
            $result = mb_substr($result,0,250-3,'utf-8').'...';
        }
        return $result;
    }

      public function getContentTruncated85()
    {
        $result = strip_tags($this->content);
        if (mb_strlen($result,'utf-8') >85){
            $result = mb_substr($result,0,85-3,'utf-8').'...';
        }
        return $result;
    }

    public function getIsActiveColored()
    {
        $result = empty($this->isActive) ? '<font color=red>Не активен</font>' : '<font color=green>Активен</font>';
        return $result;
    }

    public function getHideDateColored()
    {
        $result = empty($this->hideDate) ? '<font color=red>Нет</font>' : '<font color=green>Да</font>';
        return $result;
    }
  
    public function getCreatorLogin()
    {
        return $this->getCreator()->getLogin();
    }
    
    public function getCategoryTitle()
    {
        return $this->getCategory()->getTitle();
    }
    
    public function getCreateDateFormatted()
    {
        return date('d-m-Y H:i:s', $this->createDate);
    }
    //-------------------------------------------------------------------------------------------------------------------
}

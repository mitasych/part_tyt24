<?php
class AK_Article_Item extends AK_Data_Entity_Extended
{
    protected $id;
    private $title;
    public $pic;
    private $content;
    private $createDate;
    private $creatorId;
    private $isActive;
    private $categoryId = 7;
   
    private $Creator = null;
    private $Category = null;
    
    public $shapkes = array(
        '0'=>'стандартная',
        'right_part_main_logistik'=>'стандартная (логистика)',
        'right_part_main_market'=>'стандартная (маркетинг)',
        'right_part_main_risk'=>'стандартная (безопасность)'/*,
        'sea'=>'морские перевозки',
        'big'=>'доставка крупногабаритных и тяжеловесных грузов',
        'sbor'=>'доставка сборных грузов',
        'multi'=>'мультимодальные перевозки',
        'naliv'=>'наливные грузы ',
        'contain'=>'доставка контейнерных грузов',
        'custom'=>'таможенное оформление',
        'avia'=>'авиаперевозки ',
        'train'=>'железнодорожные перевозки',
        'avto'=>'автомобильные перевозки',
        
        'complect'=>'комплектные грузы',
        'vacancy'=>'вакансии',
        'avtovoz'=>'доставка насыпных грузов',
        'nasip'=>'автомобильные перевозки',
        'danger'=>'опасные грузы',
        'refrigerator'=>'рефрижераторные грузы',
        'customs'=>'таможеные грузы'*/
        
        
    );
    
    /**
     * @return unknown
     */
    public function getContent ()
    {
        return $this->content;
    }
    public function getContentSwitch() {
        $content = $this->content;
        $pos = mb_strpos($content, '<h2>', 0, 'UTF-8');
        if ($pos === false) {
            return $content;
        } else {
            $firstPart = mb_substr($content, 0, $pos+4, 'UTF-8');
            $firstPart = str_replace('<h2>', '<h2 style="cursor:pointer;">', $firstPart);
            
            $secondPart = mb_substr($content, $pos+4, mb_strlen($content, 'UTF-8'), 'UTF-8');
           
            $secondPart = str_replace('</h2>', '</h2><div class="pre-swithed-h2"></div><div class="swithed-h2">', $secondPart);
            $secondPart = str_replace('<h2>', '</div><h2 style="cursor:pointer;">', $secondPart);
            $secondPart.='</div>';
        }

        return str_replace('<h2', '<h2 class="collapsed" ', $firstPart.$secondPart);
    }
    /**
     * @return unknown
     */
    public function getCreateDate ()
    {
        return $this->createDate;
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
        parent::__construct(DBT_PREFIX . '_articles__items', array(
            'id' => 'id' , 
            'title' => 'title' , 
            'content' => 'content' , 
            'create_date' => 'createDate' , 
            'creator_id' => 'creatorId' , 
            'is_active' => 'isActive' ,
            'pic' => 'pic' ,  
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
    {
        $this->Category = new AK_Article_Category_Item($this->categoryId);
        return $this;
    }
    public function getCategory ()
    {
        if ($this->Category === null) {
            $this->setCategory();
        }
        return $this->Category;
    }
    public function getSubmenu() {
        $list = new AK_Menu_Sublink_List();
        $list->addWhere('A.link = "/articles/'.$this->getRewriteName().'/" OR A.link = "/articles/'.$this->getRewriteName().'"');
        $list = $list->getList();
        if (!empty($list[0])) {
            return $list[0];
        }
        return new AK_Menu_Sublink_Item();
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
        if (mb_strlen($result,'utf-8') >150){
            $result = mb_substr($result,0,150-3,'utf-8').'...';
        }
        return $result;
    }

    public function getIsActiveColored()
    {
        $result = empty($this->isActive) ? '<font color=red>Не активен</font>' : '<font color=green>Активен</font>';
        return $result;
    }
  
    public function getCreatorLogin()
    {
        return $this->getCreator()->getLogin();
    }
    
    public function getShapka()
    {
        if(empty($this->pic)) return $this->shapkes['0'];
        return $this->shapkes[$this->pic];
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

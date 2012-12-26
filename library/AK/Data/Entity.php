<?php
class AK_Data_Entity
{
    /**
     * Db connection object.
     * @var object
     */
    public $_db;
    /**
     * The name of table which from we get data.
     * @var string
     */
    public $tableName = null;
    /**
     * fale if object was not loaded
     * @var boolean
     */
    public $isExist = false;
    /**
     * primary key name
     * @var string
     */
    public $pkColName = "id";
    /**
     * Array of table's_fields => class_properties.
     * @var array
     */
    protected $record = array();
    /**
     * кэш для хранения загруженных объектов в пределах одного обращения к серверу
     * @var unknown_type
     */
    private $cache;
    private $rank = null;
    private $rankCnt = null;
    public $EntityTypeId;
    public $weight;
    
    
    private $comments = null;
    private $rating = null;
    
    
    public $id_lost = null;
    /**
     * Constructor.
     * @param string $tableName
     */
    public function __construct ($tableName = false, $fields = null)
    {
        $this->_db = Zend_Registry::get("DB");
        if ($tableName)
            $this->tableName = $tableName;
        if ($fields)
            $this->record = $fields;
        
        
        // ENTITYTYPEID
        if ($this instanceof AK_News_Item) {
            $this->EntityTypeId = 1;
            $this->EntityTypeName = 'news';
        }
        
        if ($this instanceof AK_Article_Item) {
            $this->EntityTypeId = 2;
            $this->EntityTypeName = 'article';
        }
        
        if ($this instanceof AK_User) {
            $this->EntityTypeId = 3;
            $this->EntityTypeName = 'user';
        }
       
    }
    /**
     * Добавление свойства в класс
     * @param string $colName
     * @param string $propertyName
     */
    public function addField ($colName, $propertyName = false)
    {
        $this->record[$colName] = $propertyName ? $propertyName : $colName;
        if ($propertyName)
            $this->setProperty($propertyName, null); else
            $this->setProperty($colName, null);
    }
    /**
     * set value for property
     * @param string $propertyName
     * @param string $properyValue
     * @return void
     * @author Artem Sukharev
     */
    protected function setProperty ($propertyName, $properyValue)
    {
        if (method_exists($this, 'set' . ucfirst($propertyName))) {
            $method = 'set' . ucfirst($propertyName);
            $this->$method($properyValue);
        } else {
            if (property_exists($this, $propertyName)) {
                $this->$propertyName = $properyValue;
            }
        }
    }
    /**
     * get value for property
     * @param string $propertyName
     * @return mixed
     * @author Artem Sukharev
     */
    public function getProperty ($propertyName)
    {
        if (method_exists($this, 'get' . ucfirst($propertyName))) {
            $method = 'get' . ucfirst($propertyName);
            return $this->$method();
        } else {
            if (property_exists($this, $propertyName)) {
                return $this->$propertyName;
            } else {
                return null;
            }
        }
    }
    /**
     * return value of primary key for object
     * @return mixed
     * @author Artem Sukharev
     */
    public function getPKPropertyValue ()
    {
        $pkPropertyName = $this->record[$this->pkColName];
        return $this->getProperty($pkPropertyName);
    }
    /**
     * load data to object from db
     * @param unknown_type $value
     * @author Kostikov
     */
    public function load ($value = null)
    {
        if (empty($value))
            return false;
        if (! is_array($value)) {
            if (! is_object($value)) {
                $value = $this->_db->select()->from($this->tableName, '*')->where($this->pkColName . '= ? ', $value)->limit(1);
            }
            
            $value = $this->_db->fetchRow($value);  
        }
        if ($value) {
            foreach ($this->record as $colName => $field) {
                if (isset($value[$colName]))
                    $this->setProperty($field, $value[$colName]); else
                    $this->setProperty($field, null);
            }
            $this->isExist = true;
            return true;
        }
    }
    /**
     * load data to object by primary key
     * @param mixed $keyValue
     */
    public function loadByPk ($pkValue)
    {
        if (null === $pkValue)
            return false;
        $sql = $this->_db->select()->from($this->tableName, '*')->where($this->pkColName . '=?', $pkValue)->limit(1);
        $row = $this->_db->fetchRow($sql);    //print_r($row);
        if ($row) {
            foreach ($this->record as $colName => $field) {
                //print $colName."---".$field."<br>";
                if (isset($row[$colName])) {
                    $this->setProperty($field, $row[$colName]);//print $row[$colName];
                } else {
                    $this->setProperty($field, null);
                }
            }
            $this->isExist = true;
            return true;
        }
        return false;
    }
    
    /**
     * load data to object by field name and value
     */
    public function loadByField ($field_name, $field_value)
    {
        $query = $this->_db->select()->from($this->tableName, '*')->where($field_name . '=?', $field_value)->limit(1);
        $row = $this->_db->fetchRow($query);
        if ($row) {
            foreach ($this->record as $colName => $field) {
                if (isset($row[$colName]))
                    $this->setProperty($field, $row[$colName]); else
                    $this->setProperty($field, null);
            }
            $this->isExist = true;
            return true;
        }
        return false;
    }
    
    /**
     * load data to object by sql
     * @param string $query
     */
    public function loadBySql ($query)
    {
        $row = $this->_db->fetchRow($query);
        if ($row) {
            foreach ($this->record as $colName => $field)
                $this->setProperty($field, $row[$colName]);
            $this->isExist = true;
        }
    }
    /**
     * Сохранение объекта в базе данных
     * @todo в массив для апдейта может передать только изменённые поля, сохранив первоначальные в $this->load()
     */
    public function save ()
    {
        foreach ($this->record as $colName => $propertyName) {
            if ($propertyName != $this->pkColName) {
                $prop[$colName] = $this->getProperty($propertyName);
            }
        }
        
        $pkPropertyName = $this->record[$this->pkColName];

        if ($this->getPKPropertyValue()) {
            // update record
            $result = $this->_db->update($this->tableName, $prop, $this->_db->quoteInto($this->pkColName . ' = ?', $this->getPKPropertyValue()));

        } else {
            // add new record, return last id and set to object
            $result = $this->_db->insert($this->tableName, $prop);
			
            $this->id_lost = $this->_db->lastInsertId();
            
            $this->setProperty($pkPropertyName, $this->_db->lastInsertId());
        }

        return $result;
    }

    public function getLostId()
    {
    	return $this->id_lost;
    }


    public function save2 ($table, $data)
    {   

        $db = Zend_Registry::get("DBORDER");
            print_r($data);
             print_r($table);
             // exit();
               $result =    $db->insert($table,$data);
      
        return $result;
    }
    /**
     * delete record from DB
     *
     */
    public function delete ()
    {
        $pkPropertyName = $this->record[$this->pkColName];
        $this->_db->delete($this->tableName, $this->_db->quoteInto($this->pkColName . ' =? ', $this->getPKPropertyValue()));
        
        /**
         * delete comments for entity
         */
       // if (!empty($this->EntityTypeName)) {
       //     $this->_db->delete(DBT_PREFIX.'_entity__comments', $this->_db->quoteInto('entity_type_id =? ', $this->EntityTypeId) . " AND " . $this->_db->quoteInto('entity_id =? ', $this->getPKPropertyValue()));
       // }
        /**
         *  delete ranks for entity
         */
        //$this->_db->delete('zanby_entity__ranks', $this->_db->quoteInto('entity_type_id =? ', $this->EntityTypeId) . " AND " . $this->_db->quoteInto('entity_id =? ', $this->getPKPropertyValue()));
    }
   
    
    /**
     * add user comment for entity
     *
     */
    public function addComment ($message='', $author='')
    {
        $comment = new AK_Data_Comment();
        $comment->entityTypeId = $this->EntityTypeId;
        $comment->entityId = $this->getPKPropertyValue();
        $comment->creationDate = time();
        $comment->content = $message;
        $comment->author = $author;
        $comment->isApproved = 0;
        $comment->save();
    }
    /**
     * add rank to entity, or replace if user already rank it
     */
    /*public function addRank ($rank)
    {
        $user = Zend::registry('User');
        $sql = $this->_db->select()->from('zanby_entity__ranks AS zer', 'COUNT(user_id)')->where('user_id = ?', $user->getPKPropertyValue())->where('entity_type_id = ?', $this->EntityTypeId)->where('entity_id = ?', $this->getPKPropertyValue());
        if ($this->_db->fetchOne($sql)) {
            $result = $this->_db->update('zanby_entity__ranks', array(
                'rank' => $rank), $this->_db->quoteInto('user_id = ?', $user->getPKPropertyValue()) . " AND " . $this->_db->quoteInto('entity_type_id = ?', $this->EntityTypeId) . " AND " . $this->_db->quoteInto('entity_id = ?', $this->getPKPropertyValue()));
        } else {
            $result = $this->_db->insert('zanby_entity__ranks', array(
                'user_id' => $user->getPKPropertyValue() , 
                'entity_type_id' => $this->EntityTypeId , 
                'entity_id' => $this->getPKPropertyValue() , 
                'rank' => $rank));
        }
        $rank = $this->_db->fetchOne($sql);
    }*/
    /**
     * Return curent rank of entity
     * @return int
     */
   /* public function getRank ()
    {
        if ($this->rank === null) {
            $this->setRank();
        }
        return $this->rank;
    }*/
   /* public function getRankCnt ()
    {
        if ($this->rankCnt === null) {
            $this->setRank();
        }
        return $this->rankCnt;
    }*/
    /**
     * Return curent rank of entity
     *
     * @return int
     */
   /* public function setRank ()
    {
        $sql = $this->_db->select()->from('view_entity__ranks AS ver', array(
            'ver.rank' , 
            'ver.rank_cnt'))->where("ver.entity_id = " . $this->getPKPropertyValue() . " AND ver.entity_type_id = " . $this->EntityTypeId);
        $rank = $this->_db->fetchRow($sql);
        $this->rank = ! empty($rank['rank']) ? $rank['rank'] : 0;
        $this->rankCnt = ! empty($rank['rank_cnt']) ? floor($rank['rank_cnt']) : 0;
    }*/
    
    
    
    /**
     * get comments for entity
     */
    public function getCommentsList ($approvedOnly = true)
    {
        $comments = new AK_Data_Comment_List();
        $comments->addWhere('A.entity_id = ?', $this->getPKPropertyValue());
        $comments->addWhere('A.entity_type_id = ?', $this->EntityTypeId);
        if ($approvedOnly) {
          $comments->addWhere('A.is_approved = ?', 1);
        }
        $comments->setOrder('creation_date DESC');
        
        $comments = $comments->getList();
       
       /* $query = $this->_db->select()
                      ->from(DBT_PREFIX.'_entity__comments as A', 'A.*')
                      ->where("A.entity_id = '" . $this->getPKPropertyValue() . "' AND A.entity_type_id = '" . $this->EntityTypeId. "'");
        $comments = $this->_db->fetchAll($query);*/
        /*foreach ($comments as &$comment) {
            $c = new Ak_Data_Comment($comment['id']);
            $c->user = $comment['login'];
            $comment = $c;
        }*/
        return $comments;
    }
    /**
     * get users comments count for any item
     * @return int
     */
    public function getCommentsCount ($approvedOnly = true)
    {
    
        $comments = new AK_Data_Comment_List();
        $comments->addWhere('A.entity_id = ?', $this->getPKPropertyValue());
        $comments->addWhere('A.entity_type_id = ?', $this->EntityTypeId);
        if ($approvedOnly) {
          $comments->addWhere('A.is_approved = ?', 1);
        }
        
        return $comments->getCount();
        
        /*$query = $this->_db->select()->from(DBT_PREFIX.'_entity__comments AS A', 'COUNT(A.id) as count')->where("A.entity_id = " . $this->getPKPropertyValue() . " AND A.entity_type_id = " . $this->EntityTypeId);
        return $this->_db->fetchOne($query);*/
    }
    
}

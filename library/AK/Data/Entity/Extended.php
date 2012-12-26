<?php
class AK_Data_Entity_Extended extends AK_Data_Entity
{
    protected $metaTitle = '';
    protected $metaKeywords = '';
    protected $metaDescription = '';
    
    protected $rewriteName = '';
    
    
    
    
    
    
    
    public function getMetaDescription ()
    {
        return $this->metaDescription;
    }
    public function getMetaKeywords ()
    {
        return $this->metaKeywords;
    }
    public function getMetaTitle ()
    {
        return $this->metaTitle;
    }
    
    
    
    public function setMetaDescription ($value)
    {
        $this->metaDescription = $value;
        return $this;
    }
    public function setMetaKeywords ($value)
    {
        $this->metaKeywords = $value;
        return $this;
    }
    public function setMetaTitle ($value)
    {
        $this->metaTitle = $value;
        return $this;
    }
    
    
    public function getRewriteName ()
    {
        return $this->rewriteName;
    }
    public function setRewriteName ($value)
    {
        $this->rewriteName = $value;
        return $this;
    }
    

     /**
     * 
     */
    public function loadByRewriteName($name)
    {
        
        
        $query = $this->_db->select()->from(DBT_PREFIX . '_rewrite__names', 'entity_id')->where($this->_db->quoteInto('`rewrite_name` = ? AND `entity_type_id` = '.$this->EntityTypeId, $name ))->where('rewrite_name=?', $name);
        $result = $this->_db->fetchOne($query);
       
        if(!empty($result)) $this->loadByPk($result);
        
        return false;
    }


    public function __construct ($tableName = false, $fields = null)
    {
        parent::__construct($tableName, $fields);
        return true;
    }
    
    public function load ($value = null)
    {
        if (empty($value))
            return false;
            
        parent::load($value);
        
        if (!empty($this->id)) {
          $this->loadMeta();
          $this->loadRewrite();
        }  
    }
    
    public function loadByPk ($pkValue = null)
    {
        parent::loadByPk($pkValue);
        
        if (!empty($this->id)) {
          $this->loadMeta();
          $this->loadRewrite();
        }
    }
    //meta
    private function loadMeta ()
    {
        $query = $this->_db->select()->from(DBT_PREFIX.'_meta__tags', '*')->where('entity_id = ?', $this->id)->where('entity_type_id = ?', $this->EntityTypeId)->limit(1);
        $row = $this->_db->fetchRow($query);
        if ($row) {
            $this->metaTitle = $row['title'];
            $this->metaKeywords = $row['keywords'];
            $this->metaDescription = $row['description'];
        }
    }
    //rewrite
    private function loadRewrite ()
    {
        $query = $this->_db->select()->from(DBT_PREFIX.'_rewrite__names', '*')->where('entity_id = ?', $this->id)->where('entity_type_id = ?', $this->EntityTypeId)->limit(1);
        $row = $this->_db->fetchRow($query);
        if ($row) {
            $this->rewriteName = $row['rewrite_name'];
        } 
    }
    
    public function save ()
    {
    
        foreach ($this->record as $colName => $propertyName) {
            if ($propertyName != $this->pkColName && $propertyName != 'metaTitle' && $propertyName != 'metaDescription' && $propertyName != 'metaKeywords' && $propertyName != 'rewriteName' ) {
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
            $this->setProperty($pkPropertyName, $this->_db->lastInsertId());
        }
        
        $this->_db->delete(DBT_PREFIX.'_meta__tags', $this->_db->quoteInto('`entity_id` = ? AND `entity_type_id` = '.$this->EntityTypeId, $this->getId() ) );
        $this->_db->delete(DBT_PREFIX.'_rewrite__names', $this->_db->quoteInto('`entity_id` = ? AND `entity_type_id` = '.$this->EntityTypeId, $this->getId() ) );
          
        //meta
        $result = $this->_db->insert(DBT_PREFIX.'_meta__tags', array('title' => $this->metaTitle, 'keywords' => $this->metaKeywords, 'description' => $this->metaDescription, 'entity_type_id' => $this->EntityTypeId, 'entity_id' => $this->getId() ) );
        //rewrite
        $result = $this->_db->insert(DBT_PREFIX.'_rewrite__names', array('rewrite_name' => $this->rewriteName, 'entity_type_id' => $this->EntityTypeId, 'entity_id' => $this->getId() ) );
        
        return true;
    }
    /**
     * delete record from DB
     *
     */
    public function delete ()
    {
        
        $this->_db->delete(DBT_PREFIX.'_meta__tags', $this->_db->quoteInto('`entity_id` = ? AND `entity_type_id` = '.$this->EntityTypeId, $this->getId() ) );
        $this->_db->delete(DBT_PREFIX.'_rewrite__names', $this->_db->quoteInto('`entity_id` = ? AND `entity_type_id` = '.$this->EntityTypeId, $this->getId() ) );
       
        parent::delete();
        
        return true;
    }
}

<?php

class AK_Order_Sms_DbTable_AddressBook {
    
    private $_db;
    private $_name;
    private $_user_id;
    
    public function __construct($user_id=null) {
    	$this->_db = Zend_Registry :: get('DBORDER');
    	$this->_name = 'address_book';
    	$this->_user_id = $user_id;
    }
    
    public function getAll($id=null, $data=null, $search=null) {

            $query = $this->_db->select();
          	$query->from(array('a' => $this->_name),
    			array('a.*')
    		);
          	
          	if (!empty($this->_user_id))
          	{
          		$query->where('user_id = ?', $this->_user_id);
          	}
          	
	    	if (!empty($id))
			{
				$query->where('id = ?', $id);
			}
			
			
			if (!empty($search['s_id'])) {
				$query->where('id LIKE ?', "%$search[s_id]%");
			}
			if (!empty($search['s_name'])) {
				$query->where('name LIKE ?', "%$search[s_name]%");
			}
			if (!empty($search['s_surname'])) {
				$query->where('surname LIKE ?', "%$search[s_surname]%");
			}
			if (!empty($search['s_lastname'])) {
				$query->where('first_name LIKE ?', "%$search[s_lastname]%");
			}
			if (!empty($search['s_org'])) {
				$query->where('org LIKE ?', "%$search[s_org]%");
			}
			if (!empty($search['s_position'])) {
				$query->where('position LIKE ?', "%$search[s_position]%");
			}
			if (!empty($search['s_mobile_phone'])) {
				$query->where('mobile_phone LIKE ?', "%$search[s_mobile_phone]%");
			}
			if (!empty($search['s_phone_number'])) {
				$query->where('phone_number LIKE ?', "%$search[s_phone_number]%");
			}
			if (!empty($search['s_balans'])) {
				$query->where('balans LIKE ?', "%$search[s_balans]%");
			}
			if (!empty($search['s_sex']) || $search['s_sex'] != '') {
				$query->where('sex = ?', "$search[s_sex]");
			}
			if (!empty($search['s_status'])) {
				$query->where('status = ?', "$search[s_status]");
			}
			if (!empty($search['s_email'])) {
				$query->where('email LIKE ?', "%$search[s_email]%");
			}
			if (!empty($search['s_fax'])) {
				$query->where('fax LIKE ?', "%$search[s_fax]%");
			}
			
			//SELECT FROM_UNIXTIME(`add_date`,'%d.%m.%Y') FROM `address_book`
			//SELECT * FROM address_book WHERE FROM_UNIXTIME(`add_date`,'%d.%m.%Y') = '26.11.2012'
			if (!empty($search['s_add_date'])) {
				$query->where("FROM_UNIXTIME(add_date,'%d.%m.%Y') = ?", "$search[s_add_date]");
			}
			
			
			if (!empty($data['search']))
			{
				$query->where('name LIKE ?', "%$data[search]%");
				$query->orwhere('surname LIKE ?', "%$data[search]%");
				$query->orwhere('first_name LIKE ?', "%$data[search]%");
				$query->orwhere('org LIKE ?', "%$data[search]%");
				$query->orwhere('mobile_phone LIKE ?', "%$data[search]%");
			}
			
// 			if (!empty($data['search_org']))
// 			{
// 				$query->where('org LIKE ?', "%$data[search_org]%");
// 			}
			
// 			if (!empty($data['search_phone']))
// 			{
// 				$query->where('mobile_phone LIKE ?', "%$data[search_phone]%");
// 			}
			
			if (!empty($data['sidx']) && !empty($data['sord']))
			{
			    $query->order($data['sidx'].' '.$data['sord']);
			}
			
			if (!empty($data['page']) && !empty($data['rows']))
			{
				$query->limitPage($data['page'], $data['rows']);
			}
            
			$res = $this->_db->fetchAll($query);
            return $res;
    }
    
    public function getSex() {
    
    	$query = $this->_db->select();
    	$query->from(array('a' => 'address_book__sex'),
    			array('a.code','a.title')
    	);
    	$query->order('a.code ASC');
    	$res = $this->_db->fetchAll($query);
    	return $res;
    }
    
    public function getStatus() {
    
    	$query = $this->_db->select();
    	    	$query->from(array('a' => 'address_book__status'),
    			array('a.code','a.title')
    	);
    	$query->order('a.code ASC');
    	$res = $this->_db->fetchAll($query);
    	return $res;
    }
    
    public function insert($data)
    {
    	$result = $this->_db->insert($this->_name,$data);
    
    	return $result;
    }
    
    public function insertData($table,$data)
    {
    	$result = $this->_db->insert($table,$data);
    
    	return $result;
    }
    
    public function update($data,$where)
    {
    	$result = $this->_db->update($this->_name, $data, $where);
    
    	return $result;
    }
    
    public function delete($where)
    {
    	$result = $this->_db->delete($this->_name, $where);
    
    	return $result;
    }
    
    public function updateData($table,$data,$where)
    {
    	$result = $this->_db->update($table, $data, $where);
    
    	return $result;
    }
    
    public function getTpl($id=null) {
    
    	$query = $this->_db->select();
    	$query->from(array('a' => 'address_book__tpl'),
    			array('a.*',
    			        'title_type' => '(SELECT title FROM address_book__tpl_type t1 WHERE t1.code = a.type_tpl)')
    	);
    	
    	$query->where('type_tpl = 0');
    	
    	$query->orwhere('user_id=?', $this->_user_id);
    	    	
    	if (!empty($id))
    	{
    		$query->where('id = ?', $id);
    	}
    	
    	$query->order('a.type_tpl DESC');
    	$res = $this->_db->fetchAll($query);
    	return $res;
    }
}
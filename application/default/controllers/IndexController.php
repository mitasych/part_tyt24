<?php
class IndexController extends AK_Controller_Action
{
    public $params;
    protected $_db;
    
    public function __construct (Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);
        $this->_db = Zend_Registry :: get('DB');
        $this->params = $this->_getAllParams();
    }
   
    //public function indexAction()
    //{
	//    include_once('index/action.index.php');

    //}
    public function expoAction()
    {
          $this->view->expo = "<iframe width=800 height=1800 src='http://an.expopromoter.com/ru/1625/embedded/list/'></iframe>"; 

    }


    public function rubricAction()
    {
	    include_once('index/action.rubric.php');

    }
    
    public function indexAction() {
      $okato = (isset($this->params['okato']) && !empty($this->params['okato']) && ($this->params['okato'] !== 'sort') && ($this->params['okato'] !== 'all'))?$this->params['okato']:null;
      $okved = (isset($this->params['okved']) && !empty($this->params['okved']) && ($this->params['okved'] !== 'all'))?$this->params['okved']:null;
      $id = isset($this->params['id'])?$this->params['id']:null;
      $sort = (isset($this->params['okato']) && $this->params['okato'] == 'sort')? true : false;
      $show_all_okato = (isset($this->params['okato']) && $this->params['okato'] == 'all')? true : false;
      $show_all_okved = (isset($this->params['okved']) && $this->params['okved'] == 'all')? true : false;
      
//-------------------------------------- формирование списка рубрик ---------------------
      $max_count_okved = array('id' => null, 'name' => null, 'count' => 0);
      if(empty($id)) {
	      $data = $this->getOkvedList($okved, $okato);
	      if($data) {
		      foreach($data as &$value) {
		      	$value['subitems'] = $this->getOkvedList($value['id'], $okato);
		      	$value['count'] = $this->getCompanyCount($value['id'], $okato);
		      	if($value['subitems'] !== false) {
			      	foreach($value['subitems'] as &$subvalue) {
			      		$subvalue['subitems'] = $this->getOkvedList($subvalue['id'], $okato);
			      		$subvalue['count'] = $this->getCompanyCount($subvalue['id'], $okato);
			      		if($subvalue['subitems'] !== false) {
			      			foreach($subvalue['subitems'] as &$subsubvalue) {
			      				$subsubvalue['count'] = $this->getCompanyCount($subsubvalue['id'], $okato);
			      				($max_count_okved['count'] < $subsubvalue['count']) ? $max_count_okved = $subsubvalue : $max_count_okved;
			      			}
			      			uasort($subvalue['subitems'], array($this, 'sort_menu'));
			      		}
			      		else {
			      			($max_count_okved['count'] < $subvalue['count']) ? $max_count_okved = $subvalue : $max_count_okved;
			      		}
			      	}
			    uasort($value['subitems'], array($this, 'sort_menu'));
		      	}
		      }
		  uasort($data, array($this, 'sort_menu'));
		  if(!is_null($okved)) {
		  	$okvedList = $this->getOkvedOne($okved);
		  	$okvedList['subitems'] = $data;
		  	$data = array($okvedList);
		  	if($okved > 0 && $okved < 9) {
		  		$okved_menu_first_level = $this->getOkvedList();
    			$this->view->okvedMenuFirstLevel = $okved_menu_first_level;
		  	}
		  }
	      //echo "<pre>";
	      //print_r($data);
	      //echo "</pre>";
	      }
      }
// сортировка рубрик в алфавитном порядке
      else {
      	$okatoItems = $this->getOkatoOne($okato);
      	$okved_menu = new AK_okved_MenuList();
      	if ($id=='*') {
 			$data = $okved_menu->setOrder('A.name ASC')->returnAsAssoc(true)->getList();
 		}
 		else {
 			$data = $okved_menu->addWhere('A.name LIKE ?',$id."%")->setOrder('A.name ASC')->returnAsAssoc(true)->getList();
 		}
 		if(count($data) > 0) {
	 		foreach($data as $key => $value) {
	 			$count = $this->getCompanyCount($key, $okatoItems['id']);
	 			$data_sort[] = array('id' => $key, 'name' => $value, 'count' => $count);
	 			($max_count_okved['count'] < $count) ? $max_count_okved = array('id' => $key, 'name' => $value, 'count' => $count) : $max_count_okved;
	 		}
	 		$data = $data_sort;
 		}
 		else {$data = array();}
 		$this->view->alf = array ("*", "А" , "Б" , "В" , "Г" , "Д" , "Е" , "Ё" , "Ж" , "З" , "И" , "К" , "Л" , "М" , "Н" , "О" , "П" , "Р" , "С" , "Т" , "У" , "Ф" , "Х" , "Ц" , "Ч" , "Ш" , "Щ" , "Э" , "Ю" , "Я" );
      }

//-------------------------------------- формирование списка регионов ---------------------
	$max_count_okato = array('id' => null, 'name' => null, 'count' => 0);
      if($sort) { // сортировка регионов по алфавиту
      	$okato_menu = new AK_okato_List();
      	$okatoList = $okato_menu->addWhere('A.parent_id in (29554, 29553 ,29552,29551,29550,29549,29548,29543)')->setOrder('A.name ASC')->returnAsAssoc(true)->getList();
      	foreach($okatoList as $item) {
      		$type = $this->addRepublic($item['name']);
       		if($item['additional_info'] == "") {$city[] = array( "id" => $item['id'],  "name" => $item['name'].$type, "additional_info" => $item['additional_info']);}
       		else {
            	$other[] = array( "id" => $item['id'],  "name" => $item['name'].$type, "additional_info" => $item['additional_info'] );
       		}
      	}
      	if(!empty($city) && !empty($other)) {
      		$okatoList = array_merge($city, $other);
      	}
      }
      else {
	      $okatoList = $this->getOkatoList($okato);
	      if($okatoList) {
	      	$okatoParentList = array();
		      foreach($okatoList as $key => &$value) {
		      	// удаляем отображение названия "города краевого подчинения", вместо этого названия отображаем список этих городов
		      	if(strpos($value['name'],'/')!==false) {
		      		$type = $this->filterName($value['name']);
		      		$sub_okato = $this->getOkatoList($value['id']);
		      		foreach($sub_okato as $subvalue) {
		      			// подсчитываем коли-во предприятий для каждого населенного пункта из списка
		      			$subvalue['count'] = $this->getCompanyCount($okved, $subvalue['id']);
		      			// переопределяем родителя для данных населенных пунктов
		      			$subvalue['parent_id'] = $value['parent_id'];
		      			$subvalue['type'] = $type;
		      			$okatoParentList[] = $subvalue;
		      		}
		      		unset($okatoList[$key]);
		      	}
		      	else {
		      		// подсчитываем коли-во предприятий для каждого населенного пункта из списка
		      		$value['count'] = $this->getCompanyCount($okved, $value['id']);
		      		$type = $this->addRepublic($value['name']);
		      		$value['type'] = $type;
		      		if(is_null($okato)) {
		      			$value['subitems'] = $this->getOkatoList($value['id']);
		      			foreach($value['subitems'] as $key => &$subvalue) {
		      				$type = $this->addRepublic($subvalue['name']);
		      				$subvalue['name'] = $subvalue['name'].$type;
		      				$subvalue['count'] = $this->getCompanyCount($okved, $subvalue['id']);
		      				($max_count_okato['count'] < $subvalue['count']) ? $max_count_okato = $subvalue : $max_count_okato;
		      			}
		      			uasort($value['subitems'], array($this, 'sort_menu'));
		      		}
		      	}
		      }
		      $okatoList = array_merge($okatoList, $okatoParentList);
		      usort($okatoList, array($this, 'sort_menu'));
		      if(!is_null($okato)) {
		      	$max_count_okato = $okatoList[0];
		      	$okatoList = array(
		      			array('subitems' => $okatoList)
		      			);
		      	$okato_menu_first_level = $this->getOkatoList();
		      	$this->view->okato_menu_first_level = $okato_menu_first_level;
		      }
	      }
      }
      //echo "<pre>";
      //print_r($okatoList);
      //echo "</pre>";
      $this->view->okved_id = $okved; 							//number or null
      $this->view->okato_id = ($sort)?'sort':$okato; 			//number or null
      $this->view->id = $id; 									//string or null (буква алфавита при сортировке рубрик)
      $this->view->all_okato = $show_all_okato; 				//boolean (true при отображении всех регионов)
      $this->view->all_okved = $show_all_okved; 				//boolean (true при отображении всех рубрик)
      $this->view->current_okved = $this->getOkvedOne($okved); 	//array (содержит запись выбранной рубрики)
      $this->view->max_okved = $max_count_okved;					//array (содержит запись рубрики с максимальным количеством предприятий)
      $this->view->current_okato = $this->getOkatoOne($okato); 	//array (содержит запись выбранного региона)
      $this->view->parent_okato = $this->getParentOkato($this->view->current_okato['parent_id']); //array (содержит запись родителя выбранного региона)
      $this->view->max_okato = $max_count_okato;				//array (содержит запись региона с максимальным количеством предприятий)
      $this->view->okved = $data; 								//array (содержит список рубрик)
      $this->view->okato = $okatoList; 							//array (содержит список регионов)
    }
    
      private function getOkvedList($okved = null, $okato = null) {
      	$select = $this->_db->select();
    	$select->from('okved_level', array('id', 'name', 'parent_id'));
    	if(empty($okved)) {
    		$select->where('parent_id IS NULL');
    	}
    	else {
    		$select->where('parent_id = ?', $okved);
    	}
    	$data = $select->query()->fetchAll();
    	if(count($data) > 0) {
    		return $data;
    	}
    	else {
    		return false;
    	}
      }
    
    private function getOkvedOne($id = null) {
    	if(!is_null($id)) {
    		$select = $this->_db->select();
    		$select->from('okved_level')
    				->where('id = ?', $id);
    		return $this->_db->fetchRow($select);
    	}
    	else {
    		return false;
    	}
    }
    
    private function getOkatoList($okato = null) {
    	$select = $this->_db->select();
    	$select->from('class_okato', array('id', 'name', 'code', 'parent_id', 'additional_info'));
    	if(is_null($okato)) {
    		$select->where('parent_id IS NULL');
    	}
    	else {
    		$select->where('parent_id = ?', $okato);
    	}
    	return $select->query()->fetchAll();
    }
    
    private function getOkatoOne($id = null) {
    	if(!is_null($id)) {
	    	$select = $this->_db->select();
	    	$select->from('class_okato')
	    			->where('id = ?', $id);
	    	return $this->_db->fetchRow($select);
    	}
    	else {
    		return false;
    	}
    }
    
    private function getCompanyCount($okved = null, $okato = null) {
    	  $okved_level = null;
    	  if ($okved > 0 && $okved < 9) {
	      	$okved_level = 'zerolevel_id';
	      } elseif (!empty($okved) && $okved < 55) {
	      	$okved_level = 'firstlevel_id';
	      } elseif($okved > 54) {
	      	$okved_level = 'secondlevel_id';
	      }
	       	$select = $this->_db->select();
	    	$select->from('class_company_short5_2', array('count'=>'COUNT(*)'));
	      
	    	if(!empty($okved) && !empty($okved_level)) {
		    	$select->where($okved_level.' = \''.$okved.'\'');
		    }
		    $where = $this->getWhereForOkato($okato);
		    if(!empty($where)) {
		    	$select->where($where);
		    }
		    //echo $select->__toString()."<br>";
	    	return $count = $this->_db->fetchOne($select);
    }
    
    private function sort_menu($a, $b) {
	    if ($a['count'] == $b['count']) {
	        return 0;
	    }
	    return ($a['count'] > $b['count']) ? -1 : 1;
	}
	
	private function filterName($name) {
		$type = "";
		if(strpos($name,"Города")!== false)
                $type = 'г. ';
        if(strpos($name,"Поселки")!== false)
                $type = 'п. ';
        if(strpos($name,"Районы")!== false)
                $type = 'р-н. ';
        if(strpos($name,"Сельсоветы")!== false)
                $type = 'c/c. ';
        if(strpos($name,"Улусы")!== false)
                $type = 'Улус ';
        if(strpos($name,"Наслеги")!== false)
                $type = 'Насег ';
    return $type;
	}
	
	private function addRepublic($name) {
		$type = "";
		if((strpos($name,"область") !== false) || (strpos($name,"округ") !== false) || (strpos($name,"края") !== false) || (strpos($name,"край") !== false) || (strpos($name,"г.") !== false)) {
        	$type = "";
        }
        else {
        	$type = ', Респ. ';
        }
    return $type;
	}
	
	private function getWhereForOkato($okato) {
	    // Т.к у ФЕДЕРАЛЬНЫХ ОКРУГОВ НЕТ КОДА ПО КОТОРОМУ МОЖНО ПРОИЗВЕСТИ ПОИСК,
        // то нужно производить поиск в элементах у которых стоит на него parent_id
    	$where = '';
    	if(!empty($okato)) {
    		$one_okato = $this->getOkatoOne($okato);
    		if ($one_okato['code'] == "") {
    			$okato_list = $this->getOkatoList($okato);
    			if(count($okato_list) > 0) {
    				foreach($okato_list as $value) {
    					$where .= "okato_id LIKE '{$value['code']}%' OR ";
    				}
    				$where = substr($where, 0, -4);
    			}
    		}
    		else {
    			$where = "okato_id LIKE '{$one_okato['code']}%'";
    		}
    	}
    	return $where;
	}
	
	private function getParentOkato($id = null) {
		if(!empty($id)) {
			$parent = $this->getOkatoOne($id);
			if (strpos($parent['name'],'/')!==false) {
				$parent = $this->getOkatoOne($parent['parent_id']);
			}
		return $parent;
		}
		return false; 
	}
	
    public function awayAction()
    {
	    include_once('index/action.away.php');

    }


    public function avtocounterAction()        {$this->_redirect(SITE_URL.'/index/index/avto/');}
    public function sendtofriendAction()       {include_once('index/action.sendToFriend.php');}
    public function streetAction()             {include_once('index/action.street.php');}
}

<?php
class IndexxController extends AK_Controller_Action
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

    public function rubricAction()
    {
	    include_once('index/action.rubric.php');


    }

    public function individualAction()
    {
    	include_once('index2/action.individual.php');
    	$this->view->okved = $this->getOkvedList();
    	//$this->view->okato = $this->getOkatoList();

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

		      				$sublevel3 = $this->getOkatoList($subvalue['id']);
		      				foreach ($sublevel3 as $key3 => $level3) {
		      					if(strpos($level3['name'],'/')!==false) {
						      		$type = $this->filterName($level3['name']);
						      		$sub_okato = $this->getOkatoList($level3['id']);
						      		$subParentList = array();
						      		foreach($sub_okato as $subvalue3) {
										// подсчитываем коли-во предприятий для каждого населенного пункта из списка
						      			$subvalue3['count'] = $this->getCompanyCount($okved, $subvalue3['id']);
						      			// переопределяем родителя для данных населенных пунктов
						      			$subvalue3['parent_id'] = $level3['parent_id'];
						      			$subvalue3['type'] = $type;
						      			$subParentList[] = $subvalue3;
						      		}
						      	} else {
						      		// echo $level3['id']; exit();
									$sub_okato = $this->getOkatoList($level3['id']);
						      		$subParentList = array();
						      		foreach($sub_okato as $subvalue3) {
										$type = $this->addRepublic($subvalue3['name']);
					      				$subvalue3['name'] = $subvalue3['name'].$type;
					      				$subvalue3['count'] = $this->getCompanyCount($okved, $subvalue3['id']);
					      				$subParentList[] = $subvalue3;
						      		}
						      	}
						      	$subvalue['level3'] = $subParentList;
		      				}
		      			}
		      			uasort($value['subitems'], array($this, 'sort_menu'));
		      		}
		      	} 
		    } // end foreach

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

     $this->view->okved = $data;
     $this->view->okato = $okatoList;
     $this->view->real_okved = $this->getOKVED();

     // echo "<pre>"; print_r($okatoList); exit();


    
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
		      	
				//--------------price------------
				if ($value['c_all']<100){$value['column'] = 25+0*$value['c_all'];}
				elseif ($value['c_all']<200){$value['column'] = round(40+0*$value['c_all']);}
				elseif ($value['c_all']<400){$value['column'] = round(0.125*$value['c_all']);}
				elseif ($value['c_all']<600){$value['column'] = round(0.1*$value['c_all']);}
				elseif ($value['c_all']<1000){$value['column'] = round(0.08*$value['c_all']);}
				elseif ($value['c_all']<1600){$value['column'] = round(0.063*$value['c_all']);}
				elseif ($value['c_all']<2500){$value['column'] = round(0.048*$value['c_all']);}
				elseif ($value['c_all']<4000){$value['column'] = round(0.038*$value['c_all']);}
				elseif ($value['c_all']<7000){$value['column'] = round(0.027*$value['c_all']);}
				elseif ($value['c_all']<12000){$value['column'] = round(0.019*$value['c_all']);}
				elseif ($value['c_all']<20000){$value['column'] = round(0.014*$value['c_all']);}
				elseif ($value['c_all']<40000){$value['column'] = round(0.009*$value['c_all']);}
				elseif ($value['c_all']<60000){$value['column'] = round(0.007*$value['c_all']);}
				elseif ($value['c_all']<100000){$value['column'] = round(0.005*$value['c_all']);}
				elseif ($value['c_all']<160000){$value['column'] = round(0.004*$value['c_all']);}
				elseif ($value['c_all']<250000){$value['column'] = round(0.003*$value['c_all']);}
				elseif ($value['c_all']<1000000){$value['column'] = round(0.0025*$value['c_all']);}
				
				if ($value['c_tele']<100){$value['position'] = 25+0*$value['c_tele'];}
				elseif ($value['c_tele']<200){$value['position'] = round(40+0*$value['c_tele']);}
				elseif ($value['c_tele']<400){$value['position'] = round(0.125*$value['c_tele']);}
				elseif ($value['c_tele']<600){$value['position'] = round(0.1*$value['c_tele']);}
				elseif ($value['c_tele']<1000){$value['position'] = round(0.08*$value['c_tele']);}
				elseif ($value['c_tele']<1600){$value['position'] = round(0.063*$value['c_tele']);}
				elseif ($value['c_tele']<2500){$value['position'] = round(0.048*$value['c_tele']);}
				elseif ($value['c_tele']<4000){$value['position'] = round(0.038*$value['c_tele']);}
				elseif ($value['c_tele']<7000){$value['position'] = round(0.027*$value['c_tele']);}
				elseif ($value['c_tele']<12000){$value['position'] = round(0.019*$value['c_tele']);}
				elseif ($value['c_tele']<20000){$value['position'] = round(0.014*$value['c_tele']);}
				elseif ($value['c_tele']<40000){$value['position'] = round(0.009*$value['c_tele']);}
				elseif ($value['c_tele']<60000){$value['position'] = round(0.007*$value['c_tele']);}
				elseif ($value['c_tele']<100000){$value['position'] = round(0.005*$value['c_tele']);}
				elseif ($value['c_tele']<160000){$value['position'] = round(0.004*$value['c_tele']);}
				elseif ($value['c_tele']<250000){$value['position'] = round(0.003*$value['c_tele']);}
				elseif ($value['c_tele']<1000000){$value['position'] = round(0.0025*$value['c_tele']);}

				if ($value['c_email']<100){$value['count'] = 25+0*$value['c_email'];}
				elseif ($value['c_email']<200){$value['count'] = round(40+0*$value['c_email']);}
				elseif ($value['c_email']<400){$value['count'] = round(0.125*$value['c_email']);}
				elseif ($value['c_email']<600){$value['count'] = round(0.1*$value['c_email']);}
				elseif ($value['c_email']<1000){$value['count'] = round(0.08*$value['c_email']);}
				elseif ($value['c_email']<1600){$value['count'] = round(0.063*$value['c_email']);}
				elseif ($value['c_email']<2500){$value['count'] = round(0.048*$value['c_email']);}
				elseif ($value['c_email']<4000){$value['count'] = round(0.038*$value['c_email']);}
				elseif ($value['c_email']<7000){$value['count'] = round(0.027*$value['c_email']);}
				elseif ($value['c_email']<12000){$value['count'] = round(0.019*$value['c_email']);}
				elseif ($value['c_email']<20000){$value['count'] = round(0.014*$value['c_email']);}
				elseif ($value['c_email']<40000){$value['count'] = round(0.009*$value['c_email']);}
				elseif ($value['c_email']<60000){$value['count'] = round(0.007*$value['c_email']);}
				elseif ($value['c_email']<100000){$value['count'] = round(0.005*$value['c_email']);}
				elseif ($value['c_email']<160000){$value['count'] = round(0.004*$value['c_email']);}
				elseif ($value['c_email']<250000){$value['count'] = round(0.003*$value['c_email']);}
				elseif ($value['c_email']<1000000){$value['count'] = round(0.0025*$value['c_email']);}
				
				
				//--------------------end--------
				
				if($value['subitems'] !== false) {
			      	foreach($value['subitems'] as &$subvalue) {
			      		$subvalue['subitems'] = $this->getOkvedList($subvalue['id'], $okato);
			      		$subvalue['count'] = $this->getCompanyCount($subvalue['id'], $okato);
							//--------------price------------
						if ($value['c_all']<100){$value['column'] = 25+0*$value['c_all'];}
						elseif ($subvalue['c_all']<200){$subvalue['column'] = round(40+0*$subvalue['c_all']);}
						elseif ($subvalue['c_all']<400){$subvalue['column'] = round(0.125*$subvalue['c_all']);}
						elseif ($subvalue['c_all']<600){$subvalue['column'] = round(0.1*$subvalue['c_all']);}
						elseif ($subvalue['c_all']<1000){$subvalue['column'] = round(0.08*$subvalue['c_all']);}
						elseif ($subvalue['c_all']<1600){$subvalue['column'] = round(0.063*$subvalue['c_all']);}
						elseif ($subvalue['c_all']<2500){$subvalue['column'] = round(0.048*$subvalue['c_all']);}
						elseif ($subvalue['c_all']<4000){$subvalue['column'] = round(0.038*$subvalue['c_all']);}
						elseif ($subvalue['c_all']<7000){$subvalue['column'] = round(0.027*$subvalue['c_all']);}
						elseif ($subvalue['c_all']<12000){$subvalue['column'] = round(0.019*$subvalue['c_all']);}
						elseif ($subvalue['c_all']<20000){$subvalue['column'] = round(0.014*$subvalue['c_all']);}
						elseif ($subvalue['c_all']<40000){$subvalue['column'] = round(0.009*$subvalue['c_all']);}
						elseif ($subvalue['c_all']<60000){$subvalue['column'] = round(0.007*$subvalue['c_all']);}
						elseif ($subvalue['c_all']<100000){$subvalue['column'] = round(0.005*$subvalue['c_all']);}
						elseif ($subvalue['c_all']<160000){$subvalue['column'] = round(0.004*$subvalue['c_all']);}
						elseif ($subvalue['c_all']<250000){$subvalue['column'] = round(0.003*$subvalue['c_all']);}
						elseif ($subvalue['c_all']<1000000){$subvalue['column'] = round(0.0025*$subvalue['c_all']);}
						
						if ($value['c_tele']<100){$value['position'] = 25+0*$value['c_tele'];}
						elseif ($subvalue['c_tele']<200){$subvalue['position'] = round(40+0*$subvalue['c_tele']);}
						elseif ($subvalue['c_tele']<400){$subvalue['position'] = round(0.125*$subvalue['c_tele']);}
						elseif ($subvalue['c_tele']<600){$subvalue['position'] = round(0.1*$subvalue['c_tele']);}
						elseif ($subvalue['c_tele']<1000){$subvalue['position'] = round(0.08*$subvalue['c_tele']);}
						elseif ($subvalue['c_tele']<1600){$subvalue['position'] = round(0.063*$subvalue['c_tele']);}
						elseif ($subvalue['c_tele']<2500){$subvalue['position'] = round(0.048*$subvalue['c_tele']);}
						elseif ($subvalue['c_tele']<4000){$subvalue['position'] = round(0.038*$subvalue['c_tele']);}
						elseif ($subvalue['c_tele']<7000){$subvalue['position'] = round(0.027*$subvalue['c_tele']);}
						elseif ($subvalue['c_tele']<12000){$subvalue['position'] = round(0.019*$subvalue['c_tele']);}
						elseif ($subvalue['c_tele']<20000){$subvalue['position'] = round(0.014*$subvalue['c_tele']);}
						elseif ($subvalue['c_tele']<40000){$subvalue['position'] = round(0.009*$subvalue['c_tele']);}
						elseif ($subvalue['c_tele']<60000){$subvalue['position'] = round(0.007*$subvalue['c_tele']);}
						elseif ($subvalue['c_tele']<100000){$subvalue['position'] = round(0.005*$subvalue['c_tele']);}
						elseif ($subvalue['c_tele']<160000){$subvalue['position'] = round(0.004*$subvalue['c_tele']);}
						elseif ($subvalue['c_tele']<250000){$subvalue['position'] = round(0.003*$subvalue['c_tele']);}
						elseif ($subvalue['c_tele']<1000000){$subvalue['position'] = round(0.0025*$subvalue['c_tele']);}

						if ($value['c_email']<100){$value['count'] = 25+0*$value['c_email'];}
						elseif ($subvalue['c_email']<200){$subvalue['count'] = round(40+0*$subvalue['c_email']);}
						elseif ($subvalue['c_email']<400){$subvalue['count'] = round(0.125*$subvalue['c_email']);}
						elseif ($subvalue['c_email']<600){$subvalue['count'] = round(0.1*$subvalue['c_email']);}
						elseif ($subvalue['c_email']<1000){$subvalue['count'] = round(0.08*$subvalue['c_email']);}
						elseif ($subvalue['c_email']<1600){$subvalue['count'] = round(0.063*$subvalue['c_email']);}
						elseif ($subvalue['c_email']<2500){$subvalue['count'] = round(0.048*$subvalue['c_email']);}
						elseif ($subvalue['c_email']<4000){$subvalue['count'] = round(0.038*$subvalue['c_email']);}
						elseif ($subvalue['c_email']<7000){$subvalue['count'] = round(0.027*$subvalue['c_email']);}
						elseif ($subvalue['c_email']<12000){$subvalue['count'] = round(0.019*$subvalue['c_email']);}
						elseif ($subvalue['c_email']<20000){$subvalue['count'] = round(0.014*$subvalue['c_email']);}
						elseif ($subvalue['c_email']<40000){$subvalue['count'] = round(0.009*$subvalue['c_email']);}
						elseif ($subvalue['c_email']<60000){$subvalue['count'] = round(0.007*$subvalue['c_email']);}
						elseif ($subvalue['c_email']<100000){$subvalue['count'] = round(0.005*$subvalue['c_email']);}
						elseif ($subvalue['c_email']<160000){$subvalue['count'] = round(0.004*$subvalue['c_email']);}
						elseif ($subvalue['c_email']<250000){$subvalue['count'] = round(0.003*$subvalue['c_email']);}
						elseif ($subvalue['c_email']<1000000){$subvalue['count'] = round(0.0025*$subvalue['c_email']);}

						//--------------------end--------
						
						
						
						if($subvalue['subitems'] !== false) {
			      			foreach($subvalue['subitems'] as &$subsubvalue) {
			      				$subsubvalue['count'] = $this->getCompanyCount($subsubvalue['id'], $okato);
			      					//--------------price------------
						if ($value['c_all']<100){$value['column'] = 25+0*$value['c_all'];}
						elseif ($subsubvalue['c_all']<200){$subsubvalue['column'] = round(40+0*$subsubvalue['c_all']);}
						elseif ($subsubvalue['c_all']<400){$subsubvalue['column'] = round(0.125*$subsubvalue['c_all']);}
						elseif ($subsubvalue['c_all']<600){$subsubvalue['column'] = round(0.1*$subsubvalue['c_all']);}
						elseif ($subsubvalue['c_all']<1000){$subsubvalue['column'] = round(0.08*$subsubvalue['c_all']);}
						elseif ($subsubvalue['c_all']<1600){$subsubvalue['column'] = round(0.063*$subsubvalue['c_all']);}
						elseif ($ssububvalue['c_all']<2500){$subsubvalue['column'] = round(0.048*$subsubvalue['c_all']);}
						elseif ($subsubvalue['c_all']<4000){$subsubvalue['column'] = round(0.038*$subsubvalue['c_all']);}
						elseif ($subsubvalue['c_all']<7000){$subsubvalue['column'] = round(0.027*$subsubvalue['c_all']);}
						elseif ($subsubvalue['c_all']<12000){$subsubvalue['column'] = round(0.019*$subsubvalue['c_all']);}
						elseif ($subsubvalue['c_all']<20000){$subsubvalue['column'] = round(0.014*$subsubvalue['c_all']);}
						elseif ($subsubvalue['c_all']<40000){$subsubvalue['column'] = round(0.009*$subsubvalue['c_all']);}
						elseif ($subsubvalue['c_all']<60000){$subsubvalue['column'] = round(0.007*$subsubvalue['c_all']);}
						elseif ($subsubvalue['c_all']<100000){$subsubvalue['column'] = round(0.005*$subsubvalue['c_all']);}
						elseif ($subsubvalue['c_all']<160000){$subsubvalue['column'] = round(0.004*$subsubvalue['c_all']);}
						elseif ($subsubvalue['c_all']<250000){$subsubvalue['column'] = round(0.003*$subsubvalue['c_all']);}
						elseif ($subsubvalue['c_all']<1000000){$subsubvalue['column'] = round(0.0025*$subsubvalue['c_all']);}

						if ($value['c_tele']<100){$value['position'] = 25+0*$value['c_tele'];}
						elseif ($subsubvalue['c_tele']<200){$subsubvalue['position'] = round(40+0*$subsubvalue['c_tele']);}
						elseif ($subsubvalue['c_tele']<400){$subsubvalue['position'] = round(0.125*$subsubvalue['c_tele']);}
						elseif ($subsubvalue['c_tele']<600){$subsubvalue['position'] = round(0.1*$subsubvalue['c_tele']);}
						elseif ($subsubvalue['c_tele']<1000){$subsubvalue['position'] = round(0.08*$subsubvalue['c_tele']);}
						elseif ($subsubvalue['c_tele']<1600){$subsubvalue['position'] = round(0.063*$subsubvalue['c_tele']);}
						elseif ($ssububvalue['c_tele']<2500){$subsubvalue['position'] = round(0.048*$subsubvalue['c_tele']);}
						elseif ($subsubvalue['c_tele']<4000){$subsubvalue['position'] = round(0.038*$subsubvalue['c_tele']);}
						elseif ($subsubvalue['c_tele']<7000){$subsubvalue['position'] = round(0.027*$subsubvalue['c_tele']);}
						elseif ($subsubvalue['c_tele']<12000){$subsubvalue['position'] = round(0.019*$subsubvalue['c_tele']);}
						elseif ($subsubvalue['c_tele']<20000){$subsubvalue['position'] = round(0.014*$subsubvalue['c_tele']);}
						elseif ($subsubvalue['c_tele']<40000){$subsubvalue['position'] = round(0.009*$subsubvalue['c_tele']);}
						elseif ($subsubvalue['c_tele']<60000){$subsubvalue['position'] = round(0.007*$subsubvalue['c_tele']);}
						elseif ($subsubvalue['c_tele']<100000){$subsubvalue['position'] = round(0.005*$subsubvalue['c_tele']);}
						elseif ($subsubvalue['c_tele']<160000){$subsubvalue['position'] = round(0.004*$subsubvalue['c_tele']);}
						elseif ($subsubvalue['c_tele']<250000){$subsubvalue['position'] = round(0.003*$subsubvalue['c_tele']);}
						elseif ($subsubvalue['c_tele']<1000000){$subsubvalue['position'] = round(0.0025*$subsubvalue['c_tele']);}

						if ($value['c_email']<100){$value['count'] = 25+0*$value['c_email'];}
						elseif ($subsubvalue['c_email']<200){$subsubvalue['count'] = round(40+0*$subsubvalue['c_email']);}
						elseif ($subsubvalue['c_email']<400){$subsubvalue['count'] = round(0.125*$subsubvalue['c_email']);}
						elseif ($subsubvalue['c_email']<600){$subsubvalue['count'] = round(0.1*$subsubvalue['c_email']);}
						elseif ($subsubvalue['c_email']<1000){$subsubvalue['count'] = round(0.08*$subsubvalue['c_email']);}
						elseif ($subsubvalue['c_email']<1600){$subsubvalue['count'] = round(0.063*$subsubvalue['c_email']);}
						elseif ($ssububvalue['c_email']<2500){$subsubvalue['count'] = round(0.048*$subsubvalue['c_email']);}
						elseif ($subsubvalue['c_email']<4000){$subsubvalue['count'] = round(0.038*$subsubvalue['c_email']);}
						elseif ($subsubvalue['c_email']<7000){$subsubvalue['count'] = round(0.027*$subsubvalue['c_email']);}
						elseif ($subsubvalue['c_email']<12000){$subsubvalue['count'] = round(0.019*$subsubvalue['c_email']);}
						elseif ($subsubvalue['c_email']<20000){$subsubvalue['count'] = round(0.014*$subsubvalue['c_email']);}
						elseif ($subsubvalue['c_email']<40000){$subsubvalue['count'] = round(0.009*$subsubvalue['c_email']);}
						elseif ($subsubvalue['c_email']<60000){$subsubvalue['count'] = round(0.007*$subsubvalue['c_email']);}
						elseif ($subsubvalue['c_email']<100000){$subsubvalue['count'] = round(0.005*$subsubvalue['c_email']);}
						elseif ($subsubvalue['c_email']<160000){$subsubvalue['count'] = round(0.004*$subsubvalue['c_email']);}
						elseif ($subsubvalue['c_email']<250000){$subsubvalue['count'] = round(0.003*$subsubvalue['c_email']);}
						elseif ($subsubvalue['c_email']<1000000){$subsubvalue['count'] = round(0.0025*$subsubvalue['c_email']);}
											
						//--------------------end--------
								
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
		      					//--------------price------------
				if ($value['c_all']<100){$value['node_count'] = 25+0*$value['c_all'];}
				elseif ($value['c_all']<200){$value['node_count'] = round(40+0*$value['c_all']);}
				elseif ($value['c_all']<400){$value['node_count'] = round(0.125*$value['c_all']);}
				elseif ($value['c_all']<600){$value['node_count'] = round(0.1*$value['c_all']);}
				elseif ($value['c_all']<1000){$value['node_count'] = round(0.08*$value['c_all']);}
				elseif ($value['c_all']<1600){$value['node_count'] = round(0.063*$value['c_all']);}
				elseif ($value['c_all']<2500){$value['node_count'] = round(0.048*$value['c_all']);}
				elseif ($value['c_all']<4000){$value['node_count'] = round(0.038*$value['c_all']);}
				elseif ($value['c_all']<7000){$value['node_count'] = round(0.027*$value['c_all']);}
				elseif ($value['c_all']<12000){$value['node_count'] = round(0.019*$value['c_all']);}
				elseif ($value['c_all']<20000){$value['node_count'] = round(0.014*$value['c_all']);}
				elseif ($value['c_all']<40000){$value['node_count'] = round(0.009*$value['c_all']);}
				elseif ($value['c_all']<60000){$value['node_count'] = round(0.007*$value['c_all']);}
				elseif ($value['c_all']<100000){$value['node_count'] = round(0.005*$value['c_all']);}
				elseif ($value['c_all']<160000){$value['node_count'] = round(0.004*$value['c_all']);}
				elseif ($value['c_all']<250000){$value['node_count'] = round(0.003*$value['c_all']);}
				elseif ($value['c_all']<1000000){$value['node_count'] = round(0.0025*$value['c_all']);}

				if ($value['c_tele']<100){$value['control_number'] = 25+0*$value['c_tele'];}
				elseif ($value['c_tele']<200){$value['control_number'] = round(40+0*$value['c_tele']);}
				elseif ($value['c_tele']<400){$value['control_number'] = round(0.125*$value['c_tele']);}
				elseif ($value['c_tele']<600){$value['control_number'] = round(0.1*$value['c_tele']);}
				elseif ($value['c_tele']<1000){$value['control_number'] = round(0.08*$value['c_tele']);}
				elseif ($value['c_tele']<1600){$value['control_number'] = round(0.063*$value['c_tele']);}
				elseif ($value['c_tele']<2500){$value['control_number'] = round(0.048*$value['c_tele']);}
				elseif ($value['c_tele']<4000){$value['control_number'] = round(0.038*$value['c_tele']);}
				elseif ($value['c_tele']<7000){$value['control_number'] = round(0.027*$value['c_tele']);}
				elseif ($value['c_tele']<12000){$value['control_number'] = round(0.019*$value['c_tele']);}
				elseif ($value['c_tele']<20000){$value['control_number'] = round(0.014*$value['c_tele']);}
				elseif ($value['c_tele']<40000){$value['control_number'] = round(0.009*$value['c_tele']);}
				elseif ($value['c_tele']<60000){$value['control_number'] = round(0.007*$value['c_tele']);}
				elseif ($value['c_tele']<100000){$value['control_number'] = round(0.005*$value['c_tele']);}
				elseif ($value['c_tele']<160000){$value['control_number'] = round(0.004*$value['c_tele']);}
				elseif ($value['c_tele']<250000){$value['control_number'] = round(0.003*$value['c_tele']);}
				elseif ($value['c_tele']<1000000){$value['control_number'] = round(0.0025*$value['c_tele']);}
				
				if ($value['c_email']<100){$value['parent_code'] = 25+0*$value['c_email'];}
				elseif ($value['c_email']<200){$value['parent_code'] = round(40+0*$value['c_email']);}
				elseif ($value['c_email']<400){$value['parent_code'] = round(0.125*$value['c_email']);}
				elseif ($value['c_email']<600){$value['parent_code'] = round(0.1*$value['c_email']);}
				elseif ($value['c_email']<1000){$value['parent_code'] = round(0.08*$value['c_email']);}
				elseif ($value['c_email']<1600){$value['parent_code'] = round(0.063*$value['c_email']);}
				elseif ($value['c_email']<2500){$value['parent_code'] = round(0.048*$value['c_email']);}
				elseif ($value['c_email']<4000){$value['parent_code'] = round(0.038*$value['c_email']);}
				elseif ($value['c_email']<7000){$value['parent_code'] = round(0.027*$value['c_email']);}
				elseif ($value['c_email']<12000){$value['parent_code'] = round(0.019*$value['c_email']);}
				elseif ($value['c_email']<20000){$value['parent_code'] = round(0.014*$value['c_email']);}
				elseif ($value['c_email']<40000){$value['parent_code'] = round(0.009*$value['c_email']);}
				elseif ($value['c_email']<60000){$value['parent_code'] = round(0.007*$value['c_email']);}
				elseif ($value['c_email']<100000){$value['parent_code'] = round(0.005*$value['c_email']);}
				elseif ($value['c_email']<160000){$value['parent_code'] = round(0.004*$value['c_email']);}
				elseif ($value['c_email']<250000){$value['parent_code'] = round(0.003*$value['c_email']);}
				elseif ($value['c_email']<1000000){$value['parent_code'] = round(0.0025*$value['c_email']);}
				
				
				//--------------------end--------
				
				
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
		      				//--------------price------------
				if ($subvalue['c_all']<100){$subvalue['node_count'] = 25+0*$subvalue['c_all'];}
				elseif ($subvalue['c_all']<200){$subvalue['node_count'] = round(40+0*$subvalue['c_all']);}
				elseif ($subvalue['c_all']<400){$subvalue['node_count'] = round(0.125*$subvalue['c_all']);}
				elseif ($subvalue['c_all']<600){$subvalue['node_count'] = round(0.1*$subvalue['c_all']);}
				elseif ($subvalue['c_all']<1000){$subvalue['node_count'] = round(0.08*$subvalue['c_all']);}
				elseif ($subvalue['c_all']<1600){$subvalue['node_count'] = round(0.063*$subvalue['c_all']);}
				elseif ($subvalue['c_all']<2500){$subvalue['node_count'] = round(0.048*$subvalue['c_all']);}
				elseif ($subvalue['c_all']<4000){$subvalue['node_count'] = round(0.038*$subvalue['c_all']);}
				elseif ($subvalue['c_all']<7000){$subvalue['node_count'] = round(0.027*$subvalue['c_all']);}
				elseif ($subvalue['c_all']<12000){$subvalue['node_count'] = round(0.019*$subvalue['c_all']);}
				elseif ($subvalue['c_all']<20000){$subvalue['node_count'] = round(0.014*$subvalue['c_all']);}
				elseif ($subvalue['c_all']<40000){$subvalue['node_count'] = round(0.009*$subvalue['c_all']);}
				elseif ($subvalue['c_all']<60000){$subvalue['node_count'] = round(0.007*$subvalue['c_all']);}
				elseif ($subvalue['c_all']<100000){$subvalue['node_count'] = round(0.005*$subvalue['c_all']);}
				elseif ($subvalue['c_all']<160000){$subvalue['node_count'] = round(0.004*$subvalue['c_all']);}
				elseif ($subvalue['c_all']<250000){$subvalue['node_count'] = round(0.003*$subvalue['c_all']);}
				elseif ($subvalue['c_all']<1000000){$subvalue['node_count'] = round(0.0025*$subvalue['c_all']);}
				
					if ($subvalue['c_tele']<100){$subvalue['control_number'] = 25+0*$subvalue['c_tele'];}
				elseif ($subvalue['c_tele']<200){$subvalue['control_number'] = round(40+0*$subvalue['c_tele']);}
				elseif ($subvalue['c_tele']<400){$subvalue['control_number'] = round(0.125*$subvalue['c_tele']);}
				elseif ($subvalue['c_tele']<600){$subvalue['control_number'] = round(0.1*$subvalue['c_tele']);}
				elseif ($subvalue['c_tele']<1000){$subvalue['control_number'] = round(0.08*$subvalue['c_tele']);}
				elseif ($subvalue['c_tele']<1600){$subvalue['control_number'] = round(0.063*$subvalue['c_tele']);}
				elseif ($subvalue['c_tele']<2500){$subvalue['control_number'] = round(0.048*$subvalue['c_tele']);}
				elseif ($subvalue['c_tele']<4000){$subvalue['control_number'] = round(0.038*$subvalue['c_tele']);}
				elseif ($subvalue['c_tele']<7000){$subvalue['control_number'] = round(0.027*$subvalue['c_tele']);}
				elseif ($subvalue['c_tele']<12000){$subvalue['control_number'] = round(0.019*$subvalue['c_tele']);}
				elseif ($subvalue['c_tele']<20000){$subvalue['control_number'] = round(0.014*$subvalue['c_tele']);}
				elseif ($subvalue['c_tele']<40000){$subvalue['control_number'] = round(0.009*$subvalue['c_tele']);}
				elseif ($subvalue['c_tele']<60000){$subvalue['control_number'] = round(0.007*$subvalue['c_tele']);}
				elseif ($subvalue['c_tele']<100000){$subvalue['control_number'] = round(0.005*$subvalue['c_tele']);}
				elseif ($subvalue['c_tele']<160000){$subvalue['control_number'] = round(0.004*$subvalue['c_tele']);}
				elseif ($subvalue['c_tele']<250000){$subvalue['control_number'] = round(0.003*$subvalue['c_tele']);}
				elseif ($subvalue['c_tele']<1000000){$subvalue['control_number'] = round(0.0025*$subvalue['c_tele']);}

					if ($subvalue['c_email']<100){$subvalue['parent_code'] = 25+0*$subvalue['c_email'];}
				elseif ($subvalue['c_email']<200){$subvalue['parent_code'] = round(40+0*$subvalue['c_email']);}
				elseif ($subvalue['c_email']<400){$subvalue['parent_code'] = round(0.125*$subvalue['c_email']);}
				elseif ($subvalue['c_email']<600){$subvalue['parent_code'] = round(0.1*$subvalue['c_email']);}
				elseif ($subvalue['c_email']<1000){$subvalue['parent_code'] = round(0.08*$subvalue['c_email']);}
				elseif ($subvalue['c_email']<1600){$subvalue['parent_code'] = round(0.063*$subvalue['c_email']);}
				elseif ($subvalue['c_email']<2500){$subvalue['parent_code'] = round(0.048*$subvalue['c_email']);}
				elseif ($subvalue['c_email']<4000){$subvalue['parent_code'] = round(0.038*$subvalue['c_email']);}
				elseif ($subvalue['c_email']<7000){$subvalue['parent_code'] = round(0.027*$subvalue['c_email']);}
				elseif ($subvalue['c_email']<12000){$subvalue['parent_code'] = round(0.019*$subvalue['c_email']);}
				elseif ($subvalue['c_email']<20000){$subvalue['parent_code'] = round(0.014*$subvalue['c_email']);}
				elseif ($subvalue['c_email']<40000){$subvalue['parent_code'] = round(0.009*$subvalue['c_email']);}
				elseif ($subvalue['c_email']<60000){$subvalue['parent_code'] = round(0.007*$subvalue['c_email']);}
				elseif ($subvalue['c_email']<100000){$subvalue['parent_code'] = round(0.005*$subvalue['c_email']);}
				elseif ($subvalue['c_email']<160000){$subvalue['parent_code'] = round(0.004*$subvalue['c_email']);}
				elseif ($subvalue['c_email']<250000){$subvalue['parent_code'] = round(0.003*$subvalue['c_email']);}
				elseif ($subvalue['c_email']<1000000){$subvalue['parent_code'] = round(0.0025*$subvalue['c_email']);}
				
				
				//--------------------end--------
							
							
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
      //print_r($data);
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
    	$select->from('okved_level',array('id', 'name', 'parent_id','c_all','c_tele','c_email','column','position','count'));
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

      private function searchOkvedList($okved = null, $okato = null) {
      	$select = $this->_db->select();
    	$select->from('okved_level',array( 'name'));
    	if(empty($okved)) {
    		$select->where('parent_id IS NULL');
    	}
    	else {
    		$select->where('id = ?', $okved);
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
    	$select->from('class_okato', array('id', 'name', 'code', 'parent_id', 'additional_info','c_all','c_tele','c_email','node_count','control_number','parent_code'));
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

	public function getOKVED($num = NULL, $count = 0){

		$select = $this->_db->select();
		$select->from('class_okved', array('id', 'code', 'name', 'parent_id', 'parent_code', 'node_count'));
		
		if($num){
			$select->where(" parent_id = '".$num."'");
		} else { 
			$select->where('parent_id IS NULL');
		}
		$list = $select->query()->fetchAll();

		$style = '';
		$class = 'parent';
		if($num){
		  $style = " padding-left: 20px; display: none; ";
		  $class = 'sub';
		}

		$okvedList = '';
		$cnt = 0;
		foreach ($list as $key => $val) {

			$query = $this->_db->select();
			$query->from('link_okved', array('count'=>'COUNT(id_okved)'));
			$query->where('id_okved LIKE "' . $val['code'] . '%"');
			$subrow = $this->_db->fetchRow($query);
			$cnt = $subrow['count'];

			if($cnt == 0)
				$cnt = $this->getOkvedCount($val['id']);

			$okvedList .=   "<div id= 'list' name= 'list_{$val['id']}' style='{$style}' class='{$class}'>".
							"<input type='checkbox' id='{$row['code']}' name='items[]' value='{$val['code']}' >&nbsp;".
							"<span id='list_name'><b>{$val['code']}</b> ".$val['name'] . "&nbsp;({$cnt})</span>";
			$okvedList .= $this->getOKVED($val['id']);
			
			$okvedList .= "</div>";
		}

		return $okvedList;
	}

	public function getOkvedCount($id, &$count=0){

		$select = $this->_db->select();
		$select->from('class_okved', array('id', 'code', 'name', 'parent_id', 'parent_code', 'node_count'));
		$select->where(" parent_id = '".$id."'");
		$list = $select->query()->fetchAll();
		foreach ($list as $key => $val) {
			$query = $this->_db->select();
			$query->from('link_okved', array('count'=>'COUNT(id_okved)'));
			$query->where('id_okved LIKE "' . $val['code'] . '%"');
			$subrow = $this->_db->fetchRow($query);
			$count += $subrow['count'];
			$this->getOkvedCount($val['id'], &$count);
		}

		return $count;		

	}

    public function avtocounterAction()        {$this->_redirect(SITE_URL.'/index/index/avto/');}
    public function sendtofriendAction()       {include_once('index/action.sendToFriend.php');}
    public function streetAction()             {include_once('index/action.street.php');}



}

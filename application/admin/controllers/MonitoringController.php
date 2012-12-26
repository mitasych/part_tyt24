<?php

class Admin_MonitoringController extends AK_Controller_Action {

    public function tarifsAction() {
        include_once('monitoring/action.tarifs.php');
    }

    public function tarifsallAction() {
        include_once('monitoring/action.tarifsall.php');
    }

    public function tarifeditAction() {
        include_once('monitoring/action.tarifedit.php');
    }
    public function tarifdeleteAction() {
        include_once('monitoring/action.tarifdelete.php');
    }
	
    public function tarifalleditAction() {
        include_once('monitoring/action.tarifalledit.php');
    }
    public function tarifalldeleteAction() {
        include_once('monitoring/action.tarifalldelete.php');
    }
    public function massTarifSortAction() {

        $this->params  = $this->getRequest()->getParams();
        
        if (!empty($this->params['CHECK_ELEMENTS']) && !empty($this->params['SORT_ELEMENTS'])) {

            foreach($this->params['SORT_ELEMENTS'] as $_key => &$_value) {
                if (in_array($_key, $this->params['CHECK_ELEMENTS'])) {
                    $currentItem = new AK_Order_Monitoring_Tarif(intval($_key));
                    $currentItem->order = $_value;
                    $currentItem->save();
                }
            }

        }

        $this->_redirect(MODULE_URL.'/monitoring/tarifs/');
    }

    public function tarifspAction() {
        include_once('monitoring/action.tarifsp.php');
    }

    public function tarifpeditAction() {
        include_once('monitoring/action.tarifpedit.php');
    }
    public function tarifpdeleteAction() {
        include_once('monitoring/action.tarifpdelete.php');
    }
    public function massTarifpSortAction() {

        $this->params  = $this->getRequest()->getParams();

        if (!empty($this->params['CHECK_ELEMENTS']) && !empty($this->params['SORT_ELEMENTS'])) {

            foreach($this->params['SORT_ELEMENTS'] as $_key => &$_value) {
                if (in_array($_key, $this->params['CHECK_ELEMENTS'])) {
                    $currentItem = new AK_Order_Monitoring_Tarif_Period(intval($_key));
                    $currentItem->order = $_value;
                    $currentItem->save();
                }
            }

        }

        $this->_redirect(MODULE_URL.'/monitoring/tarifsp/');
    }



    public function kategortypesAction() {
        include_once('monitoring/action.kategortypes.php');
    }


    public function eventtypesAction() {
        include_once('monitoring/action.eventtypes.php');
    }

    public function eventtypeeditAction() {
        include_once('monitoring/action.eventtypeedit.php');
    }
    public function eventtypedeleteAction() {
        include_once('monitoring/action.eventtypedelete.php');
    }

    public function kategoreditAction() {
        include_once('monitoring/action.kategoredit.php');
    }
    public function kategordeleteAction() {
        include_once('monitoring/action.kategordelete.php');
    }

    public function massEventtypesSortAction() {

        $this->params  = $this->getRequest()->getParams();

        if (!empty($this->params['CHECK_ELEMENTS']) && !empty($this->params['SORT_ELEMENTS'])) {

            foreach($this->params['SORT_ELEMENTS'] as $_key => &$_value) {
                if (in_array($_key, $this->params['CHECK_ELEMENTS'])) {
                    $currentItem = new AK_Order_Monitoring_Event_Type(intval($_key));
                    $currentItem->order = $_value;
                    $currentItem->save();
                }
            }

        }

        $this->_redirect(MODULE_URL.'/monitoring/eventtypes/');
    }



    public function kontragentsAction() {
        include_once('monitoring/action.kontragents.php');
    }

    public function kontragenteditAction() {
        include_once('monitoring/action.kontragentedit.php');
    }

    public function kontragentdeleteAction() {
        include_once('monitoring/action.kontragentdelete.php');
    }
	
	// monitoring demo
	
    public function demokontragentsAction() {

        include_once('monitoring/action.demokontragents.php');
    }

    public function kontragentdemoeditAction() {
        include_once('monitoring/action.kontragentdemoedit.php');
    }

    public function kontragentdemodeleteAction() {
        include_once('monitoring/action.kontragentdemodelete.php');
    }	
	
    public function demoeventsAction() {
        include_once('monitoring/action.eventsdemo.php');
    }
    public function eventdemoeditAction() {
        include_once('monitoring/action.eventdemoedit.php');
    }
    public function eventdemodeleteAction() {
        include_once('monitoring/action.eventdemodelete.php');
    }	
	
	

    public function mkontragentsAction() {
        include_once('monitoring/action.mkontragents.php');
    }

    public function eventsyesAction() {
        include_once('monitoring/action.eventsyes.php');
    }
    public function eventsdoAction() {
        include_once('monitoring/action.eventsdo.php');
    }
    public function eventsAction() {
        include_once('monitoring/action.events.php');
    }
    public function eventeditAction() {
        include_once('monitoring/action.eventedit.php');
    }
    public function eventdeleteAction() {
        include_once('monitoring/action.eventdelete.php');
    }
	
	
    public function kontrdataAction() {
        //include_once('monitoring/action.eventdelete.php');
				
		//colNames:['Контрагент', 'ИНН', 'Регион', 'Страна', 'Дата события', 'Тема события', 'Информация', 'Дата добавления'],
		//http://www.trirand.com/blog/jqgrid/jqgrid.html
		//читаем параметры
		$curPage = empty($_POST['page'])?'':$_POST['page'];
		$rowsPerPage = empty($_POST['rows'])?'':$_POST['rows'];
		$sortingField = empty($_POST['sidx'])?'':$_POST['sidx'];
		$sortingOrder = empty($_POST['sord'])?'':$_POST['sord'];
		//$tarif_id = empty($this->params['tarif'])?$this->_user->getActualTarifInfo()->tarifId:$this->params['tarif'];

		//$ttList = new AK_Order_Monitoring_Event_Type_List();
		//		$this->view->ttList = $ttList->getList();

		//$tarif_id = $this->_user->getActualTarifInfo()->tarifId;
		//print 	$tarif_id.'-'.$this->params['tarif'].'<br>';

		$kontragentsList = new AK_Order_Kontragent_List();
		//$kontragentsList->addWhere('A.tarif_id = ?', $tarif_id);
		$kontragentsList->setOrder($sortingField.' '.$sortingOrder);
		$kontragentsList->setCurrentPage($curPage);
		$kontragentsList->setListSize($rowsPerPage);
		$kontragentsList->addWhere('id in (select DISTINCT kontragent_id from orders_users__kontragents) ');
		$kontragentsList->addWhere('id in (select DISTINCT kontragent_id from orders_monitoring__events) ');

		//print_r($this->view->regions);
		//if (!empty($this->params['filter_serch']))
		{
			//print($this->params['filter_inn']);
			if (!empty($this->params['filter_inn']))
			{
				$kontragentsList->addWhere('inn = \''.$this->params['filter_inn'].'\'');
			}
			if (!empty($this->params['filter_name']))
			{
				$kontragentsList->addWhere('title LIKE \'%'.$this->params['filter_name'].'%\'');
			}
			if (!empty($this->params['filter_region']))
			{
				$kontragentsList->addWhere('region LIKE \''.$this->params['filter_region'].'\'');
			}
		}
		if (!empty($this->params['filter_serch2']))
		{
			$this->params['filter_inn'] = '';
			$this->params['filter_name'] = '';
			$this->params['filter_name'] = '0';
		}

		$kontragentsList = $kontragentsList->getList();
		$response->page = $curPage;
		$response->total =  $rowsPerPage;
		$response->records = 1;
		$i= 0;
		foreach($kontragentsList as $item)
		{
			$i++;
			//print_r($item);
			$item_new = array();
			$item_new['id']=$item->id;
			//{if $k->getKontragent()->getCompany()}<a href='http://tyt24.ru/item/index/id/{$k->getKontragent()->getCompany()->id}/'>{/if}{if $k->title}{$k->title|escape}{else}{$k->getKontragent()->title|escape}{/if}</a>
			// if ($item->getKontragent()->getCompany())
				// $title = "<a href='http://tyt24.ru/item/index/id/".$item->getKontragent()->getCompany()->id."/'>".$item->getKontragent()->title."</a>";
			// else
			$title =$item->title;
			$item_new['cell']=array('<input type=checkbox name="delItem[]" value="'.$item->id.'">', $title, $item->region, $item->adress, $item->inn, 0);
			/*$item_new['name']='del';
			$item_new['inn']='del';
			$item_new['region']='del';
			$item_new['do']='del';*/
			$response->rows[]=$item_new;
			
		}
		$response->total = ceil($i / $rowsPerPage);
		$response->records = $i;
		echo Zend_Json::encode($response);
		exit;

	}
	
    public function eventdataAction() {
	
		$curPage = empty($_POST['page'])?'':$_POST['page'];
		$rowsPerPage = empty($_POST['rows'])?'':$_POST['rows'];
		$sortingField = empty($_POST['sidx'])?'':$_POST['sidx'];
		$sortingOrder = empty($_POST['sord'])?'':$_POST['sord'];
        $db = Zend_Registry::get('DBORDER');
		$query = $db->select();
		$query->from('orders_monitoring__events AS A');
		//$query->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
		$query->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));
		$query->joinLeft('orders_monitoring__events_status AS D', 'A.statys = D.id', new Zend_Db_Expr('D.simbul AS simbul'));
		if (!empty($_GET['kid']))
			$query->where('A.kontragent_id = ?', $_GET['kid']);

		

		// $queryC = $db->select();
		// $queryC->from('orders_monitoring__events AS A', 'COUNT(A.id)');
		// $queryC->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);
		// $queryC->where($this->getWhere());
		// $totalRows = $db->fetchOne($queryC);

		//$firstRowIndex = $curPage * $rowsPerPage - $rowsPerPage;


		$query->order($sortingField.' '.$sortingOrder);
		$query->limitPage($curPage, $rowsPerPage);

		//сохраняем номер текущей страницы, общее количество страниц и общее количество записей
		$response->page = $curPage;
		// $response->total = ceil($totalRows / $rowsPerPage);
		// $response->records = $totalRows;

		$i=0;
		foreach ($db->fetchAll($query) as $event) {
			// $et = new AK_Order_Monitoring_Event_Type($event['event_type_id']);
			// $ev = new AK_Order_Monitoring_Event($event['id']);
			$add='';
			
			$response->rows[$i]['id']=$event['id'];
			$response->rows[$i]['cell']=array('<input type=checkbox name="delItem[]" value="'.$event['id'].'">',
				$event['content'],
				$event['event_type'],
				$event['istochnik'],
				empty($event['date_do'])?'':date('d.m.Y', $event['date_do']),
				$event['user'],
				$event['simbul']
				);
			$i++;
		}
		$response->total = ceil($i / $rowsPerPage);
		$response->records = $i;
		$response->testing = $i;
		echo Zend_Json::encode($response);
		exit;

	}
	
    public function eventitemAction() {
	
        $db = Zend_Registry::get('DBORDER');
		$query = $db->select();
		$query->from('orders_monitoring__events AS A');
		$query->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));
		$query->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.inn AS inn, B.title AS title, B.region AS region, B.adress  AS adress , B.rykov AS rykov'));
		$query->joinLeft('orders_monitoring__events_status AS D', 'A.statys = D.id', new Zend_Db_Expr('D.simbul AS simbul'));
		if (!empty($_GET['id']))
			$query->where('A.id = ?', $_GET['id']);
		$event = $db->fetchAll($query);
		$event = $event[0];
		$response->id = $event['id'];
		$response->cell = array(
			$event['content'],
			$event['event_type'],
			$event['istochnik'],
			date('d-m-Y', $event['date_created']),
			date('d-m-Y', $event['event_date']),
			$event['user'],
			$event['simbul'],
			$event['inn'],
			$event['title'],
			$event['region'],
			$event['adress'],
			$event['rykov']
			);
		
		echo Zend_Json::encode($response);
		exit;

	}
	
    public function setstatusAction() {
	
       /* $db = Zend_Registry::get('DBORDER');
		$query = $db->select();
		$query->from('orders_monitoring__events AS A');
		$query->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));
		$query->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.inn AS inn, B.title AS title, B.region AS region, B.adress  AS adress , B.rykov AS rykov'));
		if (!empty($_GET['id']))
			$query->where('A.id = ?', $_GET['id']);
		$event = $db->fetchAll($query);
		$event = $event[0];
		$response->id = $event['id'];
		$response->cell = array(
			$event['content'],
			$event['event_type'],
			$event['istochnik'],
			date('d-m-Y', $event['date_created']),
			date('d-m-Y', $event['event_date']),
			$event['user'],
			$event['statys'],
			$event['inn'],
			$event['title'],
			$event['region'],
			$event['adress'],
			$event['rykov']
			);
		*/
		$db = Zend_Registry::get('DBORDER');
		if ($_GET['stat'] == 'yes')
		{
			$data = array(
					'active' => 1					
				);
			$query = $db->update('orders_monitoring__events', $data, 'id = '.$_GET['id']);
			
		}
		else
		{
			
			$data = array(
					'statys' => $_GET['stat'],
					'user' => $_SESSION['admin_id'],
					'date_do' => mktime()
					
				);
			$query = $db->update('orders_monitoring__events', $data, 'id = '.$_GET['id']);
		//	echo Zend_Json::encode($response);
		}
		exit;

	}
	
    public function setsessAction() {
		$_SESSION['user_id_event'] = array();
		$db = Zend_Registry::get('DBORDER');
		$query = $db->select();
		$query->from('orders_users__accounts AS A');
		//$query->joinLeft('orders_users__monitoring_tarifs AS C', 'A.id = C.user_id');
		// $query->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.inn AS inn, B.title AS title, B.region AS region, B.adress  AS adress , B.rykov AS rykov'));
		// $query->joinLeft('orders_monitoring__events_status AS D', 'A.statys = D.id', new Zend_Db_Expr('D.simbul AS simbul'));
		// if (!empty($_GET['id']))
		$query->where('A.id in (SELECT `user_id` FROM `orders_users__monitoring_tarifs` WHERE `date_next_mon` > '.mktime(0, 0, 0, date('m'), date('d'), date('Y')).' and `date_next_mon` < '.mktime(0, 0, 0, date('m'), date('d')+1, date('Y')).')');
		$query->order('RAND()');
		$query->limitPage(0, 1);
		//print $query;
		$user = $db->fetchAll($query);
		
		//$user = $db->fetchAll('SELECT * FROM orders_users__accounts ORDER BY RAND() LIMIT 0,1');
		print_r($user);
		$_SESSION['user_id_event'][] = 1;
		print $_SESSION['user_id_event'];
		//$this->_redirect(MODULE_URL.'/monitoring/eventsdo/');
		exit;

	}

}

<?php
$type = new AK_Order_Monitoring_Tarif_ListType();
$this->view->type = $type->getList();

if (!empty($this->params['delItem']))
{   
    foreach ($this->params['delItem'] as $item)
    {
         $delK = new AK_Order_User_Kontragent($item);
         $delK->delete();
    }   
}


$type = new AK_Order_Monitoring_Tarif_ListType();
$this->view->type = $type->getList();

if (!empty($this->params['addItem']))
{   
    foreach ($this->params['addItem'] as $item)
    {  

      $db = Zend_Registry::get("DBORDER");
      if ($_POST['is_copy']==true){
             $uk = new AK_Order_User_Kontragent();
        } else{
            $uk = new AK_Order_User_Kontragent($item); 
        }
   $uk = new AK_Order_User_Kontragent($item);
   $id_k = $uk->getKontragent()->id;
   $vuk =new AK_Order_User_Tarif();
   $tarifId = $vuk->getTarifId($_POST['tarifId']);
   $auk = new AK_Order_Kontragent('id',$id_k);

      //  if (!$form->isPostback()) {
        //   $auk->inn =  $_POST['inn'];
        //   $auk->region = $_POST['region'] ;
        //   $auk->title= $_POST['title'] ;
           $uk->tarif_id = $tarifId;
  
       //    $auk->save();
           $data['user_id'] = $this->currentUser->id;
           $data['kontragent_id'] =$id_k;
           $data['tarif_id'] =  $tarifId;
           $data['title'] =   $uk->title;  

            if ($_POST['is_copy']==true){
                $result = $db->insert('orders_users__kontragents', $data);    
            }
            else{
                $result = $db->update('orders_users__kontragents',$data,$db->quoteInto('id=?',$item));
            }  
    }   
}


if (!empty($this->params['did'])) {
    $uk = new AK_Order_User_Kontragent($this->params['did']);
    if (!empty($uk->id) && $uk->userId == $this->_user->id) {
        $uk->delete();
        $this->_redirect('/monitoring/list/');
    }
}

//colNames:['Контрагент', 'ИНН', 'Регион', 'Страна', 'Дата события', 'Тема события', 'Информация', 'Дата добавления', 'Действия'],
//http://www.trirand.com/blog/jqgrid/jqgrid.html
//читаем параметры
$curPage = empty($_POST['page'])?'':$_POST['page'];
$rowsPerPage = empty($_POST['rows'])?'':$_POST['rows'];
$sortingField = empty($_POST['sidx'])?'':$_POST['sidx'];
$sortingOrder = empty($_POST['sord'])?'':$_POST['sord'];
$tarif_id = empty($this->params['tarif'])?$this->_user->getActualTarifInfo()->tarifId:$this->params['tarif'];

$ttList = new AK_Order_Monitoring_Event_Type_List();
        $this->view->ttList = $ttList->getList();		

//$tarif_id = $this->_user->getActualTarifInfo()->tarifId;
//print 	$tarif_id.'-'.$this->params['tarif'].'<br>';

$kontragentsList = new AK_Order_User_Kontragent_List();
//echo $this->params['filter_all'];

if (empty($this->params['filter_all']))
{
$kontragentsList->addWhere('A.tarif_id = ?', $tarif_id);
}
if ($this->params['filter_all'] == 'off')
{
$kontragentsList->addWhere('A.tarif_id = ?', $tarif_id);
}

$kontragentsList->setOrder($sortingField.' '.$sortingOrder);
$kontragentsList->setCurrentPage($curPage);
$kontragentsList->setListSize($rowsPerPage);

//print_r($this->view->regions);
//if (!empty($this->params['filter_serch']))
{
	//print($this->params['filter_inn']);

	if (!empty($this->params['filter_inn']))
	{
		$kontragentsList->addWhere('B.inn LIKE \''.$this->params['filter_inn'].'%\'');
	}
	if (!empty($this->params['filter_name']))
	{  

		$kontragentsList->addWhere('B.title LIKE \'%'.$this->params['filter_name'].'%\'');
	}
	if (!empty($this->params['filter_region']))
	{
		$kontragentsList->addWhere('B.region LIKE \''.$this->params['filter_region'].'\'');
	}

     if (!empty($_GET['country_mask'])) {
        $kontragentsList->addWhere("B.country LIKE ?", $_GET['country_mask'].'%');
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


$db = Zend_Registry::get('DBORDER');
$queryCompany = $db->select();
$queryCompany->from('orders_kontragents AS A');
$queryCompany->join('orders_monitoring__events AS C', 'A.id = C.kontragent_id');
$queryCompany->joinLeft('orders_kontragents AS B', 'C.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
$queryCompany->where('A.id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);

 if (!empty($_GET['country_mask'])) {
        $queryCompany->where("B.country LIKE ?", $_GET['country_mask'].'%');
    }
$n = 0;

foreach ($db->fetchAll($queryCompany) as $Company1) {
    $kontr = $Company1['kontragent_id'];
    $titleCompany[$kontr] = $Company1['title'];
    $countContr[$kontr]['count']= $countContr[$kontr]['count'] + 1;
    $countContr[$kontr]['inn'] = $Company1['inn'];  
    $countContr[$kontr]['region'] = $Company1['region'];
    $countContr[$kontr]['country'] = $Company1['country'];
    $countContr[$kontr]['title'] = $Company1['title'];
}


foreach($kontragentsList as $item)
{
	$i++;
	$item_new = array();
	$item_new['id']=$item->id;
	//{if $k->getKontragent()->getCompany()}<a href='http://tyt24.ru/item/index/id/{$k->getKontragent()->getCompany()->id}/'>{/if}{if $k->title}{$k->title|escape}{else}{$k->getKontragent()->title|escape}{/if}</a>
	// if ($item->getKontragent()->getCompany())
	// 	// $title = "<a href='http://tyt24.ru/item/index/id/".$item->getKontragent()->getCompany()->id."/'>".$item->getKontragent()->title."</a>";
	// else
		$title ='<a class="descriptionCompany"  target="_blank" href="/monitoring/eventc/'.$item->getKontragent()->id.'/" style="color: #1F5863;  cursor: pointer;">'
        . $item->title.'</a>';
        
	$item_new['cell']=array( $item->getKontragent()->region, 
         $item->getKontragent()->country
        );
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



$db = Zend_Registry::get('DBORDER');
$query = $db->select();
$query->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
$query->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
$query->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));

$query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);
if (!empty($_SESSION['monfilter']) && in_array($_SESSION['monfilter'], array('all', 'year', 'month', 'week', 'new'))) {
    switch ($_SESSION['monfilter']){
        case 'all':
            break;
        case 'year':
            $query->where('A.date_created >=?', time()-60*60*24*365);
            break;
        case 'month':
            $query->where('A.date_created >=?', time()-60*60*24*30);
            break;
        case 'week':
            $query->where('A.date_created >=?', time()-60*60*24*7);
            break;
        case 'new':
            $query->where('A.id NOT IN (SELECT event_id FROM orders_monitoring__events_views WHERE user_id = ?)', $this->_user->id);
            break;
    }
}

if (!empty($_GET['search_innnaim_mask'])) {
    $query->where("(B.title LIKE ? OR B.inn LIKE ?)", $_GET['search_innnaim_mask'].'%');
    var_dump( $_GET['search_innnaim_mask']);
    exit();
}
else {

    if (!empty($_GET['kontragent_title_mask'])) {
        $query->where("B.title LIKE ?", $_GET['kontragent_title_mask'].'%');
    }

    if (!empty($_GET['filter_inn'])) {
        $query->where("B.inn LIKE ?", $_GET['filter_inn'].'%');
    }

    if (!empty($_GET['region_mask'])) {
        $query->where("B.region LIKE ?", $_GET['region_mask'].'%');
    }

    if (!empty($_GET['country_mask'])) {
        $query->where("B.country LIKE ?", $_GET['country_mask'].'%');
    }

    if (!empty($_GET['event_date_mask'])) {
        if ($_GET['event_date_mask'] = mktime(0,0,0, substr($_GET['event_date_mask'],3,2), substr($_GET['event_date_mask'],0,2), substr($_GET['event_date_mask'],6,4) )) {
            $query->where("A.event_date >= ?", $_GET['event_date_mask']);
        }
    }

    if (!empty($_GET['event_date_po_mask'])) {
        if ($_GET['event_date_po_mask'] = mktime(0,0,0, substr($_GET['event_date_po_mask'],3,2), substr($_GET['event_date_po_mask'],0,2), substr($_GET['event_date_po_mask'],6,4) )) {
            $query->where("A.event_date <= ?", $_GET['event_date_po_mask']);
        }
    }

    if (!empty($_GET['event_type_mask'])) {
        $query->where("C.id IN (?)", explode('-', $_GET['event_type_mask']));
    }

    if (!empty($_GET['content_mask'])) {
        $query->where("A.content LIKE ?", '%'.$_GET['content_mask'].'%');
    }

    if (!empty($_GET['date_created_mask'])) {
        if ($_GET['date_created_mask'] = mktime(0,0,0, substr($_GET['date_created_mask'],3,2), substr($_GET['date_created_mask'],0,2), substr($_GET['date_created_mask'],6,4) )) {
            $query->where("A.date_created >= ?", $_GET['date_created_mask']);
        }
    }

    if (!empty($_GET['date_created_po_mask'])) {
        if ($_GET['date_created_po_mask'] = mktime(0,0,0, substr($_GET['date_created_po_mask'],3,2), substr($_GET['date_created_po_mask'],0,2), substr($_GET['date_created_po_mask'],6,4) )) {
            $query->where("A.date_created <= ?", $_GET['date_created_po_mask']);
        }
    }
}

$queryC = $db->select();
$queryC->from('orders_monitoring__events AS A', 'COUNT(A.id)');
$queryC->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);
//$queryC->where($this->getWhere());
$totalRows = $db->fetchOne($queryC);

//$firstRowIndex = $curPage * $rowsPerPage - $rowsPerPage;


$query->order($sortingField.' '.$sortingOrder);
$query->limitPage($curPage, $rowsPerPage);

//сохраняем номер текущей страницы, общее количество страниц и общее количество записей
$response->page = $curPage;
$response->total = ceil($totalRows / $rowsPerPage);
$response->records = $totalRows;

$i=0;
foreach ($db->fetchAll($query) as $key => $event) {
    $event['action'] = "test";
    $et = new AK_Order_Monitoring_Event_Type($event['event_type_id']);
    $ev = new AK_Order_Monitoring_Event($key);
    $add='';
    if (!$ev->isViewed()) {
        $add = "font-weight:bold;";
    }
    $response->rows[$i]['id']=$key;
    $response->rows[$i]['cell']=array($i, $event['kontragent_title'],
        $event['inn'],
        $event['region'],
        $event['country'],
        $event['action'],
        date('d-m-Y', $event['event_date']),
        '<b><font color="'.$et->getColor().'">'.$event['event_type'].'</font></b>',
        '<a href="/monitoring/event/'.$event['id'].'/" style="color:blue; text-decoration:underline;'.$add.'">'.$event['content'].'</a>',
        date('d-m-Y', $event['date_created']));
    $i++;
}

echo Zend_Json::encode($response);
exit;
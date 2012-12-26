<?php

//colNames:['Контрагент', 'ИНН', 'Регион', 'Страна', 'Дата события', 'Тема события', 'Информация', 'Дата добавления'],
//http://www.trirand.com/blog/jqgrid/jqgrid.html
//читаем параметры
$curPage = $_POST['page'];
$rowsPerPage = $_POST['rows'];
$sortingField = $_POST['sidx'];
$sortingOrder = $_POST['sord'];
//$this->_user = new AK_Order_User('id', 1);

$ttList = new AK_Order_Monitoring_Event_Type_List();
        $this->view->ttList = $ttList->getList();

$db = Zend_Registry::get('DBORDER');
$query = $db->select();
$query->from('orders_monitoring__demoevents AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
$query->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
$query->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));

//$query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);

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
}
else {

    if (!empty($_GET['kontragent_title_mask'])) {
        $query->where("B.title LIKE ?", $_GET['kontragent_title_mask'].'%');
    }

    if (!empty($_GET['inn_mask'])) {
        $query->where("B.inn LIKE ?", $_GET['inn_mask'].'%');
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
$queryC->from('orders_monitoring__demoevents AS A', 'COUNT(A.id)');
//$queryC->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);
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
foreach ($db->fetchAll($query) as $event) {
    $et = new AK_Order_Monitoring_Event_Type($event['event_type_id']);
    $ev = new AK_Order_Monitoring_Event($event['id']);
    $add='';
    if (!$ev->isViewed()) {
        $add = "font-weight:bold;";
    }
	$date_rand = rand(1,7);
	$date_rand_add = ($date_rand-rand(0,$date_rand))*86400;
	$date_rand = $date_rand*86400;
    $response->rows[$i]['id']=$event['id'];
    $response->rows[$i]['cell']=array(  $event['kontragent_title'],
        $event['inn'],
        $event['region'],
        $event['country'],
        date('d-m-Y', (mktime() - $date_rand)),
        '<b><font color="'.$et->getColor().'">'.$event['event_type'].'</font></b>',
        '<a href="/monitoring/eventdemo/'.$event['id'].'/" style="color:blue; text-decoration:underline;'.$add.'">'.$event['content'].'</a>',
        date('d-m-Y', (mktime() - $date_rand_add)));
    $i++;
}
echo Zend_Json::encode($response);
exit;

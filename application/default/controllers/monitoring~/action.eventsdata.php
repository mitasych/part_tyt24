<?php

//colNames:['Контрагент', 'ИНН', 'Регион', 'Страна', 'Дата события', 'Тема события', 'Информация', 'Дата добавления'],
//http://www.trirand.com/blog/jqgrid/jqgrid.html
//читаем параметры
$curPage = $_POST['page'];
$rowsPerPage = $_POST['rows'];
$sortingField = $_POST['sidx'];
$sortingOrder = $_POST['sord'];


$db = Zend_Registry::get('DBORDER');
$query = $db->select();
$query->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
$query->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
$query->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type'));

$query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);


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

if (!empty($_GET['event_type_mask'])) {
    $query->where("C.title LIKE ?", $_GET['event_type_mask'].'%');
}

if (!empty($_GET['content_mask'])) {
    $query->where("A.content LIKE ?", '%'.$_GET['content_mask'].'%');
}

if (!empty($_GET['date_created_mask'])) {
    if ($_GET['date_created_mask'] = mktime(0,0,0, substr($_GET['date_created_mask'],3,2), substr($_GET['date_created_mask'],0,2), substr($_GET['date_created_mask'],6,4) )) {
        $query->where("A.date_created >= ?", $_GET['date_created_mask']);
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
foreach ($db->fetchAll($query) as $event) {

    $ev = new AK_Order_Monitoring_Event($event['id']);
    $add='';
    if (!$ev->isViewed()) {
        $add = "font-weight:bold;";
    }
    $response->rows[$i]['id']=$event['id'];
    $response->rows[$i]['cell']=array(  $event['kontragent_title'],
        $event['inn'],
        $event['region'],
        $event['country'],
        date('d-m-Y', $event['event_date']),
        $event['event_type'],
        '<a href="/monitoring/event/'.$event['id'].'/" style="color:blue; text-decoration:underline;'.$add.'">'.$event['content'].'</a>',
        date('d-m-Y', $event['date_created']));
    $i++;
}
echo Zend_Json::encode($response);
exit;

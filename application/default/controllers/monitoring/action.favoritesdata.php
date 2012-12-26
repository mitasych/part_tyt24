<?php


// if($this->_user->getLastEventCount>0){
//     $this->_redirect('/monitoring/events/filter/new/')
// }

//colNames:['Контрагент', 'ИНН', 'Регион', 'Страна', 'Дата события', 'Тема события', 'Информация', 'Дата добавления'],
//http://www.trirand.com/blog/jqgrid/jqgrid.html
//читаем параметры
$curPage = $_POST['page'];
$rowsPerPage = $_POST['rows'];
$sortingField = $_POST['sidx'];
$sortingOrder = $_POST['sord'];

$ttList = new AK_Order_Monitoring_Event_Type_List();
        $this->view->ttList = $ttList->getList();

$db = Zend_Registry::get('DBORDER');
$query = $db->select();
$query->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
$query->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
$query->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));

$query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);
$query->where('A.favorites = 1');
if (!empty($_GET['group']) && in_array($_GET['group'], array('all', 'year', 'month', 'week', 'new'))) {
    switch ($_GET['group']){
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

    if (!empty($_GET['kontragent_title_mask'])) {
        $query->where("B.title LIKE ?", $_GET['kontragent_title_mask'].'%');
    }
    if (!empty($_GET['content_mask'])) {
        $query->where("A.content LIKE ?", '%'.$_GET['content_mask'].'%');
    }
	
	    if (!empty($_GET['inn_mask'])) {
        $query->where("B.inn LIKE ?", $_GET['inn_mask'].'%');
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
	if (!empty($_GET['country_mask'])) {
        $query->where("B.country LIKE ?", $_GET['country_mask'].'%');
    }
    if (!empty($_GET['region_mask'])) {
        $query->where("B.region LIKE ?", $_GET['region_mask'].'%');
    }
/*
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
*/
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
//secho $query->__toString();
//print_r($db);
foreach ($db->fetchAll($query) as $event) {

    $et = new AK_Order_Monitoring_Event_Type($event['event_type_id']);
    $ev = new AK_Order_Monitoring_Event($event['id']);
    if ($ev->favorites == 1){
                        $favorites = '<span id="f_'.$ev->id.'" class="favorites-star"  onClick="favor(0,'.$ev->id.')" onmouseover="$(\'#info_favor\').show();"onmouseout="$(\'#info_favor\').hide();"></span>';
        } else {
            $favorites = '<span id="f_'.$ev->id.'" class="favorites-star" onClick="favor(1,'.$ev->id.')" ></span>';
        }

        if ($event['country'] == 'RU'){
        $event['country'] .=" <img src='/images/258.gif'>";
    }

    if ($event['country'] == 'UA')
     {
        $event['country'] .=" <img src='/images/252.gif'>";
    }

    $add='';
        //     print_r ($ev->isViewed());
        // exit();
    if (!$ev->isViewed()) {
        $add = "font-weight:900;";


    } else {  $add = ""; }
    $response->rows[$i]['id']=$event['id'];
    $response->rows[$i]['cell']=array(  $favorites,


        '<a class="descriptionCompany" value="'.$event['id'].'" target="_blank" href="/monitoring/eventc/'.$ev->kontragentId.'/" style="color: #1F5863;  cursor: pointer;'.$add.'">'.$event['kontragent_title'].'</a>', 
		


        "<font  style='color: #1F5863;  cursor: pointer;".$add."'>".$event['inn']."</font>",
       
        "<font  style='color: #1F5863;  cursor: pointer;".$add."'>".$event['region']."</font>",
       "<font  style='color: #1F5863;  cursor: pointer;".$add."'>".$event['country']."</font>",

        "<font  style='color: #1F5863;  cursor: pointer;".$add."'>".date('d.m.Y', $event['event_date'])."</font>",
               '<a class="description" value="'.$event['id'].'" href="/monitoring/event/'.$event['id'].'/" style="color: #1F5863;  cursor: pointer;'.$add.'">'.$event['content'].'</a>',
        '<b><font color="'.$et->getColor().'">'.$event['event_type'].'</font></b>');
    $i++;
}

echo Zend_Json::encode($response);
exit;

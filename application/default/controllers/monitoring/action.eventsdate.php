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
if(isset($_GET['q']) && isset($_GET['id'])){
    $id_konragent = $_GET['id'];

$curPage = $_GET['page'];
$rowsPerPage = $_GET['rows'];
$sortingField = $_GET['sidx'];
$sortingOrder = $_GET['sord'];

$query = $db->select();
$query->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
$query->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
$query->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));

 $query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);

$query->where('A.date_created =?',$id_konragent);


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
 
 if (!empty($_GET['favorites'])) {
    $query->where("A.favorites =?", $_GET['favorites']);
    // print_r($queryCompany->__toString());
    }

$i=0;
$query->order($sortingField.' '.$sortingOrder);
 $query->limitPage($curPage, $rowsPerPage);

//сохраняем номер текущей страницы, общее количество страниц и общее количество записей
$response->page = $curPage;
$response->total = ceil($totalRows / $rowsPerPage);
$response->records = $totalRows;

foreach ($db->fetchAll($query) as $event) {
    $et = new AK_Order_Monitoring_Event_Type($event['event_type_id']);
    $ev = new AK_Order_Monitoring_Event($event['id']);

     if ($ev->favorites == 1){
                       $favorites = '<img id="f_'.$ev->id.'" onClick="favor(0,'.$ev->id.')" src="/img/star_event.png"  onmouseover="$(\'#info_favor\').show();"
             onmouseout="$(\'#info_favor\').hide();">';
        } else {
            $favorites = '<img id="f_'.$ev->id.'"  onClick="favor(1,'.$ev->id.')" src="/img/star_noevent.png"  onmouseover="$(\'#info_favor1\').show();"
             onmouseout="$(\'#info_favor1\').hide();">';
        }

    if ($event['country'] == 'RU'){
        $event['country'] .=" <img src='/images/258.gif'>";
    }

    if ($event['country'] == 'UA')
     {
        $event['country'] .=" <img src='/images/252.gif'>";
    }
    $add='';

    if (!$ev->isViewed()) {
        $add = "font-weight:900;";


    } else {  $add = ""; }
    $response->rows[$i]['id']=$event['id'];
    $response->rows[$i]['cell']=array(  
        $favorites,
        '<a class="descriptionCompany" value="'.$event['id'].'" target="_blank" href="/monitoring/eventc/'.$ev->kontragentId.'/" style="color: #1F5863;  cursor: pointer;'.$add.'">'.$event['kontragent_title'].'</a>',         
        "<font  style='color: #1F5863;  cursor: pointer;".$add."'>".$event['inn']."</font>",       
        "<font  style='color: #1F5863;  cursor: pointer;".$add."'>".$event['region']."</font>",
        "<font  style='color: #1F5863;  cursor: pointer;".$add."'>".$event['country']."</font>",
        "<font  style='color: #1F5863;  cursor: pointer;".$add."'>".date('d.m.Y', $event['event_date'])."</font>",
        '<b><font color="'.$et->getColor().'">'.$event['event_type'].'</font></b>',
        '<a class="description" value="'.$event['id'].'" href="/monitoring/event/'.$event['id'].'/" style="color: #1F5863;  cursor: pointer;'.$add.'">'.$event['content'].'</a>');
    $i++;
}
echo Zend_Json::encode($response);
exit();
}


$queryCompany = $db->select();
$queryCompany->from('orders_kontragents AS A');
$queryCompany->join('orders_monitoring__events AS C', 'A.id = C.kontragent_id');

$queryCompany->where('A.id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);
$queryC = $db->select();
$queryC->from('orders_monitoring__events AS A', 'COUNT(A.id)');
$queryC->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);
$totalRows = $db->fetchOne($queryC);
if (!empty($_GET['group']) && in_array($_GET['group'], array('all', 'year', 'month', 'week', 'new'))) {
    switch ($_GET['group']){
        case 'all':
            break;
        case 'year':
            $queryCompany->where('C.date_created >=?', time()-60*60*24*365);
            break;
        case 'month':
            $queryCompany->where('C.date_created >=?', time()-60*60*24*30);
            break;
        case 'week':
            $queryCompany->where('C.date_created >=?', time()-60*60*24*7);
            break;
        case 'new':
            $queryCompany->where('C.id NOT IN (SELECT event_id FROM orders_monitoring__events_views WHERE user_id = ?)', $this->_user->id);
            break;
    }
}
  if (!empty($_GET['country_mask'])) {
        $queryCompany->where("A.country LIKE ?", $_GET['country_mask'].'%');
    }

    if (!empty($_GET['content_mask'])) {
        $queryCompany->where("C.content LIKE ?", '%'.$_GET['content_mask'].'%');

    }

    if (!empty($_GET['event_type_mask'])) {
            $a =explode('-',$_GET['event_type_mask']);
        $queryCompany->Where("C.type_id = {$a[0]} OR C.type_id = {$a[1]} OR C.type_id = {$a[2]}");
    }

    if (!empty($_GET['favorites'])) {
    $queryCompany->where("C.favorites =?", $_GET['favorites']);
    }

        if (!empty($_GET['event_date_mask'])) {
        if ($_GET['event_date_mask'] = mktime(0,0,0, substr($_GET['event_date_mask'],3,2), substr($_GET['event_date_mask'],0,2), substr($_GET['event_date_mask'],6,4) )) {
           
            $queryCompany->where("C.date_created >= ?", $_GET['event_date_mask']);
        }
    }
 
     if (!empty($_GET['event_date_po_mask']))
        if ($_GET['event_date_po_mask'] = mktime(0,0,0, substr($_GET['event_date_po_mask'],3,2), substr($_GET['event_date_po_mask'],0,2), substr($_GET['event_date_po_mask'],6,4) )) {
            $queryCompany->where("C.date_created <= ?", $_GET['event_date_po_mask']);
        } 
 $queryCompany->order($sortingField.' '.$sortingOrder);
 $queryCompany->limitPage($curPage, $rowsPerPage);

//сохраняем номер текущей страницы, общее количество страниц и общее количество записей
$response1->page = $curPage;
$response1->total = ceil($totalRows / $rowsPerPage);
$response1->records = $totalRows;


$n = 0;

foreach ($db->fetchAll($queryCompany) as $Company1) {
    $kontr = $Company1['date_created'];
    $titleCompany[$kontr] = $Company1['title'];
    $countContr[$kontr]['date_created']= $countContr[$kontr]['date_created'] + 1;
  //      $countContr[$kontr]['date_created']= $countContr[$kontr]['date_created'] + 1;
     
  


}
// print_r($countContr);
// exit();
$i=0;
foreach ($countContr as $key => $value) {

    $response1->rows[$i]['id']=$key;
    $response1->rows[$i]['cell']=array(   
        '<b><font  style="color: #1F5863;">'.date('d.m.Y', $key).'</font></b>',

        "<b><font  style='color: #1F5863;  cursor: pointer;'>".$value['date_created']."</font></b>",
        
      );
    $i++;
}


echo Zend_Json::encode($response1);
exit();

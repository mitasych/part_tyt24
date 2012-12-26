<?php

// print_r($_POST);
// exit();

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

 //$query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);

$query->where('A.kontragent_id =?',$id_konragent);

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
    }
        // if (!empty($_GET['content_mask']) && ($_GET['content_mask']!='undefined') ) {
        //   print_r("expression");
        // }


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
                       $favorites = '<img id="f_'.$ev->id.'" onClick="$(\'infor\').hide(); favor(0,'.$ev->id.')" src="/img/star_event.png"  onmouseover="$(\'#info_favor\').show();"
             onmouseout="$(\'#info_favor\').hide();">';
        } else {
            $favorites = '<img id="f_'.$ev->id.'"  onClick="$(\'infor\').hide(); favor(1,'.$ev->id.');" src="/img/star_noevent.png"  onmouseover="$(\'#info_favor1\').show();"
             onmouseout="$(\'#info_favor1\').hide();">';
        }

    $add='';

    if (!$ev->isViewed()) {
        $add = "font-weight:900;";


    } else {  $add = ""; }
    $response->rows[$i]['id']=$event['id'];
    $response->rows[$i]['cell']=array(  $favorites,
        "<font  style='color: #1F5863;  cursor: pointer;".$add."'>".date('d.m.Y', $event['event_date'])."</font>",        
        '<b><font color="'.$et->getColor().'">'.$event['event_type'].'</font></b>',
        '<a class="description" value="'.$event['id'].'" href="/monitoring/event/'.$event['id'].'/" style="color: #1F5863;  cursor: pointer;'.$add.'">'.$event['content'].'</a>');
    $i++;
}
//print_r($response);
echo Zend_Json::encode($response);
exit();
}





$queryCompany = $db->select();
$queryCompany->from('orders_kontragents AS A');
$queryCompany->join('orders_monitoring__events AS C', 'A.id = C.kontragent_id');





$queryC = $db->select();
$queryC->from('orders_monitoring__events AS A', 'COUNT(A.id)');
$queryC->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);
//$queryC->where($this->getWhere());
$totalRows = $db->fetchOne($queryC);

$queryCompany->joinLeft('orders_kontragents AS B', 'C.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
$queryCompany->where('A.id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);

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
        $queryCompany->where("B.country LIKE ?", $_GET['country_mask'].'%');
    }


  if (!empty($_GET['search_innnaim_mask'])) {
        $queryCompany->where("(B.title LIKE ? OR B.inn LIKE ?)", $_GET['search_innnaim_mask'].'%');
    }

    if (!empty($_GET['kontragent_title_mask']) && ($_GET['kontragent_title_mask']!='undefined')) {
        $queryCompany->where("B.title LIKE ?", $_GET['kontragent_title_mask'].'%');
    }

  
  if (!empty($_GET['inn_mask']) && ($_GET['inn_mask']!='undefined') ) {
        $queryCompany->where("B.inn LIKE ?", $_GET['inn_mask'].'%');
    }

        if  ($_GET['fav_com']=="checked") {

        $queryCompany->where('A.id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE orders_users__kontragents.favorites LIKE "1" and user_id = ?)', $this->_user->id);

    }
    if (!empty($_GET['favorites'])) {
    $queryCompany->where("C.favorites =?", $_GET['favorites']);
   
    }
 


    if (!empty($_GET['region_mask']) && ($_GET['region_mask']!='undefined') ) {
        $queryCompany->where("B.region LIKE ?", $_GET['region_mask'].'%');
    }

        if (!empty($_GET['content_mask']) && ($_GET['content_mask']!='undefined') ) {

        $queryCompany->where("C.content LIKE ?", '%'.$_GET['content_mask'].'%');

    }

 $queryCompany->order($sortingField.' '.$sortingOrder);
 $queryCompany->limitPage($curPage, $rowsPerPage);

//сохраняем номер текущей страницы, общее количество страниц и общее количество записей
$response1->page = $curPage;
$response1->total = ceil($totalRows / $rowsPerPage);
$response1->records = $totalRows;


 //print_r($db->fetchAll($queryCompany));exit();
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

$i=0;
foreach ($countContr as $key => $value) {


        $item = new AK_Order_User_Kontragent(null, $key);
              
              $le = $item->getKontragent()->getLastEvent();
              $lastDate = date('d.m.Y', $le[0]["event_date"]);
              $lastTypeEvent =    new AK_Order_Monitoring_Event_Type($le[0]['type_id']);
 
          if ($item->favorites == 1){
            $favoritesCompany = '<span title="В избранном" style="display:block" class="favorites-star" id="f_'.$item->id.'" onClick="$(\'#infor\').hide(); favorCompany(0,'.$item->id.')" onmouseover="$(\'#info_favor\').show();"
            onmouseout="$(\'#info_favor\').hide();"><span>';
    } else {
            $favoritesCompany = '<span title="В избранное" style="display:block" class="nofavorites-star" id="f_'.$item->id.'"  onClick="$(\'#infor\').hide(); favorCompany(1,'.$item->id.')"  onmouseover="$(\'#info_favor1\').show();"
             onmouseout="$(\'#info_favor1\').hide();"><span>';


        }


        if ($value['country'] == 'RU'){
        $value['country'] .=" <img src='/images/258.gif'>";
    }

    if ($value['country'] == 'UA')
     {
        $value['country'] .=" <img src='/images/252.gif'>";
    }

    
    $response1->rows[$i]['id']=$key;
    $response1->rows[$i]['cell']=array(  $favoritesCompany   ,
        '<b><a class="descriptionCompany" value="'.$key.'" target="_blank" href="/monitoring/eventc/'.$key.'/" style="color: #1F5863;  cursor: pointer;">'. $item->getKontragent()->title.'</a></b>',
         "<b><font  style='color: #1F5863;  cursor: pointer;'>".$value['inn'].'</font></b>',
         "<b><font  style='color: #1F5863;  cursor: pointer;'>".$value['region'].'</font></b>',
         "<b><font  style='color: #1F5863;  cursor: pointer;'>".$value['country'].'</font></b>',
          "<b><font  style='color: #1F5863;  cursor: pointer;'>".$value['count']."</font></b>",
          "<b><font  style='color: #1F5863;  cursor: pointer;'>".$item->getKontragent()->adress."</font></b>",
         "<b><font  style='color: #1F5863;  cursor: pointer;'>".$item->getKontragent()->rykov."</font></b>",
         "<b><font  style='color: #1F5863;  cursor: pointer;'>".$item->getKontragent()->reg_date.'</font></b>',
         "<b><font  style='color: #1F5863;  cursor: pointer;'>".$item->getKontragent()->otrasl.'</font></b>',
         "<b><font  style='color: #1F5863;  cursor: pointer;'>".$lastDate.'</font></b>'.'<br><b><font color="'.$lastTypeEvent->getColor().'">'.$lastTypeEvent->title.'</font></b>',
         '<b><font  style="color: #1F5863;  cursor: pointer;"><a href="/reports/index/cargoname2/'.$item->getKontragent()->inn.'/cargoname/'.$item->getKontragent()->title.'">
        <img src="/images/doc.png" title="Заказать отчет" /></a>
      
        <a onClick="$(\'#formEdit\').show(); $(\'#hid_id\').val('.$item->id.');
        $(\'#inn_ed\').val(\''.$item->getKontragent()->inn.'\');
        $(\'#name_ed\').val(\''.$item->title.'\'); 
        $(\'#reg_ed\').val(\''.$item->getKontragent()->region.'\');

        return false;" href="#" data='.$item->id.'><img src="/images/edit.png" title="Редактировать" /></a>
        <a href="/monitoring/eventscompany/did/'.$item->id.'/" data='.$item->id.'
        onClick="return confirmDelete()"><img src="/images/delete_company.png" title="Удалить" /></a></font></b>
        '
       
      
      );
    $i++;
}


echo Zend_Json::encode($response1);
exit;

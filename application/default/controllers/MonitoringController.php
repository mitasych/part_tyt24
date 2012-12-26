<?php

/**
 * CSV_Writer
 * класс для создания CSV файлов
 */
class CSV_Writer {

    /**
     * @var array
     * Массив данных
     */
    public $data = array();
    public $deliminator;

    function __construct($data, $deliminator = ";") {
        if (!is_array($data)) {
            throw new Exception('CSV_Writer only accepts data as arrays');
        }

        $this->data = $data;
        $this->deliminator = $deliminator;
    }

    private function wrap_with_quotes($data) {
        $data = preg_replace('/"(.+)"/', '""$1""', $data);
        return sprintf('"%s"', $data);
    }

    public function output() {
        foreach ($this->data as $row) {
            $quoted_data = array_map(array('CSV_Writer', 'wrap_with_quotes'), $row);
            echo sprintf("%s\n", implode($this->deliminator, $quoted_data));
        }
    }

    public function headers($name) {
        header("Content-Type: text/html; charset=cp1251");
        header('Content-Type: application/csv');
        header("Content-disposition: attachment; filename={$name}.csv");
    }

}

class Option {

    public $number;
    public $text;

}

class MonitoringController extends AK_Controller_Action {

    public $typeIdPost;
    public $tarifIdPost;
    public $currentUser;
    public $params;

    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);

        $settings = new AK_Order_Settings();
        $ban = $settings->get('bannermonitoring');
        if (!empty($ban) && file_exists(DOCUMENT_ROOT . '/uploaded/sa/' . $ban)) {
            $this->view->banner = '/uploaded/sa/' . $ban;
        }

        if (defined('DISABLE_MONITORING') && DISABLE_MONITORING && ACTION_NAME != 'disabled') {
            $this->_redirect('/monitoring/disabled/');
        }

        $this->params = $this->_getAllParams();
        $this->currentUser = $this->_user;
        $this->view->currentUser = $this->currentUser;

        if (!$this->currentUser->getLogin()) {
            $this->_redirect(SITE_URL);
        }

        if ($this->currentUser->blockMonitoring && ACTION_NAME != 'blocked') {
            $this->_redirect('/monitoring/blocked/');
        }

        if ($this->_user->mon_demo)
            if ($this->_user->end_mon_demo < mktime()) {
                $this->_user->mon_demo = 0;
                $this->_user->save();
            }

        if (!$this->_user->dogovorCreated && $this->_user->mon_demo && ACTION_NAME == 'events') {
            $this->_redirect('/monitoring/eventsdemo/');
        }
        if (!$this->_user->dogovorCreated && $this->_user->mon_demo && ACTION_NAME == 'calendar') {
            $this->_redirect('/monitoring/calendardemo/');
        }

        if (ACTION_NAME != 'eventsdemo' && ACTION_NAME != 'eventsdatademo' && ACTION_NAME != 'calendardemo' && ACTION_NAME != 'datafeeddemo') {
            if (!$this->_user->dogovorCreated && ACTION_NAME != 'notapproved' && ACTION_NAME != 'notarif' && ACTION_NAME != 'disabled') {
                $this->_redirect('/monitoring/notapproved/');
            }
            if (null === $this->_user->getTarifInfo() && ACTION_NAME != 'notarif' && ACTION_NAME != 'notapproved' && ACTION_NAME != 'disabled') {
                $this->_redirect('/monitoring/notarif/');
            }
        }
    }

    public function blockedAction() {
        
    }

    public function gettarifAction() {
        //	echo $this->params['id'];

        $allUserTarifs = new AK_Order_User_Tarif_List();
        $allUserTarifs->addWhere('A.tarif_id = ' . $this->params['id']);
        $tarif = $allUserTarifs->getList();
        $tarif = $tarif[0];
        $wiew = array();
        $wiew['id'] = $tarif->tarifId;
        $wiew['startDate'] = date('d-m-Y', $tarif->startDate);
        $wiew['endDateUser'] = date('d-m-Y', $tarif->endDateUser);
        $wiew['endDateKurator'] = date('d-m-Y', $tarif->endDateKurator);
        /* $dateNextMon = $tarif->dateNextMon+$tarif->period*86400;
          $wiew['dateNextMon']=($dateNextMon < $tarif->endDateUser)?(( date('w', $dateNextMon) == 6 or date('w', $dateNextMon) == 0)? date('d-m-Y*',($dateNextMon)):date('d-m-Y',($dateNextMon))): ('-');
          $wiew['dateEndMon']=date('d-m-Y', $tarif->dateNextMon); */
        $wiew['dateNextMon'] = $tarif->dateNextMon == '-' ? $tarif->dateNextMon : (( date('w', $tarif->dateNextMon) == 6 or date('w', $tarif->dateNextMon) == 0) ? date('d-m-Y*', ($tarif->dateNextMon)) : date('d-m-Y', ($tarif->dateNextMon)));
        $wiew['dateEndMon'] = date('d-m-Y', $tarif->dateEndMon);
        $wiew['m'] = $tarif->m;
        $wiew['period'] = $tarif->period;
        $wiew['country'] = $tarif->getCountry();
        //$wiew['countryName']=$tarif->getCountry();
        if ($tarif->getCountry() == 258) {
            $wiew['countryName'] = "Россия";
        } else {
            $wiew['countryName'] = "Украина";
        }
        $count_event = AK_Order_Monitoring_Event::countEventsOnLastMon($tarif->dateEndMon, $wiew['id']);
        $wiew['count_event'] = $count_event;
        $wiew['count'] = $tarif->count;
        $wiew['price'] = (int) $tarif->count * (int) $tarif->price_one;
        $wiew['all_id'] = $tarif->all_id;
        $wiew['price_one'] = $tarif->price_one;
        $wiew['country'] = $tarif->country;
        $wiew['type_tarif'] = $tarif->getTarifAll()->type2;
        $wiew['info'] = $tarif->getTarifAll()->about;

        if ($tarif->getLastEvent()->getEventDateFormatted() == '01.01.1970') {

            $wiew['dateendevent'] = 'События нет!';
        } else
            $wiew['dateendevent'] = '<a href="/monitoring/event/' . $tarif->getLastEvent()->id . '/">' . $tarif->getLastEvent()->getEventDateFormatted() . '(' . $tarif->getLastEvent()->getType()->title . ')</a>';

        $wiew['events'] = array();
        $wiew['count_kontr'] = $allUserTarifs->getCountKontragents($this->_user->id, $tarif->tarifId);
        $ev = new AK_Order_Monitoring_Event_Type_List();
        foreach ($ev->getList() as $evn)

            if ($tarif->getTarifAll()->getEventType($evn->id)) {
                $wiew['events'][$evn->id] = $evn->title . '(' . $tarif->getEventCount($evn->id) . ')';
                $wiew['eventstype'][$evn->id] = $evn->id;
            }
        $wiew['event'] = implode(', ', $wiew['events']);
        if ($tarif->endDateUser < time()) {
            $wiew['active'] = 1;
        } else
            $wiew['active'] = 0;
        echo json_encode($wiew);
        die();
    }

    public function gettarifInfoAction() {
        echo $this->params['id'];
        $allUserTarifs = new AK_Order_User_Tarif_List();
        $allUserTarifs->addWhere('A.tarif_id = 86');
        $tarif = $allUserTarifs->getList();
        $tarif = $tarif[0];
        $wiew = array();
        $wiew['id'] = 1; //$tarif->tarifId;
        $wiew['startDate'] = //date('d-m-Y', $tarif->startDate);
                $wiew['endDateUser'] = 34; //date('d-m-Y', $tarif->endDateUser);
        $wiew['endDateKurator'] = 23; //date('d-m-Y', $tarif->endDateKurator);
        /* $dateNextMon = $tarif->dateNextMon+$tarif->period*86400;
          $wiew['dateNextMon']=($dateNextMon < $tarif->endDateUser)?(( date('w', $dateNextMon) == 6 or date('w', $dateNextMon) == 0)? date('d-m-Y*',($dateNextMon)):date('d-m-Y',($dateNextMon))): ('-');
          $wiew['dateEndMon']=date('d-m-Y', $tarif->dateNextMon); */
        $wiew['dateNextMon'] = 23; //$tarif->dateNextMon=='-'?$tarif->dateNextMon:(( date('w', $tarif->dateNextMon) == 6 or date('w', $tarif->dateNextMon) == 0)? date('d-m-Y*',($tarif->dateNextMon)):date('d-m-Y',($tarif->dateNextMon)));
        $wiew['dateEndMon'] = 33; //date('d-m-Y', $tarif->dateEndMon);
        $wiew['m'] = $tarif->m;
        $wiew['period'] = 33;
        $wiew['count'] = 45;
        $wiew['price'] = 33;
        $wiew['all_id'] = 56;
        $wiew['price_one'] = 56;
        $wiew['country'] = 44;
        $wiew['type_tarif'] = 54;
        $wiew['info'] = 332;
        //$wiew['dateendevent']=($tarif->getLastEvent()->getEventDateFormatted() == '01-01-1970')?null:'<a href="/monitoring/event/'.$tarif->getLastEvent()->id.'/">'.$tarif->getLastEvent()->getEventDateFormatted().'('.$tarif->getLastEvent()->getType()->title.')</a>';
        $wiew['dateendevent'] = 3;
        $wiew['events'] = array();
        $wiew['count_kontr'] = 45;
        // $ev = new AK_Order_Monitoring_Event_Type_List();
        // foreach ($ev->getList() as $evn)
        // 	if ($tarif->getTarifAll()->getEventType($evn->id))
        // 	{
        // 		$wiew['events'][$evn->id] = $evn->title.'('.$tarif->getEventCount($evn->id).')';
        // 	}
        $wiew['event'] = 22;
        echo json_encode($wiew);

        die();
    }

    public function gettarifdateAction() {
        //echo $this->params['id']; orders_users__monitoring_tarifs
        /* $allUserTarifs  = new AK_Order_User_Tarif_List();
          $allUserTarifs->setOrder('date_next_mon');
          $tarif = $allUserTarifs->getList();
          $tarif = $tarif[0]; */
        $wiew = array();
        $db = Zend_Registry::get('DBORDER');
        $query = $db->select()->distinct()->from(array('A' => 'orders_users__monitoring_tarifs'), 'A.date_next_mon')->where('user_id = ' . $this->_user->id)->order('A.date_next_mon DESC');
        if ($_POST['id'] > 0) {
            $query->joinInner(array('B' => 'orders_monitoring__tarif_all'), 'B.id = A.all_id', null);
            $query->where('B.type = ?', $_POST['id']);
        }
        $list = $db->fetchAll($query);
        $wiew['mon'] = $list[0];
        $db = Zend_Registry::get('DBORDER');
        $query = $db->select()->from(array('A' => 'orders_monitoring__events'))->joinInner(array('B' => 'orders_users__kontragents'), 'A.kontragent_id = B.kontragent_id', null)->joinInner(array('C' => 'orders_users__monitoring_tarifs'), 'C.tarif_id = B.tarif_id', null);
        $query->where('C.user_id = ' . $this->_user->id);
        $query->where('C.date_next_mon > A.event_date ');
        if ($_POST['id'] > 0) {
            $query->joinInner(array('D' => 'orders_monitoring__tarif_all'), 'D.id = C.all_id', null);
            $query->where('D.type = ?', $_POST['id']);
        }
        $query->order('A.event_date DESC');
        $list = $db->fetchAll($query);
        if (!empty($list[0])) {
            $wiew['event'] = $list[0];
            $t = new AK_Order_Monitoring_Event_Type($wiew['event']['type_id']);
        }
        $str = ' ' . date('d-m-Y', $wiew['mon']['date_next_mon']);
        if (!empty($wiew['event']))
            $str .= ' / <a href="/monitoring/event/' . $wiew['event']['id'] . '/" style="color:#da114b;">' . date('d-m-Y', $wiew['event']['event_date']) . ' (' . $t->title . ')</a>';
        print $str;
        die();
    }

    public function indexAction() {
        $evType = new AK_Order_Monitoring_Event_Type_List();
        $evType = $evType->getList();
        //	 print_r($evType);
        $this->view->evType = $evType;

        $ttList = new AK_Order_Monitoring_Event_Type_List();

        $allUserTarifs = new AK_Order_User_Tarif_List();
        $list_tarifs = $allUserTarifs->getAllTarifs($_SESSION["user_id"]);
        //	print_r($list_tarifs);exit();
        // достаем все тарифы юзера и сохраняем текущий 
        $this->view->userTarifs = $allUserTarifs->getAllTarifs($this->_user->id);
        $this->view->idt = empty($this->params['idt']) ? '0' : $this->params['idt'];


        // Zend_Debug::dump($this->view->showAll);exit();	

        if ($this->view->showAll != 1)
            $this->view->current_user_tarif = $this->_user->getTarifById(64);
        else
            $this->view->current_user_tarif = $this->_user->getTarifById(64);
        //Zend_Debug::dump($this->view->current_user_tarif->count); exit();			

        $this->view->showAll = 1;
        //Zend_Debug::dump($_SESSION['current_mon_tarif']); exit();		
        $db = Zend_Registry::get('DBORDER');
        $queryEveCountry = $db->select();
        $queryEveCountry->from('orders_monitoring__eventType_connect_country');
        $EveCountry = $db->fetchAll($queryEveCountry);

        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.country')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.country <> "" AND A.country IS NOT NULL')->order('A.country');
        $this->view->cList = $db->fetchCol($query);

        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.region')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.region <> "" AND A.region IS NOT NULL')->order('A.region');
        $this->view->rList = $db->fetchAll($query);

        $this->view->eveCountry = $EveCountry;

        $queryCal = $db->select();
        $queryCal->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
        $queryCal->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
        $queryCal->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));

        $queryCal->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);

        $this->view->CalendarData = $db->fetchAll($queryCal);

        foreach ($db->fetchAll($queryCal) as $event) {
            if ($event['id'] == $event['id']) {
                $eventsdata[$event['event_type_id']][$event['country']] = $eventsdata[$event['event_type_id']][$event['country']] + 1;
            }
            if ($event['country'] == 'RU') {
                $events_all['RU_ev_all'] = $events_all['RU_ev_all'] + 1;
            }
            if ($event['country'] == 'UA') {
                $events_all['UA_ev_all'] = $events_all['UA_ev_all'] + 1;
            }
        }
        $eventsdata[0] = $events_all;

        $this->view->eventsdata = $eventsdata;

        $twxt2 = new AK_Article_Item();
        $twxt2->loadByRewriteName('changeTarif');
        $this->view->change_tarif_info = strip_tags($twxt2->getContent());

        $this->view->ttList = $ttList->getList();

        if (isset($_SESSION['tarif_checked']))
            unset($_SESSION['tarif_checked']); // удаляем выбранные тарифы 

        include_once('monitoring/action.index.php');
    }

    public function eventscompanyAction() {


        if (!empty($this->params['did'])) {
            $uk = new AK_Order_User_Kontragent($this->params['did']);
            if (!empty($uk->id) && $uk->userId == $this->_user->id) {
                $uk->delete();
                $this->_redirect('/monitoring/eventscompany');
            }
        }

        if (isset($_POST['hid_id'])) {

            $db = Zend_Registry::get("DBORDER");
            if ($_POST['copy'] == true) {
                $uk = new AK_Order_User_Kontragent();
            } else {
                $uk = new AK_Order_User_Kontragent($_POST['hid_id']);
            }



            $id_k = $uk->getKontragent()->id;
            $vuk = new AK_Order_User_Tarif();
            $tarifId = $vuk->getTarifId($_POST['k_id']);
            $auk = new AK_Order_Kontragent('id', $id_k);
            //    if (!$form->isPostback()) {
            $auk->inn = $_POST['inn'];
            $auk->region = $_POST['region'];
            $auk->title = $_POST['title'];
            $uk->tarif_id = $tarifId;

            //    $auk->save();
            $data['user_id'] = $this->currentUser->id;
            $data['kontragent_id'] = $id_k;
            $data['tarif_id'] = $tarifId;
            $data['title'] = $_POST['title'];

            if ($_POST['copy'] == true) {
                // print_r($data);
                // exit();
                $stmt = $db->query(
                        "INSERT INTO `tnved_testorder`.`orders_users__kontragents` (`user_id`, `kontragent_id`, `tarif_id`, `id`, `region`, `title`, `country`)
                   VALUES ('?', '?', '?', NULL, NULL, NULL, NULL);", array($data['user_id'], $data['kontragent_id'], $data['tarif_id'], $data['title'])
                );
            } else {


                $result = $db->update('orders_users__kontragents', $data, $db->quoteInto('id=?', $_POST['hid_id']));
            }
        }

        $allUserTarifs = new AK_Order_User_Tarif_List();
        $this->view->userTarifs = $allUserTarifs->getAllTarifs($this->_user->id);

        // Настройка
        $db1 = Zend_Registry::get("DBORDER");
        if (isset($_POST['save_setting'])) {

            $data = $_POST;
            unset($data["save_setting"]);

            $data['id_user'] = $_SESSION['user_id'];
            unset($data['inform']);

            $queryC = $db1->select();
            $queryC->from('order_setting_event_company');
            $queryC->where('id_user = ?', $_SESSION['user_id']);
            $totalRows = $db1->fetchRow($queryC);

            if (empty($totalRows)) {
                $count = $db1->insert("order_setting_event_company", $data);
            } else {

                $where = $db1->quote('id_user = ?', $_SESSION['user_id']);
                $count = $db1->delete('order_setting_event_company', $where);
                $count = $db1->insert("order_setting_event_company", $data);
            }
        }


        $queryC = $db1->select();
        $queryC->from('order_setting_event_company');
        $queryC->where('id_user = ?', $_SESSION['user_id']);
        $totalRows = $db1->fetchRow($queryC);

        $this->view->datas = $totalRows;

        $ttList = new AK_Order_Monitoring_Event_Type_List();
        $this->view->ttList = $ttList->getList();

        $db = Zend_Registry::get('DBORDER');
        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.country')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.country <> "" AND A.country IS NOT NULL')->order('A.country');
        $this->view->cList = $db->fetchCol($query);

        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.region')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.region <> "" AND A.region IS NOT NULL')->order('A.region');
        $this->view->rList = $db->fetchAll($query);

        $queryCal = $db->select();
        $queryCal->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
        $queryCal->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
        $queryCal->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));

        $queryCal->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);
        foreach ($db->fetchAll($queryCal) as $event) {
            if ($event['id'] == $event['id']) {
                $eventsdata[$event['event_type_id']][$event['country']] = $eventsdata[$event['event_type_id']][$event['country']] + 1;
            }
            if ($event['country'] == 'RU') {
                $events_all['RU_ev_all'] = $events_all['RU_ev_all'] + 1;
            }
            if ($event['country'] == 'UA') {
                $events_all['UA_ev_all'] = $events_all['UA_ev_all'] + 1;
            }
        }
        $eventsdata[0] = $events_all;
        $this->view->eventsdata = $eventsdata;

        if (!empty($this->params['filter']) && in_array($this->params['filter'], array('all', 'year', 'month', 'week', 'new'))) {
            $_SESSION['monfilter'] = $this->params['filter'];
        } elseif (empty($_SESSION['monfilter']) && ($this->_user->getLastEventCount() > 0)) {
            $_SESSION['monfilter'] = 'new';
        } elseif
        (empty($_SESSION['monfilter'])) {
            $_SESSION['monfilter'] = 'month';
        }
    }

    public function eventsdatagroupAction() {

        $ttList = new AK_Order_Monitoring_Event_Type_List();
        $this->view->ttList = $ttList->getList();

        $db = Zend_Registry::get('DBORDER');
        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.country')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.country <> "" AND A.country IS NOT NULL')->order('A.country');
        $this->view->cList = $db->fetchCol($query);

        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.region')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.region <> "" AND A.region IS NOT NULL')->order('A.region');
        $this->view->rList = $db->fetchAll($query);

        $queryCal = $db->select();
        $queryCal->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
        $queryCal->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
        $queryCal->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));

        $queryCal->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);

        $this->view->CalendarData = $db->fetchAll($queryCal);
        foreach ($db->fetchAll($queryCal) as $event) {
            if ($event['id'] == $event['id']) {
                $eventsdata[$event['event_type_id']][$event['country']] = $eventsdata[$event['event_type_id']][$event['country']] + 1;
            }
            if ($event['country'] == 'RU') {
                $events_all['RU_ev_all'] = $events_all['RU_ev_all'] + 1;
            }
            if ($event['country'] == 'UA') {
                $events_all['UA_ev_all'] = $events_all['UA_ev_all'] + 1;
            }
        }
        $eventsdata[0] = $events_all;
        $this->view->eventsdata = $eventsdata;

        if (!empty($this->params['filter']) && in_array($this->params['filter'], array('all', 'year', 'month', 'week', 'new'))) {
            $_SESSION['monfilter'] = $this->params['filter'];
        } elseif (empty($_SESSION['monfilter']) && ($this->_user->getLastEventCount() > 0)) {
            $_SESSION['monfilter'] = 'new';
        } elseif
        (empty($_SESSION['monfilter'])) {
            $_SESSION['monfilter'] = 'month';
        }
    }

    public function eventsAction() {
        $db1 = Zend_Registry::get("DBORDER");
        
        if(!empty($_GET['idDel'])){
            
        $db1 = Zend_Registry::get('DBORDER');
        $sql = "DELETE FROM orders_monitoring__events WHERE id = " . (int)$_GET['idDel'];
        $db1->query($sql);
            exit("true");
        }
        
        $query = $db1->select();
// $query->from('orders_monitoring__events AS A', 'A.date_created');
// $query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id)
        // ->order('A.date_created DESC')
        // ->limit(1);
        $query->from('orders_users__monitoring_tarifs AS A', 'A.date_next_mon');
        $query->where(' user_id = ?', $_SESSION['user_id'])
                ->order('A.date_next_mon DESC')
                ->limit(1);

        $res = intval($db1->fetchOne($query));

        $this->view->lastMonitoringDate = empty($res) ? 'Мониторинг не проводился' : date('d.m.Y', $res);
        if (!empty($_GET['csvArray'])) {

            //  	 	header ("Content-Type: application/octet-stream");
            // header ("Accept-Ranges: bytes");
            // header ("Content-Length: ".filesize($file));
            // header ("Content-Disposition: attachment; filename=boxes.cvs");

            $db = Zend_Registry::get('DBORDER');

            $query = $db->select();
            $query->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
            $query->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
            $query->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));
            $query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);


            $a = $_GET['csvArray'];
            $i = 0;
            foreach ($a as $value) {
                if ($i == 0) {
                    $query->where('A.id = ?', $value);
                    $i = 1;
                } else {
                    $query->orWhere('A.id = ?', $value);
                }
            }
            //

            $data[-11]['inn'] = "Инн";
            $data[-11]['country'] = 'Страна';
            $data[-11]['date_create'] = 'Дата мониторинга';
            $data[-11]['event_date'] = 'Дата события';
            $data[-11]['region'] = 'Регион';
            $data[-11]['event_type'] = 'Тип события';
            $data[-11]['content'] = 'Описания';

            $dataDb = $db->fetchAll($query);

            foreach ($dataDb as $key => $value) {
                $data[$key]['inn'] = $value['inn'];
                $data[$key]['country'] = $value['country'];
                $data[$key]['date_create'] = date('d.m.Y', $value['date_create']);
                $data[$key]['event_date'] = date('d.m.Y', $value['event_date']);
                $data[$key]['region'] = $value['region'];
                $data[$key]['event_type'] = $value['event_type'];
                $data[$key]['content'] = $value['content'];
            }

            $csv = new CSV_Writer($data);
            $csv->headers('test');
            $csv->output();
            exit();
        }


        $type = new AK_Order_Monitoring_Tarif_ListType();
        $this->view->type = $type->getList();

        if (!empty($_POST['save_setting'])) {

            $data = array(
                'id_user' => $_SESSION['user_id'],
                'name' => $_POST['name'],
                'inn' => $_POST['inn'],
                'region' => $_POST['region'],
                'country' => $_POST['country'],
                'date_event' => $_POST['date_event'],
                'event' => $_POST['event'],
                'date_monitoring' => $_POST['date_monitoring'],
                'tarif' => $_POST['tarif'],
                'desc' => $_POST['desc'],
                'kra_pod' => $_POST['inform'],
                'window' => $_POST['window'],
                'click' => $_POST['click'],
            );
            if($data['window']==null)
                $data['window'] = 'standart';
            $queryC = $db1->select();
            $queryC->from('order_setting_event');
            $queryC->where('id_user = ?', $_SESSION['user_id']);
            $totalRows = $db1->fetchRow($queryC);

            if (empty($totalRows)) {
                $count = $db1->insert("order_setting_event", $data);
                   print_r($count);
      
            } else {

                $where = $db1->quote('id_user = ?', $_SESSION['user_id']);
                $count = $db1->delete('order_setting_event', $where);
                $count = $db1->insert("order_setting_event", $data);
            }

        }



        if (isset($_POST['id_favorites'])) {
            foreach ($_POST['id_favorites'] as $key => $value) {
                // echo $key .'=>'. $value.'<br>';
                $db = Zend_Registry::get('DBORDER');
                $queryFavorites = $db->select();
                $table = 'orders_monitoring__events';
                $set = array(
                    'favorites' => '1',
                );
                $where = $db->quoteInto('id = ?', $value);
                $d = $db->update($table, $set, $where);
            }
        }

        $ttList = new AK_Order_Monitoring_Event_Type_List();
        $this->view->ttList = $ttList->getList();

        $db = Zend_Registry::get('DBORDER');
        $queryEveCountry = $db->select();
        $queryEveCountry->from('orders_monitoring__eventType_connect_country');
        $EveCountry = $db->fetchAll($queryEveCountry);

        $this->view->eveCountry = $EveCountry;



        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.country')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.country <> "" AND A.country IS NOT NULL')->order('A.country');
        $this->view->cList = $db->fetchCol($query);

        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.region')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.region <> "" AND A.region IS NOT NULL')->order('A.region');
        $this->view->rList = $db->fetchAll($query);
        $queryCal = $db->select();
        $queryCal->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
        $queryCal->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
        $queryCal->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));

        $queryCal->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);

        $this->view->CalendarData = $db->fetchAll($queryCal);
        $eventsdata = array('4' => array('RU' => '', 'UA' => '', '' => ''), '5' => array('RU' => '', 'UA' => '', '' => ''), '6' => array('RU' => '', 'UA' => '', '' => ''),);
        $events_all = array('RU_ev_all' => '', 'UA_ev_all' => '',);
        foreach ($db->fetchAll($queryCal) as $event) {
            if ($event['id'] == $event['id']) {
                $eventsdata[$event['event_type_id']][$event['country']] = $eventsdata[$event['event_type_id']][$event['country']] + 1;
            }
            if ($event['country'] == 'RU') {
                $events_all['RU_ev_all'] = $events_all['RU_ev_all'] + 1;
            }
            if ($event['country'] == 'UA') {
                $events_all['UA_ev_all'] = $events_all['UA_ev_all'] + 1;
            }
        }
        $eventsdata[0] = $events_all;

        $this->view->eventsdata = $eventsdata;

        $queryC = $db1->select();
        $queryC->from('order_setting_event');
        $queryC->where('id_user = ?', $_SESSION['user_id']);
        $totalRows = $db1->fetchRow($queryC);

        $this->view->datas = $totalRows;


        


        if (!empty($this->params['filter']) && in_array($this->params['filter'], array('all', 'year', 'month', 'week', 'new'))) {
            $_SESSION['monfilter'] = $this->params['filter'];
        } elseif (empty($_SESSION['monfilter']) && ($this->_user->getLastEventCount() > 0)) {
            $_SESSION['monfilter'] = 'new';
        } elseif
        (empty($_SESSION['monfilter'])) {
            $_SESSION['monfilter'] = 'month';
        }
    }
    public function eventsbylistAction() {
        $db1 = Zend_Registry::get("DBORDER");

        $query = $db1->select();
        $query->from('orders_users__monitoring_tarifs AS A', 'A.date_next_mon');
        $query->where(' user_id = ?', $_SESSION['user_id'])
                ->order('A.date_next_mon DESC')
                ->limit(1);

        $res = intval($db1->fetchOne($query));

        $this->view->lastMonitoringDate = empty($res) ? 'Мониторинг не проводился' : date('d.m.Y', $res);        

        $type = new AK_Order_Monitoring_Tarif_ListType();
        $this->view->type = $type->getList();

        if (!empty($_POST['save_setting'])) {
            $data = array(
                'id_user' => $_SESSION['user_id'],
                'name' => $_POST['name'],
                'inn' => $_POST['inn'],
                'region' => $_POST['region'],
                'country' => $_POST['country'],
                'date_event' => $_POST['date_event'],
                'event' => $_POST['event'],
                'date_monitoring' => $_POST['date_monitoring'],
                'tarif' => $_POST['tarif'],
                'desc' => $_POST['desc'],
                'kra_pod' => $_POST['inform'],
            );

            $queryC = $db1->select();
            $queryC->from('order_setting_event');
            $queryC->where('id_user = ?', $_SESSION['user_id']);
            $totalRows = $db1->fetchRow($queryC);

            if (empty($totalRows)) {
                $count = $db1->insert("order_setting_event", $data);
            } else {

                $where = $db1->quote('id_user = ?', $_SESSION['user_id']);
                $count = $db1->delete('order_setting_event', $where);
                $count = $db1->insert("order_setting_event", $data);
            }
        }

        if (isset($_POST['id_favorites'])) {
            foreach ($_POST['id_favorites'] as $key => $value) {
                // echo $key .'=>'. $value.'<br>';
                $db = Zend_Registry::get('DBORDER');
                $queryFavorites = $db->select();
                $table = 'orders_monitoring__events';
                $set = array(
                    'favorites' => '1',
                );
                $where = $db->quoteInto('id = ?', $value);
                $d = $db->update($table, $set, $where);
            }
        }
        $ttList = new AK_Order_Monitoring_Event_Type_List();
        $this->view->ttList = $ttList->getList();

        $db = Zend_Registry::get('DBORDER');
        $queryEveCountry = $db->select();
        $queryEveCountry->from('orders_monitoring__eventType_connect_country');
        $EveCountry = $db->fetchAll($queryEveCountry);

        $this->view->eveCountry = $EveCountry;



        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.country')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.country <> "" AND A.country IS NOT NULL')->order('A.country');
        $this->view->cList = $db->fetchCol($query);

        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.region')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.region <> "" AND A.region IS NOT NULL')->order('A.region');
        $this->view->rList = $db->fetchAll($query);
        $queryCal = $db->select();
        $queryCal->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
        $queryCal->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
        $queryCal->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));

        $queryCal->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);

        $this->view->CalendarData = $db->fetchAll($queryCal);
        $eventsdata = array('4' => array('RU' => '', 'UA' => '', '' => ''), '5' => array('RU' => '', 'UA' => '', '' => ''), '6' => array('RU' => '', 'UA' => '', '' => ''),);
        $events_all = array('RU_ev_all' => '', 'UA_ev_all' => '',);
        foreach ($db->fetchAll($queryCal) as $event) {
            if ($event['id'] == $event['id']) {
                $eventsdata[$event['event_type_id']][$event['country']] = $eventsdata[$event['event_type_id']][$event['country']] + 1;
            }
            if ($event['country'] == 'RU') {
                $events_all['RU_ev_all'] = $events_all['RU_ev_all'] + 1;
            }
            if ($event['country'] == 'UA') {
                $events_all['UA_ev_all'] = $events_all['UA_ev_all'] + 1;
            }
        }
        $eventsdata[0] = $events_all;

        $this->view->eventsdata = $eventsdata;

        $queryC = $db1->select();
        $queryC->from('order_setting_event');
        $queryC->where('id_user = ?', $_SESSION['user_id']);
        $totalRows = $db1->fetchRow($queryC);

        $this->view->datas = $totalRows;

        if (!empty($this->params['filter']) && in_array($this->params['filter'], array('all', 'year', 'month', 'week', 'new'))) {
            $_SESSION['monfilter'] = $this->params['filter'];
        } elseif (empty($_SESSION['monfilter']) && ($this->_user->getLastEventCount() > 0)) {
            $_SESSION['monfilter'] = 'new';
        } elseif
        (empty($_SESSION['monfilter'])) {
            $_SESSION['monfilter'] = 'month';
        }
    }
    
    public function eventsdemoAction() {
        $ttList = new AK_Order_Monitoring_Event_Type_List();
        $this->view->ttList = $ttList->getList();

        $db = Zend_Registry::get('DBORDER');
        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.country')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.country <> "" AND A.country IS NOT NULL')->order('A.country');
        $this->view->cList = $db->fetchCol($query);

        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.region')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.region <> "" AND A.region IS NOT NULL')->order('A.region');
        $this->view->rList = $db->fetchAll($query);


        if (!empty($this->params['filter']) && in_array($this->params['filter'], array('all', 'year', 'month', 'week', 'new'))) {
            $_SESSION['monfilter'] = $this->params['filter'];
        } elseif (empty($_SESSION['monfilter'])) {
            $_SESSION['monfilter'] = 'all';
        }

        $this->view->monfilter = $_SESSION['monfilter'];
    }

    public function disabledAction() {
        
    }

    public function eventAction() {

        if (isset($_POST['id_favorites'])) {

            $db = Zend_Registry::get('DBORDER');
            $queryFavorites = $db->select();
            $table = 'orders_monitoring__events';
            $set = array(
                'favorites' => $_POST['favor'],
            );



            $where = $db->quoteInto('id = ?', $_POST['id_favorites']);

            $d = $db->update($table, $set, $where);
        }
        $db = Zend_Registry::get('DBORDER');
        $queryC = $db->select();
        $queryC->from('order_setting_event');
        $queryC->where('id_user = ?', $_SESSION['user_id']);
        $totalRows = $db->fetchRow($queryC);

        $this->view->datas = $totalRows;

        $queryCal = $db->select();
        $queryCal->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id'));
        $queryCal->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $_SESSION['user_id']);
//print_r($db->fetchAll($queryCal));
        $mas=array('first' => 'false', 'second' => null, 'last' => 'false' );
        foreach ($db->fetchAll($queryCal) as  $value) {
	    if($value['id']==$this->params['event_id']){
                $mas['second']=$value['id'];
            }
            if ($mas['second']==null){
                $mas['first']=$value['id'];
            }            
            if(!empty($mas['second']) && $value['id']!=$this->params['event_id'] && $mas['last']=='false'){
                $mas['last']=$value['id'];
            }          
        }
         $this->view->mas =$mas;
        

        $this->params['event_id'] = isset($this->params['event_id']) ? $this->params['event_id'] : 0;
        $this->view->event = new AK_Order_Monitoring_Event($this->params['event_id']);
        if (!$this->view->event->id)
            $this->_redirect('/monitoring/');
        $this->view->event->view();

        
        include_once('monitoring/action.addtarif.php');
    }

    public function eventcAction() {

        $this->params['kontragent_id'] = isset($this->params['kontragent_id']) ? $this->params['kontragent_id'] : 0;

        $temp = new AK_Order_User_Kontragent(null, $this->params['kontragent_id']);
        $this->view->favorites = $temp->favorites;

        $this->view->id_kont = $temp->id;

        //    print_r($this->params['kontragent_id']);
        // exit();
        $this->view->kontrag = new AK_Order_Kontragent('id', $this->params['kontragent_id']);
        //    $this->view->event = new AK_Order_Monitoring_Event($this->params['event_id']);
        // print_r($this->view->event->kontragentId);
        // exit();
        //  print_r($this);
        // if (!$this->view->kontrag->id) $this->_redirect('/monitoring/');
        // $this->view->kontrag->view();
    }

    public function eventinfoAction() {
        $this->params['event_id'] = isset($this->params['event_id']) ? $this->params['event_id'] : 0;
        $this->view->event = new AK_Order_Monitoring_Event($this->params['event_id']);
        //if (!$this->view->event->id) $this->_redirect('/monitoring/');
        $this->view->event->view();
        $this->view->setLayout('monitoring/eventinfo.tpl');
        //die();
    }

    public function tarifinfoAction() {
        $this->params['tarif_id'] = isset($this->params['tarif_id']) ? $this->params['tarif_id'] : 0;
        $this->view->tarif = new AK_Order_User_Tarif($this->params['tarif_id']);
        //if (!$this->view->event->id) $this->_redirect('/monitoring/');
        //$this->view->tarif;
        print_r($this->params['id']);
        // exit("");

        $allUserTarifs = new AK_Order_User_Tarif_List();
        $allUserTarifs->addWhere('A.tarif_id = ' . $this->params['id']);

        $this->view->count_kontr = $allUserTarifs->getCountKontragents($this->_user->id, $tarif->tarifId);

        $events = array();
        $ev = new AK_Order_Monitoring_Event_Type_List();
        foreach ($ev->getList() as $evn)
            if ($this->view->tarif->getTarifAll()->getEventType($evn->id)) {
                $events[$evn->id] = $evn->title . '(' . $this->view->tarif->getEventCount($evn->id) . ')';
            }
        $this->view->event = implode(', ', $events);

        $this->view->price = (int) $this->view->tarif->count * (int) $this->view->tarif->price_one * floor($this->view->tarif->m / $this->view->tarif->period);

        $this->view->dateNextMon = $this->view->tarif->dateNextMon == '-' ? $this->view->tarif->dateNextMon : (( date('w', $this->view->tarif->dateNextMon) == 6 or date('w', $this->view->tarif->dateNextMon) == 0) ? date('d-m-Y*', ($this->view->tarif->dateNextMon)) : date('d-m-Y', ($this->view->tarif->dateNextMon)));

        $this->view->setLayout('monitoring/tarifinfo.tpl');
        //die();
    }

    public function eventsdataAction() {
        include_once('monitoring/action.eventsdata.php');
    }

    public function favoritesdataAction() {
        include_once('monitoring/action.favoritesdata.php');
    }

    public function eventscompanydataAction() {
        include_once('monitoring/action.eventsdatacompany.php');
    }

    public function eventsdateAction() {
        include_once('monitoring/action.eventsdate.php');
    }

    public function kontrdataAction() {
        include_once('monitoring/action.kontrdata.php');
    }

    public function eventsdatademoAction() {
        include_once('monitoring/action.eventsdatademo.php');
    }

    public function datafeedAction() {
        include_once('monitoring/action.datafeed.php');
    }

    public function datafeeddemoAction() {
        include_once('monitoring/action.datafeeddemo.php');
    }

    public function dogovorAction() {
        include_once('monitoring/action.dogovor.php');
    }

    public function prilAction() {
        include_once('monitoring/action.pril.php');
    }

    public function calendarAction() {
        include_once('monitoring/action.index.php');
        $ttList = new AK_Order_Monitoring_Event_Type_List();
        $this->view->ttList = $ttList->getList();
        $db = Zend_Registry::get('DBORDER');
        $queryEveCountry = $db->select();
        $queryEveCountry->from('orders_monitoring__eventType_connect_country');
        $EveCountry = $db->fetchAll($queryEveCountry);

        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.country')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.country <> "" AND A.country IS NOT NULL')->order('A.country');
        $this->view->cList = $db->fetchCol($query);

        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.region')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.region <> "" AND A.region IS NOT NULL')->order('A.region');
        $this->view->rList = $db->fetchAll($query);

        $this->view->eveCountry = $EveCountry;

        $queryCal = $db->select();
        $queryCal->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
        $queryCal->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
        $queryCal->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));

        $queryCal->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);

        $this->view->CalendarData = $db->fetchAll($queryCal);

        foreach ($db->fetchAll($queryCal) as $event) {
            if ($event['id'] == $event['id']) {
                $eventsdata[$event['event_type_id']][$event['country']] = $eventsdata[$event['event_type_id']][$event['country']] + 1;
            }
            if ($event['country'] == 'RU') {
                $events_all['RU_ev_all'] = $events_all['RU_ev_all'] + 1;
            }
            if ($event['country'] == 'UA') {
                $events_all['UA_ev_all'] = $events_all['UA_ev_all'] + 1;
            }
        }
        $eventsdata[0] = $events_all;

        $this->view->eventsdata = $eventsdata;
    }

    public function calendardemoAction() {
        include_once('monitoring/action.index.php');
        $ttList = new AK_Order_Monitoring_Event_Type_List();
        $this->view->ttList = $ttList->getList();
    }

    public function statisticsAction() {
        $this->view->MonthNames = array("", "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
        $db = Zend_Registry::get('DBORDER');

        $query = $db->select()->from('orders_users__tarifs_stat', '*')->where('user_id =  ?', $this->_user->id)->order('start_date');
        $list = $db->fetchAll($query);
        $this->view->year = $this->getRequest()->getParam('year');
        if (empty($this->view->year)) {
            $this->view->year = date('Y', time());
        }
        $this->view->year_begin = date('Y', $this->_user->createDate);
        $this->view->year_end = date('Y');
        if ($this->view->year == $this->view->year_begin)
            $this->view->mount_begin = date('n', $this->_user->createDate);
        else
            $this->view->mount_begin = 1;
        if ($this->view->year == $this->view->year_end)
            $this->view->mount_end = date('n');
        else
            $this->view->mount_end = 12;

        $stat = array();
        for ($i = $this->view->mount_begin; $i <= $this->view->mount_end; $i++) {
            $stat[$i] = array();
            $stat[$i]['count'] = array(0, 0, 0);
            $stat[$i]['points'] = array();
            for ($k = 1; $k <= date('t'); $k++)
                $stat[$i]['points'][$k] = array(
                    'count' => 0,
                    'count_s' => 0,
                    'count_e' => 0,
                    'count_b' => 0,
                    'tarif' => ''
                );
            $stat[$i]['allcount'] = $stat[$i]['count']['0'] + $stat[$i]['count']['1'] + $stat[$i]['count']['2'];



            $stat[$i]['tarifs'] = array();
        }
        $db = Zend_Registry::get('DBORDER');
        $query = $db->select()->from('orders_users__monitoring_tarifs', '*')->where('user_id =  ?', $this->_user->id)->order('start_date');
        $list = $db->fetchAll($query);
        $date_b = mktime(0, 0, 0, $this->view->mount_begin, 1, $this->view->year);
        $date_e = mktime(0, 0, 0, $this->view->mount_end, 31, $this->view->year);
        $i = 0;
        foreach ($list as $item) {
            if (date('Y', $item['start_date']) == $this->view->year || date('Y', $item['end_date_user']) == $this->view->year) {
                if (date('Y', $item['start_date']) == $this->view->year)
                    $m_begin = date('n', $item['start_date']);
                else
                    $m_begin = 1;
                if (date('Y', $item['end_date_user']) == $this->view->year)
                    $m_end = date('n', $item['end_date_user']);
                else
                    $m_end = 12;
                $db_tarif = Zend_Registry::get('DBORDER');
                $query_tarif = $db_tarif->select()->from('orders_monitoring__statistic', '*')->where('tarif_id =  ?', $item['id'])->where('date > ?', $date_b)->where('date < ?', $date_e)->order('date');
                $list_tarif = $db_tarif->fetchAll($query_tarif);
                $j = 0;
                foreach ($list_tarif as $mon) {
                    $mount_t = date('n', $mon['date']);
                    $mount_u = date('n', $mon['date']);
                    $day_t = date('j', $mon['date']);
                    $mon['tarif'] = $item['period'] . '-' . $item['m'] . '-' . $item['count'];
                    $stat[$mount_u]['count']['count'] = $mon["count"];
                    $stat[$mount_t]['points'][$day_t]['count']+=$mon['count'];
                    $stat[$mount_t]['points'][$day_t]['count_s']+=$mon['count_s'];
                    $stat[$mount_t]['points'][$day_t]['count_e']+=$mon['count_e'];
                    $stat[$mount_t]['points'][$day_t]['count_b']+=$mon['count_b'];
                    if ($stat[$mount_t]['points'][$day_t]['tarif'] != $mon['tarif'])
                        if (empty($stat[$mount_t]['points'][$day_t]['tarif']))
                            $stat[$mount_t]['points'][$day_t]['tarif'].=$mon['tarif'];
                        else
                            $stat[$mount_t]['points'][$day_t]['tarif'].=', ' . $mon['tarif'];
                    $stat[$mount_t]['count'][0] += $mon['count_s'];

                    $stat[$mount_t]['count'][1] += $mon['count_e'];

                    $stat[$mount_t]['count'][2] += $mon['count_b'];
                    $stat[$mount_t]['allcount'] += $mon['count'];
                    $stat[$mount_t]['tarifs'][] = $mon['tarif'];
                }
            }
        }

        $db = Zend_Registry::get('DBORDER');
        $query = $db->select()->from('orders_users__monitoring_tarifs', '*')->where('user_id =  ?', $this->_user->id)->order('start_date');
        $list = $db->fetchAll($query);

        $statY = Array();
        $i = $this->view->year_begin;
        foreach ($list as $item) {
            for ($i = $this->view->year_begin; $i <= $this->view->year_end; $i++) {
                $date_b = mktime(0, 0, 0, 1, 1, $i);
                $date_e = mktime(0, 0, 0, 1, 1, $i + 1);
                $db_tarif = Zend_Registry::get('DBORDER');
                $query_tarif = $db_tarif->select()->from('orders_monitoring__statistic', '*')
                                ->where('tarif_id =  ?', $item['id'])->where('date > ?', $date_b)->where('date < ?', $date_e)->order('date');
                $list_tarif = $db_tarif->fetchAll($query_tarif);
                if (($list_tarif != Array()))
                    $statY[$i] = 7;
            }
        }


        $this->view->statY = $statY;
        $this->view->stat = $stat;
    }

    public function documentsAction() {
        $tarifsList = new AK_Order_Monitoring_Tarif_List();
        $tarifsList->addWhere('A.is_active = 1');
        $this->view->tarifsList = $tarifsList->getList();

        if (!$this->currentUser->getLogin()) {
            $this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id) {
            $this->_redirect(SITE_URL);
        }

        //settings
        $form1 = new AK_Form('editForm', 'post', SITE_URL . '/monitoring/documents/');

        if ($form1->validate($this->params)) {

            $this->_user->aktNotifyFlagMonitoring = empty($this->params['akt_notify_flag_monitoring']) ? 0 : 1;


            $this->_user->save();
            $this->_redirect(SITE_URL . '/monitoring/documents/');
        } else {

            if (!$form1->isPostback()) {
                $this->params['akt_notify_flag_monitoring'] = $this->_user->aktNotifyFlagMonitoring;
            }
            $form1->setDefaults($this->params);
            $this->view->form1 = $form1;
        }

        $this->view->fparams = $this->params;
    }

    public function tarifsAction() {
        $tarifsList = new AK_Order_Monitoring_Tarif_List();
        $tarifsList->addWhere('A.is_active = 1');
        $this->view->tarifsList = $tarifsList->getList();


        $this->view->countTarif = count($this->view->tarifsList);

        $main = $this->view->tarifsList[0];
        $this->view->itemMain = $main->pM;


        if (!$this->currentUser->getLogin()) {
            $this->_redirect(SITE_URL);
        }

        if ($this->currentUser->id != $this->_user->id) {
            $this->_redirect(SITE_URL);
        }
    }

    public function listAction() {


        if (isset($_POST['id_favorites'])) {

            $db = Zend_Registry::get('DBORDER');
            $queryFavorites = $db->select();



            $table = 'orders_users__kontragents';
            $set = array(
                'favorites' => $_POST['favor'],
            );



            $where = $db->quoteInto('id = ?', $_POST['id_favorites']);


            $d = $db->update($table, $set, $where);

            exit();
        }





        include_once('monitoring/action.list.php');
        include_once('monitoring/action.addtarif.php');
        $db = Zend_Registry::get('DBORDER');
        $queryEveCountry = $db->select();
        $queryEveCountry->from('orders_monitoring__eventType_connect_country');
        $EveCountry = $db->fetchAll($queryEveCountry);

        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.country')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.country <> "" AND A.country IS NOT NULL')->order('A.country');
        $this->view->cList = $db->fetchCol($query);

        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.region')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.region <> "" AND A.region IS NOT NULL')->order('A.region');
        $this->view->rList = $db->fetchAll($query);

        $this->view->eveCountry = $EveCountry;

        $queryCal = $db->select();
        $queryCal->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
        $queryCal->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
        $queryCal->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));

        $queryCal->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);

        $this->view->CalendarData = $db->fetchAll($queryCal);

        foreach ($db->fetchAll($queryCal) as $event) {
            if ($event['id'] == $event['id']) {
                $eventsdata[$event['event_type_id']][$event['country']] = $eventsdata[$event['event_type_id']][$event['country']] + 1;
            }
            if ($event['country'] == 'RU') {
                $events_all['RU_ev_all'] = $events_all['RU_ev_all'] + 1;
            }
            if ($event['country'] == 'UA') {
                $events_all['UA_ev_all'] = $events_all['UA_ev_all'] + 1;
            }
        }
        $eventsdata[0] = $events_all;

        $this->view->eventsdata = $eventsdata;
    }

    public function listgroupregAction() {
        include_once('monitoring/action.listgroupreg.php');
        include_once('monitoring/action.addtarif.php');
        $db = Zend_Registry::get('DBORDER');
        $queryEveCountry = $db->select();
        $queryEveCountry->from('orders_monitoring__eventType_connect_country');
        $EveCountry = $db->fetchAll($queryEveCountry);

        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.country')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.country <> "" AND A.country IS NOT NULL')->order('A.country');
        $this->view->cList = $db->fetchCol($query);

        $query = $db->select()->distinct()->from(array('A' => 'orders_kontragents'), 'A.region')->joinInner(array('B' => 'orders_monitoring__events'), 'A.id = B.kontragent_id', null)->where('A.region <> "" AND A.region IS NOT NULL')->order('A.region');
        $this->view->rList = $db->fetchAll($query);

        $this->view->eveCountry = $EveCountry;

        $queryCal = $db->select();
        $queryCal->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
        $queryCal->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
        $queryCal->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));

        $queryCal->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->_user->id);

        $this->view->CalendarData = $db->fetchAll($queryCal);

        foreach ($db->fetchAll($queryCal) as $event) {
            if ($event['id'] == $event['id']) {
                $eventsdata[$event['event_type_id']][$event['country']] = $eventsdata[$event['event_type_id']][$event['country']] + 1;
            }
            if ($event['country'] == 'RU') {
                $events_all['RU_ev_all'] = $events_all['RU_ev_all'] + 1;
            }
            if ($event['country'] == 'UA') {
                $events_all['UA_ev_all'] = $events_all['UA_ev_all'] + 1;
            }
        }
        $eventsdata[0] = $events_all;

        $this->view->eventsdata = $eventsdata;
    }

    public function notarifAction() {
        include_once('monitoring/action.notarif.php');
    }

    // добавляем новый тариф 

    public function addtarifAction() {

        //   $this->tarifIdPost = $_POST['tarifid'];
        // $this->typeIdPost = $_POST['type'];
        // $this->countryId = $_POST['country_tarif'];

        $this->view->tarifIdPost = $this->tarifIdPost;
        $this->view->typeClick = $this->typeIdPost;
        include_once('monitoring/action.addtarif.php');
    }

    public function tarifgridaddAction() {

        $this->view->tarifIdPost = $this->tarifIdPost;
        $this->view->typeClick = $this->typeIdPost;
        include_once('monitoring/action.tarif_grid_add.php');
    }

    public function notapprovedAction() {
        
    }

    /**
     * @autor voodoo
     */
    public function ordersAction() {

        if (!$this->currentUser->getLogin()) {
            $this->_redirect(SITE_URL);
        }

        if ($this->currentUser->blockMonitoring) {
            $this->_redirect('/monitoring/blocked/');
        }
        if ($this->currentUser->id != $this->_user->id) {
            $this->_redirect(SITE_URL);
        }

        if (isset($_POST['sort']))
            $sort_type = $_POST['sort'];
        if (isset($_POST['id_order']) && is_numeric($_POST['id_order']))
            $id_order = $_POST['id_order'];
        else
            $id_order = '';

        if (isset($_POST['sort_type']))
            $sort_type = $_POST['sort_type'];

        if (!isset($sort_type))
            $sort_type = '';
        //else
        // $sort_type=substr($sort_type,4);
        //var_dump($sort_type);
        if ($sort_type == '5')
            $sort_type = '';
        $this->params['page'] = empty($this->params['page']) ? 1 : intval($this->params['page']);


        //$orders = $this->_user->getPayedOrders($to, $sort_type, $id_order);

        $orders = $this->_user->getOrdersMonitoring($sort_type, $id_order);

        $url = '/users/plateji/userid/' . $this->_user->id;

        $P = new AK_Common_Paging(count($orders), 20, $url);
        $status_list = AK_Order_ZakazStatus::getList();
        $types = $this->checkOptions($status_list);
        $this->view->types = $types;
        $this->view->paging = $P->makePaging($this->params['page']);
        $this->view->orders = array_slice($orders, $this->params['page'] * ($this->params['page'] - 1), 20);
        $this->view->selected = $sort_type;

        //Zend_Debug::dump($this->view->orders);exit();
    }

    private function checkOptions($status_list) {
        $orders = $this->_user->getOrders('', '');
        $types = array();
        $return = array();

        foreach ($orders as $order) {
            $status = $order->status;
            if (!in_array($status, $types))
                $types[] = $status;
        }

        $count = count($types);
        // foreach ($i=0;$i<$count;$i++) {
        foreach ($types as $key => $item) {
            if (!empty($item)) {
                $o = new Option();
                $o->number = $item;
                $o->text = $status_list[$item];
                $return[] = $o;
            }
        }
        return $return;
    }

    public function changemailAction() {

        if ($this->getRequest()->isXmlHttpRequest()) {
            $c = $this->getRequest()->getParam('court');
            $e = $this->getRequest()->getParam('egrul');
            $b = $this->getRequest()->getParam('bankruptcy');
            //var_dump($this->getRequest());exit();
            $this->currentUser->updateEmails($c, $e, $b);
        }
    }

}


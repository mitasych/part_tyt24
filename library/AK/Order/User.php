<?php

/**
 * class Order 
 * Класс для работы с пользователями
 */
class AK_Order_User extends AK_Data_EntityOrder {

    /**
     * @var int
     */
    public $id;

    /**
     * логин
     * @var string
     */
    public $login;

    /**
     * сайт
     * @var string
     */
    public $site;

    /**
     * фамилия
     * @var string
     */
    public $secondName;

    /**
     * отчество
     * @var string
     */
    public $thirdName;

    /**
     * имя
     * @var string
     */
    public $name;

    /**
     * пол
     * @var int
     */
    public $gender;

    /**
     * 
     * @var int
     */
    public $from;

    /**
     * пароль
     * @var string
     */
    public $password;

    /**
     * новый пароль
     * @var string
     */
    public $newPassword;

    /**
     * электролнная почта
     * @var string
     */
    public $email;

    /**
     * телефон
     * @var string
     */
    public $phone;

    /**
     * доп информация
     * @var string
     */
    public $additionalInfo;
    public $subscribeFlag = 1;

    /**
     * виписка
     * @var string
     */
    public $vipiskaNotifyFlag = 0;

    /**
     * пригласивший пользователь
     * @var string
     */
    public $parent_user;

    /**
     * договор
     * @var string
     */
    public $dogovorNotifyFlag = 0;

    /**
     * последний вход пользователя
     * @var string
     */
    public $lastAccessDate = 0;

    /**
     * дата регистрации
     * @var string
     */
    public $createDate;

    /**
     * статус
     * @var string
     */
    public $status = 1;

    /**
     * организация
     * @var string
     */
    public $organization;

    /**
     * инн организация
     * @var string
     */
    public $innogrn;
    public $position;
    public $innogrn2;
    public $dolj;
    public $df;
    public $di;
    public $do;
    public $doljr;
    public $dfr;
    public $dir;
    public $dor;
    public $dn;
    public $dot;
    public $akt_email;
    public $companyProfile;
    public $aktNotifyFlagReport = 0;
    public $aktNotifyFlagBase = 0;
    public $aktNotifyFlagMonitoring = 0;
    public $aktNotifyFlagVed = 0;
    public $useMonitoring = 0;
    public $useReport = 0;
    public $useBase = 0;
    public $useVed = 0;
    public $useSms = 0;

    /**
     * дата мониторинга
     * @var string
     */
    public $dateMonitoring = 0;

    /**
     * дата отчета
     * @var string
     */
    public $dateReport = 0;
    public $dateBase = 0;
    public $blockMonitoring = 0;
    public $blockReport = 0;
    public $blockBase = 0;
    public $blockVed = 0;
    public $blockSms = 0;
    public $isBlocked = 0;
    public $dogovorCreated = 0;
    private $UserPath = null;
    private $isUsedNamedPath = false;
    public $balans = 0;
    public $isDeleted = 0;
    public $hash;
    public $country;
    private $TarifInfo = null;
    private $ActualTarifInfo = null;
    public $monitoringTarifSkidka = 0;
    public $uraddress = '';
    public $vipiskaEmail = '';
    // voodoo
    public $mon_test_period = 0; // тестовый период 
    public $court_mail;
    public $egrul_mail;
    public $bank_mail;
    public $mon_demo;
    public $end_mon_demo;
    public $enddate_mon_demo;
    public $sckode;
    public $kredit;
    public $date_kredit;
    public $akt_send_email;
    public $akt_send_kurator;
    public $save_pay;
    public $password_sip;

    /**
     * кредит
     * @return string 
     */
    public function getKreditInfo() {
        if (!empty($this->kredit))
            return $this->kredit . 'руб. до ' . date('d-m-Y', $this->date_kredit) . ' <a href="/admin/orders/userdelkr/id/' . $this->id . '">Списать</a> ';
        else
            return ' <a href="/admin/orders/userkredit/id/' . $this->id . '">Выдать</a> ';
    }

    /**
     * тариф
     * @return string 
     */
    public function getTarifInfo($recalc = false) {
        if (null === $this->TarifInfo || $recalc) {

            $_db = Zend_Registry :: get('DBORDER');

            $sql = $_db->select()->from('orders_users__monitoring_tarifs', 'id')->where('user_id = ?', $this->id);
            $res = $_db->fetchCol($sql);


            if (!empty($res[0])) {
                $this->TarifInfo = new AK_Order_User_Tarif($res[0]);
                //Zend_Debug::dump($this->TarifInfo);exit();
            }
        }

        return $this->TarifInfo;
    }

    /**
     * получаем инфо по ИД тарифа
     * @param int $tarif_id
     * @return string 
     */
    public function getTarifById($tarif_id) {
        $_db = Zend_Registry :: get('DBORDER');
        $sql = $_db->select()->from('orders_users__monitoring_tarifs')->where('tarif_id = ?', $tarif_id);
        $res = $_db->fetchAll($sql);

        if (isset($res[0])) {
            $tarif = new AK_Order_User_Tarif($res[0]);

            $this->TarifInfo = $tarif;
            return $tarif;
        }
    }

    /**
     * получаем инфо по ИД тарифа
     * @param int $id
     * @return string 
     */
    public function getTarifId($id) {
        $db = Zend_Registry::get('DBORDER');
        $query = $db->select('tarif_id');
        $query->from('orders_users__monitoring_tarifs AS A');
        $query->where('A.id=?', $id);
        $res = $db->fetchAll($query);
        $res = $res[0]['tarif_id'];
        return $res;
    }

    /**
     * взять страну
     * @return string 
     */
    public function getCountryObj() {
        if ($this->country) {
            return new AK_Location_Country($this->country);
        }
    }

    /**
     * инфо о актуальном тарифе
     * @param bool $id
     * @return string 
     */
    public function getActualTarifInfo($recalc = false) {
        if (null === $this->ActualTarifInfo || $recalc) {

            $_db = Zend_Registry :: get('DBORDER');

            $time = time();
            $sql = $_db->select()->from('orders_users__monitoring_tarifs', 'id')
                    ->where('user_id = ?', $this->id)
                    ->where('start_date <= ?', $time)
                    ->where('( ( (end_date_kurator = 0 OR end_date_kurator IS NULL) AND end_date_user >= ' . $time . ') OR ( end_date_kurator > 0  AND end_date_kurator >= ' . $time . '))');
            $res = $_db->fetchCol($sql);

            if (!empty($res[0])) {
                $this->ActualTarifInfo = new AK_Order_User_Tarif($res[0]);
            }
        }
        return $this->TarifInfo;
    }

    /**
     * Количество по актуальному тарифу
     * @return string 
     */
    public function getCountMon() {
        return $this->getActualTarifInfo()->count;
    }

    public function getCountMon1() {
        return $this->getActualTarifInfo();
    }

    /**
     * id пользователя
     * @return int 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Установить id
     * @param int $value
     * @return int 
     */
    public function setId($value) {
        $this->id = $value;
        return $this;
    }

    /**
     * @return unknown
     */
    public function getLogin() {
        return $this->login;
    }

    /**
     * имя пользователя
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * from пользователя
     * @return string 
     */
    public function getFrom() {
        return $this->from;
    }

    /**
     * пол id пользователя
     * @return string 
     */
    public function getGender() {
        return $this->gender;
    }

    /**
     * пол пользователя
     * @return string 
     */
    public function getGenderName() {
        $list = AK_Enum_Gender::getList();
        return $list[$this->gender];
    }

    /**
     * from пользователя
     * @return string 
     */
    public function getFromName() {
        $list = AK_Enum_From::getList();
        return $list[$this->from];
    }

    /**
     * фамилия пользователя
     * @return string 
     */
    public function getSecondName() {
        return $this->secondName;
    }

    /**
     * отчество пользователя
     * @return string 
     */
    public function getThirdName() {
        return $this->thirdName;
    }

    /**
     * @param unknown_type $login
     */
    public function setLogin($value) {
        $this->login = $value;
        return $this;
    }

    /**
     * платежные данные пользователя
     * @param string $value 
     * @return string 
     */
    public function setPayVal($value) {
        $this->save_pay = $value;
        return $this;
    }

    /**
     * установить имя
     * @param string $value
     * @return string 
     */
    public function setName($value) {
        $this->name = $value;
        return $this;
    }

    /**
     * установить from
     * @param string $value
     * @return string 
     */
    public function setFrom($value) {
        $this->from = $value;
        return $this;
    }

    /**
     * установить пол
     * @param string $value
     * @return string 
     */
    public function setGender($value) {
        $this->gender = $value;
        return $this;
    }

    /**
     * установить фамилию
     * @param string $value
     * @return string 
     */
    public function setSecondName($value) {
        $this->secondName = $value;
        return $this;
    }

    /**
     * установить отчество
     * @param string $value
     * @return string 
     */
    public function setThirdName($value) {
        $this->thirdName = $value;
        return $this;
    }

    /**
     * почта
     * @return string 
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * court_mail
     * @return string 
     */
    public function getCourtMail() {
        return $this->court_mail;
    }

    /**
     * egrul_mail
     * @return string 
     */
    public function getEgrulMail() {
        return $this->egrul_mail;
    }

    /**
     * bank_mail
     * @return string 
     */
    public function getBankMail() {
        return $this->bank_mail;
    }

    /**
     * установить почту
     * @param string $value
     * @return string 
     */
    public function setEmail($value) {
        $this->email = $value;
        return $this;
    }

    /**
     * взять пароль
     * @return string 
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * установить пароль
     * @param string $value
     * @return string 
     */
    public function setPassword($value) {
        $this->password = $value;
        return $this;
    }

    /**
     * взять дату создания
     * @return string 
     */
    public function getCreateDate() {
        return $this->createDate;
    }

    /**
     * установить дату создания
     * @param string $value
     * @return string 
     */
    public function setCreateDate($value) {
        $this->createDate = $value;
        return $this;
    }

    public function getOrganization() {
        return $this->organization;
    }

    /**
     * взять Icq
     * @return string 
     */
    public function getIcq() {
        return $this->icq;
    }

    /**
     * установить Icq
     * @param string $value
     * @return string 
     */
    public function setIcq($value) {
        $this->icq = $value;
        return $this;
    }

    /**
     * взять website
     * @return string 
     */
    public function getWebsite() {
        return $this->website;
    }

    /**
     * установить website
     * @param string $value
     * @return string 
     */
    public function setWebsite($value) {
        $this->website = $value;
        return $this;
    }

    /**
     * взять subscribeFlag
     * @return string 
     */
    public function getSubscribeFlag() {
        return $this->subscribeFlag;
    }

    /**
     * установить subscribeFlag
     * @param string $value
     * @return string 
     */
    public function setSubscribeFlag($value) {
        $this->subscribeFlag = $value;
        return $this;
    }

    /**
     * взять commentNotifyFlag
     * @return string 
     */
    public function getCommentNotifyFlag() {
        return $this->commentNotifyFlag;
    }

    /**
     * установить commentNotifyFlag
     * @param int $value
     * @return int 
     */
    public function setCommentNotifyFlag($value) {
        $this->commentNotifyFlag = $value;
        return $this;
    }

    /**
     * взять commentNotifyFlag
     * @return string 
     */
    public function getAdditionalInfo() {
        return $this->additionalInfo;
    }

    /**
     * установить additionalInfo
     * @param string $value
     * @return string 
     */
    public function setAdditionalInfo($value) {
        $this->additionalInfo = $value;
        return $this;
    }

    /**
     * взять количество
     * @return int 
     */
    public function getLastEventCount() {

        $db = Zend_Registry::get('DBORDER');
        $query = $db->select();
        $query->from('orders_monitoring__events AS A', 'COUNT(A.id)');
        $query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->id);
        $query->where('A.id NOT IN (SELECT event_id FROM orders_monitoring__events_views WHERE user_id = ?)', $this->id);
        $res = intval($db->fetchOne($query));
        return $res;
    }

    /**
     * общее количество
     * @return int 
     */
    public function getTotalEventCount() {

        $db = Zend_Registry::get('DBORDER');
        $query = $db->select();
        $query->from('orders_monitoring__events AS A', 'COUNT(A.id)');
        $query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->id);
        $res = intval($db->fetchOne($query));
        return $res;
    }

    /**
     * количество за месяц
     * @return array 

     */
    public function getEventMon() {

        $db = Zend_Registry::get('DBORDER');
        $query = $db->select();
        $query->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
        $query->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
        $query->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));

        $query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->id);

        $query->where('A.date_created >=?', time() - 60 * 60 * 24 * 30);
        $res = count($db->fetchAll($query));
        return $res;
    }

    /**
     * количество за год
     * @return array 
     */
    public function getEventYear() {

        $db = Zend_Registry::get('DBORDER');
        $query = $db->select();
        $query->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
        $query->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
        $query->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));

        $query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->id);

        $query->where('A.date_created >=?', time() - 60 * 60 * 24 * 365);
        $res = count($db->fetchAll($query));
        return $res;
    }

    /**
     * количество за неделю
     * @return array 
     */
    public function getEventWeek() {

        $db = Zend_Registry::get('DBORDER');
        $query = $db->select();
        $query->from('orders_monitoring__events AS A', new Zend_Db_Expr('A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
        $query->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
        $query->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type, C.id AS event_type_id'));

        $query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->id);

        $query->where('A.date_created >=?', time() - 60 * 60 * 24 * 7);
        $res = count($db->fetchAll($query));
        return $res;
    }

    /**
     * события за типом
     * @param int $type_id тип собития
     * @return array 
     */
    public function getEventId($type_id) {
        $db = Zend_Registry::get('DBORDER');
        $query = $db->select('id');
        $query->from('orders_monitoring__events AS A');
        $query->where('A.type_id =?', $type_id);
        $query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->id);
        $res = $db->fetchAll($query);
        return $res;
    }

    /**
     * количество за типом
     * @param int $type_id тип собития
     * @return array 
     */
    public function getEventCount($type_id) {

        $db = Zend_Registry::get('DBORDER');
        $query = $db->select();
        $query->from('orders_monitoring__events AS A', 'COUNT(A.id)');
        $query->where('A.type_id =?', $type_id);
        $query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $this->id);
        $res = intval($db->fetchOne($query));
        return $res;
    }

    /**
     * все события
     * @return array 
     */
    public function getTotalEvent() {

        $db = Zend_Registry::get('DBORDER');
        $query = $db->select();
        $query->from('orders_monitoring__events');
        //     $query->from('orders_users__kontragents  AS B');
        $query->where('kontragent_id = ?', $this->id);
        echo $query->__toString();
        //   exit();
        $res = $db->fetchAll($query);
        return $res;
    }

    /**
     * Constructor.
     * @param string $key - name of key for user load, range of id|login|email.
     * if null (default) - user data don't loading.
     * @param string $val - key value
     * @return void
     * @author Artem Sukharev
     */
    public function __construct($key = null, $val = null) {
        parent::__construct('orders_users__accounts', array(
            'id' => 'id',
            'login' => 'login',
            'name' => 'name',
            'site' => 'site',
            'status' => 'status',
            'second_name' => 'secondName',
            'third_name' => 'thirdName',
            'gender' => 'gender',
            'from' => 'from',
            'email' => 'email',
            'password' => 'password',
            'new_password' => 'newPassword',
            'last_access_date' => 'lastAccessDate',
            'create_date' => 'createDate',
            'phone' => 'phone',
            'subscribe_flag' => 'subscribeFlag',
            'vipiska_notify_flag' => 'vipiskaNotifyFlag',
            'parent_user' => 'parent_user',
            'dogovor_notify_flag' => 'dogovorNotifyFlag',
            'organization' => 'organization',
            'innogrn' => 'innogrn',
            'position' => 'position',
            'innogrn2' => 'innogrn2',
            'dolj' => 'dolj',
            'df' => 'df',
            'di' => 'di',
            'do' => 'do',
            'doljr' => 'doljr',
            'dfr' => 'dfr',
            'dir' => 'dir',
            'dor' => 'dor',
            'dn' => 'dn',
            'dot' => 'dot',
            'akt_email' => 'akt_email',
            'company_profile' => 'companyProfile',
            'akt_notify_flag_report' => 'aktNotifyFlagReport',
            'akt_notify_flag_base' => 'aktNotifyFlagBase',
            'akt_notify_flag_monitoring' => 'aktNotifyFlagMonitoring',
            'akt_notify_flag_ved' => 'aktNotifyFlagVed',
            'use_monitoring' => 'useMonitoring',
            'use_base' => 'useBase',
            'use_report' => 'useReport',
            'use_ved' => 'useVed',
            'use_sms' => 'useSms',
            'date_monitoring' => 'dateMonitoring',
            'date_base' => 'dateBase',
            'date_report' => 'dateReport',
            'block_monitoring' => 'blockMonitoring',
            'block_base' => 'blockBase',
            'block_report' => 'blockReport',
            'block_ved' => 'blockVed',
            'block_sms' => 'blockSms',
            'is_blocked' => 'isBlocked',
            'dogovor_created' => 'dogovorCreated',
            'is_deleted' => 'isDeleted',
            'balans' => 'balans',
            'akt_send_email' => 'akt_send_email',
            'akt_send_kurator' => 'akt_send_kurator',
            'hash' => 'hash',
            'country' => 'country',
            'monitoring_tarif_skidka' => 'monitoringTarifSkidka',
            'uraddress' => 'uraddress',
            'vipiska_email' => 'vipiskaEmail',
            'mon_test_period' => 'mon_test_period',
            'court' => 'court_mail',
            'egrul' => 'egrul_mail',
            'bankruptcy' => 'bank_mail',
            'sckode' => 'sckode',
            'kredit' => 'kredit',
            'date_kredit' => 'date_kredit',
            'mon_demo' => 'mon_demo',
            'end_mon_demo' => 'end_mon_demo',
            'save_pay' => 'save_pay',
        	'password_sip' => 'password_sip'
        ));
        /**
         *
         */
        if ($key !== null) {
            if (!is_array($key)) {
                $this->pkColName = $key;
                $this->loadByPk($val);
            } else {
                $this->load($key);
            }
        } else {
            $this->pkColName = 'id';
        }
        $this->enddate_mon_demo = date('d-m-Y', $this->end_mon_demo);
    }

    public function getMonitoringTarifSkidkaFormatted() {
        return '<input style="width:50px;" type=text name="' . AK_Common_Functions::generatePassword() . '" value="' . intval($this->monitoringTarifSkidka) . '" id="mts' . $this->id . '" /> % <a onclick="document.location.href = \'/admin/orders/userskidka/id/' . $this->id . '/sk/\'+document.getElementById(\'mts' . $this->id . '\').value+\'/\'" style="color:blue;" href="javascript:void(0)">Сохранить</a>';
    }

    public function getServicesString() {
        $res = '';
        if ($this->useBase) {
            if ($this->blockBase) {
                $res.='<font color=red>Б</font> ';
            } else {
                $res.='Б ';
            }
        }
        if ($this->useReport) {
            if ($this->blockReport) {
                $res.='<font color=red>О</font> ';
            } else {
                $res.='О ';
            }
        }
        if ($this->useMonitoring) {
            if ($this->blockMonitoring) {
                $res.='<font color=red>M</font> ';
            } else {
                $res.='М ';
            }
        }
        if ($this->useSms) {
            if ($this->blockSms) {
                $res.='<font color=red>С</font> ';
            } else {
                $res.='С ';
            }
        }
        if ($this->useVed) {
            if ($this->blockVed) {
                $res.='<font color=red>В</font> ';
            } else {
                $res.='В ';
            }
        }
        return $res;
    }

    public function getServicesStringAdmin() {
        $res = '';
        if ($this->useBase) {
            if ($this->blockBase) {
                $res.='<a href="/admin/orders/serviceblock/id/' . $this->id . '/s/base/"><font color=red>Б</font></a> ';
            } else {
                $res.='<a href="/admin/orders/serviceblock/id/' . $this->id . '/s/base/"><font color=green>Б</font></a> ';
            }
        }
        if ($this->useReport) {
            if ($this->blockReport) {
                $res.='<a href="/admin/orders/serviceblock/id/' . $this->id . '/s/report/"><font color=red>О</font></a> ';
            } else {
                $res.='<a href="/admin/orders/serviceblock/id/' . $this->id . '/s/report/"><font color=green>О</font></a> ';
            }
        }
        if ($this->useMonitoring) {
            if ($this->blockMonitoring) {
                $res.='<a href="/admin/orders/serviceblock/id/' . $this->id . '/s/monitoring/"><font color=red>M</font></a> ';
            } else {
                $res.='<a href="/admin/orders/serviceblock/id/' . $this->id . '/s/monitoring/"><font color=green>М</font></a> ';
            }
        }
        if ($this->useSms) {
            if ($this->blockSms) {
                $res.='<a href="/admin/orders/serviceblock/id/' . $this->id . '/s/sms/"><font color=red>C</font></a> ';
            } else {
                $res.='<a href="/admin/orders/serviceblock/id/' . $this->id . '/s/sms/"><font color=green>C</font></a> ';
            }
        }
        if ($this->useVed) {
            if ($this->blockVed) {
                $res.='<a href="/admin/orders/serviceblock/id/' . $this->id . '/s/ved/"><font color=red>В</font></a> ';
            } else {
                $res.='<a href="/admin/orders/serviceblock/id/' . $this->id . '/s/ved/"><font color=green>В</font></a> ';
            }
        }
        return $res;
    }

    public function getOrdersService($orders_all = '', $sort_service = '') {
        $orders = array();

        foreach ($orders_all as $o) {
            $service_idd = $o->getServisSelect();
            if ($service_idd->id != $sort_service)
                continue;
            $orders[] = $o;
        }

        return $orders;
    }

    public function getSavePay($money_type = '', $pay_variant = '') {
        $_db = Zend_Registry :: get('DBORDER');

        $new_save_settings = array(
            '1' => $money_type,
            '2' => $pay_variant,
        );

        $set = array(
            'save_pay' => serialize($new_save_settings),
        );

        $where = $_db->quoteInto('id = ?', $this->id);
        $rows_affected = $_db->update("orders_users__accounts", $set, $where);
    }

    public function getOrders($type = '', $status = '', $id = '') {
        $_db = Zend_Registry :: get('DBORDER');

        // $sql = $_db->select()->distinct()->from('orders_relations', 'order_id')->where('user_id = ?', $this->id);
        $sql = $_db->select()->distinct()->from('orders_relations', 'order_id')->where('user_id = ?', $this->id);
        //var_dump($sql);
        if (!empty($type)) {
            if ($type == 'plus') {
                $sql->where('zakaz_subtype_id = ?', AK_Order_ZakazTypes::OPERATIONS_BALANS);
            } elseif ($type == 'minus') {
                $sql->where('zakaz_subtype_id <> ?', AK_Order_ZakazTypes::OPERATIONS_BALANS);
            }
        }

        $sql->order('order_id DESC');

        $res = $_db->fetchCol($sql);
        $orders = array();
        foreach ($res as $k => $v) {

            $o = new AK_Order_Item('id', $v);
            if (!empty($o->id)) {
                //Zend_Debug::dump($res);  
                if (!empty($id))
                    if ($o->number != $id)
                        continue;
                if (!empty($type)) {
                    if ($type == 'plus') {
                        if (!empty($status))
                            if ($o->status != $status)
                                continue;
                        //  if ($o->status >= AK_Order_OrderStatus::READY) {
                        $orders[] = $o;
                        // }
                    } else {
                        if (!empty($status))
                            if ($o->status != $status)
                                continue;
                        $orders[] = $o;
                    }
                } else {

                    if (!empty($status))
                        if ($o->status != $status)
                            continue;

                    $orders[] = $o;
                }

                //
            }
        }
        return $orders;
    }

    public function getDoc($type = '', $status = '', $id = '') {
        $orders = array();
        //Zend_Debug::dump("get Doc enter");
        if ($type == 0) {
            //Zend_Debug::dump("type = 0 if enter");
            if ($this->useMonitoring) {
                //Zend_Debug::dump("usemonitor if enter");
                $orders[] = new AK_Order_Dogovor(AK_Order_ZakazTypes::MONITORING, $this); //тут ошибка
            }
            if ($this->useReport) {
                //Zend_Debug::dump("usereport if enter");
                $orders[] = new AK_Order_Dogovor(AK_Order_ZakazTypes::CONTRAGENT_CHECK, $this);
            }
            if ($this->useBase) {
                //Zend_Debug::dump("usebase if enter");
                $orders[] = new AK_Order_Dogovor(AK_Order_ZakazTypes::BASES, $this);
            }
            if ($this->useSms) {
                //Zend_Debug::dump("usebase if enter");
                $orders[] = new AK_Order_Dogovor(AK_Order_ZakazTypes::SMS, $this);
            }
            //Zend_Debug::dump("type = 0 if exit");
        } else {
            //Zend_Debug::dump("get Doc else");	
            $_db = Zend_Registry :: get('DBORDER');
            //Zend_Debug::dump("get Doc db get");	//exit();
            // $sql = $_db->select()->distinct()->from('orders_relations', 'order_id')->where('user_id = ?', $this->id);
            $sql = $_db->select()->distinct()->from('orders_relations', 'order_id')->where('user_id = ?', $this->id);

            if (!empty($type)) {
                if ($type == 2) {
                    $sql->where('zakaz_subtype_id = ?', AK_Order_ZakazTypes::OPERATIONS_BALANS);
                } elseif ($type == 1) {
                    $sql->join('orders', $_db->quoteInto('order_id = orders.id  AND orders.status IN (?)', AK_Order_OrderStatus::getPayedList()), '');
                    //$sql->where('orders.status = '.AK_Order_ZakazStatus:: AK_Order_ZakazTypes::OPERATIONS_BALANS);
                    $sql->where('zakaz_subtype_id <> ?', AK_Order_ZakazTypes::OPERATIONS_BALANS);
                    $sql->where('zakaz_subtype_id <> ?', AK_Order_ZakazTypes::MONITORING_TARIF);
                }
            }

            $sql->order('order_id DESC');
            //print $sql;
            $res = $_db->fetchCol($sql);

            foreach ($res as $k => $v) {

                $o = new AK_Order_Item('id', $v);
                if (!empty($o->id)) {
                    //Zend_Debug::dump($res);  		
                    if (!empty($id))
                        if ($o->number != $id)
                            continue;
                    if (!empty($type)) {
                        if ($type == 2) {

                            if (!empty($status))
                                if ($o->status != $status)
                                    continue;

                            // if ($o->getMoney()->id)
                            // continue;
                            if ($o->getMoney()->type_pay == 1)
                            //if ($o->status >= AK_Order_OrderStatus::READY) {
                                $orders[] = $o;
                            //		}
                        } else {

                            if (!empty($status))
                                if ($o->status != $status)
                                    continue;

                            $orders[] = $o;
                        }
                    } else {

                        if (!empty($status))
                            if ($o->status != $status)
                                continue;

                        $orders[] = $o;
                    }
                }
            }
            if ($type == 1) {
                $number = '';
                if ($this->status == 1) {
                    $number = unsigned_zerofill($this->id, 10) . '/';
                }
                else
                    $number = $this->innogrn . '/';

                for ($j = date('y', $this->dateMonitoring); $j <= date('y'); $j++)
                    for ($i = 1; $i <= 12; $i++) {
                        if ($j == date('y') && $i >= date('n')) {
                            break;
                            break;
                        }
                        $tarif = new AK_Order_User_Tarif_List();
                        $tarif->addWhere('A.user_id = ?', $this->id);
                        $tarif->addWhere('(A.start_date <= ' . mktime(0, 0, 0, $i + 1, 0, $j) . ' and A.end_date_user >= ' . mktime(0, 0, 0, $i, 1, $j) . ')');

                        $tarifs = $tarif->getList();
                        if (count($tarifs) > 0) {
                            $price = 0;
                            foreach ($tarifs as $tar) {
                                $cou = 0;
                                for ($k = $tar->startDate; $k <= $tar->endDateUser; $k = mktime(0, 0, 0, date('m', $k), date('d', $k) + $tar->period, date('Y', $k)))
                                    if ($k <= mktime(0, 0, 0, $i + 1, 0, $j) && $k >= mktime(0, 0, 0, $i, 1, $j))
                                        $cou++;
                                //print $cou.'-'.$tar->count.'-'.$tar->price_one.'='.$cou*$tar->count*$tar->price_one.'<br>';
                                $price += $cou * $tar->count * $tar->price_one;
                            }
                            if ($price > 0) {
                                $doc = new AK_Order_Doc(AK_Order_ZakazTypes::MONITORING);
                                $doc->number = $number . '' . unsigned_zerofill($i, 2) . '' . $j;
                                $doc->url = '/users/akt/id/m/y/' . $j . '/m/' . $i;
                                $doc->dateUpdated = mktime(0, 0, 0, $i + 1, 0, $j);
                                $doc->price = $price;
                                $orders[] = $doc;
                            }
                        }
                        //	print $j.'.'.$i.'-'.count($tarifs).'<br>';
                    }
            }
        }
        //Zend_Debug::dump("orders user exit");
        return $orders;
    }

    public function getPayedOrders($type = '', $status = '', $id = '') {
        $_db = Zend_Registry :: get('DBORDER');

        $sql = $_db->select()->distinct()->from(array('A' => 'orders_relations'), 'A.order_id')
                        ->joinInner(array('B' => 'orders'), $_db->quoteInto('B.id = A.order_id AND B.status IN (?)', AK_Order_OrderStatus::getPayedList()), null)
                        ->where('A.user_id = ?', $this->id)->order('order_id DESC');
        if (!empty($status))
            $sql->where('B.status = ?', $status);
        if (!empty($id))
            $sql->where('B.number = ?', $id);
        //$sql = $_db->select()->distinct()->from(array('A'=>'orders'), 'A.id')
        // ,$_db->quoteInto('B.id = A.order_id AND B.status IN (?)',AK_Order_OrderStatus::getPayedList()), null)
        // ->where('A.user_id = ?', $this->id)->where('A.status IN (?)',AK_Order_OrderStatus::getPayedList())->order('order_id DESC');

        if (!empty($type)) {
            if ($type == 'plus') {
                $sql->where('A.zakaz_subtype_id = ?', AK_Order_ZakazTypes::OPERATIONS_BALANS);
            } elseif ($type == 'minus') {
                $sql->where('A.zakaz_subtype_id <> ?', AK_Order_ZakazTypes::OPERATIONS_BALANS);
            }
        }

        $res = $_db->fetchCol($sql);
        $orders = array();
        foreach ($res as $k => $v) {
            if (!empty($v))
                $orders[] = new AK_Order_Item('id', $v);
        }
        return $orders;
    }

    public function getOrdersBase($status = '', $id = '') {
        $_db = Zend_Registry :: get('DBORDER');

        $sql = $_db->select()->distinct()->from('orders_relations', 'order_id')->where('zakaz_type_id = ?', AK_Order_ZakazTypes::BASES)->where('user_id = ?', $this->id)->order('order_id DESC');

        $res = $_db->fetchCol($sql);
        $orders = array();
        foreach ($res as $k => $v) {
            $o = new AK_Order_Item('id', $v);
            if (!empty($status))
                if ($o->status != $status)
                    continue;
            if (!empty($id))
                if ($o->number != $id)
                    continue;
            $orders[] = $o;
        }
        return $orders;
    }

    public function getOrdersBaseCount() {
        $_db = Zend_Registry :: get('DBORDER');

        $sql = $_db->select()->distinct()->from('orders_relations', 'order_id')->where('zakaz_type_id = ?', AK_Order_ZakazTypes::BASES)->where('user_id = ?', $this->id);

        return count($_db->fetchCol($sql));
    }

    public function getOrdersMonitoring($status = '', $id = '') {
        $_db = Zend_Registry :: get('DBORDER');

        $sql = $_db->select()->distinct()->from('orders_relations', 'order_id')->where('zakaz_type_id = ?', AK_Order_ZakazTypes::MONITORING)->where('user_id = ?', $this->id)->order('order_id DESC');

        $res = $_db->fetchCol($sql);
        $orders = array();
        foreach ($res as $k => $v) {

            $o = new AK_Order_Item('id', $v);
            if (!empty($status))
                if ($o->status != $status)
                    continue;
            if (!empty($id))
                if ($o->number != $id)
                    continue;
            $orders[] = $o;
        }

        //Zend_Debug::dump($orders);exit();

        return $orders;
    }

    public function getOrdersMonitoringCount() {
        $_db = Zend_Registry :: get('DBORDER');

        $sql = $_db->select()->distinct()->from('orders_relations', 'order_id')->where('zakaz_type_id = ?', AK_Order_ZakazTypes::MONITORING)->where('user_id = ?', $this->id);

        return count($_db->fetchCol($sql));
    }

    public function getOrdersReport($status = '', $id = '') {
        $_db = Zend_Registry :: get('DBORDER');

        $sql = $_db->select()->distinct()->from('orders_relations', 'order_id')->where('zakaz_type_id = ?', AK_Order_ZakazTypes::CONTRAGENT_CHECK)->where('user_id = ?', $this->id)->order('order_id DESC');

        $res = $_db->fetchCol($sql);
        $orders = array();
        foreach ($res as $k => $v) {
            $o = new AK_Order_Item('id', $v);
            if (!empty($status))
                if ($o->status != $status)
                    continue;
            if (!empty($id))
                if ($o->number != $id)
                    continue;
            $orders[] = $o;
        }
        return $orders;
    }

    public function getOrdersReportCount() {
        $_db = Zend_Registry :: get('DBORDER');

        $sql = $_db->select()->distinct()->from('orders_relations', 'order_id')->where('zakaz_type_id = ?', AK_Order_ZakazTypes::CONTRAGENT_CHECK)->where('user_id = ?', $this->id);

        return count($_db->fetchCol($sql));
    }

    /**
     * Устанавливает http адрес для пользователя
     * @return void
     */
    public function setUserPath() {

        if ($this->UserPath === null) {
            $this->UserPath = SITE_URL . '/users/';
        }
    }

    /**
     * Возвращает http адрес для пользователя
     * @return string
     */
    public function getUserPath($action = null, $withslash = true) {
        if ($this->UserPath === null) {
            $this->setUserPath();
        }
        if ($action !== null) {
            if ($this->isUsedNamedPath == false) {
                return ($withslash) ? $this->UserPath . $action . '/userid/' . $this->id . '/' : $this->UserPath . $action . '/userid/' . $this->id;
            } else {
                return ($withslash) ? $this->UserPath . $action . '/' : $this->UserPath . $action;
            }
        } else {
            return $this->UserPath;
        }
    }
    /**
     * обновить дату входа
     * @return string
     */
    public function updateLastAccessDate() {
        $query = $this->_db->quoteInto('UPDATE orders_users__accounts SET last_access_date = ' . time() . ' WHERE id = ?', $this->id);
        $this->_db->query($query);
    }

    public function isAuthenticated() {
        return (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== null) ? true : false;
    }

    /**
     * Аутентификация пользователя
     * @author Artem Sukharev
     */
    public function authenticate() {
        $_SESSION['user_id'] = $this->id;
    }

    /**
     * Завершение сессии пользователя
     * @author Artem Sukharev
     */
    public function logout() {
        unset($_SESSION['user_id']);
    }

    /**
     * Восстановление пароля
     */
    public function restorePassword() {
        
    }
    /**
     * обновления мыла пользователя
     * @params string $c, $e, $b
     */
    public function updateEmails($c, $e, $b) {
        $db = Zend_Registry::get('DBORDER');
        $id = $this->id;
        $query = "UPDATE orders_users__accounts SET  court = '$c',egrul = '$e', bankruptcy = '$b' WHERE id = $id";
        $db->query($query);
    }

    public static function validateLogin($login, $password) {
        $db = Zend_Registry::get('DBORDER');
        $select = $db->select();
        $select->from('orders_users__accounts', 'id')->where('is_deleted = 0')->where('is_blocked = 0')->where('login = ?', $login)->where("(new_password = '" . md5($password) . "' OR password = ?)", md5($password));
        $res = $db->fetchOne($select);
        return (boolean) $res;
    }

    public static function isUserExists($key, $value, $exclude = null) {
        $db = Zend_Registry::get('DBORDER');
        if (!in_array($key, array(
                    'id',
                    'login',
                    'email'))) {
            return false;
        }
        $select = $db->select();
        $select->from('orders_users__accounts', 'count(id) as count')->where($key . ' = ?', $value);
        //->where('status != ?', 'deleted');
        if ($exclude !== null) {
            $select->where($key . ' NOT IN (?)', $exclude);
        }
        $res = $db->fetchOne($select);
        return (boolean) $res;
    }

    public function getFio() {
        $res = $this->secondName . ' ' . $this->name . ' ' . $this->thirdName;
        if ($this->isBlocked) {
            $res = '<font color=red>' . $res . '<font>';
        }
        return $res;
    }

    public function getAktNotifyFlagAsYesno() {
        if (!empty($this->aktNotifyFlag)) {
            return "<font color=green>Да</font>";
        } else {
            return "<font color=red>Нет</font>";
        }
    }

    public function getSubscribeFlagAsYesno() {
        if (!empty($this->subscribeFlag)) {
            return "<font color=green>Да</font>";
        } else {
            return "<font color=red>Нет</font>";
        }
    }

    public function getVipiskaNotifyFlagAsYesno() {
        if (!empty($this->vipiskaNotifyFlag)) {
            return "<font color=green>Да</font>";
        } else {
            return "<font color=red>Нет</font>";
        }
    }

    public function getAdditionalInfoTruncated() {
        $result = $this->additionalInfo;
        if (mb_strlen($result, 'utf-8') > 250) {
            $result = mb_substr($result, 0, 250 - 3, 'utf-8') . '...';
        }
        return $result;
    }

}

function unsigned_zerofill($number, $length) {

    if (strlen($number) > $length)
        return;

    for ($i = 10, $j = 1;; $i *= 10, $j++) {

        if ($number < $i)
            return substr(pow(10, $length - $j), 1) . $number;
    }
}
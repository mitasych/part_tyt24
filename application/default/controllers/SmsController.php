<?php
class SmsController extends AK_Controller_Action {

    public $currentUser;
    public $params;

    public function __construct (Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);
        $this->currentUser = $this->_user;
        $this->view->currentUser = $this->currentUser;
        $this->params = $this->_getAllParams();

        if (!$this->currentUser->getLogin() ) {
        	$this->_redirect(SITE_URL);
        }
        
        if ($this->currentUser->id != $this->_user->id ) {
        	$this->_redirect(SITE_URL);
        }
    }
    
    public function indexAction () {
    	include_once('sms/action.index.php');
    }
    
    public function addressBookAction () {
    	include_once('sms/action.address_book.php');
    }
    
    public function addressBookAddAction () {
    	include_once('sms/action.address_book_add.php');
    	$this->render('address-book-edit');
    }
    
    public function addressBookEditAction () {
    	include_once('sms/action.address_book_edit.php');
    }
    
    public function addressBookDelAction() {
        $req = $this->_request;
        $id = $req->getParam('id');
        $oper = $req->getParam('oper');
        
        $obj = new AK_Order_Sms_DbTable_AddressBook();
        if ($oper == 'del') {
            $where = $this->_db->quoteInto('id = ?',$id);
            $obj->delete($where);
        }
        
    }
    
    public function checkingTplAction () {
        $req = $this->_request;
        $id_tpl = $req->getParam('id_tpl');
        
        $obj = new AK_Order_Sms_DbTable_AddressBook($this->_user->id);
        $row_tpl = $obj->getTpl($id_tpl);
        $text_tpl = $row_tpl[0]['text_tpl'];
        
        $this->_helper->json(array('tpl' => $text_tpl));
    }
    
    public function smsTplAction () {
    	include_once('sms/action.sms_tpl.php');
    }
    
    public function smsTplAddAction () {
    	include_once('sms/action.sms_tpl_add.php');
    	$this->render('sms-tpl-edit');
    }
    
    public function smsTplEditAction () {
    	include_once('sms/action.sms_tpl_edit.php');
    }
    
    public function primerTplAction () {
    	$req = $this->_request;
    	$msg = $req->getParam('msg');
    	$id_contact = $req->getParam('id_contact');
    	
    	if (!empty($id_contact)) {
    		$id = $id_contact;
    	}
    	else {
    		$id = 1;
    	}
    	$obj = new AK_Order_Sms_DbTable_AddressBook();
    	$def_contact = $obj->getAll($id);
    	
    	$name = $def_contact[0]['name'];
    	$surname = $def_contact[0]['surname'];
    	$first_name = $def_contact[0]['first_name'];
    	$mobile_phone = $def_contact[0]['mobile_phone'];
    	$balans = $def_contact[0]['balans'];
    	$org = $def_contact[0]['org'];
    	
    	$order = array('{Имя}','{Фамилия}','{Отчество}','{Телефон}','{Сумма}','{Организация}');
    	$replace = array($name,$surname,$first_name,$mobile_phone,$balans,$org);
    	
    	$newmsg = str_replace($order, $replace, $msg);
    	
    	$this->_helper->json(array('msg_c' => $newmsg));
    }
    
    public function addrBookGridAction () {
        $obj = new AK_Order_Sms_DbTable_AddressBook($this->_user->id);
       
        $req = $this->_request;
        $curPage = $req->getParam('page','');//print_r($curPage);echo "<br>";
        $rowsPerPage = $req->getParam('rows','');//print_r($rowsPerPage);echo "<br>";
        $sortingField = $req->getParam('sidx','');//print_r($sortingField);echo "<br>";
        $sortingOrder = $req->getParam('sord','');//print_r($sortingOrder);echo "<br>";
       //$sex = $req->getParam('sex','');
        $filter = $req->getParam('filters');
        //поиск
        $search = $req->getParam('search_mask','');
        //поиск toolbar
//         if($_POST['_search'] == true){
//             print_r($this->json2array($filter));
//         }
        
        $get = $req->getParam('get');
        
        $grid_data = array(	'page' => $curPage,
        		'rows' => $rowsPerPage,
        		'sidx' => $sortingField,
        		'sord' => $sortingOrder,
                'search' => $search,
        );
        
        //$date = strtotime($this->params['add_date']);
        //$date2 = mktime('26.11.2012'); print_r($date2); echo "<br>";
        $search_data = array(
        		's_id' => $this->params['id'],
        		's_name' => $this->params['name'],
        		's_surname' => $this->params['surname'],
        		's_lastname' => $this->params['last_name'],
        		's_org' => $this->params['org'],
        		's_position' => $this->params['position'],
        		's_mobile_phone' => $this->params['mobile_phone'],
        		's_phone_number' => $this->params['phone_number'],
        		's_balans' => $this->params['balans'],
        		's_sex' => $this->params['sex'],
        		's_status' => $this->params['status'],
        		's_email' => $this->params['email'],
        		's_fax' => $this->params['fax'],
        		's_add_date' => $this->params['add_date']
        
        );
        //Zend_Debug::dump($grid_data);
        $addr = $obj->getAll(); //Zend_Debug::dump($addr);
        $totalRows = count($addr);//Zend_Debug::dump($totalRows);
        
        $addr_to_grid = $obj->getAll('',$grid_data, $search_data);
        
        //Zend_Debug::dump($addr_to_grid);
        //сохраняем номер текущей страницы, общее количество страниц и общее количество записей
        $response->page = $curPage;
        $response->total = ceil($totalRows / $rowsPerPage);
        $response->records = $totalRows;
        
        $i=0;
        foreach ($addr_to_grid as $key => $address) {
            
            if ($address['favorites'] == 1) {
            	$favorites = '<span style="display:block" class="favorites-star" id="f_' . $address['id'] . '" onClick="$(\'#infor\').hide(); favor(0,' . $address['id'] . ')" onmouseover="$(\'#info_favor\').show();"
            onmouseout="$(\'#info_favor\').hide();"><span>';
            } else {
            	$favorites = '<span style="display:block" class="nofavorites-star" id="f_' . $address['id'] . '"  onClick="$(\'#infor\').hide(); favor(1,' . $address['id'] . ')"  onmouseover="$(\'#info_favor1\').show();"
             onmouseout="$(\'#info_favor1\').hide();"><span>';
            }
            
        	$response->rows[$i]['id']=$address['id'];
        	$response->rows[$i]['cell']=array(
        	        '' . $favorites . '',
        			$address['id'],
        			$address['surname'],
        	        $address['name'],
        			$address['first_name'],
        	        $address['sex'],
        	        $address['status'],
        			$address['org'],
        			$address['position'],
        			$address['mobile_phone'],
        			$address['balans'],
        	        $address['email'],
        	        $address['fax'],
        	        $address['phone_number'],
        	        $address['add_date']*1000,
					'<a onClick="editRow('.$address['id'].');return false;" href="#" data='.$address['id'].'><img src="/images/edit.png" title="Редактировать" /></a><a href="#" data='.$address['id'].' onClick="deleteRow('.$address['id'].');return false;"><img src="/images/delete_company.png" title="Удалить" /></a>'
        	        );
        	$i++;
        }
        $this->_helper->json($response);
//         echo Zend_Json::encode($response);
//         exit;
    }
    
    public function addrBookGridEditAction () {
    	$obj = new AK_Order_Sms_DbTable_AddressBook($this->_user->id);
    	
    	$req = $this->_request;
    	$examp = $_GET["get"]; //query number
    	
    	$id = $req->getParam('rowid');
    	
    	$row_addr = $obj->getAll($id);

//     	$s = "<table><tbody>";
//     	$s .= "<tr><td><b>Имя</b></td><td>".$row_addr[0]["name"]."</td></tr>";
//     	$s .= "<tr><td><b>Фамилия</b></td><td>".$row_addr[0]["surname"]."</td></tr>";
//     	$s .= "<tr><td><b>Отчество</b></td><td>".$row_addr[0]["first_name"]."</td></tr>";
//     	$s .= "<tr><td><b>Организация</b></td><td>".$row_addr[0]["org"]."</td></tr>";
//     	$s .= "<tr><td><b>Должность</b></td><td>".$row_addr[0]["position"]."</td></tr>";
//     	$s .= "<tr><td><b>Модильный телефон</b></td><td>".$row_addr[0]["mobile_phone"]."</td></tr>";
//     	$s .= "<tr><td><b>Баланс</b></td><td>".$row_addr[0]["balans"]."</td></tr>";
//     	$s .= "</tbody></table>";
    	
    	if($row_addr[0]["status"] == 1)
    	{
    		$status = "физическое лицо";
    	}
    	elseif($row_addr[0]["status"] == 2)
    	{
    		$status = "юредическое лицо";
    	}
    	
    	if($row_addr[0]["sex"] == 0)
    	{
    		$sex = "женский";
    	}
    	elseif($row_addr[0]["sex"] == 1)
    	{
    		$sex = "мужской";
    	}
    	
    	$b = "<div>";
    	$b .= "<p><b>Тип лица: </b>".$status."</p>";
    	$b .= "<p><b>Пол: </b>".$sex."</p>";
    	$b .= "<p><b>Номер телефона: </b>".$row_addr[0]["phone_number"]."</p>";
    	$b .= "<p><b>Факс: </b>".$row_addr[0]["fax"]."</p>";
    	$b .= "<p><b>E-mail: </b>".$row_addr[0]["email"]."</p>";
    	$b .= "<p><b>Дата добавления: </b>".$row_addr[0]["add_date"]."</p></div>";
    	echo $b;
    	exit;
//     	$response->rows[0]['cell']=array(
//     	       			$b,);
        //$this->_helper->json($b);
    }
    
    protected function json2array($json)
    {
    	$json_array = false;
    	$json = substr($json, 1, -1);
    	$json = str_replace(array(":", "{", "[", "}", "]"), array("=>", "array(", "array(", ")", ")"), $json);
    	@eval("\$json_array = array({$json});");
    	return $json_array;
    }
}
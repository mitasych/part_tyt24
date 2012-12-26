<?php

$this->params= $this->getRequest()->getParams();

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;  
$currentItem = new AK_Order_Pay_Item($this->params['id']);
$ListPay = new AK_Order_Pay_ListIk();



//$this->view->ListPay = $ListPay->returnAsAssoc(true)->getList();
//$ListPay->setGroup('A.name');
$this->view->ListPay = $ListPay->getList(1);

$ListPay2 = new AK_Order_Pay_ListType();
$this->view->ListPay2 = $ListPay2->getList();
/*
$dom = new DomDocument();
$dom->load("paysystems.currencies.export.xml");
$res = simplexml_import_dom($dom);
//print ($res->paysystems);
$ListPay3 = array();
foreach($res->paysystem as $paysystem)
{
	//print $paysystem['alias'].'<br>';
	if ($paysystem['state'])
		$ListPay3[(string) $paysystem['alias']] = (string) $paysystem.' / '.(string)$paysystem['currencyName'];
}
$this->view->ListPay3 = $ListPay3;*/
//print_r($ListPay3);
// так
/*$titles = $dom->getElementsByTagName("title");
foreach ($titles as $node) {
    echo $node->textContent . "\n";
}

// или так
foreach ($dom->documentElement->childNodes as $articles) {
    // если это элемент (nodeType == 1) и его имя "item", запускаем цикл
    if ($articles->nodeType == 1 && $articles->nodeName == "item") {
        foreach ($articles->childNodes as $item) {
            // если это элемент и его имя "title", выводим его
            if ($item->nodeType == 1 && $item->nodeName == "title") {
                echo $item->textContent . "\n";
            }
        }
    }
}*/

/*
$dom  = new domDocument('1.0'); 
    
        // $path = $.$file_array[path_to_films1];
         $dom->load('/paysystems.currencies.export.xml');
//$xml = domxml_open_file('http://www.interkassa.com/lib/paysystems.currencies.export.php?format=xml');

$root = $dom->document_element(); 
$nodes = $root->child_nodes(); 

foreach($nodes as $node) {
	print $node->get_content();
}*/
$userStatusArray = unserialize($currentItem->user_status);

if($userStatusArray['1']=="1"){ $currentItem->StatusUser1 = "checked"; }
if($userStatusArray['2']=="2"){ $currentItem->StatusUser2 = "checked"; }
if($userStatusArray['3']=="3"){ $currentItem->StatusUser3 = "checked"; }


$currentItem->active = empty($currentItem->active)?0:'checked';
$form = new AK_Form('editItem', 'post', MODULE_URL.'/orders/pay.add/');
$form->addRule('title', 'required', 'Введите название');
//$form->addRule('code', 'required', 'Введите код');

if ($form->isPostback()){
  $form->setDefaults($this->params);  
}

if ($form->validate($this->params)){
    
    $this->params['active'] = empty($this->params['active'])?0:1;
    $this->params['deleteImage'] = empty($this->params['deleteImage'])?0:1;
	
	if ($this->params['deleteImage']) {
        if ($currentItem->image && file_exists(UPLOAD_PATH."/pay/".$currentItem->image)) {
            @unlink (UPLOAD_PATH."/pay/".$currentItem->image)  ;
            $currentItem->image = '';
        }
    }
	

    $activStatusUser1 = $_POST['activStatusUser1'];
    if($activStatusUser1 ==""){$activStatusUser1 = "0";}
    $activStatusUser2 = $_POST['activStatusUser2'];
    if($activStatusUser2 ==""){$activStatusUser2 = "0";}
    $activStatusUser3 = $_POST['activStatusUser3'];
    if($activStatusUser3 ==""){$activStatusUser3 = "0";}

    $statusUser = array(
        "1" => $activStatusUser1,
        "2" => $activStatusUser2,
        "3" => $activStatusUser3
    );

    $currentItem->user_status = serialize($statusUser);
    $currentItem->title = $this->params['title'];
    $currentItem->text = $this->params['text'];
    //$currentItem->url_pay = $this->params['url_pay'];
    $currentItem->active = $this->params['active'];
    $currentItem->group = $this->params['group'];
    $currentItem->sale = $this->params['sale'];
    $currentItem->time = $this->params['time'];
    $currentItem->type_pay = $this->params['type_pay'];
	if ($currentItem->type_pay == 3)
	{
		$currentItem->url_sistem = $this->params['url_sistem'];
	}
	else
	{
		if ($currentItem->type_pay == 2)
			$currentItem->type = $this->params['type'];
	}
	$file_name=$currentItem->image;
    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
        list($width, $height, $type, $attr) = getimagesize($_FILES["image"]["tmp_name"]);

        if ($type == 1 || $type == 2 || $type == 3) {
		print $type;
            if ($currentItem->image && file_exists(UPLOAD_PATH."/pay/".$currentItem->image)) @unlink (UPLOAD_PATH."/pay/".$currentItem->image)  ;

            $file_name = AK_Common_Functions::generatePassword(10);
            $file_name.=$_FILES["image"]["name"];
            move_uploaded_file($_FILES["image"]["tmp_name"], UPLOAD_PATH."/pay/".$file_name);
        }

    }

    $currentItem->image = $file_name;
	
   // $currentItem->image = $this->params['image'];
    $currentItem->save();

    $this->_redirect(MODULE_URL.'/orders/pay/');
}

$this->view->form = $form;
$this->view->currentItem = $currentItem;


$this->view->BODY_CONTENT_FILE = "orders/pay.add.tpl";

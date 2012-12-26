<?php

$this->params= $this->getRequest()->getParams();

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;  
$currentItem = new AK_Order_Report($this->params['id']);
$ListContry = new AK_Order_Report_ListContry();

$this->view->ListContry = $ListContry->returnAsAssoc(true)->getList();

$typeList = array(
			'jur'=>'Юр. лицо',
			'ip'=>'ИП',
			'phys'=>'Физ. лицо',
			'egrp'=>'ЕГРП',
		);
$this->view->typeList = $typeList;

$form = new AK_Form('editItem', 'post', MODULE_URL.'/orders/reports.add/');
$form->addRule('title', 'required', 'Введите название');
//$form->addRule('code', 'required', 'Введите код');

if ($form->isPostback()){
  $form->setDefaults($this->params);  
}

if ($form->validate($this->params)){
    
	if (!empty($this->params['deleteImage'])) {
        if ($currentItem->img && file_exists(UPLOAD_PATH."/order/".$currentItem->img)) {
            @unlink (UPLOAD_PATH."/order/".$currentItem->img)  ;
            $currentItem->img = '';
        }
    }
    $currentItem->title = $this->params['title'];
    $currentItem->title_alter = $this->params['title_alter'];
    $currentItem->title_order = $this->params['title_order'];
    $currentItem->category = $this->params['category'];
    $currentItem->url = $this->params['url'];
    $currentItem->text_mini = $this->params['text_mini'];
    $currentItem->text = $this->params['text'];
    $currentItem->price = $this->params['price'];
    //$currentItem->price2 = $this->params['price2'];
    //$currentItem->price3 = $this->params['price3'];
    $currentItem->time = $this->params['time'];
	//$currentItem->time2 = $this->params['time2'];
    //$currentItem->time3 = $this->params['time3'];
    $currentItem->faq = $this->params['faq'];
    $currentItem->example_url = $this->params['example_url'];
    $currentItem->example_name = $this->params['example_name'];
    //$currentItem->country = $this->params['country'];
	//$currentItem->active = empty($this->params['active'])?0:1;
	$currentItem->order = empty($this->params['order'])?0:$this->params['order'];
	//$currentItem->flag1 = empty($this->params['flag1'])?0:1;
	$currentItem->flag2 = empty($this->params['flag2'])?0:1;
	$currentItem->flag3 = empty($this->params['flag3'])?0:1;
	$currentItem->active_company = empty($this->params['active_company'])?0:1;
// 	echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($this->params['main_page']); echo'</pre>';die;
	$currentItem->main_page = empty($this->params['main_page']) ? 0 : 1;
	$currentItem->report_menu = empty($this->params['report_menu']) ? 0 : 1;
	
	$file_name=$currentItem->img;
    if (is_uploaded_file($_FILES["img"]["tmp_name"])) {
		//print $_FILES["img"]["tmp_name"];
        list($width, $height, $type, $attr) = getimagesize($_FILES["img"]["tmp_name"]);

        if ($type == 1 || $type == 2 || $type == 3) {
		//print $type;
            if ($currentItem->img && file_exists(UPLOAD_PATH."/order/".$currentItem->img)) @unlink (UPLOAD_PATH."/order/".$currentItem->img)  ;

            $file_name = AK_Common_Functions::generatePassword(10);
            $file_name.=$_FILES["img"]["name"];
            move_uploaded_file($_FILES["img"]["tmp_name"], UPLOAD_PATH."/order/".$file_name);
        }

    }

    $currentItem->img = $file_name;

	$currentItem->type = $this->params['type'];
	
    $currentItem->save();

    $this->_redirect(MODULE_URL.'/orders/reports/');
}

$this->view->form = $form;
$this->view->currentItem = $currentItem;

$categoriesList = new AK_Menu_Link_List;
$categoriesList->addWhere("A.menu_id = '1'");
$this->view->categoriesList = $categoriesList->returnAsAssoc(true)->getList();

$this->view->BODY_CONTENT_FILE = "orders/reports.add.tpl";

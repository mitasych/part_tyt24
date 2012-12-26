<?php
if (empty ($_SESSION['menu_id']))
$_SESSION['menu_id']=$this->params['menu_id'];

switch ($this->getRequest()->getParam('menu_id'))
{
    case '1':

        $switchmenu = 'Левого меню';
        $_SESSION['menu_id']=1;
        break;
    case '2':
        $switchmenu = 'Нижнего меню';
        $_SESSION['menu_id']=2;
        break;
    case '3' :
        $switchmenu = 'Верхнего меню';
        $_SESSION['menu_id']=3;
        break;
}


$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;  
$currentItem = new AK_Menu_Link_Item($this->params['id']);
if (isset($this->params['menu_id'])) {
	
    $currentItem->setmenu_id(intval($this->params['menu_id']));
    
}

$categoriesList = new AK_Menu_List;

$form = new AK_Form('editItem', 'post', MODULE_URL.'/menu/link.add/');
$form->addRule('title', 'required', 'Введите заголовок');
$form->addRule('link', 'siteorabs', 'Введите корректную ссылку'); 
$form->addRule('queue', 'numeric', 'Введите корректный порядковый номер');

if ($form->isPostback()) {
    $this->params['isActive'] = empty($this->params['isActive'])?0:1;
    $this->params['isRed'] = 0;//empty($this->params['isRed'])?0:1;
    $this->params['isShow'] = empty($this->params['isShow'])?0:1;
    $this->params['isNote'] = empty($this->params['isNote'])?0:1;
    $this->params['deleteImage'] = empty($this->params['deleteImage'])?0:1;
    if(isset($this->params['view_pages'])){
    	$newViewPages = explode("\r\n", $this->params['view_pages']);
    	$recordViewPages = array();
    	foreach($newViewPages as $itemPage){
    		if (substr($itemPage, 0, 1) == '/'){
    			$recordViewPages['view'][] = $itemPage;
    		}
    		if (substr($itemPage, 0, 1) == '-'){
    			$recordViewPages['not_view'][] = substr($itemPage, 1);
    		}
    	}
    	
    	$this->params['view_pages'] = $recordViewPages;
    	if (isset($this->params['view_pages']['view']) && isset($this->params['view_pages']['not_view'])) {
    		$form->addRule('view_pages', 'onlyone', 'Можно ввести ИЛИ ТОЛЬКО страницы отображения, ИЛИ ТОЛЬКО страницы без отображения');
    	}
    }
    $form->setDefaults($this->params);
}


if ($form->validate($this->params)) {

    if ($this->params['deleteImage']) {
        if ($currentItem->image && file_exists(UPLOAD_PATH."/menu/".$currentItem->image)) {
            @unlink (UPLOAD_PATH."/menu/".$currentItem->image)  ;
            $currentItem->image = '';
        }
    }

    $currentItem->setTitle($this->params['title']);
    $currentItem->setLink($this->params['link']);
    
    $currentItem->setmenu_id($this->params['menu_id']);
    
    $currentItem->setQueue($this->params['queue']);
    $currentItem->setIsActive($this->params['isActive']);
    $currentItem->setIsNote($this->params['isNote']);
    $currentItem->setIsRed($this->params['isRed']);

    $currentItem->isShow = $this->params['isShow'];
    
    $currentItem->position = intval($this->params['position']);
    $currentItem->brif = isset($this->params['brif'])?$this->params['brif']:'';

    $file_name=$currentItem->image;
    if (is_uploaded_file($_FILES["avatar"]["tmp_name"])) {
        list($width, $height, $type, $attr) = getimagesize($_FILES["avatar"]["tmp_name"]);

        if ($type == 1 || $type == 2) {
            if ($currentItem->image && file_exists(UPLOAD_PATH."/menu/".$currentItem->image)) @unlink (UPLOAD_PATH."/menu/".$currentItem->image)  ;

            $file_name = AK_Common_Functions::generatePassword(10);
            $file_name.=$_FILES["avatar"]["name"];
            move_uploaded_file($_FILES["avatar"]["tmp_name"], UPLOAD_PATH."/menu/".$file_name);
        }

    }

    $currentItem->image = $file_name;
    
    $viewPages=false;
    if(isset($this->params['view_pages'])){
//     	$newViewPages = explode("\r\n", $this->params['view_pages']);
//     	$recordViewPages = array();
//     	foreach($newViewPages as $itemPage){
//     		if (substr($itemPage, 0, 1) == '/'){
//     			$recordViewPages['view'][] = $itemPage;
//     		}
//     		if (substr($itemPage, 0, 1) == '-'){
//     			$recordViewPages['not_view'][] = substr($itemPage, 1);
//     		}
//     	}
    	$viewPages = serialize($this->params['view_pages']);
    }
    
    $currentItem->view_pages = isset($this->params['view_pages'])?$viewPages:'';


    $currentItem->save();

    $this->_redirect(MODULE_URL.'/menu/links.list/menu_id/'.$_SESSION['menu_id'].'/');
}

$this->view->form = $form;
$this->view->currentItem = $currentItem;
$this->view->categoriesList = $categoriesList->returnAsAssoc(true)->setAssocValue('A.description')->getList();

$this->view->BODY_CONTENT_FILE = "menu/link.add.tpl";
$this->view->switchmenu = $switchmenu;

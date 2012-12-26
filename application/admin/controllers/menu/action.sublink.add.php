<?php
if (empty ($_SESSION['menu_id']))
$_SESSION['menu_id']=$this->params['menu_id'];

switch ($this->getRequest()->getParam('menu_id'))
{
    case '1':

        $switchmenu = 'Левого подменю';
        $leftmenu=false;
        $_SESSION['menu_id']=1;
        break;
    case '2':
        $switchmenu = 'Нижнего подменю';
        $leftmenu=false;
        $_SESSION['menu_id']=2;
        break;
    case '3' :
        $switchmenu = 'Верхнего подменю';
        $leftmenu=true;
        $_SESSION['menu_id']=3;
        break;
}


$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;

$currentItem = new AK_Menu_Sublink_Item($this->params['id']);

$categoriesList = new AK_Menu_Link_List;
$categoriesList->addWhere("A.menu_id = '".$_SESSION['menu_id']."'");
$positioncategoriesList = new AK_Menu_Link_List;

$positioncategoriesList->addWhere("A.menu_id = '1'");

if (isset($this->params['link_id'])) {
    
    $currentItem->setLinkId(intval($this->params['link_id']));
    //$_SESSION['link_id']=$this->params['link_id'];
}


$form = new AK_Form('editItem', 'post', MODULE_URL.'/menu/sublink.add/');
$form->addRule('title', 'required', 'Введите заголовок');
$form->addRule('link', 'siteorabs', 'Введите корректную ссылку'); 
$form->addRule('queue', 'numeric', 'Введите корректный порядковый номер');
//$form->addRule('position', 'numeric', 'Введите корректную позицию');
$form->addRule('avatar',       'uploadedimage',  'Загрузка изображения не удалась или неверный тип изображения');

if ($form->isPostback()) {
    $this->params['isShow'] = empty($this->params['isShow'])?0:1;
    $this->params['deleteImage'] = empty($this->params['deleteImage'])?0:1;
    $this->params['isRed'] = empty($this->params['isRed'])?0:1;
    $this->params['isNote'] = empty($this->params['isNote'])?0:1;
    $form->setDefaults($this->params);

}

if ($form->validate($this->params)) {
    

    if ($this->params['deleteImage']) {
        if ($currentItem->image && file_exists(UPLOAD_PATH."/menu_sub/".$currentItem->image)) {
            @unlink (UPLOAD_PATH."/menu_sub/".$currentItem->image)  ;
            $currentItem->image = '';
        }
    }
    $currentItem->setTitle($this->params['title']);
    $currentItem->setLink($this->params['link']);
    $currentItem->setLinkId($this->params['linkId']);
           
    $currentItem->setQueue($this->params['queue']);
    $currentItem->setIsRed($this->params['isRed']);
    $currentItem->setIsNote($this->params['isNote']);
    $currentItem->isShow = $this->params['isShow'];
    $currentItem->position = $this->params['position'];
    
    $currentItem->brif = isset($this->params['brif'])?$this->params['brif']:'';

    $file_name=$currentItem->image;
    if (is_uploaded_file($_FILES["avatar"]["tmp_name"])) {
        list($width, $height, $type, $attr) = getimagesize($_FILES["avatar"]["tmp_name"]);

        if ($type == 1 || $type == 2) {
            if ($currentItem->image && file_exists(UPLOAD_PATH."/menu_sub/".$currentItem->image)) @unlink (UPLOAD_PATH."/menu_sub/".$currentItem->image)  ;

            $file_name = AK_Common_Functions::generatePassword(10);
            $file_name.=$_FILES["avatar"]["name"];
            move_uploaded_file($_FILES["avatar"]["tmp_name"], UPLOAD_PATH."/menu_sub/".$file_name);
        }

    }

    $currentItem->image = $file_name;
    
    $currentItem->save();
    $this->_redirect(MODULE_URL.'/menu/sublinks.list/filterfield/linkId/filtervalue/'.$_SESSION['link_id'].'/menu_id/'.$_SESSION['menu_id'].'/');
}

$this->view->form = $form;
$this->view->currentItem = $currentItem;
$this->view->categoriesList = $categoriesList->returnAsAssoc(true)->getList();
$this->view->positioncategoriesList = $positioncategoriesList->returnAsAssoc(true)->getList();
$this->view->BODY_CONTENT_FILE = "menu/sublink.add.tpl";
$this->view->switchmenu = $switchmenu;
$this->view->leftmenu = $leftmenu;
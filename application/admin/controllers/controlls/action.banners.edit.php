<?php

$banners = new AK_Banners_List();
$banners = $banners->addWhere('A.id = ?',$this->params['edit'])->getList();
foreach ($banners as $item)
{
    $item->code = htmlspecialchars($item->code);
    
    $item->code2 = htmlspecialchars_decode($item->code);
    
}
$this->view->banners = $banners;

$this->params['id'] = isset($this->params['id'])?intval($this->params['id']):null;

$form = new AK_Form('editItem', 'post', MODULE_URL.'/controlls/banners/');
//$form->addRule('price', 'required', 'Введите Цену');
//$form->addRule('avatar',       'uploadedimage',  'Загрузка изображения не удалась или неверный тип изображения');

if ($form->isPostback()){
   $this->params['isActive'] = empty($this->params['isActive'])?0:1;
   $this->params['image_path'] = empty($this->params['image_path'])?'':$this->params['image_path'];
   $this->params['count'] = empty($this->params['count'])?0:$this->params['count'];
   $this->params['image_href'] = empty($this->params['image_href'])?'':$this->params['image_href'];
   $form->setDefaults($this->params);
}

if ($form->validate($this->params)){
    
    //print_r($this->params);
    
    $currentItem =  new AK_Banners_Item($this->params['id']);
    
    $currentItem->name = $this->params['name'];
    $currentItem->isActive = $this->params['isActive'];
    $currentItem->isimage = $this->params['isimage'];
    $currentItem->image_href = $this->params['image_href'];
    $currentItem->code = htmlspecialchars_decode($this->params['code']);
    $currentItem->key = $this->params['key'];
    $currentItem->position = $this->params['position'];
    $currentItem->priority = $this->params['priority'];
    $currentItem->count = $this->params['count'];
    $file_name = '';

  
    if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {


        //list($width, $height, $type, $attr) = getimagesize($_FILES["avatar"]["tmp_name"]);

        
           // if (file_exists(IMG_URL2_UPLOAD."/".$currentItem->image_path))
             //       @unlink (IMG_URL2_UPLOAD."/".$currentItem->image_path)  ;

            $file_name = AK_Common_Functions::generatePassword(10);
            $file_name.=$_FILES["avatar"]["name"];

            move_uploaded_file($_FILES["avatar"]["tmp_name"], IMG_URL2_UPLOAD."/".$file_name);
				//die($_FILES["avatar"]["name"]."<hr>".$_FILES["avatar"]["tmp_name"].".tmp"."<hr>".IMG_URL2_UPLOAD."/".$file_name);
           // die($_FILES["avatar"]["tmp_name"]."<hr>". $file_name);
    
         $currentItem->image_path = $file_name;
    }
    
   
    try {
         $currentItem->save();
    } catch (Zend_Db_Exception $exc) {
        echo $exc;
        die();
    }

   
   
    $this->_redirect(MODULE_URL.'/controlls/banners/');
}

$this->view->form = $form;
$this->view->options = array (0 => "Cлева", 1 => "Справа", 2 => "Слева снизу", 4 => "Справа снизу", );
$this->view->options2 = array (0 => "Код", 1 => "Картинка", 2 => "Флеш" );



?>

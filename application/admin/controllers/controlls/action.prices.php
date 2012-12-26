<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$PricesList = new AK_Order_PricesList();
$PricesList = $PricesList->getList();
$this->view->PricesList = $PricesList;

$form = new AK_Form('editItem', 'post', MODULE_URL.'/controlls/prices/');
$form->addRule('price', 'required', 'Введите Цену');

if ($form->isPostback()){
  $form->setDefaults($this->params);
}

if ($form->validate($this->params)){
    $currentItem =  new AK_Order_Prices($this->params['id']);
    $currentItem->price = $this->params['price'];
 
    $currentItem->save();

    $this->_redirect(MODULE_URL.'/controlls/prices/');
}

$this->view->form = $form;

?>

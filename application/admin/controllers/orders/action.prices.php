<?php

if ($this->getRequest()->getParam('price')) {
    $p = $this->getRequest()->getParam('price');
    foreach ($p as $key=>$value) {
        $price = new AK_Order_Prices($key);
        if ($price->id) {
            $this->view->updateMessage = 'Изменения сохранены';
            $price->price = $value;
            $price->save();
        }
    }
    $t = $this->getRequest()->getParam('title');
    foreach ($t as $key=>$value) {
        $price = new AK_Order_Prices($key);
        if ($price->id) {
            $this->view->updateMessage = 'Изменения сохранены';
            $price->title = $value;
            $price->save();
        }
    }
}

$this->view->prices = AK_Order_Prices::getPrices();
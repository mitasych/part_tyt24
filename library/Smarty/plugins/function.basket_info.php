<?php

function smarty_function_basket_info($params, &$smarty) {

    $_content = '<img src="/images/basket_small.jpg" align="left" />';

    $Basket = new AK_Order_Basket();
    
    if ($Basket->getCount()) {
        $_content.='элементов: '.$Basket->getCount();
        if ($Basket->getTotalAmount()){
            $_content.='<br>на сумму '.$Basket->getTotalAmountString();
        }
        $_content.='<br><a href="/order/basket/">просмотр</a>';
    } else {
        $_content.='корзина пуста';
    }

    return $_content;
}
<div class="right_part2">
    <div class="bg_ie">
    </div>

    <div>
        <div class="main_top_text">

            {breadcrumb controller="info" alias="orderAdd" title='' altTitle="Добавление в корзину"}

            <h1>Добавление в корзину</h1>

            <p>Элемент добавлен в корзину</p>
            <br />
            <p>Всего элементов в корзине: {$Basket->getCount()}{if $Basket->getTotalAmount()} на сумму {$Basket->getTotalAmountString()}{/if}</p>
            <br />
            <p><a href="/order/basket/">Список заказов</a></p>

            <div class="dotted2"></div>
        </div>
    </div>
</div>
<div class="right_part2">
    <div class="bg_ie">
    </div>

    <div>
        <div class="main_top_text">

            {breadcrumb controller="info" alias="orderCreated" title='' altTitle="Просмотр заказа"}

            <h1>Просмотр заказа</h1>

            <p><b>№ заказа/счета: </b>{if $orderItem->number}{$orderItem->number}{else}{$orderItem->secretCode}{/if}
            </p><p>&nbsp;</p>

           <p>&nbsp;</p>
            {include file="order/order_info.tpl" orderItem = $orderItem}<p>&nbsp;</p>
            {include file="order/pay_after_price_detect.tpl" orderItem = $orderItem}<p>&nbsp;</p>

           
            <div class="dotted2"></div>
        </div>
    </div>
</div>
<div class="right_part2">
    <div class="bg_ie">
    </div>

    <div>
        <div class="main_top_text">

            {breadcrumb controller="info" alias="orderCreated" title='' altTitle="Пополнение баланса"}

            <h1>Пополнение баланса</h1>

            <p><b>№ заказа/счета: </b>{if $orderItem->number}{$orderItem->number}{else}{$orderItem->secretCode}{/if}
            </p>
            {assign var=right_text value=yes}    
            {include file="order/balans_info.tpl" orderItem = $orderItem}
            
            {assign var=url_hidee value=yes} 
            {include file="order/pay_after_price_detect.tpl" orderItem = $orderItem}
           
            <div class="dotted2"></div>
        </div>
    </div>
</div>
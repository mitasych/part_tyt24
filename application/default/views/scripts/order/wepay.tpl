<div class="right_part2">
    <div class="bg_ie">
    </div>

    <div>
        <div class="main_top_text">

            {breadcrumb controller="info" alias="orderCreated" title='' altTitle="Оплата заказа"}

            {*<h1>Оплата заказа</h1>

            <p>Оплата заказа #{$orderItem->secretCode} на сайте {$SITE_NAME} ({$orderItem->price}.00 руб.)</p>*}


            <h1>Оплата заказа</h1>

            <p><b>№ заказа/счета: </b>{if $orderItem->number}{$orderItem->number}{else}{$orderItem->secretCode}{/if}
            </p>

            {assign var=nn value=$orderItem->getRelList()}
            {if $nn.0->getZakaz()->typeId !=21}


            <table cellpadding="5" cellspacing="5" border="1">
                <tr>
                    <th><b>№</b></th>
                    <th><b>Тип</b></th>
                    <th><b>Информация</b></th>
                    <th><b>Цена</b></th>

                </tr>
                {foreach from=$nn key=key item=item}
                <tr>
                    <td>{$key+1}</td>
                    <td>{$item->getZakaz()->getPricesObject()->getName()}</td>
                    <td>{$item->getZakaz()->getInfoString()}</td>

                    <td>{$item->getZakaz()->priceInOrder} руб.</td>
                </tr>
                {/foreach}
            </table>

            <p><b>Общая стоимость: </b>{$orderItem->price}  руб.
            </p>
            {/if}

            <form id=pay name=pay method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
                <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="{$orderItem->price}.00">
                <input type="hidden" name="LMI_PAYMENT_DESC" value="3AKA3 #{if $orderItem->number}{$orderItem->number}{else}{$orderItem->secretCode}{/if}">
                <input type="hidden" name="LMI_PAYMENT_NO" value="{$orderItem->secretCode}">
                <input type="hidden" name="LMI_PAYEE_PURSE" value="{$smarty.const.WEBMONEY_PURSE_ID}">
                {*<input type="hidden" name="LMI_SIM_MODE" value="0">*}
                <input type="submit" value="Оплатить">

            </form> 

            <div class="dotted2"></div>
        </div>
    </div>
</div>
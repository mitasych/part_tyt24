
<div class="right_part2">
    <div class="bg_ie">
    </div>

    <div>
        <div class="main_top_text">

            {assign var=nn value=$orderItem->getRelList()}

            {if $nn.0->getZakaz()->typeId !=21}
                {breadcrumb controller="info" alias="orderCreated" title='' altTitle="Оплата заказа"}
            {else}
                {breadcrumb controller="info" alias="orderCreated" title='' altTitle="Пополнение баланса"}
            {/if}

         {*   <h1>{if $nn.0->getZakaz()->typeId !=21}Оплата заказа{else}Пополнение баланса{/if}</h1>*}

        {* <p><b>№ заказа/счета: </b>{if $orderItem->number}{$orderItem->number}{else}{$orderItem->secretCode}{/if}

                {if $nn.0->getZakaz()->typeId ==21}&nbsp;
                    <b>Сумма счета: </b>{$orderItem->price} руб.
                {/if}
            </p>
        *}
            
            {if $nn.0->getZakaz()->typeId !=21}
{*            
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
    *}
            {/if}

            <form name="payment" id="redirect_ajax" action="https://interkassa.com/lib/payment.php" method="post"
                  enctype="application/x-www-form-urlencoded" accept-charset="utf8">
                <input type="hidden" name="ik_shop_id" value="{$smarty.const.IKASSA_SHOP_ID}">
                <input type="hidden" name="ik_payment_amount" value="{$orderItem->price}.00">
                <input type="hidden" name="ik_payment_id" value="{$orderItem->secretCode}">
                <input type="hidden" name="ik_payment_desc" value="Оплата заказа #{$orderItem->secretCode} на сайте {$SITE_NAME}">
                {*<input type="submit" name="process" value="{if $nn.0->getZakaz()->typeId !=21}Оплатить{else}Пополнить{/if}">*}
            </form>


            <div class="dotted2"></div>
        </div>
    </div>
</div>
{literal}
    <script>
        $("#redirect_ajax").submit();
    </script>
{/literal}
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

            <h1>{if $nn.0->getZakaz()->typeId !=21}Оплата заказа{else}Пополнение баланса{/if}</h1>

            <p><b>№ заказа/счета: </b>{if $orderItem->number}{$orderItem->number}{else}{$orderItem->secretCode}{/if}

                {if $nn.0->getZakaz()->typeId ==21}&nbsp;
                    <b>Сумма счета: </b>{$orderItem->price} руб.
                {/if}
            </p>

            
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




            {if $nn.0->getZakaz()->typeId !=21}
                <input type="submit" onclick="document.location = '{$purl}';" value="Оплатить" />
            {else}
                <input type="submit" onclick="document.location = '{$purl}';" value="Пополнить" />
            {/if}

            
            <div class="dotted2"></div>
        </div>
    </div>
</div>
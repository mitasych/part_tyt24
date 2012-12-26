<table cellpadding="5" cellspacing="0" border="0" width="100%" class="my_orders">
    <tr id="inner">
        <th><b style="color:#2D96FE">№</b></th>
        <th ><b style="color:#2D96FE">Сервис</b></th>
        <th ><b style="color:#2D96FE">Информация</b></th>
        <th><b style="color:#2D96FE">Цена</b></th>
        {if $item->fileName}
            <td><b style="color:#2D96FE">Файл</b></td>
        {/if}

    </tr>
    {foreach from=$orderItem->getRelListNumber() key=key item=item}
    <tr>
        <td>{$key+1}</td>
        <td>Баланс</td>
        <td>Сумма: {$orderItem->getPriceString()}</td>
        <td align="center">{$orderItem->getPriceString()}</td>
        {if $item->fileName}
            <td>{$item->getAttachedFileUser()}</td>
        {/if}
    </tr>
    {/foreach}
</table>

<p><b>Общая стоимость: </b>{if $orderItem->getPriceString() == 'цена требует уточнения'}-{else}{$orderItem->getPriceString()}{/if}
</p>






<p><b>Статус:</b> Ожидается оплата</p>



<p><b>Дата изменения: </b>{$orderItem->getDateUpdatedFormatted()}
</p>

{if $url_hidee==""}

{else}
    <p><B>Страница заказа:</B> http://tyt24.ru/order/showbalans/sc/{$orderItem->secretCode}/</p>

{/if}

{if $orderItem->getMoneyLabel()}
    {if $hide_pay==""}

        {if $orderItem->relationsUser == "" or $orderItem->getServis()=="Баланс"}
        <p>
            <b>Способ оплаты: </b>{$orderItem->getMoneyLabel()}
        </p>
        {/if}


        {if $right_text==""}
           Оплатите заказ в случае если Вы не оплачивали данный его ранее по какой либо причине
        {/if}
    {/if}
{/if}
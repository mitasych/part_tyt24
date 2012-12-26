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
        <td>{$item->getZakaz()->getPricesObject()->getName()}</td>
        <td>{$item->getZakaz()->getInfoString()}</td>
        <td align="center">{if $item->getZakaz()->getPriceString() == 'цена требует уточнения'}-{else}{$item->getZakaz()->getPriceString()}{/if}</td>
        {if $item->fileName}
            <td>{$item->getAttachedFileUser()}</td>
        {/if}
        
    </tr>
    {/foreach}
</table>

<p><b>Общая стоимость: </b>{if $orderItem->getPriceString() == 'цена требует уточнения'}-{else}{$orderItem->getPriceString()}{/if}
</p>
<p><b>Статус: </b>{if $orderItem->getStatusLabel() == 'Заказ передан клиенту' ||
                    $orderItem->getStatusLabel() == 'Заказ выполнен'}
                        {if !$orderItem->isBalans()}
                            Заказ передан клиенту
                        {else}
                            Баланс пополнен
                        {/if}
                    {else}
                        {$orderItem->getStatusLabel()}
                    {/if}
</p>
<p><b>Дата изменения: </b>{$orderItem->getDateUpdatedFormatted()}



{if $url_hidee==""}

{else}

    <p><B>Страница заказа:</B> http://tyt24.ru/order/show/sc/{$orderItem->secretCode}/</p>

{/if}

{if $hide_pole==""}
    {if $orderItem->getMoneyLabel()}
        {if $orderItem->relationsUser == "" or $orderItem->getServis()=="Баланс"}
        <p>
            <b>Способ оплаты: </b>{$orderItem->getMoneyLabel()}
        </p>
        {/if}
    {/if}
{/if}





<table cellpadding="5" cellspacing="5" border="1">
    <tr>
        <th><b>№</b></th>
        <th><b>Тип</b></th>
        <th width="300"><b>Информация</b></th>
        <th><b>Файл</b></th>
        <th><b>Цена</b></th>

    </tr>
    {foreach from=$orderItem->getRelList() key=key item=item}
    <tr>
        <td>{$key+1}</td>
        <td>{$item->getZakaz()->getPricesObject()->getName()}</td>
        <td>{$item->getZakaz()->getInfoString()}</td>
        <td>{if $item->fileName}{$item->getAttachedFileUser()}{/if}</td>
        <td>{$item->getZakaz()->getPriceString()}</td>
    </tr>
    {/foreach}
</table>

<p><b>Общая стоимость: </b>{$orderItem->getPriceString()}
</p>

{if $orderItem->getMoneyLabel()}
<p><b>Способ оплаты: </b>{$orderItem->getMoneyLabel()}
</p>
{/if}

<p><b>Статус: </b>{$orderItem->getStatusLabel()}
</p>

<p><b>Дата изменения: </b>{$orderItem->getDateUpdatedFormatted()}
</p>
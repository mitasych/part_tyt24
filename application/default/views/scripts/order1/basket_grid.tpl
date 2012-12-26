{if $Basket->getItems()}

{if !$ischeck}
<p>Список заказов</p>
<p><a href="/order/basketclear/">Очистить корзину</a></p>
{/if}
<table cellpadding="5" cellspacing="5" border="1">
    <tr>
        <th><b>№</b></th>
        {*<th>Раздел</th>*}
        <th><b>Тип</b></th>
        <th width="300"><b>Информация</b></th>
        <th><b>Цена</b></th>
        <th><b>Действия</b></th>
    </tr>
    {foreach from=$Basket->getItems() key=key item=item}
    <tr>
        <td>{$key+1}</td>
        {*<td>{$item->getPricesObject()->getGroupName()}</td>*}
        <td>{$item->getPricesObject()->getName()}</td>
        <td>Назавание:
        {*<a href="{$SITE_URL}/item/index/id/{$item->getId()}/">{$item->getInfoString()}</a>*}
          <a href="#">{$item->getInfoString()}</a><br  />
          {*Адрес: {$item->getAdress()}*}
          </td>
        <td>{$Basket->getElementPriceString($key)}</td>
        <td><a href="/order/basketdelete/bid/{$key}/" onclick="if (!confirm('Удалить данный элемент из корзины?')) return false;">удалить</a></td>
    </tr>
    {/foreach}
</table>
<br />
<p>Всего элементов в корзине: {$Basket->getCount()}{if $Basket->isTotalAmountDefined()} на сумму {$Basket->getTotalAmountString()}{/if}</p>
<br />

{if !$ischeck}
    {if !$user->getId() || $Basket->isBalans() || !$Basket->isTotalAmountDefined()}
        <p><a href="/order/create/">Оформление заказа</a></p>
    {else}
         {if $Basket->getTotalAmount()>$user->balans}
            <h3>Недосточно средств на личном счете</h3>
         {else}
            <input type="submit" onclick="if (!confirm('С вашего личного счета будет списано {$Basket->getTotalAmount()} руб.')) return false; document.location = '/order/create/';" value="Оплатить" />
         {/if}
    {/if}
{/if}




{else}
<p>Корзина пуста</p>
{/if}
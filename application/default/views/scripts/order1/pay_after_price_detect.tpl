{if $orderItem->status == 60}{*WAITING_FOR_PAYMENT*}
    {if !$user->getId() || $orderItem->isBalans()}
        <p>Воспользуйтесь формой оплаты заказа для оплаты в случае если Вы не оплачивали данный заказ ранее или была утеряна квитанция/счет.</p>
        <p><a href="/order/pay/sc/{$orderItem->secretCode}/">Оформление заказа</a></p>
    {else}
        {if $orderItem->price > $user->balans}
            <h3>Недосточно средств на личном счете</h3>
        {else}
            <p>Оплатите заказ в случае если Вы не оплачивали данный заказ ранее, например по причине уточнения цены.</p>
            
            <input type="submit" onclick="if (!confirm('С вашего личного счета будет списано {$orderItem->getPriceString()}')) return false; document.location = '/order/pay/sc/{$orderItem->secretCode}/';" value="Оплатить" />
        {/if}
    {/if}
{/if}
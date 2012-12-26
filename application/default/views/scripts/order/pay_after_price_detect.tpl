{if $orderItem->status == 60}{*WAITING_FOR_PAYMENT*}
    {if !$user->getId() || $orderItem->isBalans()}
    
        <form action="/order/balanspay/sc/{$orderItem->secretCode}/" method="POST">
            {if $url_hidee==""}
                <p>В случае если Вы не оплачивали данный заказ ранее или Вами была утеряна квитанция/счет, воспользуйтесь формой оплаты заказа.</p>
            {/if}

        {if $right_text=="yes"}
            <table><tr><td width="80">
                 <span class="addx2"><input  type="submit"  value="Пополнить" /></span>
            </td><td>
                В случае если Вы не оплачивали данный заказ ранее или Вами была утеряна квитанция/счет, воспользуйтесь формой оплаты заказа.
            </td></tr></table>
        {else}
            <br><span class="addx2"><input  type="submit"  value="Пополнить" /></span><br>
        {/if}
        </form>

{*onclick="if (!confirm('С вашего личного счета будет списано {$orderItem->getPriceString()}')) return false; document.location = '/order/balanspay/sc/{$orderItem->secretCode}/';"*}

    {else}
        {if $orderItem->price > $user->balans}
            <h3>Недосточно средств на личном счете</h3>
        {else}
        {if $url_hidee==""}
            <p>Оплатите заказ в случае если Вы не оплачивали данный заказ ранее, например по причине уточнения цены.</p>
        {/if}
            
            <form action="/order/basket/" method="POST">
                <input type="hidden" value="{$orderItem->price}" name="ordersBasketMoney">
                <input type="hidden" value="{$orderItem->id}" name="ordersBasketId">
                <span class="addx2"><input  type="submit" onclick="if (!confirm('С вашего личного счета будет списано {$orderItem->getPriceString()}')) return false; document.location = '/order/basket/';" value="Оплатить" /></span><br>
            </form>
        {/if}
    {/if}
{/if}
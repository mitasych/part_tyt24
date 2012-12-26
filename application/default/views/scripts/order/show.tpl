<div class="right_part2">
    <div class="bg_ie">
    </div>

    <div>
        <div class="main_top_text">

            {breadcrumb controller="info" alias="orderCreated" title='' altTitle="Просмотр заказа"}

            <h1>Просмотр заказа</h1>

            <p><b>№ заказа/счета: </b>{if $orderItem->number}{$orderItem->number}{else}{$orderItem->secretCode}{/if}
            </p>
            {assign var="url_hide" value='yes'}
            {include file="order/order_info.tpl" orderItem = $orderItem}
            
            {if $orderItem->getStatusLabel() == 'Ожидается оплата' }
                {if $orderItem->getStatusLabel() == 'Заказ передан клиенту' || $orderItem->getStatusLabel() == 'Заказ выполнен'}
                    {if !$orderItem->isBalans()}
                                

                        <table><tr>
                        <td>   
                            <form action="/order/pay/sc/{$orderItem->secretCode}/" method="POST" style="float:left;">
                                <span class="addx2"><input  type="submit"  value="Оплатить" /></span><br>
                            </form>
                         </td><td>
                            {if $user->login == ''}
                                 <p style="margin:4px 0 0 10px;float:left;">Оплатите заказ в случае если Вы не оплачивали данный его ранее по какой либо причине.</p>
                             {/if}
                        </td></tr></table>
                        {else}
                       
                    {/if}
                {else}
                        <table><tr>
                        <td>   
                            {if $user->login != ''}
                                 <form action="/order/basket/" method="POST">
                                    <input type="hidden" value="{$orderItem->price}" name="ordersBasketMoney">
                                    <input type="hidden" value="{$orderItem->id}" name="ordersBasketId">
                                    <span class="addx2"><input  type="submit" onclick="if (!confirm('С вашего личного счета будет списано {$orderItem->getPriceString()}')) return false; document.location = '/order/basket/';" value="Оплатить" /></span>
                                </form>
                            {else}
                                <form action="/order/pay/sc/{$orderItem->secretCode}/" method="POST" style="float:left;">
                                    <span class="addx2"><input  type="submit"  value="Оплатить" /></span><br>
                                </form>
                            {/if}
                         </td><td>

                            {if $user->login == ''}
                               <p style="margin:4px 0 0 10px;float:left;">Оплатите заказ в случае если Вы не оплачивали данный его ранее по какой либо причине.</p>
                             {/if}
                        </td></tr></table>
                {/if}
            {/if}


          {if $orderItem->getStatusLabel() == 'Заказ отложен'}
            {if $user->login == ''}

                        <form action="/order/editpay/sc/{$orderItem->secretCode}/" method="POST">
                            <span class="addx2"><input  type="submit"  value="Оплатить" /></span>
                        </form>

                {else}
                <form action="/order/basket/" method="POST">
                    <input type="hidden" value="{$orderItem->price}" name="ordersBasketMoney">
                    <input type="hidden" value="{$orderItem->id}" name="ordersBasketId">
                    <span class="addx2"><input  type="submit" onclick="if (!confirm('С вашего личного счета будет списано {$orderItem->getPriceString()}')) return false; document.location = '/order/basket/';" value="Оплатить" /></span>
                </form>
           {/if}      
          {/if} 

            <div class="dotted2"></div>
        </div>
    </div>
</div>
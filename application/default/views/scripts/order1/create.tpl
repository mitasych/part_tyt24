<div class="right_part2">
    <div class="bg_ie">
    </div>

    <div>
        <div class="main_top_text">

            {breadcrumb controller="info" alias="orderBasket" title='' altTitle="Оформление заказа"}

            <h1>Оформление заказа</h1>
            {if $Basket->getItems()}
            <p>Список заказов</p>
            <p><a href="/order/basket/">Вернуться в корзину</a></p>
            <table cellpadding="5" cellspacing="5" border="1">
                <tr>
                    <th><b>№</b></th>
                    {*<th>Раздел</th>*}
                    <th><b>Тип</b></th>
                    <th><b>Информация</b></th>
                    <th><b>Цена</b></th>
                </tr>
                {foreach from=$Basket->getItems() key=key item=item}
                <tr>
                    <td>{$key+1}</td>
                    {*<td>{$item->getPricesObject()->getGroupName()}</td>*}
                    <td>{$item->getPricesObject()->getName()}</td>
                    <td>{$item->getInfoString()}</td>
                    <td>{$Basket->getElementPriceString($key)}</td>
                </tr>
                {/foreach}
            </table>
            <br />
            <p>Всего элементов в корзине: {$Basket->getCount()}{if $Basket->getTotalAmount()} на сумму {$Basket->getTotalAmountString()}{/if}</p>


            {form from=$form}
            <p>{form_errors_summary}</p>


            <p><b style="color:#FF0000">&nbsp;</b>&nbsp;Контактное лицо:<br />
                {form_text name=company}
            </p>

            <p><b style="color:#FF0000">*</b>&nbsp;E-mail:<br/>
                {form_text name=email}
            </p>

            <p><b style="color:#FF0000">*</b>&nbsp;Срочность:<br />
                {form_select name="priority" options=$pItems selected=$fparams.priority}
            </p>


            {if $Basket->getTotalAmount()}
                 <p><b style="color:#FF0000">*</b>&nbsp;Способ оплаты{$fparams.mindex}:<br/>
        {assign var="moneyindex" value=1}
        {foreach from=$oItems item=oItemsA}
            {foreach from=$oItemsA key=okey item=oItem}
                {if $fparams.money == $okey && ($fparams.mindex == $moneyindex || !$fparams.mindex)}
                    {assign var="mindex" value=$moneyindex}
                    <input type="radio" name="money" ind={$moneyindex} value={$okey} checked="checked" onclick="emoneyChange(this);" /> {$oItem}<br/>
                {else}
                    <input type="radio" name="money" ind={$moneyindex} value={$okey} onclick="emoneyChange(this);" /> {$oItem}<br/>
                {/if}
                {assign var="moneyindex" value=$moneyindex+1}
            {/foreach}
        {/foreach}
        {form_hidden id="mindex" name="mindex" value=$mindex}
        {*form_select name="money" id="money" options=$oItems selected=$fparams.money*}
    </p>

                <div id="zakuplatu"{if $fparams.money != 2}style="display:none;"{/if}>
                    <p><b style="color:#FF0000">*</b>&nbsp;Заказчик:<br/>
                        {form_text name=zaku id="zaku"}
                    </p>
                    <p><b style="color:#FF0000">*</b>&nbsp;Плательщик:<br/>
                        {form_text name=platu id="platu"}
                    </p>
                </div>
             
            {literal}
            
            <script type="text/javascript">

            function emoneyChange(el){
                $('#mindex').attr('value', $(el).attr('ind'))
                if ($(el).attr('value')==2 || $(this).attr('value')=="2") {
                    $('#zakuplatu').show();
                } else {
                    $('#zakuplatu').hide();
                }

            }
    </script>
{/literal}

            {else}<p>
            У некоторых из ваших заказов отсутствует цена (требует уточнения). После оформления заказа наши специалисты уточнят цену и на указанный вами почтовый адрес будет выслано уведомление, после чего вы сможете оплатить заказ.</p>
            {/if}
            <p>{form_submit name="submitb" id="submitb" value="Отправить" }</p>

            {/form}


            {else}
            <p>У вас нет заказов</p>
            {/if}

            <div class="dotted2"></div>
        </div>
    </div>
</div>
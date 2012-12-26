<div class="right_part2">
    <div class="bg_ie">
    </div>

    <div>
        <div class="main_top_text">

            {breadcrumb controller="info" alias="orderBasket" title='' altTitle="Оформление заказа"}

            <h1>Оформление заказа</h1>

            {include file="order/order_info.tpl" orderItem = $orderItem}

            {form from=$form}
            {form_hidden name="sc" value=$orderItem->secretCode}
            <p>{form_errors_summary}</p>


            <p><b style="color:#FF0000">&nbsp;</b>&nbsp;Название Вашей компании:<br />
                {form_text name=name}
            </p>

            <p><b style="color:#FF0000">*</b>&nbsp;E-mail:<br>
                {form_text name=email}
            </p>

            <p><b style="color:#FF0000">*</b>&nbsp;Срочность:<br />
                {form_select name="priority" options=$pItems selected=$fparams.priority}
            </p>


            <p><b style="color:#FF0000">*</b>&nbsp;Способ оплаты{$fparams.mindex}:<br>
                {assign var="moneyindex" value=1}
                {foreach from=$oItems item=oItemsA}
                {foreach from=$oItemsA key=okey item=oItem}
                {if $fparams.money == $okey && ($fparams.mindex == $moneyindex || !$fparams.mindex)}
                {assign var="mindex" value=$moneyindex}
                <input type="radio" name="money" ind={$moneyindex} value={$okey} checked="checked" onclick="emoneyChange(this);" /> {$oItem}<br>
                {else}
                <input type="radio" name="money" ind={$moneyindex} value={$okey} onclick="emoneyChange(this);" /> {$oItem}<br>
                {/if}
                {assign var="moneyindex" value=$moneyindex+1}
                {/foreach}
                {/foreach}
                {form_hidden id="mindex" name="mindex" value=$mindex}
                {*form_select name="money" id="money" options=$oItems selected=$fparams.money*}
            </p>

            <div id="zakuplatu"{if $fparams.money != 2}style="display:none;"{/if}>
                 <p><b style="color:#FF0000">*</b>&nbsp;Заказчик:<br>
                    {form_text name=zaku id="zaku"}
                </p>
                <p><b style="color:#FF0000">*</b>&nbsp;Плательщик:<br>
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
            <p>{form_submit name="submitb" id="submitb" value="Отправить" }</p>
            {/form}

            <div class="dotted2"></div>
        </div>
    </div>
</div>
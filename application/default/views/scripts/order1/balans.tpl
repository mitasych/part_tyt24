{literal}
<style>

    .ozt td {
        background:none;
        padding:0px 5px 0 0;
        margin:0;
    }
    .ozt td p{
        margin:0px 0 3px;
    }
</style>
{/literal}

<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>
<div>
    <div class="main_top_text">
        {breadcrumb controller="info" alias="balans" title=$currentInfo->getTitle() altTitle="Пополнение баланса"}
        <h1>{info name="balans" what="title"}</h1>
        <p>{info name="balans"}</p>

        {form from=$form2}
        <p>{form_errors_summary}</p>

        <p><b style="color:#FF0000">*</b>&nbsp;Введите сумму:<br>
            {form_text name="balans" id="balans"}

        {form_hidden name=company}
        {*<p><b style="color:#FF0000">&nbsp;</b>&nbsp;Название Вашей компании:<br />
            {form_text name=company}
        </p>*}

        <p><b style="color:#FF0000">*</b>&nbsp;E-mail:<br>
            {form_text name=email}
        </p>


        {form_hidden name="priority" value="7"}


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
                {form_text name=platu id="platu" onfocus="if ($('#platu').attr('value') == '') $('#platu').attr('value', $('#zaku').attr('value')); "}
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


        <p>{form_submit name="submitb2" id="submitb2" value="Пополнить" onclick="$('#submitb2').attr('disabled', true);"}</p>

        {/form}


        <div class="dotted2"></div>
    </div>
</div>
</div>
{literal}
<script language="javascript">
function isenumswitch() {
   if ($('#isenum').attr('checked')) {
        $('#isenumdiv').show();
    } else {
        $('#isenumdiv').hide();
    }
}
function isfinpswitch() {
    if ($('#isfinp').attr('checked')) {
        $('#finptext').show();
    } else {
        $('#finptext').hide();
    }
}
</script>
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

{if !$hidelayout}
<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>
<div>
    <div class="main_top_text">


        {breadcrumb controller="info" alias="check" title=$currentInfo->getTitle() altTitle="Форма заказа базы данных"}
        <h1>{info name="infobase" what="title"}</h1>
        <p>{info name="infobase"}</p>
        {/if}

        {form from=$form}
        {form_errors_summary}
        <div  style="background-color:#CACACA"><br>
        <table class="ozt">
            <tr>
                <td><b style="color:#FF0000">*</b>&nbsp;Название компании<br />{form_text name="company"}</td>
                <td><b style="color:#FF0000"></b>&nbsp;Профиль компании<br />{form_text name="cprofile"}</td>
            </tr>
            <tr>
                <td><b style="color:#FF0000">*</b>&nbsp;Имя<br />{form_text name="name"}</td>
                <td><b style="color:#FF0000">*</b>&nbsp;email<br />{form_text name="email"}</td>
            </tr>
            <tr>
                <td><b style="color:#FF0000">*</b>&nbsp;Фамилия<br />{form_text name="secondname"}</td>
                <td><b style="color:#FF0000">*</b>&nbsp;Телефон<br />{form_text name="phone"}</td>
            </tr>
</table><br></div>
       <table class="ozt">
            <tr>
                <td colspan="2"><b style="color:#FF0000">*</b>&nbsp;Описание заказа БД<br />{form_textarea name="text" style="width:300px; height:100px;"}</td>
            </tr>
<tr><td colspan="2"><br><b>Отметьте поля с обязательным наличием данных в запрашиваемой БД (от выбранных полей зависит количество компаний в БД )</b><br></td></tr>
            <tr>
                <td colspan="2">
                    {form_checkbox name="isphone" id="isphone" checked=$fparams.isphone} Телефон
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    {form_checkbox name="isemail" id="isemail" checked=$fparams.isphone} Emаil
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    {form_checkbox name="isfax" id="isfax" checked=$fparams.isphone} Факс
                </td>
            </tr>
            <tr>
                <td width=200 valign="top" style="vertical-align:top;">
                    {form_checkbox name="isenum" id="isenum" checked=$fparams.isenum onclick="isenumswitch();"} Количество сотрудников
                </td>
                <td>
                    {if $fparams.isenum}
                    <div id="isenumdiv">
                        от {form_text name="enumfrom" style="width:50px;"} до {form_text name="enumto" style="width:50px;"}
                    </div>
                    {else}
                    <div id="isenumdiv" style="display:none;">
                        от {form_text name="enumfrom" style="width:50px;"} до {form_text name="enumto" style="width:50px;"}
                    </div>
                    {/if}
                </td>
            </tr>
            <tr>
                <td valign="top" style="vertical-align:top;">
                    {form_checkbox name="isfinp" id="isfinp" checked=$fparams.isfinp onclick="isfinpswitch();"} Финансовые показатели
                </td>
                <td>
                    {if $fparams.isfinp}
                        {form_textarea name="finptext" id="finptext" style="width:300px; height:100px;"}
                    {else}
                        {form_textarea name="finptext" id="finptext" style="width:300px; height:100px; display:none;"}
                    {/if}
                </td>
            </tr>
        </table>
        <p>&nbsp;</p>
        <p>{form_submit name="submitb" value="Добавить в заказ" style="margin:0;padding:0;"}</p>
        <p>&nbsp;</p>
 {/form}


    <p></p>

    {include file="order/basket_grid.tpl" ischeck=1}


     {if $Basket->isTotalAmountDefined() || (!$user->getId() && $Basket->getCount() && $Basket->isBase())}

        {if !$user->getId()}
            {form from=$form2}
            <p>{form_errors_summary}</p>


            {if $Basket->getCount() && $Basket->isBase()}
            {form_hidden name=name value=$Basket->getBaseName()}{form_hidden name=email value=$Basket->getBaseEmail()}
            {else}
            <p><b style="color:#FF0000">&nbsp;</b>&nbsp;Название Вашей компании:<br />
                {form_text name=company}
            </p>

            <p><b style="color:#FF0000">*</b>&nbsp;E-mail:<br>
                {form_text name=email}
            </p>
            {/if}
            <p><b style="color:#FF0000">*</b>&nbsp;Срочность:<br />
                {form_select name="priority" options=$pItems selected=$fparams.priority}
            </p>



            {if $Basket->getTotalAmount()}
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

            {else}<p>
            У некоторых из ваших заказов отсутствует цена (требует уточнения). После оформления заказа наши специалисты уточнят цену и на указанный вами почтовый адрес будет выслано уведомление, после чего вы сможете оплатить заказ.</p>
            {/if}


            <p>{form_submit name="submitb2" id="submitb2" value="Заказать"}</p>

            {/form}
        {else}
            {if $Basket->getTotalAmount()>$user->balans}
            <h3>Недосточно средств на личном счете</h3>
            {else}
            <input type="submit" onclick="if (!confirm('С вашего личного счета будет списано {$Basket->getTotalAmount()} руб.')) return false; document.location = '/order/create/';" value="Оплатить" />
            {/if}
        {/if}
    {else}
        {if $Basket->getCount()}
            <p><a href="/order/create/">Оформление заказа</a></p>
        {/if}
    {/if}

    <div class="dotted2"></div>

    {if !$hidelayout}
    </div>
    </div>
    </div>
    {/if}
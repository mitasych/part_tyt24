{literal}
<script language="javascript">

<!--

function checkForm() {

try {

 if ($('#cargoname').attr('value') == "" && $('#cargoname2').attr('value') == "" && $('#cargoname3').attr('value') == "") {

    if (!$('#isfiz1st').attr('checked') && $('#fizcheck').css('display')=='block'  ) {
        return true;
    }

    var naz=$('#naz').html();
    //alert('Введите хотя бы одно из полей '+naz+'/ИНН/ОГРН');
    alert('Введите '+naz);

    $('#cargoname').focus();

    return false;

  }

if (parseInt(add1val) == 6) {
if ($('#destcountry').selectedIndex == 0) {

        alert('Выберите страну');

        $('#destcountry').focus();

        return false;

      }

      if ($('#destcity').attr('value') == "") {

        alert('Введите адрес');

        $('#destcity').focus();

        return false;

      }
}

  return true;

} catch(e) {alert(e);

  return false;

}

}



function swisogrn() {
    $('#cargoname2').attr('value', '');
    $('#cargoname3').attr('value', '');
    $('#cargoname2').toggle();
    $('#cargoname3').toggle();
}

function isfizswitch(val) {

    $('#fizf').attr('value', '');
    $('#fizi').attr('value', '');
    $('#fizo').attr('value', '');

    if (val == 1) {
        $('#fizblock').show();
        $('#innogrn').hide();
        $('#fiznaimrequired').hide();
    } else {
        $('#fizblock').hide();
        $('#innogrn').show();
        $('#fiznaimrequired').show();
    }
}

//-->

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


        {breadcrumb controller="info" alias="check" title=$currentInfo->getTitle() altTitle="Форма заказа на проверку контрагента"}
        <h1>{info name="check" what="title"}</h1>
        <p>{info name="check"}</p>
{/if}


        {form from=$form onSubmit="return checkForm()" class="hidden"}
        {form_errors_summary}
        <input type="hidden" name="action" value="send">
        <p><b style="color:#FF0000">*</b> - поля обязательные для заполнения.<br>
        </p>

        {foreach from=$pricesOutput key=pid item=phtml}
        <div style="display:none;" id="priceBoxHidden{$pid}">{$phtml}</div>
        {/foreach}


        <table class="ozt">
            <tr><td colspan="2"><p><em style="color:#FF0000">Данные проверяемого контрагента</em></p></td></tr>


            <tr>
                <td style="width:300px; vertical-align:top;">
                    <p>


                    <div id="fizcheck" {if $fparams.add1 != 2}style="display:none;"{/if}>

                         {*{form_checkbox name="isfiz" id="isfiz" checked=$fparams.isfiz onclick="isfizswitch();"} выписка по физ. лицу*}
                         справка по {form_radio onclick="isfizswitch(0);" name="isfiz" id="isfiz1st" checked="0" value="0"} юр. лицу {form_radio name="isfiz" onclick="isfizswitch(1);" checked=$fparams.isfiz value="1"} физ. лицу:
                         <br><br>
                    </div>


                    <div id="fiznaimrequired" {if $fparams.isfiz  && $fparams.add1==2}style="display:none;"{/if}>
                         <b style="color:#FF0000" id="naimrequired">{if $fparams.add1==6}*{else}&nbsp;{/if}</b>&nbsp;<span id="naz">{if $fparams.add1==3}ФИО ИП{else}Наименование{/if}</span>:<br>
                        {form_text name=cargoname id="cargoname" style="width:280px;"}<br>


                    </div>




                    <div id="innogrn" style="{if $fparams.add1 == 6 || ($fparams.add1 == 2 && $fparams.isfiz) }display:none;{/if}">
                        <b style="color:#FF0000">&nbsp;</b>&nbsp;{form_radio onclick="swisogrn();" name="isogrn" checked=$fparams.isogrn value="0"} ИНН {form_radio name="isogrn" onclick="swisogrn();" checked=$fparams.isogrn value="1"}ОГРН:<br>

                        {if !$fparams.isogrn}
                        {form_text name=cargoname2 id="cargoname2" style="width:280px;"}
                        {form_text name=cargoname3 id="cargoname3" style="width:280px; display:none;"}
                        {else}
                        {form_text name=cargoname2 id="cargoname2" style="width:280px; display:none;"}
                        {form_text name=cargoname3 id="cargoname3" style="width:280px;"}
                        {/if}
                    </div>

                    <div id="add5block" style="{if $fparams.add1 != 6}display:none;{/if}">
                        <p><b style="color:#FF0000">*</b>&nbsp;Адрес:<br>
                        	{form_textarea name="destcity" id="dest" style="width:280px; height:50px;"}

                        </p>
                        <br>
                        <p><b style="color:#FF0000">*</b>&nbsp;Страна:<br>
                            <select name=destcountry style="width: 190" class=forminput>
                                <option value=0 selected>Выберите страну...

                                    {foreach from=$countries item=country}
                                <option {if $fparams.destcountry==$country}selected{/if}>{$country|escape}
                                    {/foreach}
                        </select>
                    </p>
                </div>



                <div id="fizblock" {if !$fparams.isfiz || $fparams.add1!=2}style="display:none;"{/if}>
                     <br>
                    <b style="color:#FF0000">*</b>&nbsp;<span id="naz">Фамилия</span>:<br>
                    {form_text name='fizf' id="fizf" style="width:280px;"}<br>
                    <b style="color:#FF0000">*</b>&nbsp;<span id="naz">Имя</span>:<br>
                    {form_text name='fizi' id="fizi" style="width:280px;"}<br>
                    <b style="color:#FF0000">*</b>&nbsp;<span id="naz">Отчество</span>:<br>
                    {form_text name='fizo' id="fizo" style="width:280px;"}<br>


                </div>

                <br><br>

                </p>
            </td>
            <td style="vertical-align:top;">
                <table>
                    <tr><td colspan="2"><p>&nbsp;</p></td></tr>
                    {foreach from=$zakItems key=key item=item}
                    <tr><td colspan="2"><p>{form_radio name="add1" value=$key checked=$fparams.add1}<b style="color:#FF0000">&nbsp;</b>&nbsp;{$item}&nbsp;&nbsp;</p></td></tr>
                    {/foreach}
                </table>
            </td>
        </tr>



        {literal}
        <script type="text/javascript">
            add1val = '{/literal}{$fparams.add1}{literal}';
                
            $(function(){ $('#priceBox').html($('#priceBoxHidden{/literal}{$fparams.add1}{literal}').html());});
            $("input[name=add1]").change(
                function(){
                    add1val = $(this).val();

                    if ($(this).val()==2) {
                        $("#isfiz1st").click();
                        $('#fizcheck').show();
                        //$('#fiznaimrequired').show();
                        
                    } else {
                        $('#fiznaimrequired').show();
                        $('#isfiz').attr('checked', false);
                        $('#fizcheck').hide();
                        $('#fizblock').hide();
                        $('#fizf').attr('value', '');
                        $('#fizi').attr('value', '');
                        $('#fizo').attr('value', '');
                    }

                    if ($(this).val()==3) {
                        $('#naz').html('ФИО ИП');
                    } else {
                        $('#naz').html('Наименование');
                    }

                    if ($(this).val()==6) {
                        $('#add5block').show();
                        $('#cargoname2').attr('value', '');
                        $('#cargoname3').attr('value', '');
                        $('#innogrn').hide();
                        $('#naimrequired').html('*');
                    } else {
                        $('#add5block').hide();
                        $('#innogrn').show();
                        $('#naimrequired').html('&nbsp;');
                    }
                        
                    $('#priceBox').html($('#priceBoxHidden'+$(this).val()).html());
                })
        </script>
        {/literal}


        <tr><td colspan="2"><p><b>Цена:</b></p></td></tr>
        <tr><td colspan="2"><p id="priceBox">&nbsp;</p></td></tr>

        <tr><td colspan="2"><p>&nbsp;</p></td></tr>

        <tr><td colspan="2"><p>{form_submit name="submitb" value="Добавить в заказ" style="margin:0;padding:0;"}</p></td></tr>
    </table>
    {/form}

    <p></p>

    {include file="order/basket_grid.tpl" ischeck=1}




    {if $Basket->isTotalAmountDefined()}

        {if !$user->getId()}
        {form from=$form2}
        <p>{form_errors_summary}</p>


        <p><b style="color:#FF0000">&nbsp;</b>&nbsp;Название Вашей компании:<br />
            {form_text name=company}
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
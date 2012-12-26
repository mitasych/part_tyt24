{literal}
<script language="javascript">

<!--

function checkForm() {

try {

  if (document.forms[0].elements["name"].value == "") {

    alert('Введите название организации');

    document.forms[0].elements["name"].focus();

    return false;

  }

  if (document.forms[0].elements["contactperson"].value == "") {

    alert('Введите контактное лицо');

    document.forms[0].elements["contactperson"].focus();

    return false;

  }

  if (document.forms[0].elements["phone"].value == "") {

    alert('Введите телефон');

    document.forms[0].elements["phone"].focus();

    return false;

  }

  if (document.forms[0].elements["email"].value == "") {

    alert('Введите e-mail');

    document.forms[0].elements["email"].focus();

    return false;

  }



  if ((document.forms[0].elements["napr"].selectedIndex == -1) || (document.forms[0].elements["napr"].selectedIndex == 0)) {

    alert('Выберите режим');

    document.forms[0].elements["napr"].focus();

    return false;

  }



  if (document.forms[0].elements["add1"].checked) {
  if (document.forms[0].elements["cargoname"].value == "" && document.forms[0].elements["cargoname2"].value == "") {

    alert('Введите код ТНВЭД или краткое описание товара');

    document.forms[0].elements["cargoname"].focus();

    return false;

  }
  }


  if (document.forms[0].elements["add4"].checked) {
  if (document.forms[0].elements["postav"].value == "") {

    alert('Введите поставщика');

    document.forms[0].elements["postav"].focus();

    return false;

  }
  }

  if (document.forms[0].elements["add3"].checked) {
  if (document.forms[0].elements["region"].value == "") {

    alert('Введите регион');

    document.forms[0].elements["region"].focus();

    return false;

  }
  }


  if (document.forms[0].elements["add2"].checked) {
  if (document.forms[0].elements["brand"].value == "") {

    alert('Введите бренд');

    document.forms[0].elements["brand"].focus();

    return false;

  }
  }

  
  if (document.forms[0].elements["isperiod"].checked) {
  if (document.forms[0].elements["period1"].value == "") {

    alert('Заполните все поля периода');

    document.forms[0].elements["period1"].focus();

    return false;

  }
  }
      

if (document.forms[0].elements["srok"].value == "") {

    alert('Введите срок');

    document.forms[0].elements["srok"].focus();

    return false;

  }
	
  if ((document.forms[0].elements["oplata"].selectedIndex == -1) || (document.forms[0].elements["oplata"].selectedIndex == 0)) {

    alert('Выберите способ оплаты');

    document.forms[0].elements["napr"].focus();

    return false;

  }

  return true;

} catch(e) {

  return false;

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
<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>
<div>
    <div class="main_top_text">
        {breadcrumb controller="info" alias="analiz" title=$currentInfo->getTitle() altTitle="Форма заказа на анализ"}
        <h1>{info name="analiz" what="title"}</h1>
        <p>{info name="analiz"}</p>
        {form from=$form onSubmit="return checkForm()"}
        {form_errors_summary}
        <input type="hidden" name="action" value="send">
        {*<h3>форма заказа на перевозку груза</h3>*}
        <p><b style="color:#FF0000">*</b> - поля обязательные для заполнения.<br>
        </p>
        <table class="ozt">
            <tr><td colspan="2"><p><em style="color:#FF0000">Контактная информация</em></p></td></tr>
            <tr><td colspan="2"><p></p></td></tr>
            <tr>
                <td style="width:320px;">
                    <p><b style="color:#FF0000">*</b>&nbsp;Название Вашей компании:<br />
                        {form_text name=name style="width:220px;"}
                    </p>
                </td>
                <td style="width:320px;">
                    <p><b style="color:#FF0000">*</b>&nbsp;Контактное лицо:<br>
                        {form_text name=contactperson style="width:220px;"}
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p><b style="color:#FF0000">*</b>&nbsp;Телефон:<br>
                        {form_text name=phone style="width:220px;"}
                    </p>
                </td>
                <td>
                    <p><b style="color:#FF0000">*</b>&nbsp;E-mail:<br>
                        {form_text name=email style="width:220px;"}
                    </p>
                </td>
            </tr>
            <tr><td colspan="2"><p></p></td></tr>
            <tr><td colspan="2"><p><em style="color:#FF0000">Анализ ВЭД</em></p></td></tr>
            <tr>
                <td>
                    <p><b style="color:#FF0000">*</b>&nbsp;Рынок:<br>
                        <select name=shiptype class=forminput id="shiptype" style="width:225px;">
                            <option {if $fparams.shiptype=='Россия'}selected{/if}>Россия
                            <option {if $fparams.shiptype=='Украина'}selected{/if}>Украина
                        </select>
                    </p>
                </td>
                <td>
                    <p><b style="color:#FF0000">*</b>&nbsp;Режим<br>
                        <select name=napr id=napr style="width:225px;" class=forminput>
                            <option value=0 {if !$fparams.napr}selected{/if}>Выберите режим...
                            <option {if $fparams.napr=='Экспорт'}selected{/if}>Экспорт
                            <option {if $fparams.napr=='Импорт'}selected{/if}>Импорт
                        </select>
                    </p>
            </td>
</tr>
<tr><td colspan="2"><p></p></td></tr>




<tr><td colspan="2"><p>{form_checkbox name="add1" id="add1" value="1"}<b style="color:#FF0000">&nbsp;</b>&nbsp;Товар (код ТНВЭД):&nbsp;&nbsp;</p></td></tr>
{literal}
<script type="text/javascript">
    $('#add1').click(
        function(){
            $('#add1block').toggle();
        })
</script>
{/literal}
<tr id="add1block" style="{if !$fparams.add1}display:none;{/if}">
    <td>
        <p><br><b style="color:#FF0000">*</b>&nbsp;Код ТНВЭД (не менее 4-х знаков):<br>

            {form_textarea name="cargoname" id="cargoname" style="width:220px; height:50px;"}
        </p>
    </td>
    <td>
        <p><b style="color:#FF0000">*</b>&nbsp;Краткое описание товара (заполняется<br>если не известен код ТНВЭД):<br>

            {form_textarea name="cargoname2" id="cargoname2" style="width:220px; height:50px;"}
        </p>
</tr>





<tr><td colspan="2"><p>{form_checkbox name="add3" id="add3" value="1"}<b style="color:#FF0000">&nbsp;</b>&nbsp;Регион:&nbsp;&nbsp;</p></td></tr>
{literal}
<script type="text/javascript">
    $('#add3').click(
        function(){
            $('#add3block').toggle();
        })
</script>
{/literal}
<tr id="add3block" style="{if !$fparams.add3}display:none;{/if}">
    <td colspan="2">
        <p><b style="color:#FF0000">*</b>&nbsp;Регион:<br>
            {form_textarea name="region" id="region" style="width:546px; height:50px;"}
        </p>
</tr>




<tr><td colspan="2"><p>{form_checkbox name="add2" id="add2" value="1"}<b style="color:#FF0000">&nbsp;</b>&nbsp;Бренд:&nbsp;&nbsp;</p></td></tr>
{literal}
<script type="text/javascript">
    $('#add2').click(
        function(){
            $('#add2block').toggle();
        })
</script>
{/literal}

<tr id="add2block" style="{if !$fparams.add2}display:none;{/if}">
    <td colspan="2">
        <p><b style="color:#FF0000">*</b>&nbsp;Бренд (точное наименование бренда): <br>
            {form_text name=brand id="brand" style="width:546px;"}
        </p>
    </td>
</tr>






<tr><td colspan="2"><p>{form_checkbox name="add4" id="add4" value="1"}<b style="color:#FF0000">&nbsp;</b>&nbsp;Поставщик:&nbsp;&nbsp;</p></td></tr>
{literal}
<script type="text/javascript">
    $('#add4').click(
        function(){
            $('#add4block').toggle();
        })
</script>
{/literal}
<tr id="add4block" style="{if !$fparams.add4}display:none;{/if}">
    <td colspan="2">
        <p>
            <b style="color:#FF0000">*</b>&nbsp;Поставщик/Производитель (Полное наименование, юридический адрес, ИНН):<br>

            {form_textarea name="postav" id="postav" style="width:546px; height:50px;"}
        </p>
    </td>
</tr>




<tr>
    <td colspan="2">




        <p>{form_checkbox name="isperiod" id="isperiod" value="1"}<b style="color:#FF0000">&nbsp;</b>&nbsp;Период (Год/Квартал/Месяц):&nbsp;&nbsp;


            {literal}
            <script type="text/javascript">
                $('#isperiod').click(
                    function(){
                        $('#period1').toggle();
                        $('#period2').toggle();
                        $('#period3').toggle();

                    })
            </script>
            {/literal}
            {if !$fparams.isperiod}
                {form_text name="period1" id="period1" style="width:100px; display:none;"}
            {else}
                {form_text name="period1" id="period1" style="width:100px;"}
            {/if}
            
            <select name=period2 class=forminput id="period2" style="width:50px; {if !$fparams.isperiod}display:none;{/if}">
                <option {if $fparams.period2=='1'}selected{/if}>1
            <option {if $fparams.period2=='2'}selected{/if}>2
            <option {if $fparams.period2=='3'}selected{/if}>3
            <option {if $fparams.period2=='4'}selected{/if}>4
            </select>
            
            <select name=period3 class=forminput id="period3" style="width:50px; {if !$fparams.isperiod}display:none;{/if}">
                <option {if $fparams.period=='01'}selected{/if}>01
                <option {if $fparams.period=='02'}selected{/if}>02
                <option {if $fparams.period=='03'}selected{/if}>03
                <option {if $fparams.period=='04'}selected{/if}>04
                <option {if $fparams.period=='05'}selected{/if}>05
                <option {if $fparams.period=='06'}selected{/if}>06
                <option {if $fparams.period=='07'}selected{/if}>07
                <option {if $fparams.period=='08'}selected{/if}>08
                <option {if $fparams.period=='09'}selected{/if}>09
                <option {if $fparams.period=='10'}selected{/if}>10
                <option {if $fparams.period=='11'}selected{/if}>11
                <option {if $fparams.period=='12'}selected{/if}>12

            </select>
</p>

</td>
</tr>





<tr><td colspan="2"><p></p></td></tr>
<tr><td colspan="2"><p><em style="color:#FF0000">Условия</em></p></td></tr>
<tr><td colspan="2"><p></p></td></tr>
<tr>
    <td valign="top">


        <p><b style="color:#FF0000">*</b>&nbsp;Срок выполнения заказа:<br />
            {form_text name=srok id=srok style="width:220px;"}
        </p>
        <p><b style="color:#FF0000">*</b>&nbsp;Способ оплаты:<br>
            <select name=oplata style="width:225px;" class=forminput>
                <option value=0 {if !$fparams.oplata}selected{/if}>Выберите способ оплаты...
            <option {if $fparams.oplata=='наличными'}selected{/if}>наличными
        <option {if $fparams.oplata=='безналичными'}selected{/if}>безналичными
</select>
</p>
</td>
<td>
    <p><b style="color:#FF0000">*</b>&nbsp;Код подтверждения:<br />
        <img src="{$SITE_URL}/{$verifyImage}" alt="" /><br />
        {form_text name="verify_code" style="width:220px;"}</p>
    <p>{form_submit name="submitb" value="Отправить" style="margin:0;padding:0;"}</p>
</td>
</tr>
</table>
{/form}
<div class="dotted2"></div>
</div>
</div>
</div>
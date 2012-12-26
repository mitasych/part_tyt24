{literal}
    <script language="javascript">

<!--

function addItem(type) {

  document.vacancyForm.elements["formaction"].value = "add" + type;

  document.vacancyForm.action = document.vacancyForm.action + "#" + type;

  document.vacancyForm.submit();

}

function delItem(type) {

  document.vacancyForm.elements["formaction"].value = "del" + type;

  document.vacancyForm.action = document.vacancyForm.action + "#" + type;

  document.vacancyForm.submit();

}



function setShadow(obj) {

  if (!obj) return;

  var id = obj.id;

  if (id.indexOf("[") != -1) {

    //id = id.replace("[", "_shadow[");

    id = id.substr(0, id.length - 1) + "_shadow]";

  } else {

    id = id + "_shadow";

  }

  var sh = document.getElementById(id);

  if (sh) {

          sh.value = obj.options[obj.selectedIndex].innerText;

  }

}



if ("".trim == null) {

  String.prototype.trim = function() {

    return this.replace(/(^\s*)|(\s*$)/g, "");

  }

}



function checkForm() {

    if (document.forms[0].elements["formaction"].value != "send") return true;



    try {

      for (var i = 0; i < document.forms[0].elements.length; i++) {

        var n = document.forms[0].elements[i].name.toLowerCase();

        if ((n.indexOf("pcexp[") != -1) && (n.indexOf("][name]") != -1)) {

          if (document.forms[0].elements[i].value.trim() == "") {

            document.forms[0].elements[i].focus();

            alert("Укажите навык");

            return false;

          }

        }

      }

    } catch(e) {

      return false;

    }



    return true;

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

 small { font-size: 70%; }

</style>
{/literal}
<div class="right_part">
        <div class="rp_contenet">

            {breadcrumb controller="info" alias="vacancy" title=$currentInfo->getTitle() altTitle="Вакансии"}

            <h1>{info name="vacancy" what="title"}</h1>
            <p>{info name="vacancy"}</p>
            {form from=$form onSubmit="return checkForm()"}
            {form_errors_summary}
            
            
          
            <input type="hidden" name="formaction" value="send" />
            <input type="hidden" name="eduCount" value="{$eduCount}" />
            <input type="hidden" name="edu2Count" value="{$edu2Count}" />
            <input type="hidden" name="workCount" value="{$workCount}" />
            <input type="hidden" name="langCount" value="{$langCount}" />
            <input type="hidden" name="pcexpCount" value="{$pcexpCount}" />
            <table class="ozt">
                <tr align="left">
                    <td height="30" colspan="3" valign="top">
                        <h3>общая информация</h3>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <p>Дата заполнения:</p>
                    </td>
                    <td valign="top">
                        {form_text name="date" readonly="readonly" id="date" value=$mvar.date size="25"}
                    </td>
                    <td>
                        <p>Вакансия:</p>
                    </td>
                    <td valign="top">
                        {form_text name="vacancy" id="vacancy" value=$mvar.vacancy size="25"}
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>&nbsp;</p>
                    </td>
                    <td valign="top">&nbsp;
                    </td>
                </tr>
                <td>
                        <p>ФИО:</p>
                    </td>
                    <td valign="top">
                        {form_text name="name" value=$mvar.name size="25"}
                    </td>
                    <td>
                        <p>Дата рождения:</p>
                    </td>
                    <td valign="top">
                        {form_text name="birthdate" id="birthdate" value=$mvar.birthdate size="25"}
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Место прописки:</p>
                    </td>
                    <td valign="top">
                        {form_text name="currentplace" id="currentplace" value=$mvar.currentplace size="25"}
                    </td>
                    <td>
                        <p>Адрес проживания:</p>
                    </td>
                    <td valign="top">
                        {form_text name="address" id="address" value=$mvar.address size="25"}
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Семейное положение:</p>
                    </td>
                    <td valign="top">
                        {form_text name="married" id="married" value=$mvar.married size="25"}
                    </td>
                    <td>
                        <p>Дети их возраст:</p>
                    </td>
                    <td valign="top">
                        {form_text name="children" id="children" value=$mvar.children size="25"}
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Домашний телефон:</p>
                    </td>
                    <td valign="top">
                        {form_text name="homephone" id="homephone" value=$mvar.homephone size="25"}
                    </td>
                    <td>
                        <p>Мобильный телефон:</p>
                    </td>
                    <td valign="top">
                        {form_text name="cellphone" id="cellphone" value=$mvar.cellphone size="25"}
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>E-mail:</p>
                    </td>
                    <td valign="top">
                        {form_text name="email" id="email" value=$mvar.email size="25"}
                    </td>
                </tr>
                <tr>
                    <td class="textmain" height="24">&nbsp;
                    </td>
                    <td class="textmain">&nbsp;
                    </td>
                    <td class="textmain">&nbsp;
                    </td>
                </tr>
                <tr align="left">
                    <td height="30" colspan="3" valign="top">
                        <a name="Edu"></a>
                        <h3>образование</h3>
                    </td>
                </tr>
                {section loop=$eduCount name=sec start=0 step=1}
                
                {assign var="key" value=$smarty.section.sec.iteration-1}
                <tr>
                    <td class="textmain" align="right" valign="middle" height="24">
                        <p>Название учреждения:</p>
                    </td>
                    <td valign="top">
                        {form_text name="edu[$key][house]" id="edu[$key][house]" value=$mvar.edu.$key.house size="25"}
                    </td>
                    <td class="textmain" align="right" valign="middle" height="24">
                        <p>Период обучения:</p>
                    </td>
                    <td valign="top">
                        {form_text name="edu[$key][date]" id="edu[$key][date]" value=$mvar.edu.$key.date size="25"}
                    </td>
                </tr>
                <tr>
                    <td class="textmain" align="right" valign="middle" height="24">
                        <p>Специальность:</p>
                    </td>
                    <td valign="top">
                        {form_text name="edu[$key][spec]" id="edu[$key][spec]" value=$mvar.edu.$key.spec size="25"}
                    </td>
                    <td class="textmain" align="right" valign="middle" height="24">
                        <p>Форма обучения:</p>
                    </td>
                    <td valign="top">
                        {form_text name="edu[$key][type]" id="edu[$key][type]" value=$mvar.edu.$key.type size="25"}
                    </td>
                </tr>
                <tr>
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                </tr>
                {/section}
                <tr class="hidden">
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                    <td align="right" valign="top">
                        {if $eduCount > 1}
                        
                        {form_button name="delEduBtn" id="delEduBtn" value="   -   " onClick="delItem('Edu')"}{/if}
                        
                        {form_button name="addEduBtn" id="addEduBtn" value="   +   " onClick="addItem('Edu')"}
                    </td>
                </tr>
                <tr align="left">
                    <td height="30" colspan="3" valign="top">
                        <a name="Edu2"></a>
                        <h3>дополнительное образование, тренинги, семинары, курсы</h3>
                    </td>
                </tr>
                {section loop=$edu2Count name=sec start=0 step=1}
                
                {assign var="key" value=$smarty.section.sec.iteration-1}
                <tr>
                    <td class="textmain" align="right" valign="middle" height="24">
                        <p>Период обучения:</p>
                    </td>
                    <td valign="top">
                        {form_text name="edu2[$key][date]" id="edu2[$key][date]" value=$mvar.edu2.$key.date size="25"}
                    </td>
                    <td class="textmain" align="right" valign="middle" height="24">
                        <p>Название учреждения:</p>
                    </td>
                    <td valign="top">
                        {form_text name="edu2[$key][house]" id="edu2[$key][house]" value=$mvar.edu2.$key.house size="25"}
                    </td>
                </tr>
                <tr>
                    <td class="textmain" align="right" valign="middle" height="24">
                        <p>Название курсов, семинаров, тренингов:</p>
                    </td>
                    <td valign="top">
                        {form_text name="edu2[$key][name]" id="edu2[$key][name]" value=$mvar.edu2.$key.name size="25"}
                    </td>
                </tr>
                <tr>
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                </tr>
                {/section}
                <tr class="hidden">
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                    <td align="right" valign="top">
                        {if $edu2Count > 1}
                        
                        {form_button name="delEdu2Btn" id="delEdu2Btn" value="   -   " onClick="delItem('Edu2')"}{/if}
                        
                        {form_button name="addEdu2Btn" id="addEdu2Btn" value="   +   " onClick="addItem('Edu2')"}
                    </td>
                </tr>
                <tr align="left">
                    <td height="30" colspan="3" valign="top">
                        <a name="Work"></a>
                        <h3>опыт работы</h3>
                    </td>
                </tr>
                {section loop=$workCount name=sec start=0 step=1}
                
                {assign var="key" value=$smarty.section.sec.iteration-1}
                <tr>
                    <td class="textmain" align="right" valign="middle" height="24">
                        <p>Название организации:</p>
                    </td>
                    <td valign="top">
                        {form_text name="work[$key][name]" id="work[$key][name]" value=$mvar.work.$key.name size="25"}
                    </td>
                    <td class="textmain" align="right" valign="middle" height="24">
                        <p>Период работы:</p>
                    </td>
                    <td valign="top">
                        {form_text name="work[$key][date]" id="work[$key][date]" value=$mvar.work.$key.date size="25"}
                    </td>
                </tr>
                <tr>
                    <td class="textmain" align="right" valign="middle" height="24">
                        <p>Должность:</p>
                    </td>
                    <td valign="top">
                        {form_text name="work[$key][title]" id="work[$key][title]" value=$mvar.work.$key.title size="25"}
                    </td>
                    <td class="textmain" align="right" valign="middle" height="24">
                        <p>Должностные обязанности:</p>
                    </td>
                    <td valign="top">
                        {form_text name="work[$key][desc]" id="work[$key][desc]" value=$mvar.work.$key.desc size="25"}
                    </td>
                </tr>
                <tr>
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                </tr>
                {/section}
                <tr class="hidden">
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                    <td align="right" valign="top">
                        {if $workCount > 1}
                        
                        {form_button name="delWorkBtn" id="delWorkBtn" value="   -   " onClick="delItem('Work')"}{/if}
                        
                        {form_button name="addWorkBtn" id="addWorkBtn" value="   +   " onClick="addItem('Work')"}
                    </td>
                </tr>
                <tr align="left">
                    <td height="30" colspan="3" valign="top">
                        <a name="Lang"></a>
                        <h3>владение иностранным языком</h3>
                    </td>
                </tr>
                {section loop=$langCount name=sec start=0 step=1}
                
                {assign var="key" value=$smarty.section.sec.iteration-1}
                <tr>
                    <td class="textmain" align="right" valign="middle" height="24">
                        <p>Название языка:</p>
                    </td>
                    <td valign="top">
                        {form_text name="lang[$key][name]" id="lang[$key][name]" value=$mvar.lang.$key.name size="25"}
                    </td>
                    <td class="textmain" align="right" valign="middle" height="24">
                        <p>Степень владения:</p>
                    </td>
                    <td valign="top">
                        <select name="lang[{$key}][level]" id="lang[{$key}][level]" style="width: 175px"  onChange="setShadow(this)">
                            <option {if $mvar.lang.$key.level == "базовое знание" } selected="selected"; {/if}>базовое знание
                            <option {if $mvar.lang.$key.level == "разговорный уровень" } selected="selected"; {/if} >разговорный уровень
                            <option {if $mvar.lang.$key.level == "свободное владение"} selected="selected"; {/if}>свободное владение
                        </select>
                        <script language="JavaScript">

<!--

  setShadow(document.getElementById("lang[{$key}][level]"));

//-->

</script>
                    </td>
                </tr>
                <tr>
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                </tr>
                {/section}
                <tr class="hidden">
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                    <td align="right" valign="top">
                        {if $langCount > 1}
                        
                        {form_button name="delLangBtn" id="delLangBtn" value="   -   " onClick="delItem('Lang')"}{/if}
                        
                        {form_button name="addLangBtn" id="addLangBtn" value="   +   " onClick="addItem('Lang')"}
                    </td>
                </tr>
                <tr>
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                </tr>
                <tr align="left">
                    <td height="30" colspan="2" valign="top">
                        <a name="PCExp"></a>
                        <h3>компьютерные навыки</h3>
                    </td>
                    <td height="30" colspan="2" valign="top">
                        <h3>дополнительная информация</h3>
                    </td>
                </tr>
                <tr>
                    <td class="textmain" align="right" valign="middle" height="24">
                        <p>Перечислите программы, которыми владеете:</p>
                    </td>
                    <td valign="top">
                        {form_textarea name="knaviki" cols="24" rows="4" id="note1" value=$mvar.knaviki}
                    </td><td class="textmain" align="right" valign="top" height="24">
                        <p>Наиболее сильные стороны<br>
                            вашей профессиональной деятельности:</p>
                    </td>
                    <td valign="top">
                        <p> {form_textarea name="note1" cols="24" rows="4" id="note1" value=$mvar.note1} </p>
                    </td>
                </tr>
                
                <tr>
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="textmain" align="right" valign="middle" height="24">&nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="textmain" align="right" valign="middle" height="24">
                        <p>Пожелания по оплате:</p>
                    </td>
                    <td valign="top">
                        {form_text name="cost" id="cost" value=$mvar.cost size="25"}
                    </td>
                
                    <td>
                        <p><b style="color:#FF0000">*</b>&nbsp;Код подтверждения:
                            </p>
                        
                    </td> <td>
                       
                        <p><img src="{$SITE_URL}/{$verifyImage}" alt="" /><br />
                            {form_text name="verify_code"}</p>
                    </td>
                </tr>
                
                
                
                
                 <tr>
                    <td class="textmain" align="right" valign="middle" height="24">
                       
                    </td>
                    <td valign="top">
                       
                    </td>
                
                    <td>
                     
                        
                    </td> <td>
                       
                        <p>{form_submit name="submitb" value="Отправить" style="margin:0;padding:0;"}</p>
                    </td>
                </tr>
                
                
                <tr class="hidden">
                    <td class="textmain" colspan="4">
                        <p>&nbsp;</p>
                        <p>Для того что бы распечатать заполненную анкету перед отправкой воспользуйтесь стандартной функцией печати броузера.<br />
                        </p>
                    </td>
                   
                </tr>
            </table>
            {/form}
            <div class="dotted" />
        </div>
    </div>
</div>

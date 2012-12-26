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

      if (document.forms[0].elements["cargoname"].value == "") {

        alert('Введите наименование груза (код ТНВЭД)');

        document.forms[0].elements["cargoname"].focus();

        return false;

      }

      if (document.forms[0].elements["weight"].value == "") {

        alert('Введите вес груза');

        document.forms[0].elements["weight"].focus();

        return false;

      }

      if (document.forms[0].elements["value"].value == "") {

        alert('Введите объем');

        document.forms[0].elements["value"].focus();

        return false;

      }

	
      if ((document.forms[0].elements["source[]"].selectedIndex == -1) || (document.forms[0].elements["source[]"].selectedIndex == 0)) {

        alert('Выберите страну(ы) загрузки');

        document.forms[0].elements["source[]"].focus();

        return false;

      }

      if (document.forms[0].elements["sourcecity"].value == "") {

        alert('Введите город загрузки');

        document.forms[0].elements["sourcecity"].focus();

        return false;

      }

      if (document.forms[0].elements["src_date"].value == "") {

        alert('Введите дату загрузки');

        document.forms[0].elements["src_date"].focus();

        return false;

      }

      if (document.forms[0].elements["destcountry"].selectedIndex == 0) {

        alert('Выберите страну разгрузки');

        document.forms[0].elements["destcountry"].focus();

        return false;

      }

      if (document.forms[0].elements["destcity"].value == "") {

        alert('Введите город разгрузки');

        document.forms[0].elements["destcity"].focus();

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

            {breadcrumb controller="info" alias="online" title=$currentInfo->getTitle() altTitle="Форма онлайн запроса"}

            <h1>{info name="onlinerequest" what="title"}</h1>
            <p>{info name="onlinerequest"}</p>
            {form from=$form onSubmit="return checkForm()"}
            {form_errors_summary}
            <input type="hidden" name="action" value="send">
            {*<h3>форма заказа на перевозку груза</h3>*}
            <p><b style="color:#FF0000">*</b> - поля обязательные для заполнения.<br>
            </p>
            <table class="ozt">
                <tr>
                    <td>
                        <p><b style="color:#FF0000">*</b>&nbsp;Название Вашей компании:<br />
                            {form_text name=name}
                        </p>
                    </td>
                    <td>
                        <p><b style="color:#FF0000">*</b>&nbsp;Контактное лицо:<br>
                            {form_text name=contactperson}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><b style="color:#FF0000">*</b>&nbsp;Телефон:<br>
                            {form_text name=phone}
                        </p>
                    </td>
                    <td>
                        <p><b style="color:#FF0000">*</b>&nbsp;E-mail:<br>
                            {form_text name=email}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>АДР, класс:<br>
                            {form_text name=adr id="adr"}
                        </p>
                        <p><b style="color:#FF0000">*</b>&nbsp;Вес груза (кг):<br>
                            {form_text name=weight id="weight"}                        </p>
                        <p><b style="color:#FF0000">*</b>&nbsp;Объем:<br>
                            {form_text name=value id="value"}
                        </p>
                    </td>
                    <td>
                        <p><b style="color:#FF0000">*</b>&nbsp;Способ доставки:<br>
                            <select name=shiptype class=forminput id="shiptype" style="width: 190">
                                <option>ЖД
                                <option>Авиа
                                <option>Море
                                <option>Авто
                                <option>Смешанный
                                <option>Сборный
                            </select>
                        </p>
                        <p><b style="color:#FF0000">*</b>&nbsp;Наименование груза (код ТНВЭД):<br>
                            
                            {form_textarea name="cargoname" id="cargoname" style="width:300px; height:50px;"}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><b style="color:#FF0000">*</b>&nbsp;Страна загрузки:<br>
                            <br>
                            <small style="font-size:11px">при необходимости<br>
                            укажите несколько мест загрузки,<br>
                            для этого удерживайте клавишу <b>Ctrl</b><br>
                            при выборе страны</small><br />
                            <select id="xv12" name=source[] style="width: 190" size=10 multiple class=forminput>
                                {*<option value=0 selected>Выберите страну...*}
                                <option  >Австрия
                                <option  >Азербайджан
                                <option  >Армения
                                <option  >Беларусь
                                <option  >Бельгия
                                <option  >Болгария
                                <option  >Босния и Герцеговина
                                <option  >Великобритания
                                <option  >Венгрия
                                <option  >Германия
                                <option  >Голландия
                                <option  >Греция
                                <option  >Грузия
                                <option  >Дания
                                <option  >Иран
                                <option  >Испания
                                <option  >Италия
                                <option  >Казахстан
                                <option  >Кыргызстан
                                <option  >Латвия
                                <option  >Литва
                                <option  >Македония
                                <option  >Молдавия
                                <option  >Польша
                                <option  >Португалия
                                <option  >Россия
                                <option  >Румыния
                                <option  >Словакия
                                <option  >Словения
                                <option  >Турция
                                <option  >Узбекистан
                                <option  >Украина
                                <option  >Финландия
                                <option  >Франция
                                <option  >Хорватия
                                <option  >Чехия
                                <option  >Швейцария
                                <option  >Швеция
                                <option  >Эстония
                                <option  >Югославия
                            </select>
                        </p>
                    </td>
                    <td>
                        <p><b style="color:#FF0000">*</b>&nbsp;Город загрузки:<br>
                            <br>
                            <small style="font-size:11px">при необходимости<br>
                            укажите несколько мест загрузки<br>
                            через запятую</small><br />
           
                              {form_textarea name="sourcecity" id="sourcecity" style="width:300px; height:50px;"}
                        </p>
                        <p><b style="color:#FF0000">*</b>&nbsp;Дата загрузки:<br />
                            {form_text name=src_date id="src_date"}
                        </p>
                        <p>Дополнительная информация о перевозке:<br>
                        {form_textarea name="note" id="textarea3" style="width:300px; height:50px;"}
                            
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><b style="color:#FF0000">*</b>&nbsp;Страна разгрузки:<br>
                            <select name=destcountry style="width: 190" class=forminput>
                                <option value=0 selected>Выберите страну...
                                <option  >Австрия
                                <option  >Азербайджан
                                <option  >Армения
                                <option  >Беларусь
                                <option  >Бельгия
                                <option  >Болгария
                                <option  >Босния и Герцеговина
                                <option  >Великобритания
                                <option  >Венгрия
                                <option  >Германия
                                <option  >Голландия
                                <option  >Греция
                                <option  >Грузия
                                <option  >Дания
                                <option  >Иран
                                <option  >Испания
                                <option  >Италия
                                <option  >Казахстан
                                <option  >Кыргызстан
                                <option  >Латвия
                                <option  >Литва
                                <option  >Македония
                                <option  >Молдавия
                                <option  >Польша
                                <option  >Португалия
                                <option  >Россия
                                <option  >Румыния
                                <option  >Словакия
                                <option  >Словения
                                <option  >Турция
                                <option  >Узбекистан
                                <option  >Украина
                                <option  >Финландия
                                <option  >Франция
                                <option  >Хорватия
                                <option  >Чехия
                                <option  >Швейцария
                                <option  >Швеция
                                <option  >Эстония
                                <option  >Югославия
                            </select>
                        </p>
                    </td>
                    <td>
                        <p><b style="color:#FF0000">*</b>&nbsp;Город разгрузки:<br>
                        	{form_textarea name="destcity" id="dest" style="width:300px; height:50px;"}
                            
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Дополнительные услуги</strong><br />
                        </p>
                        <p>
                        	{form_checkbox name="add1" id="add1" value="1"}
                           
                            <label for="add1">Таможенного оформления
                            
                            в стране отправления</label>
                        </p>
                        <p>
                            {form_checkbox name="add2" id="add2" value="1"}
                            <label for="add2">Таможенная очистка в стране назначения</label>
                        </p>
                        <p>
                            {form_checkbox name="add3" id="add3" value="1"}
                            <label for="add3">Страхование груза</label>
                        </p>
                        </td><td>
                        <p><b style="color:#FF0000">*</b>&nbsp;Код подтверждения:<br />
                            <img src="{$SITE_URL}/{$verifyImage}" alt="" /><br />
                            {form_text name="verify_code"}</p>
                        <p>{form_submit name="submitb" value="Отправить" style="margin:0;padding:0;"}</p>
                    </td>
                </tr>
            </table>
            {/form}
           <div class="dotted2"></div>
        </div>
    </div>
</div>
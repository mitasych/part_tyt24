{literal}
<script type="text/javascript">

function swstatus(v) {
    $('#organization').attr('value', '');
    $('#innogrn').attr('value', '');
    $('#position').attr('value', '');
    $('#innogrn2').attr('value', '');

    $('#ur').hide();
    $('#ip').hide();

    $('#vnf').hide();
    $('#anf').hide();


    if (v != 1) {
        $('#vnf').show();
        $('#anf').show();
    }
    
    if (v == 2) {
        $('#ur').show();
    }

    if (v == 3) {
        $('#ip').show();
    }

}

function swdog() {
    $('#df').attr('value', '');
    $('#di').attr('value', '');
    $('#do').attr('value', '');
    $('#dolj').attr('value', '');
    $('#dn').attr('value', '');
    $('#dot').attr('value', '');

    $('#dog').toggle();

}

</script>
<style type="text/css">
    .info_input {
        width:250px;
    }

</style>
{/literal}
{*<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>*}


    <div class="main_top_text">

        {breadcrumb controller="users" alias="profileEdit" altTitle="Личный кабинет"}

        {include file="lmenu.tpl"}


        <div class="pinfo">
            {form from=$form}
            {form_errors_summary}

            <b>Статус пользователя</b>
            <div><br />
                {foreach from=$statusList key=statusKey item=statusItem}

                <p>
                    {if $status && $status == $statusKey}
                    {form_radio name="status" value=$statusKey checked=true onclick="swstatus($(this).attr('value'));"} {$statusItem}<br>
                    {else}
                    {form_radio name="status" value=$statusKey checked=false onclick="swstatus($(this).attr('value'));"} {$statusItem}<br>
                    {/if}
                </p>
                {/foreach}
            </div>
            <div class="dotted">  <br></div>

            <b>Данные пользователя</b>
            <div><br />

                <p>Логин : {$user->login|escape}
                </p>

                <table>
                    <tr>
                        <td>
                            <p><span class="error_point">*</span>Имя<br />
                                {form_text class="info_input" name="name" value=$user->name|escape}</p>

                            <p><span class="error_point">*</span>Фамилия<br />
                                {form_text class="info_input" name="second_name" value=$user->secondName|escape}</p>

                            <p><span class="error_point">*</span>Отчество<br />
                                {form_text class="info_input" name="third_name" value=$user->thirdName|escape}</p>

                            {*<p><span class="error_point">*</span>Пол<br />
                                {form_select class="info_input" name="gender" options=$genderList selected=$user->gender}</p>*}
                            {form_hidden class="info_input" name="gender" value=1}

                        </td>

                        <td style="vertical-align:top;">
                            <div style="margin-left:10px;{if $user->status !=2} display:none;{/if}" id="ur" >
                                <p><span class="error_point">*</span>Наименование организации<br />
                                    {form_text class="info_input" name="organization" id="organization"  value=$user->organization|escape}</p>

                                <p><span class="error_point">*</span>ИНН/ОГРН<br />
                                    {form_text class="info_input" name="innogrn" id="innogrn"  value=$user->innogrn|escape}</p>

                                <p><span class="error_point">*</span>Должность<br />
                                    {form_text class="info_input" name="position" id="position" value=$user->position|escape}</p>

                            </div>

                            <div style="margin-left:10px; {if $user->status !=3} display:none;{/if}" id ="ip">
                                <p><span class="error_point">*</span>ИНН/ОГРН<br />
                                    {form_text class="info_input" name="innogrn2" id="innogrn2"  value=$user->innogrn2|escape}</p>


                            </div>

                        </td>

                    </tr>

                    <tr><td>

                            <span class="error_point">*</span>Email адрес<br />
                            {form_text class="info_input" name="email" value=$user->email|escape}
                        </td>
                        <td><div style="margin-left:10px;">Телефон/Факс<br />
                                {form_text class="info_input" name="phone" value=$user->phone|escape}</div></td>
                    </tr>

                </table>
            </div>
            <div class="dotted">  <br></div>

            
            <div>
                <br>

               


                {*form_checkbox name="subscribe_flag" value="1" style="margin:0;padding:0;"} Получать новости (не чаще двух раз в месяц)*}
                {form_hidden class="info_input" name="subscribe_flag" value="1"}

                <div id="vnf" {if $fparams.status ==1}style="display:none;"{/if}>
                     Оформить договор {form_checkbox onclick="swdog();" name="dogovor_notify_flag" value="1" style="margin:0;padding:0;"}<br><br>

                    <div id="dog" {if !$user->dogovorNotifyFlag}style=" display:none;"{/if} >
                         <p><span class="error_point">*</span>Должность руководителя <br>
                            {form_text class="info_input" name="dolj" id="dolj" value=$user->dolj|escape}, в родительном падеже :
                            {form_text class="info_input" name="doljr" id="doljr" value=$user->doljr|escape}
                        </p>

                        <p><span class="error_point">*</span>Фамилия <br>
                            {form_text class="info_input" name="df" id="df" value=$user->df|escape}, в родительном падеже :
                            {form_text class="info_input" name="dfr" id="dfr" value=$user->dfr|escape}</p>

                        <p><span class="error_point">*</span>Имя <br>
                            {form_text class="info_input" name="di" id="di" value=$user->di|escape}, в родительном падеже :
                            {form_text class="info_input" name="dir" id="dir" value=$user->dir|escape}</p>

                        <p><span class="error_point">*</span>Отчество <br>
                            {form_text class="info_input" name="do" id="do" value=$user->do|escape}, в родительном падеже :
                            {form_text class="info_input" name="dor" id="dor" value=$user->dor|escape}</p>

                        <p><span class="error_point">*</span>Действующий
                            на основании (устава, доверенности №) <br>{form_text name="dn" id="dn" value=$user->innogrn2|escape} от
                            {form_text class="info_input" name="dot" id="dot" value=$user->dot|escape}</p>

                    </div>
                </div>
                
                <br>

                <div id="anf" {if $fparams.status ==1}style="display:none;"{/if}>
                     {*form_checkbox class="info_input" onclick="$('#akt_email').attr('value','');$('#em').toggle();" name="akt_notify_flag_monitoring" value="1" style="margin:0;padding:0;"} Получать акты оказанных услуг*}
                     <div id="em" {*if !$user->aktNotifyFlag}style=" display:none;"{/if*} ><br>
                        <p><span class="error_point">*</span>Адрес для отправки актов<br />
                            {form_text class="info_input" name="akt_email" id="akt_email" value=$user->akt_email|escape style="width:450px"}</p>
                    </div>
                </div>

           
            Источник информации о нас:<br>{form_select class="info_input" name="from" options=$fromList selected=$user->from}<br><br>
            Профиль компании:<br>{form_text class="info_input" name="companyProfile" id="companyProfile" value=$user->companyProfile|escape}


              <div class="dotted">  <br></div>
            <b>Смена пароля: </b>
            <table>
                <tr><td>
                        <span class="error_point"></span>Новый пароль<br />
                        {form_password class="info_input" name="newpass"}
                    </td>
                    <td><div style="margin-left:10px;">Подтверждение нового пароля<br />
                            {form_password class="info_input" name="newpassc"}</div></td>
                </tr>


            </table>
            <div class="dotted">  <br></div>

            <p>&nbsp;</p>
            {form_submit style="width:100px;" name="submitb" value="Сохранить"}
            <p>&nbsp;</p>

            


            {/form}
        </div>


        <div class="dotted2"></div>
    </div>
</div>

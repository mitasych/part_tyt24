<tr>
    <td class="allcontent">
        {form from=$form}
        {form_hidden name="id" value=$currentItem->getId()}
        <table>
            <tr>
                <td class="contentTop">&nbsp;</td>
                <td class="contentTopLeft">Действие:&nbsp;&nbsp;</td>
                <td class="contentTopRight">{if $currentItem->getId()}Редактирование{else}Добавление{/if} пользователя{form_errors_summary}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Статус пользователя:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{foreach from=$statusList key=statusKey item=statusItem}

                    <p>
                        {if ($status && $status == $statusKey) || $currentItem->status == $statusKey}
                        {form_radio name="status" value=$statusKey checked=true} {$statusItem}<br>
                        {else}
                        {form_radio name="status" value=$statusKey checked=false} {$statusItem}<br>
                        {/if}
                    </p>
                    {/foreach}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Логин&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="login" value=$currentItem->login}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Пароль:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_password name="pass"}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Подтверждение пароля:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_password name="pass_confirm"}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Имя:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="name" value=$currentItem->name}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Фамилия:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="second_name" value=$currentItem->secondName}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Отчество:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="third_name" value=$currentItem->thirdName}</td>
            </tr>
            {form_hidden name="gender" value=1}
            {*<tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Пол:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_select name="gender" options=$genderList selected=$currentItem->gender}</td>
            </tr>*}
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Email адрес:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="email" value=$currentItem->email}</td>
            </tr>
            <tr>
                <td class="contentCenter" colspan="3" align="center">
                    {form_checkbox name="subscribe_flag" value="1" style="margin:0;padding:0;" checked=$currentItem->subscribeFlag} Получать новости (не чаще двух раз в месяц)<br>
                    {form_checkbox name="vipiska_notify_flag" value="1" style="margin:0;padding:0;" checked=$currentItem->vipiskaNotifyFlag} Получать копию выписки на e-mail<br>
                    <p>Телефон/Факс
                        {form_text name="phone" value=$currentItem->phone}</p>
                    {form_checkbox name="akt_notify_flag" value="1" style="margin:0;padding:0;" checked=$currentItem->aktNotifyFlag} Получать акты оказанных услуг
                </td>
            </tr>

            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">Источник информации о нас:</td>
                <td class="contentCenterRight rightArea">{form_select name="from" options=$fromList selected=$currentItem->from}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td class="centerUni"></td>
                <td colspan="2">{if $currentItem->getId()}
                    {form_submit value="Обновить" class="batton"}
                    {else}
                    {form_submit value="Добавить" class="batton"}
                    {/if}</td>
            </tr>
            <tr>
                <td class="blackLineLeft"></td>
                <td class="blackLineCenter" colspan="3"></td>
            </tr>
        </table>{/form}</td>
</tr>
<tr>
    <td class="allcontent">
        {form from=$form}
        {form_hidden name="id" value=$currentItem->getProperty('id')}
        <table>
            <tr>
                <td class="contentTop">&nbsp;</td>
                <td class="contentTopLeft">Действие:&nbsp;&nbsp;</td>
                <td class="contentTopRight">{if $currentItem->id}Редактирование{else}Добавление{/if} страны{form_errors_summary}</td>
            </tr>





            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Название:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="name" style="width:400px;" value=$currentItem->getProperty('name') class="input"}</td>
            </tr>
             <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Код&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="code" style="width:50px;" value=$currentItem->getProperty('code') class="input"}</td>
            </tr>
             <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft">Использовать в мониторинге:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_checkbox name="monitoringList" value="1" checked=$currentItem->monitoringList style="width:20px;"}</td>
      </tr>

      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft">Использовать в личном кабинете:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_checkbox name="registerList" value="1" checked=$currentItem->registerList style="width:20px;"}</td>
      </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td class="centerUni"></td>
                <td colspan="2">{if $currentItem->id}
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
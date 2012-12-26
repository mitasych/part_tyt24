<tr>
    <td class="allcontent">
    {form from=$form}
    {form_hidden name="id" value=$currentItem->getId()}
    <table>
      <tr>
        <td class="contentTop">&nbsp;</td>
        <td class="contentTopLeft">Действие:&nbsp;&nbsp;</td>
        <td class="contentTopRight">{if $currentItem->getId()}Редактирование{else}Добавление{/if} куратора{form_errors_summary}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Логин:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="login" class="input" value=$currentItem->login}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Пароль:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_password name="password" class="input"}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Email адрес:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="email" style="width:400px;" value=$currentItem->email}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">&nbsp</b> Описание:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_textarea name="description" style="width:400px;" value=$currentItem->description}</td>
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
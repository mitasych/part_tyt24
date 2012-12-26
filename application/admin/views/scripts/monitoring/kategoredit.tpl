<tr>
    <td class="allcontent">
    {form from=$form}
    {form_hidden name="id" value=$currentItem->id}
    <table>
      <tr>
        <td class="contentTop">&nbsp;</td>
        <td class="contentTopLeft">Действие:&nbsp;&nbsp;</td>
        <td class="contentTopRight">{if $currentItem->id}Редактирование{else}Добавление{/if} типа тарифа{form_errors_summary}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Заголовок&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="name"  value=$currentItem->name}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Информация&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="about"  value=$currentItem->about}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Символ:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="simbol" style="width:15px;" value=$currentItem->simbol}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft">Активна:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_checkbox name="active" value="1" checked=$currentItem->active style="width:20px;"}</td>
      </tr>
      
      <tr>
        <td></td>
        <td class="centerUni"></td>
        <td colspan="2">{if $currentItem->id}
             {form_submit value="Обновить элемент" class="batton"}
          {else}
             {form_submit value="Добавить элемент" class="batton"}
          {/if}</td>
      </tr>
      <tr>
        <td class="blackLineLeft"></td>
        <td class="blackLineCenter" colspan="3"></td>
      </tr>
    </table>{/form}</td>
</tr>
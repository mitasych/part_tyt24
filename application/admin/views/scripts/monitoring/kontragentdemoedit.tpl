<tr>
    <td class="allcontent">
    {form from=$form}
    {form_hidden name="id" value=$currentItem->id}
    {form_hidden name="a" value=$a}
    <table>
      <tr>
        <td class="contentTop">&nbsp;</td>
        <td class="contentTopLeft">Действие:&nbsp;&nbsp;</td>
        <td class="contentTopRight">{if $currentItem->id}Редактирование{else}Добавление{/if} контрагента{form_errors_summary}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> ИНН:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="inn"  value=$currentItem->inn}</td>
      </tr>
       <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">&nbsp;</b> Название:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="title"  value=$currentItem->title}</td>
      </tr>
       <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">&nbsp;</b> Регион:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="region"  value=$currentItem->region}</td>
      </tr>
       <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">&nbsp;</b> Страна:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="country"  value=$currentItem->country}</td>
      


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
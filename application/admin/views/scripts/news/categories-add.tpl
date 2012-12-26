<tr>
    <td class="allcontent">
    {form from=$form}
    {form_hidden name="id" value=$currentCategory->getId()}
    <table>
      <tr>
        <td class="contentTop">&nbsp;</td>
        <td class="contentTopLeft">Действие:&nbsp;&nbsp;</td>
        <td class="contentTopRight">{if $currentCategory->getId()}Редактирование{else}Добавление{/if} категории (новости){form_errors_summary}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Заголовок:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="title" style="width:400px;" value=$currentCategory->getTitle() class="input"}</td>
      </tr>
      
      
      <tr>
        <td></td>
        <td class="centerUni"></td>
        <td colspan="2">{if $currentCategory->getId()}
             {form_submit value="Обновить категорию"}
          {else}
             {form_submit value="Добавить категорию"}
          {/if}</td>
      </tr>
      <tr>
        <td class="blackLineLeft"></td>
        <td class="blackLineCenter" colspan="3"></td>
      </tr>
    </table>{/form}</td>
</tr>



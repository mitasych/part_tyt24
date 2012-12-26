<tr>
    <td class="allcontent">
    {form from=$form}
    {form_hidden name="id" value=$currentItem->id}
    <table>
      <tr>
        <td class="contentTop">&nbsp;</td>
        <td class="contentTopLeft">Действие:&nbsp;&nbsp;</td>
        <td class="contentTopRight">{if $currentItem->id}Редактирование{else}Добавление{/if} тарифа{form_errors_summary}</td>
      </tr>
      
       <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Заголовок:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="title"  value=$currentItem->title}</td>
      </tr>
       <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Кол-во дней:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="cnt"  value=$currentItem->cnt}</td>
      </tr>
       <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Скидка %:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="skidka"  value=$currentItem->skidka}</td>
      </tr>
       <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Порядковый номер:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="order" style="width:100px;" value=$currentItem->order}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft">Активен:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_checkbox name="isActive" value="1" checked=$currentItem->isActive style="width:20px;"}</td>
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
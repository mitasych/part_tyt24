<tr>
    <td class="allcontent">{form from=$form}<table>
      <tr>
        <td class="contentTop">&nbsp;</td>
        <td class="contentTopLeft">Параметр:&nbsp;&nbsp;</td>
        <td class="contentTopRight">Официальные отчёты{form_errors_summary}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft">Включить/Выключить:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_checkbox name="ofreports" style="width:20px;" checked=$checked}</td>
      </tr>
      <tr>
        <td></td>
        <td class="centerUni"></td>
        <td colspan="2">{form_submit value="Обновить" class="batton"}</td>
      </tr>
      <tr>
        <td class="blackLineLeft"></td>
        <td class="blackLineCenter" colspan="3"></td>
      </tr>
    </table>{/form}</td>
</tr>
<tr>
    <td class="allcontent">{form from=$form}<table>
      <tr>
        <td class="contentTop">&nbsp;</td>
        <td class="contentTopLeft">Параметр:&nbsp;&nbsp;</td>
        <td class="contentTopRight">E-mail для формы online-запроса и анализа{form_errors_summary}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft">Значение:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="email_online" style="width:400px;" value=$email_online|escape:html}</td>
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
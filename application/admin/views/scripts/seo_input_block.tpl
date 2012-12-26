<tr>
  <td class="contentCenter"></td>
  <td class="contentCenterLeft"><strong>Дополнительно</strong></td>
  <td class="contentCenterRight rightArea"></td>
</tr>


<tr>
<td class="contentCenter"></td>
    <td class="contentCenterLeft"><b style="color:#CB0000;">&nbsp;&nbsp;</b>title: </td>
   <td class="contentCenterRight rightArea">
    	{form_text name="metaTitle" style="width:400px;" value=$currentItem->getMetaTitle() class="input"}
        
    </td>
</tr>
<tr>
<td class="contentCenter"></td>
    <td class="contentCenterLeft"><b style="color:#CB0000;">&nbsp;&nbsp;</b>description: </td>
    <td class="contentCenterRight rightArea">
    	{form_textarea name="metaDescription" style="width:400px; height:100px;" value=$currentItem->getMetaDescription() class="input"}
    </td>
</tr>
<tr>
<td class="contentCenter"></td>
    <td class="contentCenterLeft"><b style="color:#CB0000;">&nbsp;&nbsp;</b>keywords: </td>
    <td class="contentCenterRight rightArea">
    	{form_textarea name="metaKeywords" style="width:400px; height:100px;" value=$currentItem->getMetaKeywords() class="input"}
    </td>
</tr>



{form from=$form}
{form_hidden name="id" value=$currentCategory->getId()}

<table width="70%"  border="0" cellspacing="1" cellpadding="0" class="login">
    <tr>
        <td colspan="2" class="header">{if $currentCategory->getId()}Редактирование{else}Добавление{/if} категории (статьи)</td>
        </tr>
    <tr>
	
		<tr align="center">
	  		<td>&nbsp;</td>
        <td align="left">{form_errors_summary}</td>
		</tr>

		
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td class="r_form" align="right"><b style="color:#CB0000;">*</b> Заголовок: </td>
        <td>
            {form_text name="title" style="width:400px;" value=$currentCategory->getTitle() class="input"}
        </td>
	  </tr>
	  <tr>
	      <td>&nbsp;</td>
        <td colspan="2" align="left">
            Свободные статьи&nbsp;{form_checkbox name="isFree" value="1" checked=$currentCategory->getIsFree()}
        </td>
	  </tr>
	  
	  <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    
    <tr>
        <td>&nbsp;</td>
        <td>
          {if $currentCategory->getId()}
             {form_submit value="Обновить категорию"}
          {else}
             {form_submit value="Добавить категорию"}
          {/if}
        </td>
    </tr>
    
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    
</table>
{/form}

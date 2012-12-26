<tr>
	<td>
		<h3>Права</h3>
	</td>
</tr>

{if $updateMessage}
<tr>
    <td align="center">
        <b style="color:red;">{$updateMessage}</b>
	</td>
</tr>
{/if}
<tr>
	<td class="allcontent">
    	<table>
        	
            <form action="" method="post">
            {foreach from=$mList item=item}
            <tr>
                <td class="tableTop" colspan="3">{$item.gval}</td>
                <td class="tableTopNext tableTopEnd"></td>
          	</tr>
                
            {foreach from=$item.gp key=pkey item=pitem}

            <tr>
            	<td></td>
                <td class="tableBottom"></td>
                <td class="tableBottom"><input name="r[{$pkey}]" type="checkbox" {if $r->get($pkey)}checked = "checked"{/if} /> {$pitem}</td>
                <td class="tableBottomUni"></td>
          	</tr>
            {/foreach}
            {/foreach}
            <tr>
                <td></td>
                <td></td>
                <td><input type="submit" name="submit" value="Сохранить" class="batton" /></td>
                <td></td>
            </tr>
            </form>



            <tr>
                <td class="blackLineLeft"></td>
                <td class="blackLineCenter" colspan="3"></td>
              </tr>
        </table>
    </td>
</tr>
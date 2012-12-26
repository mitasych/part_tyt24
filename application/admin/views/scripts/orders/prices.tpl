<tr>
	<td>
		<h3>Цены на услуги</h3>
	</td>
</tr>

<tr>
	<td>
        <p>
Если в качестве цены указано число, то цена будет распространяться на любое количество заказов. Если указаны диапазоны - будут действовать скидки
<br>Пример указания диапазона:
<b>1:25;11:20;21:15;51:10</b><br>
 Таким образом задаются цены: (1-10) - 25 руб., (11-20) - 20 руб., (21-50) - 15 руб., (51 и более) - 10  руб. При корректном заполнении, диапазоны будут перечислены под полем цены
        </p>
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
        	<tr>
                <td class="tableTop">&nbsp;</td>
                <td class="tableTopNext">Услуга</td>
                <td class="tableTopNext">Группа</td>
                <td class="tableTopNext tableTopEnd">Цена</td>
          	</tr>
            <form action="" method="post">
            {foreach from=$prices item=item}
            <tr>
            	<td></td>
                <td class="tableBottom"><input type="text" name="title[{$item->id}]" value="{$item->getName()|escape}" style="width:100%;" /></br>{$item->getDefaultName()|escape}</td>
                <td class="tableBottom">{$item->getGroupName()|escape}</td>
                <td class="tableBottomUni"><input type="text" name="price[{$item->id}]" value="{$item->price|escape}" style="width:270px;" /><br>{$item->getPricesOutput()}</td>
          	</tr>
            {/foreach}
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><input type="submit" name="submit" value="Сохранить" class="batton" /></td>
            </tr>
            </form>
            <tr>
                <td class="blackLineLeft"></td>
                <td class="blackLineCenter" colspan="3"></td>
              </tr>
        </table>
    </td>
</tr>
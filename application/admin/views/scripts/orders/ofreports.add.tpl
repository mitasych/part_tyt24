{include file="editor_init.tpl"}
<tr>
    <td class="allcontent">
        {form from=$form}
        {form_hidden name="id" value=$currentItem->getProperty('id')}
        <table>
            <tr>
                <td class="contentTop">&nbsp;</td>
                <td class="contentTopLeft">Действие:&nbsp;&nbsp;</td>
                <td class="contentTopRight">{if $currentItem->id}Редактирование{else}Добавление{/if} официального отчета{form_errors_summary}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Отчёт:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_select name="order_report" selected=$currentItem->getProperty('order_report_id') options=$ordersList style="width:400px;"}</td>
            </tr>
			<tr>
				<td class="contentCenter"></td>
				<td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Регион:&nbsp;&nbsp;</td>
				<td class="contentCenterRight rightArea">{form_select name="region_code" selected=$currentItem->getProperty('region_code') options=$ListRegions style="width:400px;"}</td>
			</tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"> Цена2:&nbsp;&nbsp;</td>
                <td class="contentCenterRight ">{form_text name="price2" style="width:200px;" value=$currentItem->price2 } {form_checkbox name="flag1" value="1" checked=$currentItem->flag1 style="width:20px;"} - официальная-обычная
				<br>{$currentItem->getPricesOutput(1)}
				</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">Цена3:&nbsp;&nbsp;</td>
                <td class="contentCenterRight ">{form_text name="price3" style="width:200px;" value=$currentItem->price3} {form_checkbox name="flag2" value="1" checked=$currentItem->flag2 style="width:20px;"} - официальная-срочная
				<br>{$currentItem->getPricesOutput(2)}
				</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">Цена доставки:&nbsp;&nbsp;</td>
                <td class="contentCenterRight ">{form_text name="price_shipping" style="width:200px;" value=$currentItem->price_shipping } {form_checkbox name="flag3" value="1" checked=$currentItem->flag3 style="width:20px;"} - доставка
				<br>{$currentItem->getPricesOutput(3)}
				</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"> Сроки2:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="term2" style="width:200px;" value=$currentItem->term2 } - официальная-обычная
				</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">Сроки3:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="term3" style="width:200px;" value=$currentItem->term3} - официальная-срочная
				</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">Сроки Доставки:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="term_shipping" style="width:200px;" value=$currentItem->term_shipping } - доставка</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"> Примечание:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_textarea name="note"  style="width:550px; height:200px;" value=$currentItem->getProperty('note') }</td>
            </tr>
            <tr>
				<td class="contentCenter"></td>
				<td class="contentCenterLeft">Активен:&nbsp;&nbsp;</td>
				<td class="contentCenterRight rightArea">{form_checkbox name="active" value="1" checked=$currentItem->active style="width:20px;"}</td>
			</tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td class="centerUni"></td>
                <td colspan="2">{if $currentItem->id}
                    {form_submit value="Обновить" class="batton"}
                    {else}
                    {form_submit value="Добавить" class="batton"}
                    {/if}</td>
            </tr>
            <tr>
                <td class="blackLineLeft"></td>
                <td class="blackLineCenter" colspan="3"></td>
            </tr>
        </table>{/form}</td>
</tr>
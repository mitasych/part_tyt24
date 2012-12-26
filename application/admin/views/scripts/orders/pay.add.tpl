{include file="editor_init.tpl"}
<tr>
    <td class="allcontent">
        {form from=$form enctype="multipart/form-data"}
        {form_hidden name="id" value=$currentItem->getProperty('id')}
        <table>
            <tr>
                <td class="contentTop">&nbsp;</td>
                <td class="contentTopLeft">Действие:&nbsp;&nbsp;</td>
                <td class="contentTopRight">{if $currentItem->id}Редактирование{else}Добавление{/if} оплаты{form_errors_summary}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;"></b> Название:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="title" style="width:400px;" value=$currentItem->getProperty('title')|escape class="input"}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">Oписание&nbsp;&nbsp;</td><td></td>
			</tr>
			<tr>
                <td class="contentCenter" colspan = 3 align=center>{form_textarea name="text" class="as-visual" style="width:800px; height:200px;" value=$currentItem->getProperty('text') }</td>
            </tr>
			<tr>
				<td class="contentCenter"></td>
				<td class="contentCenterLeft"><b style="color:#CB0000;"></b> Группа:&nbsp;&nbsp;</td>
				<td class="contentCenterRight rightArea">
				<select name="group" style="width:400px;">
					{foreach from=$ListPay2 item=item}
					<option value="{$item->id}" {if $item->id == $currentItem->group}selected{/if}>{$item->title}</option>
					{/foreach}
				</salect>
				
				</td>
			</tr>
			<tr>
				<td class="contentCenter"></td>
				<td class="contentCenterLeft"><b style="color:#CB0000;"></b> Способ оплаты:&nbsp;&nbsp;</td>
				<td class="contentCenterRight rightArea">
				<select name="type_pay" id="type_pay" style="width:400px;">
					<option value="0" {if 0 == $currentItem->type_pay}selected{/if}>Наличные (квитанции)</option>
					<option value="1" {if 1 == $currentItem->type_pay}selected{/if}>Безналичные (поручительство)</option>
					<option value="2" {if 2 == $currentItem->type_pay}selected{/if}>Интеркасса</option>
					<option value="3" {if 3 == $currentItem->type_pay}selected{/if}>Другое</option>
				</td>
            <tr id='url_sistem_tr'>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;"></b> Ссылка на систему:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="url_sistem" style="width:400px;" value=$currentItem->getProperty('url_sistem') class="input"}</td>
            </tr>
            {*}<tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;"></b> Ссылка на интеркассу:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="url_pay" style="width:400px;" value=$currentItem->getProperty('url_pay') class="input"}</td>
            </tr>{*}
			<tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;"></b> Скидка:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="sale" style="width:400px;" value=$currentItem->getProperty('sale') class="input"}</td>
            </tr>
			<tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;"></b> Время зачисления:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="time" style="width:400px;" value=$currentItem->getProperty('time') class="input"}</td>
            </tr>
			<tr id='type_sistem_tr'>
				<td class="contentCenter"></td>
				<td class="contentCenterLeft"><b style="color:#CB0000;"></b> Тип:&nbsp;&nbsp;</td>
				<td class="contentCenterRight rightArea">
				<select name="type" style="width:400px;">
					{foreach from=$ListPay item=item}
					<option value="{$item->id}" {if $item->id == $currentItem->type}selected{/if}>{$item->name} </option>
					{/foreach}
				</salect>
				
				</td>
			</tr>
			
			<tr>
				<td class="contentCenter"></td>
				<td class="contentCenterLeft"> Изображение (160x160):&nbsp;&nbsp;</td>
				<td class="contentCenterRight rightArea">
					{if $currentItem->image} 
						<br /><img src="{$SITE_URL}/upload/pay/{$currentItem->image}" alt="" title="" />
						<br />{form_checkbox name="deleteImage" value="1" checked=0 style="width:20px;"}&nbsp;Удалить изображение<br /><br />
					{/if}{form_file name="image" style="height:20px;"}</td>
			</tr>
			<tr>
				<td class="contentCenter"></td>
				<td class="contentCenterLeft">Активен:&nbsp;&nbsp;</td>
				<td class="contentCenterRight rightArea">{form_checkbox name="active" value="1" checked=$currentItem->active style="width:20px;"}</td>
			</tr>
			<tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;"></b> Активен у статусах пользователей:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">
                	{form_checkbox name="activStatusUser1" value="1" checked=$currentItem->StatusUser1 style="width:20px;margin-left:0px;"} &nbsp;&nbsp; Физическое лицо <p>
                	{form_checkbox name="activStatusUser2" value="2" checked=$currentItem->StatusUser2 style="width:20px;margin-left:-20px;"} &nbsp;&nbsp; Юридическое лицо <p>
                	{form_checkbox name="activStatusUser3" value="3" checked=$currentItem->StatusUser3 style="width:20px;margin-left:-20px;"} &nbsp;&nbsp; Индивидуальный предприниматель <p>
        	    </td>
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
{literal}
<script type='text/javascript'>
$(document).ready(function(){
	$('#type_pay').change( function () {
		//alert($('#type_pay').val());
		if ($(this).val() == 0 || $(this).val() == 1)
		{
			$('#url_sistem_tr').hide();
			$('#type_sistem_tr').hide();
		}
		if ($(this).val() == 3)
		{
			$('#url_sistem_tr').show();
			$('#type_sistem_tr').hide();
		}
		if ($(this).val() == 2)
		{
			$('#url_sistem_tr').hide();
			$('#type_sistem_tr').show();
		}
	});
	$('#type_pay').change();
});
</script>
{/literal}
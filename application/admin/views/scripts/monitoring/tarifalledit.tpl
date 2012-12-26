{include file="editor_init.tpl"}


<script type="text/javascript" src="/scripts/jquery.js"></script>

<style type="text/css"> @import url("{$MODULE_URL}/js/calendar/calendar-win2k-1.css"); </style>
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
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Название:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="name"  value=$currentItem->name}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;"></b> Символ:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="simb"  value=$currentItem->simb style="width:15px;"}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;"></b> Бонус (%):&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="bonus"  value=$currentItem->bonus style="width:25px;"}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Информация:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{*form_text name="about"  value=$currentItem->about*}</td>
      </tr>
      <tr>
        <td class="contentCenter" colspan="3" align="center">{form_textarea name="about" class="as-visual" style="width:675px; height:250px;" value=$currentItem->about }</td>
      </tr>
      <tr>
       <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Категория:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{*form_text name="type"  value=$currentItem->type*}
			<select name='type'>
				{foreach from=$type item=item}
				<option value={$item->id} {if $item->id == $currentItem->id}selected{/if}>{$item->name}</option>
				{/foreach}
			</select>
		</td>
      </tr>
       <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;"></b> Тип:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">
			<select name='type2' id='type2'>
				<option value=0 {if 0 == $currentItem->type2}selected{/if}>Регулярный</option>
				<option value=1 {if 1 == $currentItem->type2}selected{/if}>История</option>
			</select>
			{literal}
			<script type="text/javascript">
				$('#type2').change(function(){
					if($(this).val() == 1)
						$('.period').hide();
					else
						$('.period').show();
						
				});
			</script>
			{/literal}
		</td>
      </tr>
       <tr class='period'>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Регулярность 1:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{*form_text name="reg1"  value=$currentItem->reg1*}
			<select name='reg1'>
				{foreach from=$period item=item}
				<option value={$item->id} {if $item->id == $currentItem->reg1}selected{/if}>{$item->title} ({$item->cnt} дней / {$item->skidka}% скидка)</option>
				{/foreach}
			</select>
		</td>
      </tr>
       <tr class='period'>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Регулярность 2:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{*form_text name="reg2"  value=$currentItem->reg2*}
			<select name='reg2'>
				{foreach from=$period item=item}
				<option value={$item->id} {if $item->id == $currentItem->reg2}selected{/if}>{$item->title} ({$item->cnt} дней / {$item->skidka}% скидка)</option>
				{/foreach}
			</select>
		</td>
      </tr>
       <tr class='period'>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Регулярность 3:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{*form_text name="reg3"  value=$currentItem->reg3*}
			<select name='reg3'>
				{foreach from=$period item=item}
				<option value='{$item->id}' {if $item->id == $currentItem->reg3}selected{/if}>{$item->title} ({$item->cnt} дней / {$item->skidka}% скидка)</option>
				{/foreach}
			</select>
		</td>
      </tr>
       <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;"></b> Типы событий:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">
			<ul>
				{foreach from=$typeList item=item}
				<li style='float:none; height:28px;'><label><input style='width:20px' name='event[{$item->id}]' type=checkbox value='1' {if $currentItem->getEventType($item->id)}checked{/if}>{$item->title} </label>
				{/foreach}
			</ul>
		</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft">Активен:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_checkbox name="isActive" value="1" checked=$currentItem->isActive style="width:20px;"}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft">Тарифы:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">
			<table border=1  style='width:270px'>
				<tr>
					<th>
						&nbsp;
					</th>
					<th>
						Колличество компаний (от)
					</th>
					<th>
						Период 1 {if $settings->get('periodDay1')}({$settings->get('periodDay1')} дней){/if}
					</th>
					<th class='period'>
						Период 2 {if $settings->get('periodDay2')}({$settings->get('periodDay2')} дней){/if}
					</th>
					<th class='period'>
						Период 3 {if $settings->get('periodDay3')}({$settings->get('periodDay3')} дней){/if}
					</th>
					<!--td>
						{$item->pY}&nbsp;
					</td-->
				</tr>
				{foreach from=$tarif item=item}
				<tr>
					<td style='width:30px'>
						<input style='width:20px' name='tarifs[{$item->id}]' type=checkbox value='1' {if $currentItem->getTarifType($item->id)}checked{/if}>
					</td>
					<td style='width:60px'>
						{$item->num}&nbsp;
					</td>
					<td style='width:60px'>
						{$item->pM}&nbsp;
					</td>
					<td style='width:60px' class='period'>
						{$item->pK}&nbsp;
					</td>
					<td style='width:60px' class='period'>
						{$item->pH}&nbsp;
					</td>
					<!--td>
						{$item->pY}&nbsp;
					</td-->
				</tr>
				{/foreach}
			</table>
		</td>
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
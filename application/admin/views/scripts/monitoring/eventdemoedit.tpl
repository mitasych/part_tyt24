<script type="text/javascript" src="{$MODULE_URL}/js/calendar/calendar.js"></script>
<script type="text/javascript" src="{$MODULE_URL}/js/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="{$MODULE_URL}/js/calendar/lang/calendar-ru.js"></script>
<style type="text/css"> @import url("{$MODULE_URL}/js/calendar/calendar-win2k-1.css"); </style>
<tr>
    <td class="allcontent">
    {form from=$form}
    {form_hidden name="id" value=$currentItem->id}
    {form_hidden name="kontragent_id" value=$kontragent->id}
    
    {form_hidden name="a" value=$a}
    <table>
      <tr>
        <td class="contentTop">&nbsp;</td>
        <td class="contentTopLeft">Действие:&nbsp;&nbsp;</td>
        <td class="contentTopRight">{if $currentItem->id}Редактирование{else}Добавление{/if} события для {$kontragent->inn|escape}{form_errors_summary}</td>
      </tr>
      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Дата события&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_text name="event_date" id="event_date" style="width:150px;" value=$currentItem->getEventDateFormatted() readonly="readonly"}
            &nbsp;<button type="submit" id="cal-button-1" class="batton" style="width:40px; margin-top:5px;">...</button>

			{literal}
			<script type="text/javascript">
				Calendar.setup({
				inputField    : "event_date",
				button        : "cal-button-1",
				ifFormat 	  : "%d-%m-%Y %H:%M:%S",
				showsTime     : true,
				timeFormat    : "24",
				align         : "Tr"
				});
			</script>
			{/literal}</td>
      </tr>

      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Тип события:&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_select name="type_id" selected=$currentItem->typeId options=$eventTypes style="width:400px;"}</td>
      </tr>

      <tr>
        <td class="contentCenter"></td>
        <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Текст&nbsp;&nbsp;</td>
        <td class="contentCenterRight rightArea">{form_textarea name="content"  value=$currentItem->content}</td>
      </tr>
      
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
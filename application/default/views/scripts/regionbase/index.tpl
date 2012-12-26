{literal}
<style>
.subrubric_hide{display: none;}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$(".db_sale").hover(function() {
		$("#db_sale").css("display", "block");
	},function() {
		$("#db_sale").css("display", "none");
	});
	
	$(".db_subrub").hover(function() {
		$("#db_subrub").css("display", "block");
	},function() {
		$("#db_subrub").css("display", "none");
	});
	
	$(".db_note").hover(function() {
		$("#db_note").css("display", "block");
	},function() {
		$("#db_note").css("display", "none");
	});
	
	$(".db_desc1").hover(function() {
		$("#db_desc1").css("display", "block");
	},function() {
		$("#db_desc1").css("display", "none");
	});
	$(".db_desc2").hover(function() {
		$("#db_desc2").css("display", "block");
	},function() {
		$("#db_desc2").css("display", "none");
	});
	$(".db_desc3").hover(function() {
		$("#db_desc3").css("display", "block");
	},function() {
		$("#db_desc3").css("display", "none");
	});
	
	$("#name1").click(function () {
		$("body").find("#db_rub_count1").css("display", "block");
		$("body").find("#db_rub_cost1").css("display", "block");
		
		$("body").find("#db_rub_count2").css("display", "none");
		$("body").find("#db_rub_cost2").css("display", "none");
		
		$("body").find("#db_rub_count3").css("display", "none");
		$("body").find("#db_rub_cost3").css("display", "none");
		
		$("#name1").removeClass("db_mark_on");
		$("#name2").removeClass("db_mark_tele_on");
		$("#name3").removeClass("db_mark_email_on");
		$("#name1").addClass("db_mark_on");
		$("#name2").addClass("db_mark_tele");
		$("#name3").addClass("db_mark_email");
		return false;
	});
	$("#name2").click(function () {
		$("body").find("#db_rub_count1").css("display", "none");
		$("body").find("#db_rub_cost1").css("display", "none");
		
		$("body").find("#db_rub_count2").css("display", "block");
		$("body").find("#db_rub_cost2").css("display", "block");
		
		$("body").find("#db_rub_count3").css("display", "none");
		$("body").find("#db_rub_cost3").css("display", "none");
		
		$("#name1").removeClass("db_mark_on");
		$("#name2").removeClass("db_mark_tele_on");
		$("#name3").removeClass("db_mark_email_on");
		$("#name1").addClass("db_mark");
		$("#name2").addClass("db_mark_tele_on");
		$("#name3").addClass("db_mark_email");
		return false;
	});
	$("#name3").click(function () {
		$("body").find("#db_rub_count1").css("display", "none");
		$("body").find("#db_rub_cost1").css("display", "none");
		
		$("body").find("#db_rub_count2").css("display", "none");
		$("body").find("#db_rub_cost2").css("display", "none");
		
		$("body").find("#db_rub_count3").css("display", "block");
		$("body").find("#db_rub_cost3").css("display", "block");
		
		$("#name1").removeClass("db_mark_on");
		$("#name2").removeClass("db_mark_tele_on");
		$("#name3").removeClass("db_mark_email_on");
		$("#name1").addClass("db_mark");
		$("#name2").addClass("db_mark_tele");
		$("#name3").addClass("db_mark_email_on");
		return false;
	});
	
	$("a#list_all").click(function () {
		$(".subrubric_hide").each(function(){
			if($(this).hasClass("hide")) {
				$(this).removeClass("hide");
				$(this).show();
			}else{
				$(this).addClass("hide");
				$(this).hide();
			}
		});
	});
});
</script>
{/literal}

<table class='db_table'>
<tr>
<td width='69%'><h1 class='db_h1'>{$db_name}</h1></td>
<td width='31%' style='padding-top: 20px;'><div class='db_ibd'><a style='color: #FF9A31;' href='{$SITE_URL}/#'>Индивидуальные базы данных</a></div></td>
</tr>
<tr>
<td style='vertical-align: top;'>
	{if $level > 1}
		<div class='db_field'>Вышестоящая рубрика:</div>
		<a href='{$SITE_URL}/regionbase/index/id/{$db_parent}/'>{$db_parent_name}</a>
	{/if}
	<div class='db_field'>Формат данных:</div>
	{$db_format}
	
	<div class='db_field'>Поля базы данных:
		<img class='db_note' src='{$SITE_URL}/img/db_info.png'>
		<div class='db_info_txt' id='db_note'>
			<div id='onlytxt' style='font-weight: normal;'>{$db_note}</div>
		</div>
	</div>
	{$db_field}
	
	{if $db_temp_link}<div class='db_field'>» <a style='font-weight: normal; color: red;' href='{$db_temp_link}'>пример базы данных</a></div>{/if}
	
	<div class='db_field' id='main_lnk'>{$db_name1}: <img class='db_desc1' src='{$SITE_URL}/img/db_info2.png'> <span>{$count_all}</span></div>
	<div class='db_info_txt' id='db_desc1'><div id='onlytxt'>{$db_desc1}</div></div>
	
	<b class='db_h2'>{$db_cost} руб.</b>
	<img class='db_sale' src='{$SITE_URL}/img/db_info.png'>
	<div class='db_info_txt' id='db_sale'>
		<div id='wartxt'><b id='hdr'>Скидка</b><br>{$db_sale}</div>
	</div>
	<div style='float: right;'><input type='submit' name='btnZakaz' class='db_btn_zakaz' value=''></div>
	<div style='clear: both;'></div>
</td>
<td style='vertical-align: top;'>
	{if $level < 3}
		<table width='100%'>
		<tr>
			<td class='db_field'>Содержание (подрубрики):</td>
			<td width='20' align='center'>
				<img class='db_subrub' src='{$SITE_URL}/img/db_info.png'>
				<div class='db_info_txt' id='db_subrub'>
					<div id='onlytxt'>Каждую из нижеуказанных подрубрик можно приобрести в отдельности.</div>
				</div>
			</td>
		</tr>
		{assign var="count" value=0}
		{foreach from=$subrubric_list item=subrubric}
			{assign var="count" value=$count+1}
			{if $count > $db_top_comp}
				<tr class='subrubric_hide hide'>
					<td class='sr_100'><a href='{$SITE_URL}/regionbase/index/id/{$subrubric.id}/'>{$subrubric.name} ({$subrubric.c_all})</a></td>
					<td width='20' align='center'><a href='#'><img src='{$SITE_URL}/img/db_korzina_off.png'></a></td>
				</tr>
			{else}
				<tr>
					<td class='sr_100'><a href='{$SITE_URL}/regionbase/index/id/{$subrubric.id}/'>{$subrubric.name} ({$subrubric.c_all})</a></td>
					<td width='20' align='center'><a href='#'><img src='{$SITE_URL}/img/db_korzina_off.png'></a></td>
				</tr>
			{/if}
		{/foreach}
		<tr>
		<td colspan='2'><a href='#' id='list_all' style='color: red; font-size: 11px;'>Показать/скрыть весь список >>></a></td>
		</tr>
		</table>
	{else}
		<div class='db_field'>Содержание (предприятия):</div>		
		{foreach from=$company_list item=company}			
			<a href='{$SITE_URL}/item/index/id/{$company.sys_id}/'>{$company.single_abbr} "{$company.single_name}"</a><br>
		{/foreach}				
	{/if}
</td>
</tr>
<tr>
<td colspan='2' style='padding-top: 15px; vertical-align: top;'>
	<table style='width: 600px;'>
	{if $db_enable2}
		<tr>
		<td class='db_blue' style='height: 30px;'>
			{$db_name2}
			<img class='db_desc2' src='{$SITE_URL}/img/db_info2.png'>
			<div class='db_info_txt' id='db_desc2'><div id='onlytxt'>{$db_desc2}</div></div>
		</td>
		<td width='75' align='right'><b>{$count_phone}</b></td>
		<td width='75' align='right' class='db_blue'>{$db_cost_tele}</td>
		<td width='150' align='right'><input type='submit' value='' name='btnZakakazTele' class='db_min_zakaz'></td>
		</tr>
	{/if}
	{if $db_enable3}
		<tr>
		<td class='db_blue' style='height: 30px;'>
			{$db_name3}
			<img class='db_desc3' src='{$SITE_URL}/img/db_info2.png'>
			<div class='db_info_txt' id='db_desc3'><div id='onlytxt'>{$db_desc3}</div></div>
		</td>
		<td align='right'><b>{$count_email}</b></td>
		<td align='right' class='db_blue'>{$db_cost_email}</td>
		<td align='right'><input type='submit' value='' name='btnZakakazEmail' class='db_min_zakaz'></td>
		</tr>
	{/if}
	</table>
	
	<table width='100%' style='margin-top: 20px;'>
	<tr>
	<td colspan='4' style='padding-bottom: 10px;'>
		{if $db_enable1}<div class='db_mark_on' id='name1'><b id='uppercase'>{$db_name1}</b><br>{$db_desc1}</div>{/if}
		{if $db_enable2}<div class='db_mark_tele' id='name2'><b id='uppercase'>{$db_name2}</b><br>{$db_desc2}</div>{/if}
		{if $db_enable3}<div class='db_mark_email' id='name3'><b id='uppercase'>{$db_name3}</b><br>{$db_desc3}</div>{/if}
	</td>
	</tr>
	<tr>
	<td class='db_blue'>Другие базы данных в рубрике {$db_parent_name}:</td>
	<td width='100' class='db_blue'>Количество:</td>
	<td width='100' class='db_blue'>Цена:</td>
	<td width='20'></td>
	</tr>
	{foreach from=$rubric_list item=rubric}
		<tr>
		<td><a href='{$SITE_URL}/regionbase/index/id/{$rubric.id}/'>{$rubric.name}</a></td>
		<td>
			{if $db_enable1}<div id='db_rub_count1'>{$rubric.c_all}</div>{/if}
			{if $db_enable2}<div id='db_rub_count2'>{$rubric.c_tele}</div>{/if}
			{if $db_enable3}<div id='db_rub_count3'>{$rubric.c_email}</div>{/if}
		</td>
		<td>
			{if $db_enable1}<div id='db_rub_cost1'>{$rubric.cost}</div>{/if}
			{if $db_enable2}<div id='db_rub_cost2'>{$rubric.cost_tele}</div>{/if}
			{if $db_enable3}<div id='db_rub_cost3'>{$rubric.cost_email}</div>{/if}
		</td>
		<td><a href='#'><img src='{$SITE_URL}/img/db_korzina_off.png'></a></td>
		</tr>
	{/foreach}
	</table>
</td>
</tr>
</table>
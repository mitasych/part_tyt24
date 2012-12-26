{literal}
<script type="text/javascript">

$(document).ready(function() {	

			$('#dialog').dialog({
				width: 237, 
				modal: true,
				autoOpen: false,
			});
			
			//$('#category_box').show();
		});
		
var change_tr_arr = [];
function change_tr(id){
	if(change_tr_arr[id] == undefined || change_tr_arr[id] == false){
		$('.gridTable tr#'+id).css('background-color','#ffe9ae');
		$('.gridTable tr#'+id+' td').css('font-weight','bold');
		window.idtpl = id;
		changePrimer();
		change_tr_arr[id] = true;
	}else{
		$('.gridTable tr#'+id).css('background-color','#fff');
		$('.gridTable tr#'+id+' td').css('font-weight','normal');
		change_tr_arr[id] = false;
	}
	$('#ot'+id).toggle();
	$('#td'+id).toggle();
}

function changePrimer(id) {
var msg = $('#text_tpl'+idtpl).val();
	$.ajax({
		type: "post",
		url: "/sms/primer-tpl",
		cache: false,
		dataType: 'json',
		data: ({msg : msg, id_contact : id}),
		success: function(data)
		{
			$('#text_primer'+idtpl).val(data.msg_c);
		}						
	});
}

function openDialog() {
	$('#dialog').dialog('option', 'title', 'Адресная книга');
	$('#dialog').dialog('open');
	return false;
}

function selectVal(num, tr_id) {
	id_contact = tr_id.split('_');
	changePrimer(id_contact[1]);
	$('#dialog').dialog('close');
}

var tr_arr = [];
function dbl(id){
	if(tr_arr[id] == undefined || tr_arr[id] == false){
		window.location.replace($('#href'+id).attr("href"));
		tr_arr[id] = true;
	}
		
}

function confirmAction(action, location) {
	var msg = action == 'delete' 
				? 'Вы действительно хотите удалить запись?' 
				: 'Вы уверены, что хотите выполнить данное действие?';
	
	var result = confirm(msg);
	if (location && result) window.location.href = location;
	return result;
}
</script>
{/literal}
<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

<div>
    <div class="main_top_text">

        {breadcrumb controller="sms" alias="sms" altTitle="Шаблоны сообщений"}
        {include file="lmenu.tpl"}
		<div>
	<h3>{$title}</h3>
	</div>
	<div id = "add_tpl" class="sms_tpl">
	<a href="/sms/sms-tpl-add" style="font-size:14px;">Добавить шаблон</a>
	</div>
	<div>
	<table class='gridTable tb' width="100%" cellpadding="2" cellspacing="1" border="1">
	<tr class="tbHeader gridOff">
		<td width = '50px' align='right'>ID</td>
		<td>Название</td>
		<td>Сообщение</td>
		<td>Тип шаблона</td>
		<td width = '80px'>Действия</td>
	</tr>
	{foreach from=$sms_tpl item=item}
	<tr id="{$item.id}" ondblclick ="dbl({$item.id})" onclick="change_tr({$item.id})" valign="top">
				<td align='right'>{$item.id}</td>
				<td>{$item.name_tpl}</td>
				<td>{$item.text_tpl}
					<textarea style="display:none;" id="text_tpl{$item.id}">{$item.text_tpl}</textarea>
				</td>
				<td>{$item.title_type}</td>	
				<td>
				<a id="href{$item.id}"  style="font-size:14px;" href="/sms/sms-tpl-edit/id/{$item.id}"><img border="0" src="{$MODULE_URL}/images/edit1.jpg" alt="Изменить"></a>	
				<a style="font-size:14px;" onclick="return confirmAction('delete')" href="/sms/sms-tpl-del/id/{$item.id}"><img border="0" src="{$MODULE_URL}/images/delete.jpg" alt="Удалить"></a>
				</td>
	</tr>
	<tr>
		<td colspan="2" id ="td{$item.id}" style="background-color:#F2F2F2;text-align:left;display:none;"></td>
		<td colspan="3"  id ="ot{$item.id}" style="background-color:#F2F2F2;text-align:left;display:none;">
	 		<div id="tpl_primer" style="overflow:hidden; font-size: 12px; line-height: 20px">
			       	<textarea readonly name="text_primer{$item.id}" id="text_primer{$item.id}" rows="5" cols="100" style="width: 300px"></textarea>
			       	<a id="addr_book_primer" onclick="openDialog();return false;" style="margin:0 3px; vertical-align: top;" href="#">Адресная книга</a>
			</div>
		</td>
	</tr>
	<tr>
	</tr>
	{/foreach}
	</table>
	</div
        <div class="dotted2"></div>
    </div>
    
    <div id="dialog" style="display: none">
    	<div class="ab-sc-cont">
		    <table class="ab-sc-cont2" cellspacing="0" border="0" callpadding="0">
		    {foreach from=$addr item=ab}
			<tr id="address_{$ab.id}" onclick = "selectVal({$ab.mobile_phone}, this.id)" class="ab-sc-cell">
				<td class="ab-sc-avatar">
				<div class="ab-sc-a-b">
					<div class="ab-sc-a-c">
						<img alt="avatar" src="{$MODULE_URL}/img/avatar.gif">
					</div>
				</div>
				</td>
				<td class="ab-sc-mix">
					<div class="ab-sc-mix-i">
					<div class="ab-sc-name" title="{$ab.name}">
						<div class="ab-sc-n-c" style="width: 180px;">
						<span>{$ab.name}</span>
						<i></i>
						</div>
					</div>
					<div class="ab-sc-ci-type" style="background-image: url('/img/phone.gif');" title="Телефон"></div>
					<div class="ab-sc-ci-data" style="font-size: 10px;">
						<div class="ab-sc-ci-data-c" style="padding-top: 3px; white-space: nowrap; overflow: hidden; width: 160px;" title="{$ab.mobile_phone}">{$ab.mobile_phone}</div>
					</div>
				</div>
				</td>
			</tr>
			
			<tr class="ab-sc-sep">
				<td colspan="3">&nbsp;</td>
			</tr>
			{/foreach}
		</table>
	</div>
    
    </div>
</div>



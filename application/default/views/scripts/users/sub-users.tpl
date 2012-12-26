<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}> 
     </div>
</div>

<div>
    <div class="main_top_text">
    <div>
	<h3>{$title}</h3>
	</div>
	<input type = "hidden" id = "status" value = "{$user->status}">
	<div id = "add_subuser" class="sub_users">
	<a href="/users/addsub-users/userid/{$user->id}" style="font-size:14px;">Добавить пользователя</a>
	</div>
	<div>
	<table class='gridTable tb' width="100%" cellpadding="2" cellspacing="1" border="1">
	<tr class="tbHeader gridOff">
		<td width = '50px' align='right'>ID</td>
		<td>Логин</td>	
		<td>E-mail</td>	
		<td>Имя</td>
		<td>Фамилия</td>
		<td>Отчество</td>
		<td width = '80px'>Управление</td>
	</tr>
	{foreach from=$sub_users item=item}
	<tr valign="top">
				<td align='right'>{$item.id}</td>
				<td>{$item.login}</td>	
				<td>{$item.email}</td>
				<td>{$item.name}</td>
				<td>{$item.second_name}</td>
				<td>{$item.third_name}</td>
				<td>
				<a style="font-size:14px;" href="/users/editsub-users/subid/{$item.id}"><img border="0" src="{$MODULE_URL}/images/edit1.jpg" alt="Редактировать"></a>	
				<a style="font-size:14px;" onclick="return confirmAction('delete')" href="/users/deletesub-users/subid/{$item.id}"><img border="0" src="{$MODULE_URL}/images/delete.jpg" alt="Удалить"></a>
				</td>
	</tr>
	{/foreach}
	</table>
	</div
        <div class="dotted2"></div>
    </div>
</div>

{literal}
<script type="text/javascript">

$(document).ready(function() {
var v = $('#status').val();
	if(v == 1) {
		$('#add_subuser').hide();
	}
return false;
});

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
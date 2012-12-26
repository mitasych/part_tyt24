{literal}
<script type="text/javascript">

$(document).ready(function(){   
   $('input[name="send_user"]').change(function() {
    $("#sendAkt").submit();
     //$("#sendAkt1").click();
   });
   $('input[name="send_kurator"]').change(function() {
     $("#sendAkt").submit();
     //$("#sendAkt1").click();
   });
   
});

</script>
{/literal}

<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

<div>
    <div class="main_top_text" style="min-height:442px">

        {breadcrumb controller="users" alias="profileEdit" altTitle="Личный кабинет"}

        {include file="lmenu.tpl"}

			<div style="float:right">
			{if $to == 1}
				<form action='' method=post id="sendAkt">
				отправлять акты: 
					<label><input type='checkbox' name='send_user' value='1' {if $user->akt_send_email == 1}checked{/if}>на e-mail</label>
					<label><input type='checkbox' name='send_kurator' value='1' {if $user->akt_send_kurator == 1}checked{/if}>по почте</label>
					<input type="submit" name="akt" value="akt" id="sendAkt1" style="display:none;"/>
				</form>
				{/if}
			</div>
            <div>
                <a href="/users/docs/userid/{$user->id}/to/0">{if $to == 0}<b>{/if}Договоры</b></a> {if $user->status != 1}| <a href="/users/docs/userid/{$user->id}/to/2/">{if $to == 2}<b>{/if}Счета</b></a> | <a href="/users/docs/userid/{$user->id}/to/1/">{if $to == 1}<b>{/if}Акты</b></a>{/if}
			</div>	
		 
        <div style="margin-top:5px;">
            
			<table style='width:100%;' cellspacing="0" cellpadding="0"  class="all_tarifs">
				<tr id="head">
					<td class="odd" style="height:30px;">№ {if $to == 0}договора{elseif $to == 2}счета {elseif $to == 1}акта {/if}
					</td>
					<td>Дата {if $to == 2}счета {elseif $to == 1}акта{/if}
					</td>
					{if $to == 2}
					<td class="odd">Срок оплаты
					</td>
					{/if}
					{if $to != 0}
					<td style="text-align:right">Сумма
					</td>
					{/if}
					{if $to == 2}
					<td style="text-align:left">Статус
					</td>
					{/if}
					<td>
					</td>
				</tr>
				{foreach from = $orders item = orderItem}
				{*if $orderItem->getServis() != 'Мониторинг' or $to == 0 *}
				<tr>
					<td class="odd">
						
						{if $to == 1}{$orderItem->getServis()|substr:0:2}/{/if}{if $to != 0 }{if $orderItem->number}{$orderItem->number}{else}{$orderItem->secretCode}{/if}{else} {$orderItem->number}{/if}
					</td>
					<td>
						{$orderItem->dateUpdated|date_format:"%d-%m-%Y"}
					</td>
					{if $to == 2}
					<td class="odd">
						{$orderItem->getDateUpdatedFor()|date_format:"%d-%m-%Y"}
					</td>
					{/if}
					{if $to != 0}
					<td style="text-align:right">
						{if $orderItem->getPriceString() != 'цена требует уточнения'}{$orderItem->getPriceString()}{else}?{/if}
					</td>
					{/if}
					{if $to == 2}
					<td style="text-align:left">
						
						{if $orderItem->getStatusLabel() == 'Оплачено' || $orderItem->getStatusLabel() == 'Заказ выполнен' || $orderItem->getStatusLabel() == 'Заказ передан клиенту'}
							Оплачен
						{else}
							Не оплачен
						{/if}
					</td>
					{/if}
					<td>
						<a href='{$orderItem->getURL($to)}'><img src='/images/doc.jpg'></a>
					</td>
				</tr>
{*				
	else}
				{foreach from = $orderItem->getMonitoringTarif() item=monitem key=ids}
				<tr>
					
					<td>
						{$orderItem->number}-{$ids}
					</td>
					<td>
						{$orderItem->dateUpdated|date_format:"%d-%m-%Y"}
					</td>
					{if $to == 2}
					<td>
						{$orderItem->getDateUpdatedFor()|date_format:"%d-%m-%Y"}
					</td>
					{/if}
					{if $to != 0}
					<td>
						{if $orderItem->getPriceString() != 'цена требует уточнения'}{$orderItem->getPriceString()}{else}?{/if}
					</td>
					{/if}
					<td>
						{if $to != 2}{$orderItem->getServis()}{else}Баланс{/if}
					</td>
					{if $to == 2}
					<td>
						{$orderItem->getStatusLabel()}
					</td>
					{/if}
					<td>
						<a href='{$orderItem->getURL($to)}'><img alt="doc" src='/images/doc.jpg'></a>
					</td>
				</tr>
				{/foreach}
	{/if
*}
				{/foreach}
					
				</tr>
			</table>
            {if $paging}<div>{$paging}</div>{/if}

        </div>


        <div class="dotted2"></div>
    </div>
</div>
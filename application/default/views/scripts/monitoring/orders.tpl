{literal}
<script type="text/javascript">

$(document).ready(function(){   
   $("#sort_select").bind('change',function() {
     $("#sortStatus").submit();
   });
   $("#sortStatus_b").bind('click',function() {
     $("#sortStatus").submit();
   });
});
var change_tr_arr = []
function change_tr(id){
	if(change_tr_arr[id] == undefined || change_tr_arr[id] == false){
		$('.all_tarifs tr#'+id).css('background-color','#ffe9ae');
		$('.all_tarifs tr#'+id+' td').css('font-weight','bold');
		change_tr_arr[id] = true;
	}else{
		$('.all_tarifs tr#'+id).css('background-color','#fff');
		$('.all_tarifs tr#'+id+' td').css('font-weight','normal');
		change_tr_arr[id] = false;
	}
	$('#ot'+id).toggle();
}
</script>
{/literal}
<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>
<div>
    <div class="main_top_text">

        {breadcrumb controller="users" alias="profileEdit" altTitle="Личный кабинет"}

        {include file="lmenu.tpl"}
			<div style="float:right;margin-bottom: 10px;">
			<form method="post" action="" id="sortStatus" onchange="" style="display:inline;" >
			
			  
			 <input type=text name=id_order placeholder='Номер заказа' style="width: 100px;"> 
			 <input type="submit" value="sort" id="sortStatus" style="display:none;" />
			 <input type="button" value="Найти" id="sortStatus_b" />
			 
			 <span style="color:#1F5763;" > &nbsp;&nbsp;&nbsp;Статус заказа </span>
			  <select name="sort_type" id="sort_select" >
			 <option value="5" />Все статусы</option>
              
			  {foreach from = $types item = typeItem}
               <option value="{$typeItem->number}" {if $typeItem->number== $selected } selected  {/if} />{$typeItem->text}</option>
			  {/foreach}
			 </select>
			<br>
            </form> 
			</div><br><br>
        <div>
            <table style='width:100%' class="all_tarifs" cellpading="o" cellspacing="0">
				<tr id="head" >
					<td class="odd" width="50" style="height:30px;">(+)/(-)
					</td>
					<td align="left">№ заказа
					</td>
					<td align="left" class="odd"width="80">Дата
					</td>
					<td align="left">Сумма
					</td>
					<td align="left" class="odd" style="text-align:left">Сервис/сайт
					</td>
					
					<td align="left" style="text-align:left">Статус
					</td>
					
				</tr>
            {foreach from = $orders item = orderItem}
				<tr  onclick ="change_tr({$orderItem->id})" id="{$orderItem->id}">
					<td class="odd" style="height:30px;">
						<b>({if !$orderItem->isBalans()}-{else}+{/if})</b>
					</td>
					<td>
						{if $orderItem->number}{$orderItem->number}{else}{$orderItem->secretCode}{/if}
					</td>
					<td class="odd">
						{$orderItem->dateUpdated|date_format:"%d-%m-%Y"}
					</td>
					<td  style="text-align:right">
						{if $orderItem->getPriceString() != 'цена требует уточнения'}{$orderItem->getPriceString()}{else}?{/if}
					</td>
					<td class="odd" style="text-align:left">
						{if !$orderItem->isBalans()}{$orderItem->getServis()}{else}{$orderItem->placeCreated}{/if}
					</td>
					<td style="text-align:left" width="169">
						{$orderItem->getStatusLabel()}
					</td>
					
					
					<td>
					{*<p> <a href="javascript:void(0)" style="color:{$orderItem->getColor()}">
							<b>{if !$orderItem->isBalans()}-{else}+{/if} № </b>{if $orderItem->number}{$orderItem->number}{else}{$orderItem->secretCode}{/if}
							
						</a>{$orderItem->getDateUpdatedFormatted()} / {$orderItem->getPriceString()} / {$orderItem->getStatusLabel()}</p>*}
					</td>
					
				</tr>
				<tr >
					<td colspan="6"  id ="ot{$orderItem->id}" style="background-color:#F2F2F2;text-align:left;display:none;"> &nbsp;
					<div>
						{include file="order/order_info.tpl" orderItem = $orderItem}
						{include file="order/pay_after_price_detect.tpl" orderItem = $orderItem}
						
					</div>
					
					</td>
				</tr>
            {/foreach}				
			</table>
			<hr color="#FF8C00" width="100%" size="1px">

        </div>


        <div class="dotted2"></div>
    </div>
</div>
{literal}
<script type="text/javascript">

$(document).ready(function(){   
   $("#sort_select").bind('change',function() {
     $("#sortStatus").submit();
   });
   $("#sortStatus_b").bind('click',function() {
     $("#sortStatus").submit();
   });
    $("select[name=select_ord] option[value="+{/literal}"{$select_ord_value}"{literal}+"]").attr("selected","selected");
});
var change_tr_arr = []
function change_tr(id){
	if(change_tr_arr[id] == undefined || change_tr_arr[id] == false){
		$('.all_tarifs tr#'+id).css('background-color','#ffe9ae');
		$('.all_tarifs tr#'+id+' td').css('font-weight','bold');
		$('.all_tarifs tr#'+id+' td a').css({'color':'red', 'text-decoration': 'none'});
		$('.all_tarifs tr#'+id+' td a').next('img').attr('src','/images/drill_up_red.jpg');
		change_tr_arr[id] = true;
	}else{
		$('.all_tarifs tr#'+id).css('background-color','#fff');
		$('.all_tarifs tr#'+id+' td').css('font-weight','normal');
		$('.all_tarifs tr#'+id+' td a').css({'color':'#2D96FE', 'text-decoration': 'underline'});
		$('.all_tarifs tr#'+id+' td a').next('img').attr('src','/images/drill_down.jpg');
		change_tr_arr[id] = false;
	}
	$('#ot'+id).toggle();
}
</script>
<style type="text/css">
.my_orders tr#inner{
color: #33ACFF;
    font-size: 12px;
    font-weight: bold;
}
</style>
{/literal}

{*<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>*}

<div>
    <div class="main_top_text">

        {breadcrumb controller="users" alias="profileEdit" altTitle="Личный кабинет"}

        {include file="lmenu.tpl"}
		<div >
			<form method="post" action="" id="sortStatus" onchange="" style="display:inline;" >

			 <input type="submit" value="sort" id="sortStatus" style="display:none;" />
			 
			{literal}
			<script type="text/javascript">
				function filter_operation(value, id_user){
					if(value==1){
						$("form#sortStatus").attr("action","/users/plateji/userid/"+id_user+"/");
						$("form#sortStatus").submit();
					}else{
						if(value==2){
							$("form#sortStatus").attr("action","/users/plateji/userid/"+id_user+"/to/1");
							$("form#sortStatus").submit();
						}else{
							if(value==3){
								$("form#sortStatus").attr("action","/users/plateji/userid/"+id_user+"/to/2");
								$("form#sortStatus").submit();
							}
						}
					}
				}
			</script>
			{/literal}
			<table width="100%"><tr>
			<td>
			<div class="style_input" style="display: inline-block;">
				<input type='text' name='id_order' placeholder='№ заказа' maxlength ="7" style="width:70px" value="{$id_order_value}"/>
			 </div>
			 <div class="addx2" style="display: inline-block;">
				<input type="button" value="Найти" id="sortStatus_b" />
			 </div>
			 </td><td>
			 <div class="style-select" style="width: 160px;  display: inline-block; display: -moz-inline-box; margin-left: 15px; margin: 0px 3%;">
				<select name="select_ord" style="font-size: 11px; width: 185px;" onchange="filter_operation(this.value, {$user->id});">
				<option value="1">Все заказы (+/-)</option>
				<option value="2">Заказ услуг (-)</option>
				<option value="3">Пополнение баланса (+)</option>
				</select>
            </div>
			</td><td>
			 <div class="style-select" style="width: 160px; display: inline-block;display: -moz-inline-box; float: right;">
			  <select style="font-size: 11px; width: 185px;" id="sort_select" name="sort_type">
			 
			 <option value="5" />Все статусы заказа</option>
              
			  {foreach from = $types item = typeItem}
               <option value="{$typeItem->number}" {if $typeItem->number== $selected } selected  {/if} />{$typeItem->text}</option>
			  {/foreach}
			 </select>
			 </div>
			 </td>
			 </tr></table>
			<br>
            </form> 
			</div>			

        <div>
            
			<table style='width:100%' cellspacing="0" cellpadding="0" class="all_tarifs">
				<tr id="head" >
					<td width="70px">№ заказа</td>
					<td>Дата</td>
					<td>Стоимость</td>
					<td>Источник</td>
					<td>Статус</td>
				</tr>
					{foreach from = $orders item = orderItem}
				<tr  onclick ="change_tr({$orderItem->id})" id="{$orderItem->id}">
					
					<td>
						<a href="javascript:void(0)"  id="{$orderItem->id}">
                    <!-- <b>№ счета: </b> -->{if $orderItem->number}{$orderItem->number}{else}{$orderItem->secretCode}{/if}                 
                    </a>
					<img src="/images/drill_down.jpg"/>
					</td>
					<td>						{$orderItem->dateUpdated|date_format:"%d-%m-%Y"}
					</td>
					<td style="text-align:right; height:30px;">
						{if $orderItem->getPriceString() == 'цена требует уточнения'}-{else}{if !$orderItem->isBalans()}-{else}+{/if}{$orderItem->getPriceString()}{/if} 
					</td>
					
					<td style="text-align:left">
						{if !$orderItem->isBalans()}{$orderItem->getServis()}{else}{$orderItem->placeCreated}{/if}
					</td>
					<td style="text-align:left">{$orderItem->getStatusLabel()}
					</td>
					
					
	
				</tr>
				<tr id ="ot{$orderItem->id}" style="background-color:#F2F2F2;text-align:left;display:none;cursor:default;">
					<td colspan="5"  style="padding-left:20px;background-color: #FAF0E0;"> &nbsp;
						{include file="order/order_info.tpl" orderItem = $orderItem}
						{include file="order/pay_after_price_detect.tpl" orderItem = $orderItem}
						
					
					</td>
				</tr>
					{/foreach}
					
				</tr>
			</table>
            {if $paging}<p class="right" style="text-align:right;">{$paging}</p>{/if}

        </div>


        <div class="dotted2"></div>
    </div>
</div>
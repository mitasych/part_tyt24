{literal}
<script type="text/javascript">

$(document).ready(function(){   



   $("#sortStatus_b").bind('click',function() {
     $("#sortStatus").submit();
   });

    $("select[name=select_ord] option[value="+{/literal}"{$select_ord_value}"{literal}+"]").attr("selected","selected");
	$("#sort_select option[value="+{/literal}"{$sort_type_value}"{literal}+"]").attr("selected","selected");
    $("select[name=sort_service] option[value="+{/literal}"{$sort_service_value}"{literal}+"]").attr("selected","selected");	
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
.all_tarifs tr td {
    cursor: pointer;
}
.all_tarifs tr {
    cursor: pointer;
}
</style>
{/literal}

{*<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>*}

<div id="ajax_2">

    <div class="main_top_text">

        {breadcrumb controller="users" alias="profileEdit" altTitle="Личный кабинет"}
		
        {include file="lmenu.tpl"}
		<span style="float:right;color:red;font-weight:bold;"> 
                              Баланс <span style="color:#2D96FE;">{$user->balans} руб.</span> 
                             <a href="{$SITE_URL}/order/balans/" style="text-decoration:underline;color:red;font-weight:bold;">пополнить</a> 
                       </span>
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

			 <div class="style-select" style="width: 130px;  display: inline-block; display: -moz-inline-box; margin-left: 15px; margin: 0px 3%;">
				<select name="select_ord" id="vall_plateji" style="font-size: 11px; width: 185px;" onchange="ajax_load_plateji(this.value);">
					<option value="1" {if $sort_Plateji_val== "1" } selected  {/if}>Все платежы (+/-)</option>
					<option value="2" {if $sort_Plateji_val== "2" } selected  {/if}>Расход (-)</option>
					<option value="3" {if $sort_Plateji_val== "3" } selected  {/if}>Приход (+)</option>
				</select>
            </div>

			</td>
			<td>


				<input type="hidden" class="vall_status_contr" value="{$sort_statuse}">
				<input type="hidden" class="vall_servise_contr" value="{$sort_servicee}">
				<input type="hidden" class="vall_plateji_contr" value="{$sort_Plateji_val}">
				{literal}
					<script>


						function ajax_load_plateji(vall_plateji){

						   var vall_status_contr = $(".vall_status_contr").attr("value");
						   var vall_servise_contr = $(".vall_servise_contr").attr("value");

						   var urrl_ajax = window.location;
						   $('#ajax_2').load(""+urrl_ajax+" #ajax_2",{ id_sort_Servise: vall_servise_contr, id_sort_Status: vall_status_contr, id_sort_Plateji: vall_plateji });
						}


						function ajax_load_servise(vall_servise){

						   var vall_status_contr = $(".vall_status_contr").attr("value");
						   var vall_plateji_contr = $(".vall_plateji_contr").attr("value");	

						   var urrl_ajax = window.location;
						   $('#ajax_2').load(""+urrl_ajax+" #ajax_2",{ id_sort_Servise: vall_servise, id_sort_Status: vall_status_contr, id_sort_Plateji: vall_plateji_contr });
						}


						function ajax_load_status(vall_status){

						   var vall_status_contr = $(".vall_status_contr").attr("value");
						   var vall_plateji_contr = $(".vall_plateji_contr").attr("value");	
						   var vall_servise_contr = $(".vall_servise_contr").attr("value");

						   var urrl_ajax = window.location;
						   $('#ajax_2').load(""+urrl_ajax+" #ajax_2",{ id_sort_Servise: vall_servise_contr, id_sort_Status: vall_status, id_sort_Plateji: vall_plateji_contr });
						}

						function ajax_paging(vall_paging){
						   var vall_status_contr = $(".vall_status_contr").attr("value");
						   var vall_plateji_contr = $(".vall_plateji_contr").attr("value");	
						   var vall_servise_contr = $(".vall_servise_contr").attr("value");

						   var urrl_ajax = window.location;
						   $('#ajax_2').load(""+urrl_ajax+" #ajax_2",{ id_sort_Servise: vall_servise_contr, id_sort_Status: vall_status_contr, id_sort_Plateji: vall_plateji_contr, page:vall_paging});
						   return false;
						}
						
					</script>
				{/literal}
				
			<div class="style-select" style="width: 130px; display: inline-block;display: -moz-inline-box;">
			  <select style="font-size: 11px; width: 185px;" id="sort_service_select" name="sort_service" onchange="ajax_load_servise(this.value)">
			 		<option id="5" value="5">Все сервисы</option>
			 		{foreach from = $servis item = servisItem}
               			<option id="{$servisItem->id}" value="{$servisItem->id}" {if $servisItem->id== $sort_servicee } selected  {/if} >
               				{$servisItem->name}
               			</option>
			  		{/foreach}
			  </select>
			</div>
			</td>



			<td>
					
			 <div class="style-select" style="width: 130px; display: inline-block;display: -moz-inline-box; ">

			 	{literal}
             		<script>

             		function ajax_select(){
						$("#sortStatus").submit();
					}
	   					</script>
	   			{/literal}

			  <select style="font-size: 11px; width: 185px;" id="sort_select" name="sort_type"  onchange="ajax_load_status(this.value)">
			 	  <option value="5"  {if $sort_statuse== "5" } selected = selected  {/if} >Все статусы</option>
				  {foreach from = $types item = typeItem}
					  {if $typeItem->number != 20 && $typeItem->number != 60}
	              		 <option value="{$typeItem->number}" {if $typeItem->number==$sort_statuse}selected{/if}>{$typeItem->text}</option>
					  {/if}
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
					<td>Сервис</td>
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
						{if $orderItem->getStatusLabel()!='Баланс пополнен'}{$orderItem->getServis()}{else}Баланс{/if}
						{*{if !$orderItem->isBalans()}{$orderItem->getServis()}{else}Баланс{/if}*}
					</td>
					<td style="text-align:left">
						
					{if $orderItem->getStatusLabel() == 'Заказ передан клиенту' || $orderItem->getStatusLabel() == 'Заказ выполнен'}
						{if !$orderItem->isBalans()}
							Заказ передан клиенту
						{else}
							Баланс пополнен
						{/if}
					{else}
						{$orderItem->getStatusLabel()}
					{/if}
					
					</td>
					
					
	
				</tr>
				<tr id ="ot{$orderItem->id}" style="background-color:#F2F2F2;text-align:left;display:none;cursor:default;">
					<td colspan="5"  style="padding-left:20px;background-color: #FAF0E0;"> &nbsp;
					{if $orderItem->getServis() == 'Баланс'}
						{include file="order/balans_info.tpl" orderItem = $orderItem}
					{else}
						{include file="order/order_info.tpl" orderItem = $orderItem}
					{/if}
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

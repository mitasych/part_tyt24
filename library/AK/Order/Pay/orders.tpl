{literal}
<script type="text/javascript">

$(document).ready(function(){ 


$("#sort_service_select option[value='1']").attr("selected","selected");


/*
    $('#sort_service_select').change(function(){
      var urrl_ajax = window.location;
      var id_sort_Status = $(this).val();

      $('#ajax_2').load(""+urrl_ajax+" #ajax_2",{id_sort_Status:id_sort_Status});
     
    });
*/

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
		 <div >
			<form method="post" action="" id="sortStatus" onchange="" style="display:inline;" >
			
			 <input type="submit" value="sort" id="sortStatus" style="display:none;" />
			 
			 {literal}
			<script type="text/javascript">
				function filter_operation(value, id_user){
					if(value==1){
						$("form#sortStatus").attr("action","/users/orders/userid/"+id_user+"/");
						$("form#sortStatus").submit();
					}else{
						if(value==2){
							$("form#sortStatus").attr("action","/users/orders/userid/"+id_user+"/to/1");
							$("form#sortStatus").submit();
						}else{
							if(value==3){
								$("form#sortStatus").attr("action","/users/orders/userid/"+id_user+"/to/2");
								$("form#sortStatus").submit();
							}
						}
					}
				}
			</script>
			{/literal}
			<div class="style_input" style="display: inline-block;">
				<input type='text' name='id_order' placeholder='№ заказа' maxlength ="7" style="width:70px" value="{$id_order_value}"/>
			 </div>
			 <div class="addx2" style="display: inline-block;">
				<input type="button" value="Найти" id="sortStatus_b" />
			 </div>
			 
			<div class="style-select" style="width: 160px;  display: inline-block; display: -moz-inline-box; margin-left: 15px; margin: 0px 3%;">
				<select name="select_ord" style="font-size: 11px; width: 185px;" onchange="filter_operation(this.value, {$user->id});">
				<option value="1">Все заказы (+/-)</option>
				<option value="2">Заказ услуг (-)</option>
				<option value="3">Пополнение баланса (+)</option>
				</select>
            </div>

          
			<div class="style-select" style="width: 160px; display: inline-block;display: -moz-inline-box;">
				{literal}
					<script>
						function ajax_load_servise(vall){
						   var urrl_ajax = window.location;
						   $("#sort_service_select option[value='1']").attr("selected","selected");
						   $('#ajax_2').load(""+urrl_ajax+" #ajax_2",{id_sort_Status:vall});
						}
					</script>
				{/literal}
			  <select style="font-size: 11px; width: 185px;" id="sort_service_select" name="sort_service" onchange="ajax_load_servise(sort_service.options.value)">
			 		<option id="5" value="5">Все статусы заказа</option>
			 		{foreach from = $servis item = servisItem}
               			<option id="{$servisItem->id}"" value="{$servisItem->id}" {if $typeItemm->number== $selected } selected  {/if} >
               				{$servisItem->name}
               			</option>
			  		{/foreach}
			  </select>
			</div>


             <div id="ajax_load_select_form">
             	{literal}
             		<script>

             		function ajax_select(){
						$("#sortStatus").submit();
					}
	   					</script>
	   			{/literal}
				 <div class="style-select" style="width: 160px; display: inline-block;display: -moz-inline-box; float: right;">
				  <select style="font-size: 11px; width: 185px;" id="sort_select" name="sort_type" onchange="ajax_select();">
				 		<option id="5" value="5">Все статусы заказа</option>
				 		{foreach from = $types item = typeItemm}
	               			<option id="{$typeItemm->number}" value="{$typeItemm->number}" {if $typeItemm->number== $selected } selected  {/if} >
	               				{$typeItemm->text}
	               			</option>
				  		{/foreach}
				  </select>
				 </div>
			 </div>

			<br>
            </form> 
			</div>
			
            <div style="text-align:right;" id='option_l'  onclick="$('#option').show();" > <img src="/images/drill_right.jpg"/> 
              <a href="javascript:void(0)"> настройка полей </a> </div>
      <div id="load_ajax">  
            <table cellspacing="0" cellpadding="0" class="all_tarifs" width="100%">
                <tr id="head">
                    <td width="70px">№ Заказа</td>
                    <td>Дата</td>
                    <td >Стоимость</td>
					<td>Сервис</td>
                    <td>Cтатус заказа</td></tr>
					{*debug*}
            {foreach from = $orders item = orderItem}
            <tr id ="{$orderItem->id}" onclick ="change_tr({$orderItem->id})">
				
                <td>
                    <a href="javascript:void(0)"  id="{$orderItem->id}">
                    <!-- <b>№ счета: </b> -->{if $orderItem->number}{$orderItem->number}{else}{$orderItem->secretCode}{/if}                 
                    </a>
					 <img src="/images/drill_down.jpg"/>
                </td>
                <td>{$orderItem->dateUpdated|date_format:"%d-%m-%Y"}</td>
                <td style="text-align: right; height:30px;"> {if $orderItem->getPriceString() == 'цена требует уточнения'}-{else}
                	{if !$orderItem->isBalans()}-{else}+{/if}{$orderItem->getPriceString()}{/if} </td>
				<td style="text-align:left">
						{*{if $orderItem->getStatusLabel()!='Баланс пополнен'}{$orderItem->getServis()}{else}Баланс{/if}*}
						{$orderItem->getServis()}
				</td>
                <td style="text-align: left;"> 
                    {if $orderItem->getStatusLabel()=='Ожидается оплата'}
						Ожидается оплата
					{/if}	
                    {if $orderItem->getStatusLabel()=='Заказ передан клиенту'}
						{if !$orderItem->isBalans()}
							Заказ передан клиенту
						{/if}
					{/if}
				
                    {if $orderItem->getStatusLabel()=='Оплачено'}Оплачено{/if}
                    {if $orderItem->getStatusLabel()=='Цена требует уточнения'}{$orderItem->getStatusLabel()}{/if}
                    {if $orderItem->getStatusLabel()=='Заказ выполнен'}
						{if !$orderItem->isBalans()}
							Заказ выполнен
						{/if} 
					{/if}
					{if $orderItem->getStatusLabel()=='Заказ отложен'}
						Заказ отложен
					{/if}
					{if $orderItem->getStatusLabel()=='Баланс пополнен'}
						Баланс пополнен
					{/if}
                </td>
            </tr>
            <tr id ="ot{$orderItem->id}"  style="display:none;">
                <td colspan="5" style="padding-left:20px;background-color: #FAF0E0;"><br>
                	{if $orderItem->isBalans()}
						{include file="order/balans_info.tpl" orderItem = $orderItem}
					{else}
						{include file="order/order_info.tpl" orderItem = $orderItem}
					{/if}
                	{include file="order/pay_after_price_detect.tpl" orderItem = $orderItem}
                <br>
                </td>
            </tr>
            {/foreach}

        </table>
	{if $paging}<p class="right" style="text-align:right;">{$paging}</p>{/if}
</div>
        <div class="dotted2"></div>
    </div>
</div>


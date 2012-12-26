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
<style type="text/css">
#content .all_tarifs a {
    color: red;
}
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

		 <div style="float:right;margin-top: -4px;">
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
			</div>
			<div>
                <a href="/users/orders/userid/{$user->id}/"><b>Все</b></a> | <a href="/users/orders/userid/{$user->id}/to/1">Списано (-)</a> | <a href="/users/orders/userid/{$user->id}/to/2">Пополнено (+)</a>
            </div><br>
      <div>  
            <table cellspacing="0" cellpadding="0" class="all_tarifs" width="100%">
                <tr id="head">
                    <td>№ Заказа</td>
                    <td>Дата</td>
					<td>(+)/(-)</td>
                    <td>Цена (руб.)</td>
                    <td>Cтатул заказа</td>
            {foreach from = $orders item = orderItem}
            <tr  >
				
                <td>
                    <a href="javascript:void(0)" onclick ="change_tr({$orderItem->id})" id="{$orderItem->id}">
                    <!-- <b>№ счета: </b> -->{if $orderItem->number}{$orderItem->number}{else}{$orderItem->secretCode}{/if}                 
                     </a>
                </td>
                <td>{$orderItem->dateUpdated|date_format:"%d-%m-%Y"}</td>
				<td  class="odd" align="left" style="height:30px;">
						({if !$orderItem->isBalans()}-{else}+{/if})
				</td>
                <td> {$orderItem->getPriceString()} </td>
                <td> 
                    {if $orderItem->getStatusLabel()=='Ожидается оплата'}
						Ожидается оплата
					{/if}	
                    {if $orderItem->getStatusLabel()=='Заказ передан клиенту'}
						{if !$orderItem->isBalans()}
							Заказ передан клиенту
						{else}
							Баланс пополнен
						{/if}
					{/if}
                    {if $orderItem->getStatusLabel()=='Оплачено'}Оплачено{/if}
                    {if $orderItem->getStatusLabel()=='Цена требует уточнения'}{$orderItem->getStatusLabel()}{/if}
                    {if $orderItem->getStatusLabel()=='Заказ выполнен'}
						{if !$orderItem->isBalans()}
							Заказ выполнен
						{else}
							Баланс пополнен
						{/if} 
					{/if}
                </td>
            </tr>
            <tr id ="ot{$orderItem->id}"  style="display:none;">
                <td colspan="5" style="padding-left:20px;"><br>
                {include file="order/order_info.tpl" orderItem = $orderItem}
                {include file="order/pay_after_price_detect.tpl" orderItem = $orderItem}
                <br>
                </td>
            </tr>
            {/foreach}

        </table>
	{if $paging}<div>{$paging}</div>{/if}
</div>
        <div class="dotted2"></div>
    </div>
</div>
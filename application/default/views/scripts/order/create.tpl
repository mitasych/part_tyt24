<div class="right_part2" style="font-size: 11px;">
    <div class="bg_ie">
    	
    </div>
    <div>
        <div class="main_top_text" style="font-size: 10px;">

            {breadcrumb controller="info" alias="orderBasket" title='' altTitle="Оформление заказа"}

            <h1>Оформление заказа</h1>
            {if $Basket->getItems()}
        
            <p><a href="/order/basket/">Вернуться в корзину</a></p>
            <table cellpadding="5" cellspacing="5" border="0" style="font-size: 12px;border-bottom: 1px #5f5f5f dotted;">
                <tr>
                    <th><b style="color:#2D96FE">№</b></th>
                    {*<th>Раздел</th>*}
                    <th><b style="color:#2D96FE">Тип</b></th>
                    <th><b style="color:#2D96FE">Информация</b></th>
                    <th><b style="color:#2D96FE">Цена</b></th>
                </tr>
                {foreach from=$Basket->getItems() key=key item=item}
                <tr>
                    <td>{$key+1}</td>
                    {*<td>{$item->getPricesObject()->getGroupName()}</td>*}
                    <td>{$item->getPricesObject()->getName()}</td>
                    <td>{$item->getInfoString()}</td>
                    <td>{$Basket->getElementPriceString($key)}</td>
                </tr>
                {/foreach}
            </table>
            <br />
            <p>Всего элементов в корзине: {$Basket->getCount()}{if $Basket->getTotalAmount()} на сумму {$Basket->getTotalAmountString()}{/if}</p>


            {form from=$form}
          {form_errors_summary}


           
			{if $ifoff}Данные для доставки<p>{/if}
		
       


           {* <p><b style="color:#FF0000">*</b>&nbsp;Срочность:<br />
                {form_select name="priority" options=$pItems selected=$fparams.priority}
            </p>*}
			</td>
			
			{if $ifoff}
			<td style='vertical-align:top;'>
			<input type=hidden name='offiftrue' value=1>
            <p><b style="color:#FF0000">*</b>&nbsp;Адрес доставки:<br>
                {form_textarea name=addr}
			<p><b style="color:#FF0000">*</b>&nbsp;Ближайшее метро:<br>
                {form_select name=metro options=$ListMetro}
			<p><b style="color:#FF0000">&nbsp;</b>&nbsp;Примечание:<br>
                {form_textarea name=ather}
				
				
            </p>
			</td>
			{/if}
			</tr>
			</table>


            {if $Basket->getTotalAmount()}
			            
{foreach from=$ListPay item=pay}
	{if $pay->id == $orderItem->money }

		{assign var=select_pay_sel value=$pay->group} 	
		<input type="hidden" id="val_radio_checked" value="{$pay->id}">
		<input type="hidden" id="val_select_checked" value="{$pay->group}">
	{/if}
{/foreach}

{if $select_pay_sel == ""}
	<input type="hidden" id="val_radio_checked" value="4">
	<input type="hidden" id="val_select_checked" value="1">
{/if}



            <div id='pay_variant'><b style="font-size:11px;">Способ оплаты{$fparams.mindex}:</b>


			<table><tr><td valign="top" width="300">
			<div class="style-select" style="width: 160px;">
			{form_select name="money_type" id="money_type" style="width: 185px;" options=$ListPay2 selected=$select_pay_sel}
			</div>
            {foreach from=$ListPay item=pay}
            	<input type="hidden" name="type_pay_img" id="type_pay_img_{$pay->id}" value="{$pay->type_pay}">
				<span class="radio_style2" style="margin-left:-20px;" id="type_{$pay->group}">
					<input type="radio"  id="pay_variant_type_{$pay->id}" name="money" value='{$pay->id}' typepay='{if $pay->type_pay == 2}{$pay->typeItem->name}{else}{$pay->type_pay}{/if}' sale='{$pay->sale}' {if $pay->id== $pay_variant_save } checked=checked  {/if} 
					>

					<label style="font-size:11px;"  for="pay_variant_type_{$pay->id}">{$pay->title}<br></label>
				</span>




           
			{/foreach}
		</td>
		<td style="padding-left:40px;" valign="top">
				<div id='payimg' style="position:absolute; width:200px;">

				{assign var="key1" value=0}

				{foreach from=$ListPay item=pay key=key}
					{if $key > 1 && $pay->group != $ListPay[$key1]->group}
					<br>
					{/if}
					{assign var="key1" value = $key}
					{if $pay->image}
					<img style="padding:2px;" src='/upload/pay/{$pay->image}' class='type_{$pay->group}' id='i{$pay->id}'>
					{/if}
				{/foreach}
			</div>
		</td>
		</tr></table>		
			<p id='price_pay_p' style="margin-bottom:1px"><b>Сумма: </b>
				<div class="style-select" id='price_pay' style="width: 150px;float:left;">
					<select name='price_pay' style="width: 180px;"></select>
				</div>

				<span id='price_pay_text'></span><span id='price_pay_text_cur'></span><img id='pay_this' height=20px>{*}<span id='price_pay'></span><span id='price_cyrr'></span>{*}</p>
			{assign var="moneyindex" value=1}

		        <div id="zakuplatu"{if $fparams.money != 2}style="display:none;"{/if}>
	          <b style="font-size:11px;padding-top:2px;">Заказчик:&nbsp;</b><b style="color:#FF0000">*</b><br>
				<div class="style_input" style="width:180px;">
	                {form_text name=zaku id="zaku" value=$user->login}
				</div>
	           
	           <b style="font-size:11px;">Плательщик:&nbsp;</b><b style="color:#FF0000">*</b> <br>
				<div class="style_input"  style="width:180px;padding-top:2px;">
	                {form_text name=platu id="platu"  value=$user->login}
				</div>
	            
	        </div>
	        
            <b style="font-size:11px;">E-mail:&nbsp;</b><b style="color:#FF0000">*</b> 
			<div class="style_input"  style="width:180px;padding-top:2px;">
                {form_text name=email value=$user->email}
			</div>
             {literal}
           
            
            <script type="text/javascript">
			
			$('#platu').focus(function(){
				//alert($('#zaku').val());
				if ($('#platu').val() == '')
					$('#platu').val($('#zaku').val());
			});
			$('#zaku').change(function(){
				//alert($('#zaku').val());
				if ($('#platu').val() == '')
					$('#platu').val($('#zaku').val());
			});
            function emoneyChange(el){
                $('#mindex').attr('value', $(el).attr('ind'))
                if ($(el).attr('value')==2 || $(this).attr('value')=="2") {
                    $('#zakuplatu').show();
                } else {
                    $('#zakuplatu').hide();
                }

            }
			$('#money_type').change(function (){
					$('#pay_variant span').hide();
					$('#pay_variant span#type_'+$(this).val()).show();
					$('#pay_variant span#type_'+$(this).val()+':first input').change();
					$('#pay_variant span#type_'+$(this).val()+':first input').click();
					$('#payimg img').animate({opacity: "0.3"});
					$('#payimg img.type_'+$(this).val()).animate({opacity: "1"});
					$('#type_1').hide();
					
				});
				$('input[name="money"]').change(function (){
					var type_pay_id = $(this).attr("value");
					type_pay_img = $("#type_pay_img_"+type_pay_id).val();
					if(type_pay_img == "2") {
						$("#type_pay_img_show").show();
						$("#interkasa_redirect").attr("value","redirect");
					} else{
						$("#type_pay_img_show").hide();
						$("#interkasa_redirect").attr("value","");
					}
					type = $(this).attr('typepay');
					price2 = '{/literal}{$Basket->getTotalAmount()}{literal}';
					price = price2.substr(0,3);
					$("#price_pay select").empty();
					if (type == 1) {
                        $('#zakuplatu').show();
                    } else {
                        $('#zakuplatu').hide();
                    }
					if (isNaN($(this).attr('typepay')))
					{
						sale = (100 - $(this).attr('sale'))/100;
						$('#price_pay_p').show();
						$("#price_pay_text").hide();
						$("#price_pay").show();
						$.post("/paysystems.currencies.export.php",	function(data){
							//alert("Data Loaded: " + data);
							items = $("paysystem", data);
							ex = $("paysystem[alias='sbrf']", data).attr('exchangeRate');
							price = price / ex;
							count = 0;

							items.each( function(i, n){
								if (type == $(this).text())
								{
									count = count + 1;
									$("#price_pay select").append( $('<option value="'+$(this).attr('id')+'">' + ((price * $(this).attr('exchangeRate')) * sale).toFixed(2) + ' '+$(this).attr('currencyName')+'</option>'));
									$("#price_pay_text").html((price * $(this).attr('exchangeRate') * sale).toFixed(2) + ' '+$(this).attr('currencyName'));
								}
									//alert( "Item # " + $(this).text() + " " + $(this).attr('exchangeRate'));
							});
							if (count == 1)
							{
								
								$("#price_pay option:first").attr('selected', 'selected');
								$("#price_pay").hide();
								$("#price_pay_text").show();
								//alert($("#price_pay").val());
							}
						});
					}
					else
					{
						//$('#price_pay_p').hide();
						sale = (100 - $(this).attr('sale'))/100;
						$("#price_pay").hide();
						$("#price_pay_text").show();
						$("#price_pay_text").html((price * sale).toFixed(2) + ' руб.');
						//$("#price_pay").append( $('<option value="">' + ((price * sale).toFixed(2) + ' руб.</option>'));
									
					}
					if ($('#i'+$(this).val()).attr('src'))
					{
						$('#pay_this').show();
						$('#pay_this').attr( 'src', $('#i'+$(this).val()).attr('src'));
					}
					else
						$('#pay_this').hide();
				});
				
				
		$(document).ready( function () {
		$("#country_ord").change();
		$('#money_type').change();

		var val_radio_checked = $('#val_radio_checked').val();
		var val_select_checked = $('#val_select_checked').val();


	





		$("#type_report input:checked").change();
		{/literal}{if $fparams.id}{literal}
		$('#ru_info tr td label input[value="{/literal}{$fparams.id}{literal}"]').change();
		$('#ru_info tr td label input[value="{/literal}{$fparams.id}{literal}"]').click();
		// $("#country_ord").change();
		{/literal}{/if}{literal}
		});
    </script>
{/literal}

            {else}<p>
            У некоторых из ваших заказов отсутствует цена (требует уточнения). После оформления заказа наши специалисты уточнят цену и на указанный вами почтовый адрес будет выслано уведомление, после чего вы сможете оплатить заказ.</p>
            {/if}
            <p>
	<div class="addx2"  style="display: inline-block; width: 200px;">
		{form_submit name="submitb2"  id="submitb2" style="float:left;" value="Далее >>"}
		<div id="type_pay_img_show" style="float:left;display:none;margin-left:10px;"><img id="show_imgg"  src="/img/ik_88x31_01.PNG"></div>
	</div>

</p>

            {/form}


            {else}
            <p>У вас нет заказов</p>
            {/if}

            <div class="dotted2"></div>
        </div>
    </div>
</div>
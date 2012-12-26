{literal}
<style>
    .ozt td {
        background:none;
        padding:0px 5px 0 0;
        margin:0;
    }
    .ozt td p{
        margin:0px 0 3px;
    }

</style>
{/literal}


<div class="right_part2"> 
     <div class="bg_ie" >
</div>

    <div class="main_top_text">

        <h1>Пополнение баланса</h1>
        {info name="balans"}

       

            {form from=$form}
            {form_errors_summary}
			<table>
			<tr>
			<td>
			<b style="font-size:11px;">Введите сумму (руб.):</b>&nbsp;<b style="color:#FF0000">*</b><br>
				<div class="style_input" style="width:180px;">
					{form_text name="balans" placeholder="не менее $minimumvaluemoney рублей" id="balans" }{*value=$col*}
				</div>
			</td>
			</tr>
			</table>

			{form_hidden id="money_type_save" name="mindex1" value="$money_type_save"}
			{form_hidden id="pay_variant_save" name="mindex2" value="$pay_variant_save"}			
        	<input type="hidden" value="{$minimumvaluemoney}" id="minimumvaluemoney">



 			<div id='pay_variant'><br><b style="font-size:11px;">Способ оплаты:</b>{$fparams.mindex}
 
		<table><tr><td valign="top" width="300">

			<div class="style-select" style="width: 160px;">
				{form_select name="money_type" id="money_type"  style="width: 185px;" options=$ListPay2  selected="$money_type_save"}
			</div>
            {foreach from=$ListPay item=pay}
            	<input type="hidden" name="type_pay_img" id="type_pay_img_{$pay->id}" value="{$pay->type_pay}">

				<span class="radio_style2"  style="margin-left:-20px;" id="type_{$pay->group}">
					<input type="radio"  id="pay_variant_type_{$pay->id}" name="money" value='{$pay->id}' typepay='{if $pay->type_pay == 2}{$pay->typeItem->name}{else}{$pay->type_pay}{/if}' sale='{$pay->sale}' {if $pay->id== $pay_variant_save } checked=checked  {/if}>

					<label style="font-size:11px;"  for="pay_variant_type_{$pay->id}">{$pay->title}<br></label>
				</span>
				
           
			{/foreach}
		</td>
		<td style="padding-left:40px;" valign="top">
				<div id='payimg' style="position:absolute;">

		{assign var="key1" value=0}
				{foreach from=$ListPay item=pay key=key}
					{if $key > 1 && $pay->group != $ListPay[$key1]->group}
					<br>
					{/if}
					
					{if $pay->image}
					<img src='/upload/pay/{$pay->image}' class='type_{$pay->group}' id='i{$pay->id}'>
					{/if}
				{/foreach}
			</div>
		</td>
		</tr></table>	

				<span class="check_exel" style="margin-left:7px; margin-top: 4px;">
				<input role="checkbox" id="cb_bigset" onclick="save_setings_pay()" value="1" class="cbox" type="checkbox" />
				<label for="cb_bigset"/>сохранить для последующих платежей
				</span>

			<p id='price_pay_p'><b id='price_pay_p' style="position:absolute;padding-bottom:-4px;">Сумма: </b>
				<div class="style-select" id='price_pay' style="width: 150px;float:left;">
					<select name='price_pay' style="width:180px;padding-top:2px;"></select>
				</div>

				<span id='price_pay_text'></span><span id='price_pay_text_cur'></span><img id='pay_this' height=20px>{*}<span id='price_pay'></span><span id='price_cyrr'></span>{*}</p>
			
            {assign var="moneyindex" value=1}
          
            {form_hidden id="mindex" name="mindex" value=$mindex}
        

		       {*<div id="zakuplatu"{if $fparams.money != 2}style="display:none;"{/if}>
                    <p>Заказчик:<b style="color:#FF0000">*</b>&nbsp;<br>
					<div class="style_input">
					{if user->status == 2}
                        {form_text name=zaku id="zaku" value= $user->organization}
					{else}
						{form_text name=zaku id="zaku" value= $user->login $user->secondName $user->thirdName}
					{/if}
					</div>
                    </p>
                    <p>Плательщик:&nbsp;<b style="color:#FF0000">*</b><br>
					<div class="style_input"  style="width:380px;">
					{if user->status == 2}
                        {form_text name=platu id="platu" value= $user->organization}
					{else}
						{form_text name=platu id="platu" value= $user->login $user->secondName $user->thirdName}
					{/if}
					</div>

                    </p>
                </div>*}
		
                <div id="zakuplatu"{if $fparams.money != 2}style="display:none;"{/if}>
                    <b style="font-size:11px;">Заказчик:&nbsp;</b><b style="color:#FF0000">*</b>
					<div class="style_input"  style="width:180px;padding-top:2px;">
                        {form_text name=zaku id="zaku" value=$user->login}
					</div>
                    
                    <b style="font-size:11px;">Плательщик:&nbsp;</b><b style="color:#FF0000">*</b><br>
					<div class="style_input"  style="width:180px;padding-top:2px;">
                        {form_text name=platu id="platu"  value=$user->login}
					</div>
                    
                </div>
           {if $col > 0}<br> <input type=checkbox name='if_order' checked>активировать услугу по зачислению суммы на счет {/if}
		   
	</div>	   
            {literal}
            
            <script type="text/javascript">
			//alert('ff1');
			$("input[type='radio']").click(function(){
				pay_variant = $(this).attr("value");
			});

            function emoneyChange(el){
                $('#mindex').attr('value', $(el).attr('ind'))
                if ($(el).attr('value')==2 || $(this).attr('value')=="2") {
                    $('#zakuplatu').show();
                } else {
                    $('#zakuplatu').hide();
                }

            }
			
		/*	$('#balans').keypress(function (){
				alert($(this).val());
			});*/

			var klick_save = "";

			function save_setings_pay(){

				var urrl_ajax = window.location;
				if(pay_variant=="[object HTMLDivElement]"){ pay_variant=""; }
				if(money_type==""){ money_type=""; }

				$.post(""+urrl_ajax+"", { money_type: money_type, pay_variant: pay_variant});
			}



			$('#balans').keyup(function (){
				$('input[name="money"]:checked').change();
			});
			$('#money_type').change(function (){
					$('#pay_variant span').hide();
					$('#pay_variant span#type_'+$(this).val()).show();
					$('#pay_variant span#type_'+$(this).val()+':first input').change();
					$('#pay_variant span#type_'+$(this).val()+':first input').click();
					$('#payimg img').animate({opacity: "0.3"});
					$('#payimg img.type_'+$(this).val()).animate({opacity: "1"});
					$('#type_1').hide();
					money_type = $(this).attr("value");

					
				});
				$('input[name="money"]').change(function (){
					var id_pay_variant = $("#pay_variant_save").val();

					var type_pay_id = $(this).attr("value");
					if(id_pay_variant == $(this).val()){
						$(".check_exel").hide();
						$("#cb_bigset").attr("disabled","");
						$("#cb_bigset").attr("checked","");
					} else {
						$(".check_exel").show();
						$("#cb_bigset").removeAttr("disabled");
						$("#cb_bigset").removeAttr("checked");
					}

					type_pay_img = $("#type_pay_img_"+type_pay_id).val();
					if(type_pay_img == "2") {
						$("#type_pay_img_show").show();
						$("#interkasa_redirect").attr("value","redirect");
					} else{
						$("#type_pay_img_show").hide();
						$("#interkasa_redirect").attr("value","");
					}
					//alert('ddd');
					type = $(this).attr('typepay');
					price = $('#balans').val();
				//	alert(price);
					//$("#style-select_hide").empty();
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
									$("#price_pay_text").html((price * $(this).attr('exchangeRate') * sale).toFixed(2));
									$("#price_pay_text_cur").html(' '+$(this).attr('currencyName'));
								}
								//alert(count);
									//alert( "Item # " + $(this).text() + " " + $(this).attr('exchangeRate'));
							});
							//alert(count);
							if (count == 1)
							{
								
								$("#price_pay select option:first").attr('selected', 'selected');
								$("#price_pay").hide();
								$("#price_pay_text").show();
								$("#price_pay_text_cur").show();
								//alert($("#price_pay").val());
							}
							else
							{
								$("#price_pay option:first").attr('selected', 'selected');
								$("#price_pay").show();
								$("#price_pay_text").hide();
								$("#price_pay_text_cur").hide();
							}
						});
					}
					else
					{
						//$('#price_pay_p').hide();
						sale = (100 - $(this).attr('sale'))/100;
						$("#price_pay").hide();
						$("#price_pay_text").show();
						$("#price_pay_text_cur").show();
						$("#price_pay_text").html((price * sale).toFixed(2));
						$("#price_pay_text_cur").html(' руб.');
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

			$("#submitb2").click(function(){
				var min_bal = parseInt($("#minimumvaluemoney").val());
				if($('#balans').val()==""){

					alert("Cумма не может быть менее "+min_bal+" рублей");
					return false;
					var balans_val = ""; 
				} else {
					var balans_val = parseInt($("#balans").val());
				}



				if(balans_val < min_bal){
					alert("Cумма не может быть менее "+min_bal+" рублей");
					return false;	
				} else {
					return true;
				}

			});

		$("#country_ord").change();
		$('#money_type').change();


			var id_money_type = $("#money_type_save").val();
			var id_pay_variant = $("#pay_variant_save").val();
			
			$("#pay_variant_type_"+id_pay_variant).attr("checked","checked");
			$("#pay_variant_type_"+id_pay_variant).change();
			$("#pay_variant_type_"+id_pay_variant).click();


			var klick_save = "";

		$("#type_report input:checked").change();
		{/literal}{if $fparams.id}{literal}
		$('#ru_info tr td label input[value="{/literal}{$fparams.id}{literal}"]').change();
		$('#ru_info tr td label input[value="{/literal}{$fparams.id}{literal}"]').click();
		// $("#country_ord").change();
		{/literal}{/if}{literal}
		});
		/*$('#submitb2').click(function(){
			$('#balans').val($("#price_pay_text").html());
		});*/



    </script>
{/literal}
{literal}



{/literal}
   <b style="font-size:11px;">E-mail:</b><b style="color:#FF0000">&nbsp;*</b>
	<div class="style_input" style="width:180px;">
        {form_text name=email}
	</div>
    








<p>
	<div class="addx2"  style="display: inline-block;">
		<inpyt type="hidden" value="" name="interkasa_redirect" id="interkasa_redirect">
		{form_submit name="submitb2"  id="submitb2"  value="Пополнить" style="float:left;"}
		<div id="type_pay_img_show" style="float:left;display:none;margin-left:10px;"><img id="show_imgg"  src="/img/ik_88x31_01.PNG"></div>
	</div>
</p>

            {debug}
            {/form}

			
        <div class="dotted2"></div>
    </div>

</div>

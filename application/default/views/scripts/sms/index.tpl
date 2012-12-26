
<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

<div>
    <div class="main_top_text">

        {breadcrumb controller="sms" alias="sms" altTitle="Сообщения"}
        {include file="lmenu.tpl"}
		
		<div class="sms_services_block">
			<link id="skin-gold" title="Gold" type="text/css" rel="alternate stylesheet" href="/admin/js/calendar2/css/gold/gold.css" />
            <link type="text/css" rel="stylesheet" href="/admin/js/calendar2/css/jscal2.css" />
            <link type="text/css" rel="stylesheet" href="/admin/js/calendar2/css/border-radius.css" />
            <link id="skinhelper-compact" type="text/css" rel="alternate stylesheet" href="/admin/js/calendar2/css/reduce-spacing.css" />
			
			<script src="/admin/js/calendar2/js/jscal2.js"></script>
            <script src="/admin/js/calendar2/js/unicode-letter.js"></script>
            <script src="/admin/js/calendar2/js/lang/ru.js"></script>       
            
            {form from=$form}
            {form_errors_summary}
            
            <b>Кому:</b>
            <div id="input_phone_sms_div">
            <p><span class="error_point"></span>
				<span>+</span>
                                    {form_text class="placeholder" name="num[]" id="num_0" title="Введите номер" value="Введите номер" autocomplete="off" onfocus="inputFocus(this)" onblur="inputBlur(this)"} 
                                    <a id="addr_book_0" onclick="openDialog(this.id);return false;" style="margin:0 3px;" href="#">Адр.книга</a>
                                    </p>
            </div>
            <div style = "padding-bottom: 10px;">
            <a class="addNum" style="font-size: 13px; line-height: 13px; overflow: hidden;" onclick="addLine();return false;" href="">
            <div style="background-image: url(/images/add_contact.gif); background-repeat: no-repeat;width: 16px;height: 16px;display:inline-block;margin-bottom:-4px;"></div>
			Добавить еще один номер
			</a>
			</div>
            <div>
            	<b>Текст сообщения:</b>
	            <span><a onclick="$('#tpl_select').toggle(); return false;" href="#">добавить из шаблона</a></span>
	            <div id="tpl_select" style="display: none; position: relative;">
	            	{form_select name="tpl" placeholder="Выберите шаблон" options=$name_tpl}
	            </div>
            </div>
            <div>
            	<textarea id="sms_content" class="message_text" title="Введите текст сообщения" rows="6" size="255" name="message" placeholder="Введите текст сообщения" style="resize: none; height: 113px; display: inline-block; overflow-y: hidden;"></textarea>
           		<a id="add_in_tpl" href="#" style="margin:0 3px; vertical-align: top; display: none;" onclick="addTpl();return false;">Сохранить как шаблон</a>
            	<p style="display:inline; vertical-align: top;" id="result"></p>
            </div>
            <span id="href_primer" style="display: none;" ><a onclick="clickPrimer(); return false;" href="#">Просмотреть пример сообщения</a></span>
            <div id="tpl_primer" style="display: none; overflow:hidden;">
            	<textarea readonly name="text_primer" id="text_primer" rows="5" cols="100" style="width: 300px"></textarea>
            	<a id="addr_book_primer" onclick="openDialog(this.id);return false;" style="margin:0 3px; vertical-align: top;" href="#">Адр.книга</a>
            </div>
            <br>
            <br>
            <div style="">
            {form_submit name="submit_now" value="Отправить сейчас"}
            <a onclick="$('#sms_datetime').toggle(); return false;" href="#">Запланировать</a>
            </div>
            
            	<div id="sms_datetime" style="display: none; position: relative; height: 60px; padding: 5px 0pt 0pt;">
					<div style="position: absolute; width: 400px;">
						<b>Дата и время отправки:</b>
						<div>
						<img src="/img/calendar_icon.png">
						<input class="searchFLD" type="text" placeholder="дд.мм.гггг" id="date_sms" name="date_sms" style="width:20%;text-align:center;" />
						<input type="text" placeholder="чч:мм" onkeydown="return keyDownInTime(this,event);" onkeyup="return keyUpInTime(this,event);" size="5" name="time_input" >
						{form_button id="plan_sms_btn" name="plan_sms_btn" value="OK"}
						</div>
					</div>
				</div>
            {/form}
         </div>
        
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
	
	<div id="dial3" title="Подтверждение" />
		<p>Сохранить текст сообщения <b>как шаблон</b>?</p>
		<label>Имя шаблона</label><input type="text" id = "add_name_tpl">
	</div>
	
    </div>
</div>

     {literal}
        <script type="text/javascript">
        var countOfFields = 1; // Текущее число полей
		var curFieldNameId = 1; // Уникальное значение для атрибута name
		var maxFieldLimit = 25; // Максимальное число возможных полей
        
        $(document).ready(function() {	

			$('#dialog').dialog({
				width: 237, 
				modal: true,
				autoOpen: false,
			});
			
			$("#dial3").dialog({buttons:{
						"Да":function(){
							$(this).dialog("close");
							saveTpl();
						},
					    "Нет":function(){
					    	$(this).dialog("close");
					    }
					   },
					   width:310,
					   height:167,
					   autoOpen:false
			});
			
			//$('#category_box').show();
			
			$('#sms_content').keyup(function () {
				val = $(this).val();
				if(val)
				{
					$('#add_in_tpl').show();
				}
				else
				{
					$('#add_in_tpl').hide();
				}
			});
		});
        
        var elem_click = false;
        function openDialog(id) {
        		elem_click = true;
        		
				$('#dialog').dialog('option', 'title', 'Адресная книга');
				$('#dialog').dialog('open');
				
				var index_arr = id.split('_');
				index = index_arr[2];
				
				window.gl_index = index;
				return false;
			}
        
        function addLine() {
			var new_input=document.createElement('div');
			//var length = document.getElementById('input_phone_sms_div').getElementsByTagName('div').length;
			
			 // Увеличиваем текущее значение числа полей
 			countOfFields++;
 			// Увеличиваем ID
 			curFieldNameId++;
			
			new_input.innerHTML='<span class="error_point"></span><span>+ </span><input style="margin-bottom: 12px;" class="placeholder" id="num_'+curFieldNameId+'" name="num[]" title="Введите номер" value="Введите номер" autocomplete="off" onfocus="inputFocus(this)" onblur="inputBlur(this)"><a id="addr_book_'+curFieldNameId+'" style="margin:0 3px;" onclick="openDialog(this.id);return false;" href="#"> Адр.книга</a> <a onclick="delLine(this.parentNode.id);return false;" href="#">Удалить</a>';
			new_input.setAttribute("id", "div_"+curFieldNameId);
			
			document.getElementById('input_phone_sms_div').appendChild(new_input);
		}
		
		function delLine(id) {
			countOfFields--;
			$('#'+id).remove();	
		}
		
		function selectVal(num, tr_id) {
					var index = gl_index;
					
					if(gl_index == 'primer')
					{
						id_contact = tr_id.split('_');
						changePrimer(id_contact[1]);
						gl_index = '';
						$('#dialog').dialog('close');
					}
					else
					{
						$('#num_'+index).removeClass('placeholder');
						$('#num_'+index).attr('value', num);
						gl_index = '';
						$('#dialog').dialog('close');
					}
		}
        
        
             function change_tr() {
	            if(flag == true){
					$('#sub_users').css('background-color','#ffe9ae');
					$('#sub_users').css('font-weight','bold');
					$('.main_t').addClass('active');
					$('#rightcomp').removeAttr("class");
					$('#rightcomp').attr('class','rightcomp_act');
					flag = false;
				}else{
					$('#sub_users').css('background-color','#fff');
					$('#sub_users').css('font-weight','normal');
					$('.main_t').removeClass("active");
					$('#rightcomp').removeAttr("class");
					$('#rightcomp').attr('class','rightcomp_disact');
				flag = true;
				}
            
				$('#tb_subusers').toggle();
			} 
    		
    		//var input = document.getElementById('input_phone_sms_div').getElementsByTagName('input')[0];

			  function prepareInput(input) {
			    input.className = '';
			    input.oldValue = input.value;
			    input.value = '';
			  }
			
			  function resetInput(input) {
			    input.className = 'placeholder';
			    input.value = input.oldValue;
			  }
			  
			  function inputFocus(obj) {
				if (obj.className == 'placeholder') {
			      prepareInput(obj);
			    }	 
			  }
				
			  function inputBlur(obj) {
				if (obj.value == '') {
			      resetInput(obj);
			    }
			  }
			  
			  $('select[name="tpl"]').change(function() {
			  	var id_tpl = ($('select[name="tpl"] option:selected').val());
			  	
			  	if(id_tpl ==0 )
			  	{
			  		$('#sms_content').attr('value', '');
			  		$('#href_primer').hide();
			  		$('#tpl_primer').hide();
			  		return false;
			  	}
			  	$('#href_primer').show();
			  	
			  	$.ajax({
					type: "post",
					url: "/sms/checking-tpl",
					cache: false,
					dataType: 'json',
					data: ({id_tpl : id_tpl}),
					success: function(data)
					{
						$('#sms_content').attr('value', data.tpl);
						changePrimer();
					}						
				});	
			  });
				
			RANGE_CAL_1 = new Calendar({
                 inputField    : "date_sms",
                 dateFormat    : "%d.%m.%Y",
                 trigger       : "date_sms",
                 showsTime     : false,
                 timeFormat    : "24",
                 align         : "Tr",
                 onSelect: function() {
	                 var date = Calendar.intToDate(this.selection.get());
	                 this.hide();
                 }
            });
            
            function keyDownInTime(el, event)
			{
				var keycode = event.keyCode;
				var inpLenght = el.value.length;
				var inpValue = el.value;
				
				if(keycode == 0)
					return false;
					
				// 37 - "<-" / 39 - "->" / 46 - "Del" / 8 - "BackSp" / 48-57 - "0-9" / 96-105 - "0-9 NumPad"
				if((keycode < 48 && keycode != 8 && keycode != 9 && keycode != 37 && keycode != 39 && keycode != 46) ||
						(keycode > 57 && keycode < 96) || keycode > 105) {
					return false;
				}
				
				if(keycode == 9)
					return true;
					
				if (inpLenght == 2 && keycode != 46) {
					inpValue = inpValue + ":";
					el.value=inpValue;
				}
				
				if (inpLenght > 4) {
					if(keycode == 46 || keycode == 37 || keycode == 39)
						return true;
					if(isElemSelected(el) == true)
						return true;
					if(keycode == 8)
						return true;
					return false;
				}
				return true;
			}
			
			function keyUpInTime(el, event)
			{
				var keycode = event.keyCode;
				var inpLenght = el.value.length;
				var inpValue = el.value;
				
				if (inpLenght > 2 && inpValue[2] != ':') {
					inpValue = inpValue.replace(/:/, "");
					var str_before = inpValue.slice(0,2);
					var str_after = inpValue.slice(2);
					inpValue = str_before.concat(":", str_after)
					el.value=inpValue;
					inpLenght = el.value.length;
				}
				
				if (inpLenght == 2) {
					if (keycode == 8 || keycode == 46) {
						inpValue = inpValue.slice(0,1);
						el.value=inpValue;
					} else {
						inpValue = inpValue + ":";
						el.value=inpValue;
					}
				}
				return true;
			} 
			
			function isElemSelected(obj) {
				obj.focus();
				
				if (document.selection)
				{
					var s = document.selection.createRange();
					if (s.text)
						return true;
				}
				else if (typeof(obj.selectionStart) == "number")
				{
					if (obj.selectionStart!=obj.selectionEnd)
						return true;
				}
				
				return false;
			} 
			
			function changePrimer(id) {
				var msg = $('#sms_content').val();
				if(msg)
				{
					$.ajax({
						type: "post",
						url: "/sms/primer-tpl",
						cache: false,
						dataType: 'json',
						data: ({msg : msg, id_contact : id}),
						success: function(data)
						{
							$('#text_primer').val(data.msg_c);
						}						
					});
					
				}
				else
				{
					alert('Добавьте шаблон в "Текст сообщения"!');
					return false;
				}
				//$('#tpl_primer').toggle();
			}
			
			function clickPrimer() {
				var msg = $('#sms_content').val();
				if(!msg)
				{
					alert('Добавьте шаблон в "Текст сообщения"!');
					return false;
				}
				$('#tpl_primer').toggle();
			}
			
			function addTpl() {
				var msg = $('#sms_content').val();
				if(msg)
				{
					$('#dial3').dialog('open');
				}
				else
				{
					alert('Текст сообщения пуст!');
				}
			
			}
			
			function saveTpl() {
				val = $('#sms_content').val();
				val_name = $('#add_name_tpl').val();
				$.ajax({
						type: "post",
						url: "/sms/sms-tpl-add",
						cache: false,
						dataType: 'json',
						data: ({add_tpl : val, add_name : val_name}),
						success: function(data)
						{
							$("#result").html("Сохранение прошло успешно.");
						}						
					});
			}
         </script>
    {/literal}

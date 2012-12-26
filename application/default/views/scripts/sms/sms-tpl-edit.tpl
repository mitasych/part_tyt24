<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

<div>
    <div class="main_top_text">

        {breadcrumb controller="sms" alias="addressBookEdit" altTitle="Редактирование адресной книги"}
        {include file="lmenu.tpl"}
        
        <div >
            {form from=$form}
            {form_errors_summary}

        	<div class="dotted">  <br></div>
			<div style="float:left; display:block;">
                <table >
                    <tr>
                        <td width="150">Название шаблона</td>

                        <td>
                        
                                
                                    {form_text class="form_width" name="name_tpl" id="name_tpl"  value=$tpl_row[0].name_tpl|escape}
                                    <span class="error_point">*</span>
                        </td>
                    </tr>
                    <tr><td><br></td></tr>
                    <tr valign="top">
                       	<td>Текст сообщения</td>
                        <td>
                        			<div style="font-size: 12px; line-height: 20px; float:left;">
	                        			{form_textarea name="text_tpl" id="text_tpl" rows="10" cols="100" style="width: 300px"  value=$tpl_row[0].text_tpl|escape}
	                                    <span class="error_point">*</span>
	                                </div>
	                                <div style="font-size: 12px; line-height: 20px; padding-bottom: 25px;">
                                    	<label>Макросы:</label><br>
                                       <a id="name" style="margin:0 3px;" href="#">Имя</a><br>
                                       <a id="surname" style="margin:0 3px;" href="#">Фамилия</a><br>
                                       <a id="first_name" style="margin:0 3px;" href="#">Отчество</a><br>
                                       <a id="org" style="margin:0 3px;" href="#">Организация</a><br>
                                       <a id="balans" style="margin:0 3px;" href="#">Баланс(сумма)</a><br>
                                       <a id="mobile_phone" style="margin:0 3px;" href="#">Моб.телефон</a><br>
                                    </div>
                                    <div>
                                    <p>
										Используйте макросы &#123;Фамилия&#125;, &#123;Имя&#125;, &#123;Отчество&#125;, &#123;Телефон&#125;, &#123;Сумма&#125;, &#123;Организация&#125;
										<br>
										для подстановки данных для каждого контакта при массовой рассылке сообщений.
									</p>
									</div>
									<span><a onclick="clickPrimer(); return false;" href="#">Показать пример по вашему тексту сообщения</a></span>
						            <div id="tpl_primer" style="display: none; overflow:hidden; font-size: 12px; line-height: 20px">
						            	<textarea readonly name="text_primer" id="text_primer" rows="5" cols="100" style="width: 300px"></textarea>
						            	<a id="addr_book_primer" onclick="openDialog();return false;" style="margin:0 3px; vertical-align: top;" href="#">Адресная книга</a>
						            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="dotted" style="float:left; display:block;">  <br></div>
            <div style="float:left; display:block;">
            	{form_hidden name="id" value=$id}
            	{form_hidden name="type" value=$tpl_row[0].type_tpl|escape}
                {form_submit style="width:100px;" name="submitb" value="Сохранить"}
            </div>
            {/form}
			</div>

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
	
    </div>
</div>
{literal}
<script type="text/javascript">
        $(document).ready(function() {	

			$('#dialog').dialog({
				width: 237, 
				modal: true,
				autoOpen: false,
			});
			
			//$('#category_box').show();
		});

jQuery.fn.extend({
    insertAtCaret: function(myValue){
        return this.each(function(i) {
            if (document.selection) {
                // Для браузеров типа Internet Explorer
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            }
            else if (this.selectionStart || this.selectionStart == '0') {
                // Для браузеров типа Firefox и других Webkit-ов
                var startPos = this.selectionStart;
                var endPos = this.selectionEnd;
                var scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
                this.focus();
                this.selectionStart = startPos + myValue.length;
                this.selectionEnd = startPos + myValue.length;
                this.scrollTop = scrollTop;
            } else {
                this.value += myValue;
                this.focus();
            }
        })
    }
});

$('#name').click(function() {
  $('#text_tpl').insertAtCaret("{Имя}");
  changePrimer();
    return false;
});

$('#surname').click(function() {
  $('#text_tpl').insertAtCaret("{Фамилия}");
  changePrimer();
    return false;
});

$('#first_name').click(function() {
  $('#text_tpl').insertAtCaret("{Отчество}");
  changePrimer();
    return false;
});

$('#org').click(function() {
  $('#text_tpl').insertAtCaret("{Организация}");
  changePrimer();
    return false;
});

$('#balans').click(function() {
  $('#text_tpl').insertAtCaret("{Сумма}");
  changePrimer();
    return false;
});

$('#mobile_phone').click(function() {
  $('#text_tpl').insertAtCaret("{Телефон}");
  changePrimer();
  	return false;
});

function clickPrimer() {
	var msg = $('#text_tpl').val();
	if(msg)
	{
		changePrimer();
	}
	else
	{
		alert('Поле "Текст сообщения" не заполненно!');
		return false;
	}
	$('#tpl_primer').toggle();
}

function changePrimer(id) {
var msg = $('#text_tpl').val();
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

function openDialog() {
	$('#dialog').dialog('option', 'title', 'Адресная книга');
	$('#dialog').dialog('open');
	return false;
}

function selectVal(num, tr_id) {
	id_contact = tr_id.split('_');
	changePrimer(id_contact[1]);
	$('#dialog').dialog('close');
}

var flag = false;
$('#text_tpl').keydown(function () {
flag = false;
if(!flag)
  setTimeout(function(){
  	changePrimer();
  },
  100);
}); 
$('#text_tpl').keydown(function () {
flag = true;
});

</script>
{/literal}
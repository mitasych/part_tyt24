{literal}
<script type="text/javascript">
var rg_o = 0;
function swstatus(v, clear) {

   if ('undefined' == typeof clear || clear) {
        $('#organization').attr('value', '');
        $('#innogrn').attr('value', '');
        $('#position').attr('value', '');
        $('#innogrn2').attr('value', '');
    }

    $('#ur').hide();
    $('#ip').hide();

    $('#vnf').hide();
    $('#anf').hide();


     if (v != 1) {
        $('#vnf').show();
        $('#anf').show();
		$('#region').hide();
		rg_o = 0;
		$('#sfera').show();
    }
    
	if(v == 1) {
		rg_o = 1;
		$('#region').show();
		$('#sfera').hide();
	}
	
    if (v == 2) {
        $('#ur').show();
    }

    if (v == 3) {
        $('#ip').show();	
    }
    
}

function swdog() {
    $('#df').attr('value', '');
    $('#di').attr('value', '');
    $('#do').attr('value', '');
    $('#dolj').attr('value', '');
    $('#dn').attr('value', '');
    $('#dot').attr('value', '');
   
    $('#dog').toggle();

}
$(document).ready(function() {
swstatus(2,0);
$('#id_status_2').attr('checked', 'checked');

$('select[name="country"]').live('change',function(){
	if($(this).val() == '258' & rg_o == 1){
		$('#region').show();
	}else{
		$('#region').hide();
	}
});

 });
</script>
{/literal}

<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}> 
     </div>
</div>


<div class="dotted">  <br></div>
<div id="sub_users" class="sub_users">
	<a style="font-size:14px;" href="/users/sub-users">Мои пользователи</a>
</div>

<div>
    <div class="main_top_text">
	<h3>{$title}</h3>
	
	  {form from=$form}
        {form_errors_summary}
		
		<table>
			<tr>
				<td style="vertical-align:top;padding-right:10px;">
					<p><span class="error_point">*</span>Логин<br />
					{form_text name="login" class="form_width"}</p>

					<p><span class="error_point">*</span>Пароль<br />
					{form_password name="pass" class="form_width"}</p>

					<p><span class="error_point">*</span>Подтверждение пароля<br />
					{form_password name="pass_confirm" class="form_width"}</p>
				</td>
				<td style="vertical-align:top;" valign="top">
				</td>
			</tr>
		</table>
         
        <div class="dotted">  <br></div>

        <b>Данные пользователя</b>
        <div><br />
            <table>
                <tr>
                    <td>
                        <p><span class="error_point">*</span>Имя<br />
                            {form_text name="name" class="form_width"}</p>

                        <p><span class="error_point">*</span>Фамилия<br />
                            {form_text name="second_name" class="form_width"}</p>

                        <p><span class="error_point">*</span>Отчество<br />
                            {form_text name="third_name" class="form_width"}</p>
                    </td>

                    <td style="vertical-align:top;">

                    </td>

                </tr>
            </table>
        </div>
        <div class="dotted">  <br></div>

        <b>Контактные данные</b>
        <div><br />
            <p>
            <table><tr><td>

                        <span class="error_point">*</span>Email адрес<br />
                        {form_text class="form_width" name="email"}
                    </td>
                    <td style="padding-left: 15px">Телефон/Факс<br />
                        {form_text class="form_width" name="phone"}</td>
                </tr>
				
				
				</table>
            <br>

        </div>

        <div class="dotted">  <br></div>

       <table>
			<tr>
				<td>
					<div>
						<b>Дата регистрации:</b>
						<br>
						<span style="color: black">
							{$time|rudate}
						</span>
					</div>
				</td>
				<td valign="top">
				</td>
			</tr>
			<tr>
				<td valign="top">
				</td>
				
				<td>
				</td>
				</tr>
			</table>

                </div>
            </div>
<br />
        {form_submit name="submitb" value="Зарегистрировать"}
        <p>&nbsp;</p>
        {/form}
	
        <div class="dotted2"></div>

{literal}
        <script type="text/javascript">
             $(function(){
                swstatus($(":radio[name=status]").filter(":checked").val(), false);
             });
         </script>
    {/literal}
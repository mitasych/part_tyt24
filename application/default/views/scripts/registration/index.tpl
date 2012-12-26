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
$('#id_status_1').attr('checked', 'checked');
$('#reloadimg').click(function(){
$.post("/info/getcapchareg/", function(data) {
//alert(data);
//alert($(this).parent().children('img').attr('src'));
//alert($('#img_capcha').attr('src'));
$('#img_capcha').attr('src', 'http://egrul72.ru/'+data);
//alert($(this).prev());
});
return false;
});

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
<div>
    <div class="main_top_text">
        {breadcrumb controller="info" alias="sent" title="" altTitle="Регистрация на сайте"}
        <h1>Регистрация на сайте</h1>

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
				<b>Статус пользователя</b>
		
					<div><br />
					{foreach from=$statusList key=statusKey item=statusItem}

						<p>
						{if $status && $status == $statusKey}
						{form_radio name="status" value=$statusKey checked=true onclick="swstatus($(this).attr('value'));"} {$statusItem}<br>
						{else}
						{form_radio name="status" id="id_status_$statusKey" value=$statusKey checked=false onclick="swstatus($(this).attr('value'));"} <label for="id_status_{$statusKey}">{$statusItem}</label><br>
						{/if}
						</p>
					{/foreach}
					</div>
				
					
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
                        <div style="margin-left:10px;{if $fparams.status !=2} display:none;{/if}" id="ur" >
                            <p><span class="error_point">*</span>Наименование организации<br />
                                {form_text name="organization" class="form_width" id="organization"}</p>

                            <p><span class="error_point">*</span>ИНН<br />
                                {form_text name="innogrn" class="form_width" id="innogrn"}</p>

                            <p><span class="error_point">*</span>Должность<br />
                                {form_text name="position" class="form_width" id="position"}</p>

                        </div>

                        <div style="margin-left:10px; {if $fparams.status !=3} display:none;{/if}" id ="ip">
                            <p><span class="error_point">*</span>ИНН<br />
                                {form_text name="innogrn2" class="form_width" id="innogrn2"}</p>


                        </div>

                    </td>

                </tr>
            </table>
            {*<p><span class="error_point">*</span>Пол<br />
                {form_select name="gender" options=$genderList}</p>*}
            {form_hidden name="gender" value=1}
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

            </p>



            
        </div>

        <div class="dotted">  <br></div>

       <table>
			<tr>
				<td valign="top">
					Источник информации о нас:<br />
					
					<select name="from" style="width: 258px;">
						
						{foreach from=$sourceList item=item}
							<option value="{$item.id}">{$item.name}</option>
						{/foreach}
					
					</select>
				</td>
				<td valign="top">
					<div style="margin-left:10px;">
						Дата регистрации:
						<br><br> 
						<p style="color: black">
						{$time|rudate}
						
						
						</p>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top">
					 <div>Страна:
						<br>
						<select name="country" style="width: 258px;">
						
						{foreach from=$countriesList item=item}
							<option value="{$item.id}" {if $item.id == 258}selected{/if}>{$item.name}</option>
						{/foreach}
					
					</select>
                     </div>
				</td>
				
				<td>
					<div style="margin-left:10px;display:none;" id="region">Регион:<br>
					<select name="region" style="width: 258px;">
					{foreach from=$regionList item=item}
							<option value="{$item.region_id}" {if $item.region_id == 72}selected{/if}>{$item.RegionName}</option>
					{/foreach}
					</select>
					
					
                        </div>
						<div style="margin-left:10px;display:none;" id="sfera">
							Сфера деятельности:<br>
								{form_text name="sfera" class="form_width"}
						</div>
				</td>
				</tr>
			</table>
        <p>&nbsp;</p>
        

			   <label style="cursor:pointer;"><input type="checkbox" name="subscribe_flag" value="1" style="margin:0;padding:0;"  > Подписаться на новости </label><br />

<!--             {form_checkbox name="subscribe_flag" value="1" style="margin:0;padding:0;"} Подписаться на новости
                        <br />             -->    
                           {*form_hidden name="subscribe_flag" value="1"*}


            <br>
            			<!--<label style="cursor:pointer;"><input type="checkbox" name="vipiska_notify_flag" value="1" style="margin:0;padding:0;"  > Получать копию выписки на e-mail </label><br />-->
<!-- 					{form_checkbox name="vipiska_notify_flag" value="1" style="margin:0;padding:0;"}
					                Получать копию выписки на e-mail <br> -->
					      <br />          
			          <div id="vnf" {if $fparams.status ==1}style="display:none;"{/if}>
            <label style="cursor:pointer;"><input type="checkbox" name="dogovor_notify_flag" value="1" style="margin:0;padding:0;"  onclick="swdog();" > Оформить договор </label><br>
            <!-- {form_checkbox onclick="swdog();" name="dogovor_notify_flag" value="1" style="margin:0;padding:0;"}  Оформить договор <br>-->

            <div id="dog" {if !$fparams.dogovor_notify_flag}style=" display:none;"{/if} >



                 <p><div class="form_block">
                 			<span class="error_point">*</span>Должность руководителя <br>
                        {form_text class="form_width" name="dolj" id="dolj"}
                     </div>
                     
                     <div class="form_block"> в родительном падеже :<br />
                        {form_text class="form_width" name="doljr" id="doljr"}
                     </div> 
                </p>

                <p><div class="form_block">
                			<span class="error_point">*</span>Фамилия <br>
                        {form_text class="form_width" name="df" id="df"}
                   </div>
                                     
                   <div class="form_block"> в родительном падеже :<br />
                        {form_text class="form_width" name="dfr" id="dfr"}
                   </div>
                </p>

                <p><div class="form_block">
                			<span class="error_point">*</span>Имя <br>
                        {form_text class="form_width" name="di" id="di"}
                   </div>
                   
                  
                </p>

                <p><div class="form_block">
                			<span class="error_point">*</span>Отчество <br>
                        {form_text class="form_width" name="do" id="do"}
                    </div>
                    
                    
                 </p>



                <table>
				<tr>
				<td>
				<p><span class="error_point">*</span>Действующий на основании<br>
                                    <select name="udov2" onchange="$('#doverr').toggle();" style="width:255px; float:left;">
                                    <option {if $fparams.udov2 != 2}selected{/if} value="1" >устава</option>
                                    <option {if $fparams.udov2 == 2}selected{/if} value="2">доверенности</option></select><br>
                                    
                                   <br /></p>
				</td>
				<td style="padding-left:14px;">
					<div id="doverr" {if !$fparams.udov2 || $fparams.udov2 !=2}style="display:none; float:left;"{/if}>
                                    № {form_text name="dn" style="width:107px" id="dn" value=$user->innogrn2|escape} 
                                    от {form_text name="dot" style="width:105px" id="dot" value=$user->dot|escape}
                                    </div>
				</td>
				</tr>
				</table>
				<p ><span class="error_point">*</span>Юридический адрес
                                    <br>
                                    {form_textarea name="uraddress" style="width:523px; height:32px;" id="uraddress"}
                                     
                                             <br>
				</p>

                <br>

            <div id="anf111" {if false && $fparams.status ==1}style="display:none;"{/if}>
			{if $fparams.aef || $fparams.akt_email}
              <label style="cursor:pointer;"><input type="checkbox" checked="checked" name="aef" value="1" style="margin:0;padding:0;"  onclick="$('#akt_email').attr('value','');$('#em').toggle();" > 
         {else}
              <label style="cursor:pointer;"><input type="checkbox" name="aef" value="1" style="margin:0;padding:0;"  onclick="$('#akt_email').attr('value','');$('#em').toggle();" > 
         {/if}
            
            Почтовый адрес (укажите адрес, если он отличается от юридического) </label><br>
                           
                             <!-- {if $fparams.aef || $fparams.akt_email}
                                                             {form_checkbox checked="checked" onclick="$('#akt_email').attr('value','');$('#em').toggle();" name="aef" value="1" style="margin:0;padding:0;"}
                                                          {else}
                                                             {form_checkbox onclick="$('#akt_email').attr('value','');$('#em').toggle();" name="aef" value="1" style="margin:0;padding:0;"}
                                                          {/if}
                             
                             							Почтовый адрес (укажите адрес для отправки документов, если он отличается от юридического) <br> -->
                     <!-- Укажите почтовый адрес для отправки документов, если он отличается от юридического <br> -->

                     {if !$fparams.aef && !$fparams.akt_email}
                        <div id="em" style="display:none;">
                     {else}
                        <div id="em"  {*if !$user->aktNotifyFlag}style=" display:none;"{/if*} >
                     {/if}

                      {* Почтовый адрес (для отправки документов)<br />*}


                            {form_textarea  name="akt_email" id="akt_email" value=$user->akt_email|escape style="width:523px; height:32px;"}
                </div>
            </div>
            </div>
 </div>
<br />
			                
         <p><span class="error_point">*</span>&nbsp;Код подтверждения</p>
        <table>
			<tr>
				<td>{form_text name="verify_code" class="akW170" autocomplete="off"}</td>
				<td> <img src="{$SITE_URL}/{$verifyImage}" id='img_capcha' /> </td>
				<td><a href="#" id="reloadimg">Показать другой код</a> </td>
			</tr>
		</table>
		
        
        
        Регистрируясь на сайте, Вы подтверждаете, что с условиями использования сайта ознакомлены и полностью согласны.               
        <p>&nbsp;</p>
        {form_submit name="submitb" value="Зарегистрироваться"}
        <p>&nbsp;</p>
        {/form}


        <div class="dotted2"></div>
    </div>
</div>
</div>

 {literal}
        <script type="text/javascript">
             $(function(){
                swstatus($(":radio[name=status]").filter(":checked").val(), false);
             });
         </script>
    {/literal}
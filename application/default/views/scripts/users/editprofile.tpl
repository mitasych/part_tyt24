{literal}
<script type="text/javascript">

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
		$('#sfera').show();
    }
    
	if(v == 1) {
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
    

    $('#dog').toggle();

}

$(document).ready(function() {
	swstatus({$user->status});
});
</script>
<style type="text/css">
    .pinfo input {
        width:250px;
    }
</style>
{/literal}
<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

<div>
    <div class="main_top_text">

        {breadcrumb controller="users" alias="profileEdit" altTitle="Личный кабинет"}

        {include file="lmenu.tpl"}


        <!--class="sub_users" style="text-decoration:overline; cursor: pointer;"-->
    	<div id="sub_users">
        	<span class="main_t" value="0" style="cursor:pointer;">
        		<a style="font-size:14px;" onclick ="change_tr()">Мои пользователи</a>
        	</span>
        	<span id="rightcomp" class="rightcomp_disact"></span>
        </div>
        <br><br>
        <div id = "tb_subusers" style="display:none;">
				<div id = "add_subuser" class="sub_users" style="padding-bottom:5px;">
				<a href="/users/addsub-users/userid/{$user->id}" style="font-size:14px;">Добавить пользователя</a>
				<input type = "hidden" id = "status" value = "{$user->status}">
				</div>
				<div>
				<table class='gridTable tb' width="100%" cellpadding="2" cellspacing="1" border="1">
				<tr class="tbHeader gridOff">
					<td width = '50px' align='right'>Телефон</td>
					<td>Логин</td>	
					<td>E-mail</td>	
					<td>Имя</td>
					<td>Фамилия</td>
					<td>Отчество</td>
					<td width = '80px'>Управление</td>
				</tr>
				{foreach from=$sub_users item=item}
				<tr valign="top" ondblclick ="dbl({$item.id})" id="{$item.id}" 
					onmouseover="user_data('{$item.login}','{$item.name}','{$item.second_name}','{$item.third_name}','{$item.email}','{$item.innogrn}','{$item.position}')" 
					onmouseout="user_data('{$user->login}','{$user->name}','{$user->secondName}','{$user->thirdName}','{$user->email}','{$user->innogrn}','{$user->position}')">
							<td align='right'>{$item.phone}</td>
							<td>{$item.login}</td>	
							<td>{$item.email}</td>
							<td>{$item.name}</td>
							<td>{$item.second_name}</td>
							<td>{$item.third_name}</td>
							<td>
							<a id="href{$item.id}" style="font-size:14px;" href="/users/editsub-users/subid/{$item.id}"><img border="0" src="{$MODULE_URL}/images/edit1.jpg" alt="Редактировать"></a>	
							<a style="font-size:14px;" onclick="return confirmAction('delete')" href="/users/deletesub-users/subid/{$item.id}"><img border="0" src="{$MODULE_URL}/images/delete.jpg" alt="Удалить"></a>
							</td>
				</tr>
				{/foreach}
				</table>
				</div>
     </div   
        
        <div>
        {*<div>{$item|@debug_print_var}</div>*}
        <div style="display: block; float:left;">
            {form from=$form}
            {form_errors_summary}

        {*     <b>Статус пользователя</b>
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
		*}
        <div class="dotted">  <br></div>

            <b>Данные пользователя: {$user->login|escape}</b>
            <div><br />

               

                <table>
                    <tr>
                        <td>
                            <p><span class="error_point">*</span>Имя<br />
                                {form_text class="form_width" name="name" id="name" value=$user->name|escape}</p>

                            <p><span class="error_point">*</span>Фамилия<br />
                                {form_text class="form_width" name="second_name" id="second_name" value=$user->secondName|escape}</p>

                            <p><span class="error_point">*</span>Отчество<br />
                                {form_text class="form_width" name="third_name" id="third_name" value=$user->thirdName|escape}</p>

                            {*<p><span class="error_point">*</span>Пол<br />
                                {form_select class="form_width" name="gender" options=$genderList selected=$user->gender}</p>*}
                            {form_hidden name="gender" value=1}

                        </td>

                        <td style="vertical-align:top;">
                            <div style="margin-left:10px;{if $user->status !=2} display:none;{/if}" id="ur" >
                                <p><span class="error_point">*</span>Наименование организации<br />
                                    {form_text class="form_width" name="organization" id="organization"  value=$user->organization|escape}</p>

                                <p><span class="error_point">*</span>ИНН<br />
                                    {form_text class="form_width" name="innogrn" id="innogrn"  disabled value=$user->innogrn|escape}</p>

                                <p><span class="error_point">*</span>Должность<br />
                                    {form_text class="form_width" name="position" id="position" value=$user->position|escape}</p>

                            </div>

                            <div style="margin-left:10px; {if $user->status !=3} display:none;{/if}" id ="ip">
                                <p><span class="error_point">*</span>ИНН<br />
                                    {form_text class="form_width" name="innogrn2" id="innogrn2" disabled value=$user->innogrn2|escape}</p>


                            </div>

                        </td>

                    </tr>

                    <tr><td>

                            <span class="error_point">*</span>Email адрес<br />
                            {form_text class="form_width" name="email" id="email" value=$user->email|escape}
                        </td>
                        <td><div style="margin-left:10px;">Телефон/Факс<br />
                                {form_text class="form_width" name="phone" value=$user->phone|escape}</div></td>
                    </tr>
                </table>
            </div>
            <div class="dotted">  <br></div>


            <div>
               
               

                

                <table>
                    <tr><td>
                            <div>Страна:<br>
                            {form_select name="country" style="width:255px" options=$id_arr selected=$user->country}
                            </div></td>
                            
                        <td style="vertical-align:top;">
						<div style="margin-left:10px;" id="region">Регион:<br>{form_select name="region" style="width:255px" options=$regionList selected=$user->region}
                        </div>
						<div style="margin-left:10px;display:none;" id="sfera">
							Сфера деятельности:<br>
								{form_text name="sfera" class="form_width"}
						</div>
						</td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td>
                            <div>Источник информации о нас:<br>{form_select name="from" style="width:255px" options=$fromList selected=$user->from}<br><br>
                            </div></td>
                        <td style="vertical-align:top;"><div style="margin-left:10px;"> Дата регистрации:<br><br> <p style="color: black">{$user->createDate|rudate}</p></div></td>
                    </tr>


                </table>
                <div class="dotted"> <br></div>
                <b>Смена пароля: </b><br />
                <table>
                    <tr><td>
                            <span class="error_point"></span>Новый пароль<br />
                            {form_password class="form_width" name="newpass"}
                        </td>
                        <td><div style="margin-left:10px;">Подтверждение нового пароля<br />
                                {form_password class="form_width" name="newpassc"}</div></td>
                    </tr>


                </table>
                
                <div class="dotted">  <br></div>



                 <br>
                 	<label style="cursor:pointer;"><input type="checkbox" name="subscribe_flag" value="1" style="margin:0;padding:0;"  > Подписаться на новости </label><br />
                 <!-- {form_checkbox name="subscribe_flag" value="1" style="margin:0;padding:0;"} Получать новости (не чаще двух раз в месяц)
                                 {*form_hidden name="subscribe_flag" value="1"*}<br /> -->
                 <br>
                <div id="vnf" {if $fparams.status == 1}style="display:none;"{/if}>
                		{if $user->dogovorNotifyFlag}
            <label style="cursor:pointer;"><input type="checkbox" checked="checked" name="dogovor_notify_flag" value="1" style="margin:0;padding:0;"  onclick="swdog();" > 
                     {else}
            <label style="cursor:pointer;"><input type="checkbox" name="dogovor_notify_flag" value="1" style="margin:0;padding:0;"  onclick="swdog();" > 
                     {/if}{if $user->dogovorNotifyFlag}<b style="color:red">Оформить договор </b></label>{else}Оформить договор </label><br>{/if}<br><br>
                
                
                
                     <!-- {if $user->dogovorNotifyFlag}
                                             {form_checkbox onclick="swdog();" name="dogovor_notify_flag" value="1" style="margin:0;padding:0;" checked="checked"}
                                          {else}
                                             {form_checkbox onclick="swdog();" name="dogovor_notify_flag" value="1" style="margin:0;padding:0;"}
                                          {/if}{if $user->dogovorNotifyFlag}<b style="color:red">Оформить договор</b>{else}Оформить договор{/if}<br><br> -->

                    <div id="dog" {if !$user->dogovorNotifyFlag && !$fparams.dogovor_notify_flag}style="display:none;"{/if} >
                         <p>
                         		<div class="form_block">
                                 <span class="error_point">*</span>Должность руководителя <br>
                             		{form_text class="form_width" name="dolj" id="dolj" value=$user->dolj|escape}
                             	</div>
                            
                            <div class="form_block"> 
                            	в родительном падеже :<br />
                              {form_text class="form_width" name="doljr" id="doljr" value=$user->doljr|escape}
                            </div>
                        </p>

                        <p>
                        	<div class="form_block"> 
                        		<span class="error_point">*</span>Фамилия <br>
                            	{form_text class="form_width" name="df" id="df" value=$user->df|escape} 
                           </div>
                            
                            <div class="form_block"> 
                            	в родительном падеже :<br />
                            	{form_text class="form_width" name="dfr" id="dfr" value=$user->dfr|escape}
									</div>
								</p>	
									
                        <p>
                        	<div class="form_block"> 
                        		<span class="error_point">*</span>Имя <br>
                            	{form_text class="form_width" name="di" id="di" value=$user->di|escape}
                            </div>
                           
                          </p>

                        <p>
                        	<div class="form_block"> 
                        		<span class="error_point">*</span>Отчество <br>
                            	{form_text class="form_width" name="do" id="do" value=$user->do|escape}
                           </div>
                            	
                            
                         </p>

                        <p><table><tr><td valign="top" colspan="2">
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
				
                                </td></tr>


									<tr><td>&nbsp;</td></tr>

                            <tr><td valign="top" colspan="2"> <span class="error_point">*</span>Юридический адрес
                                    <br>
                                    {form_textarea name="uraddress" style="width:523px; height:32px;" id="uraddress" value=$user->uraddress|escape}
                                         {*</td><td style="padding-left:10px; vertical-align:top;" valign="top">*}
                                             <br>
                          <br />
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

                                </td></tr>


                        </table>

                        <br>

                
                    </div>
                </div>
              
              
                <p>&nbsp;</p>
                {form_submit style="width:100px;" name="submitb" value="Сохранить"}
                <p>&nbsp;</p>





                {/form}
            </div>
            </div>

</div>
            <div class="dotted2"></div>

        </div>
    </div>


     {literal}
        <script type="text/javascript">
             $(function(){
                swstatus($(":radio[name=status]").filter(":checked").val(), false );
             });
             
             function confirmAction(action, location) {
				var msg = action == 'delete' 
							? 'Вы действительно хотите удалить запись?' 
							: 'Вы уверены, что хотите выполнить данное действие?';
				
				var result = confirm(msg);
				if (location && result) window.location.href = location;
				return result;
			}
            
            var flag = true;
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
			
    			var tr_arr = [];
    			function dbl(id){
					if(tr_arr[id] == undefined || tr_arr[id] == false){
						window.location.replace($('#href'+id).attr("href"));
						tr_arr[id] = true;
					}
					
				}
				
    			function user_data(login,name,second,third,email,innogrn,position){
    				$('#name').attr('value', name);
    				$('#second_name').attr('value', second);
    				$('#third_name').attr('value', third);
    				$('#email').attr('value', email);
    				$('#innogrn').attr('value', innogrn);
    				$('#position').attr('value', position);
    				
    			}
    			
    			function spaces(str)
				{

					var res = str.replace(/\s/g, "");
					
					return res;
					}
    			
         </script>
    {/literal}


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
		
    }
    
	if(v == 1) {
		$('#region').show();
	}
	
    if (v == 2) {
        $('#ur').show();
		$('#region').hide();
    }

    if (v == 3) {
        $('#ip').show();
		$('#region').hide();
    }

}

function swdog() {
    

    $('#dog').toggle();

}

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


        
        
        <div >
            {form from=$form}
            {form_errors_summary}

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
        <div class="dotted">  <br></div>

            <b>Данные пользователя: {$user->login|escape}</b>
            <div><br />

               

                <table>
                    <tr>
                        <td>
                            <p><span class="error_point">*</span>Имя<br />
                                {form_text class="form_width" name="name" value=$user->name|escape}</p>

                            <p><span class="error_point">*</span>Фамилия<br />
                                {form_text class="form_width" name="second_name" value=$user->secondName|escape}</p>

                            <p><span class="error_point">*</span>Отчество<br />
                                {form_text class="form_width" name="third_name" value=$user->thirdName|escape}</p>

                            {*<p><span class="error_point">*</span>Пол<br />
                                {form_select class="form_width" name="gender" options=$genderList selected=$user->gender}</p>*}
                            {form_hidden name="gender" value=1}

                        </td>

                        <td style="vertical-align:top;">
                            <div style="margin-left:10px;{if $user->status !=2} display:none;{/if}" id="ur" >
                                <p><span class="error_point">*</span>Наименование организации<br />
                                    {form_text class="form_width" name="organization" id="organization"  value=$user->organization|escape}</p>

                                <p><span class="error_point">*</span>ИНН<br />
                                    {form_text class="form_width" name="innogrn" id="innogrn"  value=$user->innogrn|escape}</p>

                                <p><span class="error_point">*</span>Должность<br />
                                    {form_text class="form_width" name="position" id="position" value=$user->position|escape}</p>

                            </div>

                            <div style="margin-left:10px; {if $user->status !=3} display:none;{/if}" id ="ip">
                                <p><span class="error_point">*</span>ИНН<br />
                                    {form_text class="form_width" name="innogrn2" id="innogrn2"  value=$user->innogrn2|escape}</p>


                            </div>

                        </td>

                    </tr>

                    <tr><td>

                            <span class="error_point">*</span>Email адрес<br />
                            {form_text class="form_width" name="email" value=$user->email|escape}
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
                            <div>Страна:<br>{form_select name="country" style="width:255px" options=$countriesList selected=$user->country}
                            </div></td>
                        <td style="vertical-align:top;">
						<div style="margin-left:10px;" id="region">Регион:<br>{form_select name="country" style="width:255px" options=$countriesList selected=$user->country}
                        </div>
						<div style="margin-left:10px;" id="sfera">
							Сфера деятельности:<br>
								{form_text name="sfera"style="width:255px"}
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
                <div class="dotted">  <br></div>
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

                        <p><table><tr><td valign="top" colspan="2"><span class="error_point">*</span>Действующий
                                    на основании<br><select name="udov2" onchange="$('#doverr').toggle();" style="width:255px; float:left;"><option {if $fparams.udov2 != 2}selected{/if}>устава</option><option {if $fparams.udov2 == 2}selected{/if} value="2">доверенности</option></select>
                                    
</p>
                                

                                   <div id="doverr" {if !$fparams.udov2 || $fparams.udov2 !=2}style="display:none; float:left;"{/if}> № {form_text class="form_width" name="dn" id="dn" value=$user->innogrn2|escape} от
                                        {form_text name="dot" class="form_width"  id="dot" value=$user->dot|escape}
                                    </div>
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
            
            Почтовый адрес (укажите адрес для отправки документов, если он отличается от юридического) </label><br>


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
            <div class="dotted2"></div>

        </div>
    </div>


     {literal}
        <script type="text/javascript">
             $(function(){
                swstatus($(":radio[name=status]").filter(":checked").val(), false );
             });
         </script>
    {/literal}


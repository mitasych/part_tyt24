
<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
    <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
    </div>
    <div>
        <div class="main_top_text">

        {breadcrumb controller="info" alias="contact" title=$currentInfo->getTitle() altTitle="Форма обратной связи"}


            
            
<h1>{info name="contacts" what="title"}</h1>

<p>{info name="contacts"}</p>

{form from=$form}
{form_errors_summary}
    
    <table>
    <tr>
        <td style="width:250px;"><p><b style="color:#FF0000">&nbsp;</b>&nbsp;Компания<br />{form_text name="company"}</p></td>
        <td><p><b style="color:#FF0000">*</b>&nbsp;Имя<br />{form_text name="login"}</p></td>
    </tr>
    <tr>
        <td><p><b style="color:#FF0000">*</b>&nbsp;Телефон<br />{form_text name="phone"}</p></td>
        <td><p><b style="color:#FF0000">*</b>&nbsp;Email адрес<br />{form_text name="email"}</p></td>
    </tr>
</table>


    <p><b style="color:#FF0000">*</b>&nbsp;Текст сообщения<br />{form_textarea name="text" style="width:475px; height:100px;"}</p>
    
    
    <p><b style="color:#FF0000">*</b>&nbsp;Код подтверждения:<br /><img src="{$SITE_URL}/{$verifyImage}" alt="" /><br />{form_text name="verify_code"}</p>
        
    <p>{form_submit name="submitb" value="Отправить" style="margin:0;padding:0;"}</p>
        
 
{/form}


 <div class="dotted2"></div>
        </div>
    </div>
</div>

{*
<div class="dotted" /></div>
		
			</div>
			
		</div>

*}
{literal}
<script type="text/javascript">

$(document).ready(function() {
});

</script>
{/literal}
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
			<div>
                <table>
                    <tr>
                        <td>
                        	 <p>Пол:<br>
                            {form_select name="sex" style="width:255px" options=$arr_sex selected=$contact[0].sex|escape}</p>
                        	
                            <p><span class="error_point">*</span>Имя<br />
                                {form_text class="form_width" name="name" value=$contact[0].name|escape}</p>

                            <p><span class="error_point">*</span>Фамилия<br />
                                {form_text class="form_width" name="surname" value=$contact[0].surname|escape}</p>

                            <p><span class="error_point">*</span>Отчество<br />
                                {form_text class="form_width" name="first_name" value=$contact[0].first_name|escape}</p>
                        </td>

                        <td style="vertical-align:top;">
                        		<p>Тип лица<br />
                                    {form_select name="status" style="width:255px" options=$arr_status selected=$contact[0].status|escape}</p>
                        
                                <p><span class="error_point">*</span>Наименование организации<br />
                                    {form_text class="form_width" name="org" id="org"  value=$contact[0].org|escape}</p>

                                <p><span class="error_point">*</span>Должность<br />
                                    {form_text class="form_width" name="position" id="position" value=$contact[0].position|escape}</p>
                                <p><span class="error_point">*</span>Баланс(Сумма)<br />
                                    {form_text class="form_width" name="balans" id="balans" value=$contact[0].balans|escape}</p>
                        </td>

                    </tr>
                </table>
            </div>
            <div class="dotted">  <br></div>

			<div>
                <table>
                    <tr><td>
	                        <p><span class="error_point">*</span>Мобильный телефон<br />
	                                    {form_text class="form_width" name="mobile_phone" id="mobile_phone"  value=$contact[0].mobile_phone|escape}</p>
	                                    
	                        <p><span class="error_point">*</span>Телефон<br />
	                                    {form_text class="form_width" name="phone_number" id="phone_number"  value=$contact[0].phone_number|escape}</p>
	                        <p><span class="error_point">*</span>Факс<br />
	                                    {form_text class="form_width" name="fax" id="fax"  value=$contact[0].fax|escape}</p>
                        </td>
                        <td style="vertical-align:top;">
	                        <p><span class="error_point">*</span>E-mail<br />
	                                    {form_text class="form_width" name="email" id="email"  value=$contact[0].email|escape}</p>
	                        {if $id}            
	                        <div> Дата изменения:<br><br> <p style="color: black">{$contact[0].add_date|rudate}</p></div>
	                        {else}
	                        <div> Дата регистрации:<br><br> <p style="color: black">{$time|rudate}</p></div>
                        	{/if}
                        	{form_hidden name="id" value=$id}
                        </td>
                    </tr>
                </table>
                <div class="dotted"> <br></div>
              
                <p>&nbsp;</p>
                {form_submit style="width:100px;" name="submitb" value="Сохранить"}
                <p>&nbsp;</p>
                
                {/form}
			</div>

		</div>

    </div>
</div>
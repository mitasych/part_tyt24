<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>
<div>
    <div class="main_top_text">
        {breadcrumb controller="info" alias="sent" title="" altTitle="Восстановление пароля"}

        <h1>Восстановление пароля</h1>



        {form from=$form}
        {form_errors_summary}
        <p>&nbsp;</p>
        <p><span class="strong"> Введите имя пользователя на сайте и e-mail, который был указан вами при регистрации.</span> </p>
        <p>&nbsp;</p>
        <p><span class="error_point">*</span>&nbsp;Имя пользователя</p>
        {form_text name="login" class="akW170"}
        <p class="akFontS10 akWidgetInnerPB5">Это ваш ник на сайте {$SITE_NAME}</p>
        <p>&nbsp;</p>
        <p><span class="error_point">*</span>&nbsp;Email адрес</p>
        {form_text name="email" class="akW170"}
        <p>&nbsp;</p>
        <p><span class="error_point">*</span>&nbsp;Код подтверждения</p>
        <div style="margin:10px;">
            <img src="{$SITE_URL}/{$verifyImage}" alt="" />
        </div>
        {form_text name="verify_code" class="akW170" autocomplete="off"}
        <p>&nbsp;</p>
        {form_submit name="submitb" value="Отправить"}
        <p>&nbsp;</p>
        {/form}


        <div class="dotted2"></div>
    </div>
</div>
</div>
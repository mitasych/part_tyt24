{*<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>*}

<div>
    <div class="main_top_text">

        {breadcrumb controller="users" alias="profile" altTitle="Личный кабинет"}


        {include file="lmenu.tpl"}

        <div>
            {form from=$form}
            {form_errors_summary}
            <p>

                {*<div id="anf" {if $fparams.status ==1}style="display:none;"{/if}>
                   {form_checkbox onclick="$('#akt_email').attr('value','');$('#em').toggle();" name="akt_notify_flag_monitoring" value="1" style="margin:0;padding:0;"} Получать акты оказанных услуг

        </div>*}

        {form_checkbox name="akt_notify_flag_base" value="1" style="margin:0;padding:0;"} Получать акты оказанных услуг


        </p>

        {form_submit name="submitb" value="Сохранить"}
        <p>&nbsp;</p>
        {/form}
    </div>

    <div class="dotted2"></div>
</div>
</div>
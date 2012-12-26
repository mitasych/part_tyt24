<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

<div>
    <div class="main_top_text">

        {breadcrumb controller="monitoring" alias="monitoring" altTitle="Мониторинг"}
        {include file="lmenu.tpl"}
        
        <div>
            {form from=$form1}
            {form_errors_summary}
            <p>

                
                {*<div id="anf" {if $fparams.status ==1}style="display:none;"{/if}>
                   {form_checkbox onclick="$('#akt_email').attr('value','');$('#em').toggle();" name="akt_notify_flag_monitoring" value="1" style="margin:0;padding:0;"} Получать акты оказанных услуг

        </div>*}

        <a href="/monitoring/dogovor"><img src="/images/doc.jpg" title="" /> Договор (М)</a><br />
                 <a href="/monitoring/pril"><img src="/images/doc.jpg" title="" /> Приложение 1</a>
                 <br /><br />

        {form_checkbox name="akt_notify_flag_monitoring" value="1" style="margin:0;padding:0;"} Получать акты оказанных услуг


        </p>

        {form_submit name="submitb" value="Сохранить"}
        <p>&nbsp;</p>
        {/form}
    </div>


        <div class="dotted2"></div>
    </div>
</div>
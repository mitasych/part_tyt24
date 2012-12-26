<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

<div>
    <div class="main_top_text">

        {breadcrumb controller="users" alias="profile" altTitle="Личный кабинет"}


        {include file="lmenu.tpl"}

        <div>
            {form from=$form}
            {form_errors_summary}
            <p>
            {form_hidden name="monitoring_send_request" id="monitoring_send_request" value="0"}
            
            {form_checkbox name="use_report" value="1"} <b>{if $user->useReport}<a href="{$REPORTS_LINK}">{/if}Отчеты{if $user->useReport}</a>{/if} ({$user->getOrdersReportCount()})</b><br>
            {info name = 'servicereportinfo'}<br><br>

            {form_checkbox onclick="if ((this.checked) && confirm('Отправить запрос на заказ услуги мониторинга?')) document.getElementById('monitoring_send_request').value=1; else document.getElementById('monitoring_send_request').value=0;" name="use_monitoring" value="1"} <b>{if $user->useMonitoring}<a href="{$MONITORING_LINK}">{/if}Мониторинг{if $user->useMonitoring}</a>{/if} ({$user->getOrdersMonitoringCount()})</b>{*if !$user->dogovorCreated}<a href="/articles/monitoringdemo/">(заказать/демо)</a>{/if*}<br>
            {info name = 'servicemonitoringinfo'}<br><br>

            {form_checkbox name="use_base" value="1"} {if $user->useBase}<a href="{$BASES_LINK}">{/if}Базы данных{if $user->useBase}</a>{/if} ({$user->getOrdersBaseCount()})<br>
            {info name = 'servicebaseinfo'}<br><br>

            {form_checkbox name="use_ved" value="1"} {if $user->useVed}<a href="{$VED_LINK}">{/if}Рынки{if $user->useVed}</a>{/if}<br>
            {info name = 'servicevedinfo'}<br><br>
            
            </p>

            {form_submit name="submitb" value="Сохранить"}
            <p>&nbsp;</p>
            {/form}
        </div>


        <div class="dotted2"></div>
    </div>
</div>
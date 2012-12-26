<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}> </div>
</div>

<div>
    <div class="main_top_text">

        {breadcrumb controller="users" alias="profile" altTitle="Личный кабинет"}


       {* {include file="lmenu.tpl"} *}
         
        <div class="profile_content">
           
            {if $mess}<h3><font  style="color:#86cd00">{$mess}</font></h3>{/if}
            {form from=$form}
            {form_errors_summary}
            

                {form_hidden name="monitoring_send_request" id="monitoring_send_request" value="0"}

           

            {if $user->useReport}
                {if $user->useReport}<div id="report"><a style="font-size:14px;" href="{$REPORTS_LINK}">{/if}<b>ОТЧЕТНОСТЬ{if $user->useReport}{/if} (О/{$user->getOrdersReportCount()})</b></a><br><br>
                {info name = 'servicereportinfo'}
                <br></div>
            {/if}

            {if $user->useMonitoring}
               {if $user->useMonitoring}<div id="monitoring"><a style="font-size:14px;" href="{$MONITORING_LINK}">{/if}<b>МОНИТОРИНГ{if $user->useMonitoring}{/if} (М/{$user->getOrdersMonitoringCount()})</b></a>{*if !$user->dogovorCreated}<a href="/articles/monitoringdemo/">(заказать/демо)</a>{/if*}<br><br><font size="2">www.b2b-monitor.ru</font>
                {info name = 'servicemonitoringinfo'}
                <br></div>
            {/if}

			
             {if $user->useBase}
                {if $user->useBase}<div id="base"><a style="font-size:14px;" href="{$BASES_LINK}">{/if}<b>БД ПРЕДПРИЯТИЙ{if $user->useBase}{/if} (Б/{$user->getOrdersBaseCount()})</b></a><br><br><font size="2">www.b2b-base.ru</font>
                {info name = 'servicebaseinfo'}
                <br></div>
            {/if}
            
            {if $user->useSms}
            	{if $user->useSms}<div id="sms"><a style="font-size:14px;" href="{$SMS_LINK}">{/if}<b>РАССЫЛКА SMS{if $user->useBase}{/if} (Б/)</b></a><br><br><font size="2">www.smspilot.ru</font>
                {info name = 'servicesmsinfo'}
                <br></div>
            {/if}
            
            <!--{if $user->useVed}
                {form_checkbox  onclick="if ((this.checked)) if (confirm('Активизировать услугу?')) forms['editForm'].submit(); else this.checked = false; else forms['editForm'].submit();" name="use_ved" value="1"} {if $user->useVed}<a style="font-size:14px;" href="{$VED_LINK}">{/if}<b>РЫНКИ</b>{if $user->useVed}</a>{/if}<br>
                {info name = 'servicevedinfo'}
                <br>
            {/if}
			-->


            
			<div style="color:gray" onmouseover="javascript:$(this).css('color','#133C5F');" onmouseout="javascript:$(this).css('color','gray');">
            {if !$user->useReport}
                <b>{if $user->useReport}<a style="font-size:14px;" href="{$REPORTS_LINK}">{/if}ОТЧЕТНОСТЬ{if $user->useReport}</a>{/if} ({$user->getOrdersReportCount()})</b><br>
                {info name = 'servicereportinfo'}
                <br>
            {/if}
			</div>
			<div style="color:gray" onmouseover="javascript:$(this).css('color','#133C5F');" onmouseout="javascript:$(this).css('color','gray');">
            {if !$user->useMonitoring}
                <b>{if $user->useMonitoring}<a style="font-size:14px;" href="{$MONITORING_LINK}">{/if}МОНИТОРИНГ{if $user->useMonitoring}</a>{/if} ({$user->getOrdersMonitoringCount()})</b>{*if !$user->dogovorCreated}<a href="/articles/monitoringdemo/">(заказать/демо)</a>{/if*} - <font size="2">www.b2b-monitor.ru</font><br>
                {info name = 'servicemonitoringinfo'}
                <br>
            {/if}
			</div>
			<div style="color:gray" onmouseover="javascript:$(this).css('color','#133C5F');" onmouseout="javascript:$(this).css('color','gray');">
            {if !$user->useBase}
                {if $user->useBase}<a style="font-size:14px;" href="{$BASES_LINK}">{/if}<b>БД ПРЕДПРИЯТИЙ</b>{if $user->useBase}</a>{/if} ({$user->getOrdersBaseCount()}) - <font size="2">www.b2b-base.ru</font><br>
                {info name = 'servicebaseinfo'}
                <br>
            {/if}
			</div>
			<div style="color:gray" onmouseover="javascript:$(this).css('color','#133C5F');" onmouseout="javascript:$(this).css('color','gray');">
			 {if !$user->useSms}
                {if $user->useSms}<a style="font-size:14px;" href="{$SMS_LINK}">{/if}<b>РАССЫЛКА SMS</b>{if $user->useSms}</a>{/if} () - <font size="2">www.smspilot.ru</font><br>
                {info name = 'servicesmsinfo'}
                <br>
            {/if}
            </div>
            <!--<div style="color:gray" onmouseover="javascript:$(this).css('color','#000');" onmouseout="javascript:$(this).css('color','gray');">
            {if !$user->useVed}
                {form_checkbox  onclick="if ((this.checked)) if (confirm('Активизировать услугу?')) forms['editForm'].submit(); else this.checked = false; else forms['editForm'].submit();" name="use_ved" value="1"} {if $user->useVed}<a style="font-size:14px;" href="{$VED_LINK}">{/if}<b>РЫНКИ</b>{if $user->useVed}</a>{/if}<br>
                {info name = 'servicevedinfo'}
                <br>
            {/if}</div>-->
			
          	

            {*form_submit name="submitb" value="Сохранить"*}
            <p>&nbsp;</p>
            {/form}
        </div>


        <div class="dotted2"></div>
    </div>
</div>

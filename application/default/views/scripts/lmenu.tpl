 {*  <div class="promo_left">
   <div class="lk_header" >Личный кабинет</div>
   <div class="lk_menu3" > 
        <span><a class="{if CONTROLLER_NAME == 'users' && ACTION_NAME=='profile' || CONTROLLER_NAME == 'monitoring'}active{/if}" href="{$user->getUserPath('profile')}" onmousemove="$('.menu_service').show();">Сервисы</a></span> |
        <span><a class="{if CONTROLLER_NAME == 'users' && ACTION_NAME=='orders'}active{/if}" href="{$user->getUserPath('orders')}">Мои заказы</a></span> |
        <span><a class="{if CONTROLLER_NAME == 'users' && ACTION_NAME=='plateji'}active{/if}" href="{$user->getUserPath('plateji')}">Мои платежи</a></span> |
		<span><a class="{if CONTROLLER_NAME == 'users' && ACTION_NAME=='docs'}active{/if}" href="{$user->getUserPath('docs')}">Документы</a></span> |
        <span><a class="{if CONTROLLER_NAME == 'users' && ACTION_NAME=='editprofile'}active{/if}" href="{$user->getUserPath('editprofile')}">Личные данные</a></span>    
    </div> 
	<div class="menu_service" style="display:none;" onmouseout="$('.menu_service').hide();">
		<a href="{$MONITORING_LINK}?c={$user->hash}" onmousemove="$('.menu_service').show();">Мониторинг</a><br>
		<a href="http://www.egrulinfo.ru/?c={$user->hash}" onmousemove="$('.menu_service').show();">Отчетность</a><br>
		<a href="http://www.b2b-base.ru/?c={$user->hash}" onmousemove="$('.menu_service').show();">БД предприятий</a><br>
		<a href="{$SMS_LINK}?c={$user->hash}" onmousemove="$('.menu_service').show();">Рассылка SMS</a><br>
	</div> 



<div class="lk_menu3"> 
        <span> <a class="{if CONTROLLER_NAME == 'users' && ACTION_NAME=='profile' || CONTROLLER_NAME == 'monitoring'}active{/if}" href="{$user->getUserPath('profile')}">Сервисы <img src="/images/red_ico1.png"> </a> </span> 
       {if $user->useReport}
            <span class="{if CONTROLLER_NAME == 'reports'}active {/if}s2 report"><a title="{info name = 'servicereportinfo' stt = 1}" href="http://www.egrulinfo.ru/?c={$user->hash}">ОТЧЕТНОСТЬ </a></span>
        {/if} 
		{if $user->useMonitoring}
            <span class="{if CONTROLLER_NAME == 'monitoring'}active {/if}s2 monitoring"><a title="{info name = 'servicemonitoringinfo' stt = 1}" href="{$MONITORING_LINK}?c={$user->hash}">МОНИТОРИНГ </a></span>
        {/if}		
               {if $user->useBase}
            <span class="{if CONTROLLER_NAME == 'bases'}active {/if}s4 database"><a title="{info name = 'servicebaseinfo' stt = 1}" href="http://www.b2b-base.ru/?c={$user->hash}">БД ПРЕДПРИЯТИЙ </a></span>
        {/if}
        {if $user->useSms}
            <span class="{if CONTROLLER_NAME == 'sms'}active {/if}s5 sms"><a title="{info name = 'servicesmsinfo' stt = 1}" href="{$SMS_LINK}?c={$user->hash}">РАССЫЛКА SMS </a></span>
        {/if}	

       <span> <a style="color:red;"class="{if CONTROLLER_NAME == 'users' && ACTION_NAME=='profile' || CONTROLLER_NAME == 'monitoring'}active{/if}" href="{$user->getUserPath('profile')}">Сервисы <img style="margin:-2px -5px;" src="/images/red_ico1.png"> </a> </span> 
         <span> <a href="http://www.egrulinfo.ru/?c={$user->hash}">Отчетность</a> </span> 
         <span> <a href="{$MONITORING_LINK}?c={$user->hash}">Мониторинг</a> </span>   
 
	<span> 	<a href="http://www.b2b-base.ru/?c={$user->hash}">БД предприятий</a> </span>
</div> 
</div> *}
{if $banner}
    <div><img src="{$banner}" alt="" title="" /></div>
{/if}

{if CONTROLLER_NAME == 'monitoring' || CONTROLLER_NAME == 'reports' || CONTROLLER_NAME == 'bases'|| CONTROLLER_NAME == 'users'}
 {*<div class="lk_menu3">
       {if $user->useReport}
            <span class="{if CONTROLLER_NAME == 'reports'}active {/if}s2 report"><a title="{info name = 'servicereportinfo' stt = 1}" href="http://www.egrulinfo.ru/?c={$user->hash}">ОТЧЕТНОСТЬ <br> </a></span>
        {/if} 
		{if $user->useMonitoring}
            <span class="{if CONTROLLER_NAME == 'monitoring'}active {/if}s2 monitoring"><a title="{info name = 'servicemonitoringinfo' stt = 1}" href="{$MONITORING_LINK}?c={$user->hash}">МОНИТОРИНГ <br></a></span>
        {/if}		
  </td> *}
<div class="lk_menu2"> 

         <span class="{if CONTROLLER_NAME == 'monitoring' && ACTION_NAME=='index'}active {/if}s1 main"><a href="/monitoring/">Мои услуги</a></span> |<!--  <img src="/images/list_delemiter.png" />  -->

        <span class="{if CONTROLLER_NAME == 'monitoring' && (ACTION_NAME=='tarifs' || ACTION_NAME=='addtarif')}active {/if}s2 tariffs"><a href="/monitoring/addtarif/">Заказ услуг</a></span> |              
		<span class="{if CONTROLLER_NAME == 'monitoring' && ACTION_NAME=='orders'}active {/if}s2 orders"><a href="/monitoring/orders/">Заказы</a></span> |
		
    {*    {if $user->useBase}
            <span class="{if CONTROLLER_NAME == 'bases'}active {/if}s4 database"><a title="{info name = 'servicebaseinfo' stt = 1}" href="http://www.b2b-base.ru/?c={$user->hash}">БД ПРЕДПРИЯТИЙ <br></a></span>
        {/if}


        {if $user->useVed}
            <span class="{if CONTROLLER_NAME == 'ved'}active {/if}s1 market"><a title="{info name = 'servicevedinfo' stt = 1}" href="{$VED_LINK}?c={$user->hash}">РЫНКИ <br></a></span>
        {/if}
*}
{/if}

{if CONTROLLER_NAME == 'monitoring'}
    {*<div class="lk_menu2">*}
<span class="{if CONTROLLER_NAME == 'monitoring' && ACTION_NAME=='statistics'}active {/if}s2 statistic"><a href="/monitoring/statistics/">Статистика</a></span> |
        <span class="{if CONTROLLER_NAME == 'monitoring'} {if ACTION_NAME=='events' || ACTION_NAME=='favorites' || ACTION_NAME=='eventscompany' || ACTION_NAME=='eventsdatagroup'}active {/if}{/if}s1 events"><a href="/monitoring/events/">События{if $user->getLastEventCount() > 0}({$user->getLastEventCount()}){/if}{*if $user->mon_demo}(demo){/if*}</a></span> | 
        <span class="{if CONTROLLER_NAME == 'monitoring' && ACTION_NAME=='calendar'}active {/if}s2 calend"><a href="/monitoring/calendar/">Календарь{*if $user->mon_demo}(demo){/if*}</a></span> |
        <span class="{if CONTROLLER_NAME == 'monitoring' && ACTION_NAME=='list'}active {/if}s2 settings"><a href="/monitoring/list/">Настройки</a></span>

</div>
{if $user->mon_demo}<font color=red>Вы работаете в  демонстрационном режиме (до {$user->enddate_mon_demo}).</font>{/if}
{*<div><h1>МОНИТОРИНГ (М/{$user->getOrdersMonitoringCount()})</h1></div>*}
{/if}

{if CONTROLLER_NAME == 'bases'}
    <div class="lk_menu2">
        <span class="{if CONTROLLER_NAME == 'bases' && ACTION_NAME=='index'}active {/if}s2"><a href="/bases/">Online-заказ</a></span> |
        <span class="{if CONTROLLER_NAME == 'bases' && ACTION_NAME=='list'}active {/if}s1"><a href="/bases/list/">Заказы</a></span> |
        <span class="{if CONTROLLER_NAME == 'bases' && ACTION_NAME=='documents'}active {/if}s2"><a href="/bases/documents/">Документы</a></span>
    </div>

{*<div><h1>БД ПРЕДПРИЯТИЙ ({$user->getOrdersBaseCount()})</h1></div>*}
{/if}


{if CONTROLLER_NAME == 'reports'}
    <div class="lk_menu2">
        <span class="{if CONTROLLER_NAME == 'reports' && ACTION_NAME=='index'}active {/if}s2"><a href="/reports/">Online-заказ</a></span> |
        <span class="{if CONTROLLER_NAME == 'reports' && ACTION_NAME=='list'}active {/if}s1"><a href="/reports/list/">Заказы</a></span> |
        <span class="{if CONTROLLER_NAME == 'reports' && ACTION_NAME=='documents'}active {/if}s2"><a href="/reports/documents/">Документы</a></span>
    </div>

{*<div><h1>ОТЧЕТНОСТЬ (О/{$user->getOrdersReportCount()})</h1></div>*}
{/if}

{if CONTROLLER_NAME == 'sms'}
    <div class="lk_menu2">
        <span class="{if CONTROLLER_NAME == 'sms' && ACTION_NAME=='index'}active {/if}s5"><a href="/sms/">Отправка SMS</a></span> |
        <span class="{if CONTROLLER_NAME == 'sms' && ACTION_NAME=='address-book'}active {/if}s5 address"><a href="/sms/address-book/">Адресная книга</a></span> |
        <span class="{if CONTROLLER_NAME == 'sms' && ACTION_NAME=='sms-tpl'}active {/if}s5 tpl"><a href="/sms/sms-tpl/">Шаблоны сообщений</a></span> |
    </div>

{/if}
<nav role="select" style="display:none">
    <ul>
        <li><a href="#">Stream</a></li>
        <li><a href="#">Lab</a></li>
        <li><a href="#">Projects</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
    
    <select onchange="if (this.value) window.location.href = this.value;">
        <option value="#">Stream</option>
        <option value="#">Lab</option>
        <option value="#">Projects</option>
        <option value="#">About</option>
        <option value="#">Contact</option>
    </select>
</nav>
</div>

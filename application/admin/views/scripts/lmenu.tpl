<div class="promo_left">
    <h1>Личный кабинет</h1>
</div>


<div>
    <ul class="tabs">
        <li class="{if CONTROLLER_NAME == 'users' && ACTION_NAME=='profile'}active {/if}s1">&nbsp;<a href="{$user->getUserPath('profile')}">Сервисы</a>&nbsp;</li>

        {if $user->useReport}
            <li class="{if CONTROLLER_NAME == 'reports'}active {/if}s1">&nbsp;<a href="{$REPORTS_LINK}?c={$user->hash}">ОТЧЕТЫ</a>&nbsp;&nbsp;</li>
        {/if}

        {if $user->useMonitoring}
            <li class="{if CONTROLLER_NAME == 'monitoring'}active {/if}s2">&nbsp;<a href="{$MONITORING_LINK}?c={$user->hash}">МОНИТОРИНГ</a>&nbsp;</li>
        {/if}

        {if $user->useBase}
            <li class="{if CONTROLLER_NAME == 'bases'}active {/if}s1">&nbsp;&nbsp;&nbsp;<a href="{$BASES_LINK}?c={$user->hash}">БАЗЫ</a>&nbsp;&nbsp;&nbsp;</li>
        {/if}

        {if $user->useVed}
            <li class="{if CONTROLLER_NAME == 'ved'}active {/if}s1">&nbsp;&nbsp;<a href="{$VED_LINK}?c={$user->hash}">РЫНКИ</a>&nbsp;&nbsp;</li>
        {/if}

        <li class="{if CONTROLLER_NAME == 'users' && ACTION_NAME=='orders'}active {/if}s2">&nbsp;&nbsp;&nbsp;<a href="{$user->getUserPath('orders')}">Все заказы</a>&nbsp;&nbsp;&nbsp;</li>
        <li class="{if CONTROLLER_NAME == 'users' && ACTION_NAME=='editprofile'}active {/if}s3">&nbsp;<a href="{$user->getUserPath('editprofile')}">Личные данные</a>&nbsp;&nbsp;</li>


    </ul>
</div>
<div>
{if CONTROLLER_NAME == 'monitoring'}
    <ul class="tabs">
        <li class="{if CONTROLLER_NAME == 'monitoring' && ACTION_NAME=='index'}active {/if}s1">&nbsp;<a href="/monitoring/">Главная</a>&nbsp;</li>
        <li class="{if CONTROLLER_NAME == 'monitoring' && ACTION_NAME=='events'}active {/if}s1"><a href="/monitoring/events/">События</a>&nbsp;</li>
        <li class="{if CONTROLLER_NAME == 'monitoring' && ACTION_NAME=='calendar'}active {/if}s2">&nbsp;&nbsp;&nbsp;<a href="/monitoring/calendar/">Календарь</a>&nbsp;&nbsp;&nbsp;</li>
        <li class="{if CONTROLLER_NAME == 'monitoring' && ACTION_NAME=='statistics'}active {/if}s2">&nbsp;&nbsp;&nbsp;<a href="/monitoring/statistics/">Статистика</a>&nbsp;&nbsp;&nbsp;</li>
        <li class="{if CONTROLLER_NAME == 'monitoring' && ACTION_NAME=='list'}active {/if}s4"><a href="/monitoring/list/">Список мониторинга</a>&nbsp;</li>
        <li class="{if CONTROLLER_NAME == 'monitoring' && ACTION_NAME=='documents'}active {/if}s4"><a href="/monitoring/documents/">Документы/Тарифы</a>&nbsp;&nbsp;</li>
    </ul>
{/if}

{if CONTROLLER_NAME == 'bases'}
    <ul class="tabs">
        <li class="{if CONTROLLER_NAME == 'bases' && ACTION_NAME=='index'}active {/if}s2">&nbsp;<a href="/bases/">Online-заказ</a>&nbsp;&nbsp;</li>
        <li class="{if CONTROLLER_NAME == 'bases' && ACTION_NAME=='list'}active {/if}s1">&nbsp;&nbsp;<a href="/bases/list/">Заказы</a>&nbsp;&nbsp;</li>
        <li class="{if CONTROLLER_NAME == 'bases' && ACTION_NAME=='documents'}active {/if}s2">&nbsp;&nbsp;<a href="/bases/documents/">Документы</a>&nbsp;&nbsp;&nbsp;</li>
    </ul>
{/if}

{if CONTROLLER_NAME == 'reports'}
    <ul class="tabs">
        <li class="{if CONTROLLER_NAME == 'reports' && ACTION_NAME=='index'}active {/if}s2">&nbsp;&nbsp;<a href="/reports/">Online-заказ</a>&nbsp;&nbsp;</li>
        <li class="{if CONTROLLER_NAME == 'reports' && ACTION_NAME=='list'}active {/if}s1">&nbsp;&nbsp;<a href="/reports/list/">Заказы</a>&nbsp;&nbsp;</li>
        <li class="{if CONTROLLER_NAME == 'reports' && ACTION_NAME=='documents'}active {/if}s2">&nbsp;&nbsp;<a href="/reports/documents/">Документы</a>&nbsp;&nbsp;&nbsp;</li>
    </ul>
{/if}

<p></p>
</div>

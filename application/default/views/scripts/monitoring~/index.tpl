{*<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>*}

<div>
    <div class="main_top_text">

        {breadcrumb controller="monitoring" alias="monitoring" altTitle="Мониторинг"}
        {include file="lmenu.tpl"}

        <div>

            <p><strong>Дата последнего мониторинга:</strong> {$lastMonitoringDate}</p>
            <p><strong>Дата последнего события:</strong>

                {if $lastEvent->id}
                    <a href="/monitoring/event/{$lastEvent->id}/"{if !$lastEvent->isViewed()} style="font-weight:bold;"{/if}>{$lastEvent->getEventDateFormatted()} ({$lastEvent->getType()->title})</a>
                {/if}

            </p>


            <p><strong>Текущий тариф:</strong>  {$user->getTarifInfo()->getTarif()->num}-{$user->getTarifInfo()->m}</p>


            <p><strong>Срок активизации услуги:</strong>
                <b>с</b> {$user->getTarifInfo()->getStartDateFormatted()} <b>по</b>

                {if $user->getTarifInfo()->endDateUser < $user->getTarifInfo()->endDateKurator}
                    {$user->getTarifInfo()->getEndDateKuratorFormatted()}
                {else}
                    {$user->getTarifInfo()->getEndDateUserFormatted()}
                {/if}
            </p>


            <p><strong>Все тарифы:</strong>
                <br>
                {include file="monitoring/tarif_grid.tpl" tarifsList=$tarifsList}
                <br>
            </p>



            <p><strong>Баланс:</strong> {$user->balans} руб. &nbsp;<a href="/order/balans/">пополнить</a></p>
        </div>


        <div class="dotted2"></div>
    </div>
</div>
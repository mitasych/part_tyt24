{*<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>*}
<div>
    <div class="main_top_text">

        {breadcrumb controller="monitoring" alias="monitoring" altTitle="Мониторинг"}
        {include file="lmenu.tpl"}
        <div>

 

            <p><strong>Дата последнего мониторинга:</strong> {$event->getDateCreatedFormatted()}</p>
            <p><strong>Тип:</strong> {$event->getType()->title|escape}</p>
            <p><strong>Контрагент:</strong> {$event->getKontragent()->title|escape} ({$event->getKontragent()->inn|escape})</p>
            <p><strong>Дата события:</strong> {$event->getEventDateFormatted()}</p>
            <p><strong>Описание события:</strong><br> {$event->content}</p>

        </div>


        <div class="dotted2"></div>
    </div>
</div>
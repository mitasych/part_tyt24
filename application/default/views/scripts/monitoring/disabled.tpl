<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

<div>
    <div class="main_top_text">

        {breadcrumb controller="monitoring" alias="monitoring" altTitle="Мониторинг"}
        {include file="lmenu.tpl"}
        <div>

           Сервис отключен.
        </div>


        <div class="dotted2"></div>
    </div>
</div>
{*<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>*}

<div>
    <div class="main_top_text">

        {breadcrumb controller="users" alias="profile" altTitle="Личный кабинет"}


        {include file="lmenu.tpl"}

        <div>
            <p>
                {include file="info/check.tpl" hidelayout=1}
            </p>
        </div>


        <div class="dotted2"></div>
    </div>
</div>
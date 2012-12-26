{*<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>*}

<div>
    <div class="main_top_text">

        {breadcrumb controller="users" alias="profileEdit" altTitle="Личный кабинет"}

        {include file="lmenu.tpl"}

        <div>
            <hr>
            {foreach from = $orders item = orderItem}

            <p><a href="javascript:void(0)" onclick ="$('#ot{$orderItem->id}').toggle();">
                    <b>№ счета: </b>{if $orderItem->number}{$orderItem->number}{else}{$orderItem->secretCode}{/if}

                </a>{$orderItem->getDateUpdatedFormatted()} / {$orderItem->getPriceString()} / {$orderItem->getStatusLabel()}</p>
            <div id ="ot{$orderItem->id}" style="display:none;">
                {include file="order/order_info.tpl" orderItem = $orderItem}
                {include file="order/pay_after_price_detect.tpl" orderItem = $orderItem}

            </div><hr>
            {/foreach}

        </div>


        <div class="dotted2"></div>
    </div>
</div>
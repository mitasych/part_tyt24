{*<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>*}

<div>
    <div class="main_top_text">

        {breadcrumb controller="monitoring" alias="monitoring" altTitle="Мониторинг"}
        {include file="lmenu.tpl"}

        <h1>{info name="notarif" what="title"}</h1>
        <p>{info name="notarif"}</p>

        <div>

            {form from=$form}
            {form_errors_summary}
            {include file="monitoring/tarif_grid.tpl" form=$form tarifsList=$tarifsList}
            

            <br>
            <p>{form_submit name="submitb" value="Добавить в заказ" style="margin:0;padding:0;"}</p>


            {/form}



            <p></p>

            {include file="order/basket_grid.tpl" ischeck=1}


            {if $Basket->isTotalAmountDefined()}
                {if $Basket->getTotalAmount()>$user->balans}
                    <h3>Недосточно средств на личном счете</h3>
                {else}
                    <input type="submit" onclick="if (!confirm('С вашего личного счета будет списано {$Basket->getTotalAmount()} руб.')) return false; document.location = '/order/create/';" value="Оплатить" />
                {/if}
            {/if}



        </div>


        <div class="dotted2"></div>
    </div>
</div>
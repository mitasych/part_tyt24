<div class="right_part2">
    <div class="bg_ie">
    </div>

    <div>
        <div class="main_top_text">

            {assign var=nn value=$orderItem->getRelList()}

            {if $nn.0->getZakaz()->typeId !=21}
                {breadcrumb controller="info" alias="orderCreated" title='' altTitle="Заказ принят"}
            {else}
                {breadcrumb controller="info" alias="orderCreated" title='' altTitle="Пополнение баланса"}
            {/if}
            

            <h1>{if $nn.0->getZakaz()->typeId !=21}Заказ принят{else}Пополнение баланса{/if}</h1>


            {if $nn.0->getZakaz()->typeId !=21}
                {if $orderItem->status ==20}
                <p>Заказ принят. Стоимость заказа требует уточнения. Следите за состоянием заказа на странице Вашего заказа.<br>
                    <a href="{$SITE_URL}/order/show/sc/{$sc}/">Перейти на страницу заказа</a>
                </p>
                {else}
                <p>Заказ принят. На Ваш почтовый ящик выслан счет/квитанция для оплаты заказа и уведомление со ссылкой на страницу Вашего заказа.<br>
                    <a href="{$SITE_URL}/order/show/sc/{$sc}/">Перейти на страницу заказа</a>
                </p>
                {/if}
            {else}

                {if $orderItem->money == 1 || $orderItem->money == 2}
                <p>Заказ на пополнение баланса принят.  На Ваш почтовый ящик отправлен счет/квитанция для пополнения баланса и  уведомление со ссылкой на страницу заказа, где Вы сможете отслеживать его состояние в режиме on-line.
                <br><a href="{$SITE_URL}/order/show/sc/{$sc}/">Перейти на страницу заказа</a>
                </p>
                {else}
                <p>На Ваш почтовый ящик отправлен счет/квитанция для пополнения баланса. Статус оплаты Вы можете проверить
                    <a href="{$SITE_URL}/order/show/sc/{$sc}/">здесь</a>
                </p>
                {/if}
            {/if}

            <div class="dotted2"></div>
        </div>
    </div>
</div>
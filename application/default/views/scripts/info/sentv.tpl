<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
    <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
    </div>
    <div>
        <div class="main_top_text">
            {breadcrumb controller="info" alias="sentv" title="" altTitle="Отправка сообщения"}
            <h1>Сообщение отправлено</h1>
            <p>Ваше сообщение отправлено. Мы свяжемся с вами в ближайшее время, если это необходимо.</p>
            <div class="dotted2"></div>
        </div>
    </div>
</div>
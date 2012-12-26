{literal}
<script type="text/javascript">

	 $(document).ready(function() {
       $("#between_0").eq(0).hide();
	 });

</script>
{/literal}
<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

<div>
    <div class="main_top_text">

        {breadcrumb controller="monitoring" alias="monitoring" altTitle="Мониторинг"}
        {include file="lmenu.tpl"}
        <div>
            <p><strong>Все тарифы:</strong>
                <br>
				
                {include file="monitoring/tarif_grid.tpl" tarifsList=$tarifsList showusertarif=1}
                <br>
				<a href="">Описание</a> | <a href="/monitoring/addtarif/">Заказ тарифа</a> | <a href="/monitoring/">Активные тарифы</a>
            </p>
			
            <!-- <p><a href="/monitoring/notarif/change/1/">Изменить текущий тариф</a></p> -->
        </div>

        <div class="dotted2"></div>
    </div>
</div>
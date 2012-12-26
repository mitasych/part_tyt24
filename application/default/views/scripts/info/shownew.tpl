<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
    <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
    </div>

    <div>
        <div class="main_top_text">

            {breadcrumb controller="articles" alias=$currentInfo->getRewriteName()}
            <div class="promo_left">

                <div class="promo_box_link" style="margin: 5px 0 !important">
                	<div>
                		<h1>{$TITLE|escape:html}</h1>
                	</div>
                	<div class="promo_box_i inf">
	                	<span><b>Информационная версия</b></span>
	                	<span>В электронном виде на e-mail</span>
                	</div>
                	{if $sys_ofreports == 1}
	                	<div class="promo_box_i of_ver">
	                		<span><b>Официальная версия</b></span>
	                		<span>Заверено печатью, доставка курьером</span>
	                	</div>
                	{/if}
                </div>
            </div>
            {*if $currentInfo->getSubmenu()->image}
            <div class="pr_right_bg" style="float: left;">
            <img src="{$SITE_URL}/upload/menu_sub/{$currentInfo->getSubmenu()->image}" alt="" title="" width="163" height="162"  />
            </div>
            {/if*}
            <!-- -->
            {$currentInfo->text}
            <div class="dotted"><br /></div>
            <!-- -->
            <div class="info_report_block" {if $sys_ofreports != 1} style="width:100%;"{/if}>
            	<div class="promo_box_i inf">
            		<span><b>Информационная версия</b></span>
            		<span>В электронном виде на e-mail</span>
            	</div>
	            <ul>
	                <li>Срок предоставления {$currentInfo->getTimePrint(1)}</li>
	                <li>Стоимость {$currentInfo->getPricesMin(1)}</strong></li>
	                <li>Скидки: <br />
	                    {foreach from=$disc[1] item=item key=key}
	                        от {$item} руб. - {$disc[2][$key]}%<br>
	                        {assign var="discout" value=$disc[2][$key]}
	                    {/foreach}
	                </li>
	                <li><a href="/articles/payments/">Способы оплаты.</a></li>
	            </ul>
            </div>
            {if $sys_ofreports == 1}
            <div class="info_report_block">
            	<div class="promo_box_i of_ver" style="float:left; min-width:200px !important;">
            		<span><b>Официальная версия</b></span>
            		<span>Доставка курьером</span>
            	</div>
            	<div class="select" style="position: relative">
	                                        	<select name="of_reports_regions" id="of_reports_regions" onchange="getOfShipData(this.value)">
	                                        		{foreach from=$listOfreports key=key item=region}
	                                        			<option value="{$region->region_code}" {if $region->region_code==77}selected="selected"{/if}>{$region->order_report_region}</option>
	                                        		{/foreach}
	                                        	</select>
	                                        	{*}
	                                        	<div class="link_over_region"></div>
	                                        	{*}
	                                        </div>
	            <ul>
	                {*}<li>Срок предоставления {$currentInfo->getTimePrint(1)}</li>
	                <li>Стоимость {$currentInfo->getPricesMin(1)}</strong></li>{*}
	                <li>Обычная (<span class="time-simple-shipping"></span>) <span class="price-simple-shipping"></span></li>
	                <li>Срочная (<span class="time-speed-shipping"></span>) <span class="price-speed-shipping"></span></li>
	                <li>Скидки: <br />
	                    {foreach from=$disc[1] item=item key=key}
	                        от {$item} руб. - {$disc[2][$key]}%<br>
	                        {assign var="discout" value=$disc[2][$key]}
	                    {/foreach}
	                </li>
	                <li><a href="/articles/payments/">Способы оплаты.</a></li>
	            </ul>
            </div>
            {/if}
            <!-- -- >
            <div class="dotted"><br/></div>
            <!-- -->

            {if $currentInfo->category == 18}
                {assign var="text_f" value='выписку'}
            {elseif $currentInfo->category == 32}
                {assign var="text_f" value='бизнес-справку'}
            {elseif $currentInfo->category == 30}
                {assign var="text_f" value='баланс'}
            {/if}

            <div class="egrul_buttons_panel">
                <a href="/reports/order/id/{$currentInfo->id}" class="ordr_link">
                    Заказать {$text_f}
                </a>
                {if $currentInfo->faq}
                    <a href="#" class="ordr_link ordr_link_quest">Вопрос-Ответ</a>
                {/if}
                <a href="/order/" class="ordr_link ordr_link_search">Найти {$text_f}</a>

            </div>
            <div style="display: none;" class="ordr_text_quest">
                {$currentInfo->faq}

                <div class="egrul_buttons_panel">
                    <a href="/reports/order/id/{$currentInfo->id}" class="ordr_link ordr_link_order">
                        Заказать {$text_f}
                    </a>
                    {if $currentInfo->faq}
                        <a href="#" class="ordr_link ordr_link_quest ordr_link_quest_dbl">Вопрос-Ответ</a>
                    {/if}
                    <a href="/order/" class="ordr_link ordr_link_search">Найти {$text_f}</a>
                </div>

            </div>
            <div class="dotted"><br /></div>

            {if $out}
                <h2 class="collapsed"  style="cursor:pointer;">цены</h2>
                <div class="pre-swithed-h2"></div>
                <div class="swithed-h2">
                    <table border="0"><tbody>
                            <tr>
                                <td align="center">
                                    <p><strong><font size="2">Количество единовременно оплаченных выписок</font></strong></p>
                                </td>
                                <td>
                                    <p><strong><font size="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br /></font></strong></p> 
                                </td>
                                <td align="center">
                                    <p><strong><font size="2">Цена одной выписки, руб.    </font></strong></p>
                                </td>
                            </tr>
                            {$out}
                    </table>
                    <br />
                    <div class="dotted">  
                        <br />
                    </div>
                </div>
            {/if}



            {if $currentInfo->faq}
                <!-- <h2 class="collapsed"  style="cursor:pointer;">вопрос-ответ</h2> -->
                <div class="pre-swithed-h2"></div>
                <div class="swithed-h2">
                    {$currentInfo->faq}
                </div>
            {/if}

            <!--
            <h2 class="collapsed" style="cursor: pointer; background-image: url("http://egrulinfo.ru/images/bg_h2_c.jpg")">
                    <a href="/info/check/id/{$currentInfo->id}">
                            ЗАКАЗАТЬ {$text_f}
                    </a>
            </h2><br>
            <h2 class="collapsed" style="cursor: pointer; background-image: url("http://egrulinfo.ru/images/bg_h2_c.jpg")">
                    <a href="/order/">НАЙТИ {$text_f}</a>
            </h2>
            -->
            <div class="dotted2"></div>
            <!--	
                    <div class="swithed-h2" style="display: block">
                            <hr/>
                    </div>
            -->
            <div class="dotted2"></div>
        </div>
    </div>


    {literal}
        <script type="text/javascript">
            $(function () {
                $("h2").click(function () {
                     if ($(this).hasClass('collapsed')) {
                         $(this).removeClass('collapsed')
                     } else {
                         $(this).addClass('collapsed')
                     }
                     $(this).next('.pre-swithed-h2').next('.swithed-h2').toggle();
                });

                $('.ordr_link.ordr_link_quest').not('.ordr_link_quest_dbl').click(function() {
                    if ($('.ordr_text_quest').is(':hidden')) {
                        $('.ordr_text_quest').show();
                        $(this).addClass('ordr_link_active');    
                    } else {
                        $('.ordr_text_quest').hide();
                        $(this).removeClass('ordr_link_active');
                    }
               });
                   
               $('.ordr_link.ordr_link_quest.ordr_link_quest_dbl').click(function() {
                   if ($('.ordr_text_quest').is(':hidden')) {
                       $('.ordr_text_quest').show();
                       $('.ordr_link.ordr_link_quest').addClass('ordr_link_active');     
                    } else {
                       $('.ordr_text_quest').hide();
                       $('.ordr_link.ordr_link_quest').removeClass('ordr_link_active');
                   }
               });

                $("h2 a").parent().unbind('click');
                $("h2 a").parent().next('.pre-swithed-h2').next('.swithed-h2').show();


                function tt(n){
                    if (n==1) {
                        $("h2.collapsed a").parent().css({"background-image": 'url("/images/bg_h2_c.jpg")'});
                        setTimeout(function(){tt(0);}, 300);
                    } else {
                        $("h2.collapsed a").parent().css({"background-image": 'none'});
                        setTimeout(function(){tt(1);}, 300);
                    }
            
                }
                setTimeout(function(){tt(0);}, 300);
            });
        </script>
    {/literal}
    {assign var="sub" value=$currentInfo->getSubmenuPair()}
    {if $sub}
        <div class="egrul_c">
            <table style="width:730px;">
                <tr>
                    <td width="22%" style="padding-left:30px;">
                        <a href="{$sub->url}" class="promo_box_link">
                            <img src="{$SITE_URL}/upload/{$sub->getMenuParent()->getImageFolder()}/{if $sub->getMenuParent()->image}{$sub->getMenuParent()->image}{else}default.gif{/if}" alt="" title="" width="150" height="150"  />
                        </a>
                    </td>
                    <td width="78%" style="vertical-align:top; padding-left:20px;">

                        <div class="egrul_promo_content">
                            <div class="promo_content_title">
                                <h3>
                                    <span>
                                        <a style="float: left;" href="{$sub->url}">
                                            {$sub->title|escape:html}
                                        </a>
                                    </span>
                                    <span class="promo_content_det_inf">
                                        <a href="{$sub->url}">
                                            <!-- 
                                            <img src="{$IMG_URL}/info_details.jpg" style="margin: 0px;" alt="">
                                            -->
                                            <img src="{$IMG_URL}/info_det_one_min.png" alt="" />
                                            <img src="{$IMG_URL}/info_det_one_min.png" alt="" />
                                            <img src="{$IMG_URL}/info_det_one_min.png" alt="" />
                                        </a>
                                    </span>
                                </h3>
                            </div>
                            <br /><br />
                            <div class="text_mini">
                                {$sub->text_mini}
                            </div>
                            <div>
                                <ul>
                                    <li class="p_box_i inf_main_block">
                                        <span>
                                            Стоимость от {$sub->getPricesMin(1)}
                                        </span>
                                        <span>
                                            Срок предоставления {$sub->getTimePrint(1)}
                                        </span>
                                        <span class="exmpl">
                                            <a href="#">Смотреть пример</a>
                                        </span>
                                    </li>
                                    {if $sys_ofreports == 1}
                                    <li class="p_box_i of_ver_main_block">
                                        <span>
                                            Стоимость от {$sub->getPricesMin(2)}
                                            <!-- </strong> -->
                                        </span>
                                        <span>
                                            Срок предоставления {$sub->getTimePrint(2)}
                                        </span>
                                        <span class="exmpl">
                                            <a href="#">Смотреть пример</a>
                                        </span>
                                    </li>
                                    {/if}
                                </ul>
                            </div>			
                            <div>
                                {if $sub->example_name}
                                    <div class="exmpl_order">
                                        <a href="{$sub1->example_url}">
                                            {$sub->example_name}
                                        </a> 
                                    {if $sub->url[0] != 'h'}{/if} 
                                </div>
                            {/if}
                            {if $sub->url[0] != 'h'}
                                <div class="order">
                                    <a class="ordr_link" href="/reports/order/id/{$sub->id}">
                                        Заказать
                                    </a>
                                    <!-- </strong> -->
                                </div>
                            {/if}
                        </div>
                    </div>
                </td>
            </tr>
        </table>

    </div>
{/if}
<!--  ##### add #####  -->
<div class="footer_wm">
    <div class="footer_header">
        <b>МЫ ПРИНИМАЕМ К ОПЛАТЕ</b>
    </div>
    <div class="footer_moneys_items">
        <img src="/images/viza_mastercard_logo.png">
        <img src="/images/web_money_logo.png">
        <img src="/images/ya_money_logo.png">
        <img src="/images/liqpaycom_logo.png">
        <img src="/images/rbk_logo.png">
        <img src="/images/sberbank_logo.png">
    </div>
    <div>
        <a href="/articles/payments/">Подробнее о системах оплаты</a>
    </div>					
</div>
<!--  ##### end add #####  -->

</div>
{literal}
<script type="text/javascript">
$(document).ready(function(){
	console.log($('.select select').val());
	getOfShipData($('.select select').val());
});
        
function getOfShipData(code){
	$.post(
			'/info/ajaxofshipdata',{'code' : code, 'id' : {/literal}{$currentInfo->id}{literal}},
			function(json){
				$('.time-simple-shipping').html(json.term1 + ' раб.дн.');
				$('.price-simple-shipping').html(json.price1 + ' руб.');
				$('.time-speed-shipping').html(json.term2 + ' раб.дн.');
				$('.price-speed-shipping').html(json.price2 + ' руб.');
			}
		)
}
</script>
{/literal}

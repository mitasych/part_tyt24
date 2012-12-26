{include file="search.tpl"}
<script type="text/javascript" src="http://api-maps.yandex.ru/1.1/?key=AE07qE0BAAAAa8RdbAIAGoy1Go-5BSLfD2D68SYnvlS6BokAAAAAAAAAAAAG4jsyAHFKz2lsQaettz9OdTPwFg==&modules=regions~metro~traffic" charset="utf-8"></script>

{literal}
<script type="text/javascript">
   var map, geoResult;

        // Создание обработчика для события window.onLoad
        YMaps.jQuery(function () {
            // Создание экземпляра карты и его привязка к созданному контейнеру
            map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);
            
            // Установка для карты ее центра и масштаба


			            // Добавление элементов управления
            //traffic.show();
            map.addControl(new YMaps.TypeControl());
            map.addControl(new YMaps.ToolBar());
            map.addControl(new YMaps.Zoom());
          //  map.addControl(new YMaps.MiniMap());
            map.addControl(new YMaps.ScaleLine());
                       // Добавление элементов управления
            map.addControl(new YMaps.TypeControl());
            // Удаление предыдущего результата поиска


            map.removeOverlay(geoResult);

            bounds = new YMaps.GeoCollectionBounds();
            {/literal}{foreach name="company" from=$hits item=hit}{literal}
                      // Запуск процесса геокодирования
            var geocoder = new YMaps.Geocoder('{/literal}{$hit.adress}{literal}', {results: 1, boundedBy: map.getBounds()});
            // Создание обработчика для успешного завершения геокодирования
            YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {
                // Если объект был найден, то добавляем его на карту
                // и центрируем карту по области обзора найденного объекта
                if (this.length()) {
                    this.get(0).text = '{/literal}{$hit.name}<br><a href="{$SITE_URL}/item/index/id/{$hit.id}/">{literal}'+this.get(0).text+'{/literal}</a>{literal}';
                    
                    geoResult = this.get(0);
                    
                    map.addOverlay(geoResult);
                    //map.setBounds(geoResult.getBounds());

                    bounds.add(geoResult.getBounds().getCenter());
                    map.setBounds(bounds);
                    var points = geoResult.getBounds();
                                // Поиск ближайших станций метро
                                  /* METRO */


                                var point2 = geoResult.getGeoPoint();

                                var metro = new YMaps.Metro.Closest(new YMaps.GeoPoint(point2.getX(),point2.getY()), { results : 1 } )

                            // Обработчик успешного завершения
                            YMaps.Events.observe(metro, metro.Events.Load, function () {
                          if (metro.length()) {
                              metro.setStyle("default#greenSmallPoint");
                              virststat = metro.get(0);
                         if (metro.get(0).AddressDetails.Country.Locality!=undefined)
                            {
                         var station = metro.get(0).AddressDetails.Country.Locality.Thoroughfare.Premise.PremiseName;

                         station = station.replace('метро ', '');
                         var Out=document.getElementById('out{/literal}{$smarty.foreach.company.iteration}{literal}');
                            Out.innerHTML += station;
                         metro.get(0).name = "Станция Метро";}
                         metro.get(0).description = station;
                         //alert(metro.get(0).getBounds().getLeftBottom());
                         //map.addOverlay(metro);
                         //bounds.add(metro.get(0).getBounds().getCenter());

                         map.setBounds(bounds);

                         } else {
                                //alert("Поблизости не найдено станций метро");
                             }
                          });

            YMaps.Events.observe(metro, metro.Events.Fault, function (metro, error) {
              //alert("При выполнении запроса произошла ошибка: " + error);
            });
            /*END METRO */


                }else {
                  //  alert("Ничего не найдено")
                }



            // Процесс геокодирования завершен неудачно
            YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (geocoder, error) {
                //alert("Произошла ошибка: " + error);
            })

		});
map.setBounds(bounds);

{/literal}{/foreach}{literal}
});

	function show_info_report(id,obj){
		
		$('.report'+id).css('left',$(obj).offset().left+'px');
		$('.report'+id).show();
	}
	
	function hide_info_report(id){
		$('.report'+id).hide();
	}

    </script>
{/literal}

		<div class="list_page">
			<div class="pager">
                            {if $count>0}
				<p class="left">
                                {if !empty($what)}  Вы искали: <a href="">{$what}</a>.  {/if}
                                {if !empty($where)} В регионе: <a href="">{$where}</a>.  {/if}
                                Найдено: {$count|number_format:0:".":" "}</p>
                                <p class="right" style="width:400px;text-align:right;">Страница:
									<!--
									
										
										
									
									
									
									-->
									{if $page > 1}
										<a href='{$SITE_URL}/list/index/what/{$what}/where/{$where}/okved/{$okved}/okato/{$okato}/page/{math equation="x-1" x=$page}/'><<</a> 
									{/if}
									
                                    {section name=for loop=$pages+1 start=$start max=10}
                                        
                                      {if $smarty.section.for.index == $page}
                                            <span  class="selected" ><b>{$page}</b></span>
                                      {else}
                                            <a href="{$SITE_URL}/list/index/what/{$what}/where/{$where}/okved/{$okved}/okato/{$okato}/page/{$smarty.section.for.index}/">{$smarty.section.for.index}</a>
                                      {/if}
                                    {/section}
									
									{if $page < $pages}
										<a href='{$SITE_URL}/list/index/what/{$what}/where/{$where}/okved/{$okved}/okato/{$okato}/page/{math equation="x+1" x=$page}/'>>></a> 
									{/if}
									
                                </p>
                            {else}
                                <p class="left">
                                {if !isset($what)}  Вы искали: <a href="#">{$what}</a>.  {/if}
                                Извините, по вашему запросу ничего не найдено </p>
                            {/if}
                                {*<p class="left">запрос выполнен за: {$time} с.</p>*}
								
							
			</div>
             <p>

			 
			 <table width="100%" style="margin-left:-8px">
				<tr>
					
					<td>
						
						
						<table>
							<td><img src="/images/img_zakaz/egrul.png" align="middle" onmouseover="show_info_report('1',this);" onmouseout="hide_info_report('1')"></td>
							<td><b>выписки из ЕГРЮЛ</b><br>
								<b style="color:red">{$price_reports.0.price} руб.</b>
							</td>
						</table>
						<div class="report1 report_info_item_hint_elem">
							{$price_reports.0.text_mini}
						</div>
						
						
						
						
					</td>
					<td>
						<table>
							<td><img src="/images/img_zakaz/finanaliz.png" align="middle" onmouseover="show_info_report('2',this);" onmouseout="hide_info_report('2')"></td>
							<td><b>бухгалтерский баланс</b><br>
								<b style="color:red">{$price_reports.5.price} руб.</b>
							</td>
						</table>
						<div class="report2 report_info_item_hint_elem">
							{$price_reports.5.text_mini}
						</div>
					</td>
					<td>
						<table>
							<td><img src="/images/img_zakaz/finotch.png" align="middle" onmouseover="show_info_report('3',this);" onmouseout="hide_info_report('3')"></td>
							<td><b>финансовый анализ</b><br>
								<b style="color:red">{$price_reports.6.price} руб.</b>
							</td>
						</table>
						<div class="report3 report_info_item_hint_elem">
							{$price_reports.6.text_mini}
						</div>
					</td>
					<td>
						<table>
							<td><img src="/images/img_zakaz/spravka.png" align="middle" onmouseover="show_info_report('4',this);" onmouseout="hide_info_report('4')"></td>
							<td><b>бизнес справка</b><br>
								<b style="color:red">{$price_reports.2.price} руб.</b>
							</td>
							<div class="report4 report_info_item_hint_elem">
							{$price_reports.2.text_mini}
						</div>
						</table>
					</td>
					<td><img src="/images/zakaz_report.png"> 
					</td>
					
				</tr>
			</table>
			  </p>
			<div class="company_list">
                            {foreach name="company" from=$hits item=hit}
                                <div class="number">{assign var="canal1" value=$page-1}{$canal1*15+$smarty.foreach.company.iteration} </div>
				<div class="company_li"  onmousemove="$('#ct{$hit.id}').show()" onmouseout="$('#ct{$hit.id}').hide();">
					<div class="categorys" style="display:none" id="ct{$hit.id}">
						<center><a href="{$SITE_URL}/item/index/id/{$hit.id}/"><img src="/images/zakazat_report_mini.png"></a><br>
						<img src="http://tyt24.ru/img/l_nav_2m.jpg" style="width:16px;height:16px;">
						<img src="http://tyt24.ru/img/l_nav_4m.jpg" style="width:16px;height:16px;">
						<img src="http://tyt24.ru/img/l_nav_5m.jpg" style="width:16px;height:16px;">
						<img src="http://tyt24.ru/img/l_nav_3m.jpg" style="width:16px;height:16px;">
						<img src="http://tyt24.ru/img/l_nav_1m.jpg" style="width:16px;height:16px;">
						</center>
					</div>

					<a href="{$SITE_URL}/item/index/id/{$hit.id}/"><h3 class="company_name">{$hit.name}</h3></a>
					<ul class="com_list_info" style="margin-top: -5px;">
						<li>{$hit.adress}</li>
						<li class="metro" id="out{$smarty.foreach.company.iteration}"></li>
						{*<li>Рубрика:<a href="#"> Магазины - мясные продукты</a></li>*}
						{*<li class="phone">{$hit.phone}</li>*}
					</ul>
				</div>
                             {/foreach}
			</div>

			<div class="pager bottom_pager">
                            {if $count>0}
				<p class="left">
                              {if !isset($what)}  Вы искали: <a href="#">{$what}</a>.  {/if}
                                Найдено: {$count|number_format:0:".":" "}</p>
                                <p class="right" style="width:400px;text-align:right;">Страница:
									{if $page > 1}
										<a href='{$SITE_URL}/list/index/what/{$what}/where/{$where}/okved/{$okved}/okato/{$okato}/page/{math equation="x-1" x=$page}/'><<</a> 
									{/if}
                                    {section name=for loop=$pages+1 start=$start max=10}

                                      {if $smarty.section.for.index == $page}
                                            <span  class="selected" ><b>{$page}</b></span>
                                      {else}
                                            <a href="{$SITE_URL}/list/index/what/{$what}/where/{$where}/okved/{$okved}/okato/{$okato}/page/{$smarty.section.for.index}/">{$smarty.section.for.index}</a>
                                      {/if}
                                    {/section}
									{if $page < $pages}
										<a href='{$SITE_URL}/list/index/what/{$what}/where/{$where}/okved/{$okved}/okato/{$okato}/page/{math equation="x+1" x=$page}/'>>></a> 
									{/if}
                                </p>
                            {else}
                                <p class="left">
                             {if !isset($what)}  Вы искали: <a href="#">{$what}</a>.  {/if}
 </p>
                            {/if}
                            <div class="map" id="YMapsID" style="width:100%;height:400px"></div>
			</div>

		</div>

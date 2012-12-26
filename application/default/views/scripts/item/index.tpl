<script type="text/javascript" src="http://api-maps.yandex.ru/1.1/?key=AE07qE0BAAAAa8RdbAIAGoy1Go-5BSLfD2D68SYnvlS6BokAAAAAAAAAAAAG4jsyAHFKz2lsQaettz9OdTPwFg==&modules=regions~metro~traffic" charset="utf-8"></script>
<script type="text/javascript" src="/scripts/js/jquery.custom_radio_checkbox.js"></script>
{literal}
<script type="text/javascript">
//$(document).ready( function () {
   var map, geoResult;

        // Создание обработчика для события window.onLoad
        YMaps.jQuery(function () {
            // Создание экземпляра карты и его привязка к созданному контейнеру
            map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);

            // Установка для карты ее центра и масштаба
            traffic = new YMaps.Traffic.Control({   // Настройки элемента управления
            showInfoSwitcher: true,             // Показать в кнопке переключатель "Дорожные события"
            infoLayerOptions: {                 // Опции слоя дорожных событий
                cursor: YMaps.Cursor.HELP
            }
        }, {                                    // Начальное состояние элемента управления
            shown: true,                        // Немедленно включить показ пробок
            infoLayerShown: true                // Показывать слой дорожных событий
        });
			
			            // Добавление элементов управления
        
            map.addControl(traffic);
            map.addControl(new YMaps.TypeControl());
            map.addControl(new YMaps.ToolBar());
            map.addControl(new YMaps.Zoom());
          //  map.addControl(new YMaps.MiniMap());
            map.addControl(new YMaps.ScaleLine());
                       // Добавление элементов управления
            map.addControl(new YMaps.TypeControl());
            // Удаление предыдущего результата поиска
	
	
            map.removeOverlay(geoResult);

  

                      // Запуск процесса геокодирования
            var geocoder = new YMaps.Geocoder("{/literal}{$item->getAdress()}{literal}", {results: 1, boundedBy: map.getBounds()});
            // Создание обработчика для успешного завершения геокодирования
            YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {
                // Если объект был найден, то добавляем его на карту
                // и центрируем карту по области обзора найденного объекта
                if (this.length()) {
                    geoResult = this.get(0);
                    map.addOverlay(geoResult);
                    map.setBounds(geoResult.getBounds());
                    
                    bounds = new YMaps.GeoCollectionBounds(this.get(0).getBounds().getCenter());
                    //map.setBounds(bounds);
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
                         var station = metro.get(0).AddressDetails.Country.Locality.Thoroughfare.Premise.PremiseName;

                         station = station.replace('метро ', '');
                         var Out=document.getElementById('out');
                            Out.innerHTML += station;
                         metro.get(0).name = "Станция Метро";
                         metro.get(0).description = station;
                         //alert(metro.get(0).getBounds().getLeftBottom());
                         map.addOverlay(metro);
                         bounds.add(metro.get(0).getBounds().getCenter());
                         
                         map.setBounds(bounds);
       
                         } else {
                                //alert("Поблизости не найдено станций метро");
                             }
                          });

            YMaps.Events.observe(metro, metro.Events.Fault, function (metro, error) {
              alert("При выполнении запроса произошла ошибка: " + error);
            });
            /*END METRO */


                }else {
                    alert("Ничего не найдено")
                }

            

            // Процесс геокодирования завершен неудачно
            YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (geocoder, error) {
                alert("Произошла ошибка: " + error);
            })
    
		});
});

  
    </script>
<script type="text/javascript">

var browser_name = navigator.appName;

function printit() {

    if (browser_name == "Netscape") {
        window.print();
    } else {
        var WebBrowser = '<object id="WebBrowser1"></object>';
        document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
        WebBrowser1.ExecWB(6, 2);
    }
}

// Добавить в Избранное
function add_favorite(a) {
  title=document.title;
  url=document.location;
  try {
    // Internet Explorer
    window.external.AddFavorite(url, title);
  }
  catch (e) {
    try {
      // Mozilla
      window.sidebar.addPanel(title, url, "");
    }
    catch (e) {
      // Opera
      if (typeof(opera)=="object") {
        a.rel="sidebar";
        a.title=title;
        a.url=url;
        return true;
      }
      else {
        // Unknown
        alert('Нажмите Ctrl-D чтобы добавить страницу в закладки');
      }
    }
  }
  return false;
}

  //      });
</script>
<script type="text/javascript">
$(document).ready( function (){
	$('.radio').dgStyle();
});
</script>
{/literal}
<div class="company_page">
			<div class="company_rek">
				<ul class="company_rub">
					<li><a href="{$SITE_URL}/index/index/okved/">Рубрики ></a></li>
                                    {foreach name="menu" from=$menu item=hit}
                                        <li><a href="{$SITE_URL}/index/index/okved/{$hit.id}/">{$hit.name}</a></li>
                                    {/foreach}
                                        <li style="color:#2D96FE">{$second.name}</li>
				</ul>

				<ul class="company_region">
                                   <li><a href="{$SITE_URL}/index/index/okved/">Регионы ></a></li>
                                        <li><a title="{$menu_okato[3].title}" href="{$SITE_URL}/index/index/okato/{$menu_okato[3].id}/">{$menu_okato[3].name}</a></li>
                                        <li><a title="{$menu_okato[2].title}" href="{$SITE_URL}/index/index/okato/{$menu_okato[2].id}/">{$menu_okato[2].name}</a></li>
                                        <li><a title="{$menu_okato[1].title}" href="{$SITE_URL}/index/index/okato/{$menu_okato[1].id}/">{$menu_okato[1].name}</a></li>
                                        <li style="color:#FF332D">{$menu_okato[0].name}</li>
                                       
				
					

				</ul>
			</div>
			<div class="company_info">
				<div class="clear">
				<h3 class="company_name">{*Таганский гастроном <br />*}<b>{$item->getName()}</b></h3>
				<div class="adress">

					<ul class="attributes">
						<li class="city">{$item->getAdress()}</li>


						<li class="metro" id="out">
                                 </li>
						<li class="phone">{$item->getPhone()}</li>
						<li class="fax">{$item->getFax()}</li>
                                                {if ($user->isAuthenticated())}
                                                    <li class="mail"><a href="mailto:{$item->getEmail()}">{$item->getEmail()}</a></li>
                                                {else}
                                                    <li class="mail"><a href="{$SITE_URL}/users/login/">Авторизируйтесь</a></li>
                                                {/if}
                                                <li class="site"><a target="_blank" href="{$SITE_URL}/index/away/to/{$item->getWeb()}">{$item->getWeb()}</a></li>
                        
						<li class="rub">Рубрика: <a title="{$second.name}" href="{$SITE_URL}/index/index/okved/{$second.id}/">{$second.name}</a></li>
                                                <li style="padding:0px"><div class="map" id="YMapsID" style="width:100%;height:400px"></div> </li>
					</ul>
				</div>
				<div class="order">
					<div id="order_form">
						<div id="order_form_header">Заказать отчет</div>
						{foreach from=$reports key=key item=item}
							<div class="order_block">
					        	<div class="order_block_header">{$item->title}</div>
					        	<div class="order_block_price">Цена от {$item->price} руб.</div>
					            <div class="order_block_more">
					            	<a href="{$item->url}">Подробнее</a>
					                <div class="order_block_more_icon"></div>
					                <div class="clear"></div>
					            </div>
					            <div class="order_block_icon">
					            {if isset($item->img)}
					            	{assign var="item_img" value=$item->img}
					            {else}
					            	{assign var="item_img" value="deforder.png"}
					            {/if}
					            	<div class="order_block_mark" style="background:url('/upload/order/{$item_img}') no-repeat top left;"></div>
					            </div>
					            
								<div class="order_popup_submit" id="popup_{$item->id}">
									<div class="popup_close" onclick="closePopup('popup_{$item->id}')">X</div>
									<label>
										<div class="radio">
											<input type="radio" name="type_order_{$item->id}" value="info" checked="checked">
										</div>
										<div> 
											<img src="/images/inf_main_b_new.png" style="float:left; margin: 0 4px 0 3px;">
											<b class="inf op_table_title">Информационный отчет:</b><br>
											доставка на Email 
										</div>
									</label>
									{if $item->flag2 == 1 || $item->flag3 == 1}
									<label>
										<div class="radio">
											<input type="radio" name="type_order_{$item->id}" value="off">
										</div>
										<div> 
											<img src="/images/off_main_b_new.png" style="float:left; margin: 0 4px 0 3px;">
											<b class="off op_table_title">Официальный отчет:</b><br>
											доставка курьером
										</div>
									</label>
									{/if}
									<div class="ops_button">
										<a href="/reports/order/fastmode/true/add1/{$item->id}/cid/{$id}">
											<div class="white_basket"></div>
											<span>добавить в корзину</span>
										</a>
									</div>
								</div>
					        </div>
						{/foreach}
					</div>
					
				</div>
				</div>
				
				<div class="company_menu">
					<ul>
						<li class="print"><a href="#" onClick="printit()">Распечатать</a></li>
						<li class="bookmark" ><a href="#"  onclick="return add_favorite(this);">Добавить закладку</a></li>
						{*<li class="mailing"><a href="#">Отправить по почте</a></li>*}
						<li class="comment"><a href="#">Добавить отзыв</a></li>
                                               
					</ul>
				</div>
			</div>
        </div>
{literal}
<script type="text/javascript">
	$('.order_block_more_icon').hover(
		function(){
			$('.order_popup_submit').each(function(){
				$(this).hide();
			});
			$(this).parents('.order_block').find('.order_popup_submit').show();
		}
	);

	function closePopup(id){
		$('#'+id).hide();
	}

	$('.order_popup_submit input:radio').change(function(){
		var id = $(this).parents('.order_popup_submit').attr('id').replace('popup_', '');
		//console.log($(this).parents('.order_popup_submit').attr('id'));
		if ($(this).val() == 'off'){
			$(this).parents('.order_popup_submit').find('.ops_button a').attr('href', '/reports/order/id/'+id);
		}
		else if ($(this).val() == 'info'){
			$(this).parents('.order_popup_submit').find('.ops_button a').attr('href', '/reports/order/fastmode/true/add1/'+id+{/literal}'/cid/{$id}'{literal});
		}
	});
</script>
{/literal}		

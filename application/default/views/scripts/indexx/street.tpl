<script type="text/javascript" src="http://api-maps.yandex.ru/1.1/?key=AE07qE0BAAAAa8RdbAIAGoy1Go-5BSLfD2D68SYnvlS6BokAAAAAAAAAAAAG4jsyAHFKz2lsQaettz9OdTPwFg==&modules=regions~metro~traffic" charset="utf-8"></script>
{literal}
<script type="text/javascript">
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
            var geocoder = new YMaps.Geocoder("{/literal}{$name}{literal}", {results: 1, boundedBy: map.getBounds()});
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
{/literal}
{if isset($name)}
<div id="YMapsID" style="width: 100%; height: 800px;"></div>

{/if}

<script type="text/javascript" src="http://api-maps.yandex.ru/1.1/?key=AE07qE0BAAAAa8RdbAIAGoy1Go-5BSLfD2D68SYnvlS6BokAAAAAAAAAAAAG4jsyAHFKz2lsQaettz9OdTPwFg==&modules=regions~metro~traffic" charset="utf-8"></script>

{literal}
    <script>
      YMaps.jQuery(function () {
            // создание карты
        var map = new YMaps.Map(YMaps.jQuery('#YMapsIDmain')[0]),
            // создание элемента управления "Пробки"
            traffic = new YMaps.Traffic.Control({   // Настройки элемента управления
            showInfoSwitcher: false,             // Показать в кнопке переключатель "Дорожные события"
            infoLayerOptions: {                 // Опции слоя дорожных событий
                cursor: YMaps.Cursor.HELP
            }
        }, {                                    // Начальное состояние элемента управления
            shown: false,                        // Немедленно включить показ пробок
            infoLayerShown: true                // Показывать слой дорожных событий
        });

        // инициализация карты 37.61,55.75 - москва, 30.313,59.939- питер
        map.setCenter(new YMaps.GeoPoint(30.313,59.939), 10);
        // добавление элемента управления "Пробки" на карту
        map.addControl(traffic);
        //map.addControl(new YMaps.ToolBar());
        map.addControl(new YMaps.Zoom());
        // включение показа пробок
        traffic.show();
      });
    </script>
{/literal}

<div id="YMapsIDmain" style="width: 200px; height: 400px;"></div>
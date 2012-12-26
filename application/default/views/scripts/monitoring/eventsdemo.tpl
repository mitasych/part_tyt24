<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

<div>
    <div class="main_top_text">

        {breadcrumb controller="monitoring" alias="monitoring" altTitle="Мониторинг"}
        {include file="lmenu.tpl"}
        <div>

            <link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/redmond/jquery-ui-1.8.2.custom.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/ui.jqgrid.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/ui.multiselect.css" />

            <script src="/scripts/js/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
            <script src="/scripts/js/jquery.layout.js" type="text/javascript"></script>
            <script src="/scripts/js/i18n/grid.locale-ru.js" type="text/javascript"></script>

            {literal}
            <script type="text/javascript">
                $.jgrid.no_legacy_api = true;
                $.jgrid.useJSON = true;
            </script>
            <style type="text/css">
                .searchFLD {
                    width:100px;
                    
                }
            </style>
            {/literal}

            <script type="text/javascript" src="/admin/js/calendar/calendar.js"></script>
            <script type="text/javascript" src="/admin/js/calendar/calendar-setup.js"></script>
            <script type="text/javascript" src="/admin/js/calendar/lang/calendar-ru.js"></script>
            <style type="text/css"> @import url("/admin/js/calendar/calendar-win2k-1.css"); </style>


            <script src="/scripts/js/ui.multiselect.js" type="text/javascript"></script>
            <script src="/scripts/js/jquery.jqGrid.js" type="text/javascript"></script>

            
            <div>
                <a href="/monitoring/events/filter/all/">{if $monfilter == 'all'}<b>все ({$user->getTotalEventCount()})</b>{else}все ({$user->getTotalEventCount()}){/if}</a> / <a href="/monitoring/events/filter/year/">{if $monfilter == 'year'}<b>год</b>{else}год{/if}</a> / <a href="/monitoring/events/filter/month/">{if $monfilter == 'month'}<b>месяц</b>{else}месяц{/if}</a> / <a href="/monitoring/events/filter/week/">{if $monfilter == 'week'}<b>неделя</b>{else}неделя{/if}</a> / <a href="/monitoring/events/filter/new/">{if $monfilter == 'new'}<b>новые ({$user->getLastEventCount()})</b>{else}новые ({$user->getLastEventCount()}){/if}</a>
            </div><br>

            <div id="ss">
                <div class="h">Наименование/ИНН:</div>
                <div>
                    <input type="text" id="search_innnaim" onkeydown="doSearch(arguments[0]||event);" />
                    <br><a href="javascript:void(0)" onclick="$('#search_innnaim').val('');$('#ss').hide();$('#sr').show();doSearch(arguments[0]||event);">Расширенный поиск</a>
                </div>
            </div>

            


            <div id="sr" style="display:none;">
                {*<div class="h">Расширенный поиск:</div>*}
                <div>
                    <table><tr><td>
                                Наименование:</td>
                            <td>ИНН:</td>
                            <td>Регион:</td>
                            <td>Страна:</td>
                        </tr>
                        <tr>
                            <td><input style="width:200px;" class="searchFLD" type="text" id="search_kontragent_title" onkeydown="doSearch(arguments[0]||event)" />&nbsp;&nbsp;</td>
                            <td><input class="searchFLD" type="text" id="search_inn" onkeydown="doSearch(arguments[0]||event)" />&nbsp;&nbsp;</td>
                            <td><select style="width:200px;" class="searchFLD" id="search_region" onchange="doSearch(arguments[0]||event)"><option></option>{foreach from = $rList item=ritem}<option>{$ritem}</option>{/foreach}</select>&nbsp;&nbsp;</td>
                            <td><select class="searchFLD" type="text" id="search_country" onchange="doSearch(arguments[0]||event)"><option></option>{foreach from = $cList item=citem}<option>{$citem}</option>{/foreach}</select></td>
                        </tr>
                    </table>
                    <br>
                    <table><tr><td>
                                Дата события:</td>
                            <td>Дата добавления:</td>

                        </tr>
                        <tr>
                            <td>с <input class="searchFLD" type="text" id="search_event_date" name="search_event_date" onchange="doSearch(arguments[0]||event)" />

			{literal}
                                <script type="text/javascript">
                                    Calendar.setup({
                                    inputField    : "search_event_date",
                                    ifFormat 	  : "%d-%m-%Y",
                                    showsTime     : false,
                                    timeFormat    : "24",
                                    align         : "Tr"
                                    });
                                </script>
			{/literal}

                                по <input class="searchFLD" type="text" id="search_event_date_po" name="search_event_date_po" onchange="doSearch(arguments[0]||event)" />

			{literal}
                                <script type="text/javascript">
                                    Calendar.setup({
                                    inputField    : "search_event_date_po",
                                    ifFormat 	  : "%d-%m-%Y",
                                    showsTime     : false,
                                    timeFormat    : "24",
                                    align         : "Tr"
                                    });
                                </script>
			{/literal}&nbsp;&nbsp;</td>
                            <td>с <input class="searchFLD" style="width:105px;" type="text" id="search_date_created" name="search_date_created" onchange="doSearch(arguments[0]||event)" />


                                {literal}
                                <script type="text/javascript">
                                    Calendar.setup({
                                    inputField    : "search_date_created",
                                    ifFormat 	  : "%d-%m-%Y",
                                    showsTime     : false,
                                    timeFormat    : "24",
                                    align         : "Tr"
                                    });
                                </script>
			{/literal}

                                по <input class="searchFLD" style="width:105px;" type="text" id="search_date_created_po" name="search_date_created_po" onchange="doSearch(arguments[0]||event)" />


                                {literal}
                                <script type="text/javascript">
                                    Calendar.setup({
                                    inputField    : "search_date_created_po",
                                    ifFormat 	  : "%d-%m-%Y",
                                    showsTime     : false,
                                    timeFormat    : "24",
                                    align         : "Tr"
                                    });
                                </script>
			{/literal}</td>
                        </tr>
                    </table>
                    <br><table><tr><td>Описание:</td><td>
                                Тип события:</td>


                        </tr>
                        <tr>
                            <td style="vertical-align:top;"><input class="searchFLD" type="text" id="search_content" onkeydown="doSearch(arguments[0]||event)" />&nbsp;&nbsp;</td>
                            <td>{foreach from=$ttList item=et}
                                <input onclick="doSearch(arguments[0]||event)" type="checkbox" checked="1" class="searchFLD" id="search_event_type_{$et->id}" value="{$et->id}" /> <b style="color:{$et->getColor()}">{$et->title|escape}</b>&nbsp;&nbsp;
                                {/foreach}</td>
                        </tr>
                    </table>

                </div>
                <br><a href="javascript:void(0)" onclick="$('#sr .searchFLD').val('');$('#sr').hide();$('#ss').show();doSearch(arguments[0]||event);">Стандартный поиск</a>
            </div>


            <br />
            <table id="bigset"></table>
            <div id="pagerb"></div>
            {literal}
            <script type="text/javascript">
             jQuery("#bigset").jqGrid({
                url:'/monitoring/eventsdatademo/',
                datatype: "json",
                height: 530,
                width: 700,
                colNames:['Контрагент', 'ИНН', 'Регион', 'Страна', 'Дата события', 'Тип события', 'Описание', 'Дата добавления'],
                    colModel :[
                        {name:'kontragent_title', index:'kontragent_title', width:90}
                        ,{name:'inn', index:'inn', width:70, align:'right'}
                        ,{name:'region', index:'region', width:80}
                        ,{name:'country', index:'country', width:80, align:'right'}
                        ,{name:'event_date', index:'event_date', width:80, align:'right'}
                        ,{name:'event_type', index:'event_type', width:80, align:'right'}
                        ,{name:'content', index:'content', width:80, align:'right'}
                        ,{name:'date_created', index:'date_created', width:110, align:'right'}
                        ],
                rowNum:20,
                        rowList:[20,30,40],
                mtype: "POST",
                pager: jQuery('#pagerb'),
                pgbuttons: true,
                pgtext: false,
                pginput:false,
                sortname: 'event_date',
                    sortorder: "desc",
                    viewrecords: true,
                    
              
                        });
                        var timeoutHnd;
                        var flAuto = true;

                        function doSearch(ev){
                if(!flAuto)
                    return;
                        //	var elem = ev.target||ev.srcElement;
                if(timeoutHnd)
                    clearTimeout(timeoutHnd)
                timeoutHnd = setTimeout(gridReload,500)
                        }

                        function gridReload(){
                        
                        
                        var event_type_mask = {/literal}
                        {foreach from=$ttList item=et}jQuery("#search_event_type_{$et->id}").attr('checked')*jQuery("#search_event_type_{$et->id}").val()+'-'+{/foreach}'0';
            {literal}

                var search_innnaim_mask = jQuery("#search_innnaim").val();
                var kontragrnt_title_mask = jQuery("#search_kontragent_title").val();
                var inn_mask = jQuery("#search_inn").val();
                var region_mask = jQuery("#search_region").val();
                var country_mask = jQuery("#search_country").val();
                var event_date_mask = jQuery("#search_event_date").val();
                //var event_type_mask = jQuery("#search_event_type").val();
                var event_date_po_mask = jQuery("#search_event_date_po").val();
                var date_created_po_mask = jQuery("#search_date_created_po").val();
                var content_mask = jQuery("#search_content").val();
                var date_created_mask = jQuery("#search_date_created").val();

                jQuery("#bigset").jqGrid('setGridParam',{url:"/monitoring/eventsdatademo/?search_innnaim_mask="+search_innnaim_mask+"&kontragent_title_mask="+kontragrnt_title_mask+"&inn_mask="+inn_mask+"&region_mask="+region_mask+"&country_mask="+country_mask+"&event_date_mask="+event_date_mask+"&event_date_po_mask="+event_date_po_mask+"&event_type_mask="+event_type_mask+"&content_mask="+content_mask+"&date_created_mask="+date_created_mask+"&date_created_po_mask="+date_created_po_mask,page:1}).trigger("reloadGrid");
                        }
                        
            </script>
            {/literal}

            <p>
                <br>
                <b>Типы событий :</b><br><br>
                {foreach from=$ttList item=et}
                <span style="width:20px; height:20px;background-color:{$et->getColor()}">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<b style="color:{$et->getColor()}">{$et->title|escape}</b> - {$et->description|escape}<br>
                {/foreach}
            </p>
        </div>


        <div class="dotted2"></div>
    </div>
</div>
{*<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>*}

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
                    width:74px;
                    font-size:10px;
                }
            </style>
            {/literal}

            <script type="text/javascript" src="/admin/js/calendar/calendar.js"></script>
            <script type="text/javascript" src="/admin/js/calendar/calendar-setup.js"></script>
            <script type="text/javascript" src="/admin/js/calendar/lang/calendar-ru.js"></script>
            <style type="text/css"> @import url("/admin/js/calendar/calendar-win2k-1.css"); </style>


            <script src="/scripts/js/ui.multiselect.js" type="text/javascript"></script>
            <script src="/scripts/js/jquery.jqGrid.js" type="text/javascript"></script>


            <div class="h">Поиск:</div>
            <div>
                <input class="searchFLD" type="text" id="search_kontragent_title" onkeydown="doSearch(arguments[0]||event)" />
                <input class="searchFLD" style="width:65px;" type="text" id="search_inn" onkeydown="doSearch(arguments[0]||event)" />
                <input class="searchFLD" type="text" id="search_region" onkeydown="doSearch(arguments[0]||event)" />
                <input class="searchFLD" type="text" id="search_country" onkeydown="doSearch(arguments[0]||event)" />
                <input class="searchFLD" type="text" id="search_event_date" name="search_event_date" onchange="doSearch(arguments[0]||event)" />

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


                <input class="searchFLD" type="text" id="search_event_type" onkeydown="doSearch(arguments[0]||event)" />
                <input class="searchFLD" type="text" id="search_content" onkeydown="doSearch(arguments[0]||event)" />
                <input class="searchFLD" style="width:105px;" type="text" id="search_date_created" name="search_date_created" onchange="doSearch(arguments[0]||event)" />

                
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


                {*<button onclick="gridReload()" id="submitButton" style="margin-left:30px;">Search</button>*}
            </div>

            <br />
            <table id="bigset"></table>
            <div id="pagerb"></div>
            {literal}
            <script type="text/javascript">
             jQuery("#bigset").jqGrid({
                url:'/monitoring/eventsdata/',
                datatype: "json",
                height: 230,
                width: 700,
                colNames:['Контрагент', 'ИНН', 'Регион', 'Страна', 'Дата события', 'Тема события', 'Информация', 'Дата добавления'],
                    colModel :[
                        {name:'kontragent_title', index:'kontragent_title', width:80}
                        ,{name:'inn', index:'inn', width:70, align:'right'}
                        ,{name:'region', index:'region', width:80}
                        ,{name:'country', index:'country', width:80, align:'right'}
                        ,{name:'event_date', index:'event_date', width:80, align:'right'}
                        ,{name:'event_type', index:'event_type', width:80, align:'right'}
                        ,{name:'content', index:'content', width:80, align:'right'}
                        ,{name:'date_created', index:'date_created', width:110, align:'right'}
                        ],
                rowNum:10,
                        rowList:[10,20,30],
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

                var kontragrnt_title_mask = jQuery("#search_kontragent_title").val();
                var inn_mask = jQuery("#search_inn").val();
                var region_mask = jQuery("#search_region").val();
                var country_mask = jQuery("#search_country").val();
                var event_date_mask = jQuery("#search_event_date").val();
                var event_type_mask = jQuery("#search_event_type").val();
                var content_mask = jQuery("#search_content").val();
                var date_created_mask = jQuery("#search_date_created").val();

                jQuery("#bigset").jqGrid('setGridParam',{url:"/monitoring/eventsdata/?kontragent_title_mask="+kontragrnt_title_mask+"&inn_mask="+inn_mask+"&region_mask="+region_mask+"&country_mask="+country_mask+"&event_date_mask="+event_date_mask+"&event_type_mask="+event_type_mask+"&content_mask="+content_mask+"&date_created_mask="+date_created_mask,page:1}).trigger("reloadGrid");
                        }
                        
            </script>
            {/literal}


        </div>


        <div class="dotted2"></div>
    </div>
</div>
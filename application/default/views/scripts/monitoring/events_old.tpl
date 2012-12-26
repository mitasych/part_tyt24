{literal}
	<script type="text/javascript">
		function clear_form(){
			$('input[type="text"]').val('');
			$('#search_region').val('');
			$('#search_country').val('');
			
			gridReload();
		}
        var indexCheckBox=0;
	</script>
{/literal}

<div class="right_part2" {if $currentinfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentinfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
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
                jQuery.jgrid.no_legacy_api = true;
                jQuery.jgrid.useJSON = true;
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

            
           
			<div id="ras_s" style="float:left;">
				<input type="text" id="search_innnaim" onKeyDown="doSearch(arguments[0]||event);" placeholder="Наименование/ИНН" >
				<br>
				<a href="javascript:void(0)" id="SearchName"  style="font-size: 10px;color:#DBA108;" onClick="$('#standart_s').show();$('#clear_form').show();$('#ras_s').hide();jQuery('#search_innnaim').val('');jQuery('#search_innnaim').hide();jQuery('#ss').hide();jQuery('#sr').show();doSearch(arguments[0]||event);jQuery('#SearchBG').attr('style','background-image:url(/img/bg_table.jpg);')">Расширенный поиск</a>
                <a href="javascript:void(0)" id="SearchName1"  style="display:none; font-size: 10px;color:#DBA108;" onClick="$('#standart_s').show();$('#clear_form').show();$('#ras_s').hide();jQuery('#search_innnaim').val('');jQuery('#search_innnaim').hide();jQuery('#ss').hide();jQuery('#sr').show();doSearch(arguments[0]||event);jQuery('#SearchBG').attr('style','background-image:url(/img/bg_table.jpg);')">Изменить параметри поиска</a>
			</div>
			<div id="standart_s" style="float:left;margin-bottom:20px;display:none;width:202px;">
				
				<a href="javascript:void(0)" style="font-size: 10px;color:#DBA108; "  onClick="$('#clear_form').hide();$('#ras_s').show();$('#standart_s').hide();jQuery('#search_innnaim').show();jQuery('#sr .searchFLD').val('');jQuery('#sr').hide();jQuery('#ss').show();doSearch(arguments[0]||event);$('.type_select');indexCheckBox=0;{foreach from=$ttList item=et}if($('#search_event_type_{$et->id}').attr('checked'))indexCheckBox++;{/foreach};if(indexCheckBox < 3)$('#SearchName').hide(),$('#SearchName1').show();if(indexCheckBox == 3)$('#SearchName').show(),$('#SearchName1').hide();jQuery('#SearchBG').removeAttr('style')">Простой поиск</a>
			
			</div>
			 <div align="right" style="margin-right:50px;">
                <a href="/monitoring/events/filter/all/">{if $monfilter == 'all'}
                    <b>все ({$user->getTotalEventCount()})</b>{else}все ({$user->getTotalEventCount()})
                    {/if}</a> |   {if $user->getEventMon()>0} <a href="/monitoring/events/filter/year/">
                            {if $monfilter == 'year'}<b>за год</b>
                         {else}за год
                    {/if}</a> 
                     {else}за год {/if}  |


                          {if $user->getEventMon()>0} <a href="/monitoring/events/filter/month/">
                    {if $monfilter == 'month'}<b>за месяц</b>
                         {else}за месяц
                    {/if}</a> 
                     {else}за месяц {/if} 



                    |       {if $user->getEventMon()>0} <a href="/monitoring/events/filter/week/">
                            {if $monfilter == 'week'}<b>за неделю</b>
                         {else}за неделю
                    {/if}</a> 
                     {else}за неделю {/if}  |
                     {if $user->getLastEventCount() == 0}
                                     новые             
                    {else}
                    <a href="/monitoring/events/filter/new/">
                    {if $monfilter == 'new'}
                         {if $user->getLastEventCount() > 0}
                              <b>новые </a>
                             ({$user->getLastEventCount()}){/if}</b>
                             {else}новые</a>
                                {if $user->getLastEventCount() > 0}
                                     ({$user->getLastEventCount()})
                                
                                 {/if}
                             {/if}
                    
                            {/if}

            </div>
			
			<br><br>

            <!--<div id="ss">
                <div class="h"><span class="">Наименование/ИНН:</span></div>
                <div>
                    <input type="text" id="search_innnaim" onkeydown="doSearch(arguments[0]||event);" />
                   
                </div>
            </div>-->

            
			{literal}<style>
				#search_country
				{
				color: #999999;
				}
							
				#search_region{
					color:#999;
				}
				#search_region:first{
					color:#000;
				}
				#sr .n{
					color:#1f5863;
					font-weight:bold;
				}
				#sr .n1{
					color:#1f5863;
				}
			</style>{/literal}

            <div id="SearchBG">
            <div id="sr" style="display:none;padding-top:5px;">
                {*<div class="h">Расширенный поиск:</div>*}
				<span class="n">Расширенный поиск:</span> <a href="javascript:clear_form()" style="font-size: 10px;color:#DBA108;">очистить</a><br>
				
				<input type="text" placeholder="Наименование" style="width:200px;" class="searchFLD" type="text" id="search_kontragent_title" onkeydown="doSearch(arguments[0]||event)">
				<input class="searchFLD" placeholder="ИНН" type="text" id="search_inn" onKeyDown="doSearch(arguments[0]||event)" />
				<select style="width:200px;" placeholder="Регион" class="searchFLD" id="search_region" onChange="doSearch(arguments[0]||event)"><option value="" selected>Регион</option><option></option>{foreach from = $rList item=ritem}<option>{$ritem}</option>{/foreach}</select>
				<select style="width:200px;" placeholder="Страна" class="searchFLD" id="search_country" onChange="doSearch(arguments[0]||event)"><option value="" selected>Страна</option><option value="RU">RU</option><option value="UA">UA</option></select>
                <div>
                  
                    <br>
                  
                                <span class="n1">Период:</span></td>
                           

                        <input class="searchFLD" type="text" placeholder="c" id="search_event_date" name="search_event_date" style="width:69px;" onChange="doSearch(arguments[0]||event)" />

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

                                - <input class="searchFLD" type="text" placeholder="по" id="search_event_date_po" name="search_event_date_po" style="width:69px;" onChange="doSearch(arguments[0]||event)" />

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
			{/literal}
			&nbsp;&nbsp;&nbsp;<input class="searchFLD" placeholder="Описание" type="text" id="search_content"  onKeyDown="doSearch(arguments[0]||event)" style="width:342px"/>
			<br>
			
					<br>
					
					<span class="n1">Тип события</span> 
                    (<a href="#" onClick="javascript:$('.type_select').attr('checked','checked');  doSearch(arguments[0]||event); return false;">выбрать всё</a>/
                    <a href="#" onClick="javascript:$('.type_select').removeAttr('checked'); doSearch(arguments[0]||event); return false; ">снять всё</a>):
					           {foreach from=$ttList item=et }
                                <label >
                                    <input class="type_select" onChange="doSearch(arguments[0]||event)" type="checkbox" checked="checked" 
                                    style="width:10px;" class="searchFLD" id="search_event_type_{$et->id}" 
                                    value="{$et->id}" /> 
                                    <b style="color:{$et->getColor()}">{$et->title|escape}</b>
                                </label>
                                {/foreach}
					
					
					
                    
                            

                </div>
               
            </div>


            <br />
            <table id="bigset"></table>
            <div id="pagerb"></div>
			<div id=info style='display:none; position:absolute; top:220px;z-index:10000; left: 500px'>
				
			</div>
            {literal}
            <script type="text/javascript">
			
	//jQuery(document).ready(function(){
					//	alert('');	
					//	alert( document.all ); 
      setTimeout(function(){
			jQuery("#bigset").jqGrid({
                url:'/monitoring/eventsdata/',
                datatype: "json",
                height: 100+'%',
                width: 700,
                hoverrows: false,
                colNames:['','Наименование','ИНН','Регион','Страна',  'Дата<br />события', 'Описание',  'События '],
                colModel :[
						{name:'checkbox', index:'checkbox',width:25,align:'center'},
                        {name:'kontragent_title', index:'kontragent_title',width:200}
						,{name:'inn', index:'inn'}
                        ,{name:'region', index:'region'}
                        ,{name:'country', index:'country',align:'left'}
						,{name:'event_date', index:'event_date', align:'right'}
                        ,{name:'content', index:'content', align:'left'}
                       
                        
                        ,{name:'event_type', index:'event_type',align:'left'}
						
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
                    viewrecords: true
               });
				},1000);
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
                        
                        {/literal}
                        var event_type_mask = 
                        {foreach from=$ttList item=et} jQuery("#search_event_type_{$et->id}").is(':checked')*jQuery("#search_event_type_{$et->id}").val()+'-'+{/foreach}'0';
			
            {literal}
				
                var search_innnaim_mask = jQuery("#search_innnaim").val();
                var kontragrnt_title_mask = jQuery("#search_kontragent_title").val();
                var inn_mask = jQuery("#search_inn").val();
                var region_mask = jQuery("#search_region").val();
                var country_mask = jQuery("#search_country").val();
                var event_date_mask = jQuery("#search_event_date").val();
                //var event_type_mask = jQuery("#search_event_type").val();//this
                var event_date_po_mask = jQuery("#search_event_date_po").val();
                var date_created_po_mask = jQuery("#search_date_created_po").val();
                var content_mask = jQuery("#search_content").val();
                var date_created_mask = jQuery("#search_date_created").val();

                jQuery("#bigset").jqGrid('setGridParam',{url:"/monitoring/eventsdata/?search_innnaim_mask="+search_innnaim_mask+"&kontragent_title_mask="+kontragrnt_title_mask+"&inn_mask="+inn_mask+"&region_mask="+region_mask+"&country_mask="+country_mask+"&event_date_mask="+event_date_mask+"&event_date_po_mask="+event_date_po_mask+"&event_type_mask="+event_type_mask+"&content_mask="+content_mask+"&date_created_mask="+date_created_mask+"&date_created_po_mask="+date_created_po_mask,page:1}).trigger("reloadGrid");
                        }
						
                        $('.description').live('click', function(){
                         $(this).parent().parent().dblclick();
                          return false;
                        });     

//                        $('.description').live('mouseout', function(){
//                         //alert('dfghjk');
//                         base_h = $(this).offset().top - 20;
//                         //alert("/monitoring/eventinfo/event_id/"+$(this).attr('value')+"/");
//                         $.get("/monitoring/eventinfo/event_id/"+$(this).attr('value')+"/", function(data){
//                                 //alert("Data Loaded: " + data);
//                                 $('#infor').hide();
//                             //    $('#infor').append(data);
//                                // $('#info').offset({top:base_h - $('#info').outerHeight()});
//                             }
//                         );
//                            
//                         // $(this).parent().parent().dblclick();
//                         // return false;
//                        });            
                        
                        // $('tr[role="row"]').live('click', function(){
                        //  $('#info').hide();
                        // });
                        
                        // $('tr[role="row"]').live('dblclick', function(){
                        //   //alert('dfghjk');
                        //  $('#info').show();
                        //  $('#info').offset({top:$(this).offset().top - 20});
                        //  return false;
                        //  //$(this).child('a').click();
                        //  base_h = $(this).offset().top - 20;
                        //  $.get("/monitoring/eventinfo/event_id/"+$(this).attr('id')+"/", function(data){
                        //          //alert("Data Loaded: " + data);
                        //          $('#info').show();
                        //          $('#info').html('<div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-top: -5px;" onclick="$(\'#info\').hide();">X</div>'+data);
                        //          $('#info').offset({top:base_h - $('#info').outerHeight()});
                        //          $('#info').addClass('events_info_block');
                        //      }
                        //  );
                        // }); 
                                             
						
						$('tr[role="row"]').live('click', function(){
							$('#infor').hide();
						});
						
						$('tr[role="row"]').live('dblclick', function(){
							/* //alert('dfghjk');
							$('#info').show();
							$('#info').offset({top:$(this).offset().top - 20});
							return false;*/
							//$(this).child('a').click();
							base_h = $(this).offset().top - 20;
							//alert("/monitoring/eventinfo/event_id/"+$(this).attr('value')+"/");
							$.get("/monitoring/eventinfo/event_id/"+$(this).attr('id')+"/", function(data){
									//alert("Data Loaded: " + data);
									$('#infor').show();
									$('#infor').html('<div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-top: -5px;" onclick="$(\'#infor\').hide();">X</div>'+data);
									$('#infor').offset({top:base_h - $('#info').outerHeight()});
									$('#infor').addClass('events_info_block');
								}
							);
						});                 



						 // });
            
            </script>
            {/literal}
            <div  id="infor" style="position: absolute; top: 149px; z-index: 10000; left: 500px; display: none;" class="events_info_block">
               
            </div>
            <br><br>
        </div>
            <p>
               <b style="color:#1f5863">События({$user->getTotalEventCount()})<span style="font-size:11px; color:#1f5863;"> </span>:</b><br>
                {foreach from=$ttList item=et}
               
               <span style="cursor:pointer;" onClick="{foreach from=$user->getEventId($et->id) key=myId item=i}
                 if(!$('#{$i.id}').attr('aria-selected'))($('#{$i.id}').attr('aria-selected','true').attr('class','ui-widget-content jqgrow ui-row-ltr ui-state-highlight'));
                 else($('#{$i.id}').removeAttr('aria-selected').attr('class','ui-widget-content jqgrow ui-row-ltr'));
                  {/foreach}"> 
                  <span style="width:20px; height:20px;background-color:{$et->getColor()}">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<b style="color:{$et->getColor()}">{$et->title|escape}({$user->getEventCount($et->id)})
                 </b> - {$et->description|escape}</span><br>
                {/foreach}
            </p><br>
			
        </div>


        <div class="dotted2">
            
                
  
        </div>
    </div>
</div>
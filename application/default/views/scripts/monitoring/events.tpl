{literal}
<script type="text/javascript">
    var how_click= '{/literal}{$datas.click}{literal}';
    var how_window = "{/literal}{$datas.window}{literal}";                                       
        function confirmDelete(id) {
           if (confirm("Вы подтверждаете удаление?")) {
               $.post('/monitoring/events?idDel='+id, function(data) {
                   if(data=='true'){
                       gridReload();
                       }
                        
                  });
               } else {
                return false;
              }
        }
     
    function clear_form(){
        $('input[type="text"]').val('');
        $('#search_region').val('');
        if( $('#all_countries').attr('checked'))
        {
            $('#search_country').val('');
        }
        gridReload();
    }
    var indexCheckBox=0;
    function ClickSelect(temp){ $(temp).click();}    

    function StyleLabel(temp){

        if($('#search_event_type_'+temp).attr('checked')){
            {/literal}{foreach from=$ttList item=et }{literal}
            if ( {/literal}{$et->id} {literal}==temp)
            {
                $('#event_label_'+temp).removeAttr('style');
                $('#event_label_'+temp).attr('style','background-color:{/literal}{$et->getColor()}{literal};color:#fff;padding:2px;');
            }
            {/literal}{/foreach}{literal}
        }
        if(!$('#search_event_type_'+temp).attr('checked')){
            {/literal}{foreach from=$ttList item=et }{literal}
            if ( {/literal}{$et->id} {literal}==temp)
            {
                $('#event_label_'+temp).removeAttr('style');
                $('#event_label_'+temp).attr('style','color:{/literal}{$et->getColor()}{literal};padding:2px;');
            }
            {/literal}{/foreach}{literal}
        }
    }
        setTimeout( function (){
            $('.main_t:first').click();
        }, 200) ;
        
        $('.main_t').live('click',function(){

            $('.submain_t').hide();
            $('span[val="all"]').show();
            $('.main_t').removeClass("active");
            $('#rightcomp').removeAttr("class");
            $('#rightcomp').attr('class','rightcomp_disact');
            $('.rightcomp_act').removeAttr('class').attr('class','rightcomp_disact');
            $('.submain_t').removeClass("active");
            $(this).addClass('active');
            $(this).next('#rightcomp').attr('class','rightcomp_act');
            $('.submain_t[val2="'+$(this).attr('value')+'"]').show();
            $('.submain_t[val2="'+$(this).attr('value')+'"]:first').click();
            if ($(this).attr('id')!='filter_all'){$('select[name=tarif_id_one]').val('');$('#change_tarif').hide();}
    });
    
        
    $('.submain_t').live('click',function(){
        $('.submain_t').removeClass("active");
        $(this).addClass('active');
        $('#tarifs span').hide();
        $('#tarifs span[parent='+$(this).attr('value')+']').show();
        return false;
    });
    
    $('#filter_all').live('click',function(){
                    $('.main_t').removeClass("active");
                    $('.submain_t').removeClass("active");
                    $(this).addClass('active');
                    $('#tarifs span').show();
                    $('#change_tarif').show();
                    
                });  



        $('.btn_tarif').mouseout(function (){
            $('#description').hide();
        });
        $('.btn_tarif').mouseover(function (kmouse){
            id = $(this).attr('val2');
            base_h = kmouse.pageY - 450;
            base_w = kmouse.pageX - 220;
            var id_el = '#description';
            $.get('/monitoring/tarifinfo', {tarif_id : $(this).attr('val')}, function(data){
                $('#conteiner_info').html(data);
            });
            $(id_el).addClass('events_info_block');
            $(id_el).css('top', base_h).css('left', base_w);
            $(id_el).show();        
        });

        var change_arr = [];
        function change_search(){
            if(change_arr['#ras_search_link'] == undefined || change_arr['#ras_search_link'] == false){
                $('#ras_search_link').css({'font-weight':'bold','background':'#FAF295'});
                $('#ras_search_link'+' a').css({'color':'red', 'text-decoration': 'none'});
                $('#ras_search_link'+' img').attr('src','/images/drill_up_red.jpg');
                $('#ras_search_link'+' span').css('display','block');   
                $('#simly_search_form').hide();     
                change_arr['#ras_search_link'] = true;
            }else{
                $('#ras_search_link').css('font-weight','normal');
                $('#ras_search_link'+' a').css({'color':'#2D96FE', 'text-decoration': 'underline'});
                $('#ras_search_link'+' img').attr('src','/images/drill_down.jpg');
                $('#ras_search_link'+' span').css('display','none');
                $('#simly_search_form').show(); 
                change_arr['#ras_search_link'] = false;
            }
            $('#sr').toggle();
        }

        jQuery("#give_csv").live('click', function() { 
            var s;
            s = jQuery("#bigset").jqGrid('getGridParam','selarrrow');
            loc="http://tyt24.ru/monitoring/events?"
            for(var i=0; i<s.length; i++) {
                if(i==0) {
                    loc+='csvArray[]='+s[i];
                } else {
                    loc+='&csvArray[]='+s[i];
                }
            }
            location.href = loc;
        });
    
        function sortBy(){
            var sort=$('select#group1').val(); 
            if(sort==1){    
                  $.post('/monitoring/eventsbylist/',function(data){
                    $("#datajqgrid").html("")
                    $('#datajqgrid').html(data);
                    gridReload();
                    
                })  
            }               

            if(sort==2)
                $.post('/monitoring/eventsdatagroup/',function(data){
                    $("#datajqgrid").html("")
                    $('#datajqgrid').html(data);
                    gridReload();
                    
                })            

            if(sort==3)
                 $.post('/monitoring/eventscompany/',function(data){
                    $("#datajqgrid").html("")
                    $('#datajqgrid').html(data);
                    gridReload();
                    
                })
        }

       
        function showTooltip(elem,event){
            event = event || window.event;
            var temp = elem.offset();
            var t=$(document).height()-(temp.top+133);
            $('.company_info_block').css('bottom',t+'px');
            $('#tpointer').css({'bottom':t-16+'px','left':temp.left-15+elem.outerWidth()/2+'px','top':'auto'}); 
            $('#tpointer').show();
            if (event.clientX < $(document).width()/2){ 
                    var l=$(document).width()-(temp.left+elem.outerWidth()+28);
                    $('.company_info_block').css('left','auto');    
                $('.company_info_block').css('right',l+'px');
            }
             else {
                $('.company_info_block').css('right','auto');
                $('.company_info_block').css('left',temp.left+'px');

            }
        }   
</script>
{/literal}

{*$ev.date_created|date_format:"%Y%m%d"}:{literal} {{/literal} klass: "highlight2", tooltip: "Дата мониторинга" }{literal*}
<div class="right_part2" {if $currentinfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
    <div class="bg_ie" {if $currentinfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}></div>
    <div>
        <div class="main_top_text">
            {breadcrumb controller="monitoring" alias="monitoring" altTitle="Мониторинг"}
            {include file="lmenu.tpl"}
            <div>
                <link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/redmond/jquery-ui-1.8.2.custom.css" />
                <link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/ui.jqgrid.css" />
                <link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/ui.multiselect.css" />

                <link id="skin-gold" title="Gold" type="text/css" rel="alternate stylesheet" href="/admin/js/calendar2/css/gold/gold.css" />
                <link type="text/css" rel="stylesheet" href="/admin/js/calendar2/css/jscal2.css" />
                <link type="text/css" rel="stylesheet" href="/admin/js/calendar2/css/border-radius.css" />
                <link id="skinhelper-compact" type="text/css" rel="alternate stylesheet" href="/admin/js/calendar2/css/reduce-spacing.css" />

                <script src="/scripts/js/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
                <script src="/scripts/js/jquery.layout.js" type="text/javascript"></script>
                <script src="/scripts/js/i18n/grid.locale-ru.js" type="text/javascript"></script>

                {literal}
                <script type="text/javascript">
                        jQuery.jgrid.no_legacy_api = true;
                        jQuery.jgrid.useJSON = true;
                </script>
                <style type="text/css">
                    .searchFLD { width:100px;}
                </style>
                {/literal}
                <script src="/admin/js/calendar2/js/jscal2.js"></script>
                <script src="/admin/js/calendar2/js/unicode-letter.js"></script>
                <script src="/admin/js/calendar2/js/lang/ru.js"></script>       

                <script src="/scripts/js/jquery.jqGrid.js" type="text/javascript"></script>

            <form action="" method="post" name="check_tarifs" id="check_tarif" > 
    
            
            <div>
                <span class='main_t' name="allTarif" id='filter_all' style="cursor:pointer;" onClick="filter_all='on'; $('#hide_country_radio').show();">Все услуги</span><span id="rightcomp" class="rightcomp_disact"></span>
                {foreach from=$type item=typ}

                {if ($typ->id==$user->getCountMon1()->all_id)}
                    <span class='main_t active' id="active" onmouseover="$('#InfoCompany_{$typ->id}').show();showTooltip($(this),event);" onmouseout="$('#InfoCompany_{$typ->id}').hide();$('#tpointer').hide();" style="cursor:pointer;" value={$typ->id}>{$typ->name}</span> <span id="rightcomp" class="rightcomp_act"></span>
                    {/if}
                {if ($typ->id!=$user->getCountMon1()->all_id)}
                    <span class='main_t' style="cursor:pointer;" onmouseover="$('#InfoCompany_{$typ->id}').show();showTooltip($(this),event);" onmouseout="$('#InfoCompany_{$typ->id}').hide();$('#tpointer').hide();" value={$typ->id}>{$typ->name}</span><span id="rightcomp" class="rightcomp_disact"></span>
                    {/if}
                    <div align="left" id="InfoCompany_{$typ->id}"  class="company_info_block" style="display:none;">
                        <b>{$typ->about}</b>
                    </div> <span id="tpointer" style="display:none;"> </span>
                {/foreach}
            
            </div> 
            <div>
            {foreach from=$tarif item=tar}
                {if $tar->name != ''}
                    <span class='submain_t' style="padding:2px;cursor:pointer;" val2='{$tar->type}' value="{$tar->id}">{$tar->name}</span>
                {/if}
            {/foreach}
            </div><br>
            {if count($userTarifs) > 0}
            <div id="tarifs" style="float:right;margin-top:-15px;text-align:right;">
            Активные услуги: {foreach from=$userTarifs item=item}
            {if $item->count==$user->getCountMon()}
              <span onclick="$('.btn_tarif').removeAttr('id');$(this).attr('id','btn_active');doSearch(arguments[0]||event); " class="btn_tarif_{$item->tarifId} btn_tarif" style="cursor:pointer; " id="btn_active" parent='{$item->all_id}' val='{$item->id}' val2='{$item->tarifId}'>{$item->count}-{$item->m}-{$item->period}</span>
                {/if}
            {if $item->count!=$user->getCountMon()}
              <span onclick="$('.btn_tarif').removeAttr('id');$(this).attr('id','btn_active');doSearch(arguments[0]||event);" class="btn_tarif_{$item->tarifId} btn_tarif" style="cursor:pointer; " parent='{$item->all_id}' val='{$item->id}' val2='{$item->tarifId}'>{$item->count}-{$item->m}-{$item->period}</span>
                {/if}
            {/foreach}
            </div>
            <input type="hidden" name="all_tarifs" value="{ $current_mon_tarif }" id="all_input_t"/>
        </form> 
            {/if}
                <div align="left" >
                    {*<a href="/monitoring/events/" {if ACTION_NAME=='events'}style="text-decoration:none;font-weight:bold;"{/if}> события </a>|*}
                    <br>
                    <div id="simly_search_form">
                        <table style="width:100%;">
                            <tr>
                                <td colspan="3"> 
                                      <div id="country_choice" style="float: left;min-width: 280px;">
                                         <span class="active_item" id="all_countries" onClick="$('#country_choice span').removeClass('active_item');$(this).addClass('active_item');$('#search_country').val('');$('#search_innnaim').attr('placeholder','Компания/(ИНН/ЕДРПОУ)');$('#search_inn').attr('placeholder','ИНН/ЕДРПОУ');$('#search_country').removeAttr('disabled'); 
                                                    $('#jqgh_inn').html('ИНН/ЕДРПОУ');
                                                    $('#hide_inn').next().html('ИНН/ЕДРПОУ');
                                                    {foreach from=$ttList item=et }$('#type_event_'+{$et->id}).removeAttr('style');$('#search_event_type_'+{$et->id}).attr('checked','checked');{/foreach};
                                                    {if $user->getTotalEventCount()==''}$('#bottom_type_all').html('(0)');{/if}            
                                                    {foreach from=$ttList item=et}
                                                    $('#bottom_type_'+{$et->id}).html({$user->getEventCount($et->id)});                  
                                                    {if $user->getEventCount($et->id)<>''}$('#type_eve_'+{$et->id}).removeAttr('style').attr('style','cursor:pointer'); {/if}
                                                    {/foreach}
                                                    {if $user->getTotalEventCount()<>''}$('#bottom_type_all').html('('+{$user->getTotalEventCount()}+')');{/if}
                                                    $('#img_ua').hide();$('#img_ru').hide();$('#small_event_types').show();$('#full_event_types').hide();
                                                    doSearch(arguments[0]||event)" checked> <label color="#1F5763" for="all_countries">Все страны &nbsp;</label>
                                        </span>
                    <span id="country_ru" onClick="$('#country_choice span').removeClass('active_item');$(this).addClass('active_item');        
                                                    $('#search_country').val('RU');$('#search_innnaim').attr('placeholder','Компания/ИНН');$('#search_inn').attr('placeholder','ИНН');$('#search_country').attr('disabled','disabled');
                                                    $('#jqgh_inn').html('ИНН');
                                                    $('#hide_inn').next().html('ИНН');
                                                    {foreach from=$ttList item=et }$('#type_event_'+{$et->id}).attr('style','display:none');$('#search_event_type_'+{$et->id}).removeAttr('checked');{/foreach};
                                                    {foreach from=$eveCountry item=et1}{if $et1.id_country==258}$('#search_event_type_'+{$et1.id_type}).attr('checked','checked');$('#type_event_'+{$et1.id_type}).removeAttr('style');{/if}{/foreach}
                                                    {foreach from=$eventsdata key=k item=et1}$('#bottom_type_'+{$k}).html({$et1.RU});{if $et1.RU==0}$('#type_eve_'+{$k}).attr('style','display:none');{/if}{if $et1.RU<>0}$('#type_eve_'+{$k}).removeAttr('style').attr('style','cursor:pointer');{/if}{if $et1.RU_ev_all==''}$('#bottom_type_all').html('0');{/if}{if $et1.RU_ev_all<>''}$('#bottom_type_all').html({$et1.RU_ev_all});{/if}{/foreach};$('#img_ua').hide();$('#img_ru').show();$('#small_event_types').hide();$('#full_event_types').show();
                                                    doSearch(arguments[0]||event);"><label color="#1F5763" for="country_ru"><img src="/images/258.gif"> Россия &nbsp;</label>
                     </span>
                    <span id="country_ua" onClick="$('#country_choice span').removeClass('active_item');$(this).addClass('active_item');$('#search_country').val('UA');$('#search_innnaim').attr('placeholder','Компания/ЕДРПОУ');$('#search_inn').attr('placeholder','ЕДРПОУ');$('#search_country').attr('disabled','disabled');
                                                    $('#jqgh_inn').html('ЕДРПОУ');
                                                    $('#hide_inn').next().html('ЕДРПОУ');
                                                    {foreach from=$ttList item=et }$('#type_event_'+{$et->id}).attr('style','display:none');$('#search_event_type_'+{$et->id}).removeAttr('checked');{/foreach};
                                                    {foreach from=$eveCountry item=et1}{if $et1.id_country==252}$('#search_event_type_'+{$et1.id_type}).attr('checked','checked');$('#type_event_'+{$et1.id_type}).removeAttr('style');{/if}{/foreach}
                                                    {foreach from=$eventsdata key=k item=et1}$('#bottom_type_'+{$k}).html({$et1.UA});{if $et1.UA==0}$('#type_eve_'+{$k}).attr('style','display:none');{/if}{if $et1.UA<>0}$('#type_eve_'+{$k}).removeAttr('style').attr('style','cursor:pointer');{/if}{if $et1.UA_ev_all==''}$('#bottom_type_all').html('0');{/if}{if $et1.UA_ev_all<>''}$('#bottom_type_all').html({$et1.UA_ev_all});{/if}{/foreach};$('#img_ua').show();$('#img_ru').hide();$('#small_event_types').hide();$('#full_event_types').show();
                                                    doSearch(arguments[0]||event);"><label color="#1F5763" for="country_ua"><img src="/images/252.gif"> Украина &nbsp;</label>       
                    </span>
                                </div>          

                                    <div id="string_menu" style="float: right;min-width: 185px;">
                                        <input type="hidden" id="favorites" val="0">
                                        <span class="active_item" id="event_all" onclick="$('#string_menu span').removeClass('active_item');$(this).addClass('active_item');
					$('#favorites').val(0);$('#favorites').val(0);doSearch(arguments[0]||event);"> <label color="#1F5763"> Все </label> </span>
                                        <span id="event_favorites" onclick="$('#string_menu span').removeClass('active_item');$(this).addClass('active_item');
                                                    $('#favorites').val(1);doSearch(arguments[0]||event);"> <img src="/img/star_event.png">  <label color="#1F5763"> избранное </label> </span>
                                        </span>
                                        
                                            {if $user->getLastEventCount() == 0} <span> <label> новые </label> </span>          
                                            {else}  <span onClick="$('#string_menu span').removeClass('active_item');$(this).addClass('active_item');">
                                                    <a href="/monitoring/events/filter/new/" id="event_new" onclick="doSearch(arguments[0]||event);">
                                                   {if $smarty.server.REQUEST_URI == '/monitoring/events/filter/new/'}
                                                     {if $user->getLastEventCount() > 0} 
						         <label>новые </label> </a>({$user->getLastEventCount()})
                                                     {/if}
                                                  {else}<label> новые </label> </a> 
                                                       {if $user->getLastEventCount() > 0} ({$user->getLastEventCount()}) {/if}
                                                  {/if}

                                            {/if}
                                        </span>
                                       </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="ras_s" class="style_input">                
                                        <input type="text" id="search_innnaim" onKeyDown="doSearch(arguments[0]||event);" placeholder="Компания/ИНН/ЕДРПОУ" size="31">
                                    </div>          
                                </td>
                                <td>
                                    <div class="style-select"> 
                                        <select style="width:120%;" id="group" name="group" onChange= "doSearch(arguments[0]||event)">
                                            <optgroup>
                                                {* <option value="all" selected>за весь период</option>
                                                <option value="year">за год</option>
                                                <option value="month">за месяц</option>
                                                <option value="week">за неделю</option>*}
                                                {if $smarty.server.REQUEST_URI == '/monitoring/events/filter/all/'}
                                                <option value="all" selected>за весь период</option>
                                                {else} <option value="all">за весь период</option>
                                                {/if}

                                                {if $smarty.server.REQUEST_URI == '/monitoring/events/filter/all/'} 
                                            <b>все ({$user->getTotalEventCount()})</b>
                                            {else}все ({$user->getTotalEventCount()})
                                            {/if} 

                                            {if $user->getEventYear()>0}
                                            {if $smarty.server.REQUEST_URI == '/monitoring/events/filter/year/'}
                                            <option value="year" selected>за год</option>
                                            {else} <option value="year">за год</option>
                                            {/if}
                                            {/if}  

                                            {if $user->getEventMon()>0} 
                                            {if $smarty.server.REQUEST_URI == '/monitoring/events/filter/month/'}
                                            <option value="month" selected>за месяц</option>
                                            {else} <option value="month">за месяц</option>
                                            {/if}
                                            {/if} 

                                            {if $user->getEventWeek()>0} 
                                            {if $smarty.server.REQUEST_URI == '/monitoring/events/filter/week/'}
                                            <option value="week" selected>за неделю</option>
                                            {else} <option value="week">за неделю</option>
                                            {/if}
                                            {/if} 
                                            </optgroup>
                                        </select>
                                    </div>
                                </td>
                                <td> 
                                    {* <a href="/monitoring/events/" {if ACTION_NAME=='events'}style="text-decoration:none;font-weight:bold;"{/if}> &nbsp; списком </a>| группировать по <br>
                                    <input type="radio" name="group_events" onClick="location.href = '/monitoring/eventscompany/'"> Компаниям 
                                    <input type="radio" name="group_events"
                                           onClick="location.href = '/monitoring/eventsdatagroup/'"> Дате мониторинга
                                    *}

                                    <div class="style-select"> 
                                        <select id="group1" style="width:110%"  onChange= "sortBy()">
                                            <optgroup>
                                                <option value="1"> события списком</option>
                                                <option value="2"> по дате мониторинга</option>
                                                <option value="3"> по компаниям </option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </td>                               
                            </tr>

                            <tr> 
                                <td colspan="2" > 
                                    <div onclick ="$('#simly_search_form').hide(); $('#sr').show();"> <a href="javascript:void(0)" style="font-size:11px;">  расширенный поиск</a>  
                                        <img src="/images/drill_down.jpg"/>  </div>
                                </td>
                                 <td align="right">
                                    <span class="radio_style"> <input type="radio" name="full_short" value="1" id='short_radio' onClick="fullShort()" > <label color="#1F5763" for="short_radio">Кратко</lable>                             
                                    </span>
                                    <span class="radio_style"> <input type="radio" value="2" name="full_short" id='full_radio' onChange="fullShort()" > <label color="#1F5763" for="full_radio">Подробно</lable>                             
                                    </span>
                                    <!-- <div class="style-select" style="width:70%; float:right;"> 
                                        <select id="full_short" style="width:130%"  onChange= "fullShort()">
                                            <optgroup>
                                                <option value="1"></option>
                                                <option value="2">подробно</option>
                                            </optgroup>
                                        </select>
                                    </div> -->
                                </td>
                            </tr>
                        </table>
                    </div>     
                    <br>


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
                            color:#000;
                        }
                    </style>{/literal}



                    <div id="sr" style="display:none;">

                        <table cellspacing="0" cellpadding="5" style="width:100%; font-size: 12px; background-color: #F7F4B2;" border="1">
                            <tr>
                                <td colspan="3" > 
                                    <span onclick ="$('#sr').hide(); $('#simly_search_form').show();"> <a href="javascript:void(0)" style="font-size:12px; text-decoration:none;color:#FF332D;font-weight:bold">   расширенный поиск</a>  <img src="/images/red_up.png"/>
                                    </span>
                                    <span class="check_exel"> <input type="checkbox" name="fav_com" id='fav_com' onchange="doSearch(arguments[0]||event)" > <label color="#1F5763" for="fav_com">Помеченные компании</lable>                             
                                    </span>
                                </td>
                                <td style="padding-right: 10px; text-align: right;font-size: 12px;">
                                    <span >  <a style="text-decoration:underline;font-weight:bold" id="event_all1" href="javascript:;" onclick="
                                            $('#favorites').val(0);
                                            $('#event_all').css('font-weight','bold');  
                                            $('#event_all1').css('font-weight','bold');      
                                            $('#event_favorites').css('font-weight','normal');
                                            $('#event_favorites1').css('font-weight','normal');
                                            $('#event_new').css('font-weight','normal');
                                            $('#event_new1').css('font-weight','normal');
                                            doSearch(arguments[0]||event);">Все</a> |
                                        <img src="/img/star_event.png"> <a style="text-decoration:underline;" id="event_favorites1" href="javascript:;" onclick="
                                                $('#favorites').val(1);
                                                $('#event_all').css('font-weight','normal');  
                                                $('#event_all1').css('font-weight','normal');      
                                                $('#event_favorites').css('font-weight','bold');
                                                $('#event_favorites1').css('font-weight','bold');
                                                $('#event_new').css('font-weight','normal');
                                                $('#event_new1').css('font-weight','normal');
                                                doSearch(arguments[0]||event);"> избранное</a> |
                                        {if $user->getLastEventCount() == 0} новые             
                                        {else} <a href="/monitoring/events/filter/new/" id="event_new1" onclick="
                                                $('#event_all').css('font-weight','normal');  
                                                $('#event_all1').css('font-weight','normal');      
                                                $('#event_favorites').css('font-weight','normal');
                                                $('#event_favorites1').css('font-weight','normal');
                                                $('#event_new').css('font-weight','bold');
                                                $('#event_new1').css('font-weight','bold');
                                                doSearch(arguments[0]||event);">
                                            {if $smarty.server.REQUEST_URI == '/monitoring/events/filter/new/'}
                                            {if $user->getLastEventCount() > 0}
                                            новые </a>
                                        ({$user->getLastEventCount()})
                                        {/if}
                                        {else}новые</a>
                                        {if $user->getLastEventCount() > 0}
                                        ({$user->getLastEventCount()})
                                        {/if}
                                        {/if}

                                        {/if}</span>
                                </td>
                            </tr>
                            <tr>
                                {*
                                <td>
                                    {foreach from=$type item=typ}
                                    <span class="radio_style">
                                        <input type='radio'  name='razdel' value='{$typ->id}' id="razdel_{$typ->id}"  onChange="doSearch(arguments[0]||event) ;"
                                               ><label color="#1F5763" for="razdel_{$typ->id}" >{$typ->name}</label></span>
                                    {/foreach}

                                    <div>
                <span class='main_t' style="cursor:pointer;" value=0>Все</span> <span id="rightcomp" class="rightcomp_act"></span>
            {foreach from=$type item=typ}
                <span class='main_t' onmouseover="$('#InfoCompany_{$typ->id}').show();event_tip($(this),event);" onmouseout="$('#InfoCompany_{$typ->id}').hide();$('#tpointer').hide();" style="cursor:pointer;" value={$typ->id}>{$typ->name}  </span> <span id="rightcomp" class="rightcomp_disact"> </span> 
                <div align="left" id="InfoCompany_{$typ->id}"  class="events_info_block" style="display:none;position:absolute;min-width: 100px;max-width: 400px;z-index:100;overflow:hidden;"> 
                                            
                    <b>{$typ->about}</b>                        
                  </div> <span id="tpointer" style="display:none"> </span>  
            {/foreach}
            </div>


                                </td> *}
                                <td>
                                    <div class="style_input" style="width: 300px;">             
                                        <input type="text" placeholder="Компания" class="searchFLD" type="text" id="search_kontragent_title" onkeydown="doSearch(arguments[0]||event)"> </div>
                                </td>
                                <td> 
                                    <div class="style_input">
                                        <input class="searchFLD" placeholder="ИНН/ЕДРПОУ" type="text" id="search_inn" onKeyDown="doSearch(arguments[0]||event)" /> 
                                    </div>
                                </td>
                                <td>
                                    <div class="style-select">
                                        <select placeholder="Регион" class="searchFLD" id="search_region" onChange="doSearch(arguments[0]||event)"><optgroup><option value="" selected>
                                                    Регион</option>{foreach from = $rList item=ritem}
                                                <option value="{$ritem.region}">{$ritem.region}</option>

                                                {/foreach}</optgroup>
                                        </select>
                                    </div> 
                                </td>

                                <td>
                                    <div class="style-select">
                                        <select placeholder="Страна" class="searchFLD" id="search_country" onChange="doSearch(arguments[0]||event)"> <optgroup> <option value="" onClick="$('#all_countries').click();$('#search_country').removeAttr('disabled')" selected> Страна </option> <option value="RU" onClick="$('#country_ru').click();$('#search_country').removeAttr('disabled')"> Россия </option> <option value="UA" onClick="$('#country_ua').click();$('#search_country').removeAttr('disabled')">Украина</option></optgroup></select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="min-width: 250px;margin-top: -10px;">
                                        <span class="n1">Период: дата события|мониторинга <br></span>

                                        <script type="text/javascript">
                                                var LEFT_CAL = Calendar.setup({
                                                    cont: "cont",
                                                    weekNumbers: true,
                                                    selectionType: Calendar.SEL_MULTIPLE,
                                                    showTime: false
                                                    // titleFormat: "%B %Y"
                                                });
                                                var DATE_INFO = {literal}{

                                                    {/literal}{foreach from=$CalendarData item=ev}
                                                    {$ev.date_created|date_format:"%Y%m%d"}:{literal} {{/literal} klass: "highlight2", tooltip: "<span style='border-radius:3px; width:25px; height:25px;background-color:#0000FF'>&nbsp;&nbsp;&nbsp;&nbsp;</span> Дата мониторинга" }{literal},  
                                                    {/literal}{$ev.event_date|date_format:"%Y%m%d"}:{literal} {{/literal} klass: "highlight", tooltip: "<span style='border-radius:3px; width:25px; height:25px;background-color:#FF8C00'>&nbsp;&nbsp;&nbsp;&nbsp;</span> Дата события" }{literal},
                                                    {/literal}{/foreach}{literal}
                                                };

                                                function getDateInfo(date, wantsClassName) {
                                                    var as_number = Calendar.dateToInt(date);
                                                    return DATE_INFO[as_number];
                                                }{/literal};

                                        </script>


                                        {literal}<style>
                                            .highlight { color: #fff !important; font-weight: bold;background-color: #FF8C00; }
                                            .highlight2 { color: #fff !important; font-weight: bold;background-color: #0000FF;}
                                        </style>{/literal}
                                        <img  src="/img/calendar_icon.png">
                                        <span class="style_input"><input class="searchFLD" type="text" placeholder="дд.мм.гггг" id="search_event_date" name="search_event_date" style="width:30%;text-align:center;" onChange="doSearch(arguments[0]||event)" /></span> 

                                        {literal}
                                        <script type="text/javascript">
                                                RANGE_CAL_1 = new Calendar({
                                                    inputField    : "search_event_date",
                                                    dateFormat    : "%d.%m.%Y",
                                                    trigger       : "search_event_date",
                                                    showsTime     : false,
                                                    timeFormat    : "24",
                                                    dateInfo : getDateInfo,
                                                    align         : "Tr",
                                                    onSelect: function() {
                                                        var date = Calendar.intToDate(this.selection.get());
                                                        LEFT_CAL.args.min = date;
                                                        LEFT_CAL.redraw();
                                                        this.hide();
                                                        doSearch(arguments[0]||event);
                                                    }
                                                });
                                   
                                        </script>
                                        {/literal}
                                        -
                                        <img  src="/img/calendar_icon.png"> 
                                        <span class="style_input"> <input class="searchFLD" type="text" placeholder="дд.мм.гггг" id="search_event_date_po" name="search_event_date_po" style="width:30%;text-align:center;" onChange="doSearch(arguments[0]||event)" /></span>

                                        {literal}
                                        <script type="text/javascript">
                                                RANGE_CAL_1 = new Calendar({
                                                    inputField    : "search_event_date_po",
                                                    dateFormat    : "%d.%m.%Y",
                                                    trigger       : "search_event_date_po",
                                                    showsTime     : false,
                                                    timeFormat    : "24",
                                                    dateInfo : getDateInfo,
                                                    align         : "Tr",
                                                    onSelect: function() {
                                                        var date = Calendar.intToDate(this.selection.get());
                                                        LEFT_CAL.args.min = date;
                                                        LEFT_CAL.redraw();
                                                        this.hide();
                                                        doSearch(arguments[0]||event);
                                                    }
                                 
                                                });
                                        </script>
                                        {/literal}
                                    </div>
                                </td>

                                <td class="style_input" colspan="2">

                                    <input class="searchFLD" placeholder="Описание" type="text" id="search_content"  onKeyDown="doSearch         (arguments[0]||event)"/>
                                </td>
                                <td>
                                    <a id="clean_form" href="javascript:clear_form()" style="font-size: 10px;color:#DBA108;"></a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4"> 
                                    <span class="n1">Тип события:</span>

                                    <span style="margin-left: 2px;">
                                        <a href="#" onClick="javascript:$('.type_select').attr('checked','checked');{foreach from=$ttList item=et }$('#event_label_'+{$et->id}).attr('style','background-color:{$et->getColor()};color:#fff;padding:2px;');{/foreach};doSearch(arguments[0]||event); return false;">выбрать всё</a>|
                                        <a href="#" onClick="javascript:$('.type_select').removeAttr('checked'); {foreach from=$ttList item=et }$('#event_label_'+{$et->id}).attr('style','background-color:#fff;color:{$et->getColor()};padding:2px;');{/foreach}; doSearch(arguments[0]||event); return false; ">снять всё</a> 
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    {foreach from=$ttList item=et }
                                    <span class="check_exel" id="type_event_{$et->id}" onclick="StyleLabel({$et->id})"> &nbsp;
                                        <input class="type_select" onChange="doSearch(arguments[0]||event)" type="checkbox" checked="checked" style="width:10px;" class="searchFLD" id="search_event_type_{$et->id}" value="{$et->id}"/>
                                        <label  for="search_event_type_{$et->id}" >
                                            <b id="event_label_{$et->id}" onclick="StyleLabel({$et->id})" style="background-color:{$et->getColor()};color:#fff;padding:2px;">{$et->title|escape}</b></label>
                                    </span> &nbsp;
                                    {/foreach}
                                <td>
                            </tr>
                        </table>     
                    </div>
                    <span id="info_date_mon"> Дата последнего мониторинга: {$lastMonitoringDate}</span>
                    
                    <div id='option2'  style="display:none;" onClick="$('#option').hide();$('#option2').hide();$('#option1').show();" > <img src="/images/drill_up_red.jpg"/> 
                        <a href="javascript:void(0)"> настройка полей </a> </div>

                    <div>


                      
                           
                            <div id="info_favor" class="events_info_block" style="display:none;position:absolute; top:40%;width:160px;z-index:10000; left: 20%">
                                В Избранном
                            </div>
                            <div id="info_favor1" class="events_info_block" style="display:none;position:absolute; top:40%;width:160px;z-index:10000; left: 20%">
                                Добавить в избранное
                            </div>
                            {*  Избранное: <a href="javascript:void(0)" id="m1">добавить </a>/<a href="javascript:void(0)" id="k1">удалить</a> *}

                            <div id="pagerb"></div>
                            <div id="info" style='display:none; position:absolute; top:220px;z-index:10000; left: 500px'>

                            </div>
                             {literal}
                        
                            <script type="text/javascript" class="inder">
                                $(document).ready(function() { 
                                if ( this.location.href== 'http://tyt24.ru/monitoring/events/filter/new/'){
                                    $('#event_all').css('font-weight','normal');  
                                    $('#event_all1').css('font-weight','normal');      
                                    $('#event_favorites').css('font-weight','normal');
                                    $('#event_favorites1').css('font-weight','normal');
                                    $('#event_new').css('font-weight','bold');
                                    $('#event_new1').css('font-weight','bold');                             
                                } 
                                         
                                var getInn = 0;
                                location.search.substr(1).replace(/([^=&]+)=([^&]*)/g, function(o, k, v) {
                                    getInn = v;
                                });


                                if (getInn!= 0){
                                    setTimeout( function (){ 
                                        $("#search_innnaim").val(getInn).click();
                                        gridReload();
                                    }, 2000) ;}
                                {/literal}


                                {if $datas.kra_pod==0}{literal}
                                setTimeout( function (){ 
                                    $('#full_radio').attr('checked','checked');
                                    $('#full').attr('checked','checked');
                                    insertRow();
                                    $('select#group1 option:eq(1)').attr('selected','selected');
                                }, 3500) ;   
                                {/literal}{/if}{literal}
                                {/literal}{if $datas.kra_pod==1}{literal}

                                setTimeout( function (){  
                                    $('#short_radio').attr('checked','checked');
                                    $('#short').attr('checked','checked');
                                    $('select#group1 option:eq(0)').attr('selected','selected');
                                }, 1100) ;
                                {/literal}{/if}{literal}
                                if (!$("#hide_title").attr('checked'))
                                {
                                    setTimeout( function (){$("#hide_title").click(); 
                                        $('#show_title').removeAttr( 'checked');
                                    }, 2000) ;
                                }
                                if (!$("#hide_region").attr('checked')){
                                    setTimeout( function (){$("#hide_region").click(); 
                                        $('#show_region').removeAttr( 'checked');
                                    }, 2000) ;
                                }
                                if (!$("#hide_country").attr('checked')){
                                    setTimeout( function (){$("#hide_country").click(); 
                                        $('#show_country').removeAttr( 'checked');
                                    }, 2000) ;
                                }
                             
                                if (!$("#hide_desk").attr('checked')){
                                    setTimeout( function (){$("#hide_desk").click(); 
                                        $('#show_desk').removeAttr( 'checked');
                                    }, 2000) ;
                                }

                                if (!$("#hide_inn").attr('checked')){
                                    setTimeout( function (){$("#hide_inn").click(); 
                                        $('#show_inn').removeAttr( 'checked');
                                    }, 2000) ;
                                }
                                if (!$("#hide_date").attr('checked')){
                                    setTimeout( function (){$("#hide_date").click(); 
                                        $('#show_date').removeAttr( 'checked');
                                    }, 2000) ;
                                }
                                if (!$("#hide_event").attr('checked')){
                                    setTimeout( function (){$("#hide_event").click(); 
                                        $('#show_event').removeAttr( 'checked');
                                    }, 2000) ;
                                }
                                if (!$("#hide_m").attr('checked')){
                                    setTimeout( function (){$("#hide_m").click(); 
                                        $('#show_m').removeAttr( 'checked');
                                    }, 2000) ;
                                }

                                if (!$("#hide_t").attr('checked')){
                                    setTimeout( function (){$("#hide_t").click(); 
                                        $('#show_t').removeAttr( 'checked');
                                    }, 2000) ;
                                }


                                });
                        
                        </script>

{/literal}
<div style="margin-top:-30px" id='option1'  onClick="$('#option').show();$('#option1').hide();$('#option2').show();" > <img src="/images/drill_right.jpg"/> 
                        <a href="javascript:void(0)"> настройка полей </a> </div> 
                       <div id="datajqgrid"> 
                        
                             <table id="bigset"></table>  
                             {literal}
                            <script type="text/javascript" class="inder">  
                                    
                                    setTimeout(function(){
                                        jQuery("#bigset").jqGrid({
                                            url:'/monitoring/eventsdata/',
                                            datatype: "json",
                                            height: 100+'%',
                                            width: 700,
                                            hoverrows: false,
                                            colNames:['','Компания','ИНН/ЕДРПОУ','Регион','Страна',  'Дата соб.',  'Тип соб. ','Дата мон.','Услуга', 'Описание',''],
                                            colModel :[                         
                                                {name:'favorites', index:'favorites',align:'center',width:25}
                                                ,{name:'kontragent_title', index:'kontragent_title',width:150}
                                                ,{name:'inn', index:'inn',width:120}
                                                ,{name:'region', index:'region',width:80}
                                                ,{name:'country', index:'country',align:'center',width:80}
                                                ,{name:'event_date', index:'event_date', align:'center',width:130}                        
                                                ,{name:'event_type', index:'event_type',align:'left',width:95}
                                                ,{name:'date_monitoring', index:'date_monitoring',align:'center',width:180}
                                                ,{name:'tarif', index:'tarif',align:'center',width:80}
                                                ,{name:'content', index:'content', align:'left'} 
                                                 ,   {name:'delete_ev', index:'delete_ev', align:'left'} 
                                                 
                                            ],
                                            rowNum:20,
                                            rowList:[3,20,30,40],
                                            mtype: "POST",
                                            pager: jQuery('#pagerb'),
                                            pgbuttons: true,
                                            key: true,
                                            pgtext: false,
                                            pginput:true,
                                            multiselect: true,
                                            cellEdit:true,
                                            sortname: 'event_date',
                                            sortorder: "desc",
                                            viewrecords: true,
                                            gridview : true,
                                            toolbar: [true,"bottom"],
                                            pgbuttons: true,
                                            loadComplete:function(){
                                                view=0;
                                                $('input[name=full_short]').each(function(){
                                                    if($(this).is(':checked')){
                                                       view = $(this).val();
                                                    }
                                                })
                                        
                                                if(view==2){
                                                     $('#short').removeAttr('checked');
                                                     $('#full').attr('checked','checked'); 
                                                     jQuery('#bigset').jqGrid('hideCol','content');
                                                     insertRow()
                                                }          
                                            },
                                            
                                       
                                        });
                                    },1000);

                                    var timeoutHnd;
                                    var flAuto = true;
                                    function doSearch(ev){
                                        if(!flAuto)
                                            return;
                                        //  var elem = ev.target||ev.srcElement;
                                        if(timeoutHnd)
                                            clearTimeout(timeoutHnd)
                                        timeoutHnd = setTimeout(gridReload,500)
                                    }
                                    function gridReload(){                        
                                        {/literal}
                                        var event_type_mask = 
                                            {foreach from=$ttList item=et} jQuery("#search_event_type_{$et->id}").is(':checked')*jQuery("#search_event_type_{$et->id}").val()+'-'+{/foreach}'0';{literal}
                
                                        var search_innnaim_mask = jQuery("#search_innnaim").val();
                                        var inform = $('input:radio[name=inform]:checked').val();
                                        var raz = $('input:radio[name=razdel]:checked').val();
                                        var kontragrnt_title_mask = jQuery("#search_kontragent_title").val();
                                        var inn_mask = jQuery("#search_inn").val();
                                        var region_mask = jQuery("#search_region").val();
                                        var group = jQuery("#group").val();
                                        var country_mask = jQuery("#search_country").val();
                                        var event_date_mask = jQuery("#search_event_date").val();
                                        //var event_type_mask = jQuery("#search_event_type").val();
                                        var event_date_po_mask = jQuery("#search_event_date_po").val();
                                        var date_created_po_mask = jQuery("#search_date_created_po").val();
                                        var content_mask = jQuery("#search_content").val();
                                        var date_created_mask = jQuery("#search_date_created").val();
                                        var fav_com = jQuery("#fav_com").attr("checked");
                                        var favorites = jQuery("#favorites").val();
                                        var tarif = jQuery("#btn_active").attr('val2');
                                        jQuery("#bigset").jqGrid('setGridParam',{url:"/monitoring/eventsdata/?inform="+inform+"&search_innnaim_mask="+search_innnaim_mask+"&kontragent_title_mask="+kontragrnt_title_mask+"&inn_mask="+inn_mask+"&region_mask="+region_mask+"&country_mask="+country_mask+"&event_date_mask="+event_date_mask+"&event_date_po_mask="+event_date_po_mask+"&event_type_mask="+event_type_mask+"&content_mask="+content_mask+"&date_created_mask="+date_created_mask+"&date_created_po_mask="+date_created_po_mask+"&razdel="+raz+"&group="+group+"&fav_com="+fav_com+"&favorites="+favorites+"&tarif="+tarif,page:1}).trigger("reloadGrid");
                                    }
                        
                                    $('.description').live('click', function(){
                                        $(this).parent().parent().dblclick();
                                        $('#infor').hide()
                    $('#tpointer').hide()
                                        setTimeout(function(){$('#infor').hide();},2000);  
                                        return false;
                                    });     
                                    //Названия
                                    $("#hide_title").live('click' ,function() {
                                        $("#hide_title").text('Показать Компанию'); 
                                        $(this).next().attr('for','show_title');
                                        $("#hide_title").attr('id','show_title');
                                        jQuery("#bigset").jqGrid('hideCol','kontragent_title');
                                    });                                       
                                    $("#show_title").live('click' ,function() {
                                        $("#show_title").text('Скрыть Компанию'); 
                                        $(this).next().attr('for','hide_title');
                                        $("#show_title").attr('id','hide_title');
                                        jQuery("#bigset").jqGrid('showCol',"kontragent_title");
                                    });

                                    //Инн
                                    $("#hide_inn").live('click' ,function() {
                                        $("#hide_inn").text('Показать Инн');
                                        $(this).next().attr('for','show_inn'); 
                                        $("#hide_inn").attr('id','show_inn');
                                        jQuery("#bigset").jqGrid('hideCol','inn');
                                    });
                                    $("#show_inn").live('click' ,function() {
                                        $("#show_inn").text('Скрыть Инн'); 
                                        $(this).next().attr('for','hide_inn');
                                        $("#show_inn").attr('id','hide_inn');
                                        jQuery("#bigset").jqGrid('showCol',"inn");
                                    });

                                    //Регион
                                    $("#hide_region").live('click' ,function() {
                                        $("#hide_region").text('Показать Регион'); 
                                        $(this).next().attr('for','show_region');
                                        $("#hide_region").attr('id','show_region');
                                        jQuery("#bigset").jqGrid('hideCol','region');
                                    });
                                    $("#show_region").live('click' ,function() {
                                        $("#show_region").text('Скрыть Регион'); 
                                        $(this).next().attr('for','hide_region');
                                        $("#show_region").attr('id','hide_region');
                                        jQuery("#bigset").jqGrid('showCol',"region");
                                    });

                                    //Страна
                                    $("#hide_country").live('click' ,function() {
                                        $("#hide_country").text('Показать Страну');
                                        $(this).next().attr('for','show_country'); 
                                        $("#hide_country").attr('id','show_country');
                                        jQuery("#bigset").jqGrid('hideCol','country');
                                    });
                                    $("#show_country").live('click' ,function() {
                                        $("#show_country").text('Скрыть Страну'); 
                                        $(this).next().attr('for','hide_country');
                                        $("#show_country").attr('id','hide_country');
                                        jQuery("#bigset").jqGrid('showCol',"country");
                                    });

                                    //Дата
                                    $("#hide_date").live('click' ,function() {
                                        $("#hide_date").text('Показать Дату'); 
                                        $(this).next().attr('for','show_date');
                                        $("#hide_date").attr('id','show_date');
                                        jQuery("#bigset").jqGrid('hideCol','event_date');
                                    });
                                    $("#show_date").live('click' ,function() {
                                        $("#show_date").text('Скрыть Дату'); 
                                        $(this).next().attr('for','hide_date');
                                        $("#show_date").attr('id','hide_date');
                                        jQuery("#bigset").jqGrid('showCol',"event_date");
                                    });

                                    //Описания
                                    $("#hide_desk").live('click' ,function() {
                                        $("#hide_desk").text('Показать Описания'); 
                                        $(this).next().attr('for','show_desk');
                                        $("#hide_desk").attr('id','show_desk');
                                        jQuery("#bigset").jqGrid('hideCol','content');
                                    });
                                    $("#show_desk").live('click' ,function() {
                                        $("#show_desk").text('Скрыть Описание'); 
                                        $(this).next().attr('for','hide_desk');
                                        $("#show_desk").attr('id','hide_desk');
                                        jQuery("#bigset").jqGrid('showCol',"content");
                                    });

                                    //События
                                    $("#hide_event").live('click' ,function() {
                                        $("#hide_event").text('Показать События'); 
                                        $(this).next().attr('for','show_event');
                                        $("#hide_event").attr('id','show_event');
                                        jQuery("#bigset").jqGrid('hideCol','event_type');
                                    });
                                    $("#show_event").live('click' ,function() {
                                        $("#show_event").text('Скрыть События');
                                        $(this).next().attr('for','hide_event'); 
                                        $("#show_event").attr('id','hide_event');
                                        jQuery("#bigset").jqGrid('showCol',"event_type");
                                    });

                                    // Дата мониторинга
                                    $("#hide_m").live('click' ,function() {
                                        $("#hide_m").text('Показать Мониторинг'); 
                                        $(this).next().attr('for','show_m'); 
                                        $("#hide_m").attr('id','show_m');
                                        jQuery("#bigset").jqGrid('hideCol','date_monitoring');
                                    });
                                    $("#show_m").live('click' ,function() {
                                        $("#show_m").text('Скрыть Мониторинг'); 
                                        $(this).next().attr('for','hide_m'); 
                                        $("#show_m").attr('id','hide_m');
                                        jQuery("#bigset").jqGrid('showCol',"date_monitoring");
                                    });    

                                    // Тариф
                                    $("#hide_t").live('click' ,function() {
                                        $("#hide_t").text('Показать Тариф'); 
                                        $(this).next().attr('for','show_t');
                                        $("#hide_t").attr('id','show_t');
                                        jQuery("#bigset").jqGrid('hideCol','tarif');
                                    });
                                    $("#show_t").live('click' ,function() {
                                        $("#show_t").text('Скрыть Тариф');
                                        $(this).next().attr('for','hide_t'); 
                                        $("#show_t").attr('id','hide_t');
                                        jQuery("#bigset").jqGrid('showCol',"tarif");
                                    });                    
        

                                    function  favor (fav,id){
                                        $('#info_favor').hide();
                                        $('#info_favor1').hide();
                                        if(fav==0){
                                            $('#f_'+id).removeAttr('class').attr('class','nofavorites-star');
                                        }
                                        if(fav==1){
                                            $('#f_'+id).removeAttr('class').attr('class','favorites-star');
                                        }
                                        jQuery.post( "/monitoring/event/" ,{favor: fav ,  id_favorites: id }   );
                                        if (fav==1){
                                            $("#f_"+id).attr("src","/img/star_event.png");
                                            $("#f_"+id).attr("onClick","favor(0,"+id+")");                                 
                                            $("#f_"+id).attr("onmouseover","$(\'#info_favor\').show()");
                                            $("#f_"+id).attr("onmouseout","$(\'#info_favor\').hide()");
                                        }
                                        if (fav==0){
                                            $("#f_"+id).attr("src","/img/star_noevent.png");
                                            $("#f_"+id).attr("onClick","favor(1,"+id+")");
                                            $("#f_"+id).attr("onmouseover","$(\'#info_favor1\').show()");
                                            $("#f_"+id).attr("onmouseout","$(\'#info_favor1\').hide()");
                                        }
                                    }
                                    function getUrl(id){
                                            var url = "/monitoring/eventinfo/event_id/"+id+"/?";
                                            if ($('input[name=name]').is(':checked')){
                                                url=url + 'name='+1+'&';
                                            }
                                            if ($('input[name=inn]').is(':checked')){
                                                url=url + 'inn='+1+'&';
                                            }
                                            if ($('input[name=region]').is(':checked')){
                                                url=url + 'region='+1+'&';
                                            }
                                            if ($('input[name=country]').is(':checked')){
                                                url=url + 'country='+1+'&';
                                            }
                                            if ($('input[name=date_event]').is(':checked')){
                                                url=url + 'date_event='+1+'&';
                                            }
                                            if ($('input[name=event]').is(':checked')){
                                                url=url + 'event='+1+'&';
                                            }
                                            if ($('input[name=date_monitoring]').is(':checked')){
                                                url=url + 'date_monitoring='+1+'&';
                                            }
                                            if ($('input[name=tarif]').is(':checked')){
                                                url=url + 'tarif='+1+'&';
                                            }
                                            return url;
                                    }  

                                     clicks = 0;
                                    function ShowEvent(id){
                                        if(how_click=='click'){                                            
                                         var show = true;   
                                        if(($('#'+id).find('td:eq(0)').is(':hover'))||($('#'+id).find('td:eq(1)').is(':hover'))||($('#'+id).find('td:last').is(':hover'))){
                                            show = false;
                                        }else{
                                            show = true;
                                        }
                                        if(show == true){
                                        if (how_window=='standart'){
                                            jQuery("#bigset").jqGrid('viewGridRow', id,{
                                             caption: "Описание события"
                                        });
                                        }
                                        else{
                                            window.open('/monitoring/event/' + id + '', "test", "width=420, height=460, status=no, resizable=no, top=200, left=200");
                                            }     
                                        }
                                    }else{
                                            clicks++;
                                            setTimeout(function(){clicks=0;}, 400);
                                            if(clicks==2){
                                                 var show = true;   
                                                    if(($('#'+id).find('td:eq(0)').is(':hover'))||($('#'+id).find('td:eq(1)').is(':hover'))||($('#'+id).find('td:last').is(':hover'))){
                                                        show = false;
                                                    }else{
                                                        show = true;
                                                    }
                                                    if(show == true){
                                                    if (how_window=='standart'){
                                                        jQuery("#bigset").jqGrid('viewGridRow', id,{
                                                         caption: "Описание события"
                                                    });
                                                    }
                                                    else{
                                                        window.open('/monitoring/event/' + id + '', "test", "width=420, height=460, status=no, resizable=no, top=200, left=200");
                                                    }     
                                            }
                                        }
                                       
                                      }
                                    }
                                
                                    function insertRow(){
                                        var i=0;
                                        $('tr.ui-widget-content').each(function(){
                                            var id = $(this).attr('id');
                                            id = parseInt(id);

                                        if( !isNaN(id) )
                                         if (emptyObject(document.getElementById('desc_'+id))){                                      
                                            last =  jQuery("#bigset").getCell(id,"content");                                      
                                            $(this).find('td').attr('style','border-bottom:0px;');
                                           
                                            $(this).after('<tr class="ui-widget-content jqgrow ui-row-ltr"><td colspan="11" align="center"><span style="width:100%">'+$(last).html()+'</span></td></tr>');  }                 
                                        });                 
                                        
                                            jQuery("#bigset").jqGrid('hideCol',"content");
                                    }

                                     function fullShort(){                                        
                                        var view;
                                        $('input[name=full_short]').each(function(){
                                            if($(this).is(':checked')){
                                               view = $(this).val();
                                            }
                                        })
                                        
                                        if(view==1){
                                            $('#short').attr('checked','checked');
                                            $('#full').removeAttr('checked');                                                       
                                            event=1;
                                            doSearch(arguments[0]||event);
                                            jQuery('#bigset').jqGrid('showCol','content');
                                        }
                                        if(view==2){
                                             $('#short').removeAttr('checked');
                                             $('#full').attr('checked','checked');                                              
                                             insertRow()
                                        }          
                                    }

                                    function showMore(id){
                                        var last =  $('#'+id).find('td:last');
                                       
                                          if (emptyObject(document.getElementById('desc_'+id))){                                      
                                            $('#'+id).find('td').attr('style','border-bottom:0px;');
                                            $('#'+id).after('<tr id="desc_'+id+'" class="ui-widget-content jqgrow ui-row-ltr"><td colspan="10" align="center"><span style="width:100%">'+$(last).attr('title')+'</span></td></tr>');  
                                            last.remove();

                                        }    
                                    }
                            function emptyObject(obj) {
                                    for (var i in obj) {
                                        return false;
                                    }
                                    return true;
                                }

                            $('a.description').live('mouseout',function(){
                                $('#infor').hide();
                                $('#tpointer').hide();
                            })
                            $('a.description').live('mouseover',function(){
                var id_temp = $(this).attr('value');
                                var temp=$(this).offset();
                                var t=$(document).height()-(temp.top+133);
                                $.get(getUrl(id_temp), function(data){ 
                                                $('#infor').show(); 
                                                $('#infor').css({'bottom':t+'px','left':temp.left-50+'px'});                             
                                                $('#infor').html('<div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-top:-5px;" onclick="$(\'#infor\').hide();$(\'#tpointer\').hide();">X</div>'+data);
                                  
                                                setTimeout(function(){if (($('#height_content').height())>($('#infor').height())){ 
                                                 $('#infor').append('<a style="cursor:pointer;font-size: 11px;color: gray;right:5px;top: 80px;position:absolute;" onClick="showMore('+id_temp+');" href="javascript:;">...</a>');}},400);
                                                $('#infor').addClass('events_info_block');
                            $('#tpointer').css({'bottom':t-16+'px','left':temp.left}); 
                                                $('#tpointer').show();  
                                            });

                            })
                           
                            </script>
                            {/literal}
                        </div>
                            <div style="z-index:100500;position:absolute;bottom: 795px;right: 430px;">

                         <div class="events_info_block" id="option" style="display:none;position:absolute;cursor:pointer;font-size: 15px;width:180px;">
                                    <div style="position:relative;float:right;cursor:pointer;font-size: 15px;color: gray;top:5px;right:5px" onclick="$('#option2').click();">X</div>

                                    <form method="POST">
                                        <span class="check_exel">
                                            <input class="type_select" name="name" type="checkbox"  style="width:10px;"  id="hide_title" value="checked" {$datas.name}>
                                            <label  for="hide_title" >Компания</label></span><br>

                                        <span class="check_exel">
                                            <input class="type_select" name="inn" type="checkbox"  style="width:10px;"  id="hide_inn" value="checked" {$datas.inn}>
                                            <label  for="hide_inn" >ИНН/ЕДРПОУ компании</label></span><br>

                                        <span class="check_exel">
                                            <input class="type_select" type="checkbox" name="region"  style="width:10px;"  id="hide_region" value="checked" {$datas.region}>
                                            <label  for="hide_region" >Регион компании</label></span><br>

                                        <span class="check_exel">
                                            <input class="type_select" type="checkbox"  name="country" style="width:10px;"  id="hide_country" value="checked" {$datas.country}>
                                            <label  for="hide_country" >Странa компании</label></span><br>

                                        <span class="check_exel">
                                            <input class="type_select" type="checkbox" name="date_event" style="width:10px;"  id="hide_date" value="checked" {$datas.date_event}>
                                            <label  for="hide_date" >Датa события</label></span><br>

                                        <span class="check_exel">
                                            <input class="type_select" type="checkbox" name="event" style="width:10px;"  id="hide_event" value="checked" {$datas.event}>
                                            <label  for="hide_event" >Тип события</label></span><br>

                                        <span class="check_exel">
                                            <input class="type_select" type="checkbox" name="date_monitoring"  style="width:10px;"  id="hide_m" value="checked" {$datas.date_monitoring}>
                                            <label  for="hide_m" >Дата мониторинга</label></span><br>

                                        <span class="check_exel">
                                            <input class="type_select" type="checkbox" name="tarif"  style="width:10px;"  id="hide_t" value="checked" {$datas.tarif}>
                                            <label  for="hide_t" >Услуга</label></span><br>

                                        <span class="check_exel">
                                            <input class="type_select" name="desc" type="checkbox"  style="width:10px;"  id="hide_desk" value="checked" {$datas.desc}>
                                            <label  for="hide_desk" >Описание события</label></span><br>

                                        <div id="hid_info"  style="display:none">
                                            <span class="radio_style">
                                                <input type='radio'  checked="checked" name='inform' value='1' class="inform" id="short" onChange="$('#short_radio').attr('checked','checked');doSearch(arguments[0]||event) ; jQuery('#bigset').jqGrid('showCol','content');"
                                                       ><label color="#1F5763" style="font-size: 10px;background-size: 10px 10px;padding-left: 15px;" for="short" >Кратко</label></span>

                                            <span class="radio_style">
                                                <input type='radio' name='inform' value='0' class="inform" id="full" onChange="$('#full_radio').attr('checked','checked');insertRow();"
                                                       ><label color="#1F5763" style="font-size: 10px;background-size: 10px 10px;padding-left: 15px;" for="full">Подробно</label></span> 

                                        </div>
                                        <div>
                                            <span class="radio_style">
                                                <input type='radio' {if ($datas.window=='standart')}  checked="checked" {/if} name='window' value='standart' class="inform" onClick="javascript:how_window='standart';" id="window_stand"> 
                                                       <label color="#1F5763" style="font-size: 10px;background-size: 10px 10px;padding-left: 15px;" for="window_stand">Стандартное окно</label></span>

                                            <span class="radio_style">
                                                <input type='radio' {if ($datas.window=='new')}  checked="checked" {/if} name='window' value='new' class="inform" onClick="javascript:how_window='new';" id="window_new" >
                                                       <label color="#1F5763" style="font-size: 10px;background-size: 10px 10px;padding-left: 15px;" for="window_new">Отдельное окно</label></span> 

                                        </div>
                                        <div>
                                            <span class="radio_style">
                                                <input type='radio' {if ($datas.click=='click')}  checked="checked" {/if} name='click' value='click' class="inform" id="click_simpl" onClick="javascript:how_click='click';">
                                                       <label color="#1F5763" style="font-size: 10px;background-size: 10px 10px;padding-left: 15px;" for="click_simpl" >По-клику</label></span>

                                            <span class="radio_style">
                                                <input type='radio' {if ($datas.click=='dblclick')}  checked="checked" {/if} name='click' value='dblclick' class="inform" id="click_dbl" onClick="javascript:how_click='dblclick';">
                                                       <label color="#1F5763"  style="font-size: 10px;background-size: 10px 10px;padding-left: 15px;" for="click_dbl">Двойному клику</label></span> 

                                        </div>
                                        <input type="button" name="save_setting" value="Сохранить" class="file_input_button">
                                    </form>
                                    <script type="text/javascript">
                                            {literal}
                                            if ($("#hide_desk").attr("checked")=="checked"){
                                                $("#hid_info").show();
            
                                            } else {
                
                                                $("#hid_info").hide();
                                            }
                                            $("#hide_desk").live('click', function(){
                                                if ($("#show_desk").attr("checked")=="checked"){
                                                    $("#hid_info").show();
                                                } else {
                                                    $("#hid_info").hide();
                                                }});

                                            $("#show_desk").live('click', function(){
                                                if ($("#hide_desk").attr("checked")=="checked"){
                                                    $("#hid_info").show();
                                                } else {
                                                    $("#hid_info").show();
                                                }});

                                             $('input[name=save_setting]').live('click',function(){
                                var dataSetting=new Array();
                               if($('input[name=name]').is(':checked')) {
                                    dataSetting['name'] = $('input[name=name]').val();
                               }else{
                                    dataSetting['name'] = '';
                               }
                               if($('input[name=inn]').is(':checked')) {
                                    dataSetting['inn'] = $('input[name=inn]').val();
                               }else{
                                    dataSetting['inn'] = '';
                               }
                               if($('input[name=region]').is(':checked')) {
                                    dataSetting['region'] = $('input[name=region]').val();
                               }else{
                                    dataSetting['region'] = '';
                               }
                               if($('input[name=country]').is(':checked')) {
                                    dataSetting['country'] = $('input[name=country]').val();
                               }else{
                                    dataSetting['country'] = '';
                               }
                               if($('input[name=date_event]').is(':checked')) {
                                    dataSetting['date_event'] = $('input[name=date_event]').val();
                               }else{
                                    dataSetting['date_event'] = '';
                               }
                               if($('input[name=event]').is(':checked')) {
                                    dataSetting['event'] = $('input[name=event]').val();
                               }else{
                                    dataSetting['event'] = '';
                               }
                               if($('input[name=date_monitoring]').is(':checked')) {
                                    dataSetting['date_monitoring'] = $('input[name=date_monitoring]').val();
                               }else{
                                    dataSetting['date_monitoring'] = '';
                               }
                               if($('input[name=tarif]').is(':checked')) {
                                    dataSetting['tarif'] = $('input[name=tarif]').val();
                               }else{
                                    dataSetting['tarif'] = '';
                               }
                               if($('input[name=desc]').is(':checked')) {
                                    dataSetting['desc'] = $('input[name=desc]').val();
                               }else{
                                    dataSetting['desc'] = '';
                               }
                                 $('input[name=window]').each(function(){
                                    if($(this).is(':checked')) {
                                         dataSetting['window'] = $(this).val();
                                    } 
                                });
                                $('input[name=click]').each(function(){
                                    if($(this).is(':checked')) {
                                         dataSetting['click'] = $(this).val();
                                    } 
                                });
                                $('input[name=inform]').each(function(){
                                    if($(this).is(':checked')) {
                                         dataSetting['inform'] = $(this).val();
                                    } 
                                });

                                dataSetting['save_setting'] = '1';
                               $.post("/monitoring/events",
                                {   'name' : dataSetting['name'],
                                    'inn' : dataSetting['inn'],
                                    'region' : dataSetting['region'],
                                    'country' : dataSetting['country'],
                                    'date_event' : dataSetting['date_event'],
                                    'event' : dataSetting['event'],
                                    'date_monitoring' : dataSetting['date_monitoring'],
                                    'tarif' : dataSetting['tarif'],
                                    'desc' : dataSetting['desc'],
                                    'inform' : dataSetting['inform'],
                                    'save_setting' : dataSetting['save_setting'],
                                    'window' : dataSetting['window'],
                                    'click' : dataSetting['click'],
                                },function(data){
                                    alert('Настройки сохранены');
                                    $('#option').hide();
                                    $('#option2').hide(); 
                                    $('#option1').show();
                               });                           
                             })

                                            {/literal}
                                    </script> 
                                </div> 
                            </div>
                        
                            <div  id="infor" style="position: absolute; z-index: 10000; overflow:hidden; max-height:95px; left: 450px; display: none;" class="events_info_block"> </div>
                            <br>
                            <div id="description" style="display:none; position:absolute; width:470px;">
                                <div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-right: -2px;" onclick="$('#description').hide();" id='hide_info'>X</div>
                                <div id='conteiner_info'></div>
                            </div>
                               
                        <br>
                        <span id="give_csv" style="margin-top:10px; margin-left:10px; position:relative">
                            <span class="check_exel"> <input type="checkbox"  id="sel_all" onClick="if($(this).is(':checked')){$('#cb_bigset').attr('checked','checked');$('.cbox').attr('checked','checked');}else{$('#cb_bigset').removeAttr('checked');$('.cbox').removeAttr('checked');}"> <label for="sel_all"></lable></span>
                            <a style="color:#808080; " href="javascript:void(0)" >Экспорт выбранного в .csv</a> 
                        </span>
                        <br>    
                        </div>
                        <div id="event_types">
                            <span onClick="change_events()" > <img src="/images/drill_right.jpg"/> </span>
                            <a href="javascript:void(0)" onClick="change_events()" style="font-size: 12px;">  События в мониторинге</a> 
                            &nbsp;Все cтраны <span style="color:1f5863;">({$user->getTotalEventCount()})</span> 
                            /<img src="/images/258.gif"> Россия({if $eventsdata.0.RU_ev_all<>''}{$eventsdata.0.RU_ev_all}{/if}{if $eventsdata.0.RU_ev_all==''}0{/if}) 
                            /<img src="/images/252.gif"> Украина({if $eventsdata.0.UA_ev_all<>''}{$eventsdata.0.UA_ev_all}{/if}{if $eventsdata.0.UA_ev_all==''}0{/if}) 
                        </div>

                        <div style="display:none" id="full_event_types">

                            {foreach from=$ttList item=et}

                            <div id="type_eve_{$et->id}" style="cursor:pointer;" onClick="{foreach from=$user->getEventId($et->id) key=myId item=i}
                                    if(!$('#{$i.id}').attr('aria-selected'))($('#{$i.id}').attr('aria-selected','true').attr('class','ui-widget-content jqgrow ui-row-ltr ui-state-highlight'));
                                    else($('#{$i.id}').removeAttr('aria-selected').attr('class','ui-widget-content jqgrow ui-row-ltr'));
                                    {/foreach}">
                                <span  style="width:20px; height:20px;background-color:{$et->getColor()}">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<b style="color:{$et->getColor()}">{$et->title|escape}(<span style="color:{$et->getColor()}"  id="bottom_type_{$et->id}">{$user->getEventCount($et->id)}</span>)
                                </b> - {$et->description|escape} <span id='tarifs'><span class="btn_tarif" val="{$user->getActualTarifInfo()->id}" 
                                                                                         val2="{$user->getTarifId($user->getActualTarifInfo()->id)}">{$user->getCountMon() }-{$user->getTarifInfo()->m}-{$user->getActualTarifInfo()->period/7}
                                    </span> </span>
                            </div>
                            {/foreach}
                        </div>

                    </div>

                </div>

                <div class="dotted2">
                </div>
            </div>
        </div>
    </div></div>

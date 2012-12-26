      {literal}<script type="text/javascript">
    // // $('.btn_tarif').mouseout(function (){
    // //             $('#description').hide();
    // // });
    // $('.btn_tarif').mouseover(function (kmouse){
    //         id = $(this).attr('val2');
    //         base_h = kmouse.pageY +2050;
    //         base_w = kmouse.pageX -150;
    //         var id_el = '#description';
    //             $.get('/monitoring/tarifinfo', {tarif_id : $(this).attr('val')}, function(data){
    //                 $('#conteiner_info').html(data);
    //             });
    //             $(id_el).addClass('events_info_block');
    //             $(id_el).css('top', base_h).css('left', base_w);
    //             $(id_el).show();  
    //             $(id_el).attr('display','block');      
    //     });     
    </script>
      {/literal}
<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

<div>
    <div class="main_top_text">

        {breadcrumb controller="monitoring" alias="monitoring" altTitle="Мониторинг"}
        {include file="lmenu.tpl"}
        
            

        {literal}
        <link href="/scripts/wdCalendar/css/dailog.css" rel="stylesheet" type="text/css" />
        <link href="/scripts/wdCalendar/css/calendar.css" rel="stylesheet" type="text/css" />
        <link href="/scripts/wdCalendar/css/dp.css" rel="stylesheet" type="text/css" />
        <link href="/scripts/wdCalendar/css/alert.css" rel="stylesheet" type="text/css" />
        <link href="/scripts/wdCalendar/css/main.css" rel="stylesheet" type="text/css" />
{/literal}
           <script type="text/javascript">
//                         $('tr[role="row"]').live('click', function(){
//                             $('#infor').hide();
//                         });
                        
//                         $('tr[role="row"]').live('dblclick', function(){
//                             /* //alert('dfghjk');
//                             $('#info').show();
//                             $('#info').offset({top:$(this).offset().top - 20});
//                             return false;*/
//                             //$(this).child('a').click();
//                             base_h = $(this).offset().top - 20;
//                             //alert("/monitoring/eventinfo/event_id/"+$(this).attr('value')+"/");
//                             $.get("/monitoring/eventinfo/event_id/"+$(this).attr('id')+"/", function(data){
//                                     //alert("Data Loaded: " + data);
//                                     $('#infor').show();
//                                     $('#infor').html('<div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-top: -5px;" onclick="$(\'#infor\').hide();">X</div>'+data);
//                                     $('#infor').offset({top:base_h - $('#info').outerHeight()});
//                                     $('#infor').addClass('events_info_block');
//                                 }
//                             );
//                         });  
{literal} 
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
            {/literal}{/foreach}
            }
       } 
</script>{literal}
        <script src="/scripts/wdCalendar/src/jquery.js" type="text/javascript"></script>

        <script src="/scripts/wdCalendar/src/Plugins/Common.js" type="text/javascript"></script>
        <script src="/scripts/wdCalendar/src/Plugins/datepicker_lang_RU.js" type="text/javascript"></script>
        <script src="/scripts/wdCalendar/src/Plugins/jquery.datepicker.js" type="text/javascript"></script>

        <script src="/scripts/wdCalendar/src/Plugins/jquery.alert.js" type="text/javascript"></script>
        <script src="/scripts/wdCalendar/src/Plugins/jquery.ifrmdailog.js" defer="defer" type="text/javascript"></script>
        <script src="/scripts/wdCalendar/src/Plugins/wdCalendar_lang_RU.js" type="text/javascript"></script>
        <script src="/scripts/wdCalendar/src/Plugins/jquery.calendar.js" type="text/javascript"></script>

        <script type="text/javascript">

    $('div.rb-i').live('mouseout',function(){
       setTimeout( function (){  $('.events_info_block').hide();},100);
    });
    $('div.rb-i').mouseover(function(kmouse){
        var temp = $(this).attr('name');   
        base_h = kmouse.pageY-270;
        base_w = kmouse.pageX-160;
        $.get("/monitoring/eventinfo/event_id/"+temp+"/", function(data){
                 $('#infor').show();
                 $('#infor').css('height','95px').css('overflow','hidden');
                 $('#infor').html('<div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-top: -5px;" onclick="$(\'#infor\').hide();">X</div>'+data);
                $('#infor').css('top',base_h).css('left',base_w);
                setTimeout(function(){if (($('#height_content').height())>($('#infor').height())){  $('#infor').append('<a style="cursor:pointer;font-size: 11px;color: gray;right:5px;top: 80px;position:absolute;" onClick="$(this).hide();$(\'#infor\').attr(\'style\',\'position: absolute; z-index: 10000; left: 450px; top: 350px;\')" href="javascript:;">...</a>');}},200);
                $('#infor').addClass('events_info_block');
                                    }
                                ); 
    })
         // function ShowEveInfo(temp){
         //                    // console.log($('.rb-m').attr('name'));
         //                    // console.log("фівфві");
         //                    /* //alert('dfghjk');
         //                    $('#info').show();
         //                    $('#info').offset({top:$(this).offset().top - 20});
         //                    return false;*/
         //                    //$(this).child('a').click();
         //                     // base_h = $(this).offset().top-100;
         //                     // base_w = $(this).offset().left;
         //                    //alert("/monitoring/eventinfo/event_id/"+$(this).attr('value')+"/");
         //                    $.get("/monitoring/eventinfo/event_id/"+temp+"/", function(data){
         //                            //alert("Data Loaded: " + data);
         //                            $('#infor').show();
         //                            $('#infor').html('<div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-top: -5px;" onclick="$(\'#infor\').hide();">X</div>'+data);
         //                            //$('#infor').css('top',base_h).css('left',base_w);
         //                            $('#infor').addClass('events_info_block');
         //                        }
         //                    );
         //                }               

        // function showevents(){

        //     console.log($('.rb-i'));
        // }
        function dataEvets(){
        // if($('.st-c').attr('name')){
        //    console.log('hfc'); 
        // }
        var temp = "";
        $('.st-grid tr td').each(function(){
            if (typeof $(this).attr("name") != 'undefined'){
           //    console.log($(this).find('.rb-m').attr('name'));
           temp+='<td class="calendar_event" id="eve_'+$(this).find('.rb-m').attr('name')+'">'
           +$(this).find('.rb-m').attr('name')+'</td>';          
            }
            $('.tg-timedevents tr').html(temp);

           
        });            
            $('.st-grid tr td').each(function(){            
            if (typeof $(this).attr("name") != 'undefined'){                  
                            var temp1=$(this).find('.rb-m').attr('name');
                            $.get("/monitoring/eventinfo/event_id/"+temp1+"/", function(data){
                                   // $('#eve_'+$(this).find('.rb-m').attr('name')).html(data);
                                   //   console.log (data);
                                  $('.tg-timedevents tr td#eve_'+temp1).html(data);    
                                }
                            );
        }});

    }
        // $(".rb-o").live("click", function(event){

        //     console.log($(this));
        // });

            $(document).ready(function() {


            $('.btn_tarif').mouseout(function (){
                    $('#description').hide();
                 });
            $('.btn_tarif').mouseover(function (kmouse){
                id = $(this).attr('val2');
                base_h = kmouse.pageY - 380;
                base_w = kmouse.pageX - 220;
                var id_el = '#description';
                    $.get('/monitoring/tarifinfo', {tarif_id : $(this).attr('val')}, function(data){
                        $('#conteiner_info').html(data);
                    });
                    $(id_el).addClass('events_info_block');
                    $(id_el).css('top', base_h).css('left', base_w);
                    $(id_el).show();        
                  });     



               var view="week";

                var DATA_FEED_URL = "/monitoring/datafeed/";
                var op = {
                    view: view,
                    theme:3,
                    showday: new Date(),
                    //EditCmdhandler:function(){},//Edit,
                    //DeleteCmdhandler:Delete,
                    ViewCmdhandler:View,
                    onWeekOrMonthToDay:wtd,
                    onBeforeRequestData: cal_beforerequest,
                    onAfterRequestData: cal_afterrequest,
                    onRequestDataError: cal_onerror,
                    autoload:true,
                    url: DATA_FEED_URL + "?method=list",
                    extParam : []
                    //quickAddUrl: DATA_FEED_URL + "?method=add",
                    //quickUpdateUrl: DATA_FEED_URL + "?method=update",
                    //quickDeleteUrl: DATA_FEED_URL + "?method=remove"
                };
                
                var $dv = $("#calhead");
                var _MH = 500;document.documentElement.clientHeight;
                var dvH = $dv.height() -65;
                op.height = _MH - dvH;
                op.eventItems =[];

                var p = $("#gridcontainer").bcalendar(op).BcalGetOp();
                if (p && p.datestrshow) {

                    $("#txtdatetimeshow").text(p.datestrshow);
                }
               
                $("#caltoolbar").noSelect();

                $("#hdtxtshow").datepicker({ picker: "#txtdatetimeshow", showtarget: $("#txtdatetimeshow"),
                onReturn:function(r){
                                var p = $("#gridcontainer").gotoDate(r).BcalGetOp();
                                if (p && p.datestrshow) {
                                    $("#txtdatetimeshow").text(p.datestrshow);
                                }
                         }
                });
                function cal_beforerequest(type)
                {
                    var t="Загрузка...";
                    switch(type)
                    {
                        case 1:
                            t="Загрузка...";
                            break;
                        case 2:
                        case 3:
                        case 4:
                            t="Загрузка...";
                            break;
                    }
                    $("#errorpannel").hide();
                    $("#loadingpannel").html(t).show();
                }
                function cal_afterrequest(type)
                {
                    switch(type)
                    {
                        case 1:
                            $("#loadingpannel").hide();
                            break;
                        case 2:
                        case 3:
                        case 4:
                            $("#loadingpannel").html("Готово!");
                            window.setTimeout(function(){ $("#loadingpannel").hide();},2000);
                        break;
                    }

                }
                function cal_onerror(type,data)
                {
                    $("#errorpannel").show();
                }
                //function Edit(data)
                //{
                //   var eurl="edit.php?id={0}&start={2}&end={3}&isallday={4}&title={1}";
                //    if(data)
                //    {
                //        var url = StrFormat(eurl,data);
                //        OpenModelWindow(url,{ width: 600, height: 400, caption:"Manage  The Calendar",onclose:function(){
                ///           $("#gridcontainer").reload();
                //        }});
                //    }
                //}
                function View(data)
                {
                    //document.location = '/monitoring/event/'+data[0]+'/';
                    
                    return;
                    //var str = "";
                    //$.each(data, function(i, item){
                    //    str += "[" + i + "]: " + item + "\n";
                    //});
                    //alert(str);
                }
                //function Delete(data,callback)
                //{
                //
                //    $.alerts.okButton="Ok";
                //    $.alerts.cancelButton="Cancel";
                //    hiConfirm("Are You Sure to Delete this Event", 'Confirm',function(r){ r && callback(0);});
                //}
                function wtd(p)
                {
                   if (p && p.datestrshow) {
                        $("#txtdatetimeshow").text(p.datestrshow);
                    }
                    $("#caltoolbar div.fcurrent").each(function() {
                        $(this).removeClass("fcurrent");
                    })
                    $("#showdaybtn").addClass("fcurrent");
                }
                //to show day view
                $("#showdaybtn").click(function(e) {
                    //document.location.href="#day";
                    $("#caltoolbar div.fcurrent").each(function() {
                        $(this).removeClass("fcurrent");
                    })
                    $(this).addClass("fcurrent");
                    var p = $("#gridcontainer").swtichView("day").BcalGetOp();
                    if (p && p.datestrshow) {
                        $("#txtdatetimeshow").text(p.datestrshow);
                    }
                     dataEvets()
                });
                //to show week view
                $("#showweekbtn").click(function(e) {
                    //document.location.href="#week";
                    $("#caltoolbar div.fcurrent").each(function() {
                        $(this).removeClass("fcurrent");
                    })
                    $(this).addClass("fcurrent");
                    var p = $("#gridcontainer").swtichView("week").BcalGetOp();
                    if (p && p.datestrshow) {
                        $("#txtdatetimeshow").text(p.datestrshow);
                    }

                    dataEvets();
                  
                });
                //to show month view
                $("#showmonthbtn").click(function(e) {
                    //document.location.href="#month";
                    $("#caltoolbar div.fcurrent").each(function() {
                        $(this).removeClass("fcurrent");
                    })
                    $(this).addClass("fcurrent");
                    var p = $("#gridcontainer").swtichView("month").BcalGetOp();
                    if (p && p.datestrshow) {
                        $("#txtdatetimeshow").text(p.datestrshow);
                    }
                });

                $("#showreflashbtn").click(function(e){
                    $("#gridcontainer").reload();
                });

                //Add a new event
                //$("#faddbtn").click(function(e) {
                //    var url ="edit.php";
                //    OpenModelWindow(url,{ width: 500, height: 400, caption: "Create New Calendar"});
                //});
                //go to today
                $("#showtodaybtn").click(function(e) {
                    var p = $("#gridcontainer").gotoDate().BcalGetOp();
                    if (p && p.datestrshow) {
                        $("#txtdatetimeshow").text(p.datestrshow);
                    }


                });
                //previous date range
                $("#sfprevbtn").click(function(e) {
                    var p = $("#gridcontainer").previousRange().BcalGetOp();
                    if (p && p.datestrshow) {
                        $("#txtdatetimeshow").text(p.datestrshow);
                    }
                    dataEvets();
                });
                //next date range
                $("#sfnextbtn").click(function(e) {
                    var p = $("#gridcontainer").nextRange().BcalGetOp();
                    if (p && p.datestrshow) {
                        $("#txtdatetimeshow").text(p.datestrshow);
                    }
                    dataEvets();
                });
                 $("#showmonthbtn").click();
                var p = $("#gridcontainer").nextRange().BcalGetOp();
                $("#txtdatetimeshow").text(p.datestrshow);
                $("#gridcontainer").gotoDate(new Date());
                /*setTimeout(function(){
                    $("#gridcontainer").reload();
                }, 500);*/
                doSearch();
        
            });
                function doSearch(){
                     // console.log($('select#search_region option:selected').val());
               // $("#gridcontainer").reload();
             //  $("#gridcontainer").extParam = [{name:"param1", value:"value1"}, {name:"param2", value:"value2"}];
              //  $("#gridcontainer").BcalSetOp({extParam : [{name:"param6", value:$('#search_event_type_6').attr('checked')},{name:"param5", value:$('#search_event_type_5').attr('checked')},{name:"param4", value:$('#search_event_type_4').attr('checked')}]});
                $("#gridcontainer").BcalSetOp({extParam : [
                    {/literal}{foreach from=$ttList item=et}{literal}
                    {name:"param{/literal}[{$et->id}]", value:$('#search_event_type_{$et->id}').attr('checked'){literal}},
                    {/literal}{/foreach}{literal}                   
                    {name:"filter_new", value:$('#filter_new').attr('checked')},
                    {name:"country", value:$('input[name=country]:checked').val()},
                    {name:"country_search", value:$('select#search_country option:selected').val()},
                    {name:"region_mask", value:$('select#search_region option:selected').val()},
                    {name:"fav_ev", value:$('#fav_ev').attr('checked')},
                     {name:"fav_com", value:$('#fav_com').attr('checked')}
                    //var fav_com = jQuery("#fav_com").attr("checked");
                    ]
                });
                setTimeout(function(){
                    $("#gridcontainer").reload();
                }, 200);
            }
            //doSearch();
        </script>
        {/literal}
         <div  id="infor" style="position: absolute;  z-index: 10000; display: none;" class="events_info_block">
               
            </div>
             <span class="radio_style">
        <input type='radio' name='country' value='all' id="all_countries" onClick="$('#search_country').val('');$('#search_innnaim').attr('placeholder','Наименование/(ИНН/ЕДРПОУ)');$('#search_inn').attr('placeholder','ИНН/ЕДРПОУ');$('#search_country').removeAttr('disabled'); 
        {foreach from=$ttList item=et }$('#type_event_'+{$et->id}).removeAttr('style');$('#search_event_type_'+{$et->id}).attr('checked','checked');{/foreach};
            {if $user->getTotalEventCount()==''}$('#bottom_type_all').html('0');{/if}            
                {foreach from=$ttList item=et}
                    $('#bottom_type_'+{$et->id}).html({$user->getEventCount($et->id)});                  
                   {if $user->getEventCount($et->id)<>''}$('#type_eve_'+{$et->id}).removeAttr('style').attr('style','cursor:pointer'); {/if}
                {/foreach}
            {if $user->getTotalEventCount()<>''}$('#bottom_type_all').html({$user->getTotalEventCount()});{/if}
        doSearch(arguments[0]||event)" checked><label color="#1F5763" for="all_countries">Все</label></span>

        <span class="radio_style">            
        <input type='radio' name='country' value='RU' id="country_ru" onClick="        
        $('#search_country').val('RU');$('#search_innnaim').attr('placeholder','Наименование/ИНН');$('#search_inn').attr('placeholder','ИНН');$('#search_country').attr('disabled','disabled');
            {foreach from=$ttList item=et }
            $('#type_event_'+{$et->id}).attr('style','display:none');$('#search_event_type_'+{$et->id}).removeAttr('checked');{/foreach};
        {foreach from=$eveCountry item=et1}{if $et1.id_country==258}$('#search_event_type_'+{$et1.id_type}).attr('checked','checked');$('#type_event_'+{$et1.id_type}).removeAttr('style');{/if}{/foreach}
            {foreach from=$eventsdata key=k item=et1}$('#bottom_type_'+{$k}).html({$et1.RU});{if $et1.RU==0}$('#type_eve_'+{$k}).attr('style','display:none');{/if}{if $et1.RU<>0}$('#type_eve_'+{$k}).removeAttr('style').attr('style','cursor:pointer');{/if}{if $et1.RU_ev_all==''}$('#bottom_type_all').html('0');{/if}{if $et1.RU_ev_all<>''}$('#bottom_type_all').html({$et1.RU_ev_all});{/if}{/foreach};
        doSearch(arguments[0]||event);"><label color="#1F5763" for="country_ru">Россия <img src="/images/258.gif"></label></span>

         <span class="radio_style">
        <input type='radio' name='country' value='UA' id="country_ua" onClick="$('#search_country').val('UA');$('#search_innnaim').attr('placeholder','Наименование/ЕДРПОУ');$('#search_inn').attr('placeholder','ЕДРПОУ');$('#search_country').attr('disabled','disabled');
            {foreach from=$ttList item=et }$('#type_event_'+{$et->id}).attr('style','display:none');$('#search_event_type_'+{$et->id}).removeAttr('checked');
            {/foreach};
        {foreach from=$eveCountry item=et1}{if $et1.id_country==252}$('#search_event_type_'+{$et1.id_type}).attr('checked','checked');$('#type_event_'+{$et1.id_type}).removeAttr('style');{/if}{/foreach}
            {foreach from=$eventsdata key=k item=et1}$('#bottom_type_'+{$k}).html({$et1.UA});{if $et1.UA==0}$('#type_eve_'+{$k}).attr('style','display:none');{/if}{if $et1.UA<>0}$('#type_eve_'+{$k}).removeAttr('style').attr('style','cursor:pointer');{/if}{if $et1.UA_ev_all==''}$('#bottom_type_all').html('0');{/if}{if $et1.UA_ev_all<>''}$('#bottom_type_all').html({$et1.UA_ev_all});{/if}{/foreach};
        doSearch(arguments[0]||event);"><label color="#1F5763" for="country_ua">Украина <img src="/images/252.gif"></label></span><br>
        <span class="check_exel">
            <input id="fav_ev" type="checkbox" onchange="doSearch(arguments[0]||event)" name="fav_ev">
            <label for="fav_ev" color="#1F5763">Избранные события </label>
        </span>
                <span class="check_exel">
            <input id="fav_com" type="checkbox" onchange="doSearch(arguments[0]||event)" name="fav_ev">
            <label for="fav_com" color="#1F5763">омеченые компании </label>
        </span>
          <table cellspacing="0" cellpadding="5">
             <tr>
                <td>
                    <div class="style-select" style="width: 200px;">
                            <select style="width:240px;" placeholder="Регион" class="searchFLD" id="search_region" onChange="doSearch(arguments[0]||event)"><optgroup><option value="" selected>
                                Регион</option>
                                {foreach from = $rList item=ritem}
                                 <option value="{$ritem.region}">{$ritem.region}</option>
                                {/foreach}</optgroup>
                            </select>
                        </div>
                </td>
                <td>       
                    <div class="style-select" style="width: 100px;">
                            <select style="width:130px;" placeholder="Страна" class="searchFLD" id="search_country" onChange="doSearch(arguments[0]||event)">
                                <optgroup>
                                    <option value="" selected>Страна</option>
                                    <option value="RU">Россия</option>
                                    <option value="UA">Украина</option>
                                </optgroup></select>
                    </div>
                </td></tr></table>
            <br>
           <span id="info_date_mon"> Дата последнего мониторинга/события: {$lastMonitoringDate}/<a  href="/monitoring/event/{$lastEvent->id}/" style="color:#da114b;{if !$lastEvent->isViewed()} font-weight:bold;{/if}">{$lastEvent->getEventDateFormatted()} ({$lastEvent->getType()->title})</a> </span>
             Количество событий (всего/новых):
            
                <font color="#dba108">
               {$user->getTotalEventCount()} /{if $lastEvent->id}
                    {if $user->getLastEventCount() > 0}<b>{/if}{$user->getLastEventCount()}{if $user->getLastEventCount() > 0}</b>{/if}
                {else}
                    0
                    {/if}
                </font>
           <table><tr>                      
            <td valign="middle" >
                {foreach from=$ttList item=et}
                    <span class="check_exel" id="type_event_{$et->id}" onclick="StyleLabel({$et->id})">
                         <input onclick="javascript:doSearch();" type="checkbox" checked="1" class="searchFLD" id="search_event_type_{$et->id}" value="{$et->id}" />
                         <label for="search_event_type_{$et->id}" onclick="StyleLabel({$et->id})">
                         <b id="event_label_{$et->id}" onclick="StyleLabel({$et->id})" style="background-color:{$et->getColor()}; color:#fff;padding:2px">{$et->title|escape}</b>
                         </label>  
                    </span>                              
                 {/foreach}
                              
                            </td>
                        </tr>
                    </table>
        

        <div>


            <div id="calhead" style="padding-left:1px;padding-right:1px;">
                <div class="cHead"><!--<div class="ftitle">My Calendar</div>
                    <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">Loading data...</div>
                    <div id="errorpannel" class="ptogtitle loaderror" style="display: none;">Sorry, could not load your data, please try again later</div>-->
                </div>

                <div id="caltoolbar" class="ctoolbar">
                   <!-- <div id="faddbtn" class="fbutton">
                        <div><span title='Click to Create New Event' class="addcal">

                                New Event
                            </span></div>
                    </div>-->
                    <div id="shownewbtn" class="fbutton">
                   
                     <div><span title='New' class="shownewview"> <input onclick="javascript:doSearch();" type="checkbox"  class="searchFLD" id="filter_new" value="1" /> Новое</span></div>
                    </div>

                    <div class="btnseparator"></div>
                    <div id="showtodaybtn" class="fbutton">
                        <div><span title='Click to back to today ' class="showtoday">
                                Cегодня</span></div>
                    </div>
                    <div class="btnseparator"></div>

                    <div id="showdaybtn" class="fbutton">
                        <div><span title='Day' class="showdayview">День</span></div>
                    </div>
                    <div  id="showweekbtn" class="fbutton fcurrent">
                        <div><span title='Week' class="showweekview">Неделя</span></div>
                    </div>
                    <div  id="showmonthbtn" class="fbutton">
                        <div><span title='Month' class="showmonthview">Месяц</span></div>

                    </div>
                    <div class="btnseparator"></div>
                    <div  id="showreflashbtn" class="fbutton">
                        <div><span title='Refresh view' class="showdayflash">Обновить</span></div>
                    </div>
                    <div class="btnseparator"></div>
                    <div id="sfprevbtn" title="Prev"  class="fbutton">
                        <span class="fprev"></span>

                    </div>
                    <div id="sfnextbtn" title="Next" class="fbutton">
                        <span class="fnext"></span>
                    </div>
                    <div class="fshowdatep fbutton">
                        <div>
                            <input type="hidden" name="txtshow" id="hdtxtshow" />
                            <span id="txtdatetimeshow">Загрузка</span>

                        </div>
                    </div>

                    <div class="clear"></div>
                </div>
            </div>
            
            <div style="padding:1px;">

                <div class="t1 chromeColor">
                    &nbsp;</div>
                <div class="t2 chromeColor">
                    &nbsp;</div>
                <div id="dvCalMain" class="calmain printborder">
                    <div id="gridcontainer" style="overflow-y: visible;">
                    </div>
                </div>
                <div class="t2 chromeColor">

                    &nbsp;</div>
                <div class="t1 chromeColor">
                    &nbsp;
                </div>
            </div>




            </td>
           <!-- <br>
            Количество событий (всего/новых):
            
                <font color="#da114b">
               {$user->getTotalEventCount()} /{if $lastEvent->id}
                    {if $user->getLastEventCount() > 0}<b>{/if}{$user->getLastEventCount()}{if $user->getLastEventCount() > 0}</b>{/if}
                {else}
                    0
                    {/if}
                </font>-->
           
            <br>
            
			 <div id="event_types">
                <span onClick="change_events()" > <img src="/images/drill_right.jpg"/> </span>
                <a href="javascript:void(0)" onClick="change_events()">  События в мониторинге</a> 
                 &nbsp; Все cтраны <span style="color:1f5863;">({$user->getTotalEventCount()})</span> 
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
              </span></span>
			  </div>
                {/foreach}
            </div>

             <div id="description" style="display:none; position:absolute; width:470px;">
                <div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-right: -2px;" onclick="$('#description').hide();" id='hide_info'>X</div>
                <div id='conteiner_info'></div>            
             </div>


        <div class="dotted2"></div>
    </div>
</div></div>

<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

<div>
    <div class="main_top_text">

        {breadcrumb controller="monitoring" alias="monitoring" altTitle="Мониторинг"}
        {include file="lmenu.tpl"}

            <p><strong>Дата последнего события:</strong>

                {if $lastEvent->id}
                    <a href="/monitoring/event/{$lastEvent->id}/"{if !$lastEvent->isViewed()} style="font-weight:bold;"{/if}>{$lastEvent->getEventDateFormatted()} ({$lastEvent->getType()->title})</a>
                {/if}
&nbsp;
                <strong>Дата последнего мониторинга:</strong> {$lastMonitoringDate}
            </p>
           

        {literal}
        <link href="/scripts/wdCalendar/css/dailog.css" rel="stylesheet" type="text/css" />
        <link href="/scripts/wdCalendar/css/calendar.css" rel="stylesheet" type="text/css" />
        <link href="/scripts/wdCalendar/css/dp.css" rel="stylesheet" type="text/css" />
        <link href="/scripts/wdCalendar/css/alert.css" rel="stylesheet" type="text/css" />
        <link href="/scripts/wdCalendar/css/main.css" rel="stylesheet" type="text/css" />


        <script src="/scripts/wdCalendar/src/jquery.js" type="text/javascript"></script>

        <script src="/scripts/wdCalendar/src/Plugins/Common.js" type="text/javascript"></script>
        <script src="/scripts/wdCalendar/src/Plugins/datepicker_lang_RU.js" type="text/javascript"></script>
        <script src="/scripts/wdCalendar/src/Plugins/jquery.datepicker.js" type="text/javascript"></script>

        <script src="/scripts/wdCalendar/src/Plugins/jquery.alert.js" type="text/javascript"></script>
        <script src="/scripts/wdCalendar/src/Plugins/jquery.ifrmdailog.js" defer="defer" type="text/javascript"></script>
        <script src="/scripts/wdCalendar/src/Plugins/wdCalendar_lang_RU.js" type="text/javascript"></script>
        <script src="/scripts/wdCalendar/src/Plugins/jquery.calendar.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(document).ready(function() {
               var view="week";

                var DATA_FEED_URL = "/monitoring/datafeeddemo/";
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
                    url: DATA_FEED_URL + "?method=list"
                    //quickAddUrl: DATA_FEED_URL + "?method=add",
                    //quickUpdateUrl: DATA_FEED_URL + "?method=update",
                    //quickDeleteUrl: DATA_FEED_URL + "?method=remove"
                };
                var $dv = $("#calhead");
                var _MH = 500;document.documentElement.clientHeight;
                var dvH = $dv.height() + 2;
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
                    document.location = '/monitoring/event/'+data[0]+'/';
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

                });
                //next date range
                $("#sfnextbtn").click(function(e) {
                    var p = $("#gridcontainer").nextRange().BcalGetOp();
                    if (p && p.datestrshow) {
                        $("#txtdatetimeshow").text(p.datestrshow);
                    }
                });

            });
        </script>
        {/literal}



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
                            <!--<span id="txtdatetimeshow">Загрузка</span>-->

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
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
                                                ,{name:'delete_ev', index:'delete_ev', align:'left'} 
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
                                            pgtext: false,
                                            pginput:false,     
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
                                    },500);

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
                                            window.open('/monitoring/event/' + id + '', "test", "width=320, height=350, status=no, resizable=no, top=200, left=200");
                                            }     
                                        }
                                    }else{
                                            clicks++;
                                            setTimeout(function(){clicks=0;}, 200);
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
                                                        window.open('/monitoring/event/' + id + '', "test", "width=320, height=350, status=no, resizable=no, top=200, left=200");
                                                    }     
                                            }
                                        }
                                       
                                      }
                                    }
                                    
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
                                        jQuery("#bigset").jqGrid('hideCol','content');

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
                                             jQuery('#bigset').jqGrid('hideCol','content');
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
                            })
                            $('a.description').live('mouseover',function(){
                                var id_temp = $(this).attr('value');
                                var infoHeight=$(this).offset();
                                infoHeight = infoHeight.top-150;
                                $.get(getUrl(id_temp), function(data){ 
                                                $('#infor').show(); 
                                                $('#infor').css('top',infoHeight);                                  
                                                $('#infor').html('<div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-top:-5px;" onclick="$(\'#infor\').hide();">X</div>'+data);
                                  
                                                setTimeout(function(){if (($('#height_content').height())>($('#infor').height())){ 
                                                 $('#infor').append('<a style="cursor:pointer;font-size: 11px;color: gray;right:5px;top: 80px;position:absolute;" onClick="showMore('+id_temp+');" href="javascript:;">...</a>');}},200);
                                                $('#infor').addClass('events_info_block');
                                            });

                            })
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
                                },function(data){
                                    alert('Настройки сохранены');
                                    $('#option').hide();
                                    $('#option2').hide(); 
                                    $('#option1').show();
                               });                           
                             })
                            </script>
                            {/literal}
                        </div>                       
  <table id="bigset"></table>
            {literal}
            <script type="text/javascript">

    setTimeout(function(){
            jQuery("#bigset").jqGrid({
                url:'/monitoring/eventscompanydata',
                datatype: "json",
                height: 100+'%',
                width: 700,
                hoverrows: false,
                colNames:['','Наименование','ИНН/ЕДРПОУ','Регион','Страна','Cобытий','Адрес',
                'Фио директора','Дата регистрации','Отрасль','Последнее события', 'Действия'],
                colModel :[
                         {name:'favoritesCompany', index:'favoritesCompany', align:'center', sortable:false,width:40}
                        ,{name:'title', index:'title',width:200, align:'center'}
                        ,{name:'inn', index:'inn', align:'center'}
                        ,{name:'region', index:'region', align:'center'}
                        ,{name:'country', index:'country', align:'center'}
                        ,{name:'event', index:'event', align:'center', sortable:false} 
                        ,{name:'adress', index:'adress',align:'center',width:80}
                        ,{name:'rykov', index:'rykov',align:'center',width:80}
                        ,{name:'reg_date', index:'reg_date',align:'center',width:80}
                        ,{name:'otrasl', index:'otrasl',align:'center',width:80}
                        ,{name:'last_ev', index:'last_ev',align:'center',width:80}                        
                        ,{ name:'action',index:'action',width:80,  align:'center', sortable:false}                        
                        ],
                rowNum:20,
                rowList:[20,30,40],
                mtype: "POST",
                pager: jQuery('#pagerb'),
                sortname: 'title',
                pgbuttons: true,
                multiselect: true,
                pgtext: false,
                cellEdit:true,
                sortorder: "desc",
                viewrecords: true,
                pginput:true,
                subGrid : true, 
                subGridOptions: { plusicon : "ui-icon-triangle-1-e", 
                                    minusicon : "ui-icon-triangle-1-s",
                                    openicon : "ui-icon-arrowreturn-1-e" },
                subGridRowExpanded: function(subgrid_id, row_id) {                 
                     var subgrid_table_id, pager_id; 
                     var favorites = jQuery("#favorites").val();
                        subgrid_table_id = subgrid_id+"_t"; 
                        pager_id = "p_"+subgrid_table_id; 
                        $("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>"); 
                        jQuery("#"+subgrid_table_id).jqGrid({ url:"/monitoring/eventscompanydata?q=1&content_mask='+'Demo'&id="+row_id+"&favorites="+favorites, datatype: "xml", colNames: ['','Дата соб.','Тип соб.','Описание'], 
                                colModel: [ 
                                {name:"favorites",index:"favorites",width:80}, 
                                {name:"event_date",index:"event_date",width:80},
                                {name:"event_type",index:"event_type",width:70,align:"right"}, 
                                {name:"content",index:"content",width:130},                                                      
                                ], 
                                  datatype: "json",
                                  rowNum:20, 
                                  pager: pager_id, 
                                  sortname: 'event_date', 
                                  sortorder: "asc",
                                  ondblClickRow : function(rowid) {
                                                                    if(how_click == 'dblclick' ){
                                                                         if (how_window=='standart'){
                                                                            jQuery(this).jqGrid('viewGridRow', rowid, { width: "500"});}
                                                                            else {
                                                                                 window.open('/monitoring/event/' + rowid + '', "test", "width=320, height=350, status=no, resizable=no, top=200, left=200");
                                                                            }
                                                                    }
                                                                },
                                  onSelectRow : function(rowid) {
                                                                    if(how_click == 'click' ){
                                                                         if (how_window=='standart'){
                                                                            jQuery(this).jqGrid('viewGridRow', rowid, { width: "500"});}
                                                                            else {
                                                                                 window.open('/monitoring/event/' + rowid + '', "test", "width=420, height=460, status=no, resizable=no, top=200, left=200");
                                                                            }
                                                                    }
                                                                },
                                  loadComplete: function() {
                                                                  view=0;
                                                                    $('input[name=full_short]').each(function(){
                                                                        if($(this).is(':checked')){
                                                                           view = $(this).val();
                                                                        }
                                                                    })
                                                                    if(view==2){
                                                                        $(this).find('tr.ui-widget-content').each(function(){
                                                                            var id = $(this).attr('id');
                                                                            id = parseInt(id);
                                                                            tabel=jQuery(this).parent().parent();
                                                                        if( !isNaN(id) )
                                                                         if (emptyObject(document.getElementById('desc_'+id))){                                      
                                                                            last =  jQuery(tabel).getCell(id,"content");                                       
                                                                            $(this).find('td').attr('style','border-bottom:0px;');
                                                                           
                                                                            $(this).after('<tr class="ui-widget-content jqgrow ui-row-ltr"><td colspan="11" align="center"><span style="width:100%">'+$(last).html()+'</span></td></tr>'); 
                                                                             }                 
                                                                        });                 
                                                                        jQuery(this).jqGrid('hideCol','content');
                                                                    }
                                                                },
                                   height: '100%' });                            
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
                                                jQuery("#bigset").jqGrid('setGridParam',{url:"/monitoring/eventscompanydata/?inform="+inform+"&search_innnaim_mask="+search_innnaim_mask+"&kontragent_title_mask="+kontragrnt_title_mask+"&inn_mask="+inn_mask+"&region_mask="+region_mask+"&country_mask="+country_mask+"&event_date_mask="+event_date_mask+"&event_date_po_mask="+event_date_po_mask+"&event_type_mask="+event_type_mask+"&content_mask="+content_mask+"&date_created_mask="+date_created_mask+"&date_created_po_mask="+date_created_po_mask+"&razdel="+raz+"&group="+group+"&fav_com="+fav_com+"&favorites="+favorites+"&tarif="+tarif,page:1}).trigger("reloadGrid");
                                               
                        }
                        
                        $('.description').live('click', function(){
                         $(this).parent().parent().dblclick();
                          return false;
                        }); 
                        
                        function fullShort(){
                         gridReload();
                        }


                                function  favorCompany (fav,id){
                        $('#info_favor').hide();
                        $('#info_favor1').hide();

                        jQuery.post( "/monitoring/list/" ,{favor: fav ,  id_favorites: id }   );
                            if (fav==1){
                                $("#f_"+id).attr("class","favorites-star");
                                $("#f_"+id).attr("onClick","favor(0,"+id+")"); 
                                  $("#f_"+id).attr("title","В избранном");                 

                            }
                            if (fav==0){
                                    $("#f_"+id).attr("class","nofavorites-star");
                                $("#f_"+id).attr("title","В избранное");
                                $("#f_"+id).attr("onClick","favor(1,"+id+")");

                            }
                        }



                             function  favor (fav,id){
                                $('#info_favor').hide();
                                $('#info_favor1').hide();
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
                $('.ui-subtblcell td').live('dblclick',function(kmouse){ 
                   if($(this).find('img').attr('id')!='f_'+id){
                var id=$(this).parent().find('a').attr('value');
                  window.open ("/monitoring/event/"+id);
                  setTimeout(function(){$('#infor').hide();},400);}
                 });                           
                $('.ui-subtblcell td').live('click',function(kmouse){
                   base_h = kmouse.pageY - 105;
                   base_w = kmouse.pageX - 100;
                  var id=$(this).parent().find('a').attr('value');
                  if($(this).find('img').attr('id')!='f_'+id){  
                  $.get("/monitoring/eventinfo/event_id/"+id+"/", function(data){ 
                        $('#infor').show(); 
                        $('#infor').css('top',base_h).css('left',base_w); 
                           $('#infor').html('<div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-top:-5px;" onclick="$(\'#infor\').hide();">X</div>'+data);
                               $('#infor').addClass('events_info_block');   
                             setTimeout(function(){if (($('#height_content').height())>($('#infor').height())){  $('#infor').append('<a style="cursor:pointer;font-size: 11px;color: gray;right:5px;top: 80px;position:absolute;" href="/monitoring/event/'+id+'/">Подробнее</a>');}},200);
                            
                        });}
                 })
                     function ShowEvent (id){
                                    //     var show = true;   
                                    //     if(($('#'+id).find('td:eq(0)').is(':hover'))){
                                    //         show = false;
                                    //     }else{
                                    //         show = true;
                                    //     }
                                    //     if(show == true){
                                    //     // jQuery("#bigset").jqGrid('viewGridRow', id,{
                                    //     //      caption: "Описание события"
                                    //     });
                                    // }
                                }
            </script>
            {/literal}
        
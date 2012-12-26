{literal}
    <script type="text/javascript">
	
    var change_tr_arr = []
    function change_tr(id){
	if(change_tr_arr[id] == undefined || change_tr_arr[id] == false){
		$('.all_tarifs tr#'+id).next('tr').css('background-color','#ffe9ae');
		$('.all_tarifs tr#'+id+' td').css('font-weight','bold');
		$('.all_tarifs tr#'+id+' td a').css({'color':'red', 'text-decoration': 'none'});
		$('.all_tarifs tr#'+id+' td a').next('img').attr('src','/images/drill_up_red.png');
		change_tr_arr[id] = true;
	}else{
		$('.all_tarifs tr#'+id).css('background-color','#fff');
		$('.all_tarifs tr#'+id+' td').css('font-weight','normal');
		$('.all_tarifs tr#'+id+' td a').css({'color':'#2D96FE', 'text-decoration': 'underline'});
		$('.all_tarifs tr#'+id+' td a').next('img').attr('src','/images/drill_down.png');
		change_tr_arr[id] = false;
	}
	
}

    function getDescType(id){
    {/literal}
        if (id==5){literal} {  {/literal} $('#info_event').html("{$evType[0]->description}"); return;}
        if (id==6){literal}{ {/literal} $('#info_event').html("{$evType[1]->description}"); return;}
        if (id==4){literal} { {/literal} $('#info_event').html( "{$evType[2]->description}"); return;}
	

    {literal}
    }



        function updateCountActivTarif(ids){
                    //var count = ($('.all_tarifs tr:visible').size()-1);
                    var count = ($('.notactual:visible').size());
                    var count2 = ($('.actual:visible').size());
                    $('#c_activ_t').text('('+count2+')');
                    $('#c_activ_t_a').text('('+count+')');
                    //alert($('.main_t .active').attr('value'));
                    $.post('/monitoring/gettarifdate', {id : ids}, function(data){
                            $('#info-last-mon').html(data);
            //		alert(data);
                    });
            }


    function ShowInfo(temp){
			
                            base_h = '50%';
                            base_w = '42%';
			
                            getDescType(temp);
                            $('#info_event').css('top', base_h).css('left', base_w);
                            $('#info_event').show();	
			
                    }	

            $(document).ready(function(){

                 
                    $('.btn_tarif').mouseout(function (){
                        $('#description1').hide();
                     });
                $('.btn_tarif').mouseover(function (kmouse){
                    id = $(this).attr('val2');
                    var temp = elem.offset();
                    var t=$(document).height()-(temp.top+80);
                    $('#description1').css('bottom',t+'px');
                    $('#tpointer').css({'bottom':t-16+'px','left':temp.left-15+elem.outerWidth()/2+'px'}); 
                    $('#tpointer').show();
                    var id_el = '#description1';
                        $.get('/monitoring/tarifinfo', {tarif_id : $(this).attr('val')}, function(data){
                            $('#conteiner_info').html(data);
                        });
                        $(id_el).addClass('events_info_block');

                        if (kmouse.clientX < $(document).width()/2){ 
                           var l=$(document).width()-(temp.left+elem.outerWidth()+28);
                           $('#description1').css('left','auto');	
	                   $('#description1').css('right',l+'px');
                        }
                        else {
	                   $('#description1').css('right','auto');
	                   $('#description1').css('left',temp.left+'px');

                         }
                        $(id_el).show();      
                      });     
                   
    $(".all_tarifs tr:last-of-type td").css({"border-bottom":"1px solid #FF8C00"});



                    $('.main_t').click(function(){
                    //	alert('fff');
                            n_cat = '';
                            $('.submain_t').hide();
                            $('span[val="all"]').show();
                            $('.main_t').removeClass("active");
                            $('.submain_t').removeClass("active");
                            $('#rightcomp').removeAttr("class");
                            $('#rightcomp').attr('class','rightcomp_disact');
                            $('.rightcomp_act').removeAttr('class').attr('class','rightcomp_disact');
                            $(this).addClass('active');
                            $(this).next('#rightcomp').attr('class','rightcomp_act');
                            $('.submain_t[val2="'+$(this).attr('value')+'"]').show();
                            $('.submain_t[val2="'+$(this).attr('value')+'"]:first').click();
                            $('td[class ^= main_td_]').parent().hide();
                            $('tr[class = info_tr]').hide();
                            if ($(this).attr('value') != 0)
                                    $('.main_td_'+$(this).attr('value')).each(function() {
                                            $(this).parent().show();
                                            $("#edit_table").show();
                                            $('tr[id ^= info]').hide();
                                            $('.all_tarifs tr').css('background-color','#FFF');
                                            updateCountActivTarif($(this).attr('value'));
                                    });
                            else
                            {	
                                    $('td[class ^= main_td_]').parent().show();
                                    $('#sections div.menu').hide();
                    $('span[class ^= "sub_tarif_"]').hide();
                    $('td[class ^= main_td_]').parent().show();
                                    $('#edit_table').hide();
                                    $('#change_tarif_info').hide();
                                    $('#change_tarif_button').hide();
                                    $('input[name="tarif_checked[]"]').hide();
                                    updateCountActivTarif($(this).attr('value'));
                            }
			
                            if ($('.active_arhiv').attr('id') == 'activ_t')
                            {
                                    // $('.endT').attr('color','#1F5833');
                                    // $('.endT').attr('color','#1F5833');
				
                                    $(".notactual").parent().hide();
				
                                    $("#change_tarif").show();
                                    $("#change_tarif_contin").show();
                                    $("#change_tarif_rewrite").hide();
                            }
                            else
                            {
                                    $(".actual").parent().hide();
                                    $("#change_tarif").hide();
                                    $("#change_tarif_contin").hide();
                                    $("#change_tarif_rewrite").show();
                            }
                            if ($('td[class ^= main_td_]:visible').size() == 1)
                            {
                                    $('td[class ^= main_td_]:visible').click();
                                    $('td[class ^= main_td_]:visible').parent().next().show();
                            //	$('#info_date_mon').hide();
                            }
                            else
                            {
				
                            //	$('#info_date_mon').show();
                            }
                            if($('.stars:visible').size() >0)
                                    $('.stars_info').show();
                            else
                                    $('.stars_info').hide();				
			
                            if($('#change_tarif_hide:visible').size() >0)			
                                    $('#change_tarif_hide:visible').click();
                    //alert($('.active').attr('value'));
                    //alert($(this).attr('value'));
                    //	updateNewNameTarif();
                    });
                    $('#activ_t').click(function(){
                    //	alert('fff');
                            /*$('td[class ^= main_td_]').parent().hide();
                            $('.main_td_'+$('.main_t .active').attr('value')).each(function() {
                                    $(this).parent().show();
                                    $("#edit_table").show();
                                    $('tr[id ^= info]').hide();
                                    $('.all_tarifs tr').css('background-color','#FFF');
                                    updateCountActivTarif();
                            });*/
                            $('.active_arhiv').removeClass("active_arhiv");
                            $(this).addClass('active_arhiv');
                            $('.active').click();
                            //$(".notactual").parent().hide();
                    //	updateNewNameTarif(); notactual active_arhiv
                    });
                    $('#activ_t_a').click(function(){

                            // $('.endT').attr('color','#1F5833');
			
                    //	alert('fff');
                            /*$('td[class ^= main_td_]').parent().hide();
                            $('.main_td_'+$('.main_t.active').attr('value')).each(function() {
                                    $(this).parent().show();
                                    $("#edit_table").show();
                                    $('tr[id ^= info]').hide();
                                    $('.all_tarifs tr').css('background-color','#FFF');
                                    updateCountActivTarif();
                            });*/
                            $('.active_arhiv').removeClass("active_arhiv");
                            $(this).addClass('active_arhiv');
                            $('.active').click();
                            //$(".actual").parent().hide();
			
			
                    //	updateNewNameTarif();
                    });
                     updateCountActivTarif();
                     $(".main_t[value=0]").click();
                     $("#change_tarif_info").hide();
             $("input[type=checkbox]").hide();
             gActive = false;	
                     MenuEdit = false;
	
                     /*$(".all_tarifs tr").bind('mouseover',function(){
                       if (gActive) {
                        id = $(this).attr("id");
                        if (id != "head")
                         $(this).addClass("mon_tarif_over");
               }			
                     });

		 
                     $(".all_tarifs tr").bind('mouseout',function(){
                       if (gActive) {
                        id = $(this).attr("id");
                        if (id != "head")		 
                         $(this).removeClass("mon_tarif_over");
               }			
                     });*/
    $('.submain_t').click(function(){
                    $('.submain_t').removeClass("active");
                    $(this).addClass('active');

                    $('#tarifs span').hide();
                    $('#tarifs span[parent='+$(this).attr('value')+']').show();
                    $('#tarifs span[parent='+$(this).attr('value')+']:first').click();
		
            });
            $('#active').click();
                     $("#change_tarif_button").click(function(){
                               checks = $("input:checked");
                               len = checks.length;
		   
                               if (len==0) {		   
                                    alert("Выберите услугу");
                                    return false;
                               }
                               /*else if (len>1) {
                                     form =  $("form[name=check_tarifs]");
                                     form.attr('action',"/monitoring/addtarif/");			 
                                     form.submit();		  	
                                     return false;
                               }*/
                               else {
                                     form =  $("form[name=check_tarifs]");
                                     form.attr('action',"/monitoring/addtarif/");			 
                                     form.submit();
                                     return false;
                               }
		 
                     });
		 
                     $("#change_tarif_hide").click(function(){
                            $("input[type=checkbox]").hide();	
                                    $("#change_tarif_button").hide();
                                    $("#change_tarif_info").hide();
                                    $("#changeContin_tarif_info").hide();
                                    $("#changeGo_tarif_info").hide();
             $("input[type=checkbox]").hide();
                     $("#edit_table").hide();
                     $("#change_tarif_hide").hide();
                     $('.active').click();
                     });
            // $("#change_tarif").click(function() {});
		 
             $("#change_tarif").click(function() {
                       $("#change_tarif_hide").show();
                       $("#change_tarif").hide();
                       $(".endT").parent().parent().parent().hide();

                            $("#change_tarif_contin").hide();
                      // if (!gActive) {
                                    gActive=true; 
                                    $("#change_tarif_info").slideDown(500); 
                                    $("input[type=checkbox]").show();	
                                    $("#change_tarif_button").show();
                                    $("#change_tarif_button").html('Изменить выбранные');
                                    if ($('input[type=checkbox]:visible').size() == 1)
                                    {
                                            $('input[type=checkbox]:visible').click();
                                            $("#change_tarif_button").click();
                                    }
                                    return false;
                      /* }
                   else {	 
                              gActive=false;
                              $("#change_tarif_info").hide(); 
                                    $("input[type=checkbox]").hide();	
                                    $("#change_tarif_button").hide();
			  
                              return false;
                       }*/
		   
             });
		 
             $("#change_tarif_contin").click(function() {
                        $("#change_tarif_hide").show();
                        $("#change_tarif").hide();
                            $("#change_tarif_contin").hide();
                        $(".NOTendT").parent().parent().parent().hide();//NOTendT

                            gActive=true; 
                            $("#changeContin_tarif_info").slideDown(500); 
                            $("input[type=checkbox]").show();	
                            $("#change_tarif_button").show();
                            $("#change_tarif_button").html('Продлить выбранные');
                            if ($('input[type=checkbox]:visible').size() == 1)
                            {
                                    $('input[type=checkbox]:visible').click();
                                    $("#change_tarif_button").click();
                            }
                            return false;
	  
             });
		 
             $("#change_tarif_rewrite").click(function() {
                        $("#change_tarif_hide").show();
                        $("#change_tarif").hide();
                        $("#change_tarif_rewrite").hide();
                            $("#change_tarif_contin").hide();
                            gActive=true; 
                            $("#changeGo_tarif_info").slideDown(500); 
                            $("input[type=checkbox]").show();	
                            $("#change_tarif_button").show();
                            $("#change_tarif_button").html('Возобновить выбранные');
                            if ($('input[type=checkbox]:visible').size() == 1)
                            {
                                    $('input[type=checkbox]:visible').click();
                                    $("#change_tarif_button").click();
                            }
                            return false;
	  
             });
		 
            $('#sections p').toggle(function(){
                $('#sections div.menu').show();
                }, function(){
                    $('#sections div.menu').hide();
                    $('span[class ^= "sub_tarif_"]').hide();
                    $('td[class ^= main_td_]').parent().show();
                                    $('#edit_table').hide();
                });
            $('span[class ^= "sub_tarif_"]').hide();
                    $('div[class ^= "type_tarif_"]').click(function(){
                                    $('span[class ^= "sub_tarif_"]').hide();
                                    $(this).children('span').show();
                                    $('td[class ^= main_td_]').parent().hide();
                                    $('.main_td_'+$(this).attr('value')).each(function() {
                                            $(this).parent().show();
                                            $("#edit_table").show();
                                            $('tr[id ^= info]').hide();
                                            $('.all_tarifs tr').css('background-color','#FFF');
                                            updateCountActivTarif();
					
					
                                    });
                            });
                    $('span[class ^= "sub_tarif_"]').click(function(){
                            $('td[class ^= main_td_]').parent().hide();
                            //$('.submain_td_'+$(this).attr('value')).each(function() {
                            //	$(this).parent().show();
                            //});
                    });
		
                    var open_info_tarif = []
		
                    $('.all_tarifs tr:not(".info_tr")').click(function(e){
                            var row_tarif = this;
                            var id = $(this).attr('id');
                            var id_el = '#info'+id;

			
                            texts = '';
                            var value;
                            if ($(this).children().filter('.actual').size() == 0){
                                    texts = 'Возобновить';
                                    value = 1;
    }
                            else
                                    if ($(this).children('.actual').children('b').children('.endT').size() > 0)
                                    {	texts = 'Продлить';
                                                                            value = 2;}
                                    else
                                            {texts = 'Изменить';
                                                                                    value = 3;}
                            if(open_info_tarif[id] == undefined){

                                    $(id_el+' td').html($("#description").html());
                                    $.getJSON('/monitoring/gettarif', {id : $(this).attr('id')}, function(data){
                                            $(id_el+' td #tarifid').attr('value',data['id']);
                                            $(id_el+' td #count').html(data['count']);
                                            $(id_el+' td #reg').html(data['period']);
                                            $(id_el+' td #country').html(data['countryName'] +' <img src="/images/'+data['country']+'\.gif">');
                                            $(id_el+' td #time').html(data['m']);
                                            $(id_el+' td #timefor').html(''+data['startDate']+' - '+data['endDateUser']);
                                               temp =  data['endDateUser'].split('-');
                                                    if (data['active']==1 ){
                                                       $(id_el+' td #activity').html("<font color='#ff0000'>Неактивный</font> "); 
                                                    } else {
                                                        $(id_el+' td #activity').html("<font color='#458B00'>Активный</font> ");
                                                        }
                                            $(id_el+' td #dateend').html(data['dateEndMon'] + '/<br>' + data['dateNextMon']);
                                            $(id_el+' td #count_event').html(data['count_event']);
                                                
                                            //$(id_el+' td #datenext').html(data['dateNextMon']);
                                            $(id_el+' td #price').html(data['price']);
                                            // var tempev="<span onmouseover=\"$('#info_event').show();  data='";
                                            // for (var i in data['events']) {
                            // 		  tempev+=i+"'\" onmouseout=\"getDescType("+i+"); $('#info_event').hide(); \" id='event_type' '>"+data['events'][i]+"</span>  <span onmouseover=\" getDescType("+i+"); $('#info_event').show(); \"  onmouseout=\"$('#info_event').hide();\" id='event_type' data='"
                                            // }
                                             var tempev="";
                                             for (var i in data['events']) {
                                                    tempev+="<span onmouseover= \"ShowInfo("+i+")\" onmouseout=\"$('#info_event').html(''); $('#info_event').hide();\"  >"+data['events'][i]+" </span> ";
                                             }


                                    $(id_el+' td #event').html(tempev);
					

                                            //$(id_el+' td #event').html(data['event']);

                                            $(id_el+' td #count_kontr').html(data['count_kontr']);
                                            $(id_el+' td #info').html(data['info']);
                                            $(id_el+' td #dateendevent').html(data['dateendevent']);
                                            $(id_el+' td #change_tarif_reset').html(texts+' услугу');
                                            $(id_el+' td #change_tarif_reset').attr('value',value);
					 
                                            if(data['type_tarif'] == 1)
                                            {
                                                    $('.noHistory').hide();
                                            }
                                            else
                                            {
                                                    $('.noHistory').show();
                                            }
                                    });
			
				
                                    $(id_el+' td').css('text-align','left');
                                    $('.all_tarifs #'+id).css('background-color','#FFE9AE');
                                    $(id_el).show();
                            }
			
                            if(open_info_tarif[id] == true){
                                    $(id_el).hide();
                                    $('.all_tarifs #'+id).css('background-color','#FFF ');
                                    open_info_tarif[id] = false;
                            }else{
                                    $(id_el).show();
                                    open_info_tarif[id] = true;
                                    $('.all_tarifs #'+id).css('background-color','#FFE9AE');
                            }
			
			
                            /*$.getJSON('/monitoring/gettarif', {id : $(this).attr('id')}, function(data){
                                    $('#description').css({"top": e.pageY-250, "left": e.pageX-400}).show();
                                    $('#count').html(data['count']);
                                    $('#reg').html(data['period']);
                                    $('#time').html(data['m']);
                                    $('#timefor').html('c '+data['startDate']+' по '+data['endDateUser']);
                                    $('#dateend').html(data['dateNextMon']);
				
                                    $('#event').html(data['event']);
                                    if(data['type_tarif'] == 1)
                                    {
                                            $('.noHistory').hide();
                                    }
                                    else
                                    {
                                            $('.noHistory').show();
                                    }
                            });*/
                    });
                    $('.all_tarifs tr:even').css('background-color','#eee');
                    $('#close').click(function(){$('#description').hide();})
            }); 
	
function showTooltip(elem,event){
event = event || window.event;
var temp = elem.offset();
var t=$(document).height()-(temp.top+133);
$('.company_info_block').css('bottom',t+'px');
$('#tpointer').css({'bottom':t-16+'px','left':temp.left-15+elem.outerWidth()/2+'px'}); 
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
<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
    <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
    </div>

    <div>
        <div class="main_top_text">

            {breadcrumb controller="monitoring" alias="monitoring" altTitle="Мониторинг"}
            {include file="lmenu.tpl"}

            <div>

                {* Все услуги *}	
                {*}			
                <strong> Все текущие услуги : </strong>
                <select name="all_tarifs" id="all_tarif" style="color:#133C5F;font-size:12px;" > 
        
                {foreach from=$userTarifs item=item}
                <option  value="{$item->tarifId}"   >{$item->count}-{$item->m}-{$item->period/7}</option>
                {/foreach}
                </select>
                
                <input type="hidden" name="current_tarif" value="{ $current_mon_tarif }" />
                {*}


                <div>
                    <span class='main_t' style="cursor:pointer;" value=0>Все</span> <span id="rightcomp" class="rightcomp_act"></span>
                    {foreach from=$type item=typ}
                        <span class='main_t' onmouseover="$('#InfoCompany_{$typ->id}').show();showTooltip($(this),event);" onmouseout="$('#InfoCompany_{$typ->id}').hide();$('#tpointer').hide();" style="cursor:pointer;" value={$typ->id}>{$typ->name}</span> <span id="rightcomp" class="rightcomp_disact"></span> 
                        <div align="left" id="InfoCompany_{$typ->id}"  class="company_info_block" style="display:none;"> 
                           <b>{$typ->about}</b>					
                        </div> 	<span id="tpointer" style="display:none;"> </span>	
                    {/foreach}
                </div><br><br>
                <div>
                    {foreach from=$tarif item=tar}
                        {if $tar->name != ''}
                            <span class='submain_t' style="padding:2px;cursor:pointer;" val2='{$tar->type}' value="{$tar->id}">{$tar->name}</span> 
                        {/if}
                    {/foreach}
                </div>
                <!-- <span class='subm' style="display:none;" val='all'>&nbsp;</span>  -->


                {* Вывод всех услуг *}
                {if $showAll==0}  

                    {* Теcтовая услуг *}
                    {if $user->mon_test_period>0 }
                        <strong style="color:red;" > Тестовый тариф:</strong>
                        {$current_user_tarif->count}-{$current_user_tarif->m}-{$current_user_tarif->period/7}	

                    {else}
                        {* Текущий тариф  *}
                        <strong>Текущая услуга:</strong>            
                        {$current_user_tarif->count}-{$current_user_tarif->m}-{$current_user_tarif->period/7}
                    {/if}

                    &nbsp;<a href="/monitoring/notarif/change/1/">изменить</a> 
                {else}
                    <form action="/monitoring/addtarif" method="post" name="check_tarifs" id="check_tarif" > 


                        <div style="margin: 0px 0px 5px 0px; color: red;float:right;">
                            { if $user->mon_test_period!=1 }
                            
                            <a style="font-size: 11px;" href="/monitoring/addtarif/"><img src="/images/add_comp_img.png" style="margin-bottom:-3px">Добавить услугу</a>

                        {/if}				 
                    </div>  


                    <p id="change_tarif_info" style='display:none'>
                        { $change_tarif_info }
                    </p>		
                    <p id="changeContin_tarif_info" style='display:none'>
                        {info name="changeTarifContin"}
                    </p>		
                    <p id="changeGo_tarif_info" style='display:none'>
                        {info name="changeTarifGo"}
                    </p>
                    <div style="margin-top:5px;">
                        <span id='activ_t' style="font-weight:bold; text-transform: uppercase;font-size:9,75pt;color:#DBA107" class='active_arhiv'> Активные услуги <span id="c_activ_t"></span></span>
                        <span id='activ_t_a' style="font-weight:bold; text-transform: uppercase;font-size:9,75pt;color:#999999"> Архив <span id="c_activ_t_a"></span></span>
                    </div>
                    <table class="all_tarifs" cellspacing="0" cellpadding="0" style="margin-top:-70px;">
                        <tr id="head" > 
                            <td class="odd" style="text-align:left">Услуги</td>

                            <td>Период <br>с / по</td>

                            <td class="odd">Дата мониторинга<br>послед./след. </td>
                            <td width="200" style="text-align:left">Раздел/Категория</td>

                        </tr>

                        {foreach from=$userTarifs item=item}


                            <input type='hidden' id='{$item->tarifId}'>
                            {if $item->all_id == $idt || $idt == 0}
                                { $user->getTarifById($item->tarifId) } 
                                <tr class="row" id="{$item->tarifId}" onclick ="change_tr({$item->tarifId})"> 

                                    <td class="odd" style="text-align:left">
                                        <input style="vertical-align:bottom" type="checkbox" name="tarif_checked[]" value="{$item->tarifId}" />
                                        <a href="javascript:void(0);"> 
                                              {$item->getTarifAll()->getTypeItem()->simbol}{$item->getTarifAll()->simb}-{$item->period}-{$item->m}-{$item->count}</a>
                                         <img src="/images/drill_down.png">
                                    </td>

                                    {if $user->getTarifInfo()->getActual() == 1}
                                        <td style="padding: 5px; color:#1F5863; " class='{if $user->getTarifInfo()->getActual() == 1}actual{else}notactual{/if}'> 
	     {if $user->getTarifInfo()->getDaysLeft()<$setting->get('timered')}
                                            {literal}
                                                <script type="text/javascript">
                                                {/literal} {if ($user->getTarifInfo()->getActualRed() == 0)  } {literal}

    if (confirm('Срок окончания услуги мониторинга заканчивается {/literal}{strip}{if $user->getTarifInfo()->endDateUser < $user->getTarifInfo()->endDateKurator}
                                                        {$user->getTarifInfo()->getEndDateKuratorFormatted()|strip_tags}
                                                        {else}
                                                            {$user->getTarifInfo()->getEndDateKuratorFormatted()|strip_tags}
                                                        {/if}{/strip}{literal}. Продлить?')) document.location.href = '/monitoring/notarif?{/literal}tarifid={$user->getTarifInfo()->id}&type=2';
                                                                {/literal}{/if}{literal}
                                                                        </script>
                                                                    {/literal}
                                                                    {/if}
                                                                        {$user->getTarifInfo()->getStartDateFormatted()}

                                                                        {if (($user->getTarifInfo()->getActualRed() == 0) ) } <br>

                                                                            <font color="#da114b" class="endT">{$user->getTarifInfo()->getEndDateKuratorFormatted()}	</font>

                                                                        {/if}

                                                                        {if ($user->getTarifInfo()->getActualRed() == 1)} <br>


                                                                            <font color="#1F5863" class="NOTendT">{$user->getTarifInfo()->getEndDateKuratorFormatted()}	</font>	


                                                                        {/if}
                                                                        {else}
                                                                        <td style="padding: 5px;" class='notactual'> 
                                                                           {$user->getTarifInfo()->getStartDateFormatted()}
                                                                                {if $user->getTarifInfo()->endDateUser < $user->getTarifInfo()->endDateKurator}
                                                                                    {$user->getTarifInfo()->getEndDateKuratorFormatted()}
                                                                                {else}
                                                                                    {if ($user->getTarifInfo()->getActualRed() == 0)  }



                                                                                    {/if}

                                                                                    {$user->getTarifInfo()->getEndDateUserFormatted()}
                                                                                {/if} <br/> 
                                                                                {if !$user->getActualTarifInfo()}
                                                                                    <a href="/monitoring/addtarif?tarifid={$user->getTarifInfo()->id}">продлить</a>
                                                                                {/if}				  

                                                                        </td> 

                                                                        {/if}




                                                                        <br/> 
                                                                        {if !$user->getActualTarifInfo()}
                                                                            <a href="/monitoring/notarif?tarifid={$user->getTarifInfo()->id}">продлить</a>
                                                                        {/if}				  

                                                                        </td> 


                                                                        <td class='main_td_{$item->getTarifAll()->getTypeItem()->id} odd' value='{$item->getTarifAll()->getTypeItem()->id}'>
                                                                            {$item->dateEndMon|date_format:"%d-%m-%Y"}{if $item->dateNextMon != '-'}
                                                                                {$item->dateNextMon|date_format:"%d-%m-%Y"}
                                                                                {if ($item->dateNextMon|date_format:"%w" == 0 or $item->dateNextMon|date_format:"%w" == 6 )}
                                                                                    <font color="#da114b" class='stars'>*</font>
                                                                                {/if}
                                                                                {else}
                                                                                    {$item->dateNextMon}{/if}
                                                                                </td>
                                                                                <td class='submain_td_{$item->getTarifAll()->id}' value='{$item->getTarifAll()->id}' style="text-align:left">
                                                                                   {$item->getTarifAll()->getTypeItem()->name}
                                                                                    {$item->getTarifAll()->name}


                                                                                </td>

                                                                                </tr>
                                                                                <tr id="info{$item->tarifId}" class="info_tr" style="display:none; cursor:default;">
                                                                                    <td	colspan="4" style="background-color:#FAF0E0;">
                                                                                        <input type='hidden' name="idtarif" id='{$item->tarifId}'>
                                                                                    </td>

                                                                                </tr> 
                                                                                {/if}
                                                                                    {/foreach}
                                                                                    </table> 
                                                                                    <!--    <hr color="#FF8C00" width="100%" size="1px"> -->
                                                                                    <p style="font-size:11px;" class='stars_info'>{info name="infoStar"}</p>
                                                                                    <div><button class="accountblock_button" id="change_tarif_button" style="display:none">Изменить выбранные</button></div>



                                                                                    {/if}
                                                                                    {if $showAll == 0 }  {/if}
                                                                                    </p>

                                                                                    <div style="margin: 0px 0px 5px 0px; color: red;float:right;">
                                                                                        <span style="display:none;" id="edit_table">
                                                                                            <a class="accountblock_button" id="change_tarif" style=" color: #da114b;" href="/monitoring/notarif/change/1/">Изменить</a>
                                                                                            <a class="class="accountblock_button" id="change_tarif_contin" style=" color: #da114b;" href="/monitoring/notarif/change/1/">Продлить</a>
                                                                                            <a class="accountblock_button" id="change_tarif_rewrite" style=" color: #da114b;" href="/monitoring/notarif/change/1/">Возобновить</a><a href="#" id="change_tarif_hide" style="display:none;color: #da114b;">Отмена</a>&nbsp;&nbsp; </span>
                                                                                    </div>

                                                                                </form> 

                                                                                <!--p style="width:100%;float:left;">
                                                                                        <strong>Название:</strong> 
                                                                                        <span id='name'> </span>
                                                                                </p-->

                                                                                <div id="description">
                                                                                    <div>
                                                                                        <span style="color:#2D96FE;font-weight:bold" id='info'> </span>
                                                                                    </div>
                                                                                    <div><font style="color: black;font-weight: bold;">Регулярность мониторинга: </font>
                                                                                        <span id='reg'>  </span> дн.
                                                                                    </div>
                                                                                    <div><font style="color: black;font-weight: bold;">Количество компаний в мониторинге(фактическое/максимальное):</font>
                                                                                        <span id='count_kontr'> </span>/<span id='count'> </span>
                                                                                    </div>
                                                                                    <div><color: style="color: black;font-weight: bold;">Период действия (срок):</font>
                                                                                        <span id='timefor'> </span> (<span id='time'> </span> дн.) <span id="activity"></span>
                                                                                    </div>
                                                                                    <div><color: style="color: black;font-weight: bold;">Дата последнего/cледующего мониторинга:</font>
                                                                                        <span id='dateend'> </span> (Количество событий:  <span id='count_event'></span>)
                                                                                    </div>

                                                                                    <div><font style="color: black;font-weight: bold;">События, доступные в данной услуге:</font> 
                                                                                        <span id='event'> </span>
                                                                                    </div>



                                                                                    <div><font style="color: black;font-weight: bold;">Страна:</font> 
                                                                                        <span id='country'> </span>
                                                                                    </div>


                                                                                    <div><font style="color: black;font-weight: bold;">Дата последнего события:</font> 
                                                                                        <span id='dateendevent'> </span>
                                                                                    </div>
                                                                                    <input id='tarifid' type='hidden' name='tarifid' value=''>
                                                                                    Стоимость услуги :</font> <span id='price'> &nbsp;</span> руб. <br>
                                                                                    <p style="text-align:right; padding-right: 0%;"><button class="accountblock_button" id="change_tarif_reset"  name='type'>Изменить</button> </p>
                                                                                </div>



                                                                                <div id="info_event" class="events_info_block" style="display:none;position:absolute;width:350px;z-index:10000;">

                                                                                </div>



                                                                                {* Сетка для одной услуга *}
                                                                                {*} 
                                                                                <p style="width:100%;float:left;">
                                                                                            
                                                                                            
                                                                    
                                                                                <strong>Максимальное количество компаний в мониторинге:</strong> 
                                                                                {$current_user_tarif->count}
                                                                                </p>
                                                        
                                                           
                                                                                <p >
                                                                                                
                                                                                { if $showAll==0}
                                                                                <strong>Срок активизации услуги:</strong>
                                                                                <b>с</b> {$user->getTarifInfo()->getStartDateFormatted()} <b>по
                                        
                                                                                {if $user->getTarifInfo()->endDateUser < $user->getTarifInfo()->endDateKurator}
                                                                                {$user->getTarifInfo()->getEndDateKuratorFormatted()}
                                                                                {else}
                                                                                {$user->getTarifInfo()->getEndDateUserFormatted()}
                                                                                {/if} ({$user->getActualTarifInfo()->m} {if $user->getActualTarifInfo()->m == 1}месяц{/if}{if $user->getActualTarifInfo()->m == 3}месяца{/if}{if $user->getActualTarifInfo()->m == 6}месяцев{/if}{if $user->getActualTarifInfo()->m == 12}месяцев{/if})
                                                                                {if !$user->getActualTarifInfo()}
                                                                                <a href="/monitoring/notarif/">продлить</a>
                                                                                {/if}
                                                                                {else}
                                                                                <div style="float:left;" > <strong>Срок активизации услуги:</strong> </div>				
                                                                              
                                                                              
                                                                                {/if}
                                                                                </p>
                                                                    
                                                                                <p style="width:100%;float:left;">
                                                                                <strong>Периодичность мониторинга:</strong>
                                                       
                                                                                {assign var='tmp' value=$user->getActualTarifInfo()->period}
                                                                                {$periodList.$tmp}
                                                                
                                                                                </p>
                                                                    
                                                                                
                                                                                <p>
                                                                                  
                                                                                <b>События доступные для мониторинга :</b>
                                                                                {foreach from=$ttList item=et}
                                                                                <span style="width:20px; height:20px;background-color:{$et->getColor()}">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<b style="color:{$et->getColor()}">{$et->title|escape}</b> - {$et->description|escape}
                                                                                {/foreach}
                                                                                </p>
                                                                                {*}
                                                                            </div>


                                                                            <span id='info_date_mon'>Дата последнего мониторинга/события:<span id='info-last-mon'> {$lastMonitoringDate} / <a href="/monitoring/event/{$lastEvent->id}/" style="color:#da114b;{if !$lastEvent->isViewed()} font-weight:bold;{/if}">{$lastEvent->getEventDateFormatted()} ({$lastEvent->getType()->title})</a></span></td></span>

                                                                            Количество событий (всего/новых):

                                                                            <font color="#dba108">
                                                                            {$user->getTotalEventCount()} /{if $lastEvent->id}
                                                                        {if $user->getLastEventCount() > 0}<b>{/if}{$user->getLastEventCount()}{if $user->getLastEventCount() > 0}</b>{/if}
                                                                    {else}
                                                                        0
                                                                    {/if}
                                                                    </font>

                                                                    <br>
                                      <div id="country_choice">
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
{*
                                                                    <span class="radio_style">
                                                                        <input type='radio' name='country' value='' id="all_countries" onClick="$('#search_country').val('');$('#search_innnaim').attr('placeholder','Наименование/(ИНН/ЕДРПОУ)');$('#search_inn').attr('placeholder','ИНН/ЕДРПОУ');$('#search_country').removeAttr('disabled'); 
                                                                        {foreach from=$ttList item=et }$('#type_event_'+{$et->id}).removeAttr('style');$('#search_event_type_'+{$et->id}).attr('checked','checked');{/foreach};
                                                                    {if $user->getTotalEventCount()==''}$('#bottom_type_all').html('(0)');{/if}            
                                                                    {foreach from=$ttList item=et}
                    $('#bottom_type_'+{$et->id}).html({$user->getEventCount($et->id)});                  
                                                                    {if $user->getEventCount($et->id)<>''}$('#type_eve_'+{$et->id}).removeAttr('style').attr('style','cursor:pointer'); {/if}
                                                                {/foreach}
                                                            {if $user->getTotalEventCount()<>''}$('#bottom_type_all').html('('+{$user->getTotalEventCount()}+')');{/if}
                $('#img_ua').hide();$('#img_ru').hide();$('#small_event_types').show();$('#full_event_types').hide();
                doSearch(arguments[0]||event)" checked><label color="#1F5763" for="all_countries">Все</label></span>

                                                    <span class="radio_style">            
                                                        <input type='radio' name='country' value='RU' id="country_ru" onClick="        
            $('#search_country').val('RU');$('#search_innnaim').attr('placeholder','Наименование/ИНН');$('#search_inn').attr('placeholder','ИНН');$('#search_country').attr('disabled','disabled');
                                                        {foreach from=$ttList item=et }$('#type_event_'+{$et->id}).attr('style','display:none');$('#search_event_type_'+{$et->id}).removeAttr('checked');{/foreach};
                                                {foreach from=$eveCountry item=et1}{if $et1.id_country==258}$('#search_event_type_'+{$et1.id_type}).attr('checked','checked');$('#type_event_'+{$et1.id_type}).removeAttr('style');{/if}{/foreach}
                            {foreach from=$eventsdata key=k item=et1}$('#bottom_type_'+{$k}).html({$et1.RU});{if $et1.RU==0}$('#type_eve_'+{$k}).attr('style','display:none');{/if}{if $et1.RU<>0}$('#type_eve_'+{$k}).removeAttr('style').attr('style','cursor:pointer');{/if}{if $et1.RU_ev_all==''}$('#bottom_type_all').html('(0)');{/if}{if $et1.RU_ev_all<>''}$('#bottom_type_all').html('('+{$et1.RU_ev_all}+')');{/if}{/foreach};$('#img_ua').hide();$('#img_ru').show();$('#small_event_types').hide();$('#full_event_types').show();
                doSearch(arguments[0]||event);"><label color="#1F5763" for="country_ru">Россия <img src="/images/258.gif"></label></span>

                    <span class="radio_style">
                        <input type='radio' name='country' value='UA' id="country_ua" onClick="$('#search_country').val('UA');$('#search_innnaim').attr('placeholder','Наименование/ЕДРПОУ');$('#search_inn').attr('placeholder','ЕДРПОУ');$('#search_country').attr('disabled','disabled');
                        {foreach from=$ttList item=et }$('#type_event_'+{$et->id}).attr('style','display:none');$('#search_event_type_'+{$et->id}).removeAttr('checked');{/foreach};
                {foreach from=$eveCountry item=et1}{if $et1.id_country==252}$('#search_event_type_'+{$et1.id_type}).attr('checked','checked');$('#type_event_'+{$et1.id_type}).removeAttr('style');{/if}{/foreach}
{foreach from=$eventsdata key=k item=et1}$('#bottom_type_'+{$k}).html({$et1.UA});{if $et1.UA==0}$('#type_eve_'+{$k}).attr('style','display:none');{/if}{if $et1.UA<>0}$('#type_eve_'+{$k}).removeAttr('style').attr('style','cursor:pointer');{/if}{if $et1.UA_ev_all==''}$('#bottom_type_all').html('(0)');{/if}{if $et1.UA_ev_all<>''}$('#bottom_type_all').html('('+{$et1.UA_ev_all}+')');{/if}{/foreach};$('#img_ua').show();$('#img_ru').hide();$('#small_event_types').hide();$('#full_event_types').show();
                doSearch(arguments[0]||event);"><label color="#1F5763" for="country_ua">Украина <img src="/images/252.gif"></label></span><br>
*}

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
        </b> - {$et->description|escape} <span id='tarifs'><span class="btn_tarif" onmouseover="$('#description1').show();event_tip($(this),event);" onmouseout="$('#description1').hide();$('#tpointer').hide();" val="{$user->getActualTarifInfo()->id}" 
                                                                 val2="{$user->getTarifId($user->getActualTarifInfo()->id)}">{$user->getCountMon() }-{$user->getTarifInfo()->m}-{$user->getActualTarifInfo()->period/7}
            </span></span>
    </div>
    {/foreach}
    </div>
	
	 <div  id="infor" style="position: absolute; z-index: 10000; overflow:hidden; height:95px; left: 450px; display: none;" class="events_info_block"> </div>
                            <br>
                            <div id="description" style="display:none; position:absolute; width:470px;">
                                <div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-right: -2px;" onclick="$('#description').hide();" id='hide_info'>X</div>
                                <div id='conteiner_info'></div>
                            </div>
                        </div>        

    {*<div id="description1" style="display:none; position:absolute; width:470px;">
        <div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-right: -2px;" onclick="$('#description').hide();" id='hide_info'>X</div>
        <div id='conteiner_info'></div>            
    </div>
        <span id="tpointer" style="display:none"> </span>	*}

    <div class="dotted2"></div>
</div>
</div>



{literal}
<script type="text/javascript">

var filter_all="off";
   function checkbtn() {
        if ($('#country').val() == 'RU' && $('#checkinn').val().length ) {
            $('#checkinnbtn').show();
        } else {
            $('#checkinnbtn').hide();
        }

        //if ($('#checkinn').val().length ) {
        //    $('#amon').show();
        //} else {
        //    $('#amon').hide();
        //}
        
    }
    
    function acol(a){
    $('.l1,.l2').css('color','#DA114B');
    if($(a).css('color')=='rgb(218, 17, 75)'){
        $(a).css('color','#1F5763');
    }else{
        $(a).css('color','#DA114B');
    }
    
    if($('#full_search').css('display')=='none' && $('#add_comp_monitoring').css('display')=='none'){
        $('.l1').css('color','#DA114B');
        $('.l2').css('color','#DA114B');
    }
    
    }
    function HideInfo(){      
      var element = $('#drill_info').attr('data-id');
      if(element=='show'){
        window.resizeTo(420,460);
        $('#drill_info').attr('data-id','hide');
        $('#drill_info').attr('src','/images/red_down.png');
        $('.object_').hide();
        $('.company').show();
        $('.short_dt').hide();
        
      }
      if(element=='hide'){    
      window.resizeTo(480,550);    
        $('#drill_info').attr('data-id','show');
        $('#drill_info').attr('src','/images/red_up.png');
        $('.object_').show();
        $('.company').hide();
        $('.short_dt').show();
      }
    }
    $(function(){checkbtn();});
    
    function infoBox(id){
            base_h = $('#tarifs').offset().top + 20;
            var id_el = '#description';
                
                $.getJSON('/monitoring/gettarif', {id : id}, function(data){                            
                $('#amount').val(data['count']);
                $('select[name=period]').val(data['period']);
                $('input[name=m][cou='+data['m']+']').click();
                $('input[name=m][cou='+data['m']+']').change();
                $('input[name=country_tarif][value='+data['country']+']').click();
                $('input[name=country_tarif][value='+data['country']+']').change();
                
                
                });             
                
    var change= $("#amount").val();
          calculate(change);
        
        }
    
        
$(document).ready(function() {
             $('#filter_all').click(
                function(){
                    $('.main_t').removeClass("active");
                    $('.submain_t').removeClass("active");
                    $('#tarifs span').show();
                }   
                
            );
    $('.btn_tarif').mouseout(function (){
                $('#description').hide();
    });
    $('.btn_tarif').mouseover(function (kmouse){
            id = $(this).attr('val2');
            base_h = kmouse.pageY - 100;
            base_w = kmouse.pageX - 150;
            var id_el = '#description';
                $.get('/monitoring/tarifinfo', {tarif_id : $(this).attr('val')}, function(data){
                    $('#conteiner_info').html(data);
                });
                $(id_el).addClass('events_info_block');
                $(id_el).css('top', base_h).css('left', base_w);
                $(id_el).show();        
        });     

        
    $('.main_t').click(function(){

        $('.submain_t').hide();
        $('span[val="all"]').show();
        $('.main_t').removeClass("active");
        $('.submain_t').removeClass("active");
        $(this).addClass('active');
        $('.submain_t[val2="'+$(this).attr('value')+'"]').show();
        $('.submain_t[val2="'+$(this).attr('value')+'"]:first').click();
            
    });
    
        
    $('.submain_t').click(function(){
        $('.submain_t').removeClass("active");
        $(this).addClass('active');

        $('#tarifs span').hide();
        $('#tarifs span[parent='+$(this).attr('value')+']').show();

        
    });
    $('#active').click();
  });

    
    $(document).ready(function(){
            // {foreach from=$userTarifs item=item}
        // {if $item->tarifId ==$current_mon_tarif}
        // $(this).html('#terifs span').attr('style','background-color: #dba108;')
        // {/if}
         setChecked(); 
         gSave=0;        
         
         $("#all_tarif").bind('change',function() {
            $("#check_tarif").submit();
         });
                 
         $("#mail_change").click(function(){
          if (gSave==0) {
              $("#mails").show();
              $("#saved").hide();
              $("#mail_change").text("cохранить");
              gSave=1;
          }
          else {
             
             if (validateMails()){
                 court = $("input[name=court]").val();
                 egrul = $("input[name=egrul]").val();
                 bankruptcy = $("input[name=bankruptcy]").val();
              
                $.ajax({
                  method: "post",
                  url: "/monitoring/changemail/",
                  data: "court="+court+"&egrul="+egrul+"&bankruptcy="+bankruptcy, 
                  
                  beforeSend: function() {
                    $("#saved").hide();
                  },
                  
                  success: function(text){
                    $("#saved").show();
                  } 
                  
                });         
                $("#mail_change_send").val("1");
            }           
          }
          return false;
         });
         
         function setChecked(){
          var need = $("input:hidden[name=current_tarif]").val();
          need=parseInt(need);            
          
          $("#all_tarif option").each(function() {
            op = $(this).val();
            op=parseInt(op);
            if (op==need) { $(this).attr("selected","selected");}            
          });         
         }
         
         $(".all_tarifs tr").bind('mouseover',function(){
           id = $(this).attr("id");
           if (id != "head")
            $(this).addClass("mon_tarif_over"); 
         });
         
         $(".all_tarifs tr").bind('mouseout',function(){
           id = $(this).attr("id");
           if (id != "head")         
            $(this).removeClass("mon_tarif_over");  
         });

         function validateMails(){
          var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
          validate=false;    
          mails = $("#mails input");         
          
          mails.each(function() {
            if ( isValidEmailAddress($(this).val())) {  
             validate=true;
            }
            else{
             alert("Введите правильный e-mail");
             validate = false;
            }           
          });
          return validate ;       
         }  

        function isValidEmailAddress(emailAddress) {
          var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
          return pattern.test(emailAddress);
        }        

    }); 

 jQuery(".m1").live( 'click',  function() {
                         var s;
                         fav = jQuery(".m1").attr('name');
                         id = jQuery(".m1").attr('data');

                         jQuery.post( "" ,{favor: fav ,  id_favorites: id }   );
                         if (fav ==0){
                          jQuery(".m1").attr('name','1');
                         jQuery(".m1").html('<img src="/img/star_noevent.png"> Добавить в избранное');
                           alert('События удалены из избранного');} else
                          if (fav == 1){
                          jQuery(".m1").attr('name','0');
                         jQuery(".m1").html('<img src="/img/star_event.png"> Убрать из избранного');
                        
                            alert('События добавлены в избранное');
                        
                        }
   

                        });

    </script>


<style>
		#t1 strong{
			color:#1f5863;
		}
</style>
{/literal}
<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

<div>
    <div id="tarifs">

    </div>

    <div id="description" style="display:none; position:absolute;">
    <div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-right: -2px;" onclick="$('#description').hide();" id='hide_info'>X</div>
    <div id='conteiner_info'></div>
            
    </div>

<!--      <div id="info_tarif" align="left" class="events_info_block" style="display:none;position:absolute; top:47px;width:400px;z-index:10000;left:200px;">
            <p><font style="color:#dba108">Регулярность мониторинга:</font>  {$user->getTarifInfo()->period}</p>
            <p><font style="color:#dba108">Количество компаний в мониторинге(фактическое/максимальное):</font> {$user->getCountMon()}</p>


            <p><font style="color:#dba108">Срок активизации услуги:</font>
                <b></b> {$user->getTarifInfo()->getStartDateFormatted()} -

                {if $user->getTarifInfo()->endDateUser < $user->getTarifInfo()->endDateKurator}
                    {$user->getTarifInfo()->getEndDateKuratorFormatted()}
                {else}
                    {$user->getTarifInfo()->getEndDateUserFormatted()}
                {/if} ({$user->getActualTarifInfo()->m} {if $user->getActualTarifInfo()->m == 1}месяц{/if}{if $user->getActualTarifInfo()->m == 3}месяца{/if}{if $user->getActualTarifInfo()->m == 6}месяцев{/if}{if $user->getActualTarifInfo()->m == 12}месяцев{/if})
                <b></b>
   
            </div> -->
    <div class="main_top_text">
    <b>
        {breadcrumb controller="monitoring" alias="monitoring" altTitle="Мониторинг"}
        {*include file="lmenu.tpl"*}
        <div>
        {if $event->favorites==1}

          <a style="float:right" href="javascript:void(0)" class="m1" name='0' data='{$event->id}'>
              <img src="/img/star_event.png"> Удалить из избранного</a>
          {else}
 
            <a  style="float:right" href="javascript:void(0)" class="m1" name='1' data='{$event->id}'>
               <img src="/img/star_noevent.png"> Добавить в избранное</a>

        {/if}
      </div><br>
      </b> 
        <div id="t1">
          <p class="short_dt" style="display:none;"><strong>Дата события: <span style="color:#000">{$event->getEventDateFormatted()}</span></strong></p>
          <p class="company"><strong>{$event->getEventDateFormatted()}/</strong><span style="cursor:pointer;" ><font color="{if $event->getType()->id == 6}#ab8b00{/if}{if $event->getType()->id == 5}#528800{/if}{if $event->getType()->id == 4}#28754e{/if}">{$event->getType()->title|escape}</font>
               <span style="width:20px; height:20px;background-color:{if $event->getType()->id == 6}#ab8b00{/if}{if $event->getType()->id == 5}#528800{/if}{if $event->getType()->id == 4}#28754e{/if}">&nbsp;&nbsp;&nbsp;&nbsp;</span> </span></p>
          <p class="object_{$datas.date_monitoring}" {if ($datas.date_monitoring!=checked)} style="display:none;"{/if}><strong>Дата мониторинга: <span style="color:#000">{$event->getDateCreatedFormatted()}</span></strong></p>
          <p class="short_dt" style="display:none;"><strong>Тип события:</strong> <span style="cursor:pointer;" ><font color="{if $event->getType()->id == 6}#ab8b00{/if}{if $event->getType()->id == 5}#528800{/if}{if $event->getType()->id == 4}#28754e{/if}">{$event->getType()->title|escape}</font>
			         <span style="width:20px; height:20px;background-color:{if $event->getType()->id == 6}#ab8b00{/if}{if $event->getType()->id == 5}#528800{/if}{if $event->getType()->id == 4}#28754e{/if}">&nbsp;&nbsp;&nbsp;&nbsp;</span>	</span>
		    	</p>
            <div id="info_event" class="events_info_block" style="display:none;position:absolute; top:160px;width:350px;z-index:10000; left: 450px">
            <p> {$event->getType()->description|escape}</p>
            </div>
            <p><strong><span class="object_{$datas.name}" {if ($datas.name!=checked)} style="display:none;"{/if}>Наименование компании: </span><span class="company" {if ($datas.name==checked)} style="display:none;"{/if}>Компания: </span></strong> <a  target="_blank" href="/monitoring/eventc/{$event->getKontragent()->id|escape}">{$event->getKontragent()->title|escape}</a>  </p>
			<p class="object_{$datas.inn}" {if ($datas.inn!=checked)} style="display:none;" {/if}><strong>ИНН:</strong> {$event->getKontragent()->inn|escape} </p>
			<p class="object_{$datas.region}" {if ($datas.region!=checked)} style="display:none;" {/if}><strong>Регион:</strong> {$event->getKontragent()->region|escape}</p>

            <p class="object_{$datas.tarif}" {if ($datas.tarif!=checked)} style="display:none;" {/if}>Услуга: <span id="info" class="btn_tarif" val="{$user->getActualTarifInfo()->id}" 
                val2="{$user->getTarifId($user->getActualTarifInfo()->id)}">
              <strong>{$user->getCountMon() }-{$user->getTarifInfo()->m}-{$user->getActualTarifInfo()->period/7}</strong>

              </span></p>

            <p class="object_{$datas.desc}" {if ($datas.event!=checked)} style="display:none;" {/if}><strong>Описание события:</strong> {$event->content}</p>

            {if ($mas.first<>'false')}
          	 <a href="/monitoring/event/{$mas.first}" onClick="window.resizeTo(320,350)">пред.</a>
	    {/if}
	    {if ($mas.last<>'false')}
		 <a href="/monitoring/event/{$mas.last}" onClick="window.resizeTo(320,350)">след.</a>
	    {/if}
          <div style="float:right"><img id="drill_info" src="/images/red_down.png" data-id="hide" onClick="HideInfo()"></div>
        </div>

        <div class="dotted2">


        </div>
    </div>
</div>

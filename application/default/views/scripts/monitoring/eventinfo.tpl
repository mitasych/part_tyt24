{literal}
<script type="text/javascript">

   

    $('.btn_tarif').mouseout(function (){
                $('#description1').hide();
    });
    $('.btn_tarif').mouseover(function (kmouse){
            id = $(this).attr('val2');
            base_h = '50%';
            base_w = '50%';
            var id_el = '#description1';
                $.get('/monitoring/tarifinfo', {tarif_id : $(this).attr('val')}, function(data){
                    $('#conteiner_info').html(data);
                });
                $(id_el).css('top', base_h).css('left', base_w);
                $(id_el).show();        
        });   
    </script>
<style>
		#t1 strong{
			color:#1f5863;
		}
</style>
{/literal}

<div id="height_content">
<div>
    <div class="main_top_text">	
       <p><strong>Дата события  {$event->getEventDateFormatted()}</strong></p>
    {if $smarty.get.date_monitoring != 1}		
	<p><strong>Дата мониторинга: {$event->getDateCreatedFormatted()}</strong></p>
    {/if}
        {if $smarty.get.event != 1}
            <p ><strong>Тип события:</strong> <span style="cursor:pointer;" onmouseover="$('#info_event').show();" onmouseout="$('#info_event').hide();"><font color="{if $event->getType()->id == 6}#ab8b00{/if}{if $event->getType()->id == 5}#528800{/if}{if $event->getType()->id == 4}#28754e{/if}">{$event->getType()->title|escape}</font>
			<span style="width:20px; height:20px;background-color:{if $event->getType()->id == 6}#ab8b00{/if}{if $event->getType()->id == 5}#528800{/if}{if $event->getType()->id == 4}#28754e{/if}">&nbsp;&nbsp;&nbsp;&nbsp;</span>	</span>
			</p>
        {/if}
        {if $smarty.get.event != 1}
            <div id="info_event" class="events_info_block" style="display:none;position:absolute; top:135px;width:350px; z-index:10000; left: 30px">
            <p> {$event->getType()->description|escape}</p>
            </div>
        {/if}
        {if $smarty.get.name != 1}
            <p><strong>Наименование компании:</strong> {$event->getKontragent()->title|escape}</p>
        {/if}
        {if $smarty.get.inn != 1}
			<p><strong>ИНН:</strong> {$event->getKontragent()->inn|escape}</p>
		{/if}
        {if $smarty.get.region != 1}
        	<p><strong>Регион:</strong> {$event->getKontragent()->region|escape}</p> 
        {/if}               
			{*<p><strong>:</strong> {$event->getDateCreatedFormatted()}</p>*}
            <p><strong>Описание события:</strong>{$event->content}</p>
         {if $smarty.get.tarif != 1}   
            <p><strong>Услуга:        <span id="info" class="btn_tarif" val="{$user->getActualTarifInfo()->id}" 
                val2="{$user->getTarifId($user->getActualTarifInfo()->id)}">

              {$user->getCountMon() }-{$user->getTarifInfo()->m}-{$user->getActualTarifInfo()->period/7}

              </span></strong></p>
         {/if} 
    <div id="tarifs">

    </div>

    <div id="description1" style="display:hide; position:absolute;">
        <div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-right: -2px;" onclick="$('#description1').hide();" id='hide_info'>X</div>
         <div id='conteiner_info'>

        </div>         
    </div>

     </div>


        <div class="dotted2"></div>
    </div>
</div>

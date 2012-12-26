
<table cellpadding="5" cellspacing="5" border="1" id="tarif_grid" class="all_tarifs">
    <tr id="head" > 
    <td  rowspan="2" width="50"><b style="color:#dba108;">Количество компаний в мониторинге</b></td>
	<td colspan="3"> <b> <font style="font-size:14px;">Стоимость одного мониторинга, руб.</font> </b> </td>	 
    </tr>   
    <tr id="head" >
        <td id="period30" class="periods_" style="color:#DA114B"><b>30 дней</b></td>
        <td id="period90" class="periods_"><b>90 дней</b></td>
        <td id="period180" class="periods_"><b>180 дней</b></td>	
    </tr>
	
    {assign var='totalCount'  value=$user->getCountMon()}
	{assign var='next' value=`$current`}
	{assign var='prev' value=0 }
	{assign var='new_prev' value=0 }

 
	{* Текущий тариф  *}			
	{*if $showusertarif && $user->getActualTarifInfo()->getTarif()->num == $tarif->num}
		&nbsp;(<b>с</b> {$user->getActualTarifInfo()->getStartDateFormatted()} <b>по</b>

		{if $user->getActualTarifInfo()->endDateUser < $user->getActualTarifInfo()->endDateKurator}
			{$user->getActualTarifInfo()->getEndDateKuratorFormatted()}
		{else}
			{$user->getActualTarifInfo()->getEndDateUserFormatted()}
		{/if})
	{/if*}
	

	{*$refresh_period*} <br/>
    {*$show_cur_tarif*}
    {*$totalCount*}
	
	
	{*$id_tarif_check*}
	
	{*$countTarif*}
	{*$itemMain*}
    {foreach from=$tarifsList item=tarif key=key}
	{assign var='tarif_ID' value=`$id_tarif_check`}
    
	<tr id="item">
        <td>
		    { if ($key+1==$countTarif)} > {/if} 
		    
			 {$tarif->num}
			
		    { if ($key+1!=$countTarif)}
              <input type="hidden" name="sum{$tarif->num}" value="{$tarif->num}" />
			{else}
			  <input type="hidden" name="sum{$tarif->num+1}" value="{$tarif->num+1}" /> 
			{/if}
			
			{if ( ($prev==0) && ($show_cur_tarif>0) && ($totalCount!=$new_tarif_count) ) }
            
        	 {if $totalCount <= $tarif->num }
			   <div class="right_arrow"> </div> <div style="float:right;" > <b> Текущий тариф &nbsp; </b> </div> {math assign=prev equation="x+x" x=1 }
			 {/if}
			{/if} 
			
			
			{if ( ($new_prev==0) && ($show_new_tarif>0)) }
            
        	 {if $new_tarif_count <= $tarif->num }
			   <div class="green_arrow"> </div> <div style="float:right;" > <b> Новый тариф &nbsp; </b> </div> {math assign=new_prev equation="x+x" x=1 }
			 {/if}
			{/if} 			
			
        </td>
		
        <td align="left">		
		 {math assign=nfv_1 equation="ceil(x - y)" x=$tarif->pM y=$tarif->pM*$skidka/100}{$nfv_1|numberformat}

		{*<span class="between"  id="between_0" >
		 {math assign=nfv equation="ceil(x - y)" x=$itemMain y=$nfv_1  }
		 {$nfv|numberformat}
		</span>	*}	
		</td>
		
        <td align="left">
		
		 {math assign=nfv_2 equation="ceil(x - y)" x=$tarif->pK y=$tarif->pK*$skidka/100}{$nfv_2|numberformat}
         
		{*<span class="between"  id="between_1" >
		 {math assign=nfv equation="ceil(x - y)" x=$itemMain y=$nfv_2 }
		 {$nfv|numberformat}
		</span> *}	 		 
		</td>
        <td align="left">
		
		 {math assign=nfv_3 equation="ceil(x - y)" x=$tarif->pH y=$tarif->pH*$skidka/100}
		 {$nfv_3|numberformat}
		 
        {*<span class="between" id="between_2" >
		 {math assign=nfv equation="ceil(x - y)" x=$itemMain y=$nfv_3 }
		 {$nfv|numberformat}
		</span>  		 
		</td>
		
       {* <td align="right">{if $form}{form_radio name='m' value="`$tarif->id`-12" checked=""}{/if}{math assign=nfv equation="ceil(x - y)" x=$tarif->pY y=$tarif->pY*$skidka/100}{$nfv|numberformat}</td>*}
    </tr>
    {/foreach}
	
	{*$checked_period*} 
		
</table>
<div style="background-color:#FFE9AE;">
<div style="color:#1f5863;margin-top:5px;margin-bottom:4px;"><b>Выбор тарифа:</b> <span style="background-color: #DA114B;padding: 3px;border-radius: 3px;color: white;" id="new_name_tarif">0</span></div>
<font color="#1f5863">Срок мониторинга:</font>
{if $checked_period=="first"}
       <label><input type="radio"  name='m' value="{$tarif_ID}-1" checked cou='30' /> 30 дней</label>
       <label><input type="radio"  name='m' value="{$tarif_ID}-3"  cou='90'  />  90 дней</label>
       <label><input type="radio"  name='m' value="{$tarif_ID}-6"  cou='180'  /> 180 дней</label>
	  {else}
	  
	   {assign  var='value_1' value=$tarif_ID|string_format:'%s-1' }
	   {assign  var='value_2' value=$tarif_ID|string_format:'%s-3' }
	   {assign  var='value_3' value=$tarif_ID|string_format:'%s-6' }
	   
       <label><input type="radio"  name='m' value="{$tarif_ID}-1" checked {if $checked_period==$value_1 } checked {/if} cou='30'  />  30 дней</label>
       <label><input type="radio"  name='m' value="{$tarif_ID}-3" {if $checked_period==$value_2 } checked {/if} cou='90'  />   90 дней</label>
       <label><input type="radio"  name='m' value="{$tarif_ID}-6" {if $checked_period==$value_3 } checked {/if} cou='180'  />  180 дней</label>
	  {/if}
</div>
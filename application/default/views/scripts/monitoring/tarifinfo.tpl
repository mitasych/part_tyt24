
<p class="infotarifp">
	<font class='desc_tar'>Регулярность мониторинга: </font>
	<span id='reg' > {$tarif->period}</span> дн.
</p>
<p class="infotarifp">
	<font class='desc_tar'>Компаний в мониторинге (фактически/максимум):</font>  <br>
	<span id='count_kontr'> {$count_kontr}</span>/<span id='count'>{$tarif->count} </span>
</p> <br>
<p class="infotarifp">
	<font class='desc_tar'>Период действия (срок):</font><br>
	<span id='timefor' >{$tarif->startDate|date_format:"%d-%m-%Y"} - {$tarif->endDateUser|date_format:"%d-%m-%Y"} </span> (<span id='time'> {$tarif->m}</span> дн.)
</p><br>
<p class="infotarifp">
	<font class='desc_tar' >Дата последнего/cледующего мониторинга:</font><br>
	<span id='dateend' > {$tarif->dateEndMon|date_format:"%d-%m-%Y"}/{$dateNextMon|date_format:"%d-%m-%Y"}</span>
</p><br>
<p class="infotarifp">
	<font class='desc_tar'>События, доступные в данном тарифе:</font> <br>
	<span id='event' >{$event} </span><br>
</p><br>
<p class="infotarifp">
	<font class='desc_tar'>Информация:</font>
	<span id='info'> {$tarif->getTarifAll()->about}</span>
</p>
<p class="infotarifp">
	
	<span id='info'><font class='desc_tar'>Страна:</font>   {if $tarif->getCountry()==258}Россия {else} Украина {/if}  <img src="/images/{$tarif->getCountry()}.gif"> </span>

</p>

<p class="infotarifp">
	<font class='desc_tar'>Дата последнего события:</font> <br>
	<span id='dateendevent'> {if $tarif->getLastEvent()->getEventDateFormatted() == '01-01-1970'} &nbsp; {else}<a href="/monitoring/event/{$tarif->getLastEvent()->id}/">{$tarif->getLastEvent()->getEventDateFormatted()}({$tarif->getLastEvent()->getType()->title})</a>{/if}</span>
</p><br>
<p class="infotarifp"  style="width:100%;float:left;"><font class='desc_tar'>Стоимость тарифа :</font> <span id='price'> {$price}</span> руб. </p>

{literal}

    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['imagechart']});
    </script>
    <script type="text/javascript">

      function drawVisualization() {
       a = $("#allinfo").data("first");
       b = $("#allinfo").data("second");
       c = $("#allinfo").data("thirst");
        var data = google.visualization.arrayToDataTable([
          ['', '', ''],
          ['', a, true],
          ['', b, false],
          ['', c, true]
        ]);
        var options = {
                  width:150, height:70,
                };
        options.cht = 'bhg';
        var min = 0;
        var max = 100;
        options.chds = min + ',' + max;
        var meters = 'N** ';
        var color = 'ff3399';
        var index = 0;
        var allbars = -1;
        var fontSize = 10;
        var priority = 0;
        options.chm = [meters, color, index, allbars, fontSize, priority].join(',');
        new google.visualization.ImageChart(document.getElementById('visualization')).
          draw(data, options);
      }
      google.setOnLoadCallback(drawVisualization);
    </script>

    <script type="text/javascript">


          google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        data = [
        ["месяц","суд", "егрюл", "банкротство","всего"],
        [1,0,0,0,0],
        [2,0,0,0,0],
        [3,0,0,0,0],
        [4,0,0,0,0],
        [5,0,0,0,0],
        [6,0,0,0,0],
        [7,0,0,0,0],
        [8,0,0,0,0],
        [9,0,0,0,0],
        [10,0,0,0,0],
        [11,0,0,0,0],
        [12,0,0,0,0],
        ];
        var i=0;
       
      $(".jud").each(function () {
            i++;
            data[i][1] = parseInt($(this).attr('data'));

      });

      var j=0;

      $(".egrul").each(function () {
            j++;
      
           data[j][2] =  parseInt($(this).attr('data'));


      });
      
      n=0;
      
      $(".bank").each(function () {
            n++;
            data[n][3] = parseInt($(this).attr('data'));

      });
      
      k=0;
      
      $(".all_d").each(function () {
            k++;
              
            data[k][4] = parseInt($(this).attr('data'));
      });




        var data = google.visualization.arrayToDataTable(data);

        var options = {
          title: 'График'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }













    </script>



<script type="text/javascript">
var change_tr_arr = []
function change_tr(id){
	if(change_tr_arr[id] == undefined || change_tr_arr[id] == false){
		$(".all_tarifs .mon_stat[m_id='"+id+"']:not(.no_change)").css('background-color','#ffe9ae');
		change_tr_arr[id] = true;
	}else{
		$(".all_tarifs .mon_stat[m_id='"+id+"']:not(.no_change)").css('background-color','#fff');
		change_tr_arr[id] = false;
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
			<div style="float:left">
			{section name=foo start=$year_begin loop=$year_end step=1}           
             { if (($statY[$smarty.section.foo.index]==7)) }
				<a style="color:red" href="/monitoring/statistics/year/{$smarty.section.foo.index}/">{if $smarty.section.foo.index ==  $year}<b>{$smarty.section.foo.index}</b>{else}{$smarty.section.foo.index}{/if}</a>		
            {else} 
               {$smarty.section.foo.index}
            {/if} 
       {/section}
				<a style="color:red" href="/monitoring/statistics/year/{$year_end}/">{if $year_end ==  $year}<b>{$year_end}</b>{else}{$year_end}{/if}</a>
			</div>			
			<p>
        <br><br>
        {if $year}
        {assign var="s2" value=0}
        {assign var="s3" value=0}
        {assign var="ss" value=0}
        {assign var="se" value=0}
        {assign var="sb" value=0}
<p>
 <b style="color:#1f5863">Типы событий :</b>
  <span style="width: 20px; height: 20px; background-color: rgb(82, 136, 0)">    </span>
  <b style="color:#528800">суд</b>
  <span style="width: 20px; height: 20px; background-color: rgb(171, 139, 0)">    </span>
  <b style="color:#ab8b00">егрюл</b>
  <span style="width: 20px; height: 20px; background-color: rgb(40, 117, 78)">    </span>
  <b style="color:#28754e">банкротство</b>
</p><table class="all_tarifs" cellpadding="0" cellspacing="0">
            <tr id="head" >
                <td style="text-align:left;font-weight: normal;"><b>Месяц</b><br>Дата мониторинга</td>
                <td><b>Всего событий (по типам)</b></td>
                <td ><b>Тарифы</b></td>
                <td><b>События/Компании</b></td>
                <td ><b>Событий на 1 компанию</b></td>
                <td> График </td>     
            </tr>
			{assign name="i" value="0"}		
            {foreach from=$stat key=mk item=mi}
			
            <tr class='mon_stat {if count($mi.tarifs ) == 0}no_change{/if}' m_id='{$mk}' onclick="change_tr({$mk})" style='{if $i == 1}background-color:#f2f2f2;{assign name="i" value="0"}{else}{assign name="i" value="1"}{/if}' >

                <td class="odd" style="text-align:left;height: 30px;{if count($mi.tarifs ) == 0}color:gray{/if}">
                  <b>{$MonthNames.$mk}</b></td>
			<td id="allinfo" data-first="{$mi.count.0}" data-second="{$mi.count.1}" data-thirst="{$mi.count.2}"    
        style="{if count($mi.tarifs ) == 0}color:gray{/if}">

        <b> <span class="all_d" data="{$mi.allcount}">{$mi.allcount} </span>(<font class="jud" data="{$mi.count.0}" color="#528800">{$mi.count.0}</font> / <font class="egrul" data="{$mi.count.1}" color="#AB8B00">{$mi.count.1} </font> / <font class="bank" data="{$mi.count.2}" color="#28754E">{$mi.count.2}</font> )</b>

      </td>
				<td class="odd" style="{if count($mi.tarifs ) == 0}color:gray{/if}">
					<b>{foreach from= $mi.tarifs|@array_unique item=tarif}
						{$tarif} &nbsp;
					{/foreach}</b>
				</td>

                <td>    {if $mi.count.count!=0}
                      {$mi.allcount}/{$mi.count.count}
                      {/if}
                </td>

                <td>  
                    {if $mi.count.count!=0}
        

                    {math equation="x / y" x=$mi.allcount y=$mi.count.count format="%.1f"} 
                    {/if}

                     </td>

                     <td>
                          {if $mi.count.count!=0}
                         <div onLoad="drawVisualization()" id="visualization" style="width: 150px; height: 70px;"></div>
                          {/if}
                     </td>
            </tr>
			
		
			
            {assign var="s3" value=$s3+$mi.allcount}

            {assign var="ss" value=$ss+$mi.count.0}

            {assign var="se" value=$se+$mi.count.1}
            {assign var="sb" value=$sb+$mi.count.2}
				{assign name="i" value="0"}
				
                {*$mi.points[8].tarif*}

                

				{foreach from=$mi.points key=key item=point}
					{if $point.count > 0}
					 <tr class='point_stat' m_id='{$mk}' style='{if $i == 1}background-color:#f2f2f2;{assign name="i" value="0"}{else}{assign name="i" value="1"}{/if}'>
						<td style="text-align:left;color:#1f5863;">&nbsp;&nbsp;&nbsp;{$key}-{$mk}-{$year}</td>
						<td>{$point.count} (<font color="#528800">{$point.count_s}</font> / <font color="#AB8B00">{$point.count_e}</font> / <font color="#28754E">{$point.count_b}</font>)</td>
						<td class="odd" >{$point.tarif}</td>
					</tr>
					{/if}
				{/foreach}
			
            {/foreach}
            <tr id="bottom">
                <td style="font-size:13px;text-align:left;"><b>ИТОГО ({$year})</b></td>
                <td  style="font-size:13px;"><b>{$s3} (<font color="#528800">{$ss}</font> / <font color="#AB8B00">{$se}</font> / <font color="#28754E">{$sb}</font> )</b></td>
                <td></td>
                 <td></td>
                  <td></td>
                   <td></td>
            </tr>
            </table>
        {/if}
		
		
		


        </div>
		{literal}
		<script type='text/javascript'>
			$(document).ready(function(){
				$('tr.point_stat').hide();
				$('tr.mon_stat').toggle(function(){
					$('tr.point_stat[m_id="'+$(this).attr('m_id')+'"]').show();
				},
				function(){
					$('tr.point_stat[m_id="'+$(this).attr('m_id')+'"]').hide();
				});
			});
		</script>
		{/literal}

        <div class="dotted2">



             <div id="chart_div" style="width: 900px; height: 500px;"></div>


        </div>
    </div>
</div>

{literal}
<script type="text/javascript">


    function confirmDelete() {
    if (confirm("Вы подтверждаете удаление?")) {
        return true;
    } else {
        return false;
    }
}



var filter_all="off";
   function checkbtn() {
        if ($('#country').val() == 'RU' && $('#checkinn').val().length ) {
            $('#checkinnbtn').show();
        } else {
            $('#checkinnbtn').hide();
        }
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
	        if (!$("#hide_country").attr('checked')){
      		  setTimeout( function (){$("#hide_country").click(); 
               $('#show_country').removeAttr( 'checked');
               }, 2000) ;
 		   }

         if (!$("#hide_title").attr('checked')){
        setTimeout( function (){$("#hide_title").click(); 
               $('#show_title').removeAttr( 'checked');
                     }, 2000) ;
    }

             if (!$("#hide_reg_date").attr('checked')){
        setTimeout( function (){$("#hide_reg_date").click(); 
               $('#show_reg_date').removeAttr( 'checked');
                     }, 2000) ;
    }

                 if (!$("#hide_otrasl").attr('checked')){
        setTimeout( function (){$("#hide_otrasl").click(); 
               $('#show_otrasl').removeAttr( 'checked');
                     }, 2000) ;
    }


             if (!$("#hide_rykov").attr('checked')){
        setTimeout( function (){$("#hide_rykov").click(); 
               $('#show_rykov').removeAttr( 'checked');
                     }, 2000) ;
    }



             if (!$("#hide_adress").attr('checked')){
        setTimeout( function (){$("#hide_adress").click(); 
               $('#show_adress').removeAttr( 'checked');
                     }, 2000) ;
    }


    if (!$("#hide_region").attr('checked') ) {
        setTimeout( function (){$("#hide_region").click(); 
               $('#show_region').removeAttr( 'checked');
                     }, 2000) ;
    }


        if (!$("#hide_country").attr('checked')){
        setTimeout( function (){$("#hide_country").click(); 
               $('#show_country').removeAttr( 'checked');
                     }, 2000) ;
    }



     if (!$("#hide_inn").attr('checked')){
        setTimeout( function (){$("#hide_inn").click(); 
               $('#show_inn').removeAttr( 'checked');
                     }, 2000) ;
    }

             if (!$("#hide_event").attr('checked')){
        setTimeout( function (){$("#hide_event").click(); 
               $('#show_event').removeAttr( 'checked');
                     }, 2000) ;
  			}



	 		 $('#filter_all').click(
	 		 	function(){
	 		 		$('.main_t').removeClass("active");
	 		 		$('.submain_t').removeClass("active");
	 		 		$('#tarifs span').show();
	 		 		$('#change_tarif').show();
	 		 		
	 		 	}	
	 		 	
			);
	$('.btn_tarif').mouseout(function (){
				$('#description').hide();
	});
	$('.btn_tarif').mouseover(function (kmouse){
			id = $(this).attr('val2');
			base_h = kmouse.pageY - 430;
			base_w = kmouse.pageX - 300;
			var id_el = '#description';
				$.get('/monitoring/tarifinfo', {tarif_id : $(this).attr('val')}, function(data){
					$('#conteiner_info').html(data);
				});
				$(id_el).addClass('events_info_block');
				$(id_el).css('top', base_h).css('left', base_w);
				$(id_el).show();		
		});		

	$('.show_tarif').mouseout(function (){
				$('#description').hide();
	});
	$('.show_tarif').mouseover(function (kmouse){
			id = $(this).attr('val2');
			base_h = kmouse.pageY - 430;
			base_w = kmouse.pageX - 300;
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
		$('#rightcomp').removeAttr("class");
		$('#rightcomp').attr('class','rightcomp_disact');
		$('.rightcomp_act').removeAttr('class').attr('class','rightcomp_disact');
		$('.submain_t').removeClass("active");
		$(this).addClass('active');
		$(this).next('#rightcomp').attr('class','rightcomp_act');
		$('.submain_t[val2="'+$(this).attr('value')+'"]').show();
		$('.submain_t[val2="'+$(this).attr('value')+'"]:first').click();
		if ($(this).attr('id')!='filter_all'){$('select[name=tarif_id_one]').val('');$('#change_tarif').hide();}
	});
	
		
	$('.submain_t').live('click',function(){
		$('.submain_t').removeClass("active");
		$(this).addClass('active');
		$('#tarifs span').hide();
		$('#tarifs span[parent='+$(this).attr('value')+']').show();
		return false;
	});
	$('#active').click();
		 $("#mail_change").click(function(){
			  $("#mails").show();
			  $("#saved").hide();
			  $("#mail_change").hide();
			  $("#mail_hide").show();			
		  return false;
		 });
		$("#mail_hide").click(function(){
			  $("#mails").hide();
			  $("#saved").hide();
			  $("#mail_change").show();
			  $("#mail_hide").hide();			
		  return false;
		 });

		$("#save_mail").click(function(){
			if($(this).attr('data-id')==1){
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
					$("#save_mail").attr('data-id','0');
				  }					  
				});	  
        			
		  	}}

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
	</script>
{/literal}
<div align="left" id="formEdit" class="events_info_block" style="display:none; position:absolute; left:350px; top:400px; z-index:10000; padding-left:30px">
	<div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-top: -5px;" onclick="$('#formEdit').hide();">X</div>
	<form method="post" action="">
		<span class="check_exel"><input type="checkbox" name="copy" id="form_copy"> <label class="style_input" for="form_copy">Копировать в новую услугу:</lable></span><br>
		<label  class="style_input">ИНН:<br>
		<input id='inn_ed' type="text" name="inn" readonly ></label><br><br>
		<label class="style_input">Названия:<br>
		<input id='name_ed' type="text" name="title"></label><br><br>
		<label class="style_input">Регион:<br>
		<input id='reg_ed'  type="text" name="region" readonly ></label><br><br>
		<label  class="style_input">Адрес:<br>
		<input id='address_ed' type="text" name="inn" readonly ></label><br><br>
		<label class="style_input">ФИО директора:<br>
		<input id='fio_ed' type="text" name="title"></label><br><br>
		<label class="style_input">Отрасль:<br>
		<input id='otrasl_ed'  type="text" name="region" readonly ></label><br><br>
		<div class="style-select" style="width: 100px;">                     
                     <select name="k_id" style="width: 140px;">
                     	<optgroup>
						{foreach from=$userTarifs item=item}
							<option value="{$item->id}" >{$item->count}-{$item->m}-{$item->period}</option>
						{/foreach}
						</optgroup>
					</select>
		</div>	<br>
		<input  type="hidden" id="hid_id" name="hid_id" value="">	
		<span id="addx3">
		<input type="submit" class="file_input_button" value="Сохранить изменения"></span><br>
	</form>
	<div class="show_tarif" style="float:right;cursor:pointer;position:relative;bottom:5px;right:5px;"  val="{$user->getActualTarifInfo()->id}" val2="{$user->getTarifId($user->getActualTarifInfo()->id)}"><img class="db_note" src="/img/db_info.png"></div>
</div>




<div id="description" style="display:none; position:absolute; width:470px;">
	<div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-right: -2px;" onclick="$('#description').hide();" id='hide_info'>X</div>
	<div id='conteiner_info'></div>
			
</div>



<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

<div>
    <div class="main_top_text">

        {breadcrumb controller="monitoring" alias="monitoring" altTitle="Мониторинг"}
        {include file="lmenu.tpl"}

        <h1>{info name="monitoringlist" what="title"}</h1>
        <p>{info name="monitoringlist"}</p>
		
		
	

        <div>

			<form action="" method="post" name="check_tarifs" id="check_tarif" > 
	
			<p>
			<div>
			<span class='main_t ' name="allTarif" id='filter_all' style="cursor:pointer;"  onClick="doSearch(arguments[0]||event);filter_all='on'; $('#hide_country_radio').show();">Все услуги</span><span id="rightcomp" class="rightcomp_disact"></span>
			{foreach from=$type item=typ}

			{if ($typ->id==$user->getCountMon1()->all_id)}
				<span class='main_t active' id="active" onmouseover="$('#InfoCompany_{$typ->id}').show();" onmouseout="$('#InfoCompany_{$typ->id}').hide();" style="cursor:pointer;" value={$typ->id}>{$typ->name}</span><span id="rightcomp" class="rightcomp_act"></span>
				{/if}
			{if ($typ->id!=$user->getCountMon1()->all_id)}
				<span class='main_t' style="cursor:pointer;" onmouseover="$('#InfoCompany_{$typ->id}').show();" onmouseout="$('#InfoCompany_{$typ->id}').hide();" value={$typ->id}>{$typ->name}</span><span id="rightcomp" class="rightcomp_disact"></span>
				{/if}
				<div align="left" id="InfoCompany_{$typ->id}"  class="events_info_block" style="display:none; position:absolute; {if $typ->id==1}left:400px;{/if}{if $typ->id==2}left:550px;{/if}{if $typ->id==3}left:700px;{/if} top:95px; z-index:10000;">
					<b>{$typ->about}</b>
				</div>
			{/foreach}
			
			</div><br><br>
			<div style="padding:3px;margin-top:5px;">
			{foreach from=$tarif item=tar}
				{if $tar->name != ''}
					<span class='submain_t' style="padding:2px;cursor:pointer;" val2='{$tar->type}' value="{$tar->id}">{$tar->name}</span>
				{/if}
			{/foreach}
			</div><br>
			{*<span class='submain_t' val='all'></span> *}
            			

            {*form_select name="period" options=$periodList selected=$user->getActualTarifInfo()->period*}		
            {*form_submit name="refresh" value="Пересчитать услугу" style="margin:0;padding:0;"*}


	        <input type="hidden" name="userPeriod" value="{$show_cur_tarif}" />  
         	<input type="hidden" name="countTarif" value="{$countTarif}" /> 
	        <input type="hidden" name="currentTarif" value="{$user->getCountMon() }" /> 
	        <input type="hidden" name="currentPeriod" value="{$user->getActualTarifInfo()->m }" /> 
			
	        <input type="hidden" name="newTarifPeriod" value="{$new_tarif_period}" /> 			
	        <input type="hidden" name="showNewTarif" value="{$show_new_tarif}" />
	        <input type="hidden" name="newTarifCount" value="{$new_tarif_count}" />
	        <input type="hidden" name="showTarifCount" value="{$show_tarif_count}" />
			<input type="hidden" name="min" value="{$min_for_mon}" />
			<input type="hidden" name="price_one" value="" />
    		<input type="hidden" name="between_residue" value="{$total_between}" />
			<input type="hidden" name="between" value="" />
			<input type="hidden" name="residue_minus" value="" />			
			
			
			 
					
			{if count($userTarifs) > 0}
			<div id="tarifs" style="float:right;margin-bottom:5px;text-align:right;">
			Активные услуги: {foreach from=$userTarifs item=item}
			{if $item->count==$user->getCountMon()}
			  <span onclick="{if $item->tarifId ==$current_mon_tarif}$('#info_tarif').toggle();return false;
			{else}$('#all_input_t').val('{$item->tarifId}');$('#check_tarif').submit();return false;
			{/if}" class="btn_tarif_{$item->tarifId} btn_tarif" style="cursor:pointer; " id="btn_active" parent='{$item->all_id}' val='{$item->id}' val2='{$item->tarifId}'>{$item->count}-{$item->m}-{$item->period}</span>
				{/if}
			{if $item->count!=$user->getCountMon()}
			  <span onclick="{if $item->tarifId ==$current_mon_tarif}$('#info_tarif').toggle();return false;
			{else}$('#all_input_t').val('{$item->tarifId}');$('#check_tarif').submit();return false;
			{/if}" class="btn_tarif_{$item->tarifId} btn_tarif" style="cursor:pointer; " parent='{$item->all_id}' val='{$item->id}' val2='{$item->tarifId}'>{$item->count}-{$item->m}-{$item->period}</span>
				{/if}
			{/foreach}
			</div>
			{/if}


			<br><br>
			<div align="right">
			<a class="l1" href="#" onClick="javascript:$('#full_search').toggle();$('#add_comp_monitoring').hide();acol('.l1');return false;" style="color:#DA114B;">Найти компанию</a>{if $kc != $user->getCountMon()} | <a class="l2" href="#" onClick="javascript:$('#add_comp_monitoring').toggle();acol('.l2');$('#full_search').hide();return false;" style="color:#da114b">Добавить компанию</a>{/if}
			</div>
		
			<input type="hidden" name="all_tarifs" value="{ $current_mon_tarif }" id="all_input_t"/>
			</form> 
			
            </p>
			<br/>
            <form name="addcompany" action="" method="POST" enctype='multipart/form-data'>
            {*form from=$form enctype="multipart/form-data" action="/monitoring/list"*}
            {*form_errors_summary*}
            {*form_hidden name="mid" value=$fparams.mid*}
            {*form_hidden name="region" value=$fparams.region*}
				<input type="hidden" name="mid" value="{ $fparams.mid }" >
				<input type="hidden" name="region" value="{ $fparams.region }" >
				<input type="hidden" name="userid" value="{$user->id}" >
			

			
			
			<div  id="add_comp_monitoring" style="display:none;margin-top:-80px;">
			<!-- <font color="#1F5763">Добавление компании:</font><br> -->
            <p>
            <table>
	            <tr style="font-weight:bold; font-size:15px; line-height:28px;">
	            	<td>Добавить компанию:</td>
	            </tr>	
	            <tr>
	                <td><span class="check_exel"><input onclick="{literal}if (this.checked){$('.add_company').hide();$('#addxl').show();} else {$('#addxl').hide();$('.add_company').show();}{/literal}" id="checkbox_id" type="checkbox"/> <label color="#1F5763" for="checkbox_id">Добавить в список мониторинга из Excel</lable></span></td>
	            </tr> 
             </table>

            <div id="change_tarif" style="display:none;">
              <label style="float:left;line-height:28px;margin-right:5px;"><b>Текущая услуга: </b></label>
            	<div class="style-select" style="width: 100px; margin-bottom:10px;">                     
                     <select name="tarif_id_one" style="width: 140px;">
                     	<optgroup>
						{foreach from=$userTarifs item=item}
							<option value="{$item->id}">{$item->count}-{$item->m}-{$item->period}</option>
						{/foreach}
						</optgroup>
					</select>					
				</div>
			</div>

                    <div class="add_company">
                    		<span class="style_input" style="float:left;margin-top:5px;margin-right:5px;"><input type="text"  id="checkinn" name="inn_one" placeholder="ИНН/ЕДРПОУ" value="{$fparams.inn}"  style="width: 100px;"></span>
                        
                        {*form_text placeholder="ИНН" id="checkinn" name="inn_one" onkeyup="checkbtn();" value=$fparams.inn style="width: 100px;"*}
                    
                      	<span class="style_input" style="float:left;margin-top:5px;margin-right:5px;"><input type="text" name="title_one" placeholder="Наименование" value="{$fparams.title}"  style="width: 190px;"></span>
                      
                        &nbsp;{*form_text *}
              
          
                    <input style="margin-top:-10px;" type="submit" name="submitb" class="submit_monitoring"  value="">
                </div>
							<div id="addxl" style="display:none;">

								<span class="style_input"> <input type="text" id="fileName" class="file_input_textbox" ></span>

								 <span class="file_input_div">
								      <input type="button" value="Обзор..." class="file_input_button" onClick="$('.file_input_div input[type=file]').click();">
								      <input type="file"  name="csv" style="display:none" class="" onchange="javascript: document.getElementById('fileName').value = this.value;$('#addx2').show();" />
								 </span><br>
								 <font id="addx3" style="font-size:11px;color:#666666">Здесь можно добавить список контрагентов из файла в формате .CSV (Excel). Данные в файле должны располагаться 	в следующем порядке: ИНН, Наименование, Страна, при этом поле Страна необязательное</font>
								</div>
								<span id="addx2" style="display:none;">
									<input type="submit" value="Импортировать список">
								</span>
					
			
                        {*form_submit id="checkinnbtn" name="ok" value="Проверить на наличие в ЕГРЮЛ" style="margin:0;padding:0;width: 265px;"*}
                  
{if $cres}<div><br>{$cres}<br></div>
{/if}

			
			
            </p>
            {*/form*}
        </form>
		<br>
		</div>
			<h3 style="color:#ff9a31;margin-bottom: 5px;text-transform:uppercase;"><b>Список контрагентов для мониторинга ({$kc} из {$user->getCountMon() })</b></h3>
			<div id="full_search" style="display:none;">
				<form name="SearchCompany">
			
				<table>
					<tr>
						<td>
							<font style="font-size:13px;font-weight:1000;"><b>Поиск:</b></fotn>
						</td>						
						<td align="right">
							{if $countTarif>1} 
							<span class="check_exel"><input type="checkbox" name="allTarif" id='filter_all1' onchange="doSearch(arguments[0]||event)"> <label color="#1F5763" for="filter_all1">Искать по всем услугам</lable>								
							</span>
							<!-- <input type="checkbox" id="show_country" value="Странa"> -->
							{/if}
						</td>
						<td>
						<span class="check_exel"><input type="checkbox" name="fav_com" id='fav_com' onchange="doSearch(arguments[0]||event)" > <label color="#1F5763" for="fav_com">Помеченные компании</lable>								
							</span>
						</td>
						<td>
						</td>
					</tr>
					<tr>
						<td class="style_input">
							
							<input name='filter_name' placeholder="Наименование" id='filter_name' type='text' value='{$filter_name}' onkeydown="doSearch(arguments[0]||event)">
						</td>
						<td class="style_input">
							
							<input name='filter_inn' placeholder="ИНН/ЕДРПОУ" id='filter_inn' type='text' value='{$filter_inn}' onkeydown="doSearch(arguments[0]||event)">
						</td>
						<td>
							<div class="style-select" style="width: 300px;"> 
								<select name='filter_region' style="width: 340px;" id='filter_region' onChange="doSearch(arguments[0]||event)">
									<optgroup>
									<option value='0' {if $filter_region == '0'}selected{/if}>Выберите регион</option>
									{foreach from=$regions item=reg}								
									<option value='{$reg.region}' {if $reg.region==''}style='display:none;' {/if}{if $reg.region<>''}{if $filter_region == $reg.region}selected{/if}{/if}>{$reg.region}</option>
									{/foreach}
								</optgroup>
								</select>
							</div>
						</td>
						
						<td>
							<a href="#"   onClick='javascript:document.forms.SearchCompany.reset(); doSearch(arguments[0]||event); return false'><img src="/images/clear_form.png" style="margin-top:-2px;"></a>
						</td>
					</tr>

				</table>
				<br>
			</form>
			</div>

			
			
			<form action='' method=post>
			{literal}
			<script type="text/javascript" src="/scripts/tablesortet/jquery.tablesorter.js"></script>

			
			{/literal}
			
				<table id="bigset" style="width: 100%;">

				</table>
            <div id="pagerb"></div>


           
 {literal}
 
            <script src="/scripts/js/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
            <script src="/scripts/js/jquery.layout.js" type="text/javascript"></script>
            <script src="/scripts/js/i18n/grid.locale-ru.js" type="text/javascript"></script>

            <link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/redmond/jquery-ui-1.8.2.custom.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/ui.jqgrid.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/ui.multiselect.css" />
			<script src="/scripts/js/ui.multiselect.js" type="text/javascript"></script>
            <script src="/scripts/js/jquery.jqGrid.js" type="text/javascript"></script>
   
        
            <style type="text/css">
                .searchFLD {
                    width:100px;
                    
                }
            </style>
            <script type="text/javascript">
              $("#hide_country").live('click',function() {     
                     $("#hide_country").attr('id','show_country');
                     jQuery("#bigset").jqGrid('hideCol','country');
                      });


                   $("#show_country").live ('click' ,function() {
                     $("#show_country").attr('id','hide_country');
                     jQuery("#bigset").jqGrid('showCol',"country");
                    });


            	         $("#m1").live("click", function() {
                         var s;
                         s = jQuery("#bigset").jqGrid('getGridParam','selarrrow');
                         if (s[0] ==  undefined)
                         s.shift();
                   
                      	
                         jQuery.post("/monitoring/kontrdata", { delItem: s } );

                            $("input:checkbox").removeAttr("checked");
                             gridReload();
                            window.location = "/monitoring/list/"
   							
                        });

            	        $("#addgroup").live("click", function() {
                         var s,t;
                         t = $('#tar_id').val();
                         c =  $("#is_copy").attr("checked");

                         s = jQuery("#bigset").jqGrid('getGridParam','selarrrow');
                         if (s[0] ==  undefined)
                         s.shift();
                   
                      	
                         jQuery.post("/monitoring/kontrdata", { addItem: s, 'is_copy': c, 'tarifId': t } );
           
                          //  $("input:checkbox").removeAttr("checked");
                             gridReload();
                            window.location = "/monitoring/list/"
   							
                        });

            	
            	$("#filter_all1").change(function () {
				if ($(this).attr("checked")) {
					filter_all='on';
					$('#change_tarif').show();
				} else {
					filter_all='off';
					if ($('#filter_all').attr('class')!='main_t active'){
						$('select[name=tarif_id_one]').val('');
						$('#change_tarif').hide();

					}
				}
				}); 


                $.jgrid.no_legacy_api = true;
                $.jgrid.useJSON = true;
             setTimeout(function(){
			 jQuery("#bigset").jqGrid({
                url:'/monitoring/kontrdata/?tarif={/literal}{$current_mon_tarif}{literal}',
                datatype: "json",
               	height: 100+"%",
                width: 90+"%",
                colNames:['','№', 'Наименование', 'ИНН/ЕДРПОУ', 'Регион','События','Страна','Адрес',
                'Фио директора','Дата регистрации','Отрасль', 'Действия'],
                    colModel :[
						
                         {name:'favorites', index:'favorites',align:'center',width:40},
						{name:'number',index:'n',width:20,align:'center'}
                        ,{name:'title', index:'B.title',  align:'left'}
                        ,{name:'inn', index:'inn',width:60}
                        ,{name:'region', index:'B.region',  align:'center'}
                        //
                        ,{name:'event', index:'event',width:60,  align:'left'}
                        ,{name:'country', index:'country',align:'center',width:80}
                        ,{name:'adress', index:'adress',align:'center',width:80}
                        ,{name:'rykov', index:'rykov',align:'center',width:80}
                        ,{name:'reg_date', index:'reg_date',align:'center',width:80}
                        ,{name:'otrasl', index:'otrasl',align:'center',width:80}
                        
                       ,{{/literal} name:'action',index:'action',width:80,  align:'center', sortable:false{literal}}
                        ],
             {/literal}   rowNum:20,
             autowidth: true,
                        rowList:[20,30,40],
                mtype: "POST",
                pager: jQuery('#pagerb'),
                pgbuttons: true,
                pgtext: false,
                pginput:false,
                multiselect: true,
                sortname: 'B.title',
                    sortorder: "desc",         
                    viewrecords: true,{literal}
                    //tarif: {/literal}{$current_mon_tarif}{literal},
              
                        });
						}, 2000);
                        var timeoutHnd;
                        var flAuto = true;

                        function doSearch(ev){
                if(!flAuto)
                    return;
                        //	var elem = ev.target||ev.srcElement;
                if(timeoutHnd)
                    clearTimeout(timeoutHnd)
                timeoutHnd = setTimeout(gridReload,300)
                        }

                        function gridReload(){
                        
                        
                     

                var search_innnaim_mask = jQuery("#search_innnaim").val();
                var kontragrnt_title_mask = jQuery("#search_kontragent_title").val();
                var inn_mask = jQuery("#search_inn").val();
                var region_mask = jQuery("#search_region").val();
                var country_mask = $('input:radio[name=country]:checked').val();
                var event_date_mask = jQuery("#search_event_date").val();
                //var event_type_mask = jQuery("#search_event_type").val();
                var event_date_po_mask = jQuery("#search_event_date_po").val();
                var date_created_po_mask = jQuery("#search_date_created_po").val();
                var content_mask = jQuery("#search_content").val();
                var date_created_mask = jQuery("#search_date_created").val();


                var search_innnaim_mask = '';
                var kontragrnt_title_mask = '';
                var inn_mask = '';
                var region_mask = '';
               // var country_mask = '';
                var event_date_mask = '';
                //var event_type_mask = jQuery("#search_event_type").val();
                var event_date_po_mask =  '';
                var date_created_po_mask =  '';
                var content_mask = '';
                var date_created_mask =  '';
				var filter_inn = jQuery("#filter_inn").val();
			//	var filter_all = jQuery("#filter_all").val();


				// $( ':checkbox:checked' ).each(function(){

  		// 		var filter_all = this.value
				// });	

	          

				var filter_name = jQuery("#filter_name").val();
				var filter_region = jQuery("#filter_region").val();
				var fav_com = jQuery("#fav_com").attr("checked");
				
                jQuery("#bigset").jqGrid('setGridParam',{url:"/monitoring/kontrdata/?filter_region="+filter_region+"&tarif={/literal}{$current_mon_tarif}{literal}&filter_name="+filter_name+"&filter_inn="+filter_inn+"&filter_all="+filter_all+"&country_mask="+country_mask+"&fav_com="+fav_com}).trigger("reloadGrid");
                   delete filter_all;   

                        }
                        gridReload();

		$('input[name="filter_serch"]').click(function(){
					gridReload();
					return false;
			});
		$('input[name="filter_serch2"]').click(function(){
					 jQuery("#filter_inn").val('');
					 jQuery("#filter_name").val('');
					 jQuery("#filter_region").val('');
					 gridReload();
					 
					 return false;
		});
	
		$('input[name="delItem[]"]').live('click',function(){
			if($('input[name="delItem[]"]:checked').size() > 0){
				$('a#jqgh_del').css('color','#DA114B');
			}else{
				$('a#jqgh_del').css('color','#DBA108');
			}
		
		});
		
		$('#jqgh_del').live('click', function(){
			alert('ff');
			/*if ($(this).attr('checked') == true)
				$('input[name="delItem[]"]').attr('checked', 'checked');
			else
				$('input[name="delItem[]"]').attr('checked', '');
			//	$('#delallItem').attr('checked', 'checked');*/
		});




                    function  favor (fav,id){
                        $('#info_favor').hide();
                        $('#info_favor1').hide();

                        jQuery.post( "/monitoring/list/" ,{favor: fav ,  id_favorites: id }   );
                            if (fav==1){
                                $("#f_"+id).attr("class","favorites-star");
                                $("#f_"+id).attr("onClick","favor(0,"+id+")"); 
                                  $("#f_"+id).attr("title","В избранном");                 
                                $("#f_"+id).attr("onmouseover","$(\'#info_favor\').show()");
                                $("#f_"+id).attr("onmouseout","$(\'#info_favor\').hide()");
                            }
                            if (fav==0){
                                    $("#f_"+id).attr("class","nofavorites-star");
							$("#f_"+id).attr("title","В избранное");
                                $("#f_"+id).attr("onClick","favor(1,"+id+")");
                                $("#f_"+id).attr("onmouseover","$(\'#info_favor1\').show()");
                                $("#f_"+id).attr("onmouseout","$(\'#info_favor1\').hide()");
                            }
                        }

 </script>
	
			<div style="margin-top:10px; margin-left:10px; position:relative">
				<span class="check_exel"><input type="checkbox"  id="sel_all" onClick="if($(this).is(':checked')){$('#cb_bigset').attr('checked','checked');$('.cbox').attr('checked','checked');}else{$('#cb_bigset').removeAttr('checked');$('.cbox').removeAttr('checked');}"> <label for="sel_all"></lable></span>
				<a style="color:#808080; " href="#" onClick="$('#items_sel').show();return false;">Действия с выбранными</a> 

		</div>


		<div class="events_info_block" id="items_sel" style="position:relative;left:70px;top:-30px;display:none;">
			<div style="position:relative;float:right;cursor:pointer;font-size: 15px;color: gray;top:5px;right:5px" onclick="$('#items_sel').hide();
                $('#option_l').show();">X</div>
			{/literal}
			<a href="javascript:void(0);" id="m1">Удалить выбранные</a><br>
			<a href="javascript:void(0);" id="addgroup">Добавить в новую услугу</a>

			 <div class="style-select" style="width: 100px;">                     
	             <select id='tar_id' name="k_id" style="width: 140px;">
	                <optgroup>
					{foreach from=$userTarifs item=item}
						<option value="{$item->id}" >{$item->count}-{$item->m}-{$item->period}</option>
					{/foreach}
					</optgroup>
				</select>
			</div>
			<span class="check_exel"><input id='is_copy' value='1' type="checkbox" name="copy" id="form_copy"> <label for="is_copy">Копировать в новую услугу:</lable></span><br>
			{literal}
		</div>

		
</form>
			
	   <div style="margin-top:5px;float:right;">Услуга 
	   	от <b> {/literal}{$user->getTarifInfo()->getStartDateFormatted()|strip_tags}{literal}</b>
	    до <b> {/literal}{$user->getTarifInfo()->getEndDateKuratorFormatted()|strip_tags}{literal}</b>	
	   </div>
            

            

            
			            {/literal}

			            <br>
 <div id="hide_country_radio" style="display:none">
<span class="radio_style">
        <input type='radio' name='country' value='' id="all_countries" onClick="
        		$('#jqgh_inn').html('ИНН/ЕДРПОУ'); console.log('222');   $('#search_country').val('');$('#filter_inn').attr('placeholder','ИНН/ЕДРПОУ');$('#search_inn').attr('placeholder','ИНН/ЕДРПОУ');$('#search_country').removeAttr('disabled'); 
        {foreach from=$ttList item=et }$('#type_event_'+{$et->id}).removeAttr('style');$('#search_event_type_'+{$et->id}).attr('checked','checked');{/foreach};
            {if $user->getTotalEventCount()==''}$('#bottom_type_all').html('(0)');{/if}            
                {foreach from=$ttList item=et}
                    $('#bottom_type_'+{$et->id}).html({$user->getEventCount($et->id)});                  
                   {if $user->getEventCount($et->id)<>''}$('#type_eve_'+{$et->id}).removeAttr('style').attr('style','cursor:pointer'); {/if}
                {/foreach}
            {if $user->getTotalEventCount()<>''}$('#bottom_type_all').html('('+{$user->getTotalEventCount()}+')');{/if}
            $('#img_ua').hide();$('#img_ru').hide();$('#small_event_types').show();$('#full_event_types').hide();
        doSearch(arguments[0]||event); " checked><label color="#1F5763" for="all_countries">Все</label></span>

        <span class="radio_style">            
        <input type='radio' name='country' value='RU' id="country_ru" onClick="$('#jqgh_inn').html('ИНН');        
        $('#search_country').val('RU');$('#filter_inn').attr('placeholder','ИНН');$('#search_inn').attr('placeholder','ИНН');$('#search_country').attr('disabled','disabled');
            {foreach from=$ttList item=et }$('#type_event_'+{$et->id}).attr('style','display:none');$('#search_event_type_'+{$et->id}).removeAttr('checked');{/foreach};
        {foreach from=$eveCountry item=et1}{if $et1.id_country==258}$('#search_event_type_'+{$et1.id_type}).attr('checked','checked');$('#type_event_'+{$et1.id_type}).removeAttr('style');{/if}{/foreach}
            {foreach from=$eventsdata key=k item=et1}$('#bottom_type_'+{$k}).html({$et1.RU});{if $et1.RU==0}$('#type_eve_'+{$k}).attr('style','display:none');{/if}{if $et1.RU<>0}$('#type_eve_'+{$k}).removeAttr('style').attr('style','cursor:pointer');{/if}{if $et1.RU_ev_all==''}$('#bottom_type_all').html('(0)');{/if}{if $et1.RU_ev_all<>''}$('#bottom_type_all').html('('+{$et1.RU_ev_all}+')');{/if}{/foreach};$('#img_ua').hide();$('#img_ru').show();$('#small_event_types').hide();$('#full_event_types').show();
        doSearch(arguments[0]||event);"><label color="#1F5763" for="country_ru">Россия <img src="/images/258.gif"></label></span>

         <span class="radio_style">
        <input type='radio' name='country' value='UA' id="country_ua" onClick="$('#jqgh_inn').html('ЕДРПОУ'); $('#search_country').val('UA');$('#filter_inn').attr('placeholder','ЕДРПОУ');$('#search_inn').attr('placeholder','ЕДРПОУ');$('#search_country').attr('disabled','disabled');
            {foreach from=$ttList item=et }$('#type_event_'+{$et->id}).attr('style','display:none');$('#search_event_type_'+{$et->id}).removeAttr('checked');{/foreach};
        {foreach from=$eveCountry item=et1}{if $et1.id_country==252}$('#search_event_type_'+{$et1.id_type}).attr('checked','checked');$('#type_event_'+{$et1.id_type}).removeAttr('style');{/if}{/foreach}
            {foreach from=$eventsdata key=k item=et1}$('#bottom_type_'+{$k}).html({$et1.UA});{if $et1.UA==0}$('#type_eve_'+{$k}).attr('style','display:none');{/if}{if $et1.UA<>0}$('#type_eve_'+{$k}).removeAttr('style').attr('style','cursor:pointer');{/if}{if $et1.UA_ev_all==''}$('#bottom_type_all').html('(0)');{/if}{if $et1.UA_ev_all<>''}$('#bottom_type_all').html('('+{$et1.UA_ev_all}+')');{/if}{/foreach};$('#img_ua').show();$('#img_ru').hide();$('#small_event_types').hide();$('#full_event_types').show();
        doSearch(arguments[0]||event);"><label color="#1F5763" for="country_ua">Украина <img src="/images/252.gif"></label></span><br>
</div>
			 <div id="small_event_types">
                <b style="color:#2D96FE;">События в мониторинге:</b> все<span style="color:#2D96FE;">({$user->getTotalEventCount()})</span> 
                /<img src="/images/258.gif"> Россия({if $eventsdata.0.RU_ev_all<>''}{$eventsdata.0.RU_ev_all}{/if}{if $eventsdata.0.RU_ev_all==''}0{/if}) 
                /<img src="/images/252.gif"> Украина({if $eventsdata.0.UA_ev_all<>''}{$eventsdata.0.UA_ev_all}{/if}{if $eventsdata.0.UA_ev_all==''}0{/if}) <span style="cursor:pointer" onClick="$('#small_event_types').hide();$('#full_event_types').show();">подробно</span></div>
                
            <div style="display:none" id="full_event_types">
                <b style="color:#2D96FE;">События в мониторинге<span style="color:#2D96FE;"  id="bottom_type_all">({$user->getTotalEventCount()})</span></b> <img id="img_ua" style="display:none" src="/images/252.gif"><img id="img_ru" style="display:none" src="/images/258.gif"><span style="cursor:pointer" onClick="$('#small_event_types').show();$('#full_event_types').hide();">кратко</span><br>

              {foreach from=$ttList item=et}
                
               <div id="type_eve_{$et->id}" style="cursor:pointer;" onClick="{foreach from=$user->getEventId($et->id) key=myId item=i}
                 if(!$('#{$i.id}').attr('aria-selected'))($('#{$i.id}').attr('aria-selected','true').attr('class','ui-widget-content jqgrow ui-row-ltr ui-state-highlight'));
                 else($('#{$i.id}').removeAttr('aria-selected').attr('class','ui-widget-content jqgrow ui-row-ltr'));
                  {/foreach}">
                  <span  style="width:20px; height:20px;background-color:{$et->getColor()}">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<b style="color:{$et->getColor()}">{$et->title|escape}(<span style="color:{$et->getColor()}"  id="bottom_type_{$et->id}">{$user->getEventCount($et->id)}</span>)
                 </b> - {$et->description|escape} <span id='tarifs1'><span class="btn_tarif" val="{$user->getActualTarifInfo()->id}" 
                val2="{$user->getTarifId($user->getActualTarifInfo()->id)}">{$user->getCountMon() }-{$user->getTarifInfo()->m}-{$user->getActualTarifInfo()->period/7}
              </span></span></div>
                {/foreach}
            </div>

              <div id="description1" style="display:none; position:absolute; width:470px;">
                <div style="float:right;cursor:pointer;font-size: 15px;color: gray;margin-right: -2px;" onclick="$('#description').hide();" id='hide_info'>X</div>
                <div id='conteiner_info'></div>            
             </div>
			
			{* Настройка событий text-align:right; *}
			{* TODO добавление новыйх событий по автомату  *}
			
            <div style="float:left; margin-top:-15px;padding:0px;">
                <br>
                <b style="color:#1F5763">Настройка рассылки уведомлений :</b><br>
				 <strong> Общий  адрес</strong>: {$user->getEmail() } &nbsp;&nbsp; <a href="#" id="mail_change" style="color:#da114b"> изменить </a><a href="" id="mail_hide" style="color:#da114b;display:none;"> свернуть </a>
			    
				<div id="mails" style="display:none" class="style_input"> 				
                {foreach from=$ttList item=et}
				
				{ if ($et->title =="суд" ) }
				<input type="text" name="court"  value="{$user->getCourtMail() }" class="list_event_input"  onChange="$('#save_mail').attr('data-id','1')"/>
                <span style="width:20px; height:20px;background-color:{$et->getColor()}">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;
				    <b style="color:{$et->getColor()}"> {$et->title|escape}</b> {/if}
					
				{ if ($et->title =="егрюл" ) }
				<input type="text" name="egrul" value="{$user->getEgrulMail()}" class="list_event_input" onChange="$('#save_mail').attr('data-id','1')"/> 
                <span style="width:20px; height:20px;background-color:{$et->getColor()}">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;
				    <b style="color:{$et->getColor()}"> {$et->title|escape}</b> {/if}

				{ if ($et->title =="банкротство" ) }
                <input type="text" name="bankruptcy" value="{$user->getBankMail() }"  class="list_event_input" onChange="$('#save_mail').attr('data-id','1')"/>
                <span style="width:20px; height:20px;background-color:{$et->getColor()}">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;
				    <b style="color:{$et->getColor()}"> {$et->title|escape}</b> {/if}					
	            <br/>		
                {/foreach}
                <div style="color:#da114b;"><br>
				<span id="save_mail" style="cursor:pointer;" data-id="0" class="file_input_button">Сохранить</span>
				<span style="display:none;color:#da114b;" id="saved" > изменения сохранены <font color="#DBA108">(<a href="" onClick="$('#mails').hide();$('#mail_hide').hide();$('#mail_change').show();return false;" style="color:#DBA108">свернуть</a>)</font>  </span></div>
			</p>
			
			

			  </div></div></div></div>


<div style="z-index:100500;position:relative;float:right;cursor:pointer;font-size: 15px;top:-80px;right:5px">

                     <br><span id='option_l'  onclick="$('#option_l').hide(); $('#option').show(); " class="file_input_button"> Настройки </span>              
        <div class="events_info_block" id="option" style="margin-left: -170px;display:none;position:absolute;cursor:pointer;font-size: 15px;top:65%;left:-50%;padding-left:15px; width:170px;">
                    <div style="position:relative;float:right;cursor:pointer;font-size: 15px;color: gray;top:5px;right:5px" onclick="$('#option').hide();
                $('#option_l').show();">X</div>

                <form method="POST">
                <span class="check_exel">
            <input class="type_select" name="title" type="checkbox"  style="width:10px;"  id="hide_title" value="checked"   {$datas.title}/>
                <label  for="hide_title" ></label>Наименования</span><br>

                <span class="check_exel">
                 <input class="type_select" name="inn" type="checkbox"  style="width:10px;"  id="hide_inn" value="checked"  {$datas.inn}/>
                <label  for="hide_inn" ></label>ИНН</span><br>

                <span class="check_exel">
                 <input class="type_select" type="checkbox" name="region"  style="width:10px;"  id="hide_region" value="checked"  {$datas.region}/>
                <label  for="hide_region"  ></label>Регион</span><br>

   
                <span class="check_exel">
                 <input class="type_select" type="checkbox" name="event" style="width:10px;"  id="hide_event" value="checked" {$datas.event}/>
                <label  for="hide_event"  ></label>События</span><br>


                <span class="check_exel">
                 <input class="type_select" type="checkbox" name="country" style="width:10px;"  id="hide_country" value="checked" {$datas.country}/>
                <label  for="hide_country"  ></label>Страна</span><br>

  
  				                <span class="check_exel">
                 <input class="type_select" type="checkbox" name="adress" style="width:10px;"  id="hide_adress" value="checked" {$datas.adress}/>
                <label  for="hide_adress"  ></label>Адрес</span><br>

        
                 <span class="check_exel">
                 <input class="type_select" type="checkbox" name="rykov" style="width:10px;"  id="hide_rykov" value="checked" {$datas.rykov}/>
                <label  for="hide_rykov"  ></label>ФИО директора</span><br>

                 <span class="check_exel">
                 <input class="type_select" type="checkbox" name="reg_date" style="width:10px;"  id="hide_reg_date" value="checked" {$datas.reg_date}/>
                <label  for="hide_reg_date"  ></label>Дата регистрации</span><br>

                                 <span class="check_exel">
                 <input class="type_select" type="checkbox" name="otrasl" style="width:10px;"  id="hide_otrasl" value="checked" {$datas.otrasl}/>
                <label  for="hide_otrasl"  ></label>Отрасль</span><br>


        		 <input type="submit" name="save_setting" value="Сохранить">
                </form>




                </div>

        </div> 

         <div  id="infor" style="position: absolute; z-index: 10000; overflow:hidden; height:95px; left: 450px; display: none;" class="events_info_block"> </div>
            <br>
   </div> 

   <script type="text/javascript">
{literal}
		          //Названия
                    $("#hide_title").live('click' ,function() {
                  
                         $("#hide_title").text('Показать Наименования'); 
                         $(this).next().attr('for','show_title');
                         $("#hide_title").attr('id','show_title');
                         jQuery("#bigset").jqGrid('hideCol','title');
                    });                                       
                    $("#show_title").live('click' ,function() {
               
                         $("#show_title").text('Скрыть Наименования'); 
                         $(this).next().attr('for','hide_title');
                         $("#show_title").attr('id','hide_title');
                         jQuery("#bigset").jqGrid('showCol',"title");
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
     //События
                     $("#hide_event").live('click' ,function() {
                         $("#hide_event").text('Показать События'); 
                         $(this).next().attr('for','show_event');
                         $("#hide_event").attr('id','show_event');
                         jQuery("#bigset").jqGrid('hideCol','event');
                      });
                    $("#show_event").live('click' ,function() {
                         $("#show_event").text('Скрыть События');
                         $(this).next().attr('for','hide_event'); 
                         $("#show_event").attr('id','hide_event');
                         jQuery("#bigset").jqGrid('showCol',"event");
                    });

                         $("#hide_country").live('click' ,function() {
                         $(this).next().attr('for','show_country');
                         $("#hide_country").attr('id','show_country');
                         jQuery("#bigset").jqGrid('hideCol','country');
                      });
                    $("#show_country").live('click' ,function() {
                         $("#show_country").text('Скрыть События');
                         $(this).next().attr('for','hide_country'); 
                         $("#show_country").attr('id','hide_country');
                         jQuery("#bigset").jqGrid('showCol',"country");
                    });

                     $("#hide_adress").live('click' ,function() {
                         $(this).next().attr('for','show_adress');
                         $("#hide_adress").attr('id','show_adress');
                         jQuery("#bigset").jqGrid('hideCol','adress');
                      });
                    $("#show_adress").live('click' ,function() {
                         $("#show_adress").text('Скрыть События');
                         $(this).next().attr('for','hide_adress'); 
                         $("#show_adress").attr('id','hide_adress');
                         jQuery("#bigset").jqGrid('showCol',"adress");
                    });

                    $("#hide_rykov").live('click' ,function() {
                         $(this).next().attr('for','show_rykov');
                         $("#hide_rykov").attr('id','show_rykov');
                         jQuery("#bigset").jqGrid('hideCol','rykov');
                      });
                    $("#show_rykov").live('click' ,function() {
                         $(this).next().attr('for','hide_rykov'); 
                         $("#show_rykov").attr('id','hide_rykov');
                         jQuery("#bigset").jqGrid('showCol',"rykov");
                    });


                         $("#hide_reg_date").live('click' ,function() {
                         $(this).next().attr('for','show_reg_date');
                         $("#hide_reg_date").attr('id','show_reg_date');
                         jQuery("#bigset").jqGrid('hideCol','reg_date');
                      });
                    $("#show_reg_date").live('click' ,function() {
                         $(this).next().attr('for','hide_reg_date'); 
                         $("#show_reg_date").attr('id','hide_reg_date');
                         jQuery("#bigset").jqGrid('showCol',"reg_date");
                    });

                    $("#hide_otrasl").live('click' ,function() {
                         $(this).next().attr('for','show_otrasl');
                         $("#hide_otrasl").attr('id','show_otrasl');
                         jQuery("#bigset").jqGrid('hideCol','otrasl');
                      });
                    $("#show_otrasl").live('click' ,function() {
                         $(this).next().attr('for','hide_otrasl'); 
                         $("#show_otrasl").attr('id','hide_otrasl');
                         jQuery("#bigset").jqGrid('showCol',"otrasl");
                    });






{/literal}
   </script>

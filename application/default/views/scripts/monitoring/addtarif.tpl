{if $smarty.get.type}

    {assign var="tarifIdPost" value = $smarty.get.tarifid|string_format:"%d"}
    {assign var="typeClick" value = $smarty.get.type|string_format:"%d"}
{/if}


    <script type="text/javascript">
        var tarifIdPost ={if $tarifIdPost} {$tarifIdPost} {else} -100 {/if} ;
        var typeClick = {if $typeClick} {$typeClick} {else} -100 {/if} ;

    </script>



    {* Release Tpl  *}

    <div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>

        <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}> </div>


        {literal}
            <script type="text/javascript">
            min_count_company = 25;	
	
                    function updateNewNameTarif(){
                                    var srok = $('input[name="m"]:checked').attr('cou');
                                    var period = ($('select[name="period"] option:selected').val());
                                    var count_comp = $('#amount').val();
			
                                    var n_cat = $('.main_t.active').text();
                                    var sub_n_cat = $('.submain_t.active').text();
			
                                    $('#new_name_tarif').text(n_cat.substr(0,1)+sub_n_cat.substr(0,1)+'-'+srok+'-'+period+'-'+count_comp);
                            }
                    var change_tarif = [];
	

	
		
                     $(document).ready(function() {	 	
	 		 
                    $('.btn_tarif').mouseout(function (){
		
                                    /*var id_el = '#description';
			
                                            $(id_el).hide();*/
                                            //$('#hide_info').click();
                                            $('#description').hide();
                    });
                    $('.btn_tarif').mouseover(function (kmouse){
                                    id = $(this).attr('val2');

                                    base_h = kmouse.pageY + 355;
                                    base_w = kmouse.pageX ;
                                    var id_el = '#description';
                                    $('.btn_tarif').css('background-color','#1F5863');
                                    $.get('/monitoring/tarifinfo', {tarif_id : $(this).attr('val')}, function(data){
                                            $('#description').html(data);
                                    });
                                    $(id_el).addClass('events_info_block');		
                                    $(id_el).css('top',base_h).css('left', base_w);
                                    $(id_el).show();
				
		
                            });
		
                            setTimeout(updateNewNameTarif,1000);
                    var start=$( "#amount" ).val();		
                            calculate(start);

                    minimal = $( "input:hidden[name=min_value]").val();
                            var gMin = $("input[name=min]").val();
                            gMin = parseInt(gMin);
		
		
                            checkNewTarif();
                            //alert('fff');
                            //$("#slider-range-min").slider('min',gMin);
                            $("#between_0").eq(0).hide();
                    $(".right_arrow").hide();	    
                            $(".right_arrow").eq(0).show();
		
                            /*$( "#slider-range-min" ).slider({
                                range: 'min',
                                    min: gMin,
                                    max: 1000,			
                                    slide: function( event, ui ) {
                                            $( "#amount" ).val( ui.value );
                                            calculate(ui.value);
                                    }
		
                            });*/
		
                            $("#amount").bind('keyup', function (event) {
                              var change= $("#amount").val();  
                              //$( "#slider-range-min" ).slider('value',change);
                              $("#total").show();
		  
                              checkNumberFields(this,event);
                      calculate(change);
                      //temp=parseInt($("#amount").val(gMin));
          	  
                            });
		
                            $("#amount").bind('blur', function (event) {
                              var change= $("#amount").val(); 
                                    if (change < min_count_company)
                                    {
                                            $("#amount").val(min_count_company)
                              var change= $("#amount").val(); 
                              //$( "#slider-range-min" ).slider('value',change);
                              $("#total").show();
		  
                              checkNumberFields(this,event);
                      calculate(change);
                      //temp=parseInt($("#amount").val(gMin));
                              }
          	  
                            });
		
		
		
                            //$("form[name=tarifForm]").bind('submit',function() {
                            //});
		
		
		
                            $('select[name="period"]').change(function() {
                      //setTimeout(updateNewNameTarif,500); 
                      updateNewNameTarif();

                              var change= $("#amount").val();
                              calculate(change);		  
                            });
		
                            $('#hictory_add').change(function() {
                      //setTimeout(updateNewNameTarif,500); 
                      updateNewNameTarif();

                              var change= $("#amount").val();
                              calculate(change);		  
                            });
		
		
		
		
                            $("input[name=submitb]").click(function() {
                      discount=$("#ackiya").text();		  
                              price=$("#total_sum").text();	  
 
                              var temp=parseInt($( "#amount" ).val());
                              if (temp<gMin){
                               alert('Введите минимум '+gMin+' компания для мониторинга');
                       return false;		   
                              }  

                      total_residue = parseInt($("#residue_sum").text());
                      price = parseInt(price);
                              if (total_residue > price){
                               alert('Сумма нового услуги должна превышать остаток с предыдущих услуг');
                       return false;
                              }  
          
                              $("input[name=refresh]").val(0);
		  
                              $("input[name=mon_price]").val(price);
                              $("input[name=mon_discount]").val(discount);
		  
                              $("form[name=tarifForm]").submit();		  
                            });		
		
                             $("form[name=tarifForm]").submit(function(){
                                    if($('#amount').val() < min_count_company)
                                    {
                                            alert ('Минимальное количество компаний - ' + min_count_company);
                                            return false;
                                    }
                             });	
                            var period = $("input:radio[name=checked_period]").val();
	
                            function calculate(total){
                              sum = 0;
                              sum_history=0;
                              total_count=0;
                    //	 if ($('[name=period]:visible').size() == 0)
                             if ($('[name=hictory_add]:checked').size() == 1)
                             {		
                                    var rowN=checkRangeNubmer(total);
                                    var price=getPrice(rowN);		  
                                    sum_history=price*parseInt(total);
                                    //alert(sum)
                                    //alert(total)
                                    total_count += total*1;
                                    $('input[name="mon_price"]').val(sum);
                                    //alert(sum)
                                    //return 0;
                             }
                             if ($('[name=period]:visible').size() > 0)
                             {
                              checks=$(":radio[name=m]").filter(":checked").attr('cou');
                              period=$('select[name="period"] option:selected').val()
		  
		  
		  
                              var rowN=checkRangeNubmer(total);
                              mult = Math.floor(checks/period);
                              var price=getPrice(rowN);		  
                              sum=price*parseInt(total)*mult;
                              total_count += parseInt(total)*mult
		  
                              checks_sale=$(":radio[name=m]").filter(":checked").attr('sale');
                              sum=sum*(100-checks_sale)/100;
                            //	alert(price);
                      $("input:hidden[name=price_one]").val(price); // цена за одну штуку 	
		  
                      between=checkBetween(rowN);
                            //  alert(between);
                      between*=total*mult;
                      if (isNaN(between)) between=0;
                      if (isNaN(sum)) sum=0; 

                      $("#ackiya").text(between);
                            //	alert(sum+'='+between);
                             }
                             sum = sum + sum_history;
                             var sum2 = ''+sum+'';
                             if(sum2.length == 5){
                                    sum2 = sum2.substr(0,2)+' '+sum2.substr(2,5);
			
                              }
                              $("#total_sum").text(sum2);   
                              $("#monitoring_count_total").html(total_count);   
		  
                              $('input[name="mon_price"]').val(sum);
		  
                            }
		
                            function checkBetween(row){
                            //  checks=$(":radio[name=m]").filter(":checked").val();
          
                         // checks=checkNumber(checks);
                          checks=1;
		  
                              if (checks == 1) {
                               var price=$("table#tarif_grid tr#item").eq(row).children().eq(1);
                               var bet=$(price).children().eq(0).text();
                               return parseInt(bet);
                              }
		  
                              if (checks == 2) {
                               var price=$("table#tarif_grid tr#item").eq(row).children().eq(2);
                               var bet=$(price).children().eq(0).text();
                               return parseInt(bet);	   
                      }
		  
                              if (checks == 3) {
                               var price=$("table#tarif_grid tr#item").eq(row).children().eq(3);
                               var bet=$(price).children().eq(0).text();
                               return parseInt(bet);	   
                      }
		  
                            }
		
                            function checkRangeNubmer(total) {
                              var need=0;
                              var cur=1;
		  
                          var sums=$('table#tarif_grid input[type=hidden]');
          
                              len = $(sums).size();
                              total = parseInt(total); 
		  
 
                              for (var i=0; i<len; i++) {		  
                                cur = $(sums).eq(i).val();
                        cur = parseInt(cur);
			
                                    if ( (cur!=7) && (cur!=0) && (cur!=1) ) {
			
                                            if (total >= cur) {
                             need++;
                                    //	 alert(cur);
                          }

                        }           	
                      }
		  
		   
                              last = $("input[name=countTarif]").val();
                              last=parseInt(last);
                            //alert(need);
                              if (need != 0) need--;
                            //alert(need);
                      return need;	      
                            }
		
                            function getPrice(row){
                              //checks=$(":radio[name=m]").filter(":checked").val();		  
                              checks=$("input[name=country_tarif]:checked").attr('value');		
                            //	alert(checks);
                          checks=checkNumber(checks);
                              var price=$("table#tarif_grid tr#item").eq(row).children().eq(checks).text();	
                                    $("table#tarif_grid tr#item td[align=left]").css('color','#1F5863');		  
                                    //$("table#tarif_grid tr#item").eq(row).children().eq(checks).css('color','#ff0000');		  
                      return parseInt(price);		
                            }
		
                            $("input[name=m]").live('click',function() {
                              var a = $(this).attr('value');
                              var change= $("#amount").val();
                              calculate(change);
                              setTimeout(updateNewNameTarif,500);

		  
                            });
                            $("input[name=country_tarif]").live('change',function() {
                              $("input[name=country_tarif2][value="+$(this).attr('value')+"]").click();
                              var a = $(this).attr('value');
                              //alert(a);
                              $('[name=type_event]').hide();
                              $('.countr_'+$(this).attr('value')).show();
                              var change= $("#amount").val();
                              calculate(change);
		  
                              $('.country_').css('color','#2D96FE');
                              $('#country_'+$(this).attr('value')).css('color','#dba108');
                              setTimeout(updateNewNameTarif,50);
                            });
                            $("input[name=country_tarif2]").live('change',function() {
                              $("input[name=country_tarif][value="+$(this).attr('value')+"]").click();
                              $("input[name=country_tarif][value="+$(this).attr('value')+"]").change();
		  
                            });

                function setCurrent(){
                     count=$("input[name=currentTarif]").val();
                     period=$("input[name=currentPeriod]").val();
                     user_period=parseInt($("input[name=userPeriod]").val());
	 
                     //cur_period=$("input[name=period]").val();
     
                     //alert(user_period == cur_period);

                     if ( user_period>0) {
                             var row=checkRangeNubmer(count);
                             if (period=="1") period=1;
                             if (period=="3") period=2;
                             if (period=="6") period=3;	 
                             $("table#tarif_grid tr#item").eq(row).children().eq(period).children().css({background:"blue",color: "black",fontWeight: "bold" } );       	 
                             $("table#tarif_grid tr#item").eq(row).children().eq(period).eq(0).css({background:"blue",color: "black",fontWeight: "bold"} );	 
                             $("table#tarif_grid tr#item").eq(row).children().eq(0);
                     }
  	 
                    }
	
                    function checkNewTarif() {	
                      count=parseInt($("input[name=newTarifCount]").val());
                      period=parseInt($("input[name=newTarifPeriod]").val());	  
                      show_new=parseInt($("input[name=showNewTarif]").val());
	  
      
                      if (show_new>0) {
                      if (period==0) return;
                      var row=checkRangeNubmer(count);
	  
                      if (period==1) period=1;
                      if (period==3) period=2;
                  if (period==6) period=3;
	  
                      $("table#tarif_grid tr#item").eq(row).children().eq(period).children().css({background:"green",color: "black",fontWeight: "bold" } );       	 
                      $("table#tarif_grid tr#item").eq(row).children().eq(period).eq(0).css({background:"green",color: "black",fontWeight: "bold"} );	 
                      $("table#tarif_grid tr#item").eq(row).children().eq(0);
                      }
	  
                    }
		
                function checkNumberFields(e, k){
	
                     var str = $(e).val();
                     var new_str = s = "";
	
                    for(var i=0; i < str.length; i++){
		
                            s = str.substr(i,1);
		
                            if(s!=" " && isNaN(s) == false){
                                    new_str += s;
                            }
                     }	
                     if(eval(new_str) == 0){ new_str = "0" ; }
    
                    $(e).val(new_str);
	
                    }
	
                    function checkNumber(checks){
	
                    /* len=checks.length;
                     len--;
                     checks=checks[len];	  
                     checks=parseInt(checks);
	 
                     switch(checks) {
                      case 1: return 1;
                      case 3: return 2;
                      case 6: return 3;
                      case 12: return 4;
                     }	*/
                     index = $('.country_').index($('#country_'+checks));
               
                    // alert(index);
                     return (index+1);	 
                    }
	

                $("#form_paid").click(function () {
                 re = parseInt($("#residue_sum").text());	
                     sum = parseInt($("#total_sum").text()); 

                 between = sum - re; 
	 
                     $("input:hidden[name=between]").val(between);
                     $("input:hidden[name=residue_minus]").val(between); 
	 
                 if ( confirm('С вашего личного счета будет списано '+between+'руб. (с учетом остатка)') ) {
                      url = '/order/create/';
                      $(location).attr("href",url);
                     }
                     else return false; 
                    });
	

                $('.submain_t').click(function(){
                    if (($(this).html() == 'история') || ($(this).html() == 'history')){
                                    $('#span_visible').hide();
                                    console.log("2222");
                            } else {
                                    $('#span_visible').show();
                            }
                });
	

                    $('.main_t').click(function(){ 
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
		
                            updateNewNameTarif();
                            setTimeout(updateNewNameTarif,50);
                    });

                    $('[name=type_event]').live('mousemove', function(){
                            $(this).children('span').show();
                    });
	
	
                    $('[name=type_event]').live('mouseout', function(){
                            $(this).children('span').hide();
                    });
	
                    $('.submain_t').click(function(){
                            sub_n_cat = '';
                            //$('.submain_t').hide();
                            //$('span[val="all"]').show();
                            $('.submain_t').removeClass("active");
                            updateNewNameTarif();
                            var submain_active_value = $('.main_t .active').val();
                            $(this).addClass('active');
                            //$('.submain_t[val2="'+$(this).attr('value')+'"]').show();
                            /*$('#tarif_grid tr.cl').hide();
                            $('#tarif_grid tr.cl'+$(this).attr('value')).show();*/
                            $('#tarifs span').hide();
                            $('#tarifs span[parent='+$(this).attr('value')+']').show();
                            //$('#tarifs span[parent='+$(this).attr('value')+']:first').click();
                            $.post('/monitoring/tarifgridadd/', {tarifsThis : $(this).attr('value'), period : '{/literal}{$refresh_period}{literal}', skidka : '{/literal}{$fparams.skidka}{literal}'}, function(data){
                                    $('#table_prices').html(data);
                                    updateNewNameTarif();
                                    if(submain_active_value==4){
                                            $("#span_visible").attr("display","none");
                                    }else{
                                            $("#span_visible").attr("display","block");
                                    }
                            });
		
                    });
            {/literal}

            {if !$tarifIdPost}

                $('.main_t:first').click();
   	
            {/if}{literal}
                    var change= $("#amount").val();
                              calculate(change);
                    $(".main_top_text div p").css("display","none");
	
            });
            </script>

        {/literal}
        <div id="description" style="display:none; position:absolute; width:470px;">

        </div>

        <div>
            <div class="main_top_text">

                {breadcrumb controller="monitoring" alias="monitoring" altTitle="Мониторинг"}
                {include file="lmenu.tpl"}

                <h1>{info name="notarif" what="title"}</h1>
                <p>{info name="notarif"}</p>


                <div>

                   
            {form from=$form id="form_"}
            {form_errors_summary}
            {form_hidden name="change" value=$change}
             
			
			<p>
			<div style="background-color:#FFE9AE;padding:3px;color:#1F5863;">
			{foreach from=$type item=typ}
				<span class='main_t' style="padding:2px;cursor:pointer;" value={$typ->id}>{$typ->name}</span> <font color="white">|</font>
			{/foreach}
			</div>
			<div style="background-color:#FFE9AE;padding:3px;color:#1F5863;margin-top:2px;">
			{foreach from=$tarif item=tar}
				{if $tar->name != ''}
					<span class='submain_t' style="padding:2px;cursor:pointer;" val2='{$tar->type}' value="{$tar->id}">{$tar->name} <font color="white">|</font></span> 
				{/if}
			{/foreach}
			</div><br>
			<span class='submain_t' val='all'>&nbsp;</span> 
            			

            {*form_select name="period" options=$periodList selected=$user->getActualTarifInfo()->period*}		
            {*form_submit name="refresh" value="Пересчитать тариф" style="margin:0;padding:0;"*}


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
			<div id="tarifs">
			Активные тарифы: {foreach from=$userTarifs item=item}
			  <span onclick="infoBox({$item->tarifId})" class="btn_tarif_{$item->tarifId} btn_tarif" style="cursor:pointer">{$item->count}-{$item->m}-{$item->period/7}</span>
			{/foreach}
			</div>
			{/if}
			
			
			
			
			<div id=table_prices style="margin-top: -12px;">
			
            {include file="monitoring/tarif_grid_add.tpl" form=$form tarifsList=$tarifsList showusertarif=1 skidka=$fparams.skidka}
            
			</div>
     		<div style="background-color:#FFE9AE;">
            <p style="line-height: 10px;padding:0px;padding-top:5px;" >			 
             <font color="#1f5863">Регулярность мониторинга:</font>
			 <select name="period">
				{foreach from=$periodList item=period key=key}
				<option value="{$key}" >{$period}</option>
				{/foreach}
			 </select>
             {*<input type="radio"  name="period" value="7"  {if $refresh_period==7 } checked {/if} /> 1 неделя
             <input type="radio"  name="period" value="14" {if $refresh_period==14 } checked {/if} /> 2 недели
             <input type="radio"  name="period" value="28" {if $refresh_period==28 } checked {/if} /> 4 недели*}
             <input type="hidden" name="refresh" value="" />
             <input type="hidden" name="min_value" value="{$minimal}" />    			 
            </p>  
			<div style="margin-top:5px">
			<font color="#1f5863">Количество компаний в мониторинге :</font>
            <input type="text" id="amount" name="monitoring_count" value="{$minimal}" onkeyup="updateNewNameTarif()" style="width: 40px;"/>   			
            <div id="slider-range-min"></div>
			</div>
			</div>
			
		 <script>	
{$tmps =0}
                    {if $show_delete_tarifs>0 }
                        {literal}
                           
                                    
                             setTimeout(function() { 
                                $("select[name=period]").val({/literal}{$delete_tarifs[0]->period}{literal});
                                $("#amount").val({/literal}{$delete_tarifs[0]->count}{literal});
                                $("#amount").val({/literal}{$delete_tarifs[0]->count}{literal});
                                $(".sale_period").eq({/literal}{$delete_tarifs[0]->m }{literal}).click();
                                $('#{/literal}{$delete_tarifs[0]->country }{literal}').click();
                            {/literal}{if ($delete_tarifs[0]->history == 0)}    
                                $("#hictory_add").removeAttr("checked");
                            
                            {/if}{literal}
                                    
                            {/literal}{if ($delete_tarifs[0]->history == 1)}    
                                $("#hictory_add").attr("checked","checked");
                            {/if}{literal}
                            }, 1200)
                                </script>   
                         
                             
                                
                           
                        {/literal}
             {/if}
                             
                                
                            </script>
                        {/literal}

                        {foreach from=$delete_tarifs item=item}
                            {$sum =0}
                            {if $item->endDateUser > $smarty.now}      
                                <span class="tarif_residue" style="color: #02950E;"  > Остаток с услуги <strong> {$item->count}-{$item->m}-{$item->period/7} </strong> : {$sum = $sum + $item->residue}  { $item->residue } &nbsp;руб.</span><br><br>
			{/if}		
                        {/foreach}
                        <br><br/>
                        {if $sum!=0}
                            <span style="font-weight: bold; color: #02950E;" > Общий остаток c предыдущих услуг : <span id="residue_sum">{$sum} </span> &nbsp;руб.</span> 		     
                        {/if}
           
			
             		

			<br>
                    {if $Basket->getCount()==0}
                        <div style="float:right;margin-top: -5px;">
                            <input type="button" onclick="$('#form_').submit();" class="db_btn_zakaz" id="db_btn_zakaz">
			</div>
                    {/if}
                    {if $Basket->getCount()>0}
                        <div style="float:right;margin-top: -5px;">
                            <input type="button" onclick="$('#form_').submit();" class="db_btn_zakaz1" id="db_btn_zakaz">
                        </div>
                    {/if}
                    <div style="color:#2D96FE;font-size:13px;">			<b>Общая стоимость : <span id="total_sum" style="color:#2D96FE"> </span> &nbsp;руб.</span></div></b>
			
			<div style="color:#1f5863">			<b>Общая стоимость : <span id="total_sum" style="color:#DB144D"> </span> &nbsp;руб.</span></div></b>
			
			
			<input type="hidden" name="mon_price" value="" />
			<input type="hidden" name="mon_discount" value="" />
			
            <br>
            {*<div style="margin:0px;padding:0px;height:31px;line-height:31px;padding-right:155px;" >
			
			
			
			
			
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<!--<span >
			Всего элементов в корзине: {$Basket->getCount()}{if $Basket->isTotalAmountDefined()} на сумму {$Basket->getTotalAmountString()}{/if}
            </span>-->
			<a href="/order/basket/" > <div id="basket_link"> </div> </a>  
			</div>
			
			</div>*}

  
            {/form}

{include file="order/basket_grid.tpl" ischeck=1}



                {*}
                {if $show_delete_tarifs>0 }	

                {if $Basket->isTotalAmountDefined()}
                {if $Basket->getTotalAmount()>$balans_residue } 
                <span style="color:red;" >Недосточно средств на личном счете ( c учетом остатка ) </span >
                {else}
                <input type="submit" name="form_paid" id="form_paid"  value="Оплатить" />
                {/if}
                {/if}			

                {else }
                
                {if $Basket->isTotalAmountDefined()}
                {if $Basket->getTotalAmount()>$user->balans } 
                <span style="color:red;" >Недосточно средств на личном счете</span>
                {else}
                <input type="submit" onclick="if (!confirm('С вашего личного счета будет списано {$Basket->getTotalAmount()} руб.')) return false; document.location = '/order/create/';" value="Оплатить" />
                {/if}
                {/if}

                {/if}
                {*}


            </div>

        </div>
        <div class="dotted2"></div>
    </div>
</div>

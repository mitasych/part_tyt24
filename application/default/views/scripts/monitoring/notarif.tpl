{* Release Tpl  *}

<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

{literal}
<script type="text/javascript">
	function updateNewNameTarif(){
			var srok = $('input["name"="m"]:checked').attr('cou');
			var period = ($('select[name="period"] option:selected').val())/7;
			var count_comp = $('#amount').val();
			
		
			
			$('#new_name_tarif').text(srok+'-'+period+'-'+count_comp);
		}
	
	 $(document).ready(function() {
	setTimeout(updateNewNameTarif,1000);
        var start=$( "#amount" ).val();		
		calculate(start);
        setCurrent();
        checkNewTarif();		
        minimal = $( "input:hidden[name=min_value]").val();
		var gMin = $("input[name=min]").val();
		gMin = parseInt(gMin);
		
		$("#slider-range-min").slider('min',minimal);
		$("#between_0").eq(0).hide();
        $(".right_arrow").hide();	    
		$(".right_arrow").eq(0).show();
		
		$( "#slider-range-min" ).slider({
		    range: 'min',
			min: gMin,
			max: 1000,			
			slide: function( event, ui ) {
				$( "#amount" ).val( ui.value );
				calculate(ui.value);
			}
		
		});
		$('input[name="m"]').live("click",function(){
			updateNewNameTarif();
		
		});
		$("#amount").bind('keyup', function (event) {
		  var change= $("#amount").val();  
		  $( "#slider-range-min" ).slider('value',change);
		  $("#total").show();
		  updateNewNameTarif();
		  checkNumberFields(this,event);
          calculate(change);
          //temp=parseInt($("#amount").val(gMin));
          	  
		});
		
		$("form[name=tarifForm]").bind('submit',function() {
          discount=$("#ackiya").text();		  
		  price=$("#total_sum").text();
		  
		  var temp=parseInt($( "#amount" ).val());
		  if (temp<gMin){
		   alert('Введите минимум '+gMin+' компания для мониторинга');
           return false;		   
		  }          
	      
		  $("input[name=mon_price]").val(price);
		  $("input[name=mon_discount]").val(discount);
		});
		
		
		
		$("input[name=period]").click(function() {
          need=$(this).val();	  
		  $("input[name=refresh]").val(need); 
	  
		  $("form[name=tarifForm]").submit();		  
		});
		
		$("input[name=submitb]").click(function() {
		  $("input[name=refresh]").val(0); 
	  
		  $("form[name=tarifForm]").submit();		  
		});		
		
		var period = $("input:radio[name=checked_period]").val();
	
		function calculate(total){
		 

		  
		  var rowN=checkRangeNubmer(total);
		  
		  var price=getPrice(rowN);		  
		  sum=price*parseInt(total);
		  

          between=checkBetween(rowN);
		  
          between*=total;
          if (isNaN(between)) between=0;
          if (isNaN(sum)) sum=0;                               		  
		  
          $("#ackiya").text(between);		  
		  $("#total_sum").text(sum);        		  
		}
		
		function checkBetween(row){
		  checks=$(":radio[name=m]").filter(":checked").val();
          
	      checks=checkNumber(checks);
		  
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
		  
	      var sums=$("table#tarif_grid input[type=hidden]");
          
		  len = $(sums).size();
		  total = parseInt(total); 
		  
 
		  for (var i=0; i<len; i++) {		  
		    cur = $(sums).eq(i).val();
            cur = parseInt(cur);
			
			if ( (cur!=7) && (cur!=0) && (cur!=1) ) {
			
			  if (total > cur ) {
                 need++;
              }

            }           	
          }
		  
		   
		  last = $("input[name=countTarif]").val();
		  last=parseInt(last);
		  if (need==last) need--;

		  //alert(need+' '+last);
		  //var price=$("table#tarif_grid tr#item").eq(5).text();
		  //alert(price); 		  
		  
          return need;	      
		}
		
		function getPrice(row){
		  checks=$(":radio[name=m]").filter(":checked").val();		  
	      checks=checkNumber(checks);
		  var price=$("table#tarif_grid tr#item").eq(row).children().eq(checks).text();			  
          return parseInt(price);		
		}
		
		$("input[name=m]").bind('click',function() {
		  var a = $(this).attr('value');
		  var change= $("#amount").val();
		  calculate(change);
		   $('.periods_').css('color','white');
		  $('#period'+$(this).attr('cou')).css('color','#DA114B');
		  
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
		 $("table#tarif_grid tr#item").eq(row).children().eq(period).children().css({background:"blue",color: "white",fontWeight: "bold" } );       	 
		 $("table#tarif_grid tr#item").eq(row).children().eq(period).eq(0).css({background:"blue",color: "white",fontWeight: "bold"} );	 
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
	  
	  $("table#tarif_grid tr#item").eq(row).children().eq(period).children().css({background:"green",color: "white",fontWeight: "bold" } );       	 
	  $("table#tarif_grid tr#item").eq(row).children().eq(period).eq(0).css({background:"green",color: "white",fontWeight: "bold"} );	 
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
 	 len=checks.length;
	 len--;
	 checks=checks[len];	  
	 checks=parseInt(checks);
	 
	 switch(checks) {
	  case 1: return 1;
	  case 3: return 2;
	  case 6: return 3;
	  case 12: return 4;
	 }	
	 	 
	}	
	});
	


</script>

{/literal}


<div>
    <div class="main_top_text">

        {breadcrumb controller="monitoring" alias="monitoring" altTitle="Мониторинг"}
        {include file="lmenu.tpl"}

        <h1>{info name="notarif" what="title"}</h1>
        <p>{info name="notarif"}</p>
        

        <div>

            {form from=$form id=form_}
            {form_errors_summary}
            {form_hidden name="change" value=$change}
             <div id="tarifs" style="margin-bottom:-3px;">
			 {if count($user->getActualTarifInfo()) > 0}
				<b>Изменение текущего тарифа:</b> <span>{$user->getCountMon()}-{$user->getActualTarifInfo()->m }-{$user->getActualTarifInfo()->period/7}</span>
			 </div>
			 {/if}
           		 
			 
			 
			{*$refresh_period*}
			
            	

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
			
            {include file="monitoring/tarif_grid.tpl" form=$form tarifsList=$tarifsList showusertarif=1 skidka=$fparams.skidka}
            
     		 <div style="background-color:#FFE9AE;">
            <p style="line-height: 10px;padding:0px;padding-top:5px;" >	
             <font color="#1f5863">Регулярность мониторинга:</font>
			 <select name="period">
				<option value="7"> 1 неделя</option>
				<option value="14"> 2 неделя</option>
				<option value="27"> 4 неделя</option>
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
<br>
			<div style="float:right;margin-top: -15px;">
				<a href="#" onclick="$('#form_').submit();"><img src="/images/add_order_button.png" border="0"></a>
			</div>
			
			<div style="color:#1f5863">			<b>Общая стоимость : <span id="total_sum" style="color:#DB144D"> </span> &nbsp;руб.</span></div></b>
			
			<input type="hidden" name="mon_price" value="" />
			<input type="hidden" name="mon_discount" value="" />
			
            


            {/form}

            <p></p>
			<br>
            {include file="order/basket_grid.tpl" ischeck=1}


            {if $Basket->isTotalAmountDefined()}
                {if $Basket->getTotalAmount()>$user->balans}
                    <h3>Недосточно средств на личном счете</h3>
                {else}
                    {*<input type="submit" onclick="if (!confirm('С вашего личного счета будет списано {$Basket->getTotalAmount()} руб.')) return false; document.location = '/order/create/';" value="Оплатить" />*}
                    {*<a href="/order/create/" onclick="if (!confirm('С вашего личного счета будет списано {$Basket->getTotalAmount()} руб.')) return false;">Оплатить</a>*}
                {/if}
            {/if}



        </div>


        <div class="dotted2"></div>
    </div>
</div>
{* Release Tpl  *}

<!-- <div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div> -->

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
    function infoBox(id){
            base_h = $('#tarifs').offset().top + 20;
            var id_el = '#description';
            $('.btn_tarif').css('background-color','#1F5863');
            if(change_tarif[id] == undefined || change_tarif[id] == false){
                change_tarif[id] = true;
                $('.btn_tarif_'+id).css('background-color','#DBA108');
            }else{
                change_tarif[id] = false;
                $('.btn_tarif_'+id).css('background-color','#1F5863');
            }
            
            
                $.getJSON('/monitoring/gettarif', {id : id}, function(data){
                
                /*$(id_el+' #count').html(data['count']);
                $(id_el+' #reg').html(data['period']);
                $(id_el+' #time').html(data['m']);
                $(id_el+' #timefor').html(''+data['startDate']+' - '+data['endDateUser']);
                $(id_el+' #dateend').html(data['dateNextMon']);
                $(id_el+' #price').html(data['price']);
                $(id_el+' #event').html(data['event']);
                $(id_el+' #count_kontr').html(data['count_kontr']);
                */
                
                $('#amount').val(data['count']);
                $('select[name=period]').val(data['period']);
                $('input[name=m][cou='+data['m']+']').click();
                $('input[name=m][cou='+data['m']+']').change();
                $('input[name=country_tarif][value='+data['country']+']').click();
                $('input[name=country_tarif][value='+data['country']+']').change();
                
                
                
            /*  if(data['type_tarif'] == 1)
                {
                    $('.noHistory').hide();
                }
                else
                {
                    $('.noHistory').show();
                }*/
                });
                /*
                $(id_el).addClass('events_info_block');
                $('#description').css('left',($('#tarifs').offset().left-300)+'px');
                $(id_el).offset({top:base_h - $(id_el).outerHeight()});
                
                $(id_el).show();*/
                
                
                
    var change= $("#amount").val();
          calculate(change);
        
        }
    
        
     $(document).ready(function() {
     
    $('.btn_tarif').mouseout(function (){
        
            /*var id_el = '#description';
            
                $(id_el).hide();*/
                //$('#hide_info').click();
                $('#description').hide();
    });
    $('.btn_tarif').mouseover(function (kmouse){
            id = $(this).attr('val2');
            base_h = kmouse.pageY + 20;
            base_w = kmouse.pageX ;
            var id_el = '#description';
            $('.btn_tarif').css('background-color','#1F5863');
            if(change_tarif[id] == undefined || change_tarif[id] == false){
                change_tarif[id] = true;
                $('.btn_tarif_'+id).css('background-color','#DBA108');
            }else{
                change_tarif[id] = false;
                $('.btn_tarif_'+id).css('background-color','#1F5863');
            }
            
            
                $.get('/monitoring/tarifinfo', {tarif_id : $(this).attr('val')}, function(data){
                    $('#conteiner_info').html(data);
            /*  if(data['type_tarif'] == 1)
                {
                    $('.noHistory').hide();
                }
                else
                {
                    $('.noHistory').show();
                }*/
                });
                $(id_el).addClass('events_info_block');
                //$('#description').css('left',($('#tarifs').offset().left-300)+'px');
                //$(id_el).offset({top:base_h - $(id_el).outerHeight()});
                //alert(base_h);
                //alert($(id_el).offset().top);
                //$(id_el).offset({top:base_h, left:(base_w - $(id_el).outerWidth()/2)});
                //$(id_el).offset({left:base_w - $(id_el).outerWidth()/2});
                $(id_el).css('top',base_h).css('left', base_w);
            
                //alert($(id_el).offset().top);
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
           alert('Сумма нового тарифа должна превышать остаток с предыдущих тарифов');
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
    //   if ($('[name=period]:visible').size() == 0)
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
        //  alert(price);
          $("input:hidden[name=price_one]").val(price); // цена за одну штуку   
          
          between=checkBetween(rowN);
        //  alert(between);
          between*=total*mult;
          if (isNaN(between)) between=0;
          if (isNaN(sum)) sum=0; 

          $("#ackiya").text(between);
        //  alert(sum+'='+between);
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
            //   alert(cur);
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
        //  alert(checks);
          checks=checkNumber(checks);
          var price=$("table#tarif_grid tr#item").eq(row).children().eq(checks).text(); 
            $("table#tarif_grid tr#item td[align=left]").css('color','#1F5863');          
            $("table#tarif_grid tr#item").eq(row).children().eq(checks).css('color','#ff0000');       
          return parseInt(price);       
        }
        
        $("input[name=m]").live('click',function() {
          var a = $(this).attr('value');
          var change= $("#amount").val();
          calculate(change);
          setTimeout(updateNewNameTarif,500);
          /*$('.periods_').css('color','white');
          $('#period'+$(this).attr('cou')).css('color','#DA114B');*/
          
        });
        $("input[name=country_tarif]").live('change',function() {
          $("input[name=country_tarif2][value="+$(this).attr('value')+"]").click();
          var a = $(this).attr('value');
          //alert(a);
          $('[name=type_event]').hide();
          $('.countr_'+$(this).attr('value')).show();
          var change= $("#amount").val();
          calculate(change);
          setTimeout(updateNewNameTarif,50);
          $('.country_').css('color','#FF8C00');
          $('#country_'+$(this).attr('value')).css('color','#DA114B');
          
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
    
    /* len=checks.length;
     len--;
     checks=checks[len];      
     checks=parseInt(checks);
     
     switch(checks) {
      case 1: return 1;
      case 3: return 2;
      case 6: return 3;
      case 12: return 4;
     }  */
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
    

    
    
    $('.main_t').click(function(){
        n_cat = '';
        $('.submain_t').hide();
        $('span[val="all"]').show();
        $('.main_t').removeClass("active");
        $('.submain_t').removeClass("active");
        $(this).addClass('active');
        $('.submain_t[val2="'+$(this).attr('value')+'"]').show();
        $('.submain_t[val2="'+$(this).attr('value')+'"]:first').click();
        
        updateNewNameTarif();
        //setTimeout(updateNewNameTarif,50);
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
        $(this).addClass('active');
        //$('.submain_t[val2="'+$(this).attr('value')+'"]').show();
        /*$('#tarif_grid tr.cl').hide();
        $('#tarif_grid tr.cl'+$(this).attr('value')).show();*/
        $('#tarifs span').hide();
        $('#tarifs span[parent='+$(this).attr('value')+']').show();
        $.post('/monitoring/tarifgridadd/', {tarifsThis : $(this).attr('value'), period : '{/literal}{$refresh_period}{literal}', skidka : '{/literal}{$fparams.skidka}{literal}'}, function(data){
            $('#table_prices').html(data);
            updateNewNameTarif();
        });
        
    });
    $('.main_t:first').click();
    var change= $("#amount").val();
          calculate(change);
});
{/literal}
</script>





{if $Basket->getItems()}

{if !$ischeck}
<p>Список заказов</p>
<p><a href="/order/basketclear/">Очистить корзину</a></p>
  {/if} 

       
<table cellpadding="5" cellspacing="5" border="1">
    <tr>
        <th style="color:#ff9a31"><b>№</b></th>
        {*<th>Раздел</th>*}
        <th style="color:#ff9a31"><b>Тип</b></th>
        <th  style="color:#ff9a31" width="300"><b>Информация</b></th>
        <th style="color:#ff9a31"><b>Цена</b></th>
        <th style="color:#ff9a31"><b>Действия</b></th>
    </tr>
    {foreach from=$Basket->getItems() key=key item=item}
    <tr>
        <td>{$key+1}</td>
        {*<td>{$item->getPricesObject()->getGroupName()}</td>*}
        <td>{$item->getPricesObject()->getName()}</td>
        <td>{$item->getInfoString()}<br>
        
           {if $item->typeId==41}
              Страна:
              {$item->country_name}<br>
              Период:
              {$item->m}<br>
              Регулярность:
              {$item->period} <br>
              Количество компаний:  
              {$item->mon_count }
          {/if}
          {*Адрес: {$item->getAdress()}*}
          </td>
        <td>{$Basket->getElementPriceString($key)}</td>
        <td><a href="javascript:void(0);" onclick="if (!confirm('Удалить данный элемент из корзины?')) return false; else delete_from_basket({$key});">удалить</a></td>
    </tr>
    {/foreach}





</table>
{literal}
<script type="text/javascript">
function delete_from_basket(key){
$.post('/order/basketdelete/bid/'+key+'/', {}, function(data){
			window.location.reload(true);
		});
}
</script>
{/literal}
<div style="float: right;color:#2c7f8e">Всего элементов в корзине: {$Basket->getCount()}{if $Basket->isTotalAmountDefined()} на сумму {$Basket->getTotalAmountString()}{/if}</div>
<div class="otder_order">



{* if !$user->getId() || $Basket->isBalans() || !$Basket->isTotalAmountDefined()}
        <div class="button">
            <a class="pay_all" href="/order/create/" title="Оплатить"
                onclick="if (!confirm('С вашего личного счета будет списано {$Basket->getTotalAmount()} руб.')) return false;">
                Оплатить
            </a>
        </div>
    {else *}
    {if $Basket->getTotalAmount()>$user->balans}
        {math assign=balans_pay equation="x - y" x=$Basket->getTotalAmount() y=$user->balans}
        
            <font style="color:#d9124b">Недостаточно средств на личном счете</font> | Для активации услуги необходимо доплатить {$balans_pay} руб.
            <br>
            
            {if $user->login != ""}
              <div style="float:right">
              <input type="button" onclick="location.href='/order/balans/col/{$balans_pay}'" style="font-size:17px;" value="Пополнить баланс">
              </div>
            {/if}

            {if $user->login != ""}
              <input type="button"  onclick="location.href='/order/balans/col/{$balans_pay}'" value="Отложить заказ">
            {/if}
            
            
        
        {else}
            {*
            <div class="button">
                <a class="pay_all" href="/order/create/" title="Оплатить"
                    onclick="if (!confirm('С вашего личного счета будет списано {$Basket->getTotalAmount()} руб.')) return false;">
                        <!-- Оформить заказ -->
                </a>
            </div>
            *}
            <div class="button">
                Вы покупаете услугу в соответствии с договором от {$user->createDate|date_format:"%e.%m.%Y"}.<br>
                {*<div style="float:right">
                <input type="submit" style="font-size:17px;" class="pay_all" title="Активировать услугу"
                    onclick="if (!confirm('С вашего личного счета будет списано {$Basket->getTotalAmount()} руб.')) return false; document.location = '/order/create/';" 
                value="Активировать услугу"/> &nbsp;&nbsp;&nbsp;
                </div>*}
                &nbsp;&nbsp;&nbsp;<input type="button" onclick="document.location = '/order/cancel/';" value="Отложить заказ">
        
            </div>
    {/if}



</div>


{if !$ischeck}
    {if !$user->getId() || $Basket->isBalans() || !$Basket->isTotalAmountDefined()}
        <p><a href="/order/create/"><img src="/images/zakaz_na_vse.png"></a></p>
    {else}
         {if $Basket->getTotalAmount()>$user->balans}
            <h3>Недосточно средств на личном счете</h3>
         {else}
         <form action="/order/basket/" method="POST">
            <input type="hidden" value="{$Basket->getTotalAmount()}" name="totalamount">
            <input type="submit" onclick="if (!confirm('С вашего личного счета будет списано {$Basket->getTotalAmount()} руб.')) return false; document.location = '/order/basket/';" value="Оплатить" />
          </form>


         {/if}
    {/if}
{/if}




          
        
          




{else}
<p>Корзина пуста</p>
{/if}

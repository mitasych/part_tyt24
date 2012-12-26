{popup_init src='/javascripts/overlib/overlib.js'} 
<!-- <script type="text/javascript" src="/jQuery/jQuery.js"></script>
<script type="text/javascript" src="/jQuery/interface.js"></script>
<script type="text/javascript" src="/jQuery/jquery.easytooltip.js"></script> --> 
{literal} 

    <script type="text/javascript" src="/scripts/js/jquery.custom_radio_checkbox.js"></script>
    <script type="text/javascript" src="/scripts/ExpandSelect_1.00.js"></script>
    <link rel="stylesheet" href="/style/reset.css">

    <script language="javascript">

    function updateInput(id,value){
            if($('#'+id).val() != value){
                    $('#'+id).css('color','black');
            }
	
            return true;

    }
    $(document).ready( function () 
    {
        jQuery('.radio').dgStyle();
            
        jQuery('input[type=radio][name=isoff]').live('change',function() {
            var parent = jQuery(this).parent().parent().parent().parent().parent();
            jQuery('input[type=radio][name=type_r]', parent).parent().click();    

        });
            
            
    //$("#cargoname").css("color","gray");
    //$("#cargoname2").css("color","gray");
    //$("#cargoname3").css("color","gray");
    $('#docs2 input[type="checkbox"]').click(function(){
            $('#docs1 input[type="checkbox"]').attr("checked","");
            $('#docs1 .checkbox').css('background-position','0px 0px');
	
    });
    $('#docs1 input[type="checkbox"]').click(function(){
            $('#docs2 input[type="checkbox"]').attr("checked","");
            $('#docs2 .checkbox').css('background-position','0px 0px');
            $('#docs2 .document_hint_elements').hide();
    });

    $("input[name=between]").attr("value","ua");

    $("table.ozt input[type=radio]:checked").each(function(){
       $(this).nextAll().filter("td p:first").addClass("red");
      });
  
      $("table.ozt td p").hover(
        function(){
          $(this).addClass("red");
        },
        function(){
          $(this).removeClass("red"); 
        });


      $("table.ozt td p").click(
        function(){
          $(this).prevAll().addClass("red").filter("input:radio:first").attr("checked","checked").change().click();
	  
        $("table.ozt td p input[type=radio]").not(":checked").each(function(){
         $(this).nextAll().filter("td p:first").removeClass("red");
        });

      });
       


      $("table.ozt input[type=radio]").click(function(){

        $("table.ozt input[type=radio]").not(":checked").each(function(){
         $(this).nextAll().filter("td p:first").removeClass("red");
        });

       $(this).nextAll().filter("td p:first").addClass("red");

      });
  
            $("#innogrn span").click(function(){

                    alert('kkk');
      // alert($(this).html());

            });


  
            $("#innogrn span").click(function(){

                    alert('kkk');
      // alert($(this).html());

            });
  
      check=$("#ru_main input[name=add1]").attr("value");

            need=String($("#ru_info input:radio:checked:first").attr("value"));         
            $('#priceBox').html($('#priceBoxHidden'+need).html());
                    //console.log($('#priceBoxHidden'+need).html());


    //rbutton_inf obutton_inf


    /* НИЧЕГО НЕ МЕНЯТЬ в ftp://admin@213.133.125.238/www/egr.su/public_html/scripts/js/custom-form-elements.js РАБОТАЕТ ВСЕ, ТОЛЬКО В IE НАДА ЕЩЕ НАЖАТЬ В КАКОЕ НИБУДЬ ДРУГОЕ МЕСТО ПОСЛЕ ВКЛЮЧЕНИЯ КНОПКИ!!! ( */

    $(".report_info_item_checker input[type=radio][name=type_r]").live('change',function(){

        //console.log('change');
	
            $(".ordr_link").removeClass("ordr_link_unblock").attr("dalee", "off");
            $(document).find(".quantity").attr('readonly', 'readonly');
            $(".document_check input[type=checkbox]").removeAttr('checked');
            $(".document_price").show();
            $(".document_hint_elements").hide();
            //$(".document_check input[type=checkbox]").attr('disabled', 'disabled');
            $(".report_info_item input.all_quantity").val(1);
            $("#itogo").html("0 руб.");
            var parrent = $(this).parent().parent().parent().parent().parent().parent();
            if ($(this).val() == 1) {
                if ($('#isoff_o', parrent).length != 0) {
                    $('#isoff_o', parrent).attr('checked', 'checked');
                } else if ($('#isoff_s', parrent).length != 0) {
                    $('#isoff_s', parrent).attr('checked', 'checked');
                }
            } else {
                $('#isoff_o[name=isoff]').removeAttr('checked');
                $('#isoff_s[name=isoff]').removeAttr('checked');
                $('#isoff_o[name=isoff]').parent().css('background-position', '50% 0px');
                $('#isoff_s[name=isoff]').parent().css('background-position', '50% 0px');
                    
            }
                
            
            //if( this.checked ){
            
                    $("input.quantity", parrent).val(1);
	
                    $(".ordr_link", parrent).addClass("ordr_link_unblock").attr("dalee", "on");
                    $(".quantity", parrent).removeAttr("readonly");	
                    $(".document_check input[type=checkbox]", parrent).removeAttr('disabled');
            //}
            /*else {
                    $(".ordr_link", parrent).removeClass("ordr_link_unblock");
            }*/
    });

            $(".obutton>a").click(function(){
                    if($(this).attr("dalee") == "off"){
                            return false;
                    }
            });
	
	
                    /*
	
    <li>
      <div class="document_check">
            <label>
              <input type="checkbox" id="" name="" class="styled" />
              <span> устав </span> 
            </label>
            <span class="document_price"> 100 руб. </span>
            {form_hidden name="" id="" class="cost" value="100 руб."}
      </div>
      <div class="document_hint_elements">
            <div class="rbutton"> <span> кол-во: </span><br />
              {form_text name="cdd1" id="" class="input_field quantity" value="1"} 
            </div>
            <div class="other_info"> <span class="other_info_price"> 100 руб. за документ</span> </div>
      </div>
    </li>	
	
            */
	


    $(".document_hint_elements input.quantity").keypress( function(evt) {
                    var charCode = get_char_code(evt);
                    if ((charCode<48 || charCode>57) && charCode!=8 && charCode!=37 && charCode!=39) 
                      return false; 
            }).keyup( function(){
                    if($(this).val()!='')
                            get_count_cost($(this));
            }).blur( function(){
                    if($(this).val()=='')
                            $(this).val(1);
                    get_count_cost($(this));
            });	
	
    $(".document_check input[type=checkbox]").change(function(){	
            var parent = $(this).parent().parent();
            var parent_info = parent.parent();
	
            if(this.checked){
                    parent.find(".document_price").hide();
                    parent_info.find(".document_hint_elements").slideDown();
                    parent_info.find("input[type=text].quantity").val(1);
            }
            else {
                    parent.find(".document_price").show();
                    parent_info.find(".document_hint_elements").slideUp();
                    parent_info.find("input[type=text].quantity").val(1);
            }
	
            get_count_cost($(this));
    });



    $('#docs1 input[type="checkbox"]').attr('disabled','');
    $('#docs2 input[type="checkbox"]').attr('disabled','');	

    //var cur_reg_code = $('.select select')val()
	
    set_link_region();

    })
    
    function set_link_region(code)
	{
    	var code_current = $('.select select').val();
    	console.log(code_current);
    	var select_region_text = $('.select select option[value="'+code_current+'"]').html();
    	if(select_region_text == null){
    		select_region_text = 'нет доставки';
        }
    	var link_region = '<a href="javascript:void(0)" onclick="showRegions()">'+select_region_text+'</a>';
    	$('div.link_over_region').show().html(link_region);
    	
    }

    showDropdown = function (element) {
        var event;
        event = document.createEvent('MouseEvents');
        event.initMouseEvent('mousedown', true, true, window);
        element.dispatchEvent(event);
    };
    
    function showRegions()
    {
    	ExpandSelect("of_reports_regions");
	}



    function get_char_code(evt)
    {
            if (!evt) evt = event; 
                    if (evt.charCode) 
                      var charCode = evt.charCode; 
                    else if (evt.keyCode) 
                      var charCode = evt.keyCode; 
                    else if (evt.which) 
                      var charCode = evt.which; 
                    else 
                      var charCode = 0; 
            return charCode;
    }
 
    function get_count_cost(_this)
    {
            var parent_info = $(_this).parent().parent().parent().parent();
            var all_parent_block = parent_info.parent().parent().parent();
            var allcost = 0;
            var all_quantity = 0;
            var eles = $(".document_check input[type=checkbox]", parent_info);
            for (var i = 0; i < eles.length; i++) {
		
                    var p = $(eles[i]).parent().parent().parent();
		
                    if(eles[i].checked)
                    {
                            var q = p.find("input[type=text].quantity").val();
                            all_quantity += parseInt(q, 10);
                            var c = p.find("input[type=hidden].cost").val().replace(/[^\d]/ig,"");
                            if(q === undefined) q = 1;
                            allcost += parseInt(q, 10) * parseInt(c, 10);
                    }
            }		
            $("#itogo", all_parent_block).html(allcost + " руб.");
            $("input.all_quantity", all_parent_block).val(all_quantity);
    }
  
    function checkForm() {
        try {
            var result = true;
             $('form input').each(function() { 
                if ($(this).is(':visible') && typeof $(this).attr('required') != 'undefined' && $(this).val() == ''){
                    alert('Заполните обязательные поля отмеченные звездочкой');
                    result = false;
                    return false;
                }
             });
             if (!result) {
                 return false;
            }
             if ($('#cargoname').attr('value') == "" && $('#cargoname2').attr('value') == "" && $('#cargoname3').attr('value') == "") {

                if (!$('#isfiz1st').attr('checked') && $('#fizcheck').css('display')=='block'  ) {
                    return true;
                }

                if (parseInt(add1val) == 9) {
                    return true;
                }

                var naz=$('#naz').html();
                //alert('Введите хотя бы одно из полей '+naz+'/ИНН/ОГРН');
                alert('Введите '+naz);

                $('#cargoname').focus();

                return false;
              }

            if (parseInt(add1val) == 6) {
                
                if ($('#destcountry').selectedIndex == 0) {

                        alert('Выберите страну');

                        $('#destcountry').focus();

                        return false;

                  }

                if ($('#destcity').attr('value') == "") {
                   alert('Введите адрес');
                    $('#destcity').focus();
                    return false;
              }
        }
          return true;
        } catch(e) {
          alert(e);
          return false;
        }
    }

    function swisogrn() {
        $('#cargoname2').attr('value', '');
        $('#cargoname3').attr('value', '');
        $('#cargoname2').toggle();
        $('#cargoname3').toggle();
    }

    function isfizswitch(val) {

        $('#fizf').attr('value', '');
        $('#fizi').attr('value', '');
        $('#fizo').attr('value', '');

        if (val == 1) {
            $('#fizblock').show();
            $('#innogrn').hide();
            $('#fiznaimrequired').hide();
        } else {
            $('#fizblock').hide();
            $('#innogrn').show();
            $('#fiznaimrequired').show();
        }
    }
    function chcargo2() {
        if ($('#cargoname2').val()) {
            $('#add_to_monitoring_c').show();
        } else {
            $('#add_to_monitoring').removeAttr('checked');
            $('#add_to_monitoring_c').hide();
        }
    }

    /*function show_hint_elem(elem){
            if($('.warning_info_content_bg').is(':visible')){
                    $('' + elem).hide();
            }
            else {
                    $('' + elem).show();
            }
            return true;
    }*/
    function show_hint_elem(elem, el){
            if($(elem).is(':visible')){
                    $(elem, jQuery(el).parent()).hide();
            }
            else {
                    $(elem, jQuery(el).parent()).show();
            }
            return true;
    }


    </script>
    <style>

        .ozt td {
            background:none;
            padding:0px 5px 0 0;
            margin:0;
        }
        .ozt td p{
            margin:0px 0px;
            margin-bottom:3px;
        }
        #ru_info td font
        {
            color:inherit;
            font-weight:normal;
        }
        #report_info strong
        {
            color:inherit;
            font-weight:normal;
        }
        .report_info strong
        {
            color:inherit;
            font-weight:normal;
        }

    </style>
{/literal}

{if !$hidelayout}
    <div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
        <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}> </div>
        <div>
            <div class="main_top_text">
                {breadcrumb controller="info" alias="check" title=$currentInfo->getTitle() altTitle="Форма заказа на проверку контрагента"}
                <h1>{info name="check" what="title"}</h1>
                <p>{info name="check"}</p>
            {/if}


            {form from=$form onSubmit="return checkForm()"}
            {form_errors_summary}
            <label>
                <input type="hidden" name="action" value="send">
            </label>

            {foreach from=$pricesOutput key=pid item=phtml}
                <div style="display:none;" id="priceBoxHidden{$pid}">{$phtml}</div>
            {/foreach}
            <table class="ozt" style="margin-bottom:25px;" style='width: 100%;'>
                <tr> 

                    <!--<td></td>-->
                    <td> {*}
                        <p><em style="color:#FF0000">Страна</em> &nbsp;&nbsp;&nbsp;&nbsp;{form_select name="country_ord" id="country_ord" selected=$select_co options=$ListContry style="width:150px;"}</p>
                        {*}
                        {*
                        <p><b style="color:#005fb1">Выбор отчета:</b></p>
                        *}</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;"><div id="change_country" >
                            <div id="ru_info">
                                <table style='width: 100%;'>
                                    <tr>
                                        <th align=left valign=middle> 
                                            <b class="op_table_title">Выбор отчета:</b> <br><br>
                                        </th>
                                        <th>
                                            <b class="op_table_title" style="margin: 0 5px 0 0;">
                                                Инфо
                                            </b><br><br>
                                        </th>
                                        <th align=left valign=middle> 
                                            <img src='/images/inf_main_b_new.png' style='float:left; margin: 0 4px 0 3px;'>
                                            <b class='inf op_table_title'>Информационный отчет:</b>
                                            <br>
                                            доставка на Email 
                                        </th>
                                        <th>
                                        </th>
                                        {if $sys_ofreports == 1}
                                        <th align=left valign=middle width=290> 
	                                        <div class="fleft">
	                                            <img src='/images/off_main_b_new.png' style='float:left; margin: 0 4px 0 3px;'>
	                                            <b class='off op_table_title'>Официальный отчет:</b>
	                                            <br>
	                                            доставка курьером 
	                                        </div>
	                                        <div class="select" style="position: relative">
	                                        	<select name="of_reports_regions" id="of_reports_regions">
	                                        		{foreach from=$listOfreports key=key item=region}
	                                        			<option value="{$region->region_code}" {if $region->region_code==77}selected="selected"{/if}>{$region->order_report_region}</option>
	                                        		{/foreach}
	                                        	</select>
	                                        	<div class="link_over_region"></div>
	                                        </div>
                                        </th>
                                        {/if}
                                    </tr>
                                    {assign var="isinffull" value=0}
                                    {assign var="isoffffull" value=0}
                                    {foreach from=$reports key=key item=item}
                                        {if $item->title_order}
                                            <tr  class="contry_{$item->country} {cycle values=width,grey} {$key+1} report_{$item->id} report_row" >
                                                <td width="200px">
                                                    <label style="font-weight: bold;">
                                                        <div class="radio">
                                                            <input type="radio" alt="{$item->type}" name="add1" value="{$item->id}" {if $fparams.id == $item->id}checked="checked"{/if}>
                                                        </div>
                                                        {$item->title_order}&nbsp;&nbsp; 
                                                    </label>
                                                    <div class="report_info reseting_report_info" >
                                                        <div class="report_info_vot_suda"></div>
                                                    </div>
                                                </td>
                                                
                                                {if $sys_ofreports == 1}
                                                <td width="70px" align="center" style="position: relative;" >
                                                    <span class="read_more_info" onmouseover="show_hint_elem('.title_el_{$key}', this);" 
                                                          onmouseout="show_hint_elem('.title_el_{$key}', this);">читать инфо</span>
                                                    {if $item->text_mini}
                                                        <div class="report_info_item_hint_elem title_el_{$key}"> {$item->text_mini} </div>
                                                    {/if}
                                                </td>
                                                {else}
                                                <td width="290px" align="center" style="position: relative;" >
                                                    {if $item->text_mini}
                                                        <div class="report_info_item_hint_elem title_el_{$key}" style="display: block; position: static; width: 220px; margin-bottom: 7px;"> {$item->text_mini} </div>
                                                    {/if}
                                                </td>
                                                {/if}
                                                
                                                <td width=220px class='price inf'> {*if $item->flag1*}
                                                    <div class='report_info_main'> 
                                                        <img src=/images/inf_main_g_new.png title='Информационная' style='position:relative; top:3px;'>
                                                        <b style='margin-left:5px;'>{if $item->flag1}{$item->getPricesOutput(1, true)} {else}---{/if}</b> {assign var="isinffull" value=1}
                                                        
                                                    </div>
                                                    {*if $item->example_url*}
                                                    {if $item->price}
                                                        <div class="report_info reseting_report_info">
                                                            <div class="report_info_items">
                                                                {if $item->title_order == 'дубликаты документов'}
                                                                    <div class="report_info_item">

                                                                    </div>
                                                                    <div class="report_info_item">
                                                                        <ul id="docs1">
                                                                            <!--<li> <b style="color:#FF0000">*</b>Документы: </li>-->
                                                                            <li>
                                                                                <div class="document_check">
                                                                                    <label>
                                                                                        <input type="checkbox" id="" name="" class="styled" />
                                                                                        <span> устав </span> 
                                                                                    </label>
                                                                                    <span class=""> 100 руб. </span>
                                                                                    {form_hidden name="" id="" class="cost" value="100 руб."} 
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="document_check">
                                                                                    <label>
                                                                                        <input type="checkbox" id="" name="" class="styled"  />
                                                                                        <span> учредительный договор </span> </label>
                                                                                    <span class=""> 100 руб. </span>
                                                                                    {form_hidden name="" id="" class="cost" value="100 руб."} 
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="document_check">
                                                                                    <label>
                                                                                        <input type="checkbox" id="" name="" class="styled"  />
                                                                                        <span> протокол собрания учредит. </span> </label>
                                                                                    <span class=""> 100 руб. </span>
                                                                                    {form_hidden name="" id="" class="cost" value="100 руб."} 
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="document_check">
                                                                                    <label>
                                                                                        <input type="checkbox" id="" name="" class="styled"  />
                                                                                        <span> решение о создании </span> </label>
                                                                                    <span class=""> 100 руб. </span>
                                                                                    {form_hidden name="" id="" class="cost" value="100 руб."}
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="document_check">
                                                                                    <label>
                                                                                        <input type="checkbox" id="" name="" class="styled"  />
                                                                                        <span> свидетельство ИНН </span> </label>
                                                                                    <span class=""> 100 руб. </span> 
                                                                                    {form_hidden name="" id="" class="cost" value="100 руб."}
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="document_check">
                                                                                    <label>
                                                                                        <input type="checkbox" id="" name="" class="styled"  />
                                                                                        <span> свидетельсвто ОГРН </span> </label>
                                                                                    <span class=""> 100 руб. </span>
                                                                                    {form_hidden name="" id="" class="cost" value="100 руб."} 
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="report_info_item">
                                                                        <div class="report_info_item_summa">
                                                                            <label>Сумма: </label>
                                                                            <span id="itogo">0 руб.</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            {else}
                                                                <div class="report_info_item">
                                                                    <div class="report_info_item_checker">
                                                                        <label>
                                                                            {*if $item->flag2 || $item->flag3*}
                                                                            {if 1}
                                                                                <div class="radio">
                                                                                <input type="radio" name="type_r" id="type_r_inf" value="0" checked="checked">
                                                                                </div>
                                                                            {else}
                                                                                <input type="radio" name="type_r" id="type_r_inf" value="0" style="display: none;">    
                                                                            {/if}
                                                                            
                                                                                <span><b>{if $item->flag1}{$item->getPricesOutput(1,true)}{else}---{/if}</b></span>
                                                                            <label>
                                                                                <label>(до 30 мин)</label>
                                                                    </div>
                                                                </div>
                                                                                <div class="report_info_item">
                                                                                    <div class="rbutton"> </div>
                                                                                    <div class="price"> 
                                                                                        <span>Скидки</span>
                                                                                        <label>до {$maxdisc}%</label>

                                                                                        <label class="warning_info">

                                                                                            <img src="/images/warning_small_green.png" 
                                                                                                 onmouseover="show_hint_elem('.warning_info_content_bg', this);" 
                                                                                                 onmouseout ="show_hint_elem('.warning_info_content_bg', this);"/>
                                                                                            <div class="warning_info_content_bg">
                                                                                                <div class="warning_info_content">
                                                                                                    <div class="warning_info_content_header">
                                                                                                        Скидка
                                                                                                    </div>
                                                                                                    <div>

                                                                                                        {foreach from=$disc[1] item=item2 key=key}
                                                                                                            от {$item2} руб. - {$disc[2][$key]}%
                                                                                                            <br>
                                                                                                        {assign var="discout" value=$disc[2][$key]}{/foreach}
                                                                                                        <br>
                                                                                                        <div style="font-size:11px;">Скидки действуют на информационные<br> отчеты при заказе<br> более одного отчета.</div>
                                                                                                    </div>
                                                                                                </div>									
                                                                                            </div>

                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="report_info_item">
                                                                                    <div class="rbutton"> </div>
                                                                                    <div class="price"> 
                                                                                        <span> 
                                                                                            <a href='{$item->example_url}'>пример</a> 
                                                                                        </span>
                                                                                        <label>без заверения</label>
                                                                                    </div>
                                                                                </div>
                                                                            {/if}
                                                                            <div class="report_info_item">
                                                                                <div class="rbutton"></div>
                                                                                <div class="obutton"> 
                                                                                    <a class="ordr_link ordr_link_block ordr_link_unblock" href="#" onclick="basketAdd(this)" dalee="on">В КОРЗИНУ</a> 
                                                                                </div>
                                                                            </div>						
                                                                            </div>
                                                                            </div>
                                                                        {/if}
                                                                        {*/if*}&nbsp; 
                                                                        </td>
                                                                        {if $sys_ofreports == 1}
                                                                        <td width=10px>&nbsp;</td>
                                                                        <td width=220px class='price off'> {*if $item->flag2*}
                                                                            <div class='report_info_main'> 
                                                                                <img src="/images/off_main_g_new.png" title='Официальная' style='position:relative; top:3px;'>
                                                                                <b style="margin-left:5px;">{if isset($item->ofreport) && isset($item->ofreport->flag1)}{$item->ofreport->getPricesOutput(1,true)}{elseif isset($item->ofreport) && isset($item->ofreport->flag2)}{$item->ofreport->getPricesOutput(2,true)}{else}---{/if}</b> {assign var="isoffffull" value=1} 
                                                                            </div>
                                                                            {*if $item->example_off_url*}				
                                                                            {*if $item->price2*}
                                                                            <div class="report_info reseting_report_info">
                                                                                <div class="report_info_items">
                                                                                    {if $item->title_order == 'дубликаты документов'}

                                                                                    	{*if $item->flag2*}
                                                                                        {if isset($item->ofreport) && isset($item->ofreport->flag1)}
                                                                                            <div class="report_info_item">
                                                                                                  <div class="report_info_item_checker">

                                                                                                    <label>
                                                                                                        <div class="radio">
                                                                                                            <input type="radio" name="isoff" id="isoff_o" value="0" checked="checked">
                                                                                                        </div>
                                                                                                        Обычная ({$item->ofreport->getTimePrint2(1)}) {$item->ofreport->getPricesOutput(1,true)}
                                                                                                    </label>
                                                                                                    <br>
                                                                                                </div>
                                                                                            </div>
                                                                                        {/if}
                                                                                        {if isset($item->ofreport) && isset($item->ofreport->flag2)}
                                                                                            <div class="report_info_item">
                                                                                                  <div class="report_info_item_checker">
                                                                                                    <label>
                                                                                                        <div class="radio">
                                                                                                            <input type="radio" name="isoff" id="isoff_s" value="1" checked="checked">
                                                                                                        </div>
                                                                                                         Срочная ({$item->ofreport->getTimePrint2(2)}) {$item->ofreport->getPricesOutput(3,true)}
                                                                                                    </label>

                                                                                                  </div>
                                                                                            </div>
                                                                                        {/if}
                                                                                        <div class="report_info_item">
                                                                                            <ul id="docs2">
                                                                                                <!--<li> <b style="color:#FF0000">*</b>Документы: </li>-->
                                                                                                <li>
                                                                                                    <div class="document_check">
                                                                                                        <label>
                                                                                                            <input type="checkbox" id="" name="" class="styled" />
                                                                                                            <span> устав </span> 
                                                                                                        </label>
                                                                                                        <span class="document_price"> 100 руб. </span>
                                                                                                        {form_hidden name="" id="" class="cost" value="100 руб."} 
                                                                                                    </div>
                                                                                                    <div class="document_hint_elements">
                                                                                                        <div class="rbutton"> <span> кол-во: </span><br />
                                                                                                            {form_text name="cdd1" id="" class="input_field quantity" value="1"}
                                                                                                        </div>
                                                                                                        <div class="other_info"> <span class="other_info_price"> 100 руб. за документ</span> </div>
                                                                                                    </div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="document_check">
                                                                                                        <label>
                                                                                                            <input type="checkbox" id="" name="" class="styled"  />
                                                                                                            <span> учредительный договор </span> </label>
                                                                                                        <span class="document_price"> 100 руб. </span>
                                                                                                        {form_hidden name="" id="" class="cost" value="100 руб."} 
                                                                                                    </div>
                                                                                                    <div class="document_hint_elements">
                                                                                                        <div class="rbutton"> <span> кол-во: </span><br />
                                                                                                            {form_text name="cdd2" id="" class="input_field quantity" value="1" onblur="if($(this).attr('value') == '')$(this).attr('value','1');" 
									onfocus="if($(this).attr('value') == '1')$(this).attr('value','');"}
                                                                                                        </div>
                                                                                                        <div class="other_info"> <span class="other_info_price"> 100 руб. за документ</span> 
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="document_check">
                                                                                                        <label>
                                                                                                            <input type="checkbox" id="" name="" class="styled"  />
                                                                                                            <span> протокол собрания учредит. </span> </label>
                                                                                                        <span class="document_price"> 100 руб. </span>
                                                                                                        {form_hidden name="" id="" class="cost" value="100 руб."} 
                                                                                                    </div>
                                                                                                    <div class="document_hint_elements">
                                                                                                        <div class="rbutton"> <span> кол-во: </span><br />
                                                                                                            {form_text name="cdd3" id="" class="input_field quantity" value="1" onblur="if($(this).attr('value') == '')$(this).attr('value','1');" 
									onfocus="if($(this).attr('value') == '1')$(this).attr('value','');" } 
                                                                                                        </div>
                                                                                                        <div class="other_info"> <span class="other_info_price"> 100 руб. за документ</span> </div>
                                                                                                    </div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="document_check">
                                                                                                        <label>
                                                                                                            <input type="checkbox" id="" name="" class="styled"  />
                                                                                                            <span> решение о создании </span> </label>
                                                                                                        <span class="document_price"> 100 руб. </span>
                                                                                                        {form_hidden name="" id="" class="cost" value="100 руб."}
                                                                                                    </div>
                                                                                                    <div class="document_hint_elements">
                                                                                                        <div class="rbutton"> <span> кол-во: </span><br />
                                                                                                            {form_text name="cdd4" id="" class="input_field quantity" value="1" onblur="if($(this).attr('value') == '')$(this).attr('value','1');" 
									onfocus="if($(this).attr('value') == '1')$(this).attr('value','');"} 
                                                                                                        </div>
                                                                                                        <div class="other_info"> <span class="other_info_price"> 100 руб. за документ</span> </div>
                                                                                                    </div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="document_check">
                                                                                                        <label>
                                                                                                            <input type="checkbox" id="" name="" class="styled"  />
                                                                                                            <span> свидетельство ИНН </span> </label>
                                                                                                        <span class="document_price"> 100 руб. </span> 
                                                                                                        {form_hidden name="" id="" class="cost" value="100 руб."}
                                                                                                    </div>
                                                                                                    <div class="document_hint_elements">
                                                                                                        <div class="rbutton"> <span> кол-во: </span><br />
                                                                                                            {form_text name="cdd5" id="" class="input_field quantity" value="1" onblur="if($(this).attr('value') == '')$(this).attr('value','1');" 
									onfocus="if($(this).attr('value') == '1')$(this).attr('value','');"} 
                                                                                                        </div>
                                                                                                        <div class="other_info"> <span class="other_info_price"> 100 руб. за документ</span> </div>
                                                                                                    </div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="document_check">
                                                                                                        <label>
                                                                                                            <input type="checkbox" id="" name="" class="styled"  />
                                                                                                            <span> свидетельсвто ОГРН </span> </label>
                                                                                                        <span class="document_price"> 100 руб. </span>
                                                                                                        {form_hidden name="" id="" class="cost" value="100 руб."} 
                                                                                                    </div>
                                                                                                    <div class="document_hint_elements">
                                                                                                        <div class="rbutton"> <span> кол-во: </span><br />
                                                                                                            {form_text name="cdd6" id="" class="input_field quantity" value="1" onblur="if($(this).attr('value') == '')$(this).attr('value','1');" 
									onfocus="if($(this).attr('value') == '1')$(this).attr('value','');"}
                                                                                                        </div>
                                                                                                        <div class="other_info"> <span class="other_info_price"> 100 руб. за документ</span> </div>
                                                                                                    </div>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                        <div class="report_info_item">
                                                                                            <div class="report_info_item_summa">
                                                                                                <label>Сумма: </label>
                                                                                                <span id="itogo">0 руб.</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                {else}
                                                                                    {*if $item->flag2 || $item->flag3*}
                                                                                    {if isset($item->ofreport) && (isset($item->ofreport->flag1) || isset($item->ofreport->flag2))}
                                                                                        <div class="report_info_item" style="display:none">
                                                                                            <div class="report_info_item_checker">
                                                                                                <label>
                                                                                                    {if $item->flag1}
                                                                                                        <div class="radio">
                                                                                                            <input type="radio" name="type_r" id="type_r_off" value="1" class="styled">
                                                                                                        </div>
                                                                                                    {else}
                                                                                                        <span style="display:none"><input type="radio" name="type_r" value="1" id="type_r_off" class="styled"></span>
                                                                                                     {/if}   
                                                                                                    <span><b>{if isset($item->ofreport) && isset($item->ofreport->flag1)}{$item->ofreport->getTimePrint2(1)}{elseif isset($item->ofreport) && isset($item->ofreport->flag2)}{$item->ofreport->getTimePrint2(2)}{else}---{/if}</b></span>
                                                                                                    <label>
                                                                                                        <label>(до 5 раб. дней)</label>
                                                                                                </div>
                                                                                            </div>
                                                                                                        {*if $item->flag2*}
                                                                                                        {if isset($item->ofreport) && isset($item->ofreport->flag1)}
                                                                                                        <div class="report_info_item">
                                                                                                              <div class="report_info_item_checker">
                                                                                                                
                                                                                                                <label>
                                                                                                                    <div class="radio">
                                                                                                                        <input type="radio" name="isoff" id="isoff_o" value="0" checked="checked">
                                                                                                                    </div>
                                                                                                                    Обычная ({$item->ofreport->getTimePrint2(1)}) <span class="of-price">{$item->ofreport->getPricesOutput(1,true)}</span>
                                                                                                                    
                                                                                                                </label>
                                                                                                                <br>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        {/if}
                                                                                                        {*if $item->flag3*}
                                                                                                        {if isset($item->ofreport) && isset($item->ofreport->flag2)}
                                                                                                        <div class="report_info_item">
                                                                                                              <div class="report_info_item_checker">
                                                                                                                <label>
                                                                                                                    <div class="radio">
                                                                                                                        <input type="radio" name="isoff" id="isoff_s" value="1" checked="checked">
                                                                                                                    </div>
                                                                                                                     Срочная ({$item->ofreport->getTimePrint2(2)}) <span class="of-price">{$item->ofreport->getPricesOutput(2,true)}</span>
                                                                                                                </label>
                                                                                                                
                                                                                                              </div>
                                                                                                        </div>
                                                                                                        {/if}
                                                                                                        <div class="report_info_item">
                                                                                                            <div class="rbutton"> </div>
                                                                                                            <div class="price"> <span> <a href='{$item->example_off_url}'>пример</a> </span>
                                                                                                                <label>заверено печатью</label>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    {/if}
                                                                                                {/if}
                                                                                                {*if $item->flag2 || $item->flag3*}
                                                                                                {if isset($item->ofreport) && (isset($item->ofreport->flag1) || isset($item->ofreport->flag2))}
                                                                                                    <div class="report_info_item">
                                                                                                        <div class="rbutton">
                                                                                                            {*if $item->title_order != 'дубликаты документов'}
                                                                                                                <span> кол-во: </span><br />
                                                                                                                {form_text name=offcount id="cargoname" class="input_field quantity" value="1" onblur="if($(this).attr('value') == '')$(this).attr('value','1');" 
                                                                                                                    onfocus="if($(this).attr('value') == '1')$(this).attr('value','');" readonly }
                                                                                                            {else}
                                                                                                                <span> итого: </span><br />
                                                                                                                {form_text name=offcount id="cargoname" class="input_field all_quantity" value="0" onblur="if($(this).attr('value') == '')$(this).attr('value','0');" 
                                                                                                                    onfocus="if($(this).attr('value') == '0')$(this).attr('value','');" readonly="readonly" }
                                                                                                            {/if*}
                                                                                                            {if $item->title_order != 'дубликаты документов'}
                                                                                                                <span> кол-во: </span><br />
                                                                                                                {form_text name=offcount id="offcount" class="input_field quantity" value="1" onblur="if($(this).attr('value') == '')$(this).attr('value','1');" 
                                                                                                                    onfocus="if($(this).attr('value') == '1')$(this).attr('value','');" readonly }
                                                                                                            {else}
                                                                                                                <span> итого: </span><br />
                                                                                                                {form_text name=offcount id="offcount" class="input_field all_quantity" value="0" onblur="if($(this).attr('value') == '')$(this).attr('value','0');" 
                                                                                                                    onfocus="if($(this).attr('value') == '0')$(this).attr('value','');" readonly="readonly" }
                                                                                                            {/if}
                                                                                                        </div>
                                                                                                        <div class="obutton"> 
                                                                                                            <a class="ordr_link ordr_link_block" onclick="basketAdd(this)" href="#" dalee="on">В КОРЗИНУ</a> 
                                                                                                        </div>
                                                                                                    </div>
                                                                                                {/if}
                                                                                                </div>
                                                                                                </div>
                                                                                                {*/if*}							
                                                                                                {*/if*}&nbsp; </td>
                                                                                                {/if}
                                                                                                {*
                                                                                                <td colspan="2" style='height:23px'><div style="cursor:pointer; z-index:5; background-color:#fff;top:5px; position:relative; float:right" > {$item->getPricesMin(1)|replace:'-':''} 
                                                                                                {if $item->time}({$item->getTimePrint(1)|replace:'—':''}){/if} </div>
                                                                                                <p>
                                                                                                <label style="cursor:pointer; z-index:5; background-color:#fff; position:relative;" >{form_radio name="add1" value=$item->id checked=$fparams.add1 class="styled"} {$item->title_order}&nbsp;&nbsp;</label>
                                                                                                {if $item->example_url}<a href='{$item->example_url}' style=" z-index:5; background-color:#fff; position:relative;">пример</a>{/if}&nbsp;<!--<img src="/images/ico_que.gif" {popup sticky=true offsetx=-250 snapx=10 snapy=10 trigger='onClick' caption='#item' text='#item'} />--> 
                                                                                                &nbsp;
                                                                                              
                                                                                                <div style='width:100%;  border-bottom:1px dotted #000; bottom:6px; position:relative; z-index:2;'></div></td>
                                                                                                *} </tr>
                                                                                            {/if}
                                                                                        {/foreach}
                                                                                        </table>
                                                                                        </div>
                                                                                        </div>
                                                                                        {*if true || !$user->id}<img width="240" style="position:absolute;" src="/images/paysystem.jpg" />{/if*} 
                                                                                        <!--div id='report_info'>
                                                                                                                        
                                                                                                                </div--></td>
                                                                                        </tr>
                                                                                        </table>
<!--                                                                                        <table width=100%>
                                                                                            <tr>
                                                                                                <td width=400px>
                                                                                                    <p><b style="color:#FF0000">*</b> - поля обязательные для заполнения.<br></p>
                                                                                                </td>
                                                                                                <td rowspan=2 width=370px><table id="type_report">
                                                                                                        <tr>
                                                                                                            <td  width=150px><label>
                                                                                                                    {form_radio name="type_r" id="type_r_inf" checked="0" value="0" class="styled"} Информационная 
                                                                                                                </label></td>
                                                                                                            <td width=10px>&nbsp;</td>
                                                                                                            <td width=150px><label>
                                                                                                                    {form_radio name="type_r" id="type_r_off" checked="0" value="1" class="styled"} Официальная
                                                                                                                </label></td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                    <table>
                                                                                                        <tr>
                                                                                                            <td ><p><b>Цена: </b></p></td>
                                                                                                            <td id='time_title'><p> <b>Сроки:</b></p></td>
                                                                                                            {if !$user->id}
                                                                                                                <td style='position:relative;'><p> 
                                                                                                                        <b>Скидка<b> <img src="/images/action.png" width="15" height="15" 
                                                                                                                                          onmouseover="javascript:$('#disc').toggle();" onmouseout="javascript:$('#disc').toggle();"/>
                                                                                                                                <div id='disc' 
                                                                                                                                     style='position:absolute; top: 20px; left:0px; width:150px; border: 1px solid #000; display:none; background-color: #f8f8f8; padding: 5px;border-radius:5px'>
                                                                                                                                    {foreach from=$disc[1] item=item key=key}
                                                                                                                                        от {$item} руб. - {$disc[2][$key]}%
                                                                                                                                        <br>
                                                                                                                                    {assign var="discout" value=$disc[2][$key]}{/foreach}
                                                                                                                                </div></td>
                                                                                                                            {/if}</tr>
                                                                                                                            <tr>
                                                                                                                                <td><p id="priceBox">&nbsp;</p></td>
                                                                                                                                <td style='vertical-align:top'><p id=time></p></td>
                                                                                                                                {if !$user->id}
                                                                                                                                    <td>до {$discout}%</td>
                                                                                                                                {/if}</tr>
                                                                                                                            <tr>
                                                                                                                                <td colspan="3"><p>&nbsp;</p></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td colspan="3"><p>
                                                                                                                                        <button class="buy_button">
                                                                                                                                            <img src="/images/basket.png" alt="" width="23" height="24" style="vertical-align: middle" />
                                                                                                                                            добавить в корзину
                                                                                                                                        </button>
                                                                                                                                    </p></td>
                                                                                                                            </tr>
                                                                                                                            </table>-->
                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                {/form}
                                                                                                                                <td style="width:300px; vertical-align:top;">


                                                                                                                                    <div id="order_form_hidden" style="display:none">


                                                                                                                                        <div id="ru_main">
                                                                                                                                            <div id="bankrot" {if $fparams.add1 != 9}style="display:none;"{/if}> Подписка на еженедельно публикуемые в газете "Коммерсантъ" сведения о банкротствах предприятий, с дополненными данными из Росстата </div>
                                                                                                                                            <div id="fizcheck" {if $fparams.add1 != 2 || $fparams.add1 != 1}style="display:none;"{/if}>
                                                                                                                                                {*{form_checkbox name="isfiz" id="isfiz" checked=$fparams.isfiz onclick="isfizswitch();"} выписка по физ. лицу*}
                                                                                                                                                {*}  справка по
                                                                                                                                                <label>{form_radio onclick="isfizswitch(0);" name="isfiz" id="isfiz1st" checked="0" value="0" class="styled"} юр. лицу </label>
                                                                                                                                                <label>
                                                                                                                                                {form_radio name="isfiz" onclick="isfizswitch(1);" checked=$fparams.isfiz value="1" class="styled"} физ. лицу
                                                                                                                                                <label>
                                                                                                                                                :{*}
                                                                                                                                                <select name="isfiz" id="isfiz">
                                                                                                                                                    <option value="0" onclick="isfizswitch(0);" {if $fparams.isfiz == 0}selected{/if}>на юр. лицо </option>
                                                                                                                                                    <option value="1" onclick="isfizswitch(1);" {if $fparams.isfiz == 1}selected{/if}>на физ. лицо</option>
                                                                                                                                                </select>
                                                                                                                                                <br>
                                                                                                                                                <br>
                                                                                                                                            </div>
                                                                                                                                            <div id="fiznaimrequired" {if $fparams.isfiz  && $fparams.add1==2}style="display:none;"{/if}>
                                                                                                                                                <b style="color:#FF0000" id="naimrequired">{if $fparams.add1==6}*{else}&nbsp;{/if}</b>
                                                                                                                                                <span id="naz">{if $fparams.add1==3}ФИО ИП{else}Наименование{/if}</span>:<br>
                                                                                                                                                {if $cp_name}
                                                                                                                                                    <input name="cargoname" id="cargoname" value='{$cp_name}' class="input_field">
                                                                                                                                                {else}
                                                                                                                                                    {form_text name=cargoname id="cargoname" class="input_field" placeholder="пример: ООО «Бизнес»"}
                                                                                                                                                {/if}
                                                                                                                                                <br>
                                                                                                                                            </div>
                                                                                                                                            <div id="innogrn" style="{if $fparams.add1 == 6 || ($fparams.add1 == 2 && $fparams.isfiz) }display:none;{/if}"> 
                                                                                                                                                <b style="color:#FF0000">*</b>
                                                                                                                                                <span id="naz">ИНН / ОГРН</span>:<br>
                                                                                                                                                {if !$fparams.isogrn}
                                                                                                                                                    {if $cp_inn}
                                                                                                                                                        <input name="cargoname2" id="cargoname2" value='{$cp_inn}' class="input_field">
                                                                                                                                                    {else}
                                                                                                                                                        {form_text name=cargoname2 id="cargoname2" class="input_field" placeholder="пример: 7717533277" required="true"}<br>
                                                                                                                                                        <span style="display:none;">
                                                                                                                                                        {form_text name=cargoname3 id="cargoname3" class="input_field" placeholder="пример: 7717533277" style="display:none;}<br>
                                                                                                                                                        </span>
                                                                                                                                                    {/if}
                                                                                                                                                {else}
                                                                                                                                                    <span style="display:none;">
                                                                                                                                                    {form_text name=cargoname2 id="cargoname2" class="input_field" placeholder="пример: 7717533277" style="display:none;"}<br>
                                                                                                                                                    </span>
                                                                                                                                                    {form_text name=cargoname3 id="cargoname3" class="input_field" placeholder="пример: 7717533277" required="true"}<br>
                                                                                                                                                {/if}

                                                                                                                                                {if $user->id && $user->useMonitoring}
                                                                                                                                                    <div id="add_to_monitoring_c" {if !$fparams.cargoname2}style="display:none;"{/if}>
                                                                                                                                                        <input id="add_to_monitoring" type="checkbox" name="add_to_monitoring" {if $fparams.add_to_monitoring}checked="checked"{/if} />
                                                                                                                                                        <label for="add_to_monitoring" >добавить в мониторинг</label>
                                                                                                                                                        &nbsp;
                                                                                                                                                        <div style=" display:inline-block; cursor:pointer; width:15px; height:16px; background:url(/images/q.jpg)" title="{info name = 'servicemonitoringinfo' stt=1}"></div>
                                                                                                                                                        <br />
                                                                                                                                                    </div>
                                                                                                                                                {/if} </div>
                                                                                                                                            <div id="add5block" style="{if $fparams.add1 != 6}display:none;{/if}">
                                                                                                                                                <b style="color:#FF0000">*</b>&nbsp;Адрес:<br>
                                                                                                                                                {form_textarea name="destcity" id="dest" style="width:270px; height:50px;" required="true" required="true"} </p>
                                                                                                                                                <br>
                                                                                                                                                <p><b style="color:#FF0000">*</b>&nbsp;Страна:<br>
                                                                                                                                                    <select name=destcountry style="width: 190" class=forminput required="true">
                                                                                                                                                        <option value=0 selected>Выберите страну...

                                                                                                                                                            {foreach from=$countries item=country}
                                                                                                                                                            <option {if $fparams.destcountry==$country}selected{/if}>{$country|escape}
                                                                                                                                                            {/foreach}
                                                                                                                                                    </select>
                                                                                                                                                </p>
                                                                                                                                            </div>
                                                                                                                                            <div id="fizblock" {if !$fparams.isfiz || $fparams.add1!=2} style="display:none;"{/if}> 
                                                                                                                                                <div>
                                                                                                                                                    <b style="color:#FF0000">*</b>
                                                                                                                                                    <span id="naz">Фамилия</span>:<br>				
                                                                                                                                                    {form_text name='fizf' id="fizf" class="input_field" placeholder="пример: Иванов" required="true"}
                                                                                                                                                </div>
                                                                                                                                                <div>
                                                                                                                                                    <b style="color:#FF0000">*</b>
                                                                                                                                                    <span id="naz">Имя</span>:<br>				
                                                                                                                                                    {form_text name='fizi' id="fizi" class="input_field" placeholder="пример: Иван" required="true"}
                                                                                                                                                </div>
                                                                                                                                                <div>
                                                                                                                                                    <b style="color:#FF0000">*</b>
                                                                                                                                                    <span id="naz">Отчество</span>:<br>
                                                                                                                                                    {form_text name='fizo' id="fizo" class="input_field" placeholder="пример: Иванович" required="true"}
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                            <div id="egrpblock" {if !$fparams.isfiz || $fparams.add1!=29}style="display:none;"{/if}>
                                                                                                                                                <div>
                                                                                                                                                    <b style="color:#FF0000">*</b>
                                                                                                                                                    <span id="naz">Вид объекта</span>:<br>
                                                                                                                                                    <select name='egrpv' id="egrpv" style="width:270px;" required="true">
                                                                                                                                                        <option value=0>квартира</option>
                                                                                                                                                        <option value=1>нежилое помещение</option>
                                                                                                                                                        <option value=2>земельный участок</option>
                                                                                                                                                        <option value=3>нежилое здание</option>
                                                                                                                                                        <option value=4>часть здания</option>
                                                                                                                                                        <option value=5>комната</option>
                                                                                                                                                        <option value=6>гараж</option>
                                                                                                                                                        <option value=7>жилой дом</option>
                                                                                                                                                        <option value=8>иное</option>
                                                                                                                                                    </select>
                                                                                                                                                </div>
                                                                                                                                                <div>
                                                                                                                                                    <b style="color:#FF0000">*</b>
                                                                                                                                                    <span id="naz">Площадь (м<span style='vertical-align:super;font-size:8px;'>2</span>)</span>:<br>
                                                                                                                                                    {form_text name='egrpp' id="egrpp" class="input_field" placeholder="пример: 50" required="true"}
                                                                                                                                                </div>
                                                                                                                                                <div>
                                                                                                                                                    <b style="color:#FF0000">*</b>
                                                                                                                                                    <span id="naz">Адресс объекта</span>:<br>
                                                                                                                                                    {form_textarea name='egrpa' id="egrpa" placeholder="пример: г. Москва, Ленинский пр-т, д.98 оф.217а" required="true"}
                                                                                                                                                </div>
                                                                                                                                                <div>
                                                                                                                                                    <b style="color:#FF0000">*</b>
                                                                                                                                                    <span id="naz">Кадастровый номер</span>:<br>
                                                                                                                                                    {form_text name='egrpk' id="egrpk" class="input_field" placeholder="пример: 77-77-04/006/2009-368" required="true"}
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                            <div id="cdblock" {if !$fparams.isfiz || $fparams.add1!=28}style="display:none;"{/if}> 
                                                                                                                                                <b style="color:#FF0000">*</b>Документы:
                                                                                                                                                            <div>
                                                                                                                                                                    <span>устав</span>
                                                                                                                                                                    <label>{form_text name='cdd1' value='' }</label>
                                                                                                                                                </div>
                                                                                                                                                            <div>
                                                                                                                                                                    <span>учредительный договор</span>
                                                                                                                                                                    <label>{form_text name='cdd2' value='' }</label>
                                                                                                                                                </div>
                                                                                                                                                            <div>
                                                                                                                                                                    <span>протокол собрания учредителей</span>
                                                                                                                                                                    <label>{form_text name='cdd3' value='' }</label>
                                                                                                                                                </div>
                                                                                                                                                            <div>
                                                                                                                                                                    <span>решение о создании</span>
                                                                                                                                                                    <label>{form_text name='cdd4' value='' }</label>
                                                                                                                                                </div>
                                                                                                                                                            <div>
                                                                                                                                                                    <span>свидетельство ИНН</span>
                                                                                                                                                                    <label>{form_text name='cdd5' value='' }</label>
                                                                                                                                                </div>
                                                                                                                                                            <div>
                                                                                                                                                                    <span>свидетельсвто ОГРН</span>
                                                                                                                                                                    <label>{form_text name='cdd6' value='' }</label>
                                                                                                                                                </div>
                                                                                                                                                <div>
                                                                                                                                                    <b style="color:#FF0000">*</b>
                                                                                                                                                    <span id="naz">Примечание</span>:<br>
                                                                                                                                                    {form_text name='cdrd' id="cdrd" class="input_field" placeholder="пример: последняя редакция" required="true"}<br>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                            
                                                                                                                                    <div id="ifoffcount" style="display: none;" > 
                                                                                                                                                  <b style="color:#FF0000" id="naimrequired"></b>
                                                                                                                                                  <span id="naz">Количество</span>:<br>
                                                                                                                                            {*form_text name=offcount id="cargoname" class="input_field" placeholder="количество" autofocus=""*}<br>
                                                                                                                                            {*form_text name=offcount id="offcount" class="input_field" placeholder="количество" autofocus=""*}<br>
                                                                                                                                          </div>
                                                                                                                                            
                                                                                                                                        </div>
                                                                                                                                    </div>

                                                                                                                                </td>

                                                                                                                                <td style="vertical-align:top">
                                                                                                                                                          <div id="tooltips_window">
                                                                                                                                                                  <table style="width:20px">
                                                                                                                                {foreach from=$zakItems key=key item=item}
                                                                                                                                        <tr><td colspan="2"><p><label style="cursor:pointer;">
                                                                                                                                                <img src="/images/ico_que.gif" title="tooltip" />
                                                                                                                                        </label></p></td></tr>
                                                                                                                                {/foreach}
                                                                                                                        </table>
                                                                                                                </div>
                                                                                                        </td>

                                                                                                                            </tr>


                                                                                                                            <!--tr><td colspan="2"><p><b>Цена: </b></p></td><td>Сроки</td></tr>
                                                                                                                            <!--tr id="offcheck" ><td colspan="2">
                                                                                                                                            <label>{*form_radio name="isoff" id="isoff_o" checked="0" value="0"*} Обычная </label>
                                                                                                                                            <label>{*form_radio name="isoff" id="isoff_s" checked="0" value="1"*} Срочная</label>
                                                                                                                            </td></tr--> 

{literal} 
<script type="text/javascript">
var dataReport;

if ({/literal}{$isoffffull}{literal} == 0)
	$('.off').hide();
if ({/literal}{$isinffull}{literal} == 0)
	$('.inf').hide();


function basketAdd(el) {
if (jQuery(el).is('.ordr_link_unblock')) {
jQuery('[name=contactForm]').submit();
}
}

function isfizswitch(val) {

$('#fizf').attr('value', '');
$('#fizi').attr('value', '');
$('#fizo').attr('value', '');

if (val == 1) {
$('#fizblock').show();
$('#innogrn').hide();
$('#fiznaimrequired').hide();
} else {
$('#fizblock').hide();
$('#innogrn').show();
$('#fiznaimrequired').show();
}
}
$("#type_report input").change(function(){

//fizcheck
//alert($("#type_report input::checked").val())

//alert($('#ru_info tr td label input:checked').val());
//alert($("#type_report input:checked").val());
if ($("#type_report input:checked").val()==0)
{
$("#offcheck").hide();
//alert($('#ru_info tr td label input:checked').val());
//это отключаем т.е. юзаем только по юр лицу
/*if ($('#ru_info tr td label input:checked').val() == 2)
{
$("#fizcheck").show();
$('#isfiz option:selected').click();
}*/

$('#priceBox').html(dataReport.price);
$('#time').html(dataReport.time);
$("#time").show();
$("#time_title").show();
//$("#ifoffcount").hide();


}
else
{
$("#fizcheck").hide();
$("#time").hide();
$("#time_title").hide();
//$("#ifoffcount").show();
//$("#offcheck").show();	
//isfizswitch(0);
$('#priceBox').html(dataReport.price_off);
//$("input[name=isoff]:checked").change();

}

});
add1val = '{/literal}{$fparams.add1}{literal}';
var textform = '';

// $(function(){ $('#priceBox').html($('#priceBoxHidden{/literal}{$fparams.add1}{literal}').html());});


$('input[name=cargoname2]').live('change',function(){
	//console.log($(this).val());
	//console.log($(this).parents('tr.report_row').find("input[name=add1]").val());
	var type = $(this).parents('tr.report_row').find("input[name=add1]").val()
	$.post(
			'/info/ajaxofregionsbycargo',{'cargo' : $(this).val(), 'type' : type},
			function(json){
				//console.log(json);
				if(json.noValid !== undefined){
					alert(json.noValid);
				}
				else{
					$('#of_reports_regions').html(json.listReps);
					///
					$('tr.report_row td.price.off div.report_info_main b').each(function(){
						$(this).html('---');
					});
					
					$('tr.report_row td.price.off div.reseting_report_info div.report_info_items').each(function(){
						$(this).html('');
					}); 
					
					for(var ofreport in json.listRepsCode){
						//console.log(json.listRepsCode[ofreport].price_inactive);
						var Elact = $('tr.report_'+ofreport+' td.price.off div.reseting_report_info div.report_info_items');
						var Elinact = $('tr.report_'+ofreport+'.report_row td.price.off div.report_info_main b');

						Elact.html(json.listRepsCode[ofreport].html_prices);

						Elinact.html(json.listRepsCode[ofreport].price_inactive + ' руб.');
					}
				}
				set_link_region();
				jQuery('.radio').dgStyle();
			}
		)
});


$("input[name=add1]").change(
function(){

var type = $(this).val();
var reg_code = $('#of_reports_regions').val();
var type_of_report = $(this).attr('alt');
var cargoname2 = $('input[name="cargoname2"]').val();
var cargoname = $('input[name="cargoname"]').val();

//console.log(this);
//console.log(reg_code);
$.post(
	'/info/ajaxofregionsbytype',{'type' : type, 'code': reg_code, 'cargoname2': cargoname2},
	function(json){
		//console.log(json.listReps);
		$('#of_reports_regions').html(json.listReps);
		///
		$('tr.report_row td.price.off div.report_info_main b').each(function(){
			$(this).html('---');
		});
		
		$('tr.report_row td.price.off div.reseting_report_info div.report_info_items').each(function(){
			$(this).html('');
		}); 

		$('#cargoname').val(cargoname);
		$('#cargoname2').val(cargoname2);

		$('input[name="cargoname2"]').attr('placeholder', 'пример: '+json.code+'17533277');
		
		for(var ofreport in json.listRepsCode){
			//console.log(json.listRepsCode[ofreport].price_inactive);
			var Elact = $('tr.report_'+ofreport+' td.price.off div.reseting_report_info div.report_info_items');
			var Elinact = $('tr.report_'+ofreport+'.report_row td.price.off div.report_info_main b');

			Elact.html(json.listRepsCode[ofreport].html_prices);

			Elinact.html(json.listRepsCode[ofreport].price_inactive + ' руб.');
		}
		set_link_region();
		jQuery('.radio').dgStyle();
	}
)

$('.active_tr').removeClass('active_tr');

var parent = $(this).parent().parent().parent().parent();

parent.addClass('active_tr');

add1val = $(this).val();

/* поиск -> копирование -> удаление -> перемещение >*/
if(textform == ''){  				
		textform = document.getElementById('ru_main').parentNode.innerHTML;
		$(document).find('order_form_hidden').remove();
}

/*var elems = document.getElementsByClassName('rivs_main');
for(var i=0; i<elems.length; i++) {
		elems[i].innerHTML = '';
}*/

$(".report_info_vot_suda>.rivs_main").remove();

$(this).parent().parent().parent().find('.rivs_main').remove();
$(this).parent().parent().parent().find('.report_info_vot_suda').append(
'<div class="rivs_main"></div>');
$(this).parent().parent().parent().find('.rivs_main').append(
		textform
);

// .filter("input:radio:first").attr("checked","checked").change().click();
parent.find(".report_info_item_checker input[type=radio]:first").change().click();
//    console.log(parent.find("input[type=radio][name=type_r]:first").parent());
parent.find("input[type=radio][name=type_r]:first").parent().change().click();
/* > end */

if(type_of_report == 'jur'){
	$('#fiznaimrequired').show();
	$('#cargoname').show();
} else{
	$('#fiznaimrequired').show();
	$('#isfiz').attr('checked', false);
	$('#fizcheck').hide();
	// $('#fizblock').hide();
	$('#fizf').attr('value', '');
	$('#fizi').attr('value', '');
	$('#fizo').attr('value', '');
}

if (type_of_report == 'ip') {
	$('#naz').html('ФИО ИП');
} else {
	$('#naz').html('Наименование');
}

if (type_of_report=='egrp') {
	$('#egrpblock').show();
	$('#fizcheck').hide();
	$('#fiznaimrequired').hide();
	$('#innogrn').hide();
} else {
	$('#egrpblock').hide();
}

if (type_of_report=='phys') {
	$('#fizblock').show();
	$('#fiznaimrequired').hide();
	$('#innogrn').hide();
} else {
	$('#fizblock').hide();
}
/*
if ($(this).val()==2) {
	$("#isfiz1st").click();
	// $('#fizcheck').show();тож отключаем
	$('#fiznaimrequired').show();
	$('#cargoname').show();
} else {
	$('#fiznaimrequired').show();
	$('#isfiz').attr('checked', false);
	$('#fizcheck').hide();
	// $('#fizblock').hide();
	$('#fizf').attr('value', '');
	$('#fizi').attr('value', '');
	$('#fizo').attr('value', '');
}
//$('#cargoname').val(tmp_name['cargoname']);
if ($(this).val()==3) {
	$('#naz').html('ФИО ИП');
} else {
	$('#naz').html('Наименование');
}


if ($(this).val()==6) {
$('#add5block').show();
$('#cargoname2').attr('value', '');
$('#cargoname3').attr('value', '');
$('#innogrn').hide();
$('#naimrequired').html('*');
} else {
$('#add5block').hide();
$('#innogrn').show();
$('#naimrequired').html('&nbsp;');
}

if ($(this).val()==9) {
$('#bankrot').show();
$('#fizcheck').hide();
$('#fiznaimrequired').hide();
$('#innogrn').hide();
} else {
$('#bankrot').hide();
}
*/

if ($(this).val()==28) {
	$('#cdblock').show();
	$('#innogrn').show();
	$('#fiznaimrequired').show();
} else {
	$('#cdblock').hide();
}
/*
if ($(this).val()==29) {
	$('#egrpblock').show();
	$('#fizcheck').hide();
	$('#fiznaimrequired').hide();
	$('#innogrn').hide();
} else {
	$('#egrpblock').hide();
}


if ($(this).val()==31) {
$('#fizblock').show();
		$('#fiznaimrequired').hide();
$('#innogrn').hide();
} else {
$('#fizblock').hide();
}
*/
//$('#priceBox').html($('#priceBoxHidden'+$(this).val()).html());

$.getJSON("/info/getcheckreport/", {id: add1val}, function(data){
		//alert("JSON Data: " + data.price);
		dataReport = data;
		$('#priceBox').html(dataReport.price);
		$('#report_info').html(dataReport.about);
		if (dataReport.price != 0) {
                    $('#type_r_inf').parent().show();
                } else {
                    $('#type_r_inf').parent().hide();
                }
		if (dataReport.price_off != 0)
				$('#type_r_off').parent().show();
		else
				$('#type_r_off').parent().hide();

		if (dataReport.fl_inf == 0)
		{
				$('#type_r_inf').attr('disabled', 'disabled');
				$('#type_r_inf').removeAttr('checked');							
				$('#type_r_inf').parent().css('color', '#638caf');
				$('#type_r_off').attr('checked', 'checked');
		}
		else
		{
				$('#type_r_inf').removeAttr('disabled');
				$('#type_r_inf').parent().css('color', '#133c5f');
		}
		if (dataReport.fl_off_o != 0 || dataReport.fl_off_s != 0)
		{
				$('#type_r_off').removeAttr('disabled');
				$('#type_r_off').parent().css('color', '#133c5f');
				if (dataReport.fl_off_o == 0)
				{
						$('#isoff_o').attr('disabled', 'disabled');
						$('#isoff_o').removeAttr('checked');
						$('#isoff_s').attr('checked', 'checked');
				}
				else
				{
						$('#isoff_o').removeAttr('disabled');
				}
				if (dataReport.fl_off_s == 0)
				{
						$('#isoff_s').attr('disabled', 'disabled');
						$('#isoff_s').removeAttr('checked');
						$('#isoff_o').attr('checked', 'checked');
				}
				else
				{
						$('#isoff_s').removeAttr('disabled');
				}

		}
		else
		{
				$('#type_r_off').attr('disabled', 'disabled');
				$('#type_r_off').removeAttr('checked');
				$('#type_r_off').parent().css('color', '#638caf');
				$('#type_r_inf').attr('checked', 'checked');							
		}
		$("#type_report input:checked").change();
                //console.log('hi');
                $('.report_info_vot_suda input[placeholder]').placeholder();
});

//$("#type_report input:checked").change();

});
/*$("input[name=isoff]").change(function(){
//alert('ff');
if ($(this).val() == 0)
{
		$('#priceBox').html(dataReport.price2);
		$('#time').html(dataReport.time2);
}
else
{
		$('#priceBox').html(dataReport.price3);
		$('#time').html(dataReport.time3);
}

});*/


</script> 
{/literal} 

<!--tr><td colspan="2"><p id="priceBox">&nbsp;</p></td></tr>
<tr><td colspan="2"><p>Сроки <span id='time'></span></p></td></tr-->

<tr>
<td colspan="2"><p>&nbsp;</p></td>
</tr>

<!-- <tr><td colspan="2"><p>{form_submit name="submitb" value="Добавить в корзину" style="margin:0;padding:0;"}</p></td></tr> --> 
<!--tr><td colspan="2"><p><button class="buy_button"><img src="/images/basket.png" alt="" width="23" height="24" style="vertical-align: middle" />добавить в корзину</button></p></td></tr-->
</table>

<p></p>
{if $Basket->getItems()}
<div style="background-color:#e4ffb3;margin:-29px;margin-left:0px;margin-top:0px;padding:35px;padding-left:4px;margin-bottom:10px;padding-top:10px;"> 

<div class="add" style="float:right;">
<a href="/order/basketclear/">Очистить корзину</a>
</div>
<div class="basket_info_header" style="margin-top:-10px">
<img src="/images/user_telejka_link.png" align="top"> <font style="color:#005fb1"><b>В КОРЗИНЕ</b></font>
</div>

<div style="clear:right;"></div>
<div style="margin-top:4px;">
{include file="order/basket_grid.tpl" ischeck=1}
</div>


{if $user->getId()}
{if $Basket->getTotalAmount()<=$user->balans}


<div class="other_order" style="clear:right;margin-top:30px;margin-right:-62px;margin-left:30px;">	 

<div class="button" style="margin-top:-70px"><a class="pay_all" href="/order/create/" title="Оформить заказ"></a></div>
</div>
{else}
<div style="clear:left"><h4 style="color:#86cd00;">Недостаточно средств на личном счете | <u style="color:#86cd00" id="naimrequired"><a style="color:#86cd00" href="/order/balans/">Пополнить баланс</a></u></h4></div>
{/if}

{else}

<div class="other_order" style="clear:right;margin-top:30px;margin-right:-62px;margin-left:30px;">
<div class="button" style="margin-top:-70px">	<a class="pay_all" href="/order/create/" title="Оформить заказ">
<!-- Оформить заказ -->
</a>

</div>
</div>
{/if}
{/if}


</div>

{if $Basket->isTotalAmountDefined()}

{if !$user->getId()}
{*}  {form from=$form2}
<p>{form_errors_summary}</p>
<p><b style="color:#FF0000">&nbsp;</b>&nbsp;Название Вашей компании:<br />
{form_text name=company 
value="Название Вашей компании" 
onblur="if($(this).attr('value') == '')$(this).attr('value','Название Вашей компании');" 
onfocus="if($(this).attr('value') == 'Название Вашей компании')$(this).attr('value','');"} </p>
<p><b style="color:#FF0000">*</b>&nbsp;E-mail:<br>
{form_text name=email 
value="E-mail" 
onblur="if($(this).attr('value') == '')$(this).attr('value','E-mail');" 
onfocus="if($(this).attr('value') == 'E-mail')$(this).attr('value','');"} </p>
<p><b style="color:#FF0000">*</b>&nbsp;Срочность:<br />
{form_select name="priority" options=$pItems selected=$fparams.priority} </p>
<p id='pay_variant'><b style="color:#FF0000">*</b>&nbsp;Способ оплаты{$fparams.mindex}:<br>
{form_select name="money_type" id="money_type" options=$ListPay2 selected=$fparams.money_type} <br>
{foreach from=$ListPay item=pay}
<label class='type_{$pay->group}'>
<input type="radio" name="money" value='{$pay->id}' typepay='{if $pay->type_pay == 2}{$pay->typeItem->name}{else}{$pay->type_pay}{/if}' />
{$pay->title}<br>
</label>
{/foreach}

<p id='price_pay_p'>Сумма:
<select id='price_pay' name='price_pay'>
</select>
{*}<span id='price_pay'></span><span id='price_cyrr'></span>{*}</p>
{assign var="moneyindex" value=1}{*}
{*}  {foreach from=$oItems item=oItemsA}
{foreach from=$oItemsA key=okey item=oItem}
{if $fparams.money == $okey && ($fparams.mindex == $moneyindex || !$fparams.mindex)}
{assign var="mindex" value=$moneyindex}
<input type="radio" name="money" ind={$moneyindex} value={$okey} checked="checked" onclick="emoneyChange(this);" />
{$oItem}<br>
{else}
<input type="radio" name="money" ind={$moneyindex} value={$okey} onclick="emoneyChange(this);" />
{$oItem}<br>
{/if}
{assign var="moneyindex" value=$moneyindex+1}
{/foreach}
{/foreach}{*}
{form_hidden id="mindex" name="mindex" value=$mindex}
{*form_select name="money" id="money" options=$oItems selected=$fparams.money*}

{*}
<div id="zakuplatu"{if $fparams.money != 2}style="display:none;"{/if}>
<p><b style="color:#FF0000">*</b>&nbsp;Заказчик:<br>
{form_text name=zaku id="zaku" value="Заказчик" 
onblur="if($(this).attr('value') == '')$(this).attr('value','Заказчик');" 
onfocus="if($(this).attr('value') == 'Заказчик')$(this).attr('value','');"} </p>
<p><b style="color:#FF0000">*</b>&nbsp;Плательщик:<br>
{form_text name=platu id="platu" 
value="Плательщик" 
onblur="if($(this).attr('value') == '')$(this).attr('value','Плательщик');" 
onfocus="if($(this).attr('value') == 'Плательщик')$(this).attr('value','');"} </p>
</div>
</p>
<p id="op1">
	<button class="buy_button"><img src="/images/basket.png" alt="" width="23" height="24" style="vertical-align: middle" />заказать</button>
</p>
{/form}{*}
{else}
{if $Basket->getTotalAmount()>$user->balans}

{else} 
<!-- <input type="checkbox" onclick="if ($(this).attr('checked')) $('#op2').show(); else $('#op2').hide();" /> <a href="/reports/oferta">С условиями предоставления услуг ознакомлен и согласен</a><br /><br /> -->
<div id="op2" >
<input type="submit" onclick="if (!confirm('С вашего личного счета будет списано {$Basket->getTotalAmount()} руб.')) return false; document.location = '/order/create/';" value="Оплатить" />
</div>
{/if}
{/if}
{else}
{if $Basket->getCount()} 

<!--         <input type="checkbox" onclick="if ($(this).attr('checked')) $('#op3').show(); else $('#op3').hide();" /> <a href="/reports/oferta">С условиями предоставления услуг ознакомлен и согласен</a><br /><br />
<br /><br /> -->
<p id="op1" style="display:none;"><a href="/order/create/">Оформление заказа</a></p>
{/if}
{/if}
<div class="dotted2"></div>
	
	
	
{if !$hidelayout} </div>
	
	
	

<!--  ##### add #####  -->
<div class="footer_wm">
<div class="footer_header">
<b>МЫ ПРИНИМАЕМ К ОПЛАТЕ</b>
</div>
<div class="footer_moneys_items">
<img src="/images/viza_mastercard_logo.png">
<img src="/images/web_money_logo.png">
<img src="/images/ya_money_logo.png">
<img src="/images/liqpaycom_logo.png">
<img src="/images/rbk_logo.png">
<img src="/images/sberbank_logo.png">
</div>
<div>
<a href="/articles/payments/">Подробнее о системах оплаты</a>
</div>					
</div>
<!--  ##### end add #####  -->
		
		
</div>
</div>
{/if}


{literal} 
<script type="text/javascript">
//	var dataReport;
$(document).ready( function () {
//	$("#country_ord").change();
{/literal}{if $fparams.id}{literal}
$('#ru_info tr td label input[value="{/literal}{$fparams.id}{literal}"]').change();
$('#ru_info tr td label input[value="{/literal}{$fparams.id}{literal}"]').click();
// $("#country_ord").change();
{/literal}{/if}{literal}

$('#money_type').change();
//$("#type_report input:checked").change();

/*$.getJSON("http://192.168.0.17/info/getcheckreport/id/2", function(data){
//alert("JSON Data: " + data.price);
dataReport = data;
//alert(dataReport);
});*/

//setTimeout(function() {alert(dataReport.name)},2000);
//alert('dataReport.price');
});


function getCoords(elem) {
// (1)
var box = elem.getBoundingClientRect();

var body = document.body;
var docEl = document.documentElement;

// (2)
var scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
var scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;

// (3)
var clientTop = docEl.clientTop || body.clientTop || 0;
var clientLeft = docEl.clientLeft || body.clientLeft || 0;

// (4)
var top  = box.top +  scrollTop - clientTop;
var left = box.left + scrollLeft - clientLeft;

// (5)
return { top: Math.round(top), left: Math.round(left) };
}

</script>
<script type="text/javascript">
$('select#of_reports_regions').live('change',function(){
	//console.log($(this).val());
	//var comment = $(this).val();
	var type = $('input[name=add1][checked="checked"]').val();
	var type_off = $('input[name=isoff][checked="checked"]').attr('id');
	if(type_off === undefined){
		type_off = 0;
	}
	console.log(type_off);
	var code = $(this).val();
	$('input[name="cargoname2"]').attr('placeholder', 'пример: '+code+'17533277');
	$.post(
			'/info/ajaxofregions',{'code' : code, 'type' : type, 'type_off' : type_off},
			function(json){
				
				$('tr.report_row td.price.off div.report_info_main b').each(function(){
					$(this).html('---');
				});
				
				$('tr.report_row td.price.off div.reseting_report_info div.report_info_items').each(function(){
					$(this).html('');
				});
				
				for(var ofreport in json){
					//console.log(json[ofreport].price_inactive);
					var Elact = $('tr.report_'+ofreport+' td.price.off div.reseting_report_info div.report_info_items');
					var Elinact = $('tr.report_'+ofreport+'.report_row td.price.off div.report_info_main b');

					Elact.html(json[ofreport].html_prices);

					Elinact.html(json[ofreport].price_inactive + ' руб.');
				}
				set_link_region();
				jQuery('.radio').dgStyle();
			}
		)	
});

$('select#of_reports_regions').live('mouseout',function(){
	set_link_region();
});
</script> 
{/literal}

{literal}
    <script type="text/javascript">

                    if (typeClick == 1){
                            $('.xxx').text("Возобновить услугу:  ");
                    }
                    if (typeClick == 2){
                            $('.xxx').text("Продлить услугу:  ");
                    }
                    if (typeClick == 3){	 		
                            $('.xxx').text("Изменить услугу:  ");
                    }
		
                    $('input#258').click();
		
                
                
                
    var change_ev = [];
    function change_events(){
            if(change_ev['#event_types'] == undefined || change_ev['#event_types'] == false){
                    $('#event_types'+' span img').attr('src','/images/drill_up_red.jpg');
                    $('#event_types'+' a').css({'color':'#FF0000','text-decoration': 'none','font-weight':'bold'});
                    change_ev['#event_types'] = true;
            }else{
                    $('#event_types'+' span img').attr('src','/images/drill_right.jpg');
                    $('#event_types'+' a').css({'color':'#2D96FE','text-decoration': 'underline','font-weight':'normal'});
                    change_ev['#event_types'] = false;
            }
            $('#full_event_types').toggle();
    }
                
    </script>
{/literal}

<div id='tarif_info'>
    {$tarifslllItem->about}
    <input type='hidden' value="{$tarifslllItem->type}" name="all_id">
    <div id='tarif_event_type'>
        {*foreach from=$Countryses item=country*}
        {section name=country loop=$Countryses step=-1}
            <span class="radio_style">
                <input type='radio' name='country_tarif2' value='{$Countryses[country].id_country}' id="{$Countryses[country].id_country}"><label color="#1F5763" for="{$Countryses[country].id_country}">{$Countryses[country].name} <img src="/images/{$Countryses[country].id_country}.gif">  </lable></span>

                {/section}
                {*/foreach*}

                {*section name=foo loop=$custid step=-1*}
                {*$custid[foo]*}
                {*/section*}
                <br>
                {foreach from=$typeEvent item=typeE}
                    {if $tarifslllItem->getEventType($typeE->id)}
                        <font name='type_event' class='{foreach from=$typeE->getTypeCountryList() item=countrys}countr_{$countrys->id} {/foreach}'>{$typeE->title} <span class='info_type' style='display:none;' val={$typeE->id}>{$typeE->description}</span></font>
                    {/if}
                {/foreach}
                </div>
                <div id='bonus'>
                    Бонус: {$tarifslllItem->bonus}% {info name="bonus"}
                </div>
                </div>

                <table cellpadding="0" cellspacing="0" border="0" id="tarif_grid" class="all_tarifs">
                    <tr id="head" > 
                        <td  rowspan="2" width="100"><b style="color:#dba108;">Количество компаний в мониторинге</b></td>
                        <td  colspan="3" align="left" style="border-bottom:none !important;"><font style="font-size:14px;color:#DBA108;font-weight:bolder;">Стоимость одного мониторинга, руб.</font> </td>	 
                    </tr>   
                    <tr id="head" >

                        {section name=country loop=$Countryses step=-1}
                            <td id="country_{$Countryses[country].id_country}" class="country_" style="color:#dba108"><b>{$Countryses[country].name} <img src="/images/{$Countryses[country].id_country}.gif"> </b></td>
                                {/section}

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

                    {*$countTarif*}
                    {*$itemMain*}
                    {assign var="i"}
                    {$i=0}


                    {foreach from=$price_array item=price_one key=key}
                        <tr id="item" class='cl '>
                            <td style="color:#dba108;font-weight: bold;" id="{$tarif->num}">
                                {*$price_one.name*}
                                {if ($i==0) }
                                    {assign var="result" value="-"|explode:$price_one.name} 
                                    {$result.0}  -
                                    {$result.1+1} 
                                {/if}

                                {if ($i==4) }
                                    {assign var="result" value="-"|explode:$price_one.name} 
                                    {$result.0+1}
                                    и более 
                                {/if}

                                {if ($i!=0) && ($i!=4) }
                                    {assign var="result" value="-"|explode:$price_one.name} 
                                    {$result.0+1}  -
                                    {$result.1+1} 
                                {/if}
                                <!-- {$i++} -->
                                { if ($key+1!=$countTarif)}
                                <input type="hidden" name="sum{$key}" value="{$key}" val2='{$key}'/>
                                {else}
                                    <input type="hidden" name="sum{$key+1}" value="{$key+1}" val2='{$key}'/> 
                                    {/if}
                                    </td>




                                    {foreach from=$price_one.price|@array_reverse:true item=one}

                                        <td align="left" style="font-weight: bold;">		
                                            {$one}
                                        </td>
                                    {/foreach}
                                </tr>
                                {/foreach}


                                    {*$checked_period*} 
                                    {if ($form)}

                                    {/if}
                                    <tr>
                                        <td></td>
                                        {foreach from=$Countryses item=item}

                                            {foreach from=$typeEvent item=typeE}
                                                <td>
                                                    {$item.id_country}
                                                    {$typeE->getTypeCountry($item.id_country)}
                                                    {if $tarifslllItem->getEventType($typeE->id)}
                                                        <!--<font name='type_event' class='{foreach from=$typeE->getTypeCountryList() item=countrys}countr_{$countrys->id} {/foreach}'>{$typeE->title} <span class='info_type' style='display:none;' val={$typeE->id}>{$typeE->description}</span></font>-->
                                                    {/if}
                                                </td>
                                            {/foreach}

                                        {/foreach}       
                                    </tr>
                                </table>

                                <div>

                                    <font color="#1f5863">Страна:</font>


                                    {section name=country loop=$Countryses step=-1}

                                        <span class="radio_style">
                                            <input type='radio' name='country_tarif' value='{$Countryses[country].id_country}' id='{$Countryses[country].id_country}'><label for="{$Countryses[country].id_country}">{$Countryses[country].name} <img src="/images/{$Countryses[country].id_country}.gif"></lable></span>

                                            {/section}

                                            {*<select name="country_tarif">
                                            {foreach from=$Countryses item=country}
                                    
                                            <option value='{$country.id_country}' selected>{$country.name}</b></option>
                                    
                                            {/foreach}
                                    
                                            </select>*}
                                            <br>
                                            {if $tarifslllItem->period_active1== 1 || $tarifslllItem->period_active2== 1 || $tarifslllItem->period_active3== 1}
                                                <font style="font-size: 13px;font-weight: normal;color:#000">Выбор периода мониторинга:</font>
                                                {if $checked_period=="first"}
                                                    {if $tarifslllItem->period_active1 == 1}
                                                        <span class="radio_style"><input type="radio"  name='m' value="{$tarif_ID}-1" checked cou='{$tarifslllItem->period1}' sale='{$tarifslllItem->period_sale1}'  id='per_{$tarifslllItem->period1}'/> <label for="per_{$tarifslllItem->period1}">{$tarifslllItem->period1} дней <span class='sale_period ' val=1>Скидка {$tarifslllItem->period_sale1}%</span></label></span>
                                                        {/if}
                                                        {if $tarifslllItem->period_active2 == 1}
                                                        <span class="radio_style"><input type="radio"  name='m' value="{$tarif_ID}-3"  cou='{$tarifslllItem->period2}'  sale='{$tarifslllItem->period_sale2}' id='per_{$tarifslllItem->period2}'/> <label for="per_{$tarifslllItem->period2}"> {$tarifslllItem->period2} дней <span class='sale_period ' val=2>Скидка {$tarifslllItem->period_sale2}%</span></label></span>
                                                        {/if}
                                                        {if $tarifslllItem->period_active3 == 1}
                                                        <span class="radio_style"><input type="radio"  name='m' value="{$tarif_ID}-6"  cou='{$tarifslllItem->period3}'  sale='{$tarifslllItem->period_sale3}' id='per_{$tarifslllItem->period3}'/><label for="per_{$tarifslllItem->period3}"> {$tarifslllItem->period3} дней <span class='sale_period ' val=3>Скидка {$tarifslllItem->period_sale3}%</span></label></span>
                                                        {/if}
                                                    {else}

                                                    {assign  var='value_1' value=$tarif_ID|string_format:'%s-1' }
                                                    {assign  var='value_2' value=$tarif_ID|string_format:'%s-3' }
                                                    {assign  var='value_3' value=$tarif_ID|string_format:'%s-6' }
                                                    {if $tarifslllItem->period_active1 == 1}

                                                        <span class="radio_style"><input type="radio"  name='m' value="{$tarif_ID}-1" {if $checked_period==$value_1 } checked {/if} cou='{$tarifslllItem->period1}'  sale='{$tarifslllItem->period_sale1}' id='radioper_{$tarifslllItem->period1}'/> <label for="radioper_{$tarifslllItem->period1}"> {$tarifslllItem->period1} дней <span class='sale_period ' val=1>

                                                                    {if ($tarifslllItem->period_sale1!=0) }
                                                                        Скидка {$tarifslllItem->period_sale1}%
                                                                    {/if}


                                                                </span></label></span>
                                                            {/if}
                                                            {if $tarifslllItem->period_active2 == 1}
                                                        <span class="radio_style"><input type="radio"  name='m' value="{$tarif_ID}-3" {if $checked_period==$value_2 } checked {/if} cou='{$tarifslllItem->period2}'  sale='{$tarifslllItem->period_sale2}' id='radioper_{$tarifslllItem->period2}'/><label for="radioper_{$tarifslllItem->period2}">  {$tarifslllItem->period2} дней <span class='sale_period ' val=2>Скидка {$tarifslllItem->period_sale2}%</span></label></span>
                                                        {/if}
                                                        {if $tarifslllItem->period_active3 == 1}
                                                        <span class="radio_style"><input type="radio"  name='m' value="{$tarif_ID}-6" {if $checked_period==$value_3 } checked {/if} cou='{$tarifslllItem->period3}'  sale='{$tarifslllItem->period_sale3}' id='radioper_{$tarifslllItem->period3}'/><label for="radioper_{$tarifslllItem->period3}"> {$tarifslllItem->period3} дней <span class='sale_period ' val=3>


                                                                    Скидка {$tarifslllItem->period_sale3}%


                                                                </span></label></span>
                                                            {/if}
                                                        {/if}
                                                        {literal}
                                                    <script type="text/javascript">
                                                            $('[name=period]').parent().show();
                                                            $('[name=hictory_add]').parent().show();
                                                            $('[name=hictory_add]').attr("checked", "");
                                                    </script>

                                                {/literal}
                                            {else}

                                                {literal}
                                                    <script type="text/javascript">
                                                            $('[name=period]').parent().hide();
                                                            $('[name=hictory_add]').parent().hide();
                                                            $('[name=hictory_add]').attr("checked", "checked");
                                                    </script>

                                                {/literal}
                                            {/if}
                                            </div>
                                            <div></div>
                                            <div style="margin-top:5px;margin-bottom:4px;" class="new_tarif"><span style="width:20px; height:20px;background-color:#ff322d">&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='xxx'> Новая услуга: </span><span id="new_name_tarif">0</span></div>
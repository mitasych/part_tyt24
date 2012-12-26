{*$okato|print_r*}
{literal}
<script type="text/javascript">


function OpenList(temp){

    if( $('.last_ul_li_'+temp).attr("style"))
    {
        $('#drill_img_menu_'+temp).attr("src", "/images/drill_down.jpg");
        $('.last_ul_li_'+temp).removeAttr("style");
        
      }
    else
    {
        $('#drill_img_menu_'+temp).attr("src", "/images/drill_up.jpg");
        $('.last_ul_li_'+temp).attr("style","display:none;");
        {/literal}
        {foreach from=$okved item=current name="okved"}
            {foreach from=$current.subitems item=subitem name="second"}

        $('.last_ul_li_ul_'+{$subitem.id}+'_'+temp).attr("style","display:none;");
            {/foreach}
        {/foreach}

        {literal}
    }
}


function OpenListSubmenu(temp,temp1){


    if( $('.last_ul_li_ul_'+temp1+'_'+temp).attr("style"))
    {
        $('#drill_img_'+temp1).attr("src", "/images/drill_down_red.jpg");
        $('.last_ul_li_ul_'+temp1+'_'+temp).removeAttr("style");
        
      }
    else
    {
        $('#drill_img_'+temp1).attr("src", "/images/drill_up_red.jpg");
         {/literal}
        {foreach from=$okved item=current name="okved"}
            {foreach from=$current.subitems item=subitem name="second"}
        $('.last_ul_li_ul_'+temp1+'_'+temp).attr("style","display:none;");       
            {/foreach}
        {/foreach}

        {literal}
    }
}

function HideShow(temp){

    if( $('.last_ul_'+temp).attr("style"))
    {
        $('#drill_down_okato_'+temp).attr("src", "/images/drill_down_red.jpg");
        $('.last_ul_'+temp).removeAttr("style");
        
      }
    else
    {
        $('#drill_down_okato_'+temp).attr("src", "/images/drill_up_red.jpg");
        $('.last_ul_'+temp).attr("style","display:none;");
    }
}





// $(document).ready(function(){


// 	$(".drill_down_submenu").toggle(
//         function(){
//         $(this).find("img").attr("src", "/images/drill_down_red.jpg");
//         $(this).nextAll("ul").filter(function(i){if(i > -1) return true;}).attr("style","display:block;");
//         $(this).nextAll("ul").find("a").filter(function(i){if(i > -1) return true;}).attr("style","display:block;");
//        },
//         function(){
// 		$(this).nextAll("ul").find("a").attr("style", "");
// 		$(this).find("img").attr("src", "/images/drill_up_red.jpg");
//         $(this).nextAll("ul").filter(function(i){if(i > -1) return true;}).attr("style", "display:none;");
// 	   }
        

//     );

// 	// $(".drill_down_menu").toggle(
       
//  //        function(){
// 	// 	// $(this).nextAll("tr").find("li").attr("style", "");
// 	// 	$(this).find("img").attr("src", "/images/drill_up.jpg");

//  //      //$('.last_ul_li_'+$('.drill_down_menu').attr('name')).attr("style","display:none;");
//  //     // $('.last_ul_li_ul_'+$('.drill_down_submenu').attr('name')).attr("style","display:none;");
// 	// } ,   
//  //      function(){
//  //        $(this).find("img").attr("src", "/images/drill_down.jpg");
//  //     //   $('.last_ul_li_'+$(this).find('.drill_down_menu').attr('name')).removeAttr("style");
//  //                console.log($this('.drill_down_menu').attr('name'));
//  //       // $('.last_ul_li_ul_'+$('.drill_down_submenu').attr('name')).removeAttr("style");
//  //    }

    
//     // );
// 	$(".drill_down_okato").toggle(function(){
// 		$(this).nextAll("ul").find("li").filter(function(i){if(i > -1) return true;}).attr("style", "").after("<br />");
// 		$(this).find("img").attr("src", "/images/drill_up_red.jpg");
// 	}, function(){
// 		$(this).find("img").attr("src", "/images/drill_down_red.jpg");
// 		$(this).nextAll("ul").filter(function(i){if(i > -1) return true;}).attr("style", "display:none;").next().remove();
// 	});
// })
</script>
{/literal}

    	{if empty($id)}
           <div><h1 class="db_h1" style="float:left;">Базы данных:</h1>

               <div class="db_menu"> 

                <a id="rubrick" class="db_menu_link_select" href="#" onClick="$('.rubrik_list').attr('style','display:block');$('.region_list').attr('style','display:none');$('#rubrick').attr('class','db_menu_link_select');$('#region').attr('class','db_menu_link');return false;">РУБРИКИ</a> 
                <a id="region" class="db_menu_link" href="#" onClick="$('.region_list').attr('style','display:block');$('.rubrik_list').attr('style','display:none');$('#region').attr('class','db_menu_link_select');$('#rubrick').attr('class','db_menu_link');return false;">РЕГИОНЫ</a>

               </div>
            </div> 
            <div class="db_submenu">
  <table width='100%' style='margin-top: 20px;'>
  <tr>
  <td colspan='4' style='padding-bottom: 10px;'>
    <div class='db_mark_on' id='name1' onClick="$('.all').attr('style','display:block');$('.tele').attr('style','display:none');$('.email').attr('style','display:none');$('#name1').attr('class','db_mark_on');$('#name2').attr('class','db_mark_tele');$('#name3').attr('class','db_mark_email');return false;"><b id='uppercase' >Маркетинг</b><br>Краткое описание пункта</div>
    <div class='db_mark_tele' id='name2' onClick="$('.tele').attr('style','display:block');$('.all').attr('style','display:none');$('.email').attr('style','display:none');$('#name1').attr('class','db_mark');$('#name2').attr('class','db_mark_tele_on');$('#name3').attr('class','db_mark_email');return false;"><b  id='uppercase2'>Телемаркетинг</b><br>Краткое описание пункта</div>
    <div class='db_mark_email' id='name3' onClick="$('.email').attr('style','display:block');$('.tele').attr('style','display:none');$('.all').attr('style','display:none');$('#name1').attr('class','db_mark');$('#name2').attr('class','db_mark_tele');$('#name3').attr('class','db_mark_email_on');return false;"><b id='uppercase' >Email-Маркетинг</b><br>Краткое описание пункта</div>
  </td>
  </tr>


  </table>
            
            </div>            
                <br>
             <div class="rubrik_list" style="display:block" >
                 
                {if empty($okved)} Предприятия отсутствуют при заданных фильтрах <br/> <a href="{$SITE_URL}">Вернуться на главную</a>{/if}
                <table width="100%" cellspacing="0" cellpadding="0" border="0">

                    <tr class="table_title" >
                        <td>Выбрать рубрику:</td>
                        <td align="right" style="padding-right:26px;">Количество:</td>
                        <td align="right" style="padding-right:25px;">Цена:</td>
                        <td></td>
                    </tr>
                    {foreach from=$okved item=current name="okved"}
                        {if count($current.subitems)!=0 && $current.count != 0}
                        {assign var="style_menu" value=""}
                        <tr  class="menu_drill" >
                          <td width="60%" class="name_drill"><a style="font-weight:bold; font-size:12px;" href="{$SITE_URL}/database/show/id/{$current.id}/">{$current.name}</a>{if count($current.subitems)>2 and empty($okved_id) and not $all_okved}<a class="drill_down_menu" name="{$current.id}" onClick="OpenList({$current.id})"><img id="drill_img_menu_{$current.id}" src="/images/drill_down.jpg"></a>{/if}
                                                          </td>
                          <td align="right" style="padding-right:25px;">
                                            <div class="all" style="display:block">{$current.c_all}</div>
                                            <div class="tele" style="display:none">{$current.c_tele}</div>
                                            <div class="email" style="display:none">{$current.c_email}</div>
                          </td>
                          <td align="right" style="padding-right:25px;">
                                            <div class="all" style="display:block">{$current.column}</div>
                                            <div class="tele" style="display:none">{$current.position}</div>
                                            <div class="email" style="display:none">{$current.count}</div>
                          </td>
                          <td > <a class="add_to_bascket" onmouseover="$(this).find('img').attr('src','/img/db_korzina_min_on.png')" onmouseout="$(this).find('img').attr('src','/img/db_korzina_min_off.png')" href="#"><img src="/img/db_korzina_min_off.png"></a></td>
                        </tr> 

                                {foreach from=$current.subitems item=subitem name="second"}
                                {if $subitem.count != 0}
	                                {*if $smarty.foreach.second.iteration > 2 and empty($okved_id) and not $all_okved}
	                                    {assign var="style_menu" value="display:none;"}
	                                {/if*}
                                        <tr class="last_ul_li_{$current.id}" id="submenu_drill">
	                                        <td id="last_ul_li" width="50%" style="{if $style_menu}{$style_menu}{/if}"><a class="submenu_a" style="font-weight:bold; font-size: 12px;" href="{$SITE_URL}/database/show/id/{$subitem.id}/">{$subitem.name}{if empty($okved_id)}{else}({$subitem.count|number_format:0:".":" "}){/if}</a>{if count($subitem.subitems)>0 and empty($okved_id) and not $all_okved}<a class="drill_down_submenu" onClick="OpenListSubmenu({$current.id},{$subitem.id})" name="{$subitem.id}"><img id="drill_img_{$subitem.id}" src="{$IMG_URL}/drill_up_red.jpg" /></a>{/if}
	                                       </td>
                                           <td align="right" style="padding-right:25px;">
                                            <div class="all" style="display:block">{$subitem.c_all}</div>
                                            <div class="tele" style="display:none">{$subitem.c_tele}</div>
                                            <div class="email" style="display:none">{$subitem.c_email}</div>

                                          </td>
                                           <td align="right" style="padding-right:25px;">
                                            <div class="all" style="display:block">{$subitem.column}</div>
                                            <div class="tele" style="display:none">{$subitem.position}</div>
                                            <div class="email" style="display:none">{$subitem.count}</div>
										   
										   
										   
										   </td>
                                           <td > <a class="add_to_bascket" onmouseover="$(this).find('img').attr('src','/img/db_korzina_min_on.png')" onmouseout="$(this).find('img').attr('src','/img/db_korzina_min_off.png')" href="#"><img src="/img/db_korzina_min_off.png"></a></td>
                                        </tr>
	                                            {assign var="style_submenu" value=""}
	                                                {foreach from=$subitem.subitems item=subsubitem name="third"}
	                                                    {if $subsubitem.count != 0}
	                                                        {if $smarty.foreach.third.iteration > 0 and empty($okved_id) and not $all_okved}
	                                                        	{assign var="style_submenu" value="display:none;"}
	                                                        {/if}
                                                            <tr id="sub_submenu" class="last_ul_li_ul_{$subitem.id}_{$current.id}" style="display:none;">
	                                                           <td width="50%">
                                                                        <a class="sub_submenu" href="{$SITE_URL}/database/show/id/{$subsubitem.id}/">{$subsubitem.name}{if empty($okved_id)}{else} ({$subsubitem.count|number_format:0:".":" "}){/if}</a> 
                                                                    {*style="{if $style_submenu}{$style_submenu}{/if}"*}
                                                                </td>
                                                                <td align="right" style="padding-right:25px;">
                                                                      <div class="all" style="display:block">{$subsubitem.c_all}</div>
                                                                      <div class="tele" style="display:none">{$subsubitem.c_tele}</div>
                                                                      <div class="email" style="display:none">{$subsubitem.c_email}</div>
                                                                </td>
                                                                 <td align="right" style="padding-right:25px;">                                                                                               <div class="all" style="display:block">{$subsubitem.column}</div>
                                                                      <div class="tele" style="display:none">{$subsubitem.position}</div>
                                                                      <div class="email" style="display:none">{$subsubitem.count}</div>
                                                                </td>
                                                                 <td> <a class="add_to_bascket" onmouseover="$(this).find('img').attr('src','/img/db_korzina_min_on.png')" onmouseout="$(this).find('img').attr('src','/img/db_korzina_min_off.png')" href="#"><img src="/img/db_korzina_min_off.png"></a></td>
                                                            </tr>

	                                                    {/if}
	                                                {/foreach}
	                                        
	                            {/if}
                                {/foreach}

                          {if $smarty.foreach.okved.iteration == ($smarty.foreach.okved.total)}
                        </table>
                </div>


        <div class="region_list" style="display:none" >
<!-- 
                         <div class="branch_submenu">
                <p style="color:#FF332D;">ТОП: {if $max_okato.count neq 0}<a href="{$SITE_URL}/regionbase/index/id/{$max_okato.id}/">{$max_okato.name} ({$max_okato.count|number_format:0:".":" "}) </a><a class="{if $all_okato}li_ico_up{else}li_ico{/if}" href="{$SITE_URL}/index2/index/okved/{if $all_okved}all{else}{$okved_id}{/if}/okato/{if !$all_okato}all{/if}/id/{$id}">&nbsp;&nbsp;&nbsp;&nbsp;</a>{else}<a href="{$SITE_URL}/index2/index/okved/{if $all_okved}all{else}{$okved_id}{/if}/okato/12530/id/{$id}">Москва</a>; <a href="{$SITE_URL}/index2/index/okved/{if $all_okved}all{else}{$okved_id}{/if}/okato/11600/id/{$id}/">Санкт-Петербург</a> <a class="{if $all_okato}li_ico_up{else}li_ico{/if}" href="{$SITE_URL}/index2/index/okved/{if $all_okved}all{else}{$okved_id}{/if}/okato/{if !$all_okato}all{/if}/id/{$id}">&nbsp;&nbsp;&nbsp;&nbsp;</a>{/if}</p>
            </div> -->
           
 
          <table width="100%" cellspacing="0" cellpadding="0" border="0">

                <tr class="table_title">
                    <td>Выбрать регион:</td>
                    <td >Количество:</td>
                    <td style="padding-left=50px;">Цена:</td>
                    <td></td>
                </tr>
                {foreach from=$okato item=current}
                {if count($current.subitems)!=0}
                {assign var="style_okato" value=""}
                {/if}
                <tr  class="menu_drill" >
                    <td width="60%" class="name_drill">
                        {if $current.id}
                         <a style="font-weight:bold; font-size:13px;" href="{$SITE_URL}/regionbase/index/id/{$current.id}/" title="{$current.name}{if $current.additional_info}, центр: {$current.additional_info}{/if}">{$current.name}</a><a class="drill_down_okato" onClick="HideShow({$current.id})"><img id="drill_down_okato_{$current.id}" src="{$IMG_URL}/drill_down_red.jpg" /></a>
                         {/if}
                    </td>
                    <td align="right" style="padding-right:32px;">
                                            <div class="all" style="display:block">{$current.c_all}</div>
                                            <div class="tele" style="display:none">{$current.c_tele}</div>
                                            <div class="email" style="display:none">{$current.c_email}</div>
                    </td>
                    <td align="right" style="padding-right:48px;">
                                            <div class="all" style="display:block">{$current.node_count}</div>
                                            <div class="tele" style="display:none">{$current.control_number}</div>
                                            <div class="email" style="display:none">{$current.parent_code}</div>                  
                    </td>
                    <td> <a class="add_to_bascket" onmouseover="$(this).find('img').attr('src','/img/db_korzina_min_on.png')" onmouseout="$(this).find('img').attr('src','/img/db_korzina_min_off.png')" href="#"><img src="/img/db_korzina_min_off.png"></a></td>
                </tr>
                
                        {foreach from=$current.subitems item=subitem name=subOkato}
                          {if $subitem.count !=0 }
                           <tr class="last_ul_{$current.id}" id="submenu_drill">
                            <td id="last_ul_li">
                                <a class="submenu_a" href="{$SITE_URL}/regionbase/index/id/{$subitem.id}/" title="{$subitem.additional_info}">{$subitem.name} {$subitem.type}</a>
                            </td>
                           
                           <td align="right" style="padding-right:32px;">
                                            <div class="all" style="display:block">{$subitem.c_all}</div>
                                            <div class="tele" style="display:none">{$subitem.c_tele}</div>
                                            <div class="email" style="display:none">{$subitem.c_email}</div>
                           </td>
                            <td align="right" style="padding-right:48px;">
                                            <div class="all" style="display:block">{$subitem.node_count}</div>
                                            <div class="tele" style="display:none">{$subitem.control_number}</div>
                                            <div class="email" style="display:none">{$subitem.parent_code}</div>
                            </td>
                            <td><a class="add_to_bascket" onmouseover="$(this).find('img').attr('src','/img/db_korzina_min_on.png')" onmouseout="$(this).find('img').attr('src','/img/db_korzina_min_off.png')" href="#"><img src="/img/db_korzina_min_off.png"></a></td>
                           </tr>
                           {/if}
                        {/foreach}
                    
                
                {/foreach}
          <!--       {if $current_okato}</br>{/if}
                {foreach from=$okato_menu_first_level item=okatoFO}
                    {if $okatoFO.id !== $okato_id}
                        <li><a style="font-weight:bold; font-size:11px;" href="{$SITE_URL}/index2/index/okved/{if $all_okved}all{else}{$okved_id}{/if}/okato/{$okatoFO.id}/id/{$id}/" title="{$okatoFO.name}{if $okatoFO.additional_info}, центр: {$okatoFO.additional_info}{/if}">{$okatoFO.name}</a></li>
                    {/if}
                {/foreach}
                <br /> -->
               
            </table>

         </div>
                <!-- <ul class="">
                          {/if}
                        {/if}
                    {/foreach}
                    {if empty($okvedMenuFirstLevel)}
                    {else}
                        {foreach from=$okvedMenuFirstLevel item=menu}
                        {if $menu.id !== $okved_id}
                            <li><a style="font-weight:bold; font-size:10px; margin-left:40px;" href="{$SITE_URL}/index2/index/okved/{$menu.id}/okato/{if $all_okato}all{else}{$okato_id}{/if}/">{$menu.name}</a></li>
                        {/if}
                        {/foreach}
                    {/if}
                </ul> -->
  

       {else}
<!-- sort -->
                <h1><a href="{$SITE_URL}/index2/index/okato/{if $all_okato}all{else}{$okato_id}{/if}/">РУБРИКИ</a><a style="font-size:16px;" href="{$SITE_URL}/index2/index/okato/{if $all_okato}all{else}{$okato_id}{/if}/">&nbsp;(А-Я)</a></h1>
                <div class="branch_submenu">
                    <p style="color:#2D96FE;">ТОП: {if $max_okved}<a style="color:#2D96FE;" href="{$SITE_URL}/database/index/id/{$max_okved.id}/">{$max_okved.name} ({$max_okved.count|number_format:0:".":" "}) </a>{/if}<a class="li_ico" >&nbsp;&nbsp;&nbsp;&nbsp;</a></p>
                </div>
                <span>(
                    {foreach from=$alf item=hit name="alf"}
                        <a {if $hit==$id} class="selected" {/if}  href="{$SITE_URL}/index2/index/okato/{if $all_okato}all{else}{$okato_id}{/if}/id/{$hit}/">{$hit}</a>
                    {/foreach}
                      )<a class="blue_close" href="{$SITE_URL}">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </span>
                <ul class="brunch a-b">
                    {foreach from=$okved item=hit name="okved"}
                        <li class="head"><a href="{$SITE_URL}/database/index/id/{$hit.id}/okato/{$okato_id}/">{$hit.name} ({$hit.count|number_format:0:".":" "})</a></li>
                        {if $smarty.foreach.okved.iteration == (round($smarty.foreach.okved.total/2))  }
                </ul>
                <ul class="brunch a-b">
                        {/if}
                    {/foreach}
                </ul>
        {/if}
    
{literal}
<script type="text/javascript">
$(document).ready(function(){
	$(".drill_down_submenu").toggle(function(){
		$(this).nextAll("ul").find("a").attr("style", "");
		$(this).find("img").attr("src", "/images/drill_up_red.jpg");
	}, function(){
		$(this).find("img").attr("src", "/images/drill_down_red.jpg");
		$(this).nextAll("ul").find("a").filter(function(i){if(i > 4) return true;}).attr("style", "display:none;");
	});
	$(".drill_down_menu").toggle(function(){
		$(this).nextAll("ul").find("li").attr("style", "");
		$(this).find("img").attr("src", "/images/drill_up.jpg");
	}, function(){
		$(this).find("img").attr("src", "/images/drill_down.jpg");
		$(this).nextAll("ul").find("li").filter(function(i){if(i > 1) return true;}).attr("style", "display:none;");
	});
	$(".drill_down_okato").toggle(function(){
		$(this).nextAll("ul").find("li").filter(function(i){if(i > 4) return true;}).attr("style", "").after("<br />");
		$(this).find("img").attr("src", "/images/drill_up_red.jpg");
	}, function(){
		$(this).find("img").attr("src", "/images/drill_down_red.jpg");
		$(this).nextAll("ul").find("li").filter(function(i){if(i > 4) return true;}).attr("style", "display:none;").next().remove();
	});
})
</script>
{/literal}
{include file="search.tpl"}
<table cellpadding="0" cellspacing="0" border="0">
    <tr>
    	{if empty($id)}
            <td class="branch_li2" style='vertical-align: top;'>
                <h1><a href="{$SITE_URL}/index2/index/okato/{$okato_id}/">РУБРИКИ</a> <a id="rub" style="font-size:16px; text-decoration:none;" href="{$SITE_URL}/index2/index/okved/*/okato/{if $all_okato}all{else}{$okato_id}{/if}/">(А-Я)</a></h1>
                <div class="branch_submenu">
                    <p style="color:#2D96FE;">ТОП: {if $max_okved}<a style="color:#2D96FE;" href="{$SITE_URL}/database/index/id/{$max_okved.id}/">{$max_okved.name} ({$max_okved.count|number_format:0:".":" "}) </a>{/if}<a class="{if $all_okved}li_ico_up{else}li_ico{/if}" href="{$SITE_URL}/index2/index/okved/{if !$all_okved}all{/if}/okato/{if $all_okato}all{else}{$okato_id}{/if}/id/{$id}">&nbsp;&nbsp;&nbsp;&nbsp;</a></p>
                </div>
                {if $current_okved}
                    <div class="branch_submenu" style="border:none">
                        <a href="{$SITE_URL}/index2/index/okato/{if $all_okato}all{else}{$okato_id}{/if}/">Рубрики</a>->
                        <a>{$current_okved.name}</a>
                    </div>
                {/if}
                <ul class="brunch">
                    {if empty($okved)} Предприятия отсутствуют при заданных фильтрах <br/> <a href="{$SITE_URL}">Вернуться на главную</a>{/if}
                    {foreach from=$okved item=current name="okved"}
                        {if count($current.subitems)!=0 && $current.count != 0}
                        {assign var="style_menu" value=""}
                          <li>
                            <a style="font-weight:bold; font-size:12px;" href="{$SITE_URL}/database/index/id/{$current.id}/">{$current.name}</a>{if count($current.subitems)>2 and empty($okved_id) and not $all_okved}<a class="drill_down_menu"><img src="{$IMG_URL}/drill_down.jpg" /></a>{/if}
                            <ul class="last_ul_li">
                                {foreach from=$current.subitems item=subitem name="second"}
                                {if $subitem.count != 0}
	                                {if $smarty.foreach.second.iteration > 2 and empty($okved_id) and not $all_okved}
	                                    {assign var="style_menu" value="display:none;"}
	                                {/if}
	                                    <li style="{if $style_menu}{$style_menu}{/if}">
	                                            <a style="font-weight:bold; font-size: 12px;" href="{$SITE_URL}/database/index/id/{$subitem.id}/">{$subitem.name}{if empty($okved_id)}{else}({$subitem.count|number_format:0:".":" "}){/if}</a>{if count($subitem.subitems)>5 and empty($okved_id) and not $all_okved}<a class="drill_down_submenu"><img src="{$IMG_URL}/drill_down_red.jpg" /></a>{/if}
	                                            <br/>
	                                            <ul>
	                                            {assign var="style_submenu" value=""}
	                                                {foreach from=$subitem.subitems item=subsubitem name="third"}
	                                                    {if $subsubitem.count != 0}
	                                                        {if $smarty.foreach.third.iteration > 5 and empty($okved_id) and not $all_okved}
	                                                        	{assign var="style_submenu" value="display:none;"}
	                                                        {/if}
	                                                            <a style="{if $style_submenu}{$style_submenu}{/if}" href="{$SITE_URL}/database/index/id/{$subsubitem.id}/">{$subsubitem.name}{if empty($okved_id)}{else} ({$subsubitem.count|number_format:0:".":" "}){/if}</a>
	                                                    {/if}
	                                                {/foreach}
	                                            </ul>
	                                            <br />
	                                    </li>
	                            {/if}
                                {/foreach}
                            </ul>
                          </li>
                          {if $smarty.foreach.okved.iteration == (round($smarty.foreach.okved.total/2))}
                </ul></div>
                <ul class="brunch">
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
                </ul>
                <div style="clear:both"></div>
                {if $all_okved} 
                	<a style="color:#2D96FE; font-size:11px; font-weight:normal;" href="{$SITE_URL}/index2/index/okato/{if $all_okato}all{else}{$okato_id}{/if}/">свернуть рубрики <<< </a>
				{else}
                    <a style="color:#2D96FE; font-size:11px; font-weight:normal;" href="{$SITE_URL}/index2/index/okved/all/okato/{if $all_okato}all{else}{$okato_id}{/if}/">все рубрики >>> </a>
                {/if}
            </td>
       {else}
<!-- sort -->
            <td class="branch_li2" style='vertical-align: top;'>
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
            </td>
        {/if}
<!-- rubric -->

      <td class="region_li2" style='vertical-align: top;'>
            <h1><a style="color:#FF332D;" href="{$SITE_URL}/index2/index/okved/{if $all_okved}all{else}{$okved_id}{/if}/id/{$id}">Регионы</a><a {if $okato_id eq 'sort'}class="selected" {/if}style="font-size:16px;" href="{$SITE_URL}/index2/index/okved/{if $all_okved}all{else}{$okved_id}{/if}/okato/{if $okato_id neq 'sort'}sort{/if}/id/{$id}/">&nbsp;(А-Я)</a></h1>
            <div class="branch_submenu">
                <p style="color:#FF332D;">ТОП: {if $max_okato.count neq 0}<a href="{$SITE_URL}/regionbase/index/id/{$max_okato.id}/">{$max_okato.name} ({$max_okato.count|number_format:0:".":" "}) </a><a class="{if $all_okato}li_ico_up{else}li_ico{/if}" href="{$SITE_URL}/index2/index/okved/{if $all_okved}all{else}{$okved_id}{/if}/okato/{if !$all_okato}all{/if}/id/{$id}">&nbsp;&nbsp;&nbsp;&nbsp;</a>{else}<a href="{$SITE_URL}/index2/index/okved/{if $all_okved}all{else}{$okved_id}{/if}/okato/12530/id/{$id}">Москва</a>; <a href="{$SITE_URL}/index2/index/okved/{if $all_okved}all{else}{$okved_id}{/if}/okato/11600/id/{$id}/">Санкт-Петербург</a> <a class="{if $all_okato}li_ico_up{else}li_ico{/if}" href="{$SITE_URL}/index2/index/okved/{if $all_okved}all{else}{$okved_id}{/if}/okato/{if !$all_okato}all{/if}/id/{$id}">&nbsp;&nbsp;&nbsp;&nbsp;</a>{/if}</p>
            </div>
            {if $current_okato}
            <div class="branch_submenu" style="border:none">
                <a href="{$SITE_URL}/index2/index/okved/{if $all_okved}all{else}{$okved_id}{/if}/okato/{if $parent_okato}{$parent_okato.id}{/if}/id/{$id}/">{if $parent_okato}{$parent_okato.name}{else}Регионы{/if}</a>->
                <a>{$current_okato.name}</a>
            </div>
            {/if}
            <ul class="brunch">
            	{foreach from=$okato item=current}
            	{if count($current.subitems)!=0}
                {assign var="style_okato" value=""}
                {/if}
                <li>
                    {if $current.id}<a style="font-weight:bold; font-size:13px;" href="{$SITE_URL}/regionbase/index/id/{$current.id}/" title="{$current.name}{if $current.additional_info}, центр: {$current.additional_info}{/if}">{$current.name}</a>{if count($current.subitems)>5 and empty($okato_id) and not $all_okato}<a class="drill_down_okato"><img src="{$IMG_URL}/drill_down_red.jpg" /></a>{/if}<br />
                    {else}{if $current_okato}<a style="font-weight:bold; font-size:13px;" href="{$SITE_URL}/regionbase/index/id/{$current_okato.id}/" title="{$current_okato.name}{if $current_okato.additional_info}, центр: {$current_okato.additional_info}{/if}">{$current_okato.name}</a><br />{/if}
                    {/if}
                    <ul>
                        {foreach from=$current.subitems item=subitem name=subOkato}
                        {if $smarty.foreach.subOkato.iteration > 5 and empty($okato_id) and not $all_okato}
                         {assign var="style_okato" value="display:none;"}
                        {/if}
                        {if $subitem.count !=0 }
	                        <li style="{if $style_okato}{$style_okato}{/if}">
	                            <a href="{$SITE_URL}/regionbase/index/id/{$subitem.id}/" title="{$subitem.additional_info}">{$subitem.name} {$subitem.type}</a>
	                        </li>
	                        {if empty($style_okato)}<br />{/if}
                        {/if}
                        {/foreach}
                    </ul>
                </li>
                {/foreach}
                {if $current_okato}</br>{/if}
                {foreach from=$okato_menu_first_level item=okatoFO}
                	{if $okatoFO.id !== $okato_id}
                		<li><a style="font-weight:bold; font-size:11px;" href="{$SITE_URL}/index2/index/okved/{if $all_okved}all{else}{$okved_id}{/if}/okato/{$okatoFO.id}/id/{$id}/" title="{$okatoFO.name}{if $okatoFO.additional_info}, центр: {$okatoFO.additional_info}{/if}">{$okatoFO.name}</a></li>
                	{/if}
                {/foreach}
                <br />
                {if $all_okato}
                		<li><a style="font-size:11px; font-weight:normal;" href="{$SITE_URL}/index2/index/okved/{if $all_okved}all{else}{$okved_id}{/if}/id/{$id}"> свернуть регионы <<< </a></li>
                {else}
                    {if $okato_id eq 'sort'}
                        <li><a style="font-size:11px; font-weight:normal;" href="{$SITE_URL}/index2/index/okved/{if $all_okved}all{else}{$okved_id}{/if}/id/{$id}"> свернуть регионы <<< </a></li>
                    {else}
                    	<li><a style="font-size:11px; font-weight:normal;" href="{$SITE_URL}/index2/index/okved/{if $all_okved}all{else}{$okved_id}{/if}/okato/all/id/{$id}">все регионы >>> </a></li>
                    {/if}
                {/if}
            </ul>
        </td>
    </tr>
</table>
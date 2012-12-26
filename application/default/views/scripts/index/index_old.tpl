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
})
</script>
{/literal}

{include file="search.tpl"}
<table cellpadding="0" cellspacing="0" border="0">
    <tr>
        {if empty($id)}
            <td class="branch_li">
                <h1><a href="{$SITE_URL}/index/index/okato/{$okato}/">РУБРИКИ</a> <a id="rub" style="font-size:16px; text-decoration:none;" href="{$SITE_URL}/index/index/id/*/okato/{$okato}/sort/{$sort}/">(А-Я)</a></h1>
                <div class="branch_submenu">
                    <p style="color:#2D96FE;">ТОП: <a style="color:#2D96FE;" href="{$SITE_URL}/index/index/okved/{$okvedtop.id}/okato/{$okato}/">{$okvedtop.name} ({$okvedtop.count|number_format:0:".":" "}) </a> <a class="li_ico" >&nbsp;&nbsp;&nbsp;&nbsp;</a></p>
                    {*if isset($current_okved)}     <p>{$current_okved}:  <a class="li_ico">&nbsp;&nbsp;&nbsp;&nbsp;</a></p> {/if}
                    {<p>ТОП: <a href="#">Продукты питания (175)</a>; <a href="#">Транспорт (98)</a>; <a href="#">Туризм (129)</a> <a class="li_ico" href="#">&nbsp;&nbsp;&nbsp;&nbsp;</a></p>*}
                </div>
                {if isset($current_okved)}
                    <div class="branch_submenu" style="border:none">
                        <a href="{$SITE_URL}/index/index/okato//">Рубрики</a>->
                        <a>{$current_okved}</a>
                    </div>
                {/if}
                <ul class="brunch">
                    {if empty($okvedM)} Предприятия отсутствуют при заданных фильтрах <br/> <a href="{$SITE_URL}">Вернуться на главную</a>{/if}
                    {foreach from=$okvedM item=current name="okved"}
                        {if count($current.subitems)!=0}
                        {assign var="style_menu" value=""}
                          <li>
                            <a style="font-weight:bold; font-size:12px;" href="{$SITE_URL}/index/index/okved/{$current.id}/okato/{$okato}/">{$current.name}</a>{if count($current.subitems)>2 and empty($okved) and empty($show)}<a class="drill_down_menu"><img src="{$IMG_URL}/drill_down.jpg" /></a>{/if}
                            <ul class="last_ul_li">
                                {foreach from=$current.subitems item=subitem name="second"}
                                {if $smarty.foreach.second.iteration > 2 and empty($okved) and empty($show)}
                                    {assign var="style_menu" value="display:none;"}
                                {/if}
                                    <li style="{if $style_menu}{$style_menu}{/if}">
                                            <a style="font-weight:bold; font-size: 12px;" href="{$SITE_URL}/index/index/okved/{$subitem.id}/okato/{$okato}/">{$subitem.name}{if empty($okved)}{else} ({$subitem.count|number_format:0:".":" "}){/if}</a>{if count($subitem.subitems)>5 and empty($okved) and empty($show)}<a class="drill_down_submenu"><img src="{$IMG_URL}/drill_down_red.jpg" /></a>{/if}
                                            <br/>
                                            <ul>
                                            {assign var="style_submenu" value=""}
                                                {foreach from=$subitem.subitems item=subsubitem name="third"}
                                                    {if $subsubitem.count!=0}
                                                        {if $smarty.foreach.third.iteration > 5 and empty($okved) and empty($show)}
                                                        	{assign var="style_submenu" value="display:none;"}
                                                            <!--<a style="background:none; color:#393939; list-style:none;" href="{$SITE_URL}/index/index/okved/{$subitem.id}/okato/{$okato}/">...</a>-->
                                                        {/if}
                                                            <a style="{if $style_submenu}{$style_submenu}{/if}" href="{$SITE_URL}/index/index/okved/{$subsubitem.id}/okato/{$okato}/">{$subsubitem.name}{if empty($okved)}{else} ({$subsubitem.count|number_format:0:".":" "}){/if}</a>
                                                    {/if}
                                                {/foreach}
                                            </ul>
                                            <br />
                                    </li>
                                {/foreach}
                            </ul>
                          </li>
                          {if $smarty.foreach.okved.iteration == (round($smarty.foreach.okved.total/2))}
                </ul></div>
                <ul class="brunch">
                          {/if}
                        {else} Предприятия отсутствуют при заданных фильтрах <br/> <a href="{$SITE_URL}">Вернуться на главную</a>
                        {/if}
                    {/foreach}
                    {if empty($okvedMenuFirstLevel)}
                    {else}
                        {foreach from=$okvedMenuFirstLevel item=menu}
                        {if $menu.id !== $okved}
                            <li><a style="font-weight:bold; font-size:10px; margin-left:40px;" href="{$SITE_URL}/index/index/okved/{$menu.id}/okato/{$okato}/">{$menu.name}</a></li>
                        {/if}
                        {/foreach}
                    {/if}
                </ul>
                <div style="clear:both"></div>
                {if empty($show) and empty($okved)} <a style="color:#2D96FE; font-size:11px; font-weight:normal;" href="{$SITE_URL}/index/index/show/all/show2/{$show2}/okato/{$okato}/">все рубрики >>> </a>
                {else}
                    {if isset($show) and empty($okved)} <a style="color:#2D96FE; font-size:11px; font-weight:normal;" href="{$SITE_URL}/index/index/okato/{$okato}/show2/{$show2}/">свернуть рубрики <<< </a>{/if}
                {/if}
                {if ($okved)!=''}
                    <a style="color:#2D96FE; font-size:11px; font-weight:normal;" href="{$SITE_URL}/index/index/show/all/show2/{$show2}/okato/{$okato}/">все рубрики >>> </a>
                {/if}
            </td>
        {else}
<!-- sort -->
            <td class="branch_li">
                <h1><a href="{$SITE_URL}/index/index/okato/{$okato}/sort/{$sort}/">РУБРИКИ</a><a style="font-size:16px;" href="{$SITE_URL}/index/index/okato/{$okato}/sort/{$sort}/">&nbsp;(А-Я)</a></h1>
                <div class="branch_submenu">
                    <p style="color:#2D96FE;">ТОП: <a style="color:#2D96FE;" href="{$SITE_URL}/index/index/okved/{$okvedtop.id}/okato/{$okato}/">{$okvedtop.name} ({$okvedtop.count|number_format:0:".":" "}) </a><a class="li_ico" >&nbsp;&nbsp;&nbsp;&nbsp;</a></p>
{*if isset($current_okved)}<p>{$current_okved}:  <a class="li_ico">&nbsp;&nbsp;&nbsp;&nbsp;</a></p> {/if}{<p>ТОП: <a href="#">Продукты питания (175)</a>; <a href="#">Транспорт (98)</a>; <a href="#">Туризм (129)</a> <a class="li_ico" href="#">&nbsp;&nbsp;&nbsp;&nbsp;</a></p>*}
                </div>
                <span>(
                    {foreach from=$alf item=hit name="alf"}
                        <a {if $hit==$id} class="selected" {/if}  href="{$SITE_URL}/index/index/id/{$hit}/">{$hit}</a>
                    {/foreach}
                      )<a class="blue_close" href="{$SITE_URL}">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </span>
                <ul class="brunch a-b">
{*<li class="head"><a href="#">Готовые продукты питания (1)</a></li><li><a href="#">Кондитерские изделия (1) </a></li><li><a href="#">Крупа, соль (2)  </a></li><li><a href="#">Молочные продукты (16) </a></li>*}
                    {foreach from=$hits item=hit name="okved"}
                        <li class="head"><a href="{$SITE_URL}/index/index/okved/{$hit.id}/okato/{$okato}/">{$hit.name} ({$hit.count|number_format:0:".":" "})</a></li>
                        {if $smarty.foreach.okved.iteration == (round($smarty.foreach.okved.total/2))  }
                </ul>
                <ul class="brunch a-b">
                        {/if}
                    {/foreach}
                </ul>
            </td>
        {/if}
        
<!-- rubric -->

        <td class="region_li">
            <h1><a style="color:#FF332D;" href="{$SITE_URL}/index/index/okved/{$okved}/id/{$id}">Регионы</a><a {if $sort}class="selected" {/if}style="font-size:16px;" href="{$SITE_URL}/index/index/okato//sort/{if empty($sort)}1{/if}/id/{$id}/">&nbsp;(А-Я)</a></h1>
            <div class="branch_submenu">
<!-- <h1 class="categorys"><a href="{$SITE_URL}/index/index/okato/{$okato}/sort/{$sort}/">РУБРИКИ</a></h1><div class="branch_submenu"><p>ТОП: <a href="{$SITE_URL}/index/index/okato/{$okatotop.id}/okato/{$okato}/">{$okatotop.name} ({$okatotop.count|number_format:0:".":" "}) </a></p>-->
                <!-- <p style="color:#FF332D;">ТОП: <a href="{$SITE_URL}/index/index/okved/{$okved}/okato/12530/">Москва</a>; <a href="{$SITE_URL}/index/index/okved/{$okved}/okato/11600/id/{$id}/">Санкт-Петербург</a> <a class="li_ico">&nbsp;&nbsp;&nbsp;&nbsp;</a></p> -->
                <p style="color:#FF332D;">ТОП: <a href="{$SITE_URL}/index/index/okved/{$okved}/okato//">{if $count_max}{$okato_max}({$count_max})</a><a class="li_ico">&nbsp;&nbsp;&nbsp;&nbsp;</a>{else}<a href="{$SITE_URL}/index/index/okved/{$okved}/okato/12530/">Москва</a>; <a href="{$SITE_URL}/index/index/okved/{$okved}/okato/11600/id/{$id}/">Санкт-Петербург</a> <a class="li_ico">&nbsp;&nbsp;&nbsp;&nbsp;</a>{/if}</p>
{*if isset($current_okato)}<p>{$current_okato}:  <a class="li_ico" href="#">&nbsp;&nbsp;&nbsp;&nbsp;</a></p> {/if}{<p>ТОП: <a href="#">Москва (175)</a> <a href="#" class="li_ico">&nbsp;&nbsp;&nbsp;&nbsp;</a></p> *}
            </div>
            {if isset($current_okato)}
            <div class="branch_submenu" style="border:none">
                <a href="{$SITE_URL}/index/index/okved/{$okved}/okato/{$parent_current_okato.id}/id/{$id}/">{$parent_current_okato.name}</a>->
                <a>{$current_okato}</a>
            </div>
            {/if}
            <ul class="brunch">
            	{if isset($current_okato)}
            	<li><span style="font-weight:bold; font-size:14px; color:#FF332D;">{$current_okato}</span><br /></li>
            	{/if}
                {foreach from=$okatoM item=current}
                <li>
{* if $current.parrent_id > 29542}<img src="{$IMG_URL2}/{$current.id}.png" title="{$current.name}" >{/if *}
				{if empty($current.type)}
                    <a {if isset($current_okato)}style="font-size:13px;"{else}style="font-weight:bold; font-size:13px;"{/if} href="{$SITE_URL}/index/index/okved/{$okved}/okato/{$current.id}/id/{$id}/" title="{$current.name}{if ($sort) and ($current.city)}, центр: {$current.city}{/if}">{$current.name}</a><br />
<!--<a style="text-decoration:none; font-size:12px; color:#393939;">Центр:&nbsp;</a>-->
                    <a style="color:#393939;  font-weight: normal; font-size:12px;" href="{$SITE_URL}/index/index/okved/{$okved}/okato/{$current.sity_id}/id/{$id}/" title="{$current.city}">{if empty($sort)}{$current.city}{/if}</a>
                {/if}
                    <ul>
                        {foreach from=$current.subitems item=subitem}
                        <li>
{*if $subitem->getParent_id()>29542}<img src="{$IMG_URL2}/{$subitem->getId()}.png" title="{$subitem->getName()}">{else}<img style="width:10px" src="{$IMG_URL2}/ul_last_pointer.png" title="{$subitem->getName()}">{/if}<img style="width:10px" src="{$IMG_URL2}/ul_last_pointer.png" title="{$subitem}"> {*}
                            <a href="{$SITE_URL}/index/index/okved/{$okved}/okato/{$subitem.id}/id/{$id}/" title="{$subitem.city}">{$subitem.name} {$current.type}</a>
                        </li>
                        <br />
                        {/foreach}
{*<p class="okato_title"><a href="{$SITE_URL}/index/index/okved/{$okved}/okato/{$current.id}/id/{$id}/">все регионы >>> </a></p>*}
                    </ul>
                </li>
                {/foreach}
                {if isset($current_okato)}</br>{/if}
                {foreach from=$okato_menu_first_level item=okatoFO}
                	{if $okatoFO.name !== $current_okato}
                		<li><a style="font-weight:bold; font-size:13px;" href="{$SITE_URL}/index/index/okved/{$okved}/okato/{$okatoFO.id}/id/{$id}/" title="{$okatoFO.name}">{$okatoFO.name}</a></li>
                	{/if}
                {/foreach}
                <br />
                {if empty($show2) and empty($okato)}
                	{if empty($sort)}
                    	<li> <a style="font-size:11px; font-weight:normal;" href="{$SITE_URL}/index/index/show/{$show}/show2/all/okved/{$okved}/"> все регионы >>> </a></li>
                    {else}
                    	<li><a style="font-size:11px; font-weight:normal;" href="{$SITE_URL}/index/index/okved/{$okved}/show/{$show}/"> свернуть регионы <<< </a></li>
                    {/if}
                {else}
                    {if isset($show2) and empty($okato)}
                        <li><a style="font-size:11px; font-weight:normal;" href="{$SITE_URL}/index/index/okved/{$okved}/show/{$show}/"> свернуть регионы <<< </a></li>
                    {/if}
                {/if}
                {if ($okato)!=''}
                    <li><a style="font-size:11px; font-weight:normal;" href="{$SITE_URL}/index/index/show/{$show}/show2/all/okved/{$okved}/">все регионы >>> </a></li>
                {/if}
            </ul>
        </td>
    </tr>
</table>



		<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td class="branch_li">
                                                <h1 class="categorys"><a href="{$SITE_URL}/index2/index/okato/{$okato}">РУБРИКИ</a><a id="rub" style="font-size:16px;" href="{$SITE_URL}/index2/index/okato/{$okato}/sort/1/id/{$id}/">(А-Я)</a></h1>
                                               <div class="branch_submenu">
                                             <p>ТОП: <a href="{$SITE_URL}/index2/index/id/{$okvedtop.id}/okato/{$okato}/">{$okvedtop.name} ({$okvedtop.count}) </a></p>
                                             {*if isset($current_okved)}     <p>{$current_okved}:  <a class="li_ico">&nbsp;&nbsp;&nbsp;&nbsp;</a></p> {/if}
						{<p>ТОП: <a href="#">Продукты питания (175)</a>; <a href="#">Транспорт (98)</a>; <a href="#">Туризм (129)</a> <a class="li_ico" href="#">&nbsp;&nbsp;&nbsp;&nbsp;</a></p>*}
					</div> 
 <span>(
{foreach from=$alf item=hit name="alf"}
<a {if $hit==$id} class="selected" {/if}  href="{$SITE_URL}/index2/rubric/id/{$hit}/">{$hit}</a>
{/foreach}
)<a class="blue_close" href="{$SITE_URL}">&nbsp;&nbsp;&nbsp;&nbsp;</a></span>

					<ul class="brunch a-b">
						{*<li class="head"><a href="#">Готовые продукты питания (1)</a></li>
								<li><a href="#">Кондитерские изделия (1) </a></li>
								<li><a href="#">Крупа, соль (2)  </a></li>

								<li><a href="#">Молочные продукты (16) </a></li>*}
                                                {foreach from=$hits item=hit name="okved"}
						<li class="head"><a href="{$SITE_URL}/index2/index/id/{$hit.id}/okato/{$okato}/">{$hit.name} ({$hit.count})</a></li>

                                                {if $smarty.foreach.okved.iteration == (round($smarty.foreach.okved.total/2))  }
                                                        </ul><ul class="brunch a-b">
                                                {/if}
						{/foreach}
					</ul>




				</td>
				<td class="region_li">
					<h1><a href="{$SITE_URL}/index2/rubric/id/*/">Регионы</a><a id="rub" style="font-size:16px;"></a></h1>
                                        <div class="branch_submenu">
                                          <p>ТОП: <a href="{$SITE_URL}/index2/index/id/{$okved}/okato/12530/">Москва</a> <a href="{$SITE_URL}/index2/index/id/{$okved}/okato/11600/">Санкт-Петербург</a> <a class="li_ico">&nbsp;&nbsp;&nbsp;&nbsp;</a></p>
                                         {*if isset($current_okato)}     <p>{$current_okato}:  <a class="li_ico" href="#">&nbsp;&nbsp;&nbsp;&nbsp;</a></p> {/if*}
					{*	<p>ТОП: <a href="#">Москва (175)</a> <a href="#" class="li_ico">&nbsp;&nbsp;&nbsp;&nbsp;</a></p> *}
					</div>

                                            <ul class="brunch">
                                            {foreach from=$okatoM item=current}
						<li>
                                                   <a href="{$SITE_URL}/index2/rubric/id/{$id}/okato/{$current.id} /">{$current.name} </a>
                                                   <ul>
                                                   {foreach from=$current.subitems item=subitem key=key }
                                                        <li>
                                                            <a href="{$SITE_URL}/index2/rubric/id/{$id}/okato/{$key}/">{$current.type}{$subitem} </a>
                                                        </li><br/>
                                                   {/foreach}
                                                   {*<p class="okato_title"><a href="{$SITE_URL}/okved/{$okved}/okato/{$current.id}/">Все регионы >>> </a></p>*}
                                                   </ul>
                                                </li>
                                    {/foreach}
				</td>


			</tr>
		</table>

         <h1 class="categorys" style="background-image:none; padding-left:0;"><span>( {foreach from=$alf item=hit name="alf"}
<a {if $hit==$id} class="selected" {/if}  href="{$SITE_URL}/index2/rubric/id/{$hit}/">{$hit}</a>
{/foreach}
 ) <a class="blue_close" href="{$SITE_URL}">&nbsp;&nbsp;&nbsp;&nbsp;</a></span></h1>


<div class="right_sidebar">
        	<div class="forex_widget">
                        {include file="basket.tpl"}
                    {foreach from=$right_banners item=item}
                        {$item}
                    {/foreach}
                       {if isset($current_okato)} <a href="{$SITE_URL}/index/street/okato/{$okato}/"> Пробки: {$current_okato} </a>
                       {/if}
        	</div>
                <div class="news">
                	{if count($news)>0}
                        <h1>новости</h1>
                        	<ul>
                                {foreach from=$news item=current}
                                    <li><p class="news_title">
                                        {if !$current->getHideDate()}<span class="date">
                                        {$current->getCreateDate()|rudate}
                                        {/if}
                                        </p>
                                        <a href="{$SITE_URL}/news/{if $current->getRewriteName()}{$current->getRewriteName()}{else}{$current->getId()}{/if}/">
                                        {$current->getContentTruncated85()|escape:html}
                                        </a>
                                     </li>
                        	{/foreach}
                                </ul>
                          {/if}
                </div>
                <div class="banners right_bottom">
                     {foreach from=$right_down_banners item=item}
                        {$item}
                    {/foreach}
                </div>
            </div>
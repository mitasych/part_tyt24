{if empty($left)}
            <div class="left_sidebar">
        	<div class="wather_widget">
                    {*<a href="http://clck.yandex.ru/redir/dtype=stred/pid=7/cid=1228/*http://pogoda.yandex.ru/moscow"><img src="http://info.weather.yandex.net/moscow/2.png" border="0" alt="Яндекс.Погода"/><img width="1" height="1" src="http://clck.yandex.ru/click/dtype=stred/pid=7/cid=1227/*http://img.yandex.ru/i/pix.gif" alt="" border="0"/></a>
                    <a href="http://weather-in.ru/"><img src="http://informer.weather-in.ru/11/107663a.png"
                    alt="Погода в России" title="Погода в России" width="120" height="60" border="0"></a>*}
                    {foreach from=$left_banners item=item}
                        {$item}
                    {/foreach}
                    <p>ВСЕГО: 4 066 309 предприятий</p>
        	</div>
					
        		   {menu name='main_menu'  alias=$RequestUrl controller=$controllerName}
		
		
        		{if $controllerName == 'reports'}
        		<div class="left_nav">
                    <h2>Отчёты:</h2>
                    <ul>
		
        		   {foreach from=$reportsMenu item=item}
		
		
                        <li><a href="{$item->url}">{$item->title}</a></li>
                      
						{/foreach}
                    </ul>
                </div>
        		{/if}
                <div class="left_nav">
                    <h2>ТОП предприятий:</h2>
                    <ul>
		
        		   {foreach from=$leftmenu item=item}
		
		
                        <li><a href="{$SITE_URL}/item/index/id/{$item->getId()}/">{$item->getName()}</a></li>
                      
						{/foreach}
                    </ul>
                    <a href="{$SITE_URL}/list/index/" class="all">Смотреть все >>></a>
                </div>
                   {foreach from=$left_down_banners item=item}
                        {$item}
                   {/foreach}
                {*<a href="#" class="banner"><img src="{$IMG_URL2}/main_banner1.png" /></a>
		<a href="#" class="banner"><img src="{$IMG_URL2}/main_banner2.png" /></a>*}
            </div>
{else}
<!--LEFT MENU -->
   {if empty($left_counter)}
     <div class="left_sidebar">  {mysecondbreadcrumb controller="articles"}</div>
   {else}
     {include file="left_counter.tpl"}
   {/if}
<!--end left menu -->
{/if}
<div class="main_top_text gray">

    {breadcrumb controller="news" alias='archive' altTitle='Архив новостей'}

    <p>&nbsp;</p>
    <a href="/news/lastnews/">последние 10 новостей</a><br>


    <h1>Архив новостей</h1>

    {foreach from=$newsList item=current}
    <h3><a href="{$SITE_URL}/news/{if $current->getRewriteName()}{$current->getRewriteName()}{else}{$current->getId()}{/if}/">{$current->getTitle()|escape:"html"}</a></h3>
    <p>{$current->getContent()|strip_tags|truncate:600}&nbsp;<a href="{$SITE_URL}/news/{if $current->getRewriteName()}{$current->getRewriteName()}{else}{$current->getId()}{/if}/">далее</a></p>
    {/foreach}
    <p class="pager">{$paging}</p>
    <div class="dotted2"></div>
</div>
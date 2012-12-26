		

<div class="main_top_text gray">

    {*breadcrumb controller="news" alias='last10' altTitle='Последние новости'

    <p>&nbsp;</p>*}



    <h1>Последние новости</h1>

    {foreach from=$newsList item=current}
    <div class="news_item">
    <p class="shoplink">
    <h3><a href="{$SITE_URL}/news/{if $current->getRewriteName()}{$current->getRewriteName()}{else}{$current->getId()}{/if}/">{$current->getTitle()|escape:"html"}</a></h3>
    {$current->getContent()|strip_tags|truncate:600}&nbsp;<a href="{$SITE_URL}/news/{if $current->getRewriteName()}{$current->getRewriteName()}{else}{$current->getId()}{/if}/">далее</a>
    </p>
    <hr>
    </div>
{/foreach}

</div>
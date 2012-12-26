{if empty($newsList)}


<div class="main_top_text gray">

    {*breadcrumb controller="news" alias=$currentNews->getRewriteName()

    <p>&nbsp;</p>
    <a href="/news/lastnews/">последние 10 новостей</a> | <a href="/news/archive/">архив</a> <br>*}
    

    <h1>{$currentNews->getTitle()|escape:"html"}</h1>
    {if !$currentNews->getHideDate()}
    <p><a name="{$currentNews->getId()}"></a>{$currentNews->getCreateDate()|date_format:"%d.%m.%Y"}</p><p>&nbsp;</p>
    {/if}
    {*if $currentInfo->getSubmenu()->image}
    <div class="pr_right_bg" style="float: right; margin-left:8px;margin-bottom:3px;">
        <img src="{$SITE_URL}/upload/menu_sub/{$currentInfo->getSubmenu()->image}" alt="" title="" width="132" height="132"  />
    </div>
    {/if*}
    {$currentNews->getContent()}
    <div class="dotted2"></div>
</div>
{/if}
{if isset($newsList)}
<div class="main_top_text gray">

{foreach from=$newsList item=current}
<div class="news_item">
    <h3 class="news"><a href="{$SITE_URL}/news/{if $current->getRewriteName()}{$current->getRewriteName()}{else}{$current->getId()}{/if}/">{$current->getTitle()|escape:"html"}</a></h3>
    {$current->getContent()|strip_tags|truncate:600}&nbsp;<a href="{$SITE_URL}/news/{if $current->getRewriteName()}{$current->getRewriteName()}{else}{$current->getId()}{/if}/">далее</a>

<hr>
</div>
{/foreach}
<div class="dotted2"></div>
</div>
{/if}
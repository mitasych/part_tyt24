
{include file="search.tpl"}



<!--Content-->
    <div class="article">
    <h1>{$currentInfo->getTitle()|escape:html}</h1>
    {if $currentInfo->getSubmenu()->image}
    <div class="pr_right_bg" style="float: right; margin-left:8px;margin-bottom:3px;">
        <img src="{$SITE_URL}/upload/menu_sub/{$currentInfo->getSubmenu()->image}" alt="" title=""  />
    </div>
    {/if}
    
    {$currentInfo->getContentSwitch()}
    </div>

<!-- end content -->
   
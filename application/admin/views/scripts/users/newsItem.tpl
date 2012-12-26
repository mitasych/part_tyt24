{if $currentUser->getId() == $user->getId()}
        	<p style="font-weight:bold;">Статус:&nbsp;{if $current->getIsActive()}<font color="#006600">Подтверждена</font>{else}<font color="#FF0000">Не подтверждена</font>{/if}</p>
{/if}
        
<h3>{$current->getTitle()|escape:html}</h3>
<p>
	{if $current->getAvatar()->isExists()}
    	<img id="blog_image_{$current->getId()}" style="float:left; padding: 0 10px 10px 0;" src="{$current->getAvatar()->setWidth(160)->getImage()}" alt="" title="" />
	{/if}
    {$current->getContent()|escape:html}</p>
    <div style="clear:both; height:0px;"></div>
{if $currentUser->getId() == $user->getId()}
    <span>
    	{if $current->getAvatar()->isExists()}
        	<a onclick="addImageApp.showAddImagePanel({$current->getId()}); return false;" href="#">изменить изображение</a>&nbsp;|&nbsp;
            <a onclick="xajax_blogImageDelete({$current->getId()});return false" href="#">удалить изображение</a>&nbsp;|&nbsp;	
        {else}
        	<a onclick="addImageApp.showAddImagePanel({$current->getId()}); return false;" href="#">добавить изображение</a>&nbsp;|&nbsp;
        {/if}
        <a href="#{*a{$current->getId()}*}" onclick="xajax_newsEdit({$current->getId()}); return false;">изменить</a>&nbsp;|&nbsp;<a href="#" onclick="if (!confirm('Удалить новость?')) return false; else {$smarty.ldelim}xajax_newsDelete({$current->getId()}); return false;{$smarty.rdelim}">удалить</a>
    </span><br />
{/if}
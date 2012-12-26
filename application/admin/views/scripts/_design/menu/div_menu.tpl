<div id="topmenu">
<div id="mtm_menu">

{section name=id loop=$top_menu_hash}
	<a href="{$top_menu_hash[id].HREF}" id="mtm_{$top_menu_hash[id].ID_NAME}">{$top_menu_hash[id].NAME|escape:html}</a>
{/section}

</div>
<script type="text/javascript">


if (TransMenu.isSupported()) {$smarty.ldelim}
var ms = new TransMenuSet(TransMenu.direction.down, 1, 0, TransMenu.reference.bottomLeft);


{section name=id loop=$top_menu_hash}

	{if $top_menu_hash[id].SUBITEMS}
		var menu{$smarty.section.id.iteration} = ms.addMenu(document.getElementById("mtm_{$top_menu_hash[id].ID_NAME}"));

		{section name=id2 loop=$top_menu_hash[id].SUBITEMS}
			menu{$smarty.section.id.iteration}.addItem("{$top_menu_hash[id].SUBITEMS[id2].NAME}", "{$top_menu_hash[id].SUBITEMS[id2].HREF}");

		{/section}

	{/if}
{/section}

TransMenu.renderAll();

{$smarty.rdelim}

</script>
</div>

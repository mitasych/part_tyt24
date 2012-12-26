<div style="line-height:normal;">
<h2 style="color:#FF0000;">Обнаружены следующие ошибки:</h2>
    {foreach item=e from=$errors}
        <span style="color:#FF0000; font-size:12px; font-weight:normal; line-height:normal;">&raquo;&nbsp;{$e|escape:"html"}</span><br />
    {/foreach}
    {if $errors}<br />{/if}
</div>

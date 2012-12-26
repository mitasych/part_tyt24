<h4 style="color:#FF0000">Обнаружены следующие ошибки:</h4>
{foreach item=e from=$errors}
    <font color="#FF0000">&raquo;&nbsp;{$e|escape:"html"}</font> <br />
{/foreach}
<br />
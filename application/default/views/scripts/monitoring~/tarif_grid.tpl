<table cellpadding="5" cellspacing="5" border="1">
    <tr>
        <td>Максимальное количество компаний в мониторинге</td>
        <td>Месяц</td>
        <td>Квартал</td>
        <td>Полгода</td>
        <td>Год</td>
    </tr>
    {foreach from=$tarifsList item=tarif}
    <tr>
        <td>{$tarif->num}</td>
        <td>{if $form}{form_radio name='m' value="`$tarif->id`-1" checked=""}{/if}{$tarif->pM}</td>
        <td>{if $form}{form_radio name='m' value="`$tarif->id`-3" checked=""}{/if}{$tarif->pK}</td>
        <td>{if $form}{form_radio name='m' value="`$tarif->id`-6" checked=""}{/if}{$tarif->pH}</td>
        <td>{if $form}{form_radio name='m' value="`$tarif->id`-12" checked=""}{/if}{$tarif->pY}</td>
    </tr>
    {/foreach}
</table>
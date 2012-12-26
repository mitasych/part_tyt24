{*<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>*}

<div>
    <div class="main_top_text">

        {breadcrumb controller="monitoring" alias="monitoring" altTitle="Мониторинг"}
        {include file="lmenu.tpl"}

        <h1>{info name="monitoringlist" what="title"}</h1>
        <p>{info name="monitoringlist"}</p>

        <div>

            {form from=$form}
            {form_errors_summary}
            <p>
                Введите ИНН:
                {form_text name="inn" value=$fparams.inn}
            </p>
            <p>{form_submit name="submitb" value="Добавить в список мониторинга" style="margin:0;padding:0;"}</p>
            {/form}


            <br>

            <h3>Список контрагентов</h3>
            <table cellpadding="5" cellspacing="5" border="1">
                <tr>
                    <td>ИНН</td>
                    <td>Наименование</td>
                    <td>Регион</td>
                    <td>Страна</td>
                </tr>
                {foreach from=$kontragentsList item=k}
                <tr>
                    <td>{$k->getKontragent()->inn|escape}</td>
                    <td>{$k->getKontragent()->title|escape}</td>
                    <td>{$k->getKontragent()->region|escape}</td>
                    <td>{$k->getKontragent()->country|escape}</td>
                    
                </tr>
                {/foreach}
            </table>


            <br>
            {form from=$form2}
            {form_errors_summary}
            <p>
                Периодичность рассылки:
                {form_select name="period" options=$periodList selected=$user->getTarifInfo()->period}
            </p>
            <p>{form_submit name="submitb2" value="Сохранить" style="margin:0;padding:0;"}</p>
            {/form}

        </div>


        <div class="dotted2"></div>
    </div>
</div>
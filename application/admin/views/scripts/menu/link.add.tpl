{include file="editor_init.tpl"}

<tr>
    <td class="allcontent">
        {form from=$form enctype="multipart/form-data"}
        {form_hidden name="id" value=$currentItem->getId()}
        <table>
            <tr>
                <td class="contentTop">&nbsp;</td>
                <td class="contentTopLeft">Действие:&nbsp;&nbsp;</td>
                <td class="contentTopRight">{if $currentItem->getId()}Редактирование{else}Добавление{/if} элемента {$switchmenu}{form_errors_summary}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Заголовок:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="title" style="width:400px;" value=$currentItem->getTitle()}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Меню:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_select name="menu_id" selected=$currentItem->getMenu_id() options=$categoriesList style="width:400px;"}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Ссылка:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="link" style="width:400px;" value=$currentItem->getLink()}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Порядковый номер:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="queue" style="width:100px;" value=$currentItem->getQueue()}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">Активен:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_checkbox name="isActive" value="1" checked=$currentItem->getIsActive() style="width:20px;"}</td>
            </tr>
            {form_hidden name="isNote" value="0"}
            {*<tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">Под скрепкой:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_checkbox name="isNote" value="1" checked=$currentItem->getIsNote() style="width:20px;"}</td>
            </tr>

            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">Выделен:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_checkbox name="isRed" value="1" checked=$currentItem->getIsRed() style="width:20px;"}</td>
            </tr>*}



            {*<tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">Показать на главной:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_checkbox name="isShow" value="1" checked=$currentItem->isShow style="width:20px;"}</td>
            </tr>*}


            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">Краткое содержание:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea"></td>
            </tr>
            <tr>
                <td class="contentCenter" colspan="3" align="center">{form_textarea name="brif" class="as-visual" style="width:675px; height:500px;" value=$currentItem->brif }</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"> Изображение (160x160):&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">
                    {if $currentItem->image}
                    <br /><img src="{$SITE_URL}/upload/menu/{$currentItem->image}" alt="" title="" />
                    <br />{form_checkbox name="deleteImage" value="1" checked=0 style="width:20px;"}&nbsp;Удалить изображение<br /><br />
                    {/if}{form_file name="avatar" style="height:20px;"}</td>
            </tr>



            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">Страницы показа:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea"></td>
            </tr>
            <tr>
                <td class="contentCenter" colspan="3" align="center">{form_textarea name="view_pages" style="width:500px; height:200px;" value=$currentItem->getStrViewPages() }</td>
            </tr>
            
            {*<tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"> Позиция на домашней странице:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="position" style="width:100px;" value=$currentItem->position}</td>
            </tr>*}




            <tr>
                <td></td>
                <td class="centerUni"></td>
                <td colspan="2">{if $currentItem->getId()}
                    {form_submit value="Обновить элемент" class="batton"}
                    {else}
                    {form_submit value="Добавить элемент" class="batton"}
                    {/if}</td>
            </tr>
            <tr>
                <td class="blackLineLeft"></td>
                <td class="blackLineCenter" colspan="3"></td>
            </tr>
        </table>{/form}</td>
</tr>
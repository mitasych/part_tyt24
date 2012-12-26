{include file="editor_init.tpl"}

<script type="text/javascript" src="{$MODULE_URL}/js/calendar/calendar.js"></script>
<script type="text/javascript" src="{$MODULE_URL}/js/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="{$MODULE_URL}/js/calendar/lang/calendar-ru.js"></script>
<style type="text/css"> @import url("{$MODULE_URL}/js/calendar/calendar-win2k-1.css"); </style>



<tr>
    <td class="allcontent">
        {form from=$form}
        {form_hidden name="id" value=$currentItem->getId()}
        <table>
            <tr>
                <td class="contentTop">&nbsp;</td>
                <td class="contentTopLeft">Действие:&nbsp;&nbsp;</td>
                <td class="contentTopRight">{if $currentItem->getId()}Редактирование{else}Добавление{/if} новости{form_errors_summary}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Заголовок:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="title" style="width:400px;" value=$currentItem->getTitle() class="input"}</td>
            </tr>


            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Категория:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_select name="categoryId" selected=$currentItem->getCategoryId() options=$categoriesList2+$categoriesList  style="width:400px;" class="input"}</td>
            </tr>



            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;"></b> Текст новости:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea"></td>
            </tr>
            <tr>
                <td class="contentCenter" colspan="3" align="center">{form_textarea name="content" class="as-visual" style="width:750px; height:500px;" value=$currentItem->getContent() }</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;"></b> Дата новости:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="createDate" id="createDate" style="width:150px;" value=$currentItem->getCreateDateFormatted() readonly="readonly" class="input"}
                    &nbsp;<button type="submit" id="cal-button-1" class="batton" style="width:40px; margin-top:5px;">...</button>

			{literal}
                    <script type="text/javascript">
                        Calendar.setup({
                        inputField    : "createDate",
                        button        : "cal-button-1",
                        ifFormat 	  : "%d-%m-%Y %H:%M:%S",
                        showsTime     : true,
                        timeFormat    : "24",
                        align         : "Tr"
                        });
                    </script>
			{/literal}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">Активна:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_checkbox name="isActive" value="1" checked=$currentItem->getIsActive() style="width:20px;"}</td>
            </tr>

            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">Скрыть дату&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_checkbox name="hideDate" value="1" checked=$currentItem->getHideDate() style="width:20px;"}</td>
            </tr>


            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            {include file="seo_input_block2.tpl"}

            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>



            <tr>


                <td></td>
                <td class="centerUni"></td>
                <td colspan="2">{if $currentItem->getId()}
                    {form_submit value="Обновить новость" class="batton"}
                    {else}
                    {form_submit value="Добавить новость" class="batton"}
                    {/if}</td>
            </tr>
            <tr>
                <td class="blackLineLeft"></td>
                <td class="blackLineCenter" colspan="3"></td>
            </tr>
        </table>{/form}</td>
</tr>




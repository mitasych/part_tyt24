{include file="editor_init.tpl"}
<tr>
    <td class="allcontent">
        {form from=$form enctype="multipart/form-data"}
        {form_hidden name="id" value=$currentItem->getProperty('id')}
        <table>
            <tr>
                <td class="contentTop">&nbsp;</td>
                <td class="contentTopLeft">Действие:&nbsp;&nbsp;</td>
                <td class="contentTopRight">{if $currentItem->id}Редактирование{else}Добавление{/if} отчета{form_errors_summary}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Название (на главной):&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="title" style="width:400px;" value=$currentItem->getProperty('title') class="input"}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Название (на странице):&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="title_alter" style="width:400px;" value=$currentItem->getProperty('title_alter') class="input"}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Название (на странице "Заказать"):&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="title_order" style="width:400px;" value=$currentItem->getProperty('title_order') class="input"}</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Порядковый номер:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="order" style="width:50px;" value=$currentItem->getProperty('order') class="input"}</td>
            </tr>
			<tr>
				<td class="contentCenter"></td>
				<td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Тип отчёта:&nbsp;&nbsp;</td>
				<td class="contentCenterRight rightArea">{form_select name="type" selected=$currentItem->getProperty('type') options=$typeList style="width:400px;"}</td>
			</tr>
			<tr>
				<td class="contentCenter"></td>
				<td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Элемент меню:&nbsp;&nbsp;</td>
				<td class="contentCenterRight rightArea">{form_select name="category" selected=$currentItem->getProperty('category') options=$categoriesList style="width:400px;"}</td>
			</tr>
			{*<tr>
				<td class="contentCenter"></td>
				<td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Страна:&nbsp;&nbsp;</td>
				<td class="contentCenterRight rightArea">{form_select name="country" selected=$currentItem->getProperty('country') options=$ListContry style="width:400px;"}</td>
			</tr>*}
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"><b style="color:#CB0000;">*</b> Адрес:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="url" style="width:400px;" value=$currentItem->getProperty('url') class="input"}</td>
            </tr>
             <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"> Краткое описание&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_textarea name="text_mini"  style="width:550px; height:200px;" value=$currentItem->getProperty('text_mini') }</td>
            </tr>
             <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"> Полное описание&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_textarea name="text" class="as-visual" style="width:550px; height:300px;" value=$currentItem->getProperty('text') }</td>
            </tr>
             <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"> Вопрос-ответ&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_textarea name="faq" class="as-visual" style="width:550px; height:300px;" value=$currentItem->getProperty('faq') }</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"> Цена:&nbsp;&nbsp;</td>
                <td class="contentCenterRight ">{form_text name="price" style="width:200px;" value=$currentItem->price } {form_checkbox name="flag1" value="1" checked=$currentItem->flag1 style="width:20px;"} - информационная
				<br>{$currentItem->getPricesOutput(1)}
				</td>
            </tr>
            {*<tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">&nbsp;&nbsp;</td>
                <td class="contentCenterRight ">{form_text name="price2" style="width:200px;" value=$currentItem->price2} {form_checkbox name="flag2" value="1" checked=$currentItem->flag2 style="width:20px;"} - официальная-обычная
				<br>{$currentItem->getPricesOutput(2)}
				</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"> &nbsp;&nbsp;</td>
                <td class="contentCenterRight ">{form_text name="price3" style="width:200px;" value=$currentItem->price3 } {*{form_checkbox name="flag3" value="1" checked=$currentItem->flag3 style="width:20px;"} - официальная-срочная*}
				<br>{$currentItem->getPricesOutput(3)}
				</td>
            </tr>*}
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">&nbsp;&nbsp;</td>
                <td class="contentCenterRight ">{form_checkbox name="flag2" value="1" checked=$currentItem->flag2 style="width:20px;"} - официальная-обычная
				</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"> &nbsp;&nbsp;</td>
                <td class="contentCenterRight ">{form_checkbox name="flag3" value="1" checked=$currentItem->flag3 style="width:20px;"} - официальная-срочная
				</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft"> Сроки:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="time" style="width:200px;" value=$currentItem->time } 
				</td>
            </tr>
           {* <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="time2" style="width:200px;" value=$currentItem->time2} - официальная-обычная
				</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="time3" style="width:200px;" value=$currentItem->time3 } - официальная-срочная</td>
            </tr>*}
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">Пример:&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="example_name" style="width:200px;" value=$currentItem->getProperty('example_name')} - название
				</td>
            </tr>
            <tr>
                <td class="contentCenter"></td>
                <td class="contentCenterLeft">&nbsp;&nbsp;</td>
                <td class="contentCenterRight rightArea">{form_text name="example_url" style="width:200px;" value=$currentItem->getProperty('example_url') } - ссылка</td>
            </tr>

			<tr>
				<td class="contentCenter"></td>
				<td class="contentCenterLeft"> Изображение:&nbsp;&nbsp;</td>
				<td class="contentCenterRight rightArea">
					{if $currentItem->img} 
						<br /><img src="{$SITE_URL}/upload/order/{$currentItem->img}" alt="" title="" />
						<br />{form_checkbox name="deleteImage" value="1" checked=0 style="width:20px;"}&nbsp;Удалить изображение<br /><br />
					{/if}{form_file name="img" style="height:20px;"}</td>
			</tr>
			
			<tr>
				<td class="contentCenter"></td>
				<td class="contentCenterLeft">Отображать на странице компании:&nbsp;&nbsp;</td>
				<td class="contentCenterRight rightArea">{form_checkbox name="active_company" value="1" checked=$currentItem->active_company style="width:20px;"}</td>
			</tr>
			
			<tr>
				<td class="contentCenter"></td>
				<td class="contentCenterLeft">Отображать на странице отчётов:&nbsp;&nbsp;</td>
				<td class="contentCenterRight rightArea">{form_checkbox name="main_page" value="1" checked=$currentItem->main_page style="width:20px;"}</td>
			</tr>
			<tr>
				<td class="contentCenter"></td>
				<td class="contentCenterLeft">Отображать в меню отчётов:&nbsp;&nbsp;</td>
				<td class="contentCenterRight rightArea">{form_checkbox name="report_menu" value="1" checked=$currentItem->report_menu style="width:20px;"}</td>
			</tr>
			{*<tr>
				<td class="contentCenter"></td>
				<td class="contentCenterLeft">Активен:&nbsp;&nbsp;</td>
				<td class="contentCenterRight rightArea">{form_checkbox name="active" value="1" checked=$currentItem->active style="width:20px;"}</td>
			</tr>*}
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td class="centerUni"></td>
                <td colspan="2">{if $currentItem->id}
                    {form_submit value="Обновить" class="batton"}
                    {else}
                    {form_submit value="Добавить" class="batton"}
                    {/if}</td>
            </tr>
            <tr>
                <td class="blackLineLeft"></td>
                <td class="blackLineCenter" colspan="3"></td>
            </tr>
        </table>{/form}</td>
</tr>
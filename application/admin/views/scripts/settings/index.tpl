<tr>
	<td>
		<h3>Настройки</h3>
	</td>
</tr>
<tr>
	<td class="allcontent">
    	<table>
        	<tr>
                <td class="tableTop">&nbsp;</td>
                <td class="tableTopNext">Название параметра</td>
                <td class="tableTopNext">Значение параметра</td>
                <td class="tableTopNext tableTopEnd">Действия</td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Правовая информация:</td>
                <td class="tableBottom">{$variables->get('site_copyright_information')}</td>
                <td class="tableBottomUni"><a href="{$MODULE_URL}/settings/copyright/"><img src="{$MODULE_URL}/images/edit.png" alt="Изменить" title="Изменить" /></a></a></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">E-mail для формы обратной связи:</td>
                <td class="tableBottom">{$variables->get('email_contact')}</td>
                <td class="tableBottomUni"><a href="{$MODULE_URL}/settings/contact/"><img src="{$MODULE_URL}/images/edit.png" alt="Изменить" title="Изменить" /></a></a></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">E-mail для формы online-запроса и анализа:</td>
                <td class="tableBottom">{$variables->get('email_online')}</td>
                <td class="tableBottomUni"><a href="{$MODULE_URL}/settings/online/"><img src="{$MODULE_URL}/images/edit.png" alt="Изменить" title="Изменить" /></a></a></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">E-mail главной страницы:</td>
                <td class="tableBottom">{$variables->get('email_info')}</td>
                <td class="tableBottomUni"><a href="{$MODULE_URL}/settings/info/"><img src="{$MODULE_URL}/images/edit.png" alt="Изменить" title="Изменить" /></a></a></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Телефон:</td>
                <td class="tableBottom">{$variables->get('phone')}</td>
                <td class="tableBottomUni"><a href="{$MODULE_URL}/settings/phone/"><img src="{$MODULE_URL}/images/edit.png" alt="Изменить" title="Изменить" /></a></a></td>
          	</tr>
              <tr>
            	<td></td>
                <td class="tableBottom">Телефон2:</td>
                <td class="tableBottom">{$variables->get('phone2')}</td>
                <td class="tableBottomUni"><a href="{$MODULE_URL}/settings/phone2/"><img src="{$MODULE_URL}/images/edit.png" alt="Изменить" title="Изменить" /></a></a></td>
          	</tr>
              <tr>
            	<td></td>
                <td class="tableBottom">Заголовк сайта:</td>
                <td class="tableBottom">{$variables->get('header')}</td>
                <td class="tableBottomUni"><a href="{$MODULE_URL}/settings/header/"><img src="{$MODULE_URL}/images/edit.png" alt="Изменить" title="Изменить" /></a></a></td>
          	</tr>
          	</tr>
              <tr>
            	<td></td>
                <td class="tableBottom">Официальные отчёты:</td>
                <td class="tableBottom">{if $variables->get('official_reports') == 1}Включены {else}Выключены {/if}</td>
                <td class="tableBottomUni"><a href="{$MODULE_URL}/settings/ofreports/"><img src="{$MODULE_URL}/images/edit.png" alt="Изменить" title="Изменить" /></a></a></td>
          	</tr>
            {* <tr>
            	<td></td>
                <td class="tableBottom">Профиль:</td>
                <td class="tableBottom">{$variables->get('profile')}</td>
                <td class="tableBottomUni"><a href="{$MODULE_URL}/settings/profile/"><img src="{$MODULE_URL}/images/edit.png" alt="Изменить" title="Изменить" /></a></a></td>
          	</tr>*}
            <tr>
                <td class="blackLineLeft"></td>
                <td class="blackLineCenter" colspan="3"></td>
              </tr>
        </table>
    </td>
</tr>
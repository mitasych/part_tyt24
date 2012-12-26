<tr>
	<td>
		<h3>Настройки платежной системы</h3>
	</td>
</tr>

{if $updateMessage}
<tr>
    <td align="center">
        <b style="color:red;">{$updateMessage}</b>
	</td>
</tr>
{/if}
<tr>
	<td class="allcontent">
    	<table>
        	<tr>
                <td class="tableTop">&nbsp;</td>
                <td class="tableTopNext" width="25%">Название</td>
                <td class="tableTopNext">Значение</td>
                <td class="tableTopNext tableTopEnd"></td>
          	</tr>
            <form action="" method="post">
            

            <tr>
            	<td></td>
                <td class="tableBottom">Организация</td>
                <td class="tableBottom"><input type="text" name="settings[organization]" value="{$settings->get('organization')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">Юридический адрес</td>
                <td class="tableBottom"><input type="text" name="settings[uraddr]" value="{$settings->get('uraddr')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">Фактический адрес</td>
                <td class="tableBottom"><input type="text" name="settings[factaddr]" value="{$settings->get('factaddr')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">Тел./факс</td>
                <td class="tableBottom"><input type="text" name="settings[telfax]" value="{$settings->get('telfax')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">ИНН</td>
                <td class="tableBottom"><input type="text" name="settings[inn]" value="{$settings->get('inn')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">КПП</td>
                <td class="tableBottom"><input type="text" name="settings[kpp]" value="{$settings->get('kpp')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">Получатель</td>
                <td class="tableBottom"><input type="text" name="settings[receiver]" value="{$settings->get('receiver')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">Счет получателя</td>
                <td class="tableBottom"><input type="text" name="settings[receiverschet]" value="{$settings->get('receiverschet')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">Банк получателя</td>
                <td class="tableBottom"><input type="text" name="settings[receiverbank]" value="{$settings->get('receiverbank')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>


            <tr>
            	<td></td>
                <td class="tableBottom">БИК</td>
                <td class="tableBottom"><input type="text" name="settings[bik]" value="{$settings->get('bik')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">Счет</td>
                <td class="tableBottom"><input type="text" name="settings[schet]" value="{$settings->get('schet')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">Генеральный директор</td>
                <td class="tableBottom"><input type="text" name="settings[gendirector]" value="{$settings->get('gendirector')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">Главный бухгалтер</td>
                <td class="tableBottom"><input type="text" name="settings[glavbuh]" value="{$settings->get('glavbuh')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">Примечание</td>
                <td class="tableBottom"><input type="text" name="settings[primechanie]" value="{$settings->get('primechanie')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
                <td></td>
                <td class="tableBottom">Минимальная сумма при вводе денег</td>
                <td class="tableBottom"><input type="text" name="settings[minimumvaluemoney]" value="{$settings->get('minimumvaluemoney')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
            </tr>

<tr>
                <td class="tableTop">&nbsp;</td>
                <td class="tableTopNext">&nbsp;</td>
                <td class="tableTopNext">&nbsp;</td>
                <td class="tableTopNext tableTopEnd"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom"><b>Webmoney активирована (1-да, 0-нет)</b></td>
                <td class="tableBottom"><input type="text" name="settings[webmoneyenabled]" value="{$settings->get('webmoneyenabled')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Webmoney скидка (%)</td>
                <td class="tableBottom"><input type="text" name="settings[webmoneyskidka]" value="{$settings->get('webmoneyskidka')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Webmoney вариант №1</td>
                <td class="tableBottom"><input type="text" name="settings[webmoneyslot1]" value="{$settings->get('webmoneyslot1')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Webmoney вариант №2</td>
                <td class="tableBottom"><input type="text" name="settings[webmoneyslot2]" value="{$settings->get('webmoneyslot2')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>


            <tr>
            	<td></td>
                <td class="tableBottom"><b>Interkassa активирована (1-да, 0-нет)</b></td>
                <td class="tableBottom"><input type="text" name="settings[interkassaenabled]" value="{$settings->get('interkassaenabled')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Interkassa скидка (%)</td>
                <td class="tableBottom"><input type="text" name="settings[interkassaskidka]" value="{$settings->get('interkassaskidka')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Interkassa вариант №1</td>
                <td class="tableBottom"><input type="text" name="settings[interkassaslot1]" value="{$settings->get('interkassaslot1')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Interkassa вариант №2</td>
                <td class="tableBottom"><input type="text" name="settings[interkassaslot2]" value="{$settings->get('interkassaslot2')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Interkassa вариант №3</td>
                <td class="tableBottom"><input type="text" name="settings[interkassaslot3]" value="{$settings->get('interkassaslot3')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Interkassa вариант №4</td>
                <td class="tableBottom"><input type="text" name="settings[interkassaslot4]" value="{$settings->get('interkassaslot4')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom"><b>Robokassa активирована (1-да, 0-нет)</b></td>
                <td class="tableBottom"><input type="text" name="settings[robokassaenabled]" value="{$settings->get('robokassaenabled')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Robokassa скидка (%)</td>
                <td class="tableBottom"><input type="text" name="settings[robokassaskidka]" value="{$settings->get('robokassaskidka')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Robokassa вариант №1</td>
                <td class="tableBottom"><input type="text" name="settings[robokassaslot1]" value="{$settings->get('robokassaslot1')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Robokassa вариант №2</td>
                <td class="tableBottom"><input type="text" name="settings[robokassaslot2]" value="{$settings->get('robokassaslot2')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Robokassa вариант №3</td>
                <td class="tableBottom"><input type="text" name="settings[robokassaslot3]" value="{$settings->get('robokassaslot3')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom"><b>Нал / безнал</b></td>
                <td class="tableBottom"></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Наличные скидка (%)</td>
                <td class="tableBottom"><input type="text" name="settings[nalskidka]" value="{$settings->get('nalskidka')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Безналичные скидка (%)</td>
                <td class="tableBottom"><input type="text" name="settings[beznalskidka]" value="{$settings->get('beznalskidka')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom"><b>Дополнительная платежная система активирована (1-да, 0-нет)</b></td>
                <td class="tableBottom"><input type="text" name="settings[additionalenabled]" value="{$settings->get('additionalenabled')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Дополнительная платежная система скидка (%)</td>
                <td class="tableBottom"><input type="text" name="settings[additionalskidka]" value="{$settings->get('additionalskidka')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Дополнительная платежная система название</td>
                <td class="tableBottom"><input type="text" name="settings[additionalslot1]" value="{$settings->get('additionalslot1')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>
            <tr>
            	<td></td>
                <td class="tableBottom">Дополнительная платежная система №кошелька</td>
                <td class="tableBottom"><input type="text" name="settings[additionalpurse]" value="{$settings->get('additionalpurse')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>





            <tr>
                <td class="tableTop">&nbsp;</td>
                <td class="tableTopNext">&nbsp;</td>
                <td class="tableTopNext">&nbsp;</td>
                <td class="tableTopNext tableTopEnd"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">Email администратора для отправки копий заказа (по умолчанию)</td>
                <td class="tableBottom"><input type="text" name="settings[adminemailforcopies]" value="{$settings->get('adminemailforcopies')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">Email администратора для отправки копий заказа (b2b-base.ru)</td>
                <td class="tableBottom"><input type="text" name="settings[adminemailforcopiesb2bbaseru]" value="{$settings->get('adminemailforcopiesb2bbaseru')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">Email администратора для отправки копий заказа (tamstat.ru)</td>
                <td class="tableBottom"><input type="text" name="settings[adminemailforcopiestamstatru]" value="{$settings->get('adminemailforcopiestamstatru')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>


            <tr>
                <td class="tableTopNext" colspan="3">Для добавления баннера, загрузите в менеджере файлов в папку sa изображение и вставте сюда имя файла</td>
                <td class="tableTopNext tableTopEnd"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">Баннер мониторинг</td>
                <td class="tableBottom"><input type="text" name="settings[bannermonitoring]" value="{$settings->get('bannermonitoring')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">Баннер отчеты</td>
                <td class="tableBottom"><input type="text" name="settings[bannerreports]" value="{$settings->get('bannerreports')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>

            <tr>
            	<td></td>
                <td class="tableBottom">Баннер базы даных</td>
                <td class="tableBottom"><input type="text" name="settings[bannerbases]" value="{$settings->get('bannerbases')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>


            <tr>
            	<td></td>
                <td class="tableBottom">Баннер вэд</td>
                <td class="tableBottom"><input type="text" name="settings[bannerved]" value="{$settings->get('bannerved')}" style="width:470px;" /></td>
                <td class="tableBottomUni"></td>
          	</tr>


            <tr>
                <td></td>
                <td></td>
                <td><input type="submit" name="submit" value="Сохранить" class="batton" /></td>
                <td></td>
            </tr>
            </form>
            <tr>
                <td class="blackLineLeft"></td>
                <td class="blackLineCenter" colspan="3"></td>
              </tr>
        </table>
    </td>
</tr>
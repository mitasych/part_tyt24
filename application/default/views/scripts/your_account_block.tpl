
{if $user->isAuthenticated()}

    <ul class="account_block">
          <li class="block_user" style="color:red; font-weight:bold;">
            <span id="userblock1" onClick="$('#account_infoblock').show();$('#userblock1').hide();$('#userblock2').show();" style="color:#2D96FE;margin-left: 10px;text-decoration: underline;">  {$user->getName()}  {$user->getSecondName()} <img src="/images/drill_down.png"/> </span> 
            <span id="userblock2" onClick="$('#account_infoblock').hide();$('#userblock2').hide();$('#userblock1').show();" style="display:none;color:#FF332D;margin-left: 10px;text-decoration: none;"> {$user->getName()}  {$user->getSecondName()} 
              <img src="/images/drill_up_red.png"/> </span>
          </li>
          <li style="color: gray; margin-top: 10px;"> <span> {$user->organization} </span></li>
          <li> <a class="{if CONTROLLER_NAME == 'users' && ACTION_NAME=='orders'}active{/if}" href="{$user->getUserPath('orders')}">Мои заказы</a> </li>
          <li> <a class="{if CONTROLLER_NAME == 'users' && ACTION_NAME=='plateji'}active{/if}" href="{$user->getUserPath('plateji')}">Мои платежи</a> </li>
          <li> <a class="{if CONTROLLER_NAME == 'users' && ACTION_NAME=='docs'}active{/if}" href="{$user->getUserPath('docs')}">Документы</a> </li>
          
 </ul>

 <div id="account_infoblock" class="events_info_block" style="width: 180px;">  
    <div style="position:relative;float:right;cursor:pointer;font-size: 15px;color: gray;top:5px;right:5px" onclick="$('#account_infoblock').hide();$('#userblock2').hide();    $('#userblock1').show();"> X </div>
      <ul style="padding: 3px 13px; line-height: 20px;">
             <li> <a class="{if CONTROLLER_NAME == 'users' && ACTION_NAME=='editprofile'}active{/if}" href="{$user->getUserPath('editprofile')}">Личные данные</a> </li>
             <li> Баланс: <span style="color:#2D96FE;">{$user->balans} руб.</span> </li>
            {*<input type="submit" name="balance" value="Пополнить счет" class="file_input_button">
            <input type="submit" name="exit" value="Выйти" class="file_input_button">*}
             <li> <a class="accountblock_button" style="color: #575757;text-decoration: none;font-weight: 700;line-height: 32px;" href="{$SITE_URL}/order/balans/" style="color:#2D96FE;"> Пополнить баланс </a> </li> 
             <li> Бонус: <span style="color:#2D96FE;"> 0 </span> <a class="file_input_button" style="margin-left: 28px; color: #575757;text-decoration: none;font-weight: 700;line-height: 32px;" href="{$SITE_URL}/users/logout/">выйти</a></li> 
       </ul> 
 </div>
 

{else}
 
    {form from=$enter_form id="loginForm"}
      
      <table border="0" cellpadding="0" cellspacing="0"><tr><td colspan="2">{form_text id="log" name="login"  maxlength="15" size="15" value="логин" onfocus="if ($(this).attr('value') == 'логин') $(this).attr('value','');"}</td></tr>
      <tr><td>{form_password id="pass" name="pass" value="пароль" maxlength="7" size="7" onfocus="if ($(this).attr('value') == 'пароль') $(this).attr('value','');"}</td>
      <td>{form_submit id="enter" onclick="$('#loginForm').submit(); return false;" value=">>"}</td></tr>
      </table>
    {/form}
                    <ul>
			
			<li><a href="{$SITE_URL}/registration/" style="color:#2D96FE;" >Регистрация</a></li>
			<li><a href="{$SITE_URL}/remember/" style="color:#2D96FE;" >Забыли пароль</a></li>
                    </ul>

                     <div onmouseover="AddTT('Инфоблок');" onmouseout="RemoveTT();">  
                           <div id="info_link"> </div>
                        </div>  
                  
                 </div>
</div> 
{/if}




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
<title>Административная панель</title>
<style media="all" type="text/css">
@import url(/css/style.css);
</style>
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
</head>
<body>
<div style="width:200px; margin: 0 auto;">
  <h1>Вход</h1>
  <div class="base-text"> {form from=$form}
    {form_errors_summary}
    <div>
      <div>
        <div>Имя пользователя</div>
        <div>{form_text name="login"}</div>
      </div>
      <div>
        <div>Пароль</div>
        <div>{form_password name="pass" style="width:180px;"}</div>
      </div>
      {*
      <div>
        <div>{form_checkbox name="rememberme" value="1" checked=false} Запомнить меня на этом компьютере</div>
      </div>
      *}
      <div>
        <div>{form_submit name="submitb" value="Войти"}</div>
      </div>
    </div>
    {/form} </div>
  <div class="footer"> &copy; 2007&nbsp;<a href="{$SITE_URL}">edem.by</a> </div>
</div>
</body>
</html>

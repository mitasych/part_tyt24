<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
<title>{$TITLE}</title>
<link rel="stylesheet" type="text/css" href="{$MODULE_URL}/css/adminarea.css" />
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="{$MODULE_URL}/css/style.css" />
</head><body>

<table bgcolor="#FFFFFF" width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="height:100px;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center">
      <table width="300" border="0" align="center" cellpadding="0" cellspacing="0" class="login">
        <tr>
          <td align="center">
            {form from=$form}
              <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" style="font-size:10px; color:#FF0000"> <br>
                    {form_errors_summary}
                  </td>
                </tr>
                <tr>
                  <td align="right"><strong class="grey_10">Пользователь: </strong></td>
                  <td>
                    {form_text name="login" class="input"}
                  </td>
                </tr>
                <tr>
                  <td align="right"><strong class="grey_10">Пароль:</strong></td>
                  <td>
                    {form_password name="pass" class="input" style="width:180px;"}
                  </td>
                </tr>
                <tr>
                  <td colspan="2" align="right">
                    <input type="checkbox" value="1" name="remindpass" {if $remindpass}checked="checked"{/if}/>
                    <strong class="grey_10">запомнить&nbsp;</strong> </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="right">
                    <div align="left">
                      {form_submit name="submitb" value="Войти" class="submit"}
                    </div>
                  </td>
                </tr>
              </table>
            {/form}
            <br>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>

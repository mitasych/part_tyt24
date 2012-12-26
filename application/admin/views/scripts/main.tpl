<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
<title>{$TITLE}</title>
<META name="description" content="" />
<META name="keywords" content="" />
<link href="{$MODULE_URL}/css/all.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="{$SITE_URL}/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="{$SITE_URL}/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="{$MODULE_URL}/css/menu.css" />
<script type="text/javascript" src="{$MODULE_URL}/js/transmenu.js"></script>
<script type="text/javascript">

function initTransMenu() {$smarty.ldelim}

if (TransMenu.isSupported()) {$smarty.ldelim}
TransMenu.initialize();

{section name=id loop=$top_menu_hash}

	{if $top_menu_hash[id].SUBITEMS}
		menu{$smarty.section.id.iteration}.onactivate = function() {$smarty.ldelim} document.getElementById("mtm_{$top_menu_hash[id].ID_NAME}").className = "hover"; {$smarty.rdelim};
		menu{$smarty.section.id.iteration}.ondeactivate = function() {$smarty.ldelim} document.getElementById("mtm_{$top_menu_hash[id].ID_NAME}").className = ""; {$smarty.rdelim};
	{else}
		document.getElementById("mtm_{$top_menu_hash[id].ID_NAME}").onmouseover = function() {$smarty.ldelim} ms.hideCurrent(); this.className = "hover"; {$smarty.rdelim}
		document.getElementById("mtm_{$top_menu_hash[id].ID_NAME}").onmouseout = function() {$smarty.ldelim} this.className = ""; {$smarty.rdelim}
	{/if}

{/section}


{$smarty.rdelim}
{$smarty.rdelim}

</script>
<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="{$MODULE_URL}/css/ie6.css" /><![endif]-->
<!--[if !lt IE 7]><link rel="stylesheet" type="text/css" href="{$MODULE_URL}/css/ie7.css" /><![endif]-->

<script type="text/javascript">
if(navigator.appName == "Opera") document.write("<link rel='stylesheet' href='css/opera.css' type='text/css'>");
</script>
<!--[if lt IE 7]><script defer type="text/javascript" src="{$MODULE_URL}/js/pngfix.js"></script><![endif]-->
</head>
<body class="yui-skin-sam" onload="initTransMenu()">

<table class="one">
<!-- the header -->
  <tr>
    <td><div class="header">
        <div class="headerLeft"><a href="{$SITE_URL|escape:html}"><img src="{$MODULE_URL}/images/logo.png" height=50px></a>
          <h1>Административный модуль</h1>
        </div>
        <div class="headerRight">
          <div class="headerRightDiv">
            
          <a href="{$MODULE_URL}/auth/logout/" class="headerRightDuoLink"><img class="headerRightDuoImg" src="{$MODULE_URL}/images/exit.png"></a></div>
        </div>
      </div></td>
  </tr>
  <!-- end header -->

<tr><td>{include file="_design/menu/div_menu.tpl"}</td></tr>

  <!-- the center -->
  <tr>
  	<td class="upAlltable">
        <div style="margin:15px;">
        <table class="alltable">
            {include file=$BODY_CONTENT_FILE}
        </table>
        </div>
  	</td>
  </tr>
  <!-- end center -->	

  <!-- the footer -->
  <tr>
    <td><div class="footer">
        <div class="footerLeft"><a href="{$SITE_URL|escape:html}">{$SITE_COPYRIGHT}</a></div>
        <div class="footerRight">
          
        </div>
      </div></td>
  </tr>
  <!-- end footer -->
</table>
</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TUT24</title>
<link rel="stylesheet" type="text/css" href="{$CSS_URL}/style.css" />
<link rel="stylesheet" type="text/css" href="{$CSS_URL}/jQuery.Tree.css" />
<!--[if IE]>
 <link rel="stylesheet" type="text/css" href="{$CSS_URL}/style_ie.css" />
<![endif]-->
<!--[if lte IE 7]>
 <link rel="stylesheet" type="text/css" href="{$CSS_URL}/style_ie7.css" />
<![endif]-->
<script type="text/javascript" src="{$JS_URL}/jquery-1.5.min.js"></script>
<script type="text/javascript" src="{$JS_URL}/jquery.tabSlideOut.v1.2.js"></script>
<script type="text/javascript" src="{$JS_URL}/jquery.watermark.js"></script>
<script type="text/javascript" src="{$JS_URL}/jQuery.Tree.js"></script>
<script src="http://api-maps.yandex.ru/1.1/index.xml?key=AE07qE0BAAAAa8RdbAIAGoy1Go-5BSLfD2D68SYnvlS6BokAAAAAAAAAAAAG4jsyAHFKz2lsQaettz9OdTPwFg==" type="text/javascript"></script>

</head>

<body>
<div id="page">
	<!-- header -->
	<div id="header">
		<div class="header_note">
        
			<ul>
                        {menu name='note_head' }
                        </p>
				<li><a style="color:#2D97FF" id="login" href="#">Вход в личный кабинет</a></li>
			</ul>
		</div>
		            <div class="slide-out-div" style="z-index:1000;">
        <a class="handle"  href="/user/">Личный Кабинет</a>
        <h3><span lang="ru">Вход в личный кабинет </span></h3>
        {include file="your_account_block.tpl"}
	
        <a href="/"><img id="outlogin" src="{$IMG_URL2}/bottom_pager_left.png"/></a>
        </form></div>

                <a href="/" class="logo"><img src="{$IMG_URL2}/logo.png" title="ТУТ 24" alt="ТУТ 24" /></a>
		<p class="summary"><strong>ТУТ24</strong> &#8212;
                {getsession name='session' alias=$RequestUrl}
                {menu name='title_head' }</p>
                <div id="Menu1" class="stickers">
                               <ul id="menu">
                            {menu name='top_menu'  }
                               </ul>
                </div>
         </div>

	<!-- end header -->

	

	<!-- content -->
	<div id="content">
		{include file=$BODY_CONTENT_FILE}
		<ul class="bottom_nav">
		  {menu name='bottom_menu'}
		</ul>
	</div>
	<!-- end content -->

	<!-- footer -->
	<div id="footer">
		<p>&copy; 2010 СООО <span style="font-size:12px; font-weight:bold;">"ТУТ24"</span>&nbsp;&nbsp;Правила использования информации</p>
		<p>Телефонный бизнес - справочник Бизнес-Беларусь<br />
		   Телефонные городские справочники Контакт! Минск, Контакт! Регионы</p>
	</div>
</div>


    
</body>
{literal}
<script  type="text/javascript">
$("input#search1").watermark('пример: мебель, продукты');
$("input#search1").watermark('пример: Москва');
</script>

<script type="text/javascript">
$(document).ready(function(){
    $("#login").click(function(){
            $(".header_note").animate({"right": "-215px"}, "slow");
            $(".header_note").fadeOut("fast");
            $(".slide-out-div").fadeIn("slow");

        return false;
    });
});
$(document).ready(function(){
    $("#outlogin").click(function(){
            $(".slide-out-div").fadeOut("slow");
            $(".header_note").fadeIn("fast");
            $(".header_note").animate({"right": "0px"}, "slow");
        return false;
    });
});
</script>
{/literal}
</html>
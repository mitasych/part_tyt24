{php}
if(ereg('monitoring/event/(.*)',$_SERVER['REQUEST_URI'])){  {/php}
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>{if $TITLE}TYT24 - {$TITLE}{else}TYT24{/if}</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
          <script type="text/javascript" src="{$JS_URL}/jquery-1.7.2.min.js"></script>

<script type="text/javascript" src="{$JS_URL}/jquery.watermark.js"></script>

<script type="text/javascript" src="{$JS_URL}/jquery-ui-1.9.1.custom.min.js"></script>
<script type="text/javascript" src="{$JS_URL}/jquery.ui.datepicker-ru.js"></script>

<script type="text/javascript" src="/scripts/js/i18n/grid.locale-ru.js"></script>
<script type="text/javascript" src="/scripts/js/jquery.jqGrid.js"></script>
</head>

<body>
  {include file=$BODY_CONTENT_FILE}
  </body>
  </html>
{php} }
elseif(($_SERVER['REQUEST_URI']=='/monitoring/eventsdatagroup/')||($_SERVER['REQUEST_URI']=='/monitoring/eventscompany/')||($_SERVER['REQUEST_URI']=='/monitoring/eventsbylist/')){
  {/php} 
   {include file=$BODY_CONTENT_FILE} {php}
}else{
{/php}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{if $TITLE}TYT24 - {$TITLE}{else}TYT24{/if}</title>
<link rel="stylesheet" type="text/css" media="screen" href="/style/jquery.ui.datepicker.css" />
<link rel="stylesheet" type="text/css" href="{$CSS_URL}/style.css" />

<link rel="stylesheet" type="text/css" href="{$CSS_URL}/jQuery.Tree.css" />
<link rel="stylesheet" type="text/css" href="{$CSS_URL}/screen.css" />
<link rel="stylesheet" type="text/css" href="{$CSS_URL}/jquery-ui-1.9.1.custom.css" />

<!--<link rel="stylesheet" type="text/css" href="{$CSS_URL}/jquery.ui.all.css" />
<link rel="stylesheet" type="text/css" href="{$CSS_URL}/jquery.ui.base.css" />
<link rel="stylesheet" type="text/css" href="{$CSS_URL}/jquery.ui.theme.css" />-->
<!--[if IE]>
 <link rel="stylesheet" type="text/css" href="{$CSS_URL}/style_ie.css" />
<![endif]-->
<!--[if lte IE 7]>
 <link rel="stylesheet" type="text/css" href="{$CSS_URL}/style_ie7.css" />
<![endif]-->

<link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/ui.jqgrid.css" mce_href="/scripts/themes/ui.jqgrid.css" />

<script type="text/javascript" src="{$JS_URL}/jquery-1.7.2.min.js"></script>

<script type="text/javascript" src="{$JS_URL}/jquery.watermark.js"></script>

<script type="text/javascript" src="{$JS_URL}/jquery-ui-1.9.1.custom.min.js"></script>
<script type="text/javascript" src="{$JS_URL}/jquery.ui.datepicker-ru.js"></script>

<script type="text/javascript" src="/scripts/js/i18n/grid.locale-ru.js"></script>
<script type="text/javascript" src="/scripts/js/jquery.jqGrid.js"></script>

{literal}
<script type="text/javascript">
$(document).ready(function(){
	   $('#event_types'+' a').mouseover(function (){
                         $('#event_types'+' a').css('text-decoration','none');
           });

           $("#login").click(function () {
                       if ($("#lg").is(":hidden")) {
                               $("#info").fadeOut("fast",function () {$("#lg").fadeIn()});
                       } else {
                               $("#lg").fadeOut("fast",function () {$("#info").fadeIn()});
                       }
 return false;
});
          $("#cab").click(function () {
                       if ($("#lg").is(":hidden")) {
                               $("#header_note").hide();
                               $("#info").fadeOut("fast",function () {$("#lg").fadeIn()});
                    
                       } else {
                               $("#lg").fadeOut("fast",function () {$("#info").fadeIn()});
                       }
 return false;
});
          $("#info_link").click(function () {
             document.body.removeChild(document.getElementById("ns_tt"));
                       if ($("#lg").is(":hidden")) {
                               $("#info").fadeOut("fast",function () {$("#lg").fadeIn()});
                       } else {
                               $("#lg").fadeOut("fast",function () {$("#header_note").fadeIn();
                               $("#info").fadeIn();});
                       }
 return false;
});
          $("#cab_link").click(function () {
             document.body.removeChild(document.getElementById("ns_tt"));
                       if ($("#lg").is(":hidden")) {
                               $("#header_note").hide();
                               $("#info").fadeOut("fast",function () {$("#lg").fadeIn()});
                    
                       } else {
                               $("#lg").fadeOut("fast",function () {$("#info").fadeIn()});
                       }
 return false;
});
});
</script>
<script type="text/javascript">
var l = 0, t = 0
var IE = document.all?true:false
document.onmousemove = getMouseXY
var ns_tt = document.createElement("div")
function getMouseXY(e) {
	if (IE) {
		l = event.clientX + document.body.scrollLeft
		t = event.clientY + document.body.scrollTop
	}
	else {
		l = e.pageX
		t = e.pageY
	}  
	ns_tt.style.left = l + "px"
	ns_tt.style.top = t + "px"
	return true
}

function AddTT(tt_text){
        
	document.body.appendChild(ns_tt)
	ns_tt.id = "ns_tt"
	ns_tt.innerHTML = tt_text
}

function RemoveTT() {
	document.body.removeChild(document.getElementById("ns_tt"))
}
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-17127328-9']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();



var change_ev;
function change_events(){
	if(change_ev == undefined || change_ev == false){
		$('#event_types'+' span img').attr('src','/images/drill_up_red.jpg');
                $('#event_types'+' a').css({'color':'#FF0000','text-decoration': 'none','font-weight':'bold'});
		change_ev = true;
	}else{
		$('#event_types'+' span img').attr('src','/images/drill_right.jpg');
                $('#event_types'+' a').css({'color':'#2D96FE','text-decoration': 'underline','font-weight':'normal'});
		change_ev = false;
	}
	$('#full_event_types').toggle();
}
</script>

{/literal}

</head>

<body>

<div id="page">
	<!-- header -->
	<div id="header">
		
	
        <div style="float:left; height:100px;">

                <a href="{$SITE_URL}" class="logo"><img src="{$IMG_URL2}/logo.png" title="ТУТ 24" alt="ТУТ 24" /></a>
        </div>
		<!-- <p class="summary"> 
			
                           {getsession name='session' alias=$RequestUrl}
                           {menu name='title_head' }</p> -->
                          {* <div class="list_nav">
				<ul>
         <!--  <span style="color:white; font-size:14px; font-weight:700px; text-decoration: none;"> -->
					<li title='{$pricesOutput[2]}' class="l_nav_2"><a  href="#">ПРЕДПРИЯТИЯ</a></li>
          <li title='{$pricesOutput[7]}' class="l_nav_4"><a  href="#">СТАТИСТИКА</a></li>
					<li class="l_nav_3"><a href="#">ВЫСТАВКИ</a></li>
          <li title='{$pricesOutput[4]}' class="l_nav_5"><a href="#">ТРЕНДЕРЫ</a></li>
          <li class="l_nav_1"><a href="#">АНАЛИЗ</a></li>
				<!-- 	</span> -->
                                        

				</ul>

			</div>*}
                <div class="list_nav">
                  <ul >
                      {menu name='top_menu'  alias=$RequestUrl}
                           
                  </ul>
                </div>
                <div>
                  <ul class="content_menu">
                    {mybreadcrumb alias=$RequestUrl}
                </ul>
              </div>
                <div id="header_note"  {if !$user->isAuthenticated()}style="display:none"{/if}>
              {*  <a title="Инфоцентр" alt="Инфоцентр" href="#" class="cl_h_panel" id="login"></a> *}   

                <div id="info" style="display:none;">
			              <ul>
                       {menu name='note_head'} 

        
			              </ul>
                      <div onmouseover="AddTT('Личный кабинет');" onmouseout="RemoveTT();">  
<div id="cab_link" style="position: absolute; width: 25px; height: 25px; top: 95px; left: 160px; cursor: pointer;" > </div>
</div> 
                 
                  </div>
                  </div>
                    
                         <div id="lg">
                     {include file="your_account_block.tpl"}
                      <div onmouseover="AddTT('Инфоблок');" onmouseout="RemoveTT();">  
                           <div id="info_link"> </div>
                        </div>  
                  
                 </div>

 <div id="promo_left" {if !$user->isAuthenticated()}style="display:none"{/if}>
<ul style="width: 100%;margin:0;">
       <li style="width: 18%;margin-left: -40px;"> <a class="{if CONTROLLER_NAME == 'users' && ACTION_NAME=='profile' || CONTROLLER_NAME == 'monitoring'}active{/if}" href="{$user->getUserPath('profile')}">Сервисы {*<img src="/images/red_ico1.png">*} </a>  </li>
       {if $user->useReport}
             <li> <a title="{info name = 'servicereportinfo' stt = 1}" href="http://www.egrulinfo.ru/?c={$user->hash}" class="{if CONTROLLER_NAME == 'reports'}active {/if}s2 report">ОТЧЕТНОСТЬ </a></li>
        {/if} 
		{if $user->useMonitoring}
             <li> <a title="{info name = 'servicemonitoringinfo' stt = 1}" href="{$MONITORING_LINK}?c={$user->hash}" class="{if CONTROLLER_NAME == 'monitoring'}active {/if}s2 monitoring">МОНИТОРИНГ </a></li>
        {/if}		
               {if $user->useBase}
           <li style="padding: 15px 5px 5px 5px;"> <a title="{info name = 'servicebaseinfo' stt = 1}" href="http://www.b2b-base.ru/?c={$user->hash}" class="{if CONTROLLER_NAME == 'bases'}active {/if}s4 database">БД ПРЕДПРИЯТИЙ </a> </li> 
        {/if}
        {if $user->useSms}
          <li>  <a title="{info name = 'servicesmsinfo' stt = 1}" href="{$SMS_LINK}?c={$user->hash}" class="{if CONTROLLER_NAME == 'sms'}active {/if}s5 sms">РАССЫЛКА SMS </a></li>
        {/if}
</ul>
</div>	

<div id="menu">
</div>
                </div>


	<!-- end header -->

	

	<!-- content -->
	<div id="content">
            <!-- left sidebar -->
                {include file="left.tpl"}
            
            <!--end  left sidebar -->
            <!--main content -->
            <div class="main_content" {if !$user->isAuthenticated()}style="margin-top: 0px;"{/if}>
              

                {include file=$BODY_CONTENT_FILE}
                
            </div>
            <!-- end main content -->

            <!--right sidebar -->
                {include file="right.tpl"}
            <!--end right sidebar -->


            <div style="clear:both"></div>
            <ul class="bottom_nav">
		  {menu name='bottom_menu'}
            </ul>
        </div>
	<!-- end content -->

               
	<!-- footer -->
	<div id="footer">
		{*<p>&copy; 2010 СООО <span style="font-size:12px; font-weight:bold;">"ТУТ24"</span>&nbsp;&nbsp;Правила использования информации</p>
		<p>Телефонный бизнес - справочник Бизнес-Беларусь<br />
		   Телефонные городские справочники Контакт! Минск, Контакт! Регионы</p>*}
                <div><p>{$SITE_COPYRIGHT}</p></div>
                <!--
				<div id="sitemap"><a href="{$SITE_URL}/sitemap/index.html">Карта сайта</a>
				 {foreach from=$sitemap item=item}
                    <a href="{$SITE_URL}/sitemap/{$item}-index.html">{$item}</a>
                 {/foreach}</div>
                 -->
                <div id="sitemap"><a href='{$SITE_URL}/sitemap/map_main.html'>Карта сайта</a>
					<a style='margin: 0px 2px 0px 2px;' href='{$SITE_URL}/sitemap/map_item_a-d.html'>А-Д</a>
					<a style='margin: 0px 2px 0px 2px;' href='{$SITE_URL}/sitemap/map_item_e-i.html'>Е-И</a>
					<a style='margin: 0px 2px 0px 2px;' href='{$SITE_URL}/sitemap/map_item_iy-n.html'>Й-Н</a>
					<a style='margin: 0px 2px 0px 2px;' href='{$SITE_URL}/sitemap/map_item_o-t.html'>О-Т</a>
					<a style='margin: 0px 2px 0px 2px;' href='{$SITE_URL}/sitemap/map_item_u-ch.html'>У-Ч</a>
					<a style='margin: 0px 2px 0px 2px;' href='{$SITE_URL}/sitemap/map_item_sh-znak.html'>Ш-Ь</a>
					<a style='margin: 0px 2px 0px 2px;' href='{$SITE_URL}/sitemap/map_item_ie-ya.html'>Э-Я</a>
				</div>
				
	</div>
</div>


    
</body>

{literal}
<script  type="text/javascript">
$("input#search1").watermark('пример: мебель');
$("input#search2").watermark('пример: Москва');
</script>
{/literal}
</html>
{php} } {/php}



{literal}
<script>
var IsReady = false;
var IsTimerActive = false;
var userid = "";
var BalanceTotal = 0;
var Tarif = 8;

function updatePreview(){
   if(document.getElementById("call_phonenum_txt").value.length >=3){
	getTarif();
	}else{
	document.getElementById("tarif_txt").innerHTML="Введите телефонный номер для звонка или узнайте тариф.";
	}
}


function getTarif(){
	val = $('#call_phonenum_txt').val();
	$.ajax({
		type: "post",
		url: "/telemarket/sip",
		cache: false,
		dataType: 'json',
		data: ({code : val}),
		success: function(data)
		{
			if (data.code != null){
			Tarif = data.price;
			document.getElementById("tarif_txt").innerHTML =data.code+", "+data.name+", "+data.price+" руб/мин";
			//alert(data.code+", "+data.name+", "+data.price+" руб/мин");
			}else{
			//document.getElementById("tarif_txt").innerHTML="";
			
			}
		}						
	});	
}

function getPassSid()
{
	pass = "{/literal}{$pass}{literal}";
	alert(pass);
}
/*функция пересчета баланса*/
function getBalans() {
	/*summa - обязательный параметр -на данный момент оно вводиться в инпут.
	В параметр summa надо передавать сумму, которую нужно отнять от текущего баланса баланса.
	*/
	summa = $('#summary').val();
	/* делаем аякс запрос в sipAction()*/
	$.ajax({
		type: "post",
		url: "/telemarket/sip",
		cache: false,
		dataType: 'json',
		data: ({summa : summa}), // передаем параметр summa
		//принимаем данные которые вернул наш sipAction, в нашем случае это баланс
		success: function(data)
		{
			//вывод баланса
			$('#balans').html(data.balans);
		}						
	});	
}

function StartTimer() {
	function timeOn() {
	
		var sec = 0;
		var min = 0;
		var hour = 0;
		var elem = document.getElementById("timer");
		elem.innerHTML = hour + ":0" + min + ":0" + sec;
		var a = setInterval ( function() {
			sec++;
			if ( sec==60 ) {
				BalanceTotal = BalanceTotal - Tarif;
				getBalans();
				sec = 0;
				min++;
			} else if (min==60) {
				min = 0;
				hour++;
			}
			if ( sec < 10 )  {
				brS = ":0"; // добавить перед секундами 0, если число не двузначное
			} else { brS = ":"} ;
			if ( min < 10 )  {
				brM = ":0"; // добавить перед минутами 0, если число не двузначное
			} else { brM = ":"} ;
	
			if (IsTimerActive) { // остановить работу скрипта, если прошло 2 часа
				//min = 0;
				//sec = 0;
	
				clearInterval(a);
				elem.innerHTML = "";
			}
			elem.innerHTML = hour + brM + min + brS + sec;
		},1000 );
	
	}
	timeOn();
	

};


function CallDisconnected()
{

}
function CallAccepted() 
{ 	IsTimerActive = false;
	BalanceTotal = BalanceTotal - Tarif;
	alert(BalanceTotal);
	getBalans();
	StartTimer();
}
function PhoneInit() 
{
	$('#call_phonenum_txt').bind('keypress', function(){
	        setTimeout(updatePreview, 1);
	    }
	);
        var txtId = document.getElementById("lg");
	var links = txtId.getElementsByTagName("a");
        var partsArray = links[1].href.split('/');
	userid = partsArray[6];
        //alert(userid);

        var txtBal = document.getElementById("account_infoblock");
	var spans = txtBal.getElementsByTagName("span");
        var balArray = spans[0].innerHTML;
        BalanceTotal = "{/literal}{$balans}{literal}";
alert(BalanceTotal);
 
	pass = "{/literal}{$pass}{literal}";
       	red5phone.login_js(userid, userid, pass);

}
function PhoneReady() 
{	
	IsReady = true;
}

function HangUp() 
{	IsTimerActive = true;
	document.getElementById("callhang").src = "/swf/phone_library/call.PNG";
}
function GetPhone(obj) {
          
	if (IsReady){
	if (BalanceTotal > 0){
 	    if ( obj.src.indexOf("/swf/phone_library/call.PNG") != -1){ 
 		red5phone.dial(document.getElementById("call_phonenum_txt").value);
		obj.src = "/swf/phone_library/hangup.png";
		}else{ 
		red5phone.hangup();
		obj.src="/swf/phone_library/call.PNG";
		}
		}
	}
}
function insertText(val){
document.getElementById("call_phonenum_txt").value +=val;
}
</script>
<script src="/swf/phone_library/AC_OETags.js" type="text/javascript"></script>
<link id="module_css" rel="stylesheet" type="text/css" media="screen" href="/swf/phone_library/phone1.css" />
<link id="main_css" rel="stylesheet" type="text/css" href="http://www.comtube.com/get_css.php?lang=ru"> 

<script language="JavaScript" type="text/javascript">
<!--
// -----------------------------------------------------------------------------
// Globals
// Major version of Flash required
var requiredMajorVersion = 9;
// Minor version of Flash required
var requiredMinorVersion = 0;
// Minor version of Flash required
var requiredRevision = 28;
// -----------------------------------------------------------------------------
// -->
</script>
{/literal}
{literal}
<script type="text/javascript">_pset = {"location":{"city_id":"42522"},"action":"home_page_call","uppath":["home_page","home_page_call"],"PATH_TO_ROOT":"http:\/\/www.comtube.com","SECURED_PATH_TO_ROOT":"https:\/\/www.comtube.com","PATH_TO_ROOT_SCRIPT":"http:\/\/www.comtube.com\/index","PATH_TO_MAIN_SITE":"http:\/\/www.comtube.com","USE_MAIN_SITE_AS_BACKEND":false,"PATH_TO_IMG":"http:\/\/www.comtube.com\/res\/images","DEF_AJAX_URL":"http:\/\/www.comtube.com\/backend.php","REQUEST_STRING":"http:\/\/www.comtube.com\/index\/home_page_call","NO_DB_MODE":0,"url_to_auth":"https:\/\/www.comtube.com\/index\/auth_form?from=home_page_call","url_to_loginza":"https:\/\/loginza.ru\/api\/widget?token_url=https%3A%2F%2Fwww.comtube.com%2Findex%2Fhome_page_call&lang=ru","url_to_loginza_js":"https:\/\/loginza.ru\/js\/widget.js","show_loginza":0,"conf":{"flashPhoneFile":"http:\/\/www.comtube.com\/res\/swf\/flexPhone\/flexPhone_old.swf","DEFAULT_CALLME_START_TIME":"10:00","DEFAULT_CALLME_STOP_TIME":"23:00"},"clocks_info":[{"time":"20:15:01","time_sunrise":"06:00:00","time_sunset":"21:00:00","is_night":0,"city_name":"МИНСК","city_id":"42522","utc":"3.00"},{"time":"17:15:01","time_sunrise":"07:01:59","time_sunset":"16:29:12","is_night":1,"city_name":"ЛОНДОН","city_id":0,"utc":"0.00"},{"time":"02:15:01","time_sunrise":"06:07:47","time_sunset":"16:43:48","is_night":1,"city_name":"ТОКИО","city_id":0,"utc":"9.00"},{"time":"21:15:01","time_sunrise":"08:43:24","time_sunset":"17:44:54","is_night":1,"city_name":"МОСКВА","city_id":0,"utc":"4.00"}],"locale_time_arr":{"Y":"2012","m":"10","d":"04","H":"20","i":"15","s":"01"},"tariff_id":"72","tariff_name":"Эконом","calendar_date":{"day_name":"Воскресенье","day_number":" 4","month_name":"Ноябрь"},"server_time":1352049301,"have_auth":0,"incomplete_reg":0,"success_reg":null,"login":null,"comet_uid":null,"cur_id":"2","currency":"$","start_bonus":"0.49999","first_recharge":"0.00001","sip_domain":"sip.comtube.com","domain":"com","support_email":"support@comtube.com","service_brand":"com","FSRED5URL":"rtmp:\/\/comtube.com:1936\/sip","LANGUAGE":"ru","LANG_IDS":{"en":2,"es":3,"he":26,"it":28,"ru":1,"cn":8},"LANG_DESC":{"field_prefix_2":"English","field_prefix_1":"Русский"},"callme_btn_support_code":"PduueiUL2vnNUNtDLVSsIw","callme_btn_test_code":"8i5dU@vK8QOHsgbn@oZpIg","success_page":null,"hide_phone":null,"default_text_values":{"enter_name":"Введите имя","enter_phone":"Введите номер","enter_fax":"Введите номер факса","enter_phone_2":"Укажите номер","time_format":"чч:мм","curr_moment":"сейчас","enter_member":"Введите номер","enter_message":"Введите текст сообщения"},"show_main_notice":0,"debug_level":{"log_js":1,"display_log":0},"is_production":1,"my_location":{"country_id":"31","country_name":"Белоруссия","city_id":"42522","city_name":"Минск"},"curr_balance":null,"current_notice_num":0,"yandex_search_id":1936603,"is_blocked_ip":1,"is_home_page_menu":1,"max_conf_member_cnt":5,"curr_conf_member_cnt":1,"sample_phones":["13479837878"],"no_payments":1,"is_mobile_device":0};
{/literal}
</script><script type="text/javascript" src="http://www.comtube.com/get_js.php?lang=ru"></script><script type="text/javascript" src="http://www.comtube.com/get_js.php?m=home_page&amp;lang=ru"></script><script type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>
<body leftmargin="0" bottommargin="0" topmargin="0" rightmargin="0" marginwidth="0" marginheight="0"><form name="call" onsubmit="return false;">
<div style="padding: 15px 0 0;"><div id="phone_call_input_block" style="height: 45px;">
<div class="phone_input">
<div id="call_phonenum_1_direction" style="height: 15px;"><div class="tariff-info"><span id="tarif_txt" class="tariff-info-txt">Введите телефонный номер для звонка или узнайте тариф.</span></div></div>
<table cellpadding="0" cellspacing="0" style="height: 30px; width: 330px;"><tr>
<td><div class="always_left_to_right div_phone_input" id="input_phone_call_div_1"><table cellpadding="0" cellspacing="0" width="100%"><tr>
<td style="width: 15px;"><span class="input_plus">+</span></td>
<td><input type="text" name="phone_number" style="WIDTH: 200px;" id="call_phonenum_txt" title="Введите номер" autocomplete="off"></td>
</tr></table></div></td>
<td style="width: 25px;" align="center"><div class="icon_elem"><img border="0" width="20px" height="16px" title="Удалить" src="http://www.comtube.com/res/images/erase_grey_20_16.png" style="cursor: pointer;" class="caretBackspace"></div></td>
<td style="width: 25px;" align="center">
<a class="ab-add-to-cont def-position" id="atc_call_phonenum_1" style="display: none;" onclick="common_show_atc_list(event,this,'callback');return false;" href="#" alt="" title=""></a><div class="ab-add-to-cont def-position ab-add-to-cont-disable" id="atc_disable_call_phonenum_1"></div>
</td>
<td style="width: 25px;" align="center"><a id="input_phone_call_a_1" href="#"><div class="icon_elem"><img border="0" width="16px" height="16px" title="Выбрать номер из адресной книги" src="http://www.comtube.com/res/images/frombook.gif" style="cursor: pointer;"></div></a></td>
<td><div class="help_icon" style="padding: 1px 3px;">
<img src="http://www.comtube.com/res/images/ico-help.gif" width="19px" height="19px" border="0" alt="Правила набора номера" title="Правила набора номера" onclick="initMessagePhonesFormat(event, 'Правила набора номера', 'phones_format')"><div id="phones_format" style="display:none;">
<p xmlns:php="http://php.net/xsl"><strong class="monotype">«Код страны» «код города» «номер телефона»</strong><br>(без пробелов и прочих разделителей).<br>Например: <strong class="monotype">13479837878</strong></p>
<p xmlns:php="http://php.net/xsl">Для звонков на телефоны с добавочным номером используйте символы:<ul>
<li>«.» (точка) — пауза 5 сек.</li>
<li>«,» (запятая) — пауза 2 сек.<br>Например: <strong class="monotype">13476302035.100000</strong>
</li>
</ul></p>
<p xmlns:php="http://php.net/xsl">Для звонков на SIP-номера:<ul>
<li>на внутренние SIP-номера — 6-тизначный номер<br>Например: <strong class="monotype">100000</strong>
</li>
<li>на внешние SIP-номера — <strong class="monotype">sip:user_name@sip_domain</strong><br>Например: <strong class="monotype">sip:2883740@sip_domain.com</strong>
</li>
</ul></p>
</div>
</div></td>
</tr></table>
</div>
<div class="phone_input_alternate" style="padding: 0 0 0 15px; font-weight: bold;"></div>
<div class="phone_input_dtmf" style="padding: 10px 0 0 15px; display: none;"><span class="digits" style="font-weight: bold; font-size: 19px; color: green;"></span></div>
</div></div>
<div style="padding: 0 0 0 15px;"><table cellpadding="0" cellspacing="0" width="100%"><tr>
<td width="50%"><table cellpadding="0" cellspacing="0">
<tr><td><table cellpadding="0" cellspacing="0" style="padding: 5px 0;" class="numpad_set">
<tr>
<td><img src="/swf/phone_library/1.png" border="0" onClick="insertText('1')" alt="1"></td>
<td><img src="/swf/phone_library/2.png" border="0" onClick="insertText('2')" value="abc" alt="2"></td>
<td><img src="/swf/phone_library/3.png" border="0" onClick="insertText('3')" value="def" alt="3"></td>
</tr>
<tr>
<td><img src="/swf/phone_library/4.png" border="0" onClick="insertText('4')"  value="ghi" alt="4"></td>
<td><img src="/swf/phone_library/5.png" border="0" onClick="insertText('5')" value="jkl" alt="5"></td>
<td><img src="/swf/phone_library/6.png" border="0" onClick="insertText('6')" value="mno" alt="6"></td>
</tr>
<tr>
<td><img src="/swf/phone_library/7.png" border="0" onClick="insertText('7')" value="pqrs" alt="7"></td>
<td><img src="/swf/phone_library/8.png" border="0" onClick="insertText('8')" value="tuv" alt="8"></td>
<td><img src="/swf/phone_library/9.png" border="0" onClick="insertText('9')" value="wxyz" alt="9"></td>
</tr>
<tr>
<td><img src="/swf/phone_library/ast.png" border="0" onClick="insertText('*')" alt="*"></td>
<td><img src="/swf/phone_library/0.png" border="0" onClick="insertText('0')" alt="0"></td>
<td><img src="/swf/phone_library/rsh.png" border="0" onClick="insertText('#')" alt="#"></td>
</tr>
</table></td></tr>
<tr><td class="numpad_main_btn">
<input type="button" class="send_or_call" id="call_answer_btn" name="call_answer_btn" value="Ответить на звонок!" style="display: none;"><img class="callhang" id="callhang" onclick="GetPhone(this)" src="/swf/phone_library/call.PNG" alt="Позвонить">
<span style="position:absolute; top:1;" id="timer"></span></td></tr>
</table></td>

<td><div class="service_notifier hidden"></div>
<a id="re_tarif" onclick="getTarif();return false;" style="margin:0 3px;" href="#">Вернуть инфу по тарифу в зависимости от введенного кода</a>
<br>
<a id="re_pass_sid" onclick="getPassSid();return false;" style="margin:0 3px;" href="#">Получить пароль для SIP</a>
<br>
<label>Текущий баланс: </label><span id = "balans">{$balans}</span>
<br>
<label>Затраченная сумма</label>

<input id="summary" type="text"></input><a id="get_balans" onclick="getBalans();return false;" style="margin:0 3px;" href="#">Пересчитать баланс</a>
</td>
</tr></table></div>
</form></body>

{literal}

<script language="JavaScript" type="text/javascript">
<!--
// Version check for the Flash Player that has the ability to start Player Product Install (6.0r65)
var hasProductInstall = DetectFlashVer(6, 0, 65);

// Version check based upon the values defined in globals
var hasRequestedVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);

if ( hasProductInstall && !hasRequestedVersion ) {
	// DO NOT MODIFY THE FOLLOWING FOUR LINES
	// Location visited after installation is complete if installation is required
	var MMPlayerType = (isIE == true) ? "ActiveX" : "PlugIn";
	var MMredirectURL = window.location;
    document.title = document.title.slice(0, 47) + " - Flash Player Installation";
    var MMdoctitle = document.title;

	AC_FL_RunContent(
		"src", "/swf/phone_library/playerProductInstall",
		"FlashVars", "MMredirectURL="+MMredirectURL+'&MMplayerType='+MMPlayerType+'&MMdoctitle='+MMdoctitle+"",
		"width", "300",
		"height", "300",
		"align", "middle",
		"id", "red5phone",
		"quality", "high",
		"bgcolor", "#869ca7",
		"name", "red5phone",
		"allowScriptAccess","always",
		"type", "application/x-shockwave-flash",
                "wmode", "transparent",
		"pluginspage", "http://www.adobe.com/go/getflashplayer"
	);
} else if (hasRequestedVersion) {
	// if we've detected an acceptable version
	// embed the Flash Content SWF when all tests are passed
	AC_FL_RunContent(
			"src", "/swf/phone_library/red5phone",
			"width", "300",
			"height", "300",
			"align", "middle",
			"id", "red5phone",
			"quality", "high",
			"bgcolor", "#869ca7",
			"name", "red5phone",
			"allowScriptAccess","always",
			"type", "application/x-shockwave-flash",
			"wmode", "transparent",
			"pluginspage", "http://www.adobe.com/go/getflashplayer"
	);
  } else {  // flash is too old or we can't detect the plugin
    var alternateContent = 'Alternate HTML content should be placed here. '
  	+ 'This content requires the Adobe Flash Player. '
   	+ '<a href=http://www.adobe.com/go/getflash/>Get Flash</a>';
    document.write(alternateContent);  // insert non-flash content
  }
// --> 

</script>
<noscript>
  	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
			id="red5phone" width="117" height="30"
			codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
			<param name="movie" value="/swf/phone_library/red5phone.swf" />
			<param name="quality" value="high" />
			<param name="bgcolor" value="#869ca7" />
			<param name="allowScriptAccess" value="always" />
			<embed src="/swf/phone_library/red5phone.swf" quality="high" bgcolor="#869ca7"
				width="1" height="1" name="red5phone" align="middle"
				play="true"
				loop="false"
				quality="high"
				allowScriptAccess="always"
				type="application/x-shockwave-flash"
				wmode="transparent"
				pluginspage="http://www.adobe.com/go/getflashplayer">
			</embed>
	</object>
</noscript>
{/literal}
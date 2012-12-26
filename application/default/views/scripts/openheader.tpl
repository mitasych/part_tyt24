<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="{if $KEYWORDS}{$KEYWORDS}{else}{/if}" />
        <meta name="description" content="{if $DESCRIPTION}{$DESCRIPTION}{else}{/if}" />
        <link rel="icon" href="{$SITE_URL}/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="{$SITE_URL}/favicon.ico" type="image/x-icon" />

        <script src="/scripts/jquery.js" type="text/javascript"></script>
        
        <style type="text/css">
            @import url({$CSS_URL}/reset.css);
            @import url({$CSS_URL}/style.css);
            @import url({$CSS_URL}/content3.css);
        {literal}


            #jsddm
            {	margin: 0;
              padding: 0;
            position: absolute;
            margin-top:-21px;}

            #jsddm li
            {	float: left;
              list-style: none;
              font: 11px Tahoma, Arial;
              margin: 0;
              padding: 0;
              background:none;
            }

            #jsddm li a
            {	display: block;
              background: #20548E;
              padding: 5px 12px;
              text-decoration: none;
              border-right: 1px solid white;
              /*width: 70px;*/
              color: #EAFFED;
              white-space: nowrap}

            #jsddm li a:hover
            {	background: #1A4473}

            #jsddm li ul
            {	margin: 0;
              padding: 0;
              position: absolute;
              visibility: hidden;
              border-top: 1px solid white;
              background:none;
              margin-top:-50px;
              margin-left:-250px;

            }

            #jsddm li ul li
            {	float: none;
              display: inline;float: left;
            }

            #jsddm li ul li a
            {	width: auto;
              background: #9F1B1B}

            #jsddm li ul li a:hover
            {	background: #7F1616}

        </style>
        <script type="text/javascript">

            var timeout    = 500;
            var closetimer = 0;
            var ddmenuitem = 0;

            function jsddm_open()
            {  jsddm_canceltimer();
               jsddm_close();
               ddmenuitem = $(this).find('ul').css('visibility', 'visible');}

            function jsddm_close()
            {  if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');}

            function jsddm_timer()
            {  closetimer = window.setTimeout(jsddm_close, timeout);}

            function jsddm_canceltimer()
            {  if(closetimer)
               {  window.clearTimeout(closetimer);
                  closetimer = null;}}

            $(document).ready(function()
            {  $('#jsddm > li').bind('mouseover', jsddm_open)
               $('#jsddm > li').bind('mouseout',  jsddm_timer)});

            document.onclick = jsddm_close;

        </script>
        <script type="text/javascript">
        function getBrowserInfo() {
            var t,v = undefined;

            if (window.chrome) t = 'Chrome';
            else if (window.opera) t = 'Opera';
            else if (document.all) {
                t = 'IE';
                var nv = navigator.appVersion;
                var s = nv.indexOf('MSIE')+5;
                v = nv.substring(s,s+1);
            }
            else if (navigator.appName) t = 'Netscape';

            return {type:t,version:v};
        }

        function bookmark(a){
            var url = window.document.location;
            var title = window.document.title;
            var b = getBrowserInfo();

            if (b.type == 'IE' && 8 >= b.version && b.version >= 4) window.external.AddFavorite(url,title);
            else if (b.type == 'Opera') {
                a.href = url;
                a.rel = "sidebar";
                a.title = url+','+title;
                return true;
            }
            else if (b.type == "Netscape") window.sidebar.addPanel(title,url,"");
            else alert("Нажмите CTRL-D, чтобы добавить страницу в закладки.");
            return false;
        }
    </script>
        {/literal}
        <title>{if $TITLE}{$TITLE}{else}B2B-help{/if}</title>
    </head>

    <body>

        <table cellspacing="0" cellpadding="0" border="0" width="100%" bgcolor="#FFFFFF">
            <tbody>
                <tr>
                    <td width="20">&nbsp;</td>
                    <td align="left" width="258" colspan="2"><a href="{$SITE_URL}" target="_parent"><img border="0" alt="ВЭД-эксперт" src="/images/logotype.jpg"></a></td>
                    <td>
                        <div align="right" style="color: rgb(0, 0, 153); margin-top: 5px; margin-bottom: 0px; vertical-align: bottom;" class="copyright">
                            <p style="margin: 3px; padding: 0px; color:#000000">
                                Вы перешли на эту страницу по ссылке с сайта {$SITE_NAME}. Мы не несем ответственности за размещенную на этой странице информацию.
                            
                                <a target="_parent" href="{$burl}"><b style="color:#FE0000;">Вернуться на сайт</b></a>
                                <br /> <br />
                                <a href="javascript:void(0);" onclick="return bookmark(this);">Добавить в избранное</a>
                            </p>
                        </div>
                        {menu name="main_menu" external=1}
                    </td>

                    <td width="20">&nbsp;</td>
                </tr>

                <tr>
                    <td align="right" valign="top" colspan="6" height="10" bgcolor="#FE0000">

                    </td>
                </tr>



            </tbody>
        </table>


    </body>
</html>
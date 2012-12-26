<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="{if $KEYWORDS}{$KEYWORDS}{else}{/if}" />
        <meta name="description" content="{if $DESCRIPTION}{$DESCRIPTION}{else}{/if}" />
        <title>{if $TITLE}ВЭД – эксперт: {$TITLE}{else}ВЭД – эксперт{/if}</title>
    </head>
    <frameset rows="60,*" frameborder="no" border="0" framespacing="0">
        <frame src="/info/openheader?burl={$burl}" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
        <frame src="{$ourl}" name="mainFrame" id="mainFrame" title="mainFrame" />
    </frameset>

    <noframes><body>
            {literal}
            <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-17127328-6']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

            </script>
            {/literal}
        </body>
    </noframes>
</html>
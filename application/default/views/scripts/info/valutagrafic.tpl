
            
            

<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
    <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
    </div>
    <div>
        <div class="main_top_text">

{breadcrumb controller="info" alias="valutagrafic" title=$currentInfo->getTitle() altTitle="График валют"}


            
            
<h1>{info name="valutagrafic" what="title"}</h1>

<p>{info name="valutagrafic"}</p>
<br /><br />

<div align="center">
<OBJECT classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0" WIDTH="580" HEIGHT="470" id="charts" align="middle"/>
<PARAM NAME="movie" VALUE="{$SITE_URL}/swf/charts.swf"/>
<PARAM NAME="quality" VALUE="high"/>
<PARAM NAME="bgcolor" VALUE="#CDCCCC"/>
<param name="allowScriptAccess" value="always"/>
<param name="loop" value="false"/>
<param name="scale" value="noscale"/>
<param name="salign" value="TL"/>
<param name="wmode" value="opaque"/>
<param name="FlashVars" value="library_path={$SITE_URL}/swf/charts_library&xml_source={$SITE_URL}/info/valutagraficdata/"/>
<EMBED src="{$SITE_URL}/swf/charts.swf" FlashVars="library_path={$SITE_URL}/swf/charts_library&xml_source={$SITE_URL}/info/valutagraficdata/" quality="high" bgcolor="#CDCCCC" WIDTH="580" HEIGHT="470" NAME="charts" allowScriptAccess="always" swLiveConnect="true" loop="false" scale="noscale" salign="TL" align="middle" wmode="opaque" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
</OBJECT>
</div>


 <div class="dotted2"></div>
        </div>
    </div>
</div>
{literal}
<style>
    .rassst td {font-size:12px;}
</style>

<div style="font-size:1em" class="rassst">
    <script src="/scripts/cities.js.php"></script>
    <script>
            function setCity1(id)
            {
                    if(typeof(CitiesArr[id])!='undefined')
                    {
                            var city_select=document.getElementById('city1');
                            city_select.options.length=CitiesArr[id].length;
                            city_select.options[0].value='0';
                            city_select.options[0].text='--Выберите город--';
                            for(var i=1;i<CitiesArr[id].length;i++)
                            {
                    city_select.options[i].value=CitiesArr[id][i][0];
                    city_select.options[i].text=CitiesArr[id][i][1];
                            }
                    }
            }
    </script>
    <script>
            function setCity2(id)
            {
                    if(typeof(CitiesArr[id])!='undefined')
                    {
                            var city_select=document.getElementById('city2');
                            city_select.options.length=CitiesArr[id].length;
                            city_select.options[0].value='0';
                            city_select.options[0].text='--Выберите город--';
                            for(var i=1;i<CitiesArr[id].length;i++)
                            {
                    city_select.options[i].value=CitiesArr[id][i][0];
                    city_select.options[i].text=CitiesArr[id][i][1];
                            }
                    }
            }
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

    <div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
         <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
    </div>
    <div>
        <div class="main_top_text">



            {breadcrumb controller="info" alias="rasst" title=$currentInfo->getTitle() altTitle="Расчет расстояний"}


            <h1>{info name="rasst" what="title"}</h1>

            <p>{info name="rasst"}</p>

            {$mycontent}
            <br /><br />

            <div class="dotted2"></div>
        </div>
    </div>
</div>

</div>
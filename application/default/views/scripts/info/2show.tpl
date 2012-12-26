<!-- search box -->
{literal}

<script type="text/javascript">
$(document).ready(function(){
    $("#tree").Tree();
	$("#tree2").Tree();
    $(".btn-slide").click(function(){
        $("#panel").slideToggle("slow");
        $(this).toggleClass("active"); return false;
    });

 //   $(".region").click(function(){

       // $(this).parent().(input:checkbox).checked = !checked;
 //   });

    var input = $(".FO :checkbox");
  //  $("#count").text("регионов: "+ input.length).css("color", "red");



});
</script>
{/literal}

	<div id="search_box">
			<div class="stickers">
                     {mybreadcrumb controller="articles" alias=$currentInfo->getRewriteName()  }
                        </div>
		<form id="search">
			<div class="search_links">
				<ul class="sl_left">
                           		<li><input type="radio" class="name" name="NameOrPhone" checked="yes" id="name"><label for='name'>наименование</label></li>
					<li><input type="radio" class="name" name="NameOrPhone"  id="phone"><label for='phone'>телефон</label></li>
					<li class="br_li">
                                                <a href="/" class="btn-slide">выбрать отрасль</a>
					<!--	<ul id="brunch_submenu"> -->
                                            

					<!--	</ul>  -->
					</li>
				</ul>
				<ul class="sl_right">
					<li class="co_li"><a href="#">выбрать страну</a>
						<ul id="country_submenu">
							<ul><li style="float:left"><a href="" >сорт А-Я</a></li><li ><a href="" >сорт регони</a></li></ul>
                                                        <ul>
                                                        <li>
                                                        <input type="checkbox" name="otr" value="otr1">
                                                        <a href="#">отрасль 1</a>
                                                        </li>
                                                        <li>
                                                        <li><input type="checkbox" class="otr" name="NameOrPhone" checked="yes" id="name"><label for='name'>отрасль1</label></li></li>
                                              
                                                        </ul>
						</ul>
					</li>
					<li class="re_li"><a href="#">выбрать регион</a>
						<ul id="region_submenu" style="right:0px">
							  <ul id="tree2">
                                    

                                    {foreach name=outer from=$subregions item=item}
                                    <li>
					<label>
					    <input type="checkbox">{$item.name}
                                        </label>
                                        <ul>

								{foreach name=sub from=$item.subitems item=subitem}
                                                                <li>
                                                        		<label>

                                                                                        <input type="checkbox" name="test" >{$subitem}
										<!--	<a href="/region/id/sub/id/={$subitem.id}" >{$subitem}</a> -->
                                                                	</label>
                                                                </li>

                                                                                         

											
								{/foreach}
                                         </ul>
                                    </li>
                                    {/foreach}
                                </ul>
				</ul>
			</div>
                                                    <div id="panel" style="height:auto;">
       							<!--<ul><li style="float:left"><a href="" >сорт А-Я</a></li><li ><a href="" >сорт регони</a></li></ul>
                                                        <ul>
                                                        <li>
                                               		<li><input type="checkbox" class="otr" name="NameOrPhone" checked="yes" id="name"><label for='name'>отрасль1</label></li>
                                                        </li>
                                                        <li>
                                                        <input type="checkbox" name="otr" value="otr1">
                                                        <a href="#">отрасль 1</a>
                                                        </li>
                                                        <li>
                                                        <input type="checkbox" name="otr" value="otr1">
                                                        <a href="#">отрасль 1</a>
                                                        </li>
                                                        
                                                        </ul>-->

                                <ul id="tree">
                                    

                                    {foreach name=outer from=$subregions item=item}
                                    <li>
					<label>
					    <input type="checkbox">{$item.name}
                                        </label>
                                        <ul>

								{foreach name=sub from=$item.subitems item=subitem}
                                                                <li>
                                                        		<label>

                                                                                        <input type="checkbox" name="test" >{$subitem}
										<!--	<a href="/region/id/sub/id/={$subitem.id}" >{$subitem}</a> -->
                                                                	</label>
                                                                </li>

                                                                                         

											
								{/foreach}
                                         </ul>
                                    </li>
                                    {/foreach}
                                </ul>
                                <div class="clear" style="position:relative; clear:both;" >
                                </div>
			</div>
	
			<div id="form_search">
				<input type="text" id="search1" class="search_text" value="" />
				<input type="text" id="search2" class="search_text" />
				<input type="button" class="search_btn" value="" />
			</div>
		</form>
	</div>
	<!-- end search box -->
<div class="main_top_text{if $currentInfo->getSubmenu()->getIsRed()} red{/if}">
<!-- news   -->
{if isset($news)}
<div class="news" style="float:right;width:25%">
					<h1>новости</h1>
					<ul>
                                                {foreach from=$news item=current}
						<li>
                                                    <p class="news_title">

                                                       {if !$current->getHideDate()}<span class="date">
                                                         {$current->getCreateDate()|rudate}
                                                       {/if}



                                                     </p>
                                                 <a href="{$SITE_URL}/news/{if $current->getRewriteName()}{$current->getRewriteName()}{else}{$current->getId()}{/if}/">
                                                         {$current->getContentTruncated85()|escape:html}
                                                    </a>
                                                </li>
						{/foreach}
					</ul>
				</td>
</div>
{/if}
<!-- end News -->
   <!-- {breadcrumb controller="articles" alias=$currentInfo->getRewriteName()} -->
    <div class="stickers">  {mysecondbreadcrumb controller="articles"}</div> 
    <h1>{$currentInfo->getTitle()|escape:html}</h1>
    {if $currentInfo->getSubmenu()->image}
    <div class="pr_right_bg" style="float: right; margin-left:8px;margin-bottom:3px;">
        <img src="{$SITE_URL}/upload/menu_sub/{$currentInfo->getSubmenu()->image}" alt="" title=""  />
    </div>
    {/if}
    {$currentInfo->getContentSwitch()}
    <div class="dotted2"></div>
</div>

{literal}
<!--
<script type="text/javascript">
    $(function () {
        $("h2").click(function () {
             if ($(this).hasClass('collapsed')) {
                 $(this).removeClass('collapsed')
             } else {
                 $(this).addClass('collapsed')
             }
             $(this).next('.pre-swithed-h2').next('.swithed-h2').toggle();
        });

        function tt(n){
            if (n==1) {
                $("h2.collapsed a").parent().css({"background-image": 'url("/images/bg_h2.jpg")'});
                setTimeout(function(){tt(0);}, 300);
            } else {
                $("h2.collapsed a").parent().css({"background-image": 'none'});
                setTimeout(function(){tt(1);}, 300);
            }
            
        }
        setTimeout(function(){tt(0);}, 300);
    });
</script> -->
{/literal}
{*$("h2.collapsed a").css({"color": "#000000"}*}
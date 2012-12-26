{literal}
<script type="text/javascript">
$(document).ready(function(){
           $("#okved_all").click(function () {
                       if ($("#open_okved_all").is(":hidden")) {
                               $("#open_okved_all").toggle();

                               $("#okved_all").html( "Спрятать всё &gt;&gt;&gt;" );
                       } else {
                               $("#open_okved_all").toggle();
                                $("#okved_all").html( "Показать всё &gt;&gt;&gt;" );
                       }
 return false;
});


           $("#okato_all").click(function () {
                       if ($("#open_okato_all").is(":hidden")) {
                               $("#open_okato_all").toggle();

                               $("#okato_all").html( "Спрятать всё &gt;&gt;&gt;" );
                       } else {
                               $("#open_okato_all").toggle();
                                $("#okato_all").html( "Показать всё &gt;&gt;&gt;" );
                       }
 return false;
});


});
</script>
{/literal}

<div class="left_sidebar">
			<div class="left_p_box">
                        <a style="text-decoration:none;" href="{$SITE_URL}/list/index/what/{$what}/where//okved//okato/{$okato}/">
        		<h2 class="blue category">Рубрики: <div class="category_ico"></div></h2></a>
			   <div class="okved_top">
                               <ul>
                                  {foreach name="okved" from=$okved_count item=item}
                                     <li><a href="{$SITE_URL}/list/index/what/{$what}/where//okved/{$item.id}/okato/{$okato}/">{$item.name}</a> {$item.count|number_format:0:".":" "}</li>
                                     {if $smarty.foreach.okved.iteration == 4}
                               </ul>
                           </div>
                           <div id="open_okved_all" style="display:none" >
                               <ul>
                                      {/if}
                                   {/foreach}
                               </ul>
                               </div>
					{if count($okved_count)>3}
                           
                               <ul>
                                    <li class="last"><a id="okved_all"  href="#">Показать все &gt;&gt;&gt;</a></li>
                               </ul>
                                       {/if}
                        </div>
			  
			
      
			<div class="left_p_box">
                        <a style="text-decoration:none;" href="{$SITE_URL}/list/index/what/{$what}/where//okved/{$okved}/okato//">
        		<h2 class="red region">Регионы: <div class="category_ico"></div></h2></a>
			   <div class="okato_top">
                              <ul>
      				   {foreach name="okato" from=$okato_count item=item}
                                      <li><a href="{$SITE_URL}/list/index/what/{$what}/where//okved/{$okved}/okato/{$item.id}/">{$item.name}</a> {$item.count|number_format:0:".":" "}</li>
                                      {if $smarty.foreach.okato.iteration == 4}
                              </ul>
                           </div>
                           <div id="open_okato_all" style="display:none" >
                              <ul>
                                      {/if}
                                   {/foreach}
                              </ul>
                              </div>
					{if count($okato_count)>3}
                              <ul>
                                <li class="last_red"><a id="okato_all"  href="#">Показать все &gt;&gt;&gt;</a></li>
                             </ul>
                                        {/if}
		
                        </div>
		{*	<div class="left_p_box">
        		<h2 class="grey tenders">Тендеры: <div class="category_ico"></div></h2>
				<ul>
					<li><a href="#">Товары</a> 3 346</li>
					<li><a href="#">Промышленность</a> 855</li>
					<li><a href="#">Строительство</a> 414</li>
					<li><a href="#">Транспорт и логистика</a> 183</li>
					<li class="last"><a href="#">Показать все &gt;&gt;&gt;</a></li>
				</ul>
				<a href="#"></a>
        	</div>
			<div class="left_p_box">
        		<h2 class="grey markets">Рынки: <div class="category_ico"></div></h2>
				<ul>
					<li><a href="#">Товары</a> 3 346</li>
					<li><a href="#">Промышленность</a> 855</li>
					<li><a href="#">Строительство</a> 414</li>
					<li><a href="#">Транспорт и логистика</a> 183</li>
					<li class="last_red"><a href="#">Показать все &gt;&gt;&gt;</a></li>
				</ul>
				<a href="#"></a>
        	</div>
			<div class="left_p_box">
        		<h2 class="grey exhibition">Выставки: <div class="category_ico"></div></h2>
				<ul>
					<li><a href="#">Товары</a> 3 346</li>
					<li><a href="#">Промышленность</a> 855</li>
					<li><a href="#">Строительство</a> 414</li>
					<li><a href="#">Транспорт и логистика</a> 183</li>
					<li class="last"><a href="#">Показать все &gt;&gt;&gt;</a></li>
				</ul>
				<a href="#"></a>
        	</div>
			<div class="left_p_box">
        		<h2 class="grey books">Книги:<div class="category_ico"></div></h2>
				<ul>
					<li><a href="#">Товары</a> 3 346</li>
					<li><a href="#">Промышленность</a> 855</li>
					<li><a href="#">Строительство</a> 414</li>
					<li><a href="#">Транспорт и логистика</a> 183</li>
					<li class="last_red"><a href="#">Показать все &gt;&gt;&gt;</a></li>
				</ul>
				<a href="#"></a>
        	</div>*}
</div>
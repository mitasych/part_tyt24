<!-- search box -->

<div id="search_box">
		
    {form from=$search_form id="search"}
			<div id="form_search">
                           <div class="form_search_left">
                             <div id="search_input_left" >
							       
                                    <input name="what" type="text" id="search1" class="search_text" value="" />
 				 </div>
                           </div>
                           <div class="form_search_right">
					     <div id="search_enter"> 
				<input type="submit"  value="" /> 
				</div>
				<div id="search_input_right">
                                    <input name="where" type="text" id="search2" class="search_text2" value="" />
                                    <input type="hidden" class="" value="{$okved}" name="okved" />
                                    <input type="hidden" class="" value="{$okato}" name="okato" />
                                     
				</div>
                           </div>
                         </div>
    {/form}
</div>
	<!-- end search box -->

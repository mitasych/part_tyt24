<script type="text/javascript" language="javascript">
<!--
    var filter_fields = new Array();
    {foreach from=$LISTER->getFilters() item=current}
    	filter_fields[filter_fields.length] = '{$current->field}';
	{/foreach}
   
   	var param_script = '{$LISTER->PARAM_SCRIPT}';
       //----------------------------------------------------------------------------------------
    {literal}
	
	//function field_Obj(name,type){
    //    this.name = name
     //   this.type = type
    //}
	
    //----------------------------------------------------------------------------------------
    function highlightColumn(is_on, row, col) {return
		if (is_on == 1) {var tmp_color='#ecece5';} else { var tmp_color=''; }
		
		var irow = 0;
		while (document.getElementById('r_'+irow+'c_'+col)) {
			if (irow != row) {
				document.getElementById('r_'+irow+'c_'+col).style.backgroundColor = tmp_color;
			}
			irow++;
		}	
	
	}
	//----------------------------------------------------------------------------------------
	function select_all(){
        if (document.content_form.elements['checkall'].checked == true){
            for(var i=0;i<document.content_form.length;i++){
                if (document.content_form.elements[i].type == 'checkbox'){
                    document.content_form.elements[i].checked = true
                }
            }
        }
        else{
            for(var i=0;i<document.content_form.length;i++){
                if (document.content_form.elements[i].type == 'checkbox'){
                    document.content_form.elements[i].checked = false
                }
            }
        }
    }
	//---------------------------------------------------------------------------------------
	// SORTING FILTERING
	//---------------------------------------------------------------------------------------
	function showSorting() {
		if (document.getElementById('sorting_table_0')) document.getElementById('sorting_table_0').style.display = "none";
		if (document.getElementById('filtering_table_1')) document.getElementById('filtering_table_1').style.display = "none";
		if (document.getElementById('sorting_table_1')) document.getElementById('sorting_table_1').style.display = "block";
		if (document.getElementById('filtering_table_0')) document.getElementById('filtering_table_0').style.display = "block";
	}
	function showFiltering() {
		if (document.getElementById('filtering_table_0')) document.getElementById('filtering_table_0').style.display = "none";
		if (document.getElementById('sorting_table_1')) document.getElementById('sorting_table_1').style.display = "none";
		if (document.getElementById('filtering_table_1')) document.getElementById('filtering_table_1').style.display = "block";
		if (document.getElementById('sorting_table_0')) document.getElementById('sorting_table_0').style.display = "block";
	}
    //---------------------------------------------------------------------------------------
	// FILTER
	//---------------------------------------------------------------------------------------
	function change_filter_field(){
		for (var i=0; i<filter_fields.length; i++) {
			if (document.getElementById('filter_field').options[document.getElementById('filter_field').selectedIndex].value == filter_fields[i]) {
				document.getElementById('filter_'+filter_fields[i]+'_variants').style.visibility = 'visible';	
			} else {
				document.getElementById('filter_'+filter_fields[i]+'_variants').style.visibility = 'hidden';
			}
		}
	}
	
	function applyFilter() {
		var field = document.getElementById('filter_field').options[document.getElementById('filter_field').selectedIndex].value;
		//var value = document.getElementById('filter_'+field+'_variants').options[document.getElementById('filter_'+field+'_variants').selectedIndex].value
		if (document.getElementById('filter_'+field+'_variants').options) {
			var value = document.getElementById('filter_'+field+'_variants').options[document.getElementById('filter_'+field+'_variants').selectedIndex].value;
		} else {
			var value = document.getElementById('filter_'+field+'_variants').value;
		}

		location.href = param_script+'filterfield/'+field+'/filtervalue/'+value+'/';
	}
	
    function showFilter() {
		document.getElementById('emptyFilter').style.display = "none";
		document.getElementById('nonEmptyFilter').style.display = "block";
	}
	function hideFilter() {
		document.getElementById('emptyFilter').style.display = "block";
		document.getElementById('nonEmptyFilter').style.display = "none";
	}
    //------------------------------------------------------------------------------------------
    function ValidForm(){
        if (document.content_form["RADIO_ELEMENTS"]){
            var fl_c = false;
            if (!document.content_form["RADIO_ELEMENTS"].length){
                if (document.content_form["RADIO_ELEMENTS"].checked == true){
                    fl_c = true;
                }
            }else{
                for (var i=0; i < document.content_form["RADIO_ELEMENTS"].length; i++){
                    if (document.content_form["RADIO_ELEMENTS"][i].checked == true){
                        fl_c = true;
                    }
                }
            }
            if (fl_c == false){
                alert('Пожалуйста, выберите элементы для этой операции!')
                return false;
            }

        }else{
            $ch_flag = 0;
            for(var i=0;i<document.content_form.length;i++){
                if (document.content_form.elements[i].type == 'checkbox'){
                    if (document.content_form.elements[i].checked == true){
                        $ch_flag = 1;
                    }
                }
            }
            if ($ch_flag == 0){
                alert('Пожалуйста, выберите элементы для этой операции!')
                return false;
            }
        }
        return true;
    }
	{/literal}
-->
</script>

 <!-- FILTER -->   
 <tr>
 	<td>
    	<div class="alllayers">
        	
            
            
            <table class="layer" id="sorting_table_0">
                <tr>
                    <td class="layerLeft"></td>
                    <td class="layerCenter"><a href="#" onclick="showSorting();return false;">Сортировка</a></td>
                    <td class="layerRight"></td>
                </tr>
            </table>
            <table class="layer" id="sorting_table_1" style="display:none">
                <tr>
                    <td class="layerLeft"></td>
                    <td class="layerCenter">
                    	<h6>Сортировка</h6>
                    	<p>поле:
                      	<select name="sort_order_selector" id="sort_order_selector" class="selOne">
                        	{foreach from=$LISTER->getFields() item=field name=fields}
                    			{if $field->getSORTING()}
                            		<option value="order/{$field->getSQL_FIELD()}" {if $LISTER->getSortOrder() == $field->getSQL_FIELD()} selected="selected"{/if}>{$field->getTEXT_LABEL()}</option>
                                {/if}
                            {/foreach}
                      	</select>
                      	сортировать по:
                      	<select name="sort_direction_selector" id="sort_direction_selector" class="selTwo">
                        	<option value="/dir/ASC/" {if $LISTER->getSortDirection() == 'ASC'} selected="selected"{/if}>Возрастанию</option>
                            <option value="/dir/DESC/" {if $LISTER->getSortDirection() == 'DESC'} selected="selected"{/if}>Убыванию</option>
                      	</select>
                      	
                        <a href="#" onclick="location.href='{$LISTER->PARAM_SCRIPT}'+document.getElementById('sort_order_selector').options[document.getElementById('sort_order_selector').selectedIndex].value+document.getElementById('sort_direction_selector').options[document.getElementById('sort_direction_selector').selectedIndex].value" style="margin:0 10px">применить</a></p></td>
                  	<td class="layerRight"></td>
                </tr>
            </table>
              
            
            
            
            {if $LISTER->getFilters() && $LISTER->noRenderFilters == 0}
            <table class="layer" id="filtering_table_0" style="display:{if $LISTER->filterEnabled}none{else}block{/if};">
                <tr>
                    <td class="layerLeft"></td>
                    <td class="layerCenter"><a href="#" onclick="showFiltering();return false;">Фильтр</a></td>
                    <td class="layerRight"></td>
                </tr>
            </table>
            <table class="layer" id="filtering_table_1" style="display:{if $LISTER->filterEnabled}block{else}none{/if};">
                <tr>
                    <td class="layerLeft"></td>
                    <td class="layerCenter">
                    	<h6>Фильтр</h6>
                    	<p>поле:
                      	<select class="selOne" onchange="change_filter_field();" id="filter_field">
                            {foreach from=$LISTER->getFilters() item=current}
                                <option value="{$current->field}" {if $current->field == $LISTER->currentFilterField}selected{/if}>{if $current->label}{$current->label}{else}{$current->field}{/if}</option>
                            {/foreach}
                        </select>
                      	показать:
                       
                       
                       
                                    
                                    
                      	{foreach from=$LISTER->getFilters() item=current name=filt}
                            {if $current->type == "select"}
                                
                                    <select class="selTwo" style="visibility:{if $current->field == $LISTER->currentFilterField || (!$LISTER->currentFilterField && $smarty.foreach.filt.first		) }visible{else}hidden{/if};" id="filter_{$current->field}_variants">
                                    {foreach from=$current->variants item=_variant}
                                        <option value="{$_variant.value}" {if $_variant.value == $LISTER->currentFilterValue}selected="selected"{/if}>{$_variant.label}</option>
                                    {/foreach}
                                    </select>
                               
                            {else if $current->type == "text"}
                                <input type="text" value="{$current->variant}" class="input" style="display:{if $current->field == $LISTER->currentFilterField || (!$LISTER->currentFilterField && $smarty.foreach.filt.first		) }block{else}none{/if};" id="filter_{$current->field}_variants" />
                            {/if}
                        {/foreach}
                      	
                        <a href="#" onclick="applyFilter();" style="margin:0 10px">применить</a>
                        <a href="{$LISTER->PARAM_SCRIPT}filterreset/1/" style="margin:0 10px">удалить</a>
                        
                        </p></td>
                  	<td class="layerRight"></td>
                </tr>
            </table>
            {/if}
            
    
            
            
             <!-- TOP LINKS	-->
                {if $LISTER->getTopLinks()}
                    {foreach from=$LISTER->getTopLinks() item=toplink name=tlhash}
                         <table class="layer">
                            <tr>
                                <td class="layerLeft"></td>
                                <td class="layerCenter"><a href="{$toplink->getLINK_HREF()}"{if $toplink->getLINK_CLASS()} class="{$toplink->getLINK_CLASS()}"{/if}{if $toplink->getLINK_STYLE()} style="{$toplink->getLINK_CLASS()}"{/if}{if $toplink->getLINK_EVENT()} {$toplink->getLINK_EVENT()}{/if}{if $toplink->getLINK_TARGET()} target="{$toplink->getLINK_TARGET()}"{/if}>{if $toplink->getTEXT_COLOR()}<font color="{$toplink->getTEXT_COLOR()}">{/if}{if $toplink->getTEXT_STRONG()}<b>{/if}{$toplink->getTEXT_LABEL()}{if $toplink->getTEXT_STRONG()}</b>{/if}{if $toplink->getTEXT_COLOR()}</font>{/if}</a></td>
                                <td class="layerRight"></td>
                            </tr>
                        </table>                                       
                    {/foreach}
                {/if}
            <!--	TOP LINKS	-->
            
        </div>    
    </td>
</tr>
<!-- /FILTER -->       
    






<!-- CONTENT TABLE	-->
<tr>
	<td class="allcontent">
    	<form name="content_form" action="{$PARAM_SCRIPT}" method="post" >
	
			<table>
            	<tr>
                	<td class="tableTop">&nbsp;</td>
                    {assign var=c_row value=0}
                    
                    {if $LISTER->PARAM_EL_CHECKBOX && $LISTER->getButtons() && $LISTER->getPrimaryField()}
                    {assign var=c_row value=$c_row+1}
                    <td class="tableTopNext" id="r_0c_{$c_row}" 
                                        {*onmouseover="this.style.backgroundColor='#FFF'; highlightColumn(1,0,{$c_row});" onmouseout="this.style.backgroundColor='';highlightColumn(0,0,{$c_row});"*}><input type="checkbox" name="checkall" value="1" onClick="select_all()" class="checkbox"></td>
                    {/if}
                    
                    {if $LISTER->PARAM_EL_SORTING && $LISTER->getButtons()  && $LISTER->getPrimaryField() && $LISTER->getSortingField()}
                    {assign var=c_row value=$c_row+1}
                    <td class="tableTopNext" id="r_0c_{$c_row}" 
                                        {*onmouseover="this.style.backgroundColor='#FFF'; highlightColumn(1,0,{$c_row});" onmouseout="this.style.backgroundColor='';highlightColumn(0,0,{$c_row});"*}>Сорт.</td>
                    {/if}
				                
                   <!-- TITLE HASH -->
                    {foreach from=$LISTER->getFields() item=field name=fields}
                    
                    <td id="r_0c_{$smarty.foreach.fields.iteration+$c_row}" 
                                        {*onmouseover="this.style.backgroundColor='#FFF'; highlightColumn(1,0,{$smarty.foreach.fields.iteration+$c_row});" onmouseout="this.style.backgroundColor='';highlightColumn(0,0,{$smarty.foreach.fields.iteration+$c_row});"*} class="{if ($LISTER->PARAM_EL_CHECKBOX && $LISTER->getButtons() && $LISTER->getPrimaryField()) || ($LISTER->PARAM_EL_SORTING && $LISTER->getButtons()  && $LISTER->getPrimaryField() && $LISTER->getSortingField()) }tableTopNext{else}tableTop{/if}" nowrap>
                        
                        {$field->getTEXT_LABEL()}
                        
                        
                        {*if $field->getSORTING()}
                            <a href="{$LISTER->PARAM_SCRIPT}order/{$field->getSQL_FIELD()}/dir/ASC/"><img src="{$LISTER->getImagesUrl()}up{if $LISTER->getSortOrder() == $field->getSQL_FIELD() && $LISTER->getSortDirection() == 'ASC'}_o{/if}.gif" title="ascending" alt="ascending" border="0"></a>
                            
                            <a href="{$LISTER->PARAM_SCRIPT}order/{$field->getSQL_FIELD()}/dir/DESC/"><img src="{$LISTER->getImagesUrl()}down{if $LISTER->getSortOrder() == $field->getSQL_FIELD() && $LISTER->getSortDirection() == 'DESC'}_o{/if}.gif" title="descending" alt="descending" border="0"></a>
                        {else}
                            &nbsp;
                        {/if*}
                        
                      
                    </td>
                    {/foreach}
                    
                    {if $LISTER->getOptions()}
                        <td class="tableTopNext tableTopEnd">Действия</td>
                    {/if}
                    <!-- TITLE HASH -->
                </tr>

	
    
    
    
    
    
    			{*<tr>
                    <td class="tableCenterLeft"></td>
                    <td class="tableCenterNext tableCenterNextUni"><input name="" type="checkbox" value="" class="checkbox"></td>
                    <td class="tableCenterNext tableCenterNextUni"><input name="" type="text" class="inputSmall"></td>
                    <td class="tableCenterNext">Текст номер один</td>
                    <td class="tableCenterNext">Текст номер один</td>
                    <td class="tableCenterNext">Текст номер один</td>
                    <td class="tableCenterNext">Текст номер один</td>
                    <td class="tableCenterNext" style="background:#ecece5"><span style="color:#069">Текст номер один</span></td>
                    <td class="tableCenterNext">Текст номер один</td>
                    <td class="tableCenterNext"><a href="#"><img src="images/edit.png"></a></td>
                    <td class="tableCenterRight"><a href="#"><img src="images/bascket.png"></a></td>
                </tr>
                  
                <tr>
                    <td class="tableCenterLeft"></td>
                    <td class="tableCenterNext tableCenterNextUni"><input name="" type="checkbox" value="" class="checkbox"></td>
                    <td class="tableCenterNext tableCenterNextUni"><input name="" type="text" class="inputSmall"></td>
                    <td class="tableCenterNext">Текст номер один</td>
                    <td class="tableCenterNext">Текст номер один</td>
                    <td class="tableCenterNext">Текст номер один</td>
                    <td class="tableCenterNext">Текст номер один</td>
                    <td class="tableCenterNext" style="background:#ecece5"><span style="color:#069">Текст номер один</span></td>
                    <td class="tableCenterNext">Текст номер один</td>
                    <td class="tableCenterNext"><a href="#"><img src="images/edit.png"></a></td>
                    <td class="tableCenterRight"><a href="#"><img src="images/bascket.png"></a></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="tableBottom tableCenterNextUni"><input name="" type="checkbox" value="" class="checkbox"></td>
                    <td class="tableBottom tableCenterNextUni"><input name="" type="text" class="inputSmall"></td>
                    <td class="tableBottom">Текст номер один</td>
                    <td class="tableBottom">Текст номер один</td>
                    <td class="tableBottom">Текст номер один</td>
                    <td class="tableBottom">Текст номер один</td>
                    <td class="tableBottom" style="background:#ecece5"><span style="color:#069">Текст номер один</span></td>
                    <td class="tableBottom">Текст номер один</td>
                    <td class="tableBottom"><a href="#"><img src="images/edit.png"></a></td>
                    <td class="tableBottomUni"><a href="#"><img src="images/bascket.png"></a></td>
                </tr>
        *}
    
    
    
    
    
    
    
                           {if $LISTER->getRecords()}
                               {foreach from=$LISTER->getRecords() name=nam item=current}

								
								<tr bgcolor="#DEDBD6" {*onmouseover="this.style.backgroundColor='#c4d8e5';"  onmouseout="this.style.backgroundColor='#DEDBD6';"*}>
                            		<td class="tableCenterLeft"></td>
                                    
                            		{assign var=c_row value=0}
                   
                                    {if $LISTER->PARAM_EL_CHECKBOX && $LISTER->getButtons() && $LISTER->getPrimaryField()}
                                    {assign var=c_row value=$c_row+1}
                                    	<td class="tableCenterNext tableCenterNextUni" id="r_{$smarty.foreach.nam.iteration}c_{$c_row}" 
                                        {*onmouseover="this.style.color='#069'; this.style.backgroundColor='#FFF'; highlightColumn(1,{$smarty.foreach.nam.iteration},{$c_row});" onmouseout="this.style.color=''; this.style.backgroundColor='';highlightColumn(0,{$smarty.foreach.nam.iteration},{$c_row});"*}><input type="checkbox" class="checkbox" name="CHECK_ELEMENTS[]" value="{$current->getProperty($LISTER->getPrimaryField()->getSQL_FIELD())}"></td>
                                    {/if}
                                    
                                    {if $LISTER->PARAM_EL_SORTING && $LISTER->getButtons()  && $LISTER->getPrimaryField() && $LISTER->getSortingField()}
                                    {assign var=c_row value=$c_row+1}
                                    	<td class="tableCenterNext tableCenterNextUni" id="r_{$smarty.foreach.nam.iteration}c_{$c_row}" 
                                        {*onmouseover="this.style.color='#069'; this.style.backgroundColor='#FFF'; highlightColumn(1,{$smarty.foreach.nam.iteration},{$c_row});" onmouseout="this.style.color=''; this.style.backgroundColor='';highlightColumn(0,{$smarty.foreach.nam.iteration},{$c_row});"*}><input type="text" name="SORT_ELEMENTS[{$current->getProperty($LISTER->getPrimaryField()->getSQL_FIELD())}]" value="{$current->getProperty($LISTER->getSortingField()->getSQL_FIELD())}" class="inputSmall"></td>
									                  {/if}
                                    
                                    
                                    <!-- td -->
                                    <!-- DATA_HASH-->								

                                    {foreach from=$LISTER->getFields() item=field name=fields}
                                        <!-- td style -->
                                        <td class="tableCenterNext" id="r_{$smarty.foreach.nam.iteration}c_{$smarty.foreach.fields.iteration+$c_row}" 
                                        {*onmouseover="this.style.color='#069'; this.style.backgroundColor='#FFF'; highlightColumn(1,{$smarty.foreach.nam.iteration},{$smarty.foreach.fields.iteration+$c_row});" onmouseout="this.style.color=''; this.style.backgroundColor='';highlightColumn(0,{$smarty.foreach.nam.iteration},{$smarty.foreach.fields.iteration+$c_row});"*}
                                        style="padding-top:3px;padding-bottom:3px"{if $field->getTD_ALIGN()} align="{$field->getTD_ALIGN()}"{else} align="left"{/if}{if $field->getTD_VALIGN()} valign="{$field->getTD_VALIGN()}"{else} valign="top"{/if}{if $field->getTD_WIDTH()} width="{$field->getTD_WIDTH()}"{/if}{if $field->getTD_NOWRAP()} nowrap{/if}{if $field->getTD_CLASS()} class="{$field->getTD_CLASS()}"{/if}{if $field->getTD_STYLE()} style="{$field->getTD_STYLE()}"{/if}{if $field->getTD_EVENT()} {$field->getTD_EVENT()}{/if}>
                                        <!-- /td style -->
                                        
                                            {if $field->getLINK_HREF()}
                                                <a href="{$field->getLINK_HREF()}"{if $field->getLINK_CLASS()} class="{$field->getLINK_CLASS()}"{/if}{if $field->getLINK_STYLE()} style="{$field->getLINK_STYLE()}"{/if}{if $field->getLINK_EVENT()} {$field->getLINK_EVENT()}{/if}{if $field->getLINK_TARGET()} target="{$field->getLINK_TARGET()}"{/if}>{if $field->getTEXT_STRONG()}<b>{/if}{if $field->getTEXT_COLOR()}<font color="{$field->getTEXT_COLOR()}">{/if}
                                                
                                                {$currentA.value}
                                                
                                                {if $field->getTEXT_COLOR()}</font>{/if}{if $field->getTEXT_STRONG()}</b>{/if}</a>
                                            {else}
                                                {if $field->getTEXT_STRONG()}<b>{/if}
                                                {if $field->getTEXT_COLOR()}<font color="{$field->getTEXT_COLOR()}">{/if}
                                                
                                                {*$currentA.value*}
                                                
                                                
                                                {if $field->getTEXT_HTML()}
                                                	{$current->getProperty($field->getSQL_FIELD())}
                                                {else}
                                                	{$current->getProperty($field->getSQL_FIELD())|escape:"html"}
                                                {/if}
                                                
                                                
                                                
                                                {if $field->getTEXT_COLOR()}</font>{/if}
                                                {if $field->getTEXT_STRONG()}</b>{/if}
                                        	{/if}
                                        </td>
                                    {/foreach}

                                    <!-- DATA_HASH-->
                                    <!-- td -->






								

                                    <!-- options-->
                                    
                                    
                                    {if $LISTER->getOptions()}
                                    <td align="{$LISTER->PARAM_OPTION_ALIGN}" valign="{$LISTER->PARAM_OPTION_VALIGN}"{if $LISTER->PARAM_OPTION_NOWRAP} nowrap{/if}{if $LISTER->PARAM_OPTION_WIDTH} width="{$LISTER->PARAM_OPTION_WIDTH}"{/if} class ="tableCenterRight" >
                                    <div style="height:0px; line-height:normal; display:inline;"></div>
                                        {foreach from=$LISTER->getOptions() item=option name=opthash}
                                    
                                        <a href="{$option->getLINK_HREF()}{foreach from=$LISTER->getLoopVars() item=loopVar}{$loopVar}/{$current->getProperty($loopVar)}/{/foreach}"{if $option->getLINK_CLASS()} class="{$option->getLINK_CLASS()}"{/if}{if $option->getLINK_STYLE()} style="{$option->getLINK_CLASS()}"{/if}{if $option->getLINK_EVENT()} {$option->getLINK_EVENT()}{/if}{if $option->getLINK_TARGET()} target="{$option->getLINK_TARGET()}"{/if}>{if $option->getTEXT_COLOR()}<font color="{$option->getTEXT_COLOR()}">{/if}{if $option->getTEXT_STRONG()}<b>{/if}{$option->getTEXT_LABEL()}{if $option->getTEXT_STRONG()}</b>{/if}{if $option->getTEXT_COLOR()}</font>{/if}</a>{if !$smarty.foreach.opthash.last} {$LISTER->PARAM_OPTION_DELIM} {/if}
                                        {/foreach}
                                    </td>
                                    {/if}
                                    <!-- options-->
                                    
                                    
                                    
                                    
                                    
								</tr>
							
							
                            
                            
                                                        
                                                        
                            
                            
                            
                            
                            
                            
                            
                            
								{/foreach}
							
                            
                            {else}
                                <tr bgcolor="FFFFFF">
                                    <td colspan="{$LISTER->getColspan()}" style="padding-bottom:20px; padding-top:20px" align="center">Нет данных</td>
                                </tr>
							{/if}
                 
                 
                 
                 
                 
                 
                 
                 
                 <tr>
                <td class="blackLineLeft"></td>
                <td class="blackLineCenter" colspan="{$LISTER->getColspan()}">
                
                <div class="blackLineCenterLeft">
                	
                    {if $LISTER->getButtons()}
                    выбранные: 
                        	{foreach from=$LISTER->getButtons() item=current name=buthash}
                            
                                <a href="#" 
                                {if $current->getConfirm()}
                                    onclick="if (ValidForm() && confirm('{$current->getConfirm()}')){$smarty.ldelim}forms['content_form'].action='{$current->getAction()}';forms['content_form'].submit();{$smarty.rdelim}; return false;"
                                {else}
                                    onclick="if (ValidForm()){$smarty.ldelim}forms['content_form'].action='{$current->getAction()}';forms['content_form'].submit();{$smarty.rdelim}; return false;"
                                {/if}
                                
                                
                                 >{$current->getVALUE()}</a>
                                 
                                {if !$smarty.foreach.buthash.last}&nbsp;{/if}
                            {/foreach}
                    {/if}
                    
                    
                
                			<span style="text-align:center">
                            {if $LISTER->getList()->getPagesCount() > 1}
                                &nbsp;&nbsp;
                                {section loop=$LISTER->getList()->getPagesCount()  name=paghash}
                                    {if $smarty.section.paghash.iteration != $LISTER->getList()->getCurrentPage()}
                                        <a href="{$LISTER->PARAM_SCRIPT}pagenum/{$smarty.section.paghash.iteration}/" class="options">{$smarty.section.paghash.iteration}</a>
                                    {else}
                                        <b>{$smarty.section.paghash.iteration}</b>
                                    {/if}
                                    
                                    {if !$smarty.section.paghash.last} |{/if}
                                {/section}
                            {else}
                            &nbsp;
                            {/if}
                            </span>
                </div>
                 
                 
                  </form>
                  
                  
                  <div class="blackLineCenterRight">
                  	{if $LISTER->PARAM_PAG_PANEL}
                    	
                        Всего: {$LISTER->getList()->getCount()}, выведено на странице:
                        
                        {if $LISTER->getList()->getListSize() == 10}10 {else} <a href="#" onclick="document.getElementById('h_perpage').value=10;forms['pag_form'].submit();">10</a>{/if}
                        {if $LISTER->getList()->getListSize() == 20}20 {else} <a href="#" onclick="document.getElementById('h_perpage').value=20;forms['pag_form'].submit();">20</a>{/if}
                        {if $LISTER->getList()->getListSize() == 40}40 {else} <a href="#" onclick="document.getElementById('h_perpage').value=40;forms['pag_form'].submit();">40</a>{/if}
                        {if $LISTER->getList()->getListSize() == 80}80 {else} <a href="#" onclick="document.getElementById('h_perpage').value=80;forms['pag_form'].submit();">80</a>{/if}
                        {if $LISTER->getList()->getListSize() == 1000}все {else} <a href="#" onclick="document.getElementById('h_perpage').value=1000;forms['pag_form'].submit();">все</a>{/if}
                        <form name="pag_form" action="{$LISTER->PARAM_SCRIPT}" method="post"> 
                        	<input type="hidden" name="perpage" id="h_perpage" value="{$LISTER->getList()->getListSize()}" />
                        </form>    
                            
                            
                             
                        
                    {/if}    
                  </div>
                </td>
              </tr>
              
                            
        </table>
	</td>
</tr>
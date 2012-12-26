<!--НЕ ТРОГАТЬ РУКАМИ by Aleksandr for гавнокодеров-->
{*$okved|print_r*}
{*$okato|print_r*}
{*$responce|print_r*}

<link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/redmond/jquery-ui-1.8.2.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/ui.multiselect.css" />

<script src="/scripts/js/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
<script src="/scripts/js/jquery.layout.js" type="text/javascript"></script>
<script src="/scripts/js/i18n/grid.locale-ru.js" type="text/javascript"></script>

<script src="/scripts/js/ui.multiselect.js" type="text/javascript"></script>
<script src="/scripts/js/jquery.jqGrid.js" type="text/javascript"></script>

{literal}

<script type="text/javascript">
    jQuery.jgrid.no_legacy_api = true;
    jQuery.jgrid.useJSON = true;
</script>

<script type="text/javascript">



function HideShow(temp){

    if( $(temp).attr("style"))
    {
        $(temp).removeAttr("style");
        
      }
    else
    {
        $(temp).attr("style","display:none;");
    }
return false;
}

function SelectRub(rub1,rub2){

    if( $(rub1).attr("style"))
    {
        $(rub1).removeAttr("style");
        $(rub2).attr("style","display:none")
        
      }
    else
    {
        $(rub1).attr("style","display:none;");
        $(rub2).removeAttr("style");
    }
return false;

}

function ClearRub(rub1,rub2){

        $(rub1).attr("style","display:none;");
        $(rub2).attr("style","display:none")
        

return false;

}

</script>
{/literal}

<h1>Индивидуальные базы данных</h1>
<div class="">
<a href="#" onClick="HideShow('.reg')">Выбрать регион</a><br>
	<div class="reg" style="display:none">
			<table class="treg">
				
					{foreach from=$okato item=current name="okato"}
					<tr>
						<td>
						<input type="checkbox" id="sregion_{$current.id}" value="{$current.id}" OnChange="doSearch(arguments[0]||event);" ><span onClick="HideShow('.subreg_{$current.id}')"><b>{$current.name}({$current.c_all})</b></span>
						</td>
					</tr>
					{foreach from=$current.subitems item=subitem name="subOkato"}
					<tr class="subreg_{$current.id}" style="display:none">
						<td>
						<input type="checkbox" id="sub_sregion_{$subitem.id}" value="{$subitem.id}" onChange="doSearch(arguments[0]||event);" ><span>{$subitem.name}({$subitem.c_all})</span>
						</td>
					</tr>{/foreach}

					{/foreach}
				</tr>
			</table>


	</div>
<a href="#" onClick="ClearRub('.okved','.rubricator');HideShow('.rub');">Выбрать рубрику</a><br>
	<div class="rub" style="display:none">
		<label><input type="radio" name="rub" value="rub1" id="rub1" onChange="SelectRub('.okved','.rubricator')" checked>ОКВЭД</label>
		<label><input type="radio" name="rub" value="rub2" id="rub2" onChange="SelectRub('.rubricator','.okved')">Рубрикатор</label>
	</div>
		<div class="okved" style="display:none">
			<table class="tokved">

					{foreach from=$okved item=current name="okved"}
					<tr>
						<td>
							<input type="checkbox" id="srubric_{$current.id}" value="{$current.id}" onChange="doSearch(arguments[0]||event);" ><span onClick="HideShow('.trokved_{$current.id}')"><b>{$current.name}({$current.c_all})</b></span>
						</td>
					</tr>

					{foreach from=$current.subitems item=currents name="okved"}
					<tr class="trokved_{$current.id}" style="display:none">
						<td>
							<input type="checkbox" id="sokved_{$currents.id}" value="{$currents.id}" onChange="doSearch(arguments[0]||event);"><span onClick="HideShow('.trsubokved_{$currents.id}')"><b>{$currents.name}({$currents.c_all})</b></span>
						</td>
					</tr>
						{foreach from=$currents.subitems item=subsubitem name="third"}
							<tr class="trsubokved_{$currents.id}" style="display:none">
								<td>
									<input type="checkbox" id="sub_sokved_{$subsubitem.id}" value="{$subsubitem.id}" onChange="doSearch(arguments[0]||event);" >{$subsubitem.name}({$subsubitem.c_all})
								</td>
							</tr>
						{/foreach}
					{/foreach}{/foreach}

			</table>
		</div>
		
		<div class="rubricator" style="display:none">
			<table class="trubricator" >
					{foreach from=$okved item=current name="okved"}
					<tr>
						<td>
							<input type="checkbox" id="srubric_{$current.id}" value="{$current.id}" onChange="doSearch(arguments[0]||event);" ><span onClick="HideShow('.trokved_{$current.id}')"><b>{$current.name}({$current.c_all})</b></span>
						</td>
					</tr>

					{foreach from=$current.subitems item=currents name="okved"}
					<tr class="trokved_{$current.id}" style="display:none">
						<td>
							<input type="checkbox" id="sokved_{$currents.id}" value="{$currents.id}" onChange="doSearch(arguments[0]||event);"><span onClick="HideShow('.trsubokved_{$currents.id}')"><b>{$currents.name}({$currents.c_all})</b></span>
						</td>
					</tr>
						{foreach from=$currents.subitems item=subsubitem name="third"}
							<tr class="trsubokved_{$currents.id}" style="display:none">
								<td>
									<input type="checkbox" id="sub_sokved_{$subsubitem.id}" value="{$subsubitem.id}" onChange="doSearch(arguments[0]||event);" >{$subsubitem.name}({$subsubitem.c_all})
								</td>
							</tr>
						{/foreach}
					{/foreach}{/foreach}
			</table>
		</div>
<a href="#" onClick="">Обязательные поля</a><br>
<a href="#" onClick="">Формат базы</a>
</div>
<div>

<table id="bigset"></table>
<div id="pagerb"></div>
			<div id=info style='display:none; position:absolute; top:220px;z-index:10000; left: 500px'>
				
			</div>

{literal}
    <script type="text/javascript">

 setTimeout(function(){
			jQuery("#bigset").jqGrid({
                url:'/database/individual/',
                datatype: "json",
                height: 100+'%',
                width: 700,
                hoverrows: false,
                colNames:['Наименование','Количество','Цена'],
                colModel :[
                        {name:'name', index:'name',width:200}
                        ,{name:'c_all', index:'c_all'}
                        ,{name:'price', index:'price'}
                        ],
                rowNum:20,
                rowList:[20,30,40],
                mtype: "POST",
                pager: jQuery('#pagerb'),
                pgbuttons: true,
                pgtext: false,
                pginput:false,
                sortname: 'name',
                sortorder: "desc",
                viewrecords: true
               });
				},1000);

var timeoutHnd;
var flAuto = true;


function doSearch(ev){
    if(!flAuto)
        return;
    if(timeoutHnd)
clearTimeout(timeoutHnd)
timeoutHnd = setTimeout(gridReload,500)
    }

    function gridReload(){
                        
                {/literal}
					
				var okved_mask = {foreach from=$okved item=current name="okved"}
					{foreach from=$current.subitems item=currents name="okved"} 
					
					jQuery("#sokved_{$currents.id}").is(':checked')*
					jQuery("#sokved_{$currents.id}").val()+'-'+ {/foreach}{/foreach}0;
                
				var sub_okved_mask = {foreach from=$okved item=current name="okved"}
					{foreach from=$current.subitems item=currents name="okved"}
					{foreach from=$currents.subitems item=subsubitem name="third"}

				jQuery("#sub_sokved_{$subsubitem.id}").is(':checked')*
				jQuery("#sub_sokved_{$subsubitem.id}").val()+'-'+ {/foreach}{/foreach}{/foreach}0;

				var rubric_mask = {foreach from=$okved item=current name="okved"}
					jQuery("#srubric_{$current.id}").is(':checked')*
					jQuery("#srubric_{$current.id}").val()+'-'+ {/foreach}0;

				var region_mask = {foreach from=$okato item=current name="okato"}
					jQuery("#sregion_{$current.id}").is(':checked')*
					jQuery("#sregion_{$current.id}").val()+'-'+ {/foreach}0;

                var sub_region_mask = {foreach from=$okato item=current name="okato"}
               		 {foreach from=$current.subitems item=subitem name="subOkato"}

                	jQuery("#sub_sregion_{$subitem.id}").is(':checked')*
					jQuery("#sub_sregion_{$subitem.id}").val()+'-'+ {/foreach}{/foreach}0;


                {literal}
                
                
                jQuery("#bigset").jqGrid('setGridParam',{url:"/database/individual/?okved_mask="+okved_mask+"&sub_okved_mask="+sub_okved_mask+"&rubric_mask="+rubric_mask+"&region_mask="+region_mask+"&sub_region_mask="+sub_region_mask}).trigger("reloadGrid");
                        }

</script>
{/literal}
</div>
<div>
	<label><textarea style="width:300px; height:100px;" name="textNote"></textarea></label><br>

	<label><input class="button_buy" type="submit" value="  добавить в корзину " name="submitb"></label>
</div>
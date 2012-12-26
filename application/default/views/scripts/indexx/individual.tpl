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

/* Свертывание/развертывание потомков */
$(function(){
    $('span#list_name').click(function(){
		$(this).parent().children("div#list").each(function(){
			if($(this).css('display') == 'none'){
				$(this).show();
			} else { 
				$(this).hide();
			}
		});
    });
});

/* Выделение потомков в дереве checkbox */
$(function(){
    $("input[type=checkbox]").change(function(){
	    var chk = $(this).attr('checked');
		$(this).parent().children('div#list').each(function(){
			if(chk == true || chk == "checked"){
				$(this).find('input[type=checkbox]').attr("checked", "checked");
			}else{
				$(this).find('input[type=checkbox]').removeAttr("checked");
			}
		});
	});
});

function slide(div_id){
	// $('#'+div_id).slideUp("slow");
	$('#'+div_id).slideToggle("slow");
}

</script>
{/literal}

<h1>Индивидуальные базы данных</h1>
<div class="">
	<div id="heigth_limit" style="width: 100%; height: 270px; overflow-y: scroll;">
		<table border = 0>
		<tr><td valign = "top" width = "55%">
		<!-- rubric part -->
		<a href="#" onClick="ClearRub('.okved','.rubricator');HideShow('.rub');">Выбрать рубрику</a><br>
		<div class="rub" style="">
			<label><input type="radio" name="rub" value="rub1" id="rub1" onChange="SelectRub('.okved','.rubricator')" checked>ОКВЭД</label>
			<label><input type="radio" name="rub" value="rub2" id="rub2" onChange="SelectRub('.rubricator','.okved')">Рубрикатор</label>
		</div>
			<!-- okved part -->
			<div class="okved" style="">
				<table class="tokved">
					<tr><td>{$real_okved}</td></tr>
				</table>
			</div>
			<!-- rubricator part -->
			<div class="rubricator" style="display:none">
				<table class="trubricator" >
					<tr>
						<td>
						<!-- first level -->
						{foreach from=$okved item=current name="okved"}
							<div id= 'list' name= 'list_{$current.id}' class='parent'>
								<input type="checkbox" id="srubric_{$current.id}" value="{$current.id}" onChange="doSearch(arguments[0]||event);" >
								<span id='list_name'><b>{$current.name}({$current.c_all})</b></span>

							<!-- second level -->
							{foreach from=$current.subitems item=currents name="okved"}
								<div  id= 'list' name= 'list_{$current.id}' style='padding-left:20px; display: none;'>
									<input type="checkbox" id="sokved_{$currents.id}" value="{$currents.id}" onChange="doSearch(arguments[0]||event);">
									<span id='list_name'>{$currents.name}({$currents.c_all})</span>

								<!-- third level -->
								{foreach from=$currents.subitems item=subsubitem name="third"}
									<div  id= 'list' name= 'list_{$current.id}' style='padding-left:20px; display: none;'>
										<input type="checkbox" id="sub_sokved_{$subsubitem.id}" value="{$subsubitem.id}" onChange="doSearch(arguments[0]||event);" >
										{$subsubitem.name}({$subsubitem.c_all})
									</div>
								{/foreach}
								</div>
							{/foreach}
							</div>
						{/foreach}							
						</td>
					</tr>
				</table>
			</div>		
		</td>

		<td valign = "top">
		<!-- region part -->
		<a href="#" onClick="HideShow('.reg')">Выбрать регион</a><br>
		<div class="reg" style="">
			<table class="treg">
				<tr>
					<td>
					<!-- first level -->
					{foreach from=$okato item=current name="okato"}
						<div id= 'list' name= 'list_{$current.id}' class='parent'>
							<input type="checkbox" id="sregion_{$current.id}" value="{$current.id}" OnChange="doSearch(arguments[0]||event);" >
							<span id='list_name'><b>{$current.name}({$current.c_all})</b></span>

						<!-- second level -->
						{foreach from=$current.subitems item=subitem name="subOkato"}
							<div id= 'list' name= 'list_{$subitem.id}' style='padding-left:20px; display: none;'>
								<input type="checkbox" id="sub_sregion_{$subitem.id}" value="{$subitem.id}" onChange="doSearch(arguments[0]||event);" >
								<span id='list_name'>{$subitem.name}({$subitem.c_all})</span>

							<!-- third level -->
							{foreach from=$subitem.level3 item=level3 name="sublevel3"}
								<div id= 'list' name= 'list_{$level3.id}' style='padding-left:20px; display: none;'>
									<input type="checkbox" id="sub_level3_{$level3.id}" value="{$level3.id}" onChange="doSearch(arguments[0]||event);" >
									<span>{$level3.name}({$level3.c_all})</span>
								</div>
							{/foreach}
							</div>
						{/foreach}
						</div>
					{/foreach}										
					</td>
				</tr>							
			</table>
		</div>
		</td>
		</tr>
		</table>
	</div>

<a href="#" onClick="slide('required_fields');">Обязательные поля</a><br>
	<div id='required_fields' style="display:none;">
		<label for="fax"> <input type="checkbox" class="personalFields" id="fax"  name="Факс"> Факс</label></br>
		<label for="tel"> <input type="checkbox" class="personalFields" id="tel"  name="Телефон"> Телефон</label></br>
		<label for="fond"><input type="checkbox" class="personalFields" id="fond" name="Уставной фонд"> Уставной фонд</label></br>
		<label for="mail"><input type="checkbox" class="personalFields" id="mail" name="E-mail"> E-mail</label>
	</div>
<a href="#" onClick="slide('db_format');">Формат базы</a>
	<div id='db_format' style="display:none;">
		<div style="padding-bottom: 10px;"><b>Формат данных:</b> MS Excel</div>
		<b>Поля базы:</b>
		<div style="padding-bottom:10px; font-style:italic; font-weight:normal; font-size:11px;">
			Поля отмеченные (*) заполнены не на 100%. Количество предприятий с данными полями, необходимо уточнять в каждом конкретном запросе.
		</div>
		Наименование, ОКПО, Область, Район, Населенный пункт, Адрес, Руководитель, Дата регистрации, Отрасли, Телефон*, Факс*, ВЭД*, Уставной  фонд*
		<div style="padding-top: 10px;"><a href="#" class="example">Пример базы данных</a></div>
	</div>
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
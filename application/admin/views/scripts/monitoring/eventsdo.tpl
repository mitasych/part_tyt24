<tr>
	<td>
		<h3>Мониторинг - список событий</h3>
	</td>
</tr>
<tr>
	<td>
	<script type="text/javascript" async="" src="http://www.google-analytics.com/ga.js"></script>
<script type="text/javascript" src="/scripts/jquery.js"></script>
<script type="text/javascript" src="/scripts/jquery-ui-1.7.3.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/grid.base.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/grid.common.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/grid.formedit.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/grid.inlinedit.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/grid.celledit.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/grid.subgrid.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/grid.treegrid.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/grid.custom.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/grid.postext.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/grid.tbltogrid.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/grid.setcolumns.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/grid.import.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/jquery.fmatter.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/grid.grouping.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/jqModal.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/jqDnR.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/JsonXml.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/grid.jqueryui.js"></script>
<script type="text/javascript" charset="utf-8" src="/scripts/js/jquery.searchFilter.js"></script>
		<div id='kontragent'>
			<table > 
				<tr>
					<td width=500px>
					
						<table id="bigset"></table>
						<div id="pagerb"></div>
						
						{literal}
			 
						<script src="/scripts/js/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
						<script src="/scripts/js/jquery.layout.js" type="text/javascript"></script>
						<script src="/scripts/js/i18n/grid.locale-ru.js" type="text/javascript"></script>

						<link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/redmond/jquery-ui-1.8.2.custom.css" />
						<link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/ui.jqgrid.css" />
						<link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/ui.multiselect.css" />
						<script src="/scripts/js/ui.multiselect.js" type="text/javascript"></script>
						<script src="/scripts/js/jquery.jqGrid.js" type="text/javascript"></script>

					
						<style type="text/css">
							.searchFLD {
								width:100px;
								
							}
						</style>
						<script type="text/javascript">
					//	alert('');
					$(document).ready(function() {
					
						var is_last_sel = 0;
						function select_event()
						{
							$.getJSON("/admin/monitoring/eventitem/?id="+$('#bigset').jqGrid('getGridParam','selrow'),
								function(data){
									$('#name').html(data['cell'][0]);
									$('#type').html(data['cell'][1]);
									$('#stat').html(data['cell'][6]);
									$('#date').html(data['cell'][4]+'/'+data['cell'][3]);
									$('#ka').html(data['cell'][8]+' ('+data['cell'][7]+'), '+data['cell'][9]+', '+data['cell'][11]);
								});
						}
						
						$('#next').click(function(){
							//alert('ff');
							id = $('#bigset').jqGrid('getGridParam','selrow');
							//alert(id);
							id = $('#'+id).next().attr('id');
							if (!id)
								id = $('tr.ui-widget-content:first').attr('id');
							if (is_last_sel == id)
								is_last_sel = 0;
							$('#bigset').jqGrid('setSelection',id);
						});
						$('#first').click(function(){
							id = $('tr.ui-widget-content:first').attr('id');;
							$('#bigset').jqGrid('setSelection',id);
						});
						$('#nexter').click(function(){
							//id = $('tr.ui-widget-content:first').attr('id');;
							//alert(is_last_sel);
							$('#bigset').jqGrid('setSelection',is_last_sel);
						});
						$('#last').click(function(){
							//alert('ff');
							id2 = $('#bigset').jqGrid('getGridParam','selrow');
							//alert(id);
							id = $('#'+id2).prev().attr('id');
							if (!id)
								id = $('tr.ui-widget-content:last').attr('id');
							//alert(id);
							$('#bigset').jqGrid('setSelection',id);
							if (!is_last_sel)
								is_last_sel = id2;//alert(is_last_sel);}
							else if (is_last_sel == id)
								is_last_sel = 0;
						});
						$('button[name="status"]').click(function(){
							//alert($(this).val());
							if ($(this).val() == 'yes')
							{
								
								$("tr[role='row']").each(function (i) {
									$.get("/admin/monitoring/setstatus/?id="+$(this).attr('id')+'&stat=yes',
										function(data){
											//$('#next').click();
											select = $('#bigset').jqGrid('getGridParam','selrow');
											id = $('#'+select).next().attr('id');
											gridReload();
											//setTimeout(function(){
												$('#bigset').jqGrid('setSelection',id);
											//}, 1000);
										});
								})
							}
							else
							{
								$.get("/admin/monitoring/setstatus/?id="+$('#bigset').jqGrid('getGridParam','selrow')+'&stat='+$(this).val(),
									function(data){
										//$('#next').click();
										select = $('#bigset').jqGrid('getGridParam','selrow');
										id = $('#'+select).next().attr('id');
										gridReload();
										//setTimeout(function(){
											$('#bigset').jqGrid('setSelection',id);
										//}, 1000);
									});
							}
						});
						
						$('button[name="new"]').click(function(){
							$.get("/admin/monitoring/setsess/",
								function(data){
								});
							 gridReload();
							 return false;
						});	
						$.jgrid.no_legacy_api = true;
							$.jgrid.useJSON = true;
						 setTimeout(function(){
						 jQuery("#bigset").jqGrid({
							url:'/admin/monitoring/eventdata/',
							datatype: "json",
							height: 330,
							width: 450,
							colNames:['<input type=checkbox id="delallItem" name="delallItem">','Событие', 'Тип', 'Источник', 'Дата', 'Пользователь', 'Статус'],
								colModel :[
									{name:'inp', index:'inp', width:20, align:'right', sortable:false}
									,{name:'content', index:'content', width:170, align:'right'}
									,{name:'event_type', index:'event_type', width:80, align:'right'}
									,{name:'istochnik', index:'istochnik', width:100}
									,{name:'date_do', index:'date_do', width:50}
									,{name:'user', index:'user', width:50}
									,{name:'status', index:'status', width:50, align:'right', sortable:false}
									],
							rowNum:20,
									rowList:[20,30,40],
							mtype: "POST",
							pager: jQuery('#pagerb'),
							pgbuttons: true,
							pgtext: false,
							pginput:false,
							sortname: 'content',
							testing:'dfg',
								sortorder: "desc",
								viewrecords: true,
								onSelectRow: select_event
								//tarif: {/literal}{$current_mon_tarif}{literal},
						  
									});
									}, 2000);
									var timeoutHnd;
									var flAuto = true;

									function doSearch(ev){
							if(!flAuto)
								return;
									//	var elem = ev.target||ev.srcElement;
							if(timeoutHnd)
								clearTimeout(timeoutHnd)
							timeoutHnd = setTimeout(gridReload2,500)
									}

									function gridReload(){
									
										//alert('111');
										//alert($('#bigset').jqGrid('getGridParam','selrow'));
										//	select_row_table = $('#bigset').jqGrid('getGridParam','selrow');
										alert($('#bigset').jqGrid('getGridParam','testing'));
										jQuery("#bigset").jqGrid('setGridParam',{url:"/admin/monitoring/eventdata/"}).trigger("reloadGrid");
										
									}
									gridReload()
							$('input[name="filter_serch"]').click(function(){
								gridReload();
								return false;
							});
							$('input[name="filter_serch2"]').click(function(){

								 gridReload();
								 
								 return false;
							});
							//alert('ff');
							});
						</script>
						
						<script type="text/javascript">
						$(document).ready(function() {
							
						});
							
						</script>
						{/literal}
					</td>
					<td>
						<table>
							<tr>
								<th>
									Параметр
								</th>
								<th>
									Значение
								</th>
							</tr>
							<tr>
								<td>
									Событие
								</td>
								<td id='name'>
									
								</td>
							</tr>
								<td>
									Тип
								</td>
								<td id='type'>
									
								</td>
							</tr>
								<td>
									Дата (произошло/добавлено)
								</td>
								<td id='date'>
									
								</td>
							</tr>
							</tr>
								<td>
									Статус
								</td>
								<td id='stat'>
									
								</td>
							</tr>
							</tr>
								<td>
									Контрагент
								</td>
								<td id='ka'>
									
								</td>
							</tr>
						</table>
						<div id="pagerb_info">
						
							{foreach from=$do item=item}
							<button name='status' value='{$item.id}'>{$item.simbul}</button>
							{/foreach}
							<button name='status' value='yes'>Подтвердить все</button>
							<br>
							<button id='first'><<</button>
							<button id='last'><</button>
							<button id='next'>></button>
							<button id='nexter'>>></button>
							<br>
							<button name='new' value='yes'>Новый пользователь</button>
						</div>
					   
					</td>
				</tr>
			</table>
		</div>
		
	</td>
</tr>
{*$LISTER_OUTPUT*}

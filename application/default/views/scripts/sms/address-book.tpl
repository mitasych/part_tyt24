<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
	<div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

<div>
    <div class="main_top_text">

        {breadcrumb controller="sms" alias="sms" altTitle="Сообщения"}
        {include file="lmenu.tpl"}
    
    <form action='' method=post>
			{literal}
			<script type="text/javascript" src="/scripts/tablesortet/jquery.tablesorter.js"></script>

			
			{/literal}
    
    <div class="h">Поиск контактов:</div>
	<div>	
		<input type="checkbox" id="autosearch" onclick="enableAutosubmit(this.checked)"> Автопоиск <br/>
		Поиск<br />
		<input type="text" id="search" onkeydown="doSearch(arguments[0]||event)" />
		
		<input type="button" onclick="gridReload()" id="submitButton" value="Найти" style="margin-left:30px;">
	</div>
		
    
    <input type="button" id="adddata" value="Добавить контакт" />
    <table id="bigset" style="width: 100%;">

				</table>
            <div id="pagerb"></div>
            <input type="BUTTON" id="bsdata" value="Search" />
    
    </div>
</div>

{literal}
			
			<script src="/scripts/js/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
            <script src="/scripts/js/jquery.layout.js" type="text/javascript"></script>
            <script src="/scripts/js/i18n/grid.locale-ru.js" type="text/javascript"></script>
			
            <link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/redmond/jquery-ui-1.8.2.custom.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/ui.jqgrid.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/ui.multiselect.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="/scripts/themes/jquery.ui.datepicker.css" />
			<script src="/scripts/js/ui.multiselect.js" type="text/javascript"></script>
            <script src="/scripts/js/jquery.jqGrid.js" type="text/javascript"></script>
            <script src="/scripts/jquery.ui.datepicker.js" type="text/javascript"></script>

<script type="text/javascript">

$.jgrid.no_legacy_api = true;
$.jgrid.useJSON = true;

setTimeout(function(){
	jQuery("#bigset").jqGrid({
                url: "/sms/addr-book-grid",
                datatype: "json",
               	height: 100+"%",
                width: 90+"%",
                hoverrows : false,
                colNames:['','ID', 'Фамилия', 'Имя', 'Отчество','Пол','Статус','Организация','Должность','Моб. телефон',
                'Баланс', 'Email', 'Факс', 'Телефон', 'Добавлен', 'Детали'],
                    colModel :[
						{name:'favorites',
							index:'favorites',
							align:'center',
							width:25,
							editable:false,
							search:false
						},
                        {name:'id',
                        	index:'id',
                        	align:'right',
                        	width:25,
                        	search:false,
                        	editable:false,
                        	editoptions:{readonly:true,size:10}
                        },
                        {name:'surname',
                        	index:'surname',
                        	width:63,
                        	editable:true,
                        	editoptions:{size:10}
                        },
						{name:'name',
							index:'name',
							width:59,
							editable:true,
							editoptions:{size:10}
						},
                        {name:'last_name',
                        	index:'last_name',
                        	width:76,
                        	editable:true,
                        	editoptions:{size:10}
                        },
                        {name:'sex',
                        	index:'sex',
                        	width:47,
                        	hidden:false,
                        	editrules:{edithidden:true},
                        	editable:true,
                        	edittype:"select",
                        	formatter:"select",
                        	editoptions:{value:":Выберите;0:женский; 1:мужской"},
                        	stype : "select",
                            searchoptions : {value:":Выберите;0:женский; 1:мужской"}
                        },
                        {name:'status',
                        	index:'status',
                        	width:51,
                        	hidden:false,
                        	editrules:{edithidden:true},
                        	editable:true,
                        	edittype:"select",
                        	formatter:"select",
                        	editoptions:{value:":Выберите;1:физ.лицо; 2:юр.лицо"},
                        	stype : "select"
                        },
                        {name:'org',
                        	index:'org',
                        	width:116,
                        	editable:true,
                        	editoptions:{size:10}
                        },
                        {name:'position',
                        	index:'position',
                        	width:75,
                        	editable:true,
                        	editoptions:{size:10}
                        },
                        {name:'mobile_phone',
                        	index:'mobile_phone',
                        	width:95,
                        	align:'right',
                        	editable:true,
                        	editoptions:{size:10}
                        },
                        {name:'balans',
                        	index:'balans',
                        	align:'right',
                        	width:65,
                        	editable:true,
                        	editoptions:{size:10},
                        	formatter:"currency",
                        	formatoptions:{},
                        	sorttype:"currency"
                        },
                        {name:'email',
                        	index:'email',
                        	hidden:true,
                        	editrules:{edithidden:true},
                        	editable:true,
                        	editoptions:{size:10},
                        	formatter:"email"
                        },
                        {name:'fax',
                        	index:'fax',
                        	hidden:true,
                        	editrules:{edithidden:true},
                        	editable:true,
                        	editoptions:{size:16}
                        },
                        {name:'phone_number',
                        	index:'phone_number',
                        	hidden:true,
                        	editrules:{edithidden:true},
                        	editable:true,
                        	editoptions:{size:16}
                        },
                        {name:'add_date',
                        	index:'add_date',
                        	align:'center',
                        	hidden:true,
                        	editrules:{edithidden:true},
                        	editable:false,
                        	formatter:"date",
                        	formatoptions:{srcformat:'U',newformat:'d/M/Y'},
                        	searchoptions:{
                        					dataInit:function(el){$(el).datepicker({changeMonth: true,
                        															changeYear: true,
                        															onSelect:function(){
                        																var grid = $("#bigset");
																						grid[0].triggerToolbar();
                        															},
                        															});
                        										}
                        					}
                        },
                        {name:'action',index:'action',width:80,  align:'center', sortable:false,search:false}

                        ],
		             rowNum:10,
		             autowidth: true,
                     rowList:[10,20,40],
	                mtype: "POST",
	                pager: jQuery('#pagerb'),
	                pgbuttons: true,
	                pgtext: false,
	                pginput:true,
	                key: true,
	                toolbar: [true,"bottom"],
	                multiselect: true,
	                cellEdit:true,
	                sortname: 'org',
                    sortorder: "desc",
                    editurl:"/sms/address-book-add",
					viewrecords : true,
					gridview : true,
                    rownumbers: false,
                    subGrid : false,
                    subGridRowExpanded : function(subgridid,rowid)
					{
						var data = {subgrid:subgridid, rowid:rowid};
						$("#"+jQuery.jgrid.jqID(subgridid)).load('/sms/addr-book-grid-edit',data);
					},
					beforeSelectRow: function(rowid)
					{
						ShowDetails(rowid);
						return true;
					}
					
                });
                jQuery("#bigset").jqGrid('filterToolbar',{stringResult: false,searchOnEnter : false});
                
				var tBar = $("#t_bigset");
			    tBar.append('<input id="c_chooser1" type="button" value="Базовый мастер">');
			    tBar.append('<input id="c_chooser2" type="button" value="Сторонний мастер">');
			    
			 
			    $("#c_chooser1").click(function(){
			        jQuery("#bigset").jqGrid('setColumns',{
			                                   colnameview:false,
			                                   updateAfterCheck: true
			                                  });
			    });
			 
			    $("#c_chooser2").click(function(){
			        jQuery("#bigset").jqGrid('columnChooser');
			    });
			    
			   /* jQuery("#bigset").jqGrid('navGrid','#pagerb',  // Управление тулбаром таблицы
				    {search:true}
				);*/
						

}, 2000);

var timeoutHnd;
var flAuto = false;

function doSearch(ev){
	if(!flAuto)
		return;
//	var elem = ev.target||ev.srcElement;
	if(timeoutHnd)
		clearTimeout(timeoutHnd)
	timeoutHnd = setTimeout(gridReload,500)
}

function gridReload(){
	var search_mask = jQuery("#search").val();
	jQuery("#bigset").jqGrid('setGridParam',{url:"/sms/addr-book-grid?search_mask="+search_mask,page:1}).trigger("reloadGrid");
}
function enableAutosubmit(state){
	flAuto = state;
	jQuery("#submitButton").attr("disabled",state);
}

$("#adddata").click(function(){
	//jQuery("#bigset").jqGrid('showCol',"status");
	 jQuery("#bigset").jqGrid('editGridRow',"new",{
	 		modal: false,
	 		drag: false,
	 		closeAfterAdd:true,
	 		reloadAfterSubmit:true
	 		});
});

function ShowDetails(id){
		//jQuery("#bigset").jqGrid('setGridParam',{cellEdit:false});
		//$(".ui-jqgrid").css('font-size','13px');
		var show = true;
		
		if(($('#'+id).find('td:eq(0)').is(':hover'))||($('#'+id).find('td:eq(1)').is(':hover'))||($('#'+id).find('td:last').is(':hover'))){
                                            show = false;
                                            jQuery("#bigset").jqGrid('setGridParam',{cellEdit:true});
                                        }else{
                                            show = true;
                                            jQuery("#bigset").jqGrid('setGridParam',{cellEdit:false});
                                           // return true;
                                        }
		
		if(show == true){
		jQuery("#bigset").jqGrid('viewGridRow', id,{
	 		caption: "Карточка пользователя"
	 		});
	 	//return true;
	 	}
}

function editRow(id){
$(".ui-icon-closethick").trigger('click');

jQuery("#bigset").jqGrid('editGridRow', id,{
	 		editCaption: "Редактирование",
	 		url: "/sms/address-book-edit",
	 		modal: false,
	 		drag: true,
	 		closeAfterEdit:true,
	 		reloadAfterSubmit:true
	 		});
	 		return false;
}

//form_search
$("#bsdata").click(function(){
	 jQuery("#bigset").jqGrid('searchGrid',{
			closeOnEscape:true, multipleSearch:true, closeAfterSearch:true
			});
});


function deleteRow(id){

$(".ui-icon-closethick").trigger('click');
	jQuery("#bigset").jqGrid('delGridRow', id,{
		url: "/sms/address-book-del",
		reloadAfterSubmit:true,
		msg: "Вы настаиваете на удалении?",
		caption: "Удаление записи",
		top : 357,
		left: 504
	
	});
}

function  favor (fav,id){
    $('#info_favor').hide();
    $('#info_favor1').hide();
    if(fav==0){
        $('#f_'+id).removeAttr('class').attr('class','nofavorites-star');
    }
    if(fav==1){
        $('#f_'+id).removeAttr('class').attr('class','favorites-star');
    }
    jQuery.post( "/sms/address-book-edit/" ,{favor: fav ,  id_favorites: id }   );
    if (fav==1){
        $("#f_"+id).attr("src","/img/star_event.png");
        $("#f_"+id).attr("onClick","favor(0,"+id+")");                                 
        $("#f_"+id).attr("onmouseover","$(\'#info_favor\').show()");
        $("#f_"+id).attr("onmouseout","$(\'#info_favor\').hide()");
    }
    if (fav==0){
        $("#f_"+id).attr("src","/img/star_noevent.png");
        $("#f_"+id).attr("onClick","favor(1,"+id+")");
        $("#f_"+id).attr("onmouseover","$(\'#info_favor1\').show()");
        $("#f_"+id).attr("onmouseout","$(\'#info_favor1\').hide()");
    }
}
</script>
{/literal}


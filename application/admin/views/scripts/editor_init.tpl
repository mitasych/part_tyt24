<script language="javascript" type="text/javascript" src="{$MODULE_URL}/js/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
{literal}	
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		language : "ru",
		elements : "content",
		editor_selector : "as-visual",
		plugins : "table,advimage,advhr,advlink,emotions,paste,directionality",
		theme_advanced_buttons1_add : "separator,forecolor,backcolor,rowseparator,fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "separator,emotions,separator,ltr,rtl",
		theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword",
		theme_advanced_buttons3_add_before: "separator,tablecontrols,advhr",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_source_editor_height : "550",
		theme_advanced_source_editor_width : "675",
		content_css : "{/literal}{$CSS_URL}/content3.css{literal}",
		/*external_link_list_url : "example_link_list.js",
		external_image_list_url : "example_image_list.js",
		media_external_list_url : "example_media_list.js",*/
		file_browser_callback : "ajaxfilemanager",
		
		
		theme_advanced_resizing : false,
		theme_advanced_resize_horizontal : false,
		
		theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
		paste_auto_cleanup_on_paste : true,
        paste_use_dialog : true,
		paste_convert_headers_to_strong : false,
		paste_strip_class_attributes : "all",
		
		advlink_styles :"PAMKA=promo_box_link_img",
		
		theme_advanced_disable : "help",
		debug : false,
		cleanup : true,
		cleanup_on_startup : false,
		safari_warning : false,
		gecko_spellcheck : "true",
		
		paste_remove_spans : false,
		paste_remove_styles : false,
		inline_styles : true,
		relative_urls : false //for image ... ajaxfilemanager
		//convert_urls : true
	});
	
	function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "../../../../js/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php?language=ru";
			switch (type) {
				case "image":
					break;
				case "media":
					break;
				case "flash": 
					break;
				case "file":
					break;
				default:
					return false;
			}
			var fileBrowserWindow = new Array();
			fileBrowserWindow["file"] = ajaxfilemanagerurl;
			fileBrowserWindow["title"] = "Ajax File Manager";
			fileBrowserWindow["width"] = "782";
			fileBrowserWindow["height"] = "440";
			fileBrowserWindow["close_previous"] = "no";
			tinyMCE.openWindow(fileBrowserWindow, {
			  window : win,
			  input : field_name,
			  resizable : "yes",
			  inline : "yes",
			  editor_id : tinyMCE.getWindowArg("editor_id")
			});
			
			return false;
		}
	
{/literal}	
</script>
<link rel="stylesheet" type="text/css" href="{$CSS_URL}/container.css" media="screen" />
<script type="text/javascript" src="{$JS_URL}/addImagePanelApp.js"></script>

<div id="addImagePanel" style="visibility:hidden; display:none; overflow: visible; ">
	<div class="hd">Добавление / изменение изображения</div>
    <div class="bd" id="addImagePanelContent" style="text-align:center;">
		
        
        <form id="addImagePanel_form" target="ifr1" action="{$user->getUserPath('blog.image.add')}" method="post" name="addImagePanel_form" enctype="multipart/form-data">          	<input type="hidden" id="addImagePanel_newsId" name="newsId" value="" />
        	<iframe name="ifr1" id="ifr1" width="100%" height="50" frameborder="0" scrolling="no"></iframe>
            <input id="addImagePanel_file" type="file" name="avatar" size="50" style="height:20px;" />
            
            <br />
            <input class="bottomer" style="cursor:pointer" onclick="document.forms['addImagePanel_form'].submit(); return false;" value="Отправить" />
            <input class="bottomer" style="cursor:pointer" onclick="addImageApp.hideAddImagePanel(); return false;" value="Закрыть" />
            
        </form>
        
        
    </div>
   
</div>
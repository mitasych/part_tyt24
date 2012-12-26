{literal}<style type="text/css">
table#my,table#my td
{
  border: solid 1px;
  margin: 5px;
  padding: 5px;
  border-collapse: collapse;
}
input{
width:99%;
padding:0px;
}
textarea {
width:99%;
}
embed{
width:99%;
}
</style>
{/literal}

<table id="my">
    <tr>
    <td >№:</td>
    <td style="width:200px">Название:</td>
    <td >Картинка?:</td>
    <td style="width:200px">Код:</td>
    <td>Путь к картинке:</td>
    <td>Ссылка для картинки:</td>
    <td>Количество показов:</td>
    
    <td title="если данный текст находится в URL то банер будет показан, что бы показать на всех страницах надо написать 'ALL', только для главной - пустое поле">Где показывать:</td>
    <td title="0-слева, 1-справа, 2-слева снизу, 3-справа снизу">Позиция:</td>
    <td title="больше число = выше на сайте">Приоритет:</td>
    <td>Активен?:</td>
    
    <td>Как будет выглядеть на сайте</td>
    <td>Обновить</td>
    <td><img src="/admin/images/edit.png"> </td>

    </tr>
{foreach from=$banners item=item}
       {form from=$form enctype="multipart/form-data"}
       {form_hidden name="id" value=$item->id}
<tr>
    <td>{$item->id}</td>
    
    <td>{form_text name="name" value=$item->name}</td>
  {*<td>{form_checkbox name="isimage" value="1" checked=$item->isimage}</td>*}
    <td>{form_select name="isimage" selected=$item->isimage options=$options2 }</td>
    {if $item->isimage}
    <td>{form_text name="code" value=$item->code style="display:none"}</td>
    <td>{form_file name="avatar" style="width:auto;" size="2" }</td>
    {else}
    <td>{form_text name="code" value=$item->code }</td>
    <td>{form_file name="avatar" style="width:auto;display:none" size="2" }</td>

    {/if}
    {if $item->isimage}
    <td>{form_text name="image_href" value=$item->image_href}</td>
    {else}
    <td>{form_text name="image_href" value=$item->image_href style="display:none"}</td>
    {/if}
    <td>{$item->count}</td>
    <td>{form_text name="key" value=$item->key}</td>
    <td>{form_select name="position" selected=$item->position options=$options }</td>
  {*<td>{form_text name="position" value=$item->position}</td> *}
    <td>{form_text name="priority" value=$item->priority}</td>
    <td>{form_checkbox name="isActive" value="1" checked=$item->isActive}</td>
    
    {if $item->isimage == 1}
    <td><a href="{$SITE_URL}/index/away/to/{$item->image_href}"><img src="{$IMG_URL2}/{$item->image_path}"/></a></td>
    {/if}
    {if $item->isimage == 0}
    <td>{$item->code2}</td>
    {/if}
    {if $item->isimage == 2}
    <td><embed src="{$IMG_URL2}/{$item->image_path}" quality="high"></embed></td>
    {/if}
    <td>{form_submit value="Обновить" class="batton"}</td>
    <td><a href="{$SITE_URL}/admin/controlls/banners.edit/edit/{$item->id}/"><img src="/admin/images/edit.png"></a></td>
       {/form}




</tr>



{/foreach}



{form from=$form enctype="multipart/form-data"}
       {form_hidden name="id"}
<tr>
    <td>Новый</td>

    <td>{form_text name="name"}</td>
    <td>{form_select name="isimage" selected=$item->isimage options=$options2 }</td>
   
    <td>{form_text name="code" }</td>
    <td>{form_file name="avatar" size="2"}</td>
   
 

    <td>{form_text name="image_href" }</td>



    <td>{}</td>
    <td>{form_text name="key" }</td>
    <td>{form_select name="position" selected=$item->position options=$options }</td>
    <td>{form_text name="priority" }</td>
    <td>{form_checkbox name="isActive" value="1" }</td>
   
    <td></td>
  
    <td>{}</td>
 
    <td>{form_submit value="Добавить" class="batton"}</td>
       {/form}
</tr>

</table>

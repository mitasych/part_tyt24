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
height:30px;
padding:0px;
}
</style>
{/literal}

<table id="my">
{foreach from=$banners item=item}
       {form from=$form enctype="multipart/form-data"}
       {form_hidden name="id" value=$item->id}
    <tr>
    <td >№:</td> <td>{$item->id}</td>
    <tr>
    <td style="width:200px">Название:</td>  <td>{form_text name="name" value=$item->name}</td>
    <tr>
    <td >Картинка?:</td> <td>{form_select name="isimage" selected=$item->isimage options=$options2 }</td>
    <tr>
    <td style="width:200px">Код:</td> {if $item->isimage} <td>{form_textarea name="code" value=$item->code style="display:none"}</td>  {else}  <td>{form_textarea name="code" value=$item->code }</td>    {/if}
    <tr>
    <td>Путь к картинке:</td> {if $item->isimage} <td>{form_file name="avatar" style="width:auto;" size="0" }</td>  {else}<td>{form_file name="avatar" style="width:auto;display:none" size="0" }</td>   {/if}
    <tr>
    <td>Ссылка для картинки:</td> {if $item->isimage} <td>{form_text name="image_href" value=$item->image_href}</td> {else} <td>{form_text name="image_href" value=$item->image_href style="display:none"}</td> {/if}
    <tr>
    <td>Количество показов:</td> <td>{$item->count}</td>
    <tr>

    <td title="если данный текст находится в URL то банер будет показан, что бы показать на всех страницах надо написать 'ALL', только для главной - пустое поле">Где показывать:</td> <td>{form_text name="key" value=$item->key}</td>
    <tr>
    <td title="0-слева, 1-справа, 2-слева снизу, 3-справа снизу">Позиция:</td>  <td>{form_select name="position" selected=$item->position options=$options }</td>
    <tr>
    <td title="больше число = выше на сайте">Приоритет:</td> <td>{form_text name="priority" value=$item->priority}</td>
    <tr>
    <td>Активен?:</td> <td>{form_checkbox style="width:1px; padding:0px; height:0px;" name="isActive" value="1" checked=$item->isActive}</td>
    <tr>

    <td>Как будет выглядеть на сайте</td>
      {if $item->isimage == 1}
    <td><a href="{$SITE_URL}/index/away/to/{$item->image_href}"><img src="{$IMG_URL2}/{$item->image_path}"/></a></td>
    {/if}
    {if $item->isimage == 0}
    <td>{$item->code2}</td>
    {/if}
    {if $item->isimage == 2}
    <td><embed src="{$IMG_URL2}/{$item->image_path}" quality="high"></embed></td>
    {/if}
    <tr>
    <td>Обновить</td> <td>{form_submit value="Обновить" class="batton"}</td>

       {/form}

{/foreach}


</table>

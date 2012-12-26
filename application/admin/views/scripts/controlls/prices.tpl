{literal}<style type="text/css">
table#my,table#my td
{
  border: solid 1px;
  margin: 5px;
  padding: 5px;
  border-collapse: separate;
}
</style>
{/literal}

  
<table id="my">
    <tr>
    <td>№:</td>
    <td>Цены: <span style="text-align:right"> (пример:)
<hr>
1:370;11:350;21:330;51:300
<hr>
это:
<br>
1 - 10 : 370 руб.
<br>
11 - 20 : 350 руб.
<br>
21 - 50 : 330 руб.
<br>
51 и более: 300 руб</span></td>
    <td>Товар:</td>
    <td>Обновить:</td>

    </tr>
{foreach from=$PricesList item=item}
       {form from=$form}
       {form_hidden name="id" value=$item->id}
<tr>
    <td>{$item->id}</td>
    <td>{form_text name="price" value=$item->price}</td>
    <td>{$item->title}</td>
    <td>{form_submit value="Обновить" class="batton"}</td>
       {/form}


</tr>

{/foreach}
</table>

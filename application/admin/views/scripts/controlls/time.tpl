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
    <td >№:</td>
    <td>Время поиска в секнуднах:</td>
    <td>Место:</td>
    <td>Поисковой запрос к базе:</td>
    
    </tr>
{foreach from=$time item=item}
<tr>
    <td>{$item->getId()}</td>
    <td>{$item->getTime()}</td>
    <td>{$item->getController()}</td>
    <td>{$item->getWhat()}</td>
    
    
    

</tr>

{/foreach}
</table>

{assign var="nid" value=$currentItem->getId()}

{form from=$form onsubmit="xajax_newsSave(xajax.getFormValues('dForm_$nid'), $nid); return false;" id="dForm_$nid"}

{form_errors_summary}

{form_hidden name="newsId" id="newsId" value=$currentItem->getId()}
    <div class="bottom">
         
         <p><b style="color:#FF0000">*</b>&nbsp;Заголовок:</p>
        {form_text name="title"|escape:html}
        
        <p><b style="color:#FF0000">*</b>&nbsp;Текст новости:</p>
        {form_textarea name="content"|escape:html}
    
        <br />
        {form_submit class="bottomer" name="form_save" value="Сохранить"}
    
    </div>
{/form}

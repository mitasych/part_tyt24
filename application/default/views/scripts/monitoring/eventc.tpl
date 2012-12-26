{literal}
<style>
		#t1 strong{
			color:#1f5863;
		}
</style>

<script type="text/javascript">


 jQuery(".m1").live( 'click',  function() {
                         var s;
                         fav = jQuery(".m1").attr('name');
                         id = jQuery(".m1").attr('data');

                         jQuery.post( "/monitoring/list/" ,{favor: fav ,  id_favorites: id }   );
                         if (fav ==0){
                          jQuery(".m1").attr('name','1');
                         jQuery(".m1").html('<img src="/img/star_noevent.png"> Добавить в избранное');
                           alert('Компания удалена из избранного');} else
                          if (fav == 1){
                          jQuery(".m1").attr('name','0');
                         jQuery(".m1").html('<img src="/img/star_event.png"> Удалить из избранного');
                        
                            alert('Компания добавлена в избранное');
                        
                        }
   

                        });



</script>

{/literal}


<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>

<div>
    <div class="main_top_text">

        {breadcrumb controller="monitoring" alias="monitoring" altTitle="Компания"}
        {include file="lmenu.tpl"}


                {if $favorites==1}

          <a style="float:right" href="javascript:void(0)" class="m1" name='0' data='{$id_kont}'>
              <img src="/img/star_event.png"> Удалить из избранного</a>
          {else}
 
            <a  style="float:right" href="javascript:void(0)" class="m1" name='1' data='{$id_kont}'>
               <img src="/img/star_noevent.png"> Добавить в избранное</a>

        {/if}
        <div id="t1">
			
           
         

            <p><strong>Наименование компании:</strong> {$kontrag->title|escape}</p>
			<p><strong>ИНН:</strong> {$kontrag->inn|escape}</p>   
            <p><strong>Страна:</strong> {$kontrag->country|escape}</p>
			<p><strong>Регион:</strong> {$kontrag->region|escape}</p>
            <p><strong>Отрасль:</strong> {$kontrag->otrasl|escape}</p>
            <p><strong>Адрес:</strong> {$kontrag->adress|escape}</p>
            <p><strong>ФИО директора:</strong> {$kontrag->rykov|escape}</p>
            <p><strong>Дата регистрации:</strong> {$kontrag->reg_date|escape}</p>



   
            <table border=1>
            <tbody>
              <tr>
                <td>Дата события</td>
   
               <td>Дата мониторинга</td>
 

              <td>Описания</td>
 

              <td>Тип</td>
            </tr>
            {foreach from=$kontrag->getAllEvent() item=tmp}
            <tr>
            <td>
            {$tmp.date_created|date_format:"%Y.%m.%d"}
            </td>
            <td>
            {$tmp.event_date|date_format:"%Y.%m.%d"}
            </td>
            <td>
            {$tmp.content}
            </td>
            <td>
            {$kontrag->getEventType($tmp.type_id)}
            </td>
            
            </tr>
            {/foreach}

          </tbody>
        </table>

        </div>


        <div class="dotted2">


        </div>
    </div>
</div>
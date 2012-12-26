<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>
<div>
    <div class="main_top_text">
        {breadcrumb controller="info" alias="searchdoc" title='' altTitle="Поиск"}
        <h1>{info name="searchdoc" what="title"}</h1>
        <p>{info name="searchdoc"}</p>



        
        {$searchinfo}




        <div class="dotted2"></div>
    </div>
</div>
</div>
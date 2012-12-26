<div class="right_part2">
    <div class="bg_ie">
    </div>

    <div>
        <div class="main_top_text">

            {breadcrumb controller="info" alias="orderCreated" title='' altTitle="Поиск заказа"}

            <h1>{info name="zakazindex" what="title"}</h1>
            <p>{info name="zakazindex"}</p>

            {form from=$form}
            <p>{form_errors_summary}</p>


            <p><span style="margin-bottom:3px; line-height:16px;">Введите № заказа/счета:</span><br />
                {form_text name="code"}
            </p>

            <p>{form_submit name="submitb" id="submitb" value="Найти" }</p>

            {/form}

            <div class="dotted2"></div>
        </div>
    </div>
</div>
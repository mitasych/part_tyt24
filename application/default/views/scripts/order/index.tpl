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


            <br />
                <div class="style_input" style="display: inline-block;">
                {form_text name="code" placeholder="Введите № заказа/счета"}
                </div>
            




           
                <div class="addx2" style="display: inline-block;">
                {form_submit name="submitb" id="sortStatus_b" value="Найти" }
                </div>
           

            {/form}



            <div class="dotted2"></div>
        </div>
    </div>
</div>
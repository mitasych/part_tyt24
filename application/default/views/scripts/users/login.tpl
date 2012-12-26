<div class="right_part2">
    <div class="bg_ie">
    </div>

    <div>
        <div class="main_top_text">

            {breadcrumb controller="info" alias="userLogin" title='' altTitle="Вход в личный кабинет"}

            <h1>Вход в личный кабинет</h1>

            {form from=$form}
            {form_errors_summary}
            <div class="bottom">
                <br />
                <span style="margin-bottom:3px; line-height:16px;">Имя пользователя</span><br />
                {form_text name="login"}
                <br /><br />
                <span style="margin-bottom:3px; line-height:16px;">Пароль</span><br />
                {form_password name="pass"}
                <br />
                <a href="{$SITE_URL}/remember/">Забыли пароль</a>
                <br />
                {form_submit name="submitb" name="Войти" value="Войти" class="bottomer"}
            </div>
            {/form}
            <div class="dotted2" style="height:400px"></div>
        </div>
    </div>
</div>
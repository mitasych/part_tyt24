<div>
    <div class="main_top_text">

        {form from=$form}
        {form_errors_summary}


        <b>Данные о компании</b>
        <div>
            <table>
                <tr>
                    <td>
                        <p><span class="error_point">*</span>Название Компании<br />
                            {form_text name="name"}</p>
                    </td>
                    <td>
                        <p><span class="error_point">*</span>ИНН<br />
                            {form_text name="inn"}</p>
                    </td>
                    <td>
                    <p><span class="error_point">*</span>Email адрес<br />
                        {form_text name="email"}</p>
                    </td>
                    <td><p>Телефон/Факс<br />
                        {form_text name="phone"}</td></p>
                </tr>
            </table>


        <p>&nbsp;</p>
        {form_submit name="submitb" value="Сохранить"}
        <p>&nbsp;</p>
        {/form}


        <div class="dotted2"></div>

</div>
</div>
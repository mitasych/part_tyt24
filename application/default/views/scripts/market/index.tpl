
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td class="branch_li">
                <h1>Категории</h1>
                <ul class="brunch">
                      {foreach item=c from=$categoryList key=k}
                        <li><a href="?catId={$c->CategoryId}">{$c->CategoryName}</a>
                        <ul>
                              {foreach item=sub from=$c->findDependentRowset('Tyt24_Models_MarketSubCategory')}
                                <li><a href="?sCatId={$sub->SubCategoryId}">{$sub->SubCategoryName}</a></li>
                              {/foreach}
                        </ul>
                        </li>
                        
                        {if $k + 1 > $categoryList|@count / 2}
                </ul>
                <ul class="brunch">
                        {/if}
                      {/foreach}
                </ul>
            </td>
            <td class="region_li">
                <h1>Регионы</h1>
                <ul class="brunch">
                    {foreach item=c from=$regions key=k}
                    <li><a href="#">Добывающая и топливно-энергетическая промышленность</a>
                        <ul>
                            <li><a href="#">Газ. Производство, доставка и оборудование,</a></li>
                            <li><a href="#">Добыча сырьевых ресурсов для промышленности ...</a></li>
                        </ul>
                    </li>
                    {/foreach}
                    <li><a href="#">Легкая промышленность</a>
                        <ul>
                            <li><a href="#">Кожа и меха. Изделия из кожи и меха,</a></li>
                            <li><a href="#">Текстиль ...</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Лесная промышленность. Мебель и продукция деревообработки</a>
                        <ul>
                            <li><a href="#">Лесная промышленность, </a></li>
                            <li><a href="#">Мебель ...</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Машиностроение</a>
                        <ul>
                            <li><a href="#">Автомобилестроение, </a></li>
                            <li><a href="#">Машиностроение для пищевой и легкой промышленности, бытовая техника ...</a></li>
                        </ul>
                    </li>
                    <li>
                </ul>
            </td>
            <td class="news">
                <h1>новости</h1>
                <ul>
                    <li><p>01 окт 2010 12:26</p><a href="#">Прокуратура Петербурга направила документы для экстрадиции националиста Дацика... </a></li>
                    <li><p>01 окт 2010 12:26</p><a href="#">Московский следователь отдан под суд за незаконное изъятие товаров на 450 млн рублей...  </a></li>
                </ul>
                <a href="#" class="banner"><img src="img/main_banner1.png" /></a>
                <a href="#" class="banner"><img src="img/main_banner2.png" /></a>

            </td>
        </tr>
    </table>






<div class="right_part2" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
     <div class="bg_ie" {if $currentInfo->pic}style="background-image:url('/images/{$currentInfo->pic}.jpg');"{/if}>
</div>
<div>
    <div class="main_top_text">
        {breadcrumb controller="info" alias="searchdoc" title='' altTitle="Поиск"}
        <h1>{info name="searchdoc" what="title"}</h1>
        <p>{info name="searchdoc"}</p>



        <center>
            <form name='f' id='f' action="/info/searchdoc/" method="POST" class=small>

                <input type=hidden name="Act" value="2" class=small>
                <input type=hidden name="RCode" value="0" class=small>


                <tr>
                    <td align="center" style="">

                        <table bgcolor = "#e1f2ea" style = "border: 1px #6f7c87 solid;" width = "750" cellpadding = "0" cellspacing = "1" align = "center" border = "0">

                            <tr>
                                <td>&nbsp;</td>
                                <td height="33" style = "border-bottom: 1px #6f7c87 solid;">Принявший&nbsp;орган</td>
                                <td>&nbsp;&nbsp;</td>
                                <td style = "border-bottom: 1px #6f7c87 solid;">
                                    <select class="fine" style="width: 283px;" name="OrganList" size="1" id="c1">
                                        <option selected value=0><option value=47>Высший арбитражный суд РФ<option value=53>Генеральная прокуратура РФ<option value=6>Госкомстат РФ<option value=11>Госстандарт РФ<option value=8>Государственная Дума Федерального Собрания РФ<option value=1>Государственный таможенный комитет РФ<option value=18>ГОХРАН РФ<option value=5>Конституционный Суд РФ<option value=12>МВД РФ<option value=31>МИД РФ<option value=13>Минздрав РФ<option value=32>Минздравсоцразвития РФ<option value=55>Минкомсвязь РФ<option value=33>Минобороны РФ<option value=54>Минобрнауки РФ<option value=48>Минпромторг РФ<option value=24>Минпромэнерго РФ<option value=15>Минсельхоз РФ<option value=7>Минтранс РФ<option value=3>Минфин РФ<option value=50>Минэнерго РФ<option value=26>Минюст РФ<option value=14>МНС РФ<option value=45>МЧС РФ<option value=9>Правительство РФ<option value=10>Президент РФ<option value=41>Росатом<option value=35>Росздрав<option value=34>Роскартография<option value=36>Роскосмос<option value=51>Роснедра<option value=37>Рособразование<option value=38>Роспечать<option value=23>Роспотребнадзор<option value=46>Росприроднадзор<option value=39>Роспром<option value=42>Россельхознадзор<option value=40>Росспорт<option value=19>Ростехрегулирование<option value=43>Служба внешней разведки РФ<option value=49>Совет руководителей таможенных служб государств - участников СНГ<option value=21>Таможенный комитет Союзного государства<option value=25>ФАПРИД<option value=27>Федеральная служба безопасности РФ<option value=28>Федеральная служба охраны РФ<option value=29>Федеральная служба РФ по контролю за оборотом наркотиков<option value=20>Федеральная служба судебных приставов<option value=16>Федеральная таможенная служба<option value=52>Федеральное казначейство<option value=30>ФНС РФ<option value=44>ФСИН РФ<option value=2>Центральный банк РФ<option value=22>Экономический совет СНГ

                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td height="33" style = "border-bottom: 1px #6f7c87 solid;">Вид&nbsp;документа</td>
                                <td>&nbsp;&nbsp;</td>
                                <td style = "border-bottom: 1px #6f7c87 solid;">
                                    <select class="fine" style="width: 283px;" name="DocTypeList" size="1" id="c1">
                                        <option selected value=0><option value=13>Договор<option value=19>Закон<option value=6>Инструкция<option value=9>Информация<option value=28>Классификатор<option value=17>Кодекс<option value=33>Конвенция<option value=16>Концепция<option value=20>Методика<option value=7>Методические рекомендации<option value=22>Методические указания<option value=34>Наставление<option value=29>Обзор<option value=36>Основные положения<option value=8>Перечень<option value=2>Письмо<option value=5>Положение<option value=4>Порядок<option value=15>Постановление<option value=10>Правила<option value=1>Приказ<option value=25>Программа<option value=24>Протокол<option value=32>Разъяснения<option value=3>Распоряжение<option value=27>Регламент<option value=11>Реестр<option value=23>Рекомендации<option value=14>Решение<option value=30>Сборник<option value=31>Соглашение<option value=37>Справка<option value=35>Телеграмма<option value=26>Требования<option value=18>Указ<option value=21>Указание

                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td height="33">Дата&nbsp;принятия</td>
                                <td>&nbsp;&nbsp;</td>
                                <td >от&nbsp;
                                    <select class="fine" size="1" name="DPrBD" id="c1">
                                        <option selected value=0><option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10<option value=11>11<option value=12>12<option value=13>13<option value=14>14<option value=15>15<option value=16>16<option value=17>17<option value=18>18<option value=19>19<option value=20>20<option value=21>21<option value=22>22<option value=23>23<option value=24>24<option value=25>25<option value=26>26<option value=27>27<option value=28>28<option value=29>29<option value=30>30<option value=31>31

                                    </select>
                                    &nbsp;
                                    <select class="fine" size="1" name="DPrBM" id="c1">
                                        <option selected value=0></option><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option><option value=6>6</option><option value=7>7</option><option value=8>8</option><option value=9>9</option><option value=10>10</option><option value=11>11</option><option value=12>12</option>
                                    </select>

                                    &nbsp;
                                    <select class="fine" size="1" name="DPrBY" id="c1">
                                        <option selected value=0></option><option value=1990>1990</option><option value=1991>1991</option><option value=1992>1992</option><option value=1993>1993</option><option value=1994>1994</option><option value=1995>1995</option><option value=1996>1996</option><option value=1997>1997</option><option value=1998>1998</option><option value=1999>1999</option><option value=2000>2000</option><option value=2001>2001</option><option value=2002>2002</option><option value=2003>2003</option><option value=2004>2004</option><option value=2005>2005</option><option value=2006>2006</option><option value=2007>2007</option><option value=2008>2008</option><option value=2009>2009</option><option value=2010>2010</option>

                                    </select>&nbsp;года&nbsp;&nbsp;
                                    <input value="ON" name="DPrBOnly" type="checkbox" id="c1" >&nbsp;только&nbsp;эту&nbsp;дату</td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td height="33" style = "border-bottom: 1px #6f7c87 solid;">&nbsp;</td>
                                <td>&nbsp;&nbsp;</td>
                                <td style = "border-bottom: 1px #6f7c87 solid;">до&nbsp;
                                    <select class="fine" size="1" name="DPrED" id="c1">
                                        <option selected value=0><option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10<option value=11>11<option value=12>12<option value=13>13<option value=14>14<option value=15>15<option value=16>16<option value=17>17<option value=18>18<option value=19>19<option value=20>20<option value=21>21<option value=22>22<option value=23>23<option value=24>24<option value=25>25<option value=26>26<option value=27>27<option value=28>28<option value=29>29<option value=30>30<option value=31>31

                                    </select>
                                    &nbsp;
                                    <select class="fine" size="1" name="DPrEM" id="c1">
                                        <option selected value=0></option><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option><option value=6>6</option><option value=7>7</option><option value=8>8</option><option value=9>9</option><option value=10>10</option><option value=11>11</option><option value=12>12</option>
                                    </select>

                                    &nbsp;
                                    <select class="fine" size="1" name="DPrEY" id="c1">
                                        <option selected value=0></option><option value=1990>1990</option><option value=1991>1991</option><option value=1992>1992</option><option value=1993>1993</option><option value=1994>1994</option><option value=1995>1995</option><option value=1996>1996</option><option value=1997>1997</option><option value=1998>1998</option><option value=1999>1999</option><option value=2000>2000</option><option value=2001>2001</option><option value=2002>2002</option><option value=2003>2003</option><option value=2004>2004</option><option value=2005>2005</option><option value=2006>2006</option><option value=2007>2007</option><option value=2008>2008</option><option value=2009>2009</option><option value=2010>2010</option>

                                    </select>&nbsp;года</td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td height="33" style = "border-bottom: 1px #6f7c87 solid;">Номер&nbsp;документа</td>
                                <td>&nbsp;&nbsp;</td>
                                <td style = "border-bottom: 1px #6f7c87 solid;"><input value="" class="fine" style="width: 283px;" maxlength="35" size="30" name="DocNum" id="c1"></td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td height="33" style = "border-bottom: 1px #6f7c87 solid;">Название&nbsp;документа</td>

                                <td>&nbsp;&nbsp;</td>
                                <td style = "border-bottom: 1px #6f7c87 solid;"><input value="" class="fine" style="width: 283px;" maxlength="70" size="30" name="DocName" id="c1"></td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td height="33" style = "border-bottom: 1px #6f7c87 solid;">Номер&nbsp;в&nbsp;Минюсте</td>
                                <td>&nbsp;&nbsp;</td>
                                <td style = "border-bottom: 1px #6f7c87 solid;"><input value="" class="fine" style="width: 283px;" maxlength="20" size="30" name="MinNum" id="c1"></td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td height="33">Дата&nbsp;в&nbsp;Минюсте</td>

                                <td>&nbsp;&nbsp;</td>
                                <td>от&nbsp;
                                    <select class="fine" size="1" name="DMBD" id="c1">
                                        <option selected value=0><option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10<option value=11>11<option value=12>12<option value=13>13<option value=14>14<option value=15>15<option value=16>16<option value=17>17<option value=18>18<option value=19>19<option value=20>20<option value=21>21<option value=22>22<option value=23>23<option value=24>24<option value=25>25<option value=26>26<option value=27>27<option value=28>28<option value=29>29<option value=30>30<option value=31>31

                                    </select>
                                    &nbsp;
                                    <select class="fine" size="1" name="DMBM" id="c1">
                                        <option selected value=0></option><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option><option value=6>6</option><option value=7>7</option><option value=8>8</option><option value=9>9</option><option value=10>10</option><option value=11>11</option><option value=12>12</option>
                                    </select>

                                    &nbsp;
                                    <select class="fine" size="1" name="DMBY" id="c1">
                                        <option selected value=0></option><option value=1990>1990</option><option value=1991>1991</option><option value=1992>1992</option><option value=1993>1993</option><option value=1994>1994</option><option value=1995>1995</option><option value=1996>1996</option><option value=1997>1997</option><option value=1998>1998</option><option value=1999>1999</option><option value=2000>2000</option><option value=2001>2001</option><option value=2002>2002</option><option value=2003>2003</option><option value=2004>2004</option><option value=2005>2005</option><option value=2006>2006</option><option value=2007>2007</option><option value=2008>2008</option><option value=2009>2009</option><option value=2010>2010</option>

                                    </select>&nbsp;года&nbsp;&nbsp;
                                    <input value="ON" name="DMBOnly" type="checkbox" id="c1" >&nbsp;только&nbsp;эту&nbsp;дату</td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td height="33" style = "border-bottom: 1px #6f7c87 solid;">&nbsp;</td>
                                <td>&nbsp;&nbsp;</td>
                                <td style = "border-bottom: 1px #6f7c87 solid;">до&nbsp;
                                    <select class="fine" size="1" name="DMED" id="c1">
                                        <option selected value=0><option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10<option value=11>11<option value=12>12<option value=13>13<option value=14>14<option value=15>15<option value=16>16<option value=17>17<option value=18>18<option value=19>19<option value=20>20<option value=21>21<option value=22>22<option value=23>23<option value=24>24<option value=25>25<option value=26>26<option value=27>27<option value=28>28<option value=29>29<option value=30>30<option value=31>31

                                    </select>
                                    &nbsp;
                                    <select class="fine" size="1" name="DMEM" id="c1">
                                        <option selected value=0></option><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option><option value=6>6</option><option value=7>7</option><option value=8>8</option><option value=9>9</option><option value=10>10</option><option value=11>11</option><option value=12>12</option>
                                    </select>

                                    &nbsp;
                                    <select class="fine" size="1" name="DMEY" id="c1">
                                        <option selected value=0></option><option value=1990>1990</option><option value=1991>1991</option><option value=1992>1992</option><option value=1993>1993</option><option value=1994>1994</option><option value=1995>1995</option><option value=1996>1996</option><option value=1997>1997</option><option value=1998>1998</option><option value=1999>1999</option><option value=2000>2000</option><option value=2001>2001</option><option value=2002>2002</option><option value=2003>2003</option><option value=2004>2004</option><option value=2005>2005</option><option value=2006>2006</option><option value=2007>2007</option><option value=2008>2008</option><option value=2009>2009</option><option value=2010>2010</option>

                                    </select>&nbsp;года</td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td height="33" style = "border-bottom: 1px #6f7c87 solid;">Порядок сортировки списка документов</td>
                                <td>&nbsp;&nbsp;</td>
                                <td style = "border-bottom: 1px #6f7c87 solid;">
                                    <select class="fine" style="width: 283px;" name="Order1" size="1" id="c1">
                                        <option value="DatePr|UP">по дате принятия - по возрастанию</option><option value="DatePr|DOWN" selected>по дате принятия - по убыванию</option><option value="DocName|UP">по названию - в алфавитном порядке</option><option value="DocName|DOWN">по названию - в обратном алфавитном порядке</option>
                                    </select></td>

                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td height="33">Число документов списка, <br>показываемых в окне броузера</td>
                                <td>&nbsp;&nbsp;</td>
                                <td>
                                    <select class="fine" name="RecInPage" size="1" id="c1">
                                        <option value="10">10</option><option value="30" selected>30</option><option value="50">50</option><option value="100">100</option>
                                    </select></td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td height="33">&nbsp;</td>
                                <td>&nbsp;&nbsp;</td>
                                <td>&nbsp;</td>

                            </tr>
                        </table>



                    </td>
                </tr>

                <tr>
                    <td bgcolor="#FFFFFF"><img width="1" alt="" src=".//common/images/void.gif"></td>

                </tr>
                <tr>
                    <td align="center">

                        <table border="0" height="28" cellspacing="1" cellpadding="1" width = "750" style = "border: 1px #6f7c87 solid;">
                            <tr>
                                <td width = 50% align = right><a href="" style="vertical-align:bottom"><img src="/images/sdoc/clear.gif" border="0" alt="очистить">
                                    </a>
                                </td>
                                <td width = 50% align = left><input border="0" value="Найти" alt="искать" src="/images/sdoc/find_doc.gif" type="Image" id="c1">
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
                <tr>

                    <td bgcolor="#FFFFFF" height="1"><img height="1" alt="" src=".//common/images/void.gif"></td>
                </tr>

                <tr>
                    <td>




                        <input type="hidden" name="PCrt" value="1">
                        <input type="hidden" name="PCnt" value="1">
            </form>
        </center>
        <br /><br />
        {$tableData}




        <div class="dotted2"></div>
    </div>
</div>
</div>
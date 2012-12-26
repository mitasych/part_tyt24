<?php

function get_page($url,$data=null,$options=null) {
    $process = curl_init($url);
    curl_setopt($process, CURLOPT_HEADER,0);
    if(!is_null($data)) {
        curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_POSTFIELDS, $data);
    }
    if(!is_null($options))curl_setopt_array($process,$options);
    curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($process, CURLOPT_COOKIEFILE, 'cookiefile');
    curl_setopt($process, CURLOPT_COOKIEJAR, 'cookiefile');
    curl_setopt($process, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5');
    @curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
    $return = curl_exec($process);
    curl_close($process);
    return $return;
}

$mycontent = '';

if(empty($_POST['ok']) and empty($_POST['ok2'])) {
    $arr = file(DOCUMENT_ROOT.'/scripts/db/states.txt');


    $mycontent.='<a href="javascript:void(0);" onclick="return bookmark(this);">Добавить в избранное</a><br /><br />';

    $mycontent.='<form action="" method=POST>Откуда: <select name="country1"
    onchange="setCity1(this.options[this.selectedIndex].value)" style="width:200px; font-size:10pt; margin-left:5px;">';
    $mycontent.='<option value="00">--Выберите страну--</option>';
    foreach($arr as $ar) {
        $a = explode('|', trim($ar));
        $mycontent.='<option value="'.trim($a[1]).'">'.trim($a[0]).'</option>';
    }
    $mycontent.='</select><br><select id="city1" name="city1" style="width:200px; font-size:10pt; margin-left:50px;">';
    $mycontent.='<option value="00">--Выберите город--</option>';
    $mycontent.='</select><br>Куда: <select name="country2" style="width:200px; font-size:10pt; margin-left:18px;"
        onchange="setCity2(this.options[this.selectedIndex].value)">';
    $mycontent.='<option value="00">--Выберите страну--</option>';
    foreach($arr as $ar) {
        $a = explode('|', trim($ar));
        $mycontent.='<option value="'.trim($a[1]).'">'.trim($a[0]).'</option>';
    }
    $mycontent.='</select><br><select id="city2" name="city2" style="width:200px; font-size:10pt; margin-left:50px;">';
    $mycontent.='<option value="00">--Выберите город--</option>';
    $mycontent.='</select><br><br><input type="hidden" name="ok" value="1" /><input border="0" width="83" type="image" height="21" src="/images/rasst/button_rasst.gif" name="oki" style="margin-left:100px;"></form>';
}
if(!empty($_POST['ok']) or !empty($_POST['ok2'])) {
    if(!empty($_POST['ok'])) {
        $p = get_page('http://www.issa.ru/netcat/modules/distance/', 'from_state='.$_POST['country1'].'&from_city='.$_POST['city1'].'&to_state='.$_POST['country2'].'&to_city='.$_POST['city2']);
         $p = iconv('cp1251', 'utf-8', $p);
    }
    if(!empty($_POST['ok2'])) {
        $post = '';
        $i = 0;
        while($i < 100) {
            if(!empty($_POST['ex_city_f'][$i])) {
                if($post != '') $post = $post."&";
                $post = $post.'ex_city_f%5B'.$i.'%5D='.$_POST['ex_city_f'][$i];
            }
            $i++;
        }

        $p = get_page('http://www.issa.ru/netcat/modules/distance/', $post.
                        ((!empty($_POST['num_city']))?('&num_city='.$_POST['num_city']):('')).
                        ((!empty($_POST['to_city']))?('&to_city='.$_POST['to_city']):('')).
                        ((!empty($_POST['from_city']))?('&from_city='.$_POST['from_city']):('')).
                        ((!empty($_POST['ex_sel']))?('&ex_city=&ex_sel='.$_POST['ex_sel']):('')).
                        ((!empty($_POST['c_id']))?('&c_id='.$_POST['c_id']):('')).
                        ((!empty($_POST['ex_country']))?('&ex_country='.$_POST['ex_country']):('')) );
       
        $p = iconv('cp1251', 'utf-8', $p);
        //print_r($_POST);
        //die();                                                           //
    }
    preg_match('/(.+)<FORM ACTION/isU', $p, $t);
    $p = str_replace($t[1], '', $p);
    preg_match('/<CENTER><A HREF="\.\/".+<\/html>/isU', $p, $t);
    $p = str_replace($t[0], '', $p);
    $p = str_replace('="images/', '="/images/rasst/', $p);
    $p = preg_replace('/font-size:\s*14px/mi', 'font-size: 12px', $p);
    $p = preg_replace('/\<b\>/mi', '<b style="font-size: 12px">', $p);
    $p = preg_replace('/\#CC0000/mi', '#FE0000', $p);
    //$p = preg_replace('/WIDTH=39 HEIGHT=33/mi', 'WIDTH=70 HEIGHT=70', $p);

    $p = str_replace('<INPUT TYPE="submit" VALUE="Пересчитать" CLASS=distancebutton2>', '<input type="hidden" name="ok2" value="1" /><input border="0" width="83" type="image" height="21" src="/images/rasst/button_rasst.gif" name="oki">', $p);
    $mycontent.='<form action="" method=POST>'.str_replace('<FORM ACTION="./" METHOD=POST NAME=form2 STYLE="padding:0px; margin:0px;">', '', str_replace('</FORM>', '', $p)).'</form><br><center><a href="rasst.php">Рассчитать новый маршрут</a></center>';

}

$this->view->mycontent = $mycontent;
$currentInfo = new AK_Article_Item();
$currentInfo->loadByRewriteName('rasst');
$this->view->currentInfo = $currentInfo;
if ($currentInfo->getMetaTitle()) {
    $this->view->TITLE = $currentInfo->getMetaTitle();
} elseif ($currentInfo->getTitle()) $this->view->TITLE = $currentInfo->getTitle();
if ($currentInfo->getMetaKeywords()) {
    $this->view->KEYWORDS = $currentInfo->getMetaKeywords();
}
if ($currentInfo->getMetaDescription()) {
    $this->view->DESCRIPTION = $currentInfo->getMetaDescription();
}
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

$p = get_page('http://www.alta.ru/valuta/graph/graph_xml.php?840=on&978=on&per=month');
$p = preg_replace('/<license>(.*)<\/license>/mi', '', $p);
$p = preg_replace('/<image url=\'http:\/\/www\.alta\.ru(.*)?\/>/mi', "<image url='".IMG_URL."/logotype1.jpg' x='288' y='7' />", $p);

$p = preg_replace('/<link>(.*)<\/link>/mi', "<link><area x='0' y='0' width='580' height='470'  url='".SITE_URL."/info/valutagrafic/' /></link>", $p);

echo $p;
exit;
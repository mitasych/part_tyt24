<?php

set_time_limit(0);
$o = PREG_SET_ORDER;

function get_page($url,$data=null,$options=null)
{
	$process = curl_init($url);
	curl_setopt($process, CURLOPT_HEADER,0);
	if(!is_null($data))
	{
		curl_setopt($process, CURLOPT_POST, 1);
		curl_setopt($process, CURLOPT_POSTFIELDS, $data);
	}
	if(!is_null($options))curl_setopt_array($process,$options);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($process, CURLOPT_COOKIEFILE, 'tmp/cookiefile');
	curl_setopt($process, CURLOPT_COOKIEJAR, 'tmp/cookiefile');
	curl_setopt($process, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5');
	@curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
	$return = curl_exec($process);
	curl_close($process);
	return $return;
}

$p = get_page('http://customs.consultant.ru/doc.asp?ID='.$_GET['id'].'&PSC=10&PT=1&Page=1');

preg_match('/href="(zip\/\d+\/\d+.zip)"/iU', $p, $t);
$p = str_replace($t[1], 'http://customs.consultant.ru/'.$t[1], $p);

preg_match_all('/href="(images.+tif)">/iU', $p, $tifs, $o);

foreach($tifs as $t) $p = str_replace($t[1], 'http://customs.consultant.ru/'.$t[1], $p);

preg_match_all('/<img class=PNG src="(images.+(\d+\.png))"/iU', $p, $scans, $o);

foreach($scans as $s)
{
	if(!file_exists(DOCUMENT_ROOT."/uploaded/docs/".$s[2]))
	{
    	copy("http://customs.consultant.ru/".$s[1], DOCUMENT_ROOT."/uploaded/docs/".$s[2]);
	}
	$p = str_replace($s[1], '/uploaded/docs/'.$s[2], $p);
}

$this->view->doccontent = iconv('cp1251', 'utf-8', $p);
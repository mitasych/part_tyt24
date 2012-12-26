<?php

if( !empty($_POST['PCrt']) or !empty($_GET['PCrt']))
{
	if(!empty($_GET['PCrt']))
	{
		$_POST = $_GET;
		$_POST['PCrt'] = $_GET['PCrt'];
		$_POST['PCnt'] = $_GET['PCnt'];
	}
	else{
		$_POST['PCrt'] = 1;
		$_POST['PCnt'] = 1;
	}
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
			//parser_sleep();
			return $return;
		}

  	foreach ($_POST as $key=>$value) $_POST[$key]=urlencode($value);

    $post = 'Act='.$_POST['Act'].'&RCode='.$_POST['RCode'].'&OrganList='.$_POST['OrganList'].'&DocTypeList='.$_POST['DocTypeList'].'&DPrBD='.$_POST['DPrBD'].'&DPrBM='.$_POST['DPrBM'].'&DPrBY='.$_POST['DPrBY'].'&DPrED='.$_POST['DPrED'].'&DPrEM='.$_POST['DPrEM'].'&DPrEY='.$_POST['DPrEY'].'&DocNum='.$_POST['DocNum'].'&DocName='.$_POST['DocName'].'&MinNum='.$_POST['MinNum'].'&DMBD='.$_POST['DMBD'].'&DMBM='.$_POST['DMBM'].'&DMBY='.$_POST['DMBY'].'&DMED='.$_POST['DMED'].'&DMEM='.$_POST['DMEM'].'&DMEY='.$_POST['DMEY'].'&Order1='.$_POST['Order1'].'&RecInPage='.$_POST['RecInPage'].'&x=28&y=7&PCrt='.$_POST['PCrt'].'&PCnt='.$_POST['PCnt'];

    $p = get_page('http://customs.consultant.ru/esearch.asp', $post);

	if(preg_match('/<span class=Attention>Документы по запросу не найдены<\/span>/iU', $p))
	{
    	preg_match('/<table class=medium cellpadding=3 cellspacing=2.+<\/table>/isU', $p, $t);
    	$t[0] = str_replace("info.asp", "/info/searchinfo/", $t[0]);
    	$t[0] = str_replace("help.asp#card", "/info/searchhelp/", $t[0]);
    	$this->view->tableData =  iconv('cp1251', 'utf-8', "<center>".$t[0]."</center>");
	}
	else{
		preg_match('/<table width = 750>.+<\/table>/isU', $p, $t);

		preg_match('/<table width=750 border=0 cellspacing=1 cellpadding=3>.*table>/isU', $p, $tables);
		$table = str_replace('.//common/images/arr_ora.gif', '/images/sdoc/arr_ora.gif', $tables[0]);
		preg_match_all('/href="(zip\/\d+\/\d+\.zip)"/iU', $table, $zips, $o);

		foreach($zips as $z) $table = str_replace($z[1], 'http://customs.consultant.ru/'.$z[1], $table);
		preg_match_all('/href="(doc.asp\?ID=(.+))"/iU', $table, $links, $o);
		foreach($links as $l) $table = str_replace($l[1], '/info/searchview/?id='.$l[2], $table);
		$table = $t[0]."<br>".$table;

		$pagenavi = '<center>';
		if(preg_match('/Начало<\/a>/iU', $p))
		{
			$pagenavi = $pagenavi.'<a href="/info/searchdoc/?'.'Act='.$_POST['Act'].'&RCode='.$_POST['RCode'].'&OrganList='.$_POST['OrganList'].'&DocTypeList='.$_POST['DocTypeList'].'&DPrBD='.$_POST['DPrBD'].'&DPrBM='.$_POST['DPrBM'].'&DPrBY='.$_POST['DPrBY'].'&DPrED='.$_POST['DPrED'].'&DPrEM='.$_POST['DPrEM'].'&DPrEY='.$_POST['DPrEY'].'&DocNum='.$_POST['DocNum'].'&DocName='.$_POST['DocName'].'&MinNum='.$_POST['MinNum'].'&DMBD='.$_POST['DMBD'].'&DMBM='.$_POST['DMBM'].'&DMBY='.$_POST['DMBY'].'&DMED='.$_POST['DMED'].'&DMEM='.$_POST['DMEM'].'&DMEY='.$_POST['DMEY'].'&Order1='.$_POST['Order1'].'&RecInPage='.$_POST['RecInPage'].'&x=28&y=7&PCrt=1&PCnt=1">&lt;&lt; Начало</a>';
		}
		if(preg_match('/\&lt; Назад<\/a>/iU', $p))
		{
			preg_match('/Показаны:.*<td><span class="light2">(\d+)\s/isU', $p, $t);
			$rc1 = round($t[1]/30, 0)+1;
			$rc2 = round($t[1]/30, 0)+2;
			$pagenavi = $pagenavi.'<a href="/info/searchdoc/?'.'Act=3&RCode=2&OrganList='.$_POST['OrganList'].'&DocTypeList='.$_POST['DocTypeList'].'&DPrBD='.$_POST['DPrBD'].'&DPrBM='.$_POST['DPrBM'].'&DPrBY='.$_POST['DPrBY'].'&DPrED='.$_POST['DPrED'].'&DPrEM='.$_POST['DPrEM'].'&DPrEY='.$_POST['DPrEY'].'&DocNum='.$_POST['DocNum'].'&DocName='.$_POST['DocName'].'&MinNum='.$_POST['MinNum'].'&DMBD='.$_POST['DMBD'].'&DMBM='.$_POST['DMBM'].'&DMBY='.$_POST['DMBY'].'&DMED='.$_POST['DMED'].'&DMEM='.$_POST['DMEM'].'&DMEY='.$_POST['DMEY'].'&Order1='.$_POST['Order1'].'&RecInPage='.$_POST['RecInPage'].'&x=28&y=7&PCrt='.$rc1.'&PCnt='.$rc2.'">&lt; Назад</a></a>';
		}
		if(preg_match('/Вперед \&gt;<\/a>/iU', $p))
		{
			preg_match('/Показаны:.*<td><span class="light2">(\d+)\s/isU', $p, $t);
			$rc1 = round($t[1]/30, 0)+1;
			$rc2 = round($t[1]/30, 0)+2;
			$pagenavi = $pagenavi.'<a href="/info/searchdoc/?'.'Act=3&RCode=3&OrganList='.$_POST['OrganList'].'&DocTypeList='.$_POST['DocTypeList'].'&DPrBD='.$_POST['DPrBD'].'&DPrBM='.$_POST['DPrBM'].'&DPrBY='.$_POST['DPrBY'].'&DPrED='.$_POST['DPrED'].'&DPrEM='.$_POST['DPrEM'].'&DPrEY='.$_POST['DPrEY'].'&DocNum='.$_POST['DocNum'].'&DocName='.$_POST['DocName'].'&MinNum='.$_POST['MinNum'].'&DMBD='.$_POST['DMBD'].'&DMBM='.$_POST['DMBM'].'&DMBY='.$_POST['DMBY'].'&DMED='.$_POST['DMED'].'&DMEM='.$_POST['DMEM'].'&DMEY='.$_POST['DMEY'].'&Order1='.$_POST['Order1'].'&RecInPage='.$_POST['RecInPage'].'&x=28&y=7&PCrt='.$rc1.'&PCnt='.$rc2.'">Вперед &gt;</a>';
		}
        if(preg_match('/Конец \&gt;\&gt;<\/a>/iU', $p))
		{
			preg_match('/Всего документов: (\d+)\./iU', $p, $t);
			$rc = round($t[1]/30, 0);
			$pagenavi = $pagenavi.'<a href="/info/searchdoc/?'.'Act=3&RCode=4&OrganList='.$_POST['OrganList'].'&DocTypeList='.$_POST['DocTypeList'].'&DPrBD='.$_POST['DPrBD'].'&DPrBM='.$_POST['DPrBM'].'&DPrBY='.$_POST['DPrBY'].'&DPrED='.$_POST['DPrED'].'&DPrEM='.$_POST['DPrEM'].'&DPrEY='.$_POST['DPrEY'].'&DocNum='.$_POST['DocNum'].'&DocName='.$_POST['DocName'].'&MinNum='.$_POST['MinNum'].'&DMBD='.$_POST['DMBD'].'&DMBM='.$_POST['DMBM'].'&DMBY='.$_POST['DMBY'].'&DMED='.$_POST['DMED'].'&DMEM='.$_POST['DMEM'].'&DMEY='.$_POST['DMEY'].'&Order1='.$_POST['Order1'].'&RecInPage='.$_POST['RecInPage'].'&x=28&y=7&PCrt='.$rc.'&PCnt='.$rc.'">Конец &gt;&gt;</a></a>';
		}
        $pagenavi = $pagenavi."</center>";



		$this->view->tableData = iconv('cp1251', 'utf-8', "<center>".$table."</center><br>".$pagenavi);
	}
}
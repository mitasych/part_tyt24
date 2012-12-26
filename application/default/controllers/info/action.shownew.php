<?php

$this->params['page'] = isset($this->params['page'])?$this->params['page']:'';

$currentInfo = new AK_Order_Report_List();
$currentInfo->addWhere('A.url = \'/articles/'.$this->params['page'].'/\'');
$currentInfo = $currentInfo->getList();


/**/
$this->view->settings = new AK_Order_Settings();
$disc = $this->view->settings->get('discount');
preg_match_all('/([0-9]+):([0-9\.]+)%/', $disc,$disc1);
$disc = $disc1;
$this->view->disc = $disc;
/**/

if (!empty($currentInfo[0]))
{
$currentInfo = $currentInfo[0];

$oofreports = new AK_Order_Report_Oflist();
$listOfreports = $oofreports->getList(1, 0, $currentInfo->id);

$_sys_variables = new AK_System_Variables();
$this->view->sys_ofreports = $_sys_variables->get('official_reports');

    if ($currentInfo->title_alter) {
        $this->view->TITLE = $currentInfo->title_alter;
    } elseif ($currentInfo->title) 
		$this->view->TITLE = $currentInfo->title;
    /*if ($currentInfo->getMetaKeywords()) {
        $this->view->KEYWORDS = $currentInfo->getMetaKeywords();
    }
    if ($currentInfo->getMetaDescription()) {
        $this->view->DESCRIPTION = $currentInfo->getMetaDescription();
    }*/
    
    $this->view->listOfreports = $listOfreports;
    
    $this->view->currentInfo = $currentInfo;
	$res = $currentInfo->getPricesArray();
	
    if (count($res) == 1 || empty($res)) {
        $out='';
    }
    else
	{
		$cnt = 0;
		$out = '';
		foreach ($res as $key => $val) {
			$cnt++;
			if ($cnt == count($res)) {
				$out.='<tr><td align="center"><p><font size="2">&nbsp;св. '.$key.'</font></p></td><td><p><font size="2">&nbsp;</font></p></td><td align="center"><p><font size="2">'.$val.'</font></p></td></tr>';
			} else {
				$out.='<tr><td align="center"><p><font size="2">&nbsp;'.$key.' - '.(key($res)-1).'</font></p></td><td><p><font size="2">&nbsp;</font></p></td><td align="center"><p><font size="2">'.$val.'</font></p></td></tr>';
			}
			next($res);
		}
	}
	$this->view->out = $out;
	
}
else
{
	$this->showAction();
	//$this->_redirect('/');
}
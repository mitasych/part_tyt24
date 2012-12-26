<?php

$this->_helper->viewRenderer->setRender('shownew');

$ofreports = new AK_Order_Report_Oflist();

// $reportEntity = new AK_Order_Ofreport();

if($this->_request->isXmlHttpRequest()){
	
	$code = $this->params['code'];
	$id = $this->params['id'];
	
	$ofreport = $ofreports->getList(1, $code, $id);
	
	//echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($ofreport); echo'</pre>';die;
	
	$data = array();
	$data['term1'] = $ofreport[0]->getTimePrint2(1);
	$data['term2'] = $ofreport[0]->getTimePrint2(2);
	$data['price1'] = $ofreport[0]->getPriceFront(1);
	$data['price2'] = $ofreport[0]->getPriceFront(2);
	
	
	$this->_helper->json($data);
}
else{
 	die('Error!');
}
?>
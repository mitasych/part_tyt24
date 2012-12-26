<?php

$this->_helper->viewRenderer->setRender('check');

$ofreports = new AK_Order_Report_Oflist();

// $reportEntity = new AK_Order_Ofreport();

if($this->_request->isXmlHttpRequest()){
	
	$type = $this->params['type'];
	$code = $this->params['code'];
	$cargoname2 = $this->params['cargoname2'];
	
// 	echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($code); echo'</pre>';die;
	
	$ofRepList = $ofreports->getList(1, 0, $type);
	
	$listRepsCode = array();
	
	if ((int) $code == 0) {
		$code = 77;
	}
	
	if (count($ofRepList)) {
		$arCodes = array();
		foreach ($ofRepList as $report){
			$arCodes[] = $report->region_code;
		}
	
		if (!in_array($code, $arCodes)) {
			$code = 77;
		}
	}
	
	if ($code > 0) {
		$ofRepList = $ofreports->getList(1, 0, $type);
	
		$ofRepListCode = $ofreports->getList(1, $code);
	
		foreach($ofRepListCode as $rep){
	
			if ($rep->getPriceFront(1) > 0) {
				$arRep['price_inactive'] = $rep->getPriceFront(1);
			}
			elseif ($rep->getPriceFront(2) > 0) {
				$arRep['price_inactive'] = $rep->getPriceFront(2);
			}
			else{
				$arRep['price_inactive'] = '---';
			}
	
	
			$price2_html = '';
			$price3_html = '';
			$arRep['html_prices'] = '';
	
			if($rep->getPriceFront(1) > 0){
				$price2_html = '<div class="report_info_item">
				<div class="report_info_item_checker">
				<label>
				<div class="radio" style="background-position: 50% 0px;">
				<input type="radio" name="isoff" id="isoff_o" value="0">
				</div>
				Обычная ( <strong><font class="Apple-style-span" color="#ff0000">'.$rep->term2.' раб. дней</font></strong>) <span class="of-price">'.$rep->getPriceFront(1).' руб.</span>
				</label>
				<br>
				</div>
				</div>';
			}
	
			if($rep->getPriceFront(2) > 0){
				$price3_html = '<div class="report_info_item">
				<div class="report_info_item_checker">
				<label>
				<div class="radio" style="background-position: 50% 0px;">
				<input type="radio" name="isoff" id="isoff_s" value="1">
				</div>
				Срочная ( <strong><font class="Apple-style-span" color="#ff0000">'.$rep->term3.' раб. дней</font></strong>) <span class="of-price">'.$rep->getPriceFront(2).' руб.</span>
				</label>
				</div>
				</div>';
			}
	
	
			if ((!empty($price2_html) || !empty($price3_html)) && $rep->order_report_id == $type) {
				$arRep['html_prices'] = '<div class="report_info_item" style="display:none">
				<div class="report_info_item_checker">
				<label>
				<div class="radio" style="color: rgb(19, 60, 95); display: block; background-position: 50% 0px;">
				<input type="radio" name="type_r" id="type_r_off" value="1" class="styled">
				</div>
				<span><b> <strong><font class="Apple-style-span" color="#ff0000">3 раб. дней</font></strong></b></span>
				<label>
				<label>(до 5 раб. дней)</label>
				</label>
				</label>
				</div>
				</div>
				'.$price2_html.'
				'.$price3_html.'
				<div class="report_info_item">
				<div class="rbutton"> </div>
				<div class="price"> <span> <a href="">пример</a> </span>
				<label>заверено печатью</label>
				</div>
				</div>
				<div class="report_info_item">
				<div class="rbutton">
				<span> кол-во: </span><br>
				<input type="text" name="offcount" id="offcount" class="input_field quantity" value="1" onblur="if($(this).attr(\'value\') == \'\')$(this).attr(\'value\',\'1\');" onfocus="if($(this).attr(\'value\') == \'1\')$(this).attr(\'value\',\'\');" readonly="readonly">
				</div>
				<div class="obutton">
				<a class="ordr_link ordr_link_block" onclick="basketAdd(this)" href="#" dalee="off">В КОРЗИНУ</a>
				</div>
				</div>
				';
			}
	
	
			$listRepsCode[$rep->order_report_id] = $arRep;
		}
	}
	
	$listReps = '<option>---</option>';
	
	if (count($ofRepList)) {
		$listReps = '';
		foreach($ofRepList as $report){
			$selected = '';
			if ($report->region_code==$code) {
				$selected = ' selected="selected"';
			}
			$listReps .= '<option value="'.$report->region_code.'"'.$selected.'>'.$report->order_report_region.'</option>';
		}
	}
// 	echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($listReps); echo'</pre>';die;
	$out['listReps'] = $listReps;
	$out['listRepsCode'] = $listRepsCode;
	$out['code'] = (int) $code;
	
	if (strlen($out['code']) == 1) {
		$out['code'] = '0'.$out['code'];
	}
	
	
	
	$this->_helper->json($out);
}
else{
 	die('Error!');
}
?>
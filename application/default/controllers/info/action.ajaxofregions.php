<?php

$this->_helper->viewRenderer->setRender('check');

$ofreports = new AK_Order_Report_Oflist();

// $reportEntity = new AK_Order_Ofreport();

if($this->_request->isXmlHttpRequest()){
	
	$code = $this->params['code'];
	$type = $this->params['type'];
	$type_off = $this->params['type_off'];
	
	$checked_isoff_o = $type_off == 'isoff_o' ? ' checked="checked"' : '';
	$checked_isoff_s = $type_off == 'isoff_s' ? ' checked="checked"' : '';
	
	
	
	$ofRepList = $ofreports->getList(1, $code);
	
	$listReps = array();
	
	foreach($ofRepList as $rep){
// 		$arRep['order_report_id'] = $rep->order_report_id;
// 		$arRep['price2'] = $rep->price2;
// 		$arRep['term2'] = $rep->term2;
// 		$arRep['price3'] = $rep->price3;
// 		$arRep['term3'] = $rep->term3;
// 		$arRep['price_shipping'] = $rep->price_shipping;
// 		$arRep['term_shipping'] = $rep->term_shipping;
// 		$arRep['flag1'] = $rep->flag1;
// 		$arRep['flag2'] = $rep->flag2;
// 		$arRep['flag3'] = $rep->flag3;
// 		$arRep['order_report_title'] = $rep->order_report_title;
// 		$arRep['order_report_region'] = $rep->order_report_region;
		
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
											<input type="radio" name="isoff" id="isoff_o" value="0"'.$checked_isoff_o.'>
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
											<input type="radio" name="isoff" id="isoff_s" value="1"'.$checked_isoff_s.'>
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
		
		
		$listReps[$rep->order_report_id] = $arRep;
	}
// 	echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($listReps); echo'</pre>';die;
	
	$this->_helper->json($listReps);
}
else{
 	die('Error!');
}
?>
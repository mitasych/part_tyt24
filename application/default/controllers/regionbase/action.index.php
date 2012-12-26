<?php

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

$time_end = microtime_float();
$time = $time_end - $time_start;
$this->view->time = $time; /* время выполнения запроса в бд */

$TimeInBase = new AK_Timer_Item();
$TimeInBase->setTime((float)$time)
	->setWhat($str)
	->setController("LIST");
	// ->setOkved() //хз зачем это тут. но с пустым аргументом оно не работает
	// ->setOkato(); //то же самое что выше
$TimeInBase->save();
 

######################################################
$id = $this->_getParam('id');
$this->view->base_id = $id;
/* Получение данных о базе */
$select = $this->_db->select();
$select->from('class_okato')->where('`id`=?', $id);
$dbinfo = $this->_db->fetchRow($select);
$this->view->db_name = $dbinfo['name'];
$this->view->level = $dbinfo['lvl_region'];
$lvlRub = $dbinfo['lvl_region'];

/* Кол-во компаний в рубрике */
$this->view->count_all = number_format($dbinfo['c_all'], 0, ',', ' '); // всего
$this->view->count_phone = number_format($dbinfo['c_tele'], 0, ',', ' '); // с телефоном
$this->view->count_email = number_format($dbinfo['c_email'], 0, ',', ' '); // с емейлом

/* Название вышестоящей рубрики */
if($lvlRub == 3){$db_parent_m = $dbinfo['main_parent_id'];}
else{$db_parent_m = $dbinfo['parent_id'];}
$db_parent = $dbinfo['parent_id'];
if($db_parent > 0){
	$select = $this->_db->select();
	$select->from('class_okato', 'name')->where('`id`=?', $db_parent_m);
	$rbname = $this->_db->fetchRow($select);
	$this->view->db_parent_name = $rbname['name'];
	$this->view->db_parent = $db_parent;
}
#######################################################
# дополнительные данные берущиеся из другой таблицы
$select = $this->_db->select()->from('okved_dbinfo', '*');
$result = $this->_db->fetchAll($select);
for($i=0; $i<sizeof($result); $i++){
	if($result[$i]['param'] == 'db_format'){$this->view->db_format = $result[$i]['value'];}
	if($result[$i]['param'] == 'db_field'){$this->view->db_field = $result[$i]['value'];}
	if($result[$i]['param'] == 'db_note'){$this->view->db_note = $result[$i]['value'];}
	if($result[$i]['param'] == 'db_temp_link'){$this->view->db_temp_link = $SITE_URL.'/'.$result[$i]['value'];}
	if($result[$i]['param'] == 'db_cost'){$cost_formula = $result[$i]['value'];}
	if($result[$i]['param'] == 'db_sale'){$sale_formula = $result[$i]['value'];}
	
	if($result[$i]['param'] == 'db_name1'){$this->view->db_name1 = $result[$i]['value'];}
	if($result[$i]['param'] == 'db_desc1'){$this->view->db_desc1 = $result[$i]['value'];}
	if($result[$i]['param'] == 'db_name2'){$this->view->db_name2 = $result[$i]['value'];}
	if($result[$i]['param'] == 'db_desc2'){$this->view->db_desc2 = $result[$i]['value'];}
	if($result[$i]['param'] == 'db_name3'){$this->view->db_name3 = $result[$i]['value'];}
	if($result[$i]['param'] == 'db_desc3'){$this->view->db_desc3 = $result[$i]['value'];}
	if($result[$i]['param'] == 'db_enable1'){$this->view->db_enable1 = $result[$i]['value'];}
	if($result[$i]['param'] == 'db_enable2'){$this->view->db_enable2 = $result[$i]['value'];}
	if($result[$i]['param'] == 'db_enable3'){$this->view->db_enable3 = $result[$i]['value'];}
	if($result[$i]['param'] == 'db_top_comp'){$this->view->db_top_comp = $result[$i]['value']; $a = $result[$i]['value'];}
}
######################################################
if($lvlRub < 3){
	# получаем список подрубрик	
	$select = $this->_db->select();
	$select ->from('class_okato', array('id', 'name', 'c_all'));
	if($lvlRub == 1){$select ->where('`parent_id`=?', $id);}
	else{$select ->where('`main_parent_id`=?', $id);}
	$subrubric_list = $this->_db->fetchAll($select);
	$this->view->subrubric_list = $subrubric_list;
}else{
	# получаем список компаний
	$this->view->company_list = NULL;
	if($dbinfo['code']){
		$query = "SELECT `sys_id`, `single_abbr`, `single_name` FROM `class_company5_2` WHERE `okato_id` LIKE '".iconv("WINDOWS-1251", "UTF-8", $dbinfo['code'])."%' ORDER BY `single_name` ASC LIMIT ".$a;
		$company_list = $this->_db->fetchAll($query);
		$this->view->company_list = $company_list;
	}
}

######################################################
# Получаем список сопутствующх рубрик в той же вышестоящей рубрике
if($lvlRub == 1){
	$query = "SELECT `id`, `name`, `c_all`, `c_tele`, `c_email` FROM `class_okato` WHERE `id`!='".$id."' AND `parent_id` IS NULL ORDER BY `name` ASC";
	$rubric_list = $this->_db->fetchAll($query);
	$this->view->rubric_list = $rubric_list;
}else{
	$query = "SELECT `id`, `name`, `c_all`, `c_tele`, `c_email` FROM `class_okato` WHERE `parent_id`='".$db_parent."' AND `id`!='".$id."' ORDER BY `name` ASC";
	$rubric_list = $this->_db->fetchAll($query);
	$this->view->rubric_list = $rubric_list;
}
# Форматирование скидок
$sale_list = explode(";", $sale_formula);
for($i=0; $i<sizeof($sale_list); $i++){
	list($cnt, $prc) = explode(":", $sale_list[$i]);
	if(mb_strlen($cnt) > 0){
		$db_sale .= "от ".number_format($cnt, 0, ',', ' ')." - ".$prc;
		if($i<sizeof($sale_list)){$db_sale .= "<br>";}
	}
}
$this->view->db_sale = $db_sale;

# Расчет цены по формулам
$db_cost = 0;
$db_cost_tele = 0;
$db_cost_email = 0;

$cost_formula = str_replace(",", ":", $cost_formula);
$cost_list = explode(";", $cost_formula);
$cost_m = sizeof($cost_list);
for($i=0; $i<$cost_m; $i++){
	list($c_count, $c_pre, $c_mnj) = explode(":", $cost_list[$i]);
	
	if($dbinfo['c_all'] < $c_count AND !$db_cost){$db_cost = $c_pre + $dbinfo['c_all']*$c_mnj;}
	if($dbinfo['c_tele'] < $c_count AND !$db_cost_tele){$db_cost_tele = $c_pre + $dbinfo['c_tele']*$c_mnj;}
	if($dbinfo['c_email'] < $c_count AND !$db_cost_email){$db_cost_email = $c_pre + $dbinfo['c_email']*$c_mnj;}
}
$this->view->db_cost = number_format(round($db_cost, -1), 0, ',', ' ');
$this->view->db_cost_tele = number_format(round($db_cost_tele, -1), 0, ',', ' ');
$this->view->db_cost_email = number_format(round($db_cost_email, -1), 0, ',', ' ');

# Расчет цен для списка сопутствующих рубрик
for($i=0; $i<sizeof($rubric_list); $i++){
	for($a=0; $a<$cost_m; $a++){
		list($c_count, $c_pre, $c_mnj) = explode(":", $cost_list[$a]);
		
		if($rubric_list[$i]['c_all'] < $c_count AND !$rubric_list[$i]['cost']){$rubric_list[$i]['cost'] = number_format(round(($c_pre + $rubric_list[$i]['c_all']*$c_mnj), -1), 0, ',', ' ');}
		if($rubric_list[$i]['c_tele'] < $c_count AND !$rubric_list[$i]['cost_tele']){$rubric_list[$i]['cost_tele'] = number_format(round(($c_pre + $rubric_list[$i]['c_tele']*$c_mnj), -1), 0, ',', ' ');}
		if($rubric_list[$i]['c_email'] < $c_count AND !$rubric_list[$i]['cost-email']){$rubric_list[$i]['cost_email'] = number_format(round(($c_pre + $rubric_list[$i]['c_email']*$c_mnj), -1), 0, ',', ' ');}
	}
}
$this->view->rubric_list = $rubric_list;
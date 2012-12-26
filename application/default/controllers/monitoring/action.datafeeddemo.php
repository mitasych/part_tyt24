<?php
	function js2PhpTime($jsdate) {
		if(preg_match('@(\d+)/(\d+)/(\d+)\s+(\d+):(\d+)@', $jsdate, $matches)==1)
		{        
			$ret = mktime($matches[4], $matches[5], 0, $matches[1], $matches[2], $matches[3]);
			//echo $matches[4] ."-". $matches[5] ."-". 0  ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
			}
		else 
			if(preg_match('@(\d+)/(\d+)/(\d+)@', $jsdate, $matches)==1) {
				$ret = mktime(0, 0, 0, $matches[2], $matches[1], $matches[3]);
				//echo 0 ."-". 0 ."-". 0 ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
			}
			return $ret;
	}
	function php2JsTime($phpDate) {
		//echo $phpDate;
		//return "/Date(" . $phpDate*1000 . ")/";
		//return date("m/d/Y H:i", $phpDate);
		return date("m/d/Y", $phpDate);
	}
	
	function php2MySqlTime($phpDate) {
    //return date("Y-m-d H:i:s", $phpDate);
		return date("Y-m-d", $phpDate);
	}
	
	//function mySql2PhpTime($sqlDate){
	//    $arr = date_parse($sqlDate);
	//    return mktime($arr["hour"],$arr["minute"],$arr["second"],$arr["month"],$arr["day"],$arr["year"]);
	//
	//}
	//
	//function addCalendar($st, $et, $sub, $ade){
	//  $ret = array();
	//      $ret['IsSuccess'] = true;
	//      $ret['Msg'] = 'add success';
	//      $ret['Data'] =rand();
	//  return $ret;
	//}
	//
	//
	//function addDetailedCalendar($st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
	//  $ret = array();
	//      $ret['IsSuccess'] = true;
	//      $ret['Msg'] = 'add success';
	//      $ret['Data'] = rand();
	//  return $ret;
	//}
	function listCalendarByRange($sd, $ed, $cnt, $user) {
		$db = Zend_Registry::get('DBORDER');
		$query = $db->select();
		$query->from('orders_monitoring__demoevents AS A', new Zend_Db_Expr('A.type_id as type_id, A.id as id, A.date_created AS date_created, A.event_date AS event_date, A.content AS content'));
		$query->joinLeft('orders_kontragents AS B', 'A.kontragent_id = B.id', new Zend_Db_Expr('B.title AS kontragent_title, B.inn AS inn, B.region AS region, B.country AS country'));
		$query->joinLeft('orders_monitoring__events_types AS C', 'A.type_id = C.id', new Zend_Db_Expr('C.title AS event_type'));
		//$query->where('A.kontragent_id IN (SELECT kontragent_id FROM orders_users__kontragents WHERE user_id = ?)', $user->id);
		//$query->where('A.event_date >= ?',$sd);
		//$query->where('A.event_date <= ?',$ed);
		$ret = array();    $ret['events'] = array();
		$ret["issort"] =true;
		$ret["start"] = php2JsTime($sd);
		$ret["end"] = php2JsTime($ed);
		$ret['error'] = null;
		//   $title = array('team meeting', 'remote meeting', 'project plan review', 'annual report', 'go to dinner');
		//    $location = array('Lodan', 'Newswer', 'Belion', 'Moore', 'Bytelin');
		foreach ($db->fetchAll($query) as $event) {
        //$ev = new AK_Order_Monitoring_Event($event['id']);
		//     $event['kontragent_title'],
		//        $event['inn'],
		//        $event['region'],
		//        $event['country'],
		//        date('d-m-Y', $event['event_date']),
		//        $event['event_type'],
		//        '<a href="/monitoring/event/'.$event['id'].'/" style="color:blue; text-decoration:underline;'.$add.'">'.$event['content'].'</a>',
		//        date('d-m-Y', $event['date_created']));
		//
		//    $rsd = rand($sd, $ed);
		//      $red = rand(3600, 10800);
			
			$date_rand = rand(0,7)*86400;
			$ret['events'][] = array(
				$event['id'],
				$event['content'],
			//	php2JsTime($event['event_date']),//x2
				php2JsTime(mktime()-$date_rand),
				php2JsTime(mktime()-$date_rand),
				1,
				//rand(0,1),
				0, 
				//more than one day event 
				0,
				//Recurring event 
				$event['type_id']*2,
				//color
				0, 
				//editable
				$event['region'],
				//.' '.$event['country'], 
				//location
				''
				//$attends
				);
			}
			return $ret;
	}
	function listCalendar($day, $type, $user) {
		$phpTime = js2PhpTime($day);
		//print $day;die;
		//echo $phpTime . "+" . $type;
		switch($type) {
			case "month":
				$st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
				$et = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
				$cnt = 50;
				break;
			case "week":
			//suppose first day of a week is monday
				$monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;
				//echo date('N', $phpTime);
				$st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
				$et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
				$cnt = 20;
				break;
			case "day":
				$st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
				$et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
				$cnt = 5;
				break;
		}
		//echo $st . "--" . $et;
		return listCalendarByRange($st, $et, $cnt, $user);
	}
	//function updateCalendar($id, $st, $et){
	//  $ret = array();
	//      $ret['IsSuccess'] = true;
	//      $ret['Msg'] = 'Succefully';
	//  return $ret;
	//}
	//function updateDetailedCalendar($id, $st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
	//  $ret = array();
	//      $ret['IsSuccess'] = true;
	//      $ret['Msg'] = 'Succefully';
	//  return $ret;
	//}
	//
	//function removeCalendar($id){
	//  $ret = array();
	//      $ret['IsSuccess'] = true;
	//      $ret['Msg'] = 'Succefully';
	//  return $ret;
	//}
	header('Content-type:text/javascript;charset=UTF-8');
	$method = $_GET["method"];
	switch ($method) {
	//    case "add":
	//        $ret = addCalendar($_POST["CalendarStartTime"], $_POST["CalendarEndTime"], $_POST["CalendarTitle"], $_POST["IsAllDayEvent"]);
	//        break;
		case "list":
			$ret = listCalendar($_POST["showdate"], $_POST["viewtype"],$this->_user);
			break;
	//    case "update":
	//        $ret = updateCalendar($_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
	//        break;
	//    case "remove":
	//        $ret = removeCalendar( $_POST["calendarId"]);
	//        break;
	//    case "adddetails":
	//        $id = $_GET["id"];
	//        $st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
	//        $et = $_POST["etpartdate"] . " " . $_POST["etparttime"];
	//        if($id){
	//            $ret = updateDetailedCalendar($id, $st, $et,
	//                $_POST["Subject"], $_POST["IsAllDayEvent"]?1:0, $_POST["Description"],
	//                $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
	//        }else{
	//            $ret = addDetailedCalendar($st, $et,
	//                $_POST["Subject"], $_POST["IsAllDayEvent"]?1:0, $_POST["Description"],
	//                $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
	//        }
	//        break;
	}
	echo json_encode($ret);
	exit;
?>
<?php

class AK_Order_Report extends AK_Data_EntityOrder
{
    public $id;
    public $title;
    public $title_alter;
    public $title_order;
    public $category;
    public $url;
    public $text_mini;
    public $text;
    public $price;
    public $price2;
    public $price3;
    public $time;
    public $time2;
    public $time3;
    public $example_url;
    public $example_name;
    public $country;
    public $flag1;
    public $flag2;
    public $flag3;
    public $faq;
    public $type;
    public $order;
    public $active;
    public $img;
    public $active_company;
    public $main_page;
    public $report_menu;
    /**
     * Constructor.
     *
     */
    public function getMonitoringListFormatted() {
        if (!empty($this->monitoringList)) {
            return '<font color=green>Да</font>';
        }
        return '<font color=red>Нет</font>';
    }

    public function getRegisterListFormatted() {
        if (!empty($this->registerList)) {
            return '<font color=green>Да</font>';
        }
        return '<font color=red>Нет</font>';
    }
	public function __construct($value = null)
	{
        parent::__construct('order_report', array(
            'id'   => 'id',
            'title' => 'title',
            'title_alter' => 'title_alter',
            'title_order' => 'title_order',
            'category' => 'category',
            'url' => 'url',
            'text_mini' => 'text_mini',
            'text' => 'text',
            'price' => 'price',
            'price2' => 'price2',
            'price3' => 'price3',
            'time' => 'time',
            'time2' => 'time2',
            'time3' => 'time3',
            'flag1' => 'flag1',
            'flag2' => 'flag2',
            'flag3' => 'flag3',
            'faq' => 'faq',
            'active' => 'active',
            'country' => 'country',
            'img' => 'img',
            'active_company' => 'active_company',
            'example_url' => 'example_url',
            'example_name' => 'example_name',
			'type' => 'type',
        	'order' => 'order',
        	'main_page' => 'main_page',
        	'report_menu' => 'report_menu'
			));
        $this->load($value);
	}
	 //~ public function getPricesArray($id = 1 ) {
//~ 
        //~ $_result = array();
		//~ if ($id == 1)
			//~ $price = $this->price;
		//~ if ($id == 2)
			//~ $price = $this->price2;
		//~ if ($id == 3)
			//~ $price = $this->price3;
        //~ if (preg_match('/^[0-9]+$/', $price)) {
            //~ return array('1'=>$price);
        //~ }
//~ 
        //~ if (mb_strlen($price) == 0) {
            //~ return $_result;
        //~ }
//~ 
        //~ $_lines = split(";", $price );
        //~ foreach ($_lines as $_line) {
            //~ $_result[mb_substr ($_line, 0 , mb_strpos($_line, ':',null, 'UTF-8'), 'UTF-8')] = mb_substr ($_line, mb_strpos($_line, ':',null, 'UTF-8')+1 ,mb_strlen($_line, 'UTF-8'), 'UTF-8');
        //~ }
        //~ return $_result;
    //~ }

	public function getPricesArray($id = 1) {
		 
		$ofReportList = new AK_Order_Report_Oflist();
		if (is_null($this->id)) {
			$ofReport=NULL;
		}
		else {
			$ofReport = $ofReportList->getOfreportByCodeAndReport(77, $this->id);
		}
		 
	
		$_result = array();
		if ($id == 1)
			$price = $this->price;
		if ($id == 2){
			if (!is_null($ofReport)) {
				$price = $ofReport->getPriceFront(1) != 0 ? $ofReport->getPriceFront(1) : false;
			}
			else{
				$price = $this->price2;
			}
		}
		if ($id == 3){
			if (!is_null($ofReport)) {
				$price = $ofReport->getPriceFront(2) != 0 ? $ofReport->getPriceFront(2) : false;
			}
			else{
				$price = $this->price3;
			}
		}
		if (preg_match('/^[0-9]+$/', $price)) {
			return array('1' => $price);
		}
	
		if (mb_strlen($price) == 0) {
			return $_result;
		}
	
		$_lines = split(";", $price);
		foreach ($_lines as $_line) {
			$_result[mb_substr($_line, 0, mb_strpos($_line, ':', null, 'UTF-8'), 'UTF-8')] = mb_substr($_line, mb_strpos($_line, ':', null, 'UTF-8') + 1, mb_strlen($_line, 'UTF-8'), 'UTF-8');
		}
		return $_result;
	}

	 public function getPricesMin($id = 1 ) {

		$price_arr = $this->getPricesArray($id);
		$price_arr2 = $this->getPricesArray($id);
		$price_arr3 = $this->getPricesArray($id);
        if (empty($price_arr)) {
            return '- цена требует уточнения';
        }
        if (count($price_arr) == 1) {
            
            return '- <strong><font class="Apple-style-span" color="#ff0000">'.$price_arr[1].' руб.</font></strong>';
            
        }
		$price = $price_arr[1];
        foreach ($price_arr as $key => $value) {
            if ($price >= $value) {
                $price = $value;
            }
        }
        return 'от <strong><font class="Apple-style-span" color="#ff0000">'.$price.' руб.</font></strong>';
    }
	 public function getTimePrint($id = 1 ) {
		
		$time=0;
		if ($id == 1)
			$time = $this->time;
		if ($id == 2)
			$time = $this->time2;
		if ($id == 3)
			$time = $this->time3;
		if (substr_count($time, "минут"))
			return 'до <strong><font class="Apple-style-span" color="#ff0000">'.$time.'</font></strong>';
		return '— <strong><font class="Apple-style-span" color="#ff0000">'.$time.'</font></strong>';
    }
	 public function getTimePrint2($id = 1 ) {
		
		$time=0;
		if ($id == 1)
			$time = $this->time;
		if ($id == 2)
			$time = $this->time2;
		if ($id == 3)
			$time = $this->time3;
		if (substr_count($time, "минут"))
			return 'до <strong><font class="Apple-style-span" color="#ff0000">'.$time.'</font></strong>';
		return ' <strong><font class="Apple-style-span" color="#ff0000">'.$time.'</font></strong>';
    }

    //возвращает цену единицы исходя из количества заказанного
    public function getPriceByCount($count, $id = 1) {
        $price = null;
        foreach ($this->getPricesArray($id) as $key => $value) {
            if ($count>=$key) {
                $price = $value;
            }
        }
        return $price;//null в случае пустого поля
    }    
	
	
	public function getRewriteName() {
        $Rewrite = explode("/", $this->url);
		$Rewrite = $Rewrite[2];
        return $Rewrite;
    }

    public function getPricesOutput($id = 1) {
        $res = $this->getPricesArray($id);
        if (empty($res)) {
            return 'цена требует уточнения';
        }
        if (count($res) == 1) {
            
            return '<span style="color:#ff0000; font-weight: bold; ">'.$res[1].' руб.</span>';
            
        }

        $out ='';
        $cnt = 0;
        reset($res);
        foreach ($res as $key => $val) {
            $cnt++;
            if ($cnt == count($res)) {
                //$out.=$key.' и более: '.$val.' руб.';
                $out.='<span style="color:#ff0000; font-weight: bold; ">'.$val.' руб.</span> ('.$key.' и более)<br>';
            } else {
                //$out.=$key.' - '.(key($res)-1).' : '.$val.' руб.<br>';
                $out.='<span style="color:#ff0000; font-weight: bold; ">'.$val.' руб.</span> ('.$key.' - '.(key($res)-1).')<br>';
                //prev($res);
            }
            next($res);

        }
        return $out;
    }

    public function getPricesOutputSimple($id = 1) {
        $res = $this->getPricesArray($id);
        if (empty($res)) {
            return 'цена требует уточнения';
        }
        if (count($res) == 1) {
            
            return ''.$res[1].' руб.';
            
        }

        $out ='';
        $cnt = 0;
        reset($res);
        foreach ($res as $key => $val) {
            $cnt++;
            if ($cnt == count($res)) {
                //$out.=$key.' и более: '.$val.' руб.';
                $out.=$val.' руб. ('.$key.' и более); ';
            } else {
                //$out.=$key.' - '.(key($res)-1).' : '.$val.' руб.<br>';
                $out.=$val.' руб. ('.$key.' - '.(key($res)-1).'); ';
                //prev($res);
            }
            next($res);

        }
        return $out;
    }
	
	public function getSubmenuPair() {
		$list = new AK_Order_Report_List();
		$list->addWhere('A.category = '.$this->category);
		$list->addWhere('A.id != '.$this->id);
		$list = $list->getList();
		if (!empty($list))
		{
			return $list[0];
		}
		return null;
    }
	public function getMenuParent() {
		$ParentLink = new AK_Menu_Link_Item($this->category);
        return $ParentLink;
    }
}

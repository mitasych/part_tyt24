<?php

class AK_Order_Ofreport extends AK_Data_EntityOrder {

    public $id;
    public $order_report_id;
    public $region_code;
    public $price2;
    public $term2;
    public $price3;
    public $term3;
    public $price_shipping;
    public $term_shipping;
    public $note;
    public $flag1;
    public $flag2;
    public $flag3;
    public $active;
    public $isActive;
    public $order_report_title;
    public $order_report_region;
    

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

    public function __construct($value = null) {
        parent::__construct('order_report_regions', array(
            'id' => 'id',
            'order_report_id' => 'order_report_id',
            'region_code' => 'region_code',
            'price2' => 'price2',
            'term2' => 'term2',
            'price3' => 'price3',
            'term3' => 'term3',
            'price_shipping' => 'price_shipping',
            'term_shipping' => 'term_shipping',
            'note' => 'note',
        	'flag1' => 'flag1',
        	'flag2' => 'flag2',
        	'flag3' => 'flag3',
        	'active' => 'active',
        ));
		$this->order_report_title = isset($value['order_report_title']) ? $value['order_report_title'] : '';
		$this->order_report_region = isset($value['order_report_region']) ? $value['order_report_region'] : '';
		//
        $this->load($value);
        //
        $this->isActive = empty($this->active) ? '<font color=red>Неактивен</font>' : '<font color=green>Активен</font>';
        
    }
    
    public function getPricesArray($id = 1) {

        $_result = array();
        if ($id == 1)
            $price = $this->price2 + $this->price_shipping;
        if ($id == 2)
            $price = $this->price3 + $this->price_shipping;
        if ($id == 3)
            $price = $this->price_shipping;
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

    public function getPricesMin($id = 1) {

        $price_arr = $this->getPricesArray($id);
        $price_arr2 = $this->getPricesArray($id);
        $price_arr3 = $this->getPricesArray($id);
        if (empty($price_arr)) {
            return '- цена требует уточнения';
        }
        if (count($price_arr) == 1) {

            return '- <strong><font class="Apple-style-span" color="#ff0000">' . $price_arr[1] . ' руб.</font></strong>';
        }
        $price = $price_arr[1];
        foreach ($price_arr as $key => $value) {
            if ($price >= $value) {
                $price = $value;
            }
        }
        return 'от <strong><font class="Apple-style-span" color="#ff0000">' . $price . ' руб.</font></strong>';
    }

    public function getTimePrint($id = 1) {

        $time = 0;
        if ($id == 1)
            $time = $this->term2;
        if ($id == 2)
            $time = $this->term3;
        if ($id == 3)
            $time = $this->term_shipping;
        if (substr_count($time, "минут"))
            return 'до <strong><font class="Apple-style-span" color="#ff0000">' . $time . '</font></strong>';
        return '— <strong><font class="Apple-style-span" color="#ff0000">' . $time . '</font></strong>';
    }

    public function getTimePrint2($id = 1) {

        $time = 0;
        if ($id == 1)
            $time = $this->term2;
        if ($id == 2)
            $time = $this->term3;
        if ($id == 3)
            $time = $this->term_shipping;
        if (substr_count($time, "минут"))
            return 'до <strong><font class="Apple-style-span" color="#ff0000">' . $time . '</font></strong>';
        return ' <strong><font class="Apple-style-span" color="#ff0000">' . $time . '</font></strong>';
    }

    //возвращает цену единицы исходя из количества заказанного
    public function getPriceByCount($count, $id = 1) {
        $price = null;
        foreach ($this->getPricesArray($id) as $key => $value) {
            if ($count >= $key) {
                $price = $value;
            }
        }
        return $price; //null в случае пустого поля
    }

//     public function getRewriteName() {
//         $Rewrite = explode("/", $this->url);
//         $Rewrite = $Rewrite[2];
//         return $Rewrite;
//     }

    public function getPricesOutput($id = 1, $bWithoutStyle = false) {
        $res = $this->getPricesArray($id);
        if (empty($res)) {
            return 'цена требует уточнения';
        }
        if (count($res) == 1) {
            if (!$bWithoutStyle) {
                return '<span style="color:#ff0000; font-weight: bold; ">' . $res[1] . ' руб.</span>';
            } else {
                return $res[1] . ' руб.';
            }
        }

        $out = '';
        $cnt = 0;
        reset($res);
        foreach ($res as $key => $val) {
            $cnt++;
            if ($cnt == count($res)) {
                //$out.=$key.' и более: '.$val.' руб.';
                if (!$bWithoutStyle) {
                    $out .= '<span style="color:#ff0000; font-weight: bold; ">' . $val . ' руб.</span> (' . $key . ' и более)<br>';
                } else {
                    $out .= $val . ' руб. (' . $key . ' и более)<br>';
                }
            } else {
                //$out.=$key.' - '.(key($res)-1).' : '.$val.' руб.<br>';
                if (!$bWithoutStyle) {
                    $out .= '<span style="color:#ff0000; font-weight: bold; ">' . $val . ' руб.</span> (' . $key . ' - ' . (key($res) - 1) . ')<br>';
                } else {
                    $out .= $val . ' руб. (' . $key . ' - ' . (key($res) - 1) . ')<br>';
                }
                //prev($res);
            }
            next($res);
        }
        return $out;
    }
    
    public function getPriceFront($id) {
    	$price = 0;
    	
    	if ($id == 1 && $this->flag1 > 0) {
    		$price = $this->price2;
    		if ($this->flag3 > 0) {
    			$price += $this->price_shipping;
    		}
    	}
    	if ($id == 2 && $this->flag2 > 0) {
    		$price = $this->price3;
    		if ($this->flag3 > 0) {
    			$price += $this->price_shipping;
    		}
    	}
    	
    	return $price;
    }

//     public function getSubmenuPair() {
//         $list = new AK_Order_Report_List();
//         $list->addWhere('A.category = ' . $this->category);
//         $list->addWhere('A.id != ' . $this->id);
//         $list = $list->getList();
//         if (!empty($list)) {
//             return $list[0];
//         }
//         return null;
//     }

//     public function getMenuParent() {
//         $ParentLink = new AK_Menu_Link_Item($this->category);
//         return $ParentLink;
//     }

}

<?php
class AK_Order_Prices extends AK_Data_EntityOrder {

    public $id;
    public $group;
    public $price;
    public $title;
	private $report;
	
    public function __construct ($value = null, $off = 0, $isoff = 0) {
        parent::__construct('orders_prices', array(
            'id' => 'id' ,
            'group' => 'group' ,
            'price' => 'price',
            'title' => 'title'));

        $this->load($value);
		$this->report = new AK_Order_Report($value);
		$this->id = $this->report->id;
		if ($off == 0)
			$this->price = $this->report->price;
		elseif ($isoff == 0)
			$this->price = $this->report->price2;
		else
			$this->price = $this->report->price3;
		$this->title = $this->report->title_order;
		$result = '';
		if ($this->report->flag1 && ($this->report->flag2 || $this->report->flag3))
		{
			if ($off) {
				$result.= '(oфициальная ';
				if ($isoff) {
					$result.= ' срочная)';
				}
				else
					$result.= ' обычная)';
			}
			else
				$result= '(информационная)';
		}
		$this->title .= $result;
    }

    public function getGroupName () {
        $gl = AK_Order_ZakazTypes::getGroupList();
        if (isset($gl[$this->group])) {
            return $gl[$this->group];
        }
        return '';
    }

    //возвращает массив цен ... 
    public function getPricesArray() {

        $_result = array();

        if (preg_match('/^[0-9]+$/', $this->price)) {
            return array('1'=>$this->price);
        }

        if (mb_strlen($this->price) == 0) {
            return $_result;
        }

        $_lines = split(";", $this->price );
        foreach ($_lines as $_line) {
            $_result[mb_substr ($_line, 0 , mb_strpos($_line, ':',null, 'UTF-8'), 'UTF-8')] = mb_substr ($_line, mb_strpos($_line, ':',null, 'UTF-8')+1 ,mb_strlen($_line, 'UTF-8'), 'UTF-8');
        }
        return $_result;
    }

    //возвращает цену единицы исходя из количества заказанного
    public function getPriceByCount($count) {
        $price = null;
        foreach ($this->getPricesArray() as $key => $value) {
            if ($count>=$key) {
                $price = $value;
            }
        }
        return $price;//null в случае пустого поля
    }

    public function getPricesOutput() {
        $res = $this->getPricesArray();
        if (empty($res)) {
            return 'цена требует уточнения';
        }
        if (count($res) == 1) {
            if (empty($res[0]))
				return 'цена требует уточнения';
			else
				return $this->price.' руб.';
            
        }

        $out ='';
        $cnt = 0;
        reset($res);
        foreach ($res as $key => $val) {
            $cnt++;
            if ($cnt == count($res)) {
                //$out.=$key.' и более: '.$val.' руб.';
                $out.='<span style="color:#ff0000; font-weight: bold">'.$val.' руб.</span> ('.$key.' и более)<br>';
            } else {
                //$out.=$key.' - '.(key($res)-1).' : '.$val.' руб.<br>';
                $out.='<span style="color:#ff0000; font-weight: bold">'.$val.' руб.</span> ('.$key.' - '.(key($res)-1).')<br>';
                //prev($res);
            }
            next($res);

        }
        return $out;
    }

    public function getName () {
        if (!empty($this->title)) return $this->title;
        $nl = AK_Order_ZakazTypes::getPriceList();
        if (isset($nl[$this->id])) {
            return $nl[$this->id];
        }
        return '';
    }

    public function getDefaultName () {
        $nl = AK_Order_ZakazTypes::getPriceList();
        if (isset($nl[$this->id])) {
            return $nl[$this->id];
        }
        return '';
    }

    public static function getPriceFromDb($value) {
        $db = Zend_Registry::get('DBORDER');
        $select = $db->select();
        $select->from('orders_prices', 'price')->where('id=?',(int) $value);
        $res = $db->fetchOne($select);
        return (int) $res;
    }
    
    public static function getPrices() {
        $db = Zend_Registry::get('DBORDER');
        $select = $db->select();
        $select->from('orders_prices', '*');
        $res = $db->fetchAll($select);
        foreach ( $res as &$item ) $item = new AK_Order_Prices($item);
        return $res;
    }
}

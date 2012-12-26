<?php

class AK_Order_Basket
{
    //static $amount = null;//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    //поднимаем сессию
    public static function check() {
        if (!isset($_SESSION['AK_ORDER_BASKET'] ) || !isset($_SESSION['AK_ORDER_BASKET']['ITEMS'] )) {
            $_SESSION['AK_ORDER_BASKET'] = array('ITEMS' => array());
        }
    }
    //добавление элемента
    public static function add($value) {
		
        if ($value->getIsUnique()) {//надо ли при добавлении удалять все элементы из корзины
            $_SESSION['AK_ORDER_BASKET']['ITEMS'] = array();
            $_SESSION['AK_ORDER_BASKET']['ITEMS'][] = $value;
            return;
        }

        if ($value->getIsUniqueType()) {//надо ли при добавлении удалять элементы других типов
            $items = $_SESSION['AK_ORDER_BASKET']['ITEMS'];
            foreach ($items as $key => $item) {
                if ($item->typeId != $value->typeId) {
                    unset ($_SESSION['AK_ORDER_BASKET']['ITEMS'][$key]);
                }
            }
        }

        if (!$value->getIsMulti()) {//разрешено ли добавлять несколько элементов одного типа
            $items = $_SESSION['AK_ORDER_BASKET']['ITEMS'];
            foreach ($items as $key => $item) {
                if ($item->typeId == $value->typeId) {
                    unset ($_SESSION['AK_ORDER_BASKET']['ITEMS'][$key]);
                }
            }
        }

        $_SESSION['AK_ORDER_BASKET']['ITEMS'][] = $value;
        $_SESSION['AK_ORDER_BASKET']['ITEMS'] = array_values($_SESSION['AK_ORDER_BASKET']['ITEMS']);//пересортировать
    }
    //очистка корзины
    public static function clear() {
        AK_Order_Basket::check();
        $_SESSION['AK_ORDER_BASKET']['ITEMS'] = array();
        //AK_Order_Basket::$amount = null;
    }
    //удаление элемента с определенным порядковым номером
    public function remove($id) {
        AK_Order_Basket::check();
        if (isset($_SESSION['AK_ORDER_BASKET']['ITEMS'][$id]) ) {
            unset($_SESSION['AK_ORDER_BASKET']['ITEMS'][$id]);
            $items = array();
            foreach ($_SESSION['AK_ORDER_BASKET']['ITEMS'] as $item) {
                $items[] = $item;
            }
            $_SESSION['AK_ORDER_BASKET']['ITEMS'] = $items;
        }
    }
    //получить элементы
    public static function getItems() {
        AK_Order_Basket::check();
        return $_SESSION['AK_ORDER_BASKET']['ITEMS'];
    }

    //получние массива цен сгруппированных по типу и ценой елемента с учетом количества - для отправки квитанций
    public static function getTotalPrices() {

        AK_Order_Basket::check();

        $countArray = AK_Order_Basket::getCountArray();

        $resultArray = array();

        foreach ($countArray as $type=>$cnt) {
            $price = new AK_Order_Prices($type);
            $priceAmountByCnt = $price->getPriceByCount($cnt);
            if (null === $priceAmountByCnt) {// цена требует уточнения либо вводимая цена
                //метод используется  для вставки в квитанции , поэтому среди элементов не может быть с неопределенной ценой, она есть в getVarPrice
                $elements = AK_Order_Basket::getElementsByType($type);
                $tp = 0;
                foreach ($elements as $element) {
                    $tp+=$element->getVarPrice();
                }
                $resultArray[] = array('type' => $type, 'count' => $cnt, 'price'=> null, 'pricecnt' => $tp );
            } else {
                $resultArray[] = array('type' => $type, 'count' => $cnt, 'price'=> $priceAmountByCnt, 'pricecnt' => $priceAmountByCnt*$cnt );
            }
        }

//        foreach ($countArray as $type=>$cnt) {
//            if (!empty(AK_Order_Basket::$amount)) {
//                $resultArray[] = array('type' => $type, 'count' => $cnt, 'price'=> $addArray[$item->typeId], 'pricecnt' => $addArray[$item->typeId]*$cnt );
//            } else {
//                $price = new AK_Order_Prices($type);
//                $resultArray[] = array('type' => $type, 'count' => $cnt, 'price'=> $price->getPriceByCount($cnt), 'pricecnt' => $price->getPriceByCount($cnt)*$cnt );
//            }
//        }

       
        return $resultArray;
    }

    //возвращает из корзины элементы типа
    public function getElementsByType($type) {
        AK_Order_Basket::check();
        $items = $_SESSION['AK_ORDER_BASKET']['ITEMS'];
        $result = array();
        foreach ($items as $item) {
           if ($item->typeId == $type){
               $result[] =  $item;
           }
        }
        return $result;
    }

    //получение общей цены. если зотя бы одна цена не определена - общая цена тоже не определена
    public static function getTotalAmount() {

        AK_Order_Basket::check();		
//Убран костыль для баланса!!!!@TODO исправить баланс
//        if (!empty(AK_Order_Basket::$amount)) {
//            return AK_Order_Basket::$amount;
//        }

        $items = $_SESSION['AK_ORDER_BASKET']['ITEMS'];
        $countArray = AK_Order_Basket::getCountArray();
        $totalPrice = null;
        foreach ($items as $item) {
            $price = $item->getPricesObject();

            $ep = $price->getPriceByCount($countArray[$item->typeId]);
            if (null !== $ep) {//цена определена
                if (null === $totalPrice) {
                    $totalPrice = 0;
                }
                $totalPrice+=intval($ep);
            } else { //если цена не определена, но установлена на этапе заказа (баланс, тариф) то прибавляем
                $varPrice = $item->getVarPrice();
                if (isset($varPrice)) {
                    $totalPrice+=intval($varPrice);
                } else {
                    return null; //если зотя бы одна цена не определена - общая цена тоже не определена
                }
            }
        }

        return $totalPrice;
    }

    public function isTotalAmountDefined() {
        if (null === AK_Order_Basket::getTotalAmount()) {
            return false;
        }

        return true;
    }
    
	// добавление только тарифов на мониторинг
	// проверка корзины
    public function isBalans() {
	    $items = $_SESSION['AK_ORDER_BASKET']['ITEMS'];
        $normal = false;
	
        foreach ($items as $item) {
          if ($item->typeId == 41) $normal=true;
		  else $normal=false;
        }		
        return $normal;
    }

    public function isBase() {
        $items = $_SESSION['AK_ORDER_BASKET']['ITEMS'];
        if (count($items) >0 && $items[0]->typeId == AK_Order_ZakazTypes::BASE_ITEM) {
            return true;
        }
        return false;
    }
    public function getBaseName() {
        if ($this->isBase()) {
            $items = $_SESSION['AK_ORDER_BASKET']['ITEMS'];
            return $items[0]->company;
        }
        return '';
    }
    public function getBaseEmail() {
        if ($this->isBase()) {
            $items = $_SESSION['AK_ORDER_BASKET']['ITEMS'];
            return $items[0]->email;
        }
        return '';
    }


    //получение строкой общей цены
    public static function getTotalAmountString() {
        $result = AK_Order_Basket::getTotalAmount();
        if (null === $result) {
            return 'Окончательная цена не определена';
        }
        
        return $result.' руб.';
    }

	public static function getTotalDiscountString() {
		
        return 0;
		if (self::getCount()>1){
		$result = AK_Order_Basket::getTotalAmount();
		$set=new AK_Order_Settings();
		$discount=$set->getDiscountBySum($result);
		
		$result=($result/100)*$discount;
		} else $result=0;
		$result=number_format((int) $result, 0, ',', ' ');
		
        return $result;
		
    }
	public static function getTotalSum(){
		$result = AK_Order_Basket::getTotalAmount();
		$result=$result-self::getTotalDiscountString();
		$result=number_format((int) $result, 0, ',', ' ');
        return $result;
		
	}
    //получение цены элемента
    public static function getElementPrice($id) {
        AK_Order_Basket::check();

        $countArray = AK_Order_Basket::getCountArray();

        $item = $_SESSION['AK_ORDER_BASKET']['ITEMS'][$id];

        $price = $item->getPricesObject();

        $ep = $price->getPriceByCount($countArray[$item->typeId]);

        if (null === $ep) {
            $ept = $item->getVarPrice();
            if (null !== $ept) {
                $ep = $ept;
            }
        } else {
            $ep=intval($ep);
        }

        return $ep;
    }


    //Цена элемента в корзине строкой
    public static function getElementPriceString($id) {
        $result = AK_Order_Basket::getElementPrice($id);
        if (null === $result) {
            return 'Цена требует уточнения';
        }

        return $result.' руб.';
    }

    //количество элементов в корзине
    public static function getCount() {
        AK_Order_Basket::check();
        return count($_SESSION['AK_ORDER_BASKET']['ITEMS']);
    }

    //получение массива с количеством элементов в корзине каждого типа
    public function getCountArray() {
        AK_Order_Basket::check();
        $items = $_SESSION['AK_ORDER_BASKET']['ITEMS'];

        $countArray = array();

        //!!!!!!!!!!!!$addArray = array();

        foreach ($items as $item) {
            if (!isset($countArray[$item->typeId])) {
                $countArray[$item->typeId] = 0;

//!!!!!!!!                if ($item->typeId == AK_Order_ZakazTypes::OPERATIONS_BALANS) {
//                    $addArray[$item->typeId] = $item->val;
//                }
            }

            $countArray[$item->typeId]++ ;
        }

        return $countArray;
    }
}
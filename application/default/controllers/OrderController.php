<?php
class OrderController extends AK_Controller_Action {


    public function indexAction() {

        $form = new AK_Form('searchForm', 'post', '/order/');
        $form->addRule('code', 'required', 'Введите номер или код заказа');
    
    if (isset($_POST['code'])){     
        $codePost=$_POST['code']; 

        if ($form->validate($codePost)) {


            if (AK_Order_Validate::isSecretCodeExists($codePost) || AK_Order_Validate::isNumberExists($codePost)) {
                $this->_redirect('/order/show/sc/'.$codePost.'/');
            }
            $this->_redirect('/order/notfound/');
        }
        else {

            //$form->setDefaults($this->params);
            $this->view->form = $form;
        }


    } else{
        $this->view->form = $form;
    }

        //$this->view->fparams = $this->params;
    }




    public function balansAction () {

        $this->params = $this->getRequest()->getParams();

        include_once('order/action.balans.php');
    }

//==========================================================================
    public function addAction () {//добавлено в корзину
        $this->view->Basket = new AK_Order_Basket;
     
    }
    public function editpayAction () {//добавлено в корзину
       include_once('order/edit.pay.php');
     
    }


    public function basketAction () {
    	if (isset($_POST['ordersBasketMoney']) || isset($_POST['ordersBasketId'])){
    		            $ordersBasketMoney = $_POST['ordersBasketMoney'];
    		            $ordersBasketId = $_POST['ordersBasketId'];
    	
    	
    	
    		                include_once ('order/action.orders.basket.php');
    	
    		        }
    	
    		        if (isset($_POST['totalamount'])){
    		            $TotalAmount=$_POST['totalamount'];
    		            //Кнопка оплатить
    		            if($this->_user->balans < AK_Order_Basket::getTotalAmount()) {
    		            // Недостатньо суми на вашому балансі.
    		            } else {
    		                include_once ('order/action.basket.php');
    		            }
    	
    		        } else{
    		         $totalamount ='';
    		        }
    	
    	$this->view->Basket = new AK_Order_Basket;
    	//         echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($this->view->Basket->getItems()); echo'</pre>';die;
    	$this->view->settings = new AK_Order_Settings();
    	$disc = $this->view->settings->get('discount');
    
    	preg_match_all('/([0-9]+):([0-9\.]+)%/', $disc,$disc1);
    	$disc = $disc1;
    	$this->view->disc = $disc;
    }

    public function basketdeleteAction () {
        $bid = (int) $this->getRequest()->getParam('bid');
        AK_Order_Basket::remove($bid);


        $this->_redirect('/order/basket/');
    }

    public function basketclearAction () {
        AK_Order_Basket::clear();
        $this->_redirect('/order/basket/');
    }
//==========================================================================


    public function createAction () {
        
        $this->view->Basket = new AK_Order_Basket;
        include_once('order/action.create.php');
        $zakItems =  AK_Order_ZakazTypes::getPriceListCC();
        $this->view->zakItems = $zakItems;
        $pricesOutput = array();
        foreach ($zakItems as $key=>$value) {
            $_price = new AK_Order_Prices($key);
            $pricesOutput[$key] = $_price->getPricesOutput();
        }
        $this->view->pricesOutput = $pricesOutput;
    }

    public function payAction () {
        include_once('order/action.pay.php');
    }

    public function balanspayAction () {
        include_once('order/action.balanspay.php');
    }

    public function createdAction () {
        $sc = $this->getRequest()->getParam('sc');
        if (empty($sc) || !AK_Order_Validate::isSecretCodeExists($sc)) {
            $this->_redirect('/order/notfound/');
        }

        $this->view->sc = $sc;
        $orderItem = new AK_Order_Item('secret_code', $sc);
        $this->view->orderItem = $orderItem;
    }

    public function epayAction () {

        $sc = $this->getRequest()->getParam('sc');
        if (empty($sc) || !AK_Order_Validate::isSecretCodeExists($sc)) {
            $this->_redirect('/order/notfound/');
        }
        $orderItem = new AK_Order_Item('secret_code', $sc);
        if ($orderItem->status == AK_Order_OrderStatus::WAITING_FOR_PAYMENT && !empty($orderItem->price)) {
            $this->view->orderItem = $orderItem;
        }
        else {
            $this->_redirect('/order/notfound/');
        }

    }

    public function esuccessAction () {

        $state = $_POST;
        if ($state['ik_payment_state'] == 'success' && $state['ik_shop_id'] == IKASSA_SHOP_ID) {
            $sc = $state['ik_payment_id'];

            if (!empty($sc) && AK_Order_Validate::isSecretCodeExists($sc)) {

                $orderItem = new AK_Order_Item('secret_code', $sc);

                if ($orderItem->status == AK_Order_OrderStatus::WAITING_FOR_PAYMENT && !empty($orderItem->price)) {

                    $this->_redirect('/order/created/sc/'.$orderItem->secretCode.'/');
                }

            }
        }
        $this->_redirect('/order/efail/');
    }



    public function estatussecrAction () {

        $state = $_POST;
        if ($state['ik_payment_state'] == 'success' && $state['ik_shop_id'] == IKASSA_SHOP_ID) {
            $sc = $state['ik_payment_id'];

            if (!empty($sc) && AK_Order_Validate::isSecretCodeExists($sc)) {

                $orderItem = new AK_Order_Item('secret_code', $sc);

                if ($orderItem->status == AK_Order_OrderStatus::WAITING_FOR_PAYMENT && !empty($orderItem->price) && intval($orderItem->price) == intval($state['ik_payment_amount'])) {

                    $orderItem->status = AK_Order_OrderStatus::PAID;
                    $orderItem->dateUpdated = time();
                    $orderItem->save();
                    AK_Order_Collection::sendOrderPaidClient($orderItem);
                    AK_Order_Collection::sendOrderPaidKurator($orderItem, $this->view);
                    foreach ($orderItem->getZakazList() as $zakaz) {
                        $zakaz->updatedDate = time();
                        $zakaz->status = AK_Order_ZakazStatus::PAID;
                        $zakaz->save();

                        if ($zakaz instanceof AK_Order_Form_Balans) {
                            $zakaz->status = AK_Order_ZakazStatus::DONE;
                            $zakaz->updatedDate = time();
                            $zakaz->save();
                            $user = new AK_Order_User('id', $zakaz->getRelation()->userId);
                            $user->balans = $user->balans+$zakaz->val;
                            $user->save();
                        }

                    }
                }


            }
        }



        die;
    }

    public function efailAction () {

    }
    //==========================================================================
    // WEBMONEY
    public function wepayAction () {
        $this->epayAction();
    }
    //Форма оповещения о платеже
    public function westatussecrAction () {

        $state = $_POST;
        if ($state['LMI_SECRET_KEY'] == WEBMONEY_SECRET_KEY && $state['LMI_PAYEE_PURSE'] == WEBMONEY_PURSE_ID) {
            $sc = $state['LMI_PAYMENT_NO'];

            if (!empty($sc) && AK_Order_Validate::isSecretCodeExists($sc)) {

                $orderItem = new AK_Order_Item('secret_code', $sc);

                if ($orderItem->status == AK_Order_OrderStatus::WAITING_FOR_PAYMENT && !empty($orderItem->price) && intval($orderItem->price) == intval($state['LMI_PAYMENT_AMOUNT'])) {

                    $orderItem->status = AK_Order_OrderStatus::PAID;
                    $orderItem->dateUpdated = time();
                    $orderItem->save();
                    AK_Order_Collection::sendOrderPaidClient($orderItem);
                    AK_Order_Collection::sendOrderPaidKurator($orderItem, $this->view);
                    foreach ($orderItem->getZakazList() as $zakaz) {
                        $zakaz->updatedDate = time();
                        $zakaz->status = AK_Order_ZakazStatus::PAID;
                        $zakaz->save();

                        if ($zakaz instanceof AK_Order_Form_Balans) {
                            $zakaz->status = AK_Order_ZakazStatus::DONE;
                            $zakaz->updatedDate = time();
                            $zakaz->save();
                            $user = new AK_Order_User('id', $zakaz->getRelation()->userId);
                            $user->balans = $user->balans+$zakaz->val;
                            $user->save();
                        }

                    }
                }


            }
        }



        die;
    }
    public function wesuccessAction () {

        $state = $_POST;
        if ($state['LMI_PAYMENT_NO']) {
            $sc = $state['LMI_PAYMENT_NO'];

            if (!empty($sc) && AK_Order_Validate::isSecretCodeExists($sc)) {

                $orderItem = new AK_Order_Item('secret_code', $sc);

                if ($orderItem->status == AK_Order_OrderStatus::WAITING_FOR_PAYMENT && !empty($orderItem->price)) {

                    $this->_redirect('/order/created/sc/'.$orderItem->secretCode.'/');
                }

            }
        }
        $this->_redirect('/order/efail/');
    }

    //==========================================================================
    //ROBOKASSA
    public function epay2Action () {


        $sc = $this->getRequest()->getParam('sc');
        if (empty($sc) || !AK_Order_Validate::isSecretCodeExists($sc)) {
            $this->_redirect('/order/notfound/');
        }
        $orderItem = new AK_Order_Item('secret_code', $sc);
        if ($orderItem->status == AK_Order_OrderStatus::WAITING_FOR_PAYMENT && !empty($orderItem->price)) {
            // your registration data
            $mrh_login = RKASSA_LOGIN; // your login here
            $mrh_pass1 = RKASSA_PASSWORD; // merchant pass1 here
            // order properties
            $inv_id = $orderItem->id; // shop's invoice number
            // (unique for shop's lifetime)
            $inv_desc = '';//"Оплата заказа \#".$orderItem->number." на сайте ".SITE_NAME; // invoice desc
            $out_summ = $orderItem->price.".00"; // invoice summ
            // build CRC value
            $crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");
            // build URL
           // $url = "http://test.robokassa.ru/Index.aspx?MrchLogin=$mrh_login&". "OutSum=$out_summ&InvId=$inv_id&Desc=$inv_desc&SignatureValue=$crc";
            $url = "https://merchant.roboxchange.com/Index.aspx?MrchLogin=$mrh_login&". "OutSum=$out_summ&InvId=$inv_id&Desc=$inv_desc&SignatureValue=$crc";
            $this->view->purl = $url;
            $this->view->orderItem = $orderItem;
        }
        else {
            $this->_redirect('/order/notfound/');
        }

    }

    public function estatussecr2Action () {

        // as a part of ResultURL script
        
        // your registration data
        $mrh_pass2 = RKASSA_PASSWORD;   // merchant pass2 here
        
        // HTTP parameters:
        $out_summ = $_REQUEST["OutSum"];
        $inv_id = $_REQUEST["InvId"];
        $crc = $_REQUEST["SignatureValue"];
        
        // HTTP parameters: $out_summ, $inv_id, $crc
        $crc = strtoupper($crc);   // force uppercase
        
        // build own CRC
        $my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2"));
        
        if (strtoupper($my_crc) != strtoupper($crc)) {
            echo "bad sign\n";
            exit();
        }
        
        // print OK signature
        echo "OK$inv_id\n";
        
        // perform some action (change order state to paid)</xmp>
        $orderItem = new AK_Order_Item('id', $inv_id);
        if (!empty($orderItem->id)) {

            if ($orderItem->status == AK_Order_OrderStatus::WAITING_FOR_PAYMENT && !empty($orderItem->price)) {

                $orderItem->status = AK_Order_OrderStatus::PAID;
                $orderItem->dateUpdated = time();
                $orderItem->save();
                AK_Order_Collection::sendOrderPaidClient($orderItem);
                AK_Order_Collection::sendOrderPaidKurator($orderItem, $this->view);
                foreach ($orderItem->getZakazList() as $zakaz) {
                    $zakaz->updatedDate = time();
                    $zakaz->status = AK_Order_ZakazStatus::PAID;
                    $zakaz->save();

                    if ($zakaz instanceof AK_Order_Form_Balans) {
                        $zakaz->status = AK_Order_ZakazStatus::DONE;
                        $zakaz->updatedDate = time();
                        $zakaz->save();
                        $user = new AK_Order_User('id', $zakaz->getRelation()->userId);
                        $user->balans = $user->balans+$zakaz->val;
                        $user->save();
                    }

                }
            }

        }
        die;
    }

    public function esuccess2Action () {


        // as a part of SuccessURL script

        // your registration data
        $mrh_pass1 = RKASSA_PASSWORD;  // merchant pass1 here

        // HTTP parameters:
        $out_summ = $_REQUEST["OutSum"];
        $inv_id = $_REQUEST["InvId"];
        $crc = $_REQUEST["SignatureValue"];

        $crc = strtoupper($crc);  // force uppercase

        // build own CRC
        $my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass1"));

        if (strtoupper($my_crc) != strtoupper($crc)) {
            $this->_redirect('/order/efail/');
        }

        $orderItem = new AK_Order_Item('id', $inv_id);
        if (!empty($orderItem->id)) {

            
            if ($orderItem->status == AK_Order_OrderStatus::WAITING_FOR_PAYMENT && !empty($orderItem->price)) {
                $this->_redirect('/order/created/sc/'.$orderItem->secretCode.'/');
            }
        }

        $this->_redirect('/order/efail/');
    }






    //==========================================================================
    public function showAction() {
        $sc = $this->getRequest()->getParam('sc');
        if (empty($sc) || (!AK_Order_Validate::isSecretCodeExists($sc) && !AK_Order_Validate::isNumberExists($sc))) {
            $this->_redirect('/order/notfound/');
        }
        
        


        if (AK_Order_Validate::isNumberExists($sc)) {
            $orderItem = new AK_Order_Item('number', $sc);
        }
        else {
            $orderItem = new AK_Order_Item('secret_code', $sc);
        }

        if ($orderItem->status == AK_Order_OrderStatus::READY) {
			if($orderItem->isBalans()){
				$orderItem->status = AK_Order_OrderStatus::BALANS;
			}else{
				$orderItem->status = AK_Order_OrderStatus::DONE;
			}
            $orderItem->save();
            AK_Order_Collection::sendOrderViwed($orderItem, $this->view);
        }
        $this->view->orderItem = $orderItem;        
      
        $this->view->sc = $sc;

//include_once('index/action.index.php');
    }

    public function notfoundAction () {

    }

    public function cancelAction()
    {
        include_once ('order/action.cancel.php');
    }

    public function showbalansAction()
    {

        $sc = $this->getRequest()->getParam('sc');
        if (empty($sc) || (!AK_Order_Validate::isSecretCodeExists($sc) && !AK_Order_Validate::isNumberExists($sc))) {
            $this->_redirect('/order/notfound/');
        }

        if (AK_Order_Validate::isNumberExists($sc)) {
            $orderItem = new AK_Order_Item('number', $sc);
        }
        else {
            $orderItem = new AK_Order_Item('secret_code', $sc);
        }
        
        if ($orderItem->status == AK_Order_OrderStatus::READY) {
            if($orderItem->isBalans()){
                $orderItem->status = AK_Order_OrderStatus::BALANS;
            }else{
                $orderItem->status = AK_Order_OrderStatus::DONE;
            }
            $orderItem->status = AK_Order_OrderStatus::BALANS;
            $orderItem->save();
            AK_Order_Collection::sendOrderViwed($orderItem, $this->view);
        }
        //Zend_Debug::dump($orderItem->relationsUser);
        $this->view->orderItem = $orderItem;
        $this->view->sc = $sc;
    }


}

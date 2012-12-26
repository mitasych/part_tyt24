<?php

class AK_Order_Collection {

    public function sendBeznalKurator($order, $view) {

        if ($order->isBalans()) {
            $body='Заказ на пополнение баланса. Клиентом выписан счет.<br><br>';
            $body.='Страница заказа <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a>';
        }
        else {
            $body='Заказ ожидает оплаты. Клиентом выписан счет.<br><br>';
            $body.='Страница заказа <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a>';
        }

        $_variables = new AK_System_Variables();
        $settings = new AK_Order_Settings();
        require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

        $mail = new PHPMailer();
        $body = eregi_replace("[\]",'',$body);

        $mail->From       = $_variables->get('email_online');
        $mail->FromName   = 'Администрация сайта '.SITE_NAME;
        $mail->Subject    = 'Заказ №'.$order->number.' принят на сайте '.SITE_NAME;

        $view->orderItem = $order;
        $body.= '<br />'.$view->getContents('order/order_info.tpl');
        $body.= '<p><b>Заказчик:</b>&nbsp;'.$order->company;
		//$body.= '</p>';//
		$body.= '<p><b>E-mail:</b>&nbsp;'.$order->email;

        $mail->AltBody = strip_tags(($body));
        $mail->MsgHTML($body);

        $mail->AddAddress($settings->get('adminemailforcopiesb2bbaseru'));
        $mail->Send();
    }

    public function sendNalKurator($order, $view) {

        if ($order->isBalans()) {
            $body='Заказ на пополнение баланса. Клиентом выписана квитанция.<br><br>';
            $body.='Страница заказа <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a>';
        }
        else {
            $body='Заказ ожидает оплаты. Клиентом выписана квитанция.<br><br>';
            $body.='Страница заказа <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a>';
        }

        $_variables = new AK_System_Variables();
        $settings = new AK_Order_Settings();
        require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

        $mail = new PHPMailer();
        $body = eregi_replace("[\]",'',$body);

        $mail->From       = $_variables->get('email_online');
        $mail->FromName   = 'Администрация сайта '.SITE_NAME;
        $mail->Subject    = 'Заказ №'.$order->number.' принят на сайте '.SITE_NAME;

        $view->orderItem = $order;
        $body.= '<br />'.$view->getContents('order/order_info.tpl');
        $body.= '<p><b>Заказчик:</b>&nbsp;'.$order->company;
		//$body.= '</p>';//
		$body.= '<p><b>E-mail:</b>&nbsp;'.$order->email;

        $mail->AltBody = strip_tags(($body));
        $mail->MsgHTML($body);

        $mail->AddAddress($settings->get('adminemailforcopiesb2bbaseru'));
        $mail->Send();
    }

    public function sendBeznalClient($order) {

        $fileContent = file_get_contents(INVOICE_DIR.'/invoiceinsert.rtf');
        $rowContent = file_get_contents(INVOICE_DIR.'/row.txt');

        $settings = new AK_Order_Settings();

        $fileContent = str_replace('XXXXX1', $settings->get('organization'), $fileContent);
        $fileContent = str_replace('XXXXX2', $settings->get('uraddr'), $fileContent);
        $fileContent = str_replace('XXXXX3', $settings->get('factaddr'), $fileContent);
        $fileContent = str_replace('XXXXX4', $settings->get('telfax'), $fileContent);
        $fileContent = str_replace('XXXXX5', $settings->get('inn'), $fileContent);
        $fileContent = str_replace('XXXXX6', $settings->get('kpp'), $fileContent);
        $fileContent = str_replace('XXXXX7', $settings->get('receiver'), $fileContent);
        $fileContent = str_replace('XXXXX8', $settings->get('receiverschet'), $fileContent);
        $fileContent = str_replace('XXXXX9', $settings->get('bik'), $fileContent);
        $fileContent = str_replace('XXXX10', $settings->get('receiverbank'), $fileContent);
        $fileContent = str_replace('XXXX11', $settings->get('schet'), $fileContent);

        $fileContent = str_replace('XXXX12', $order->number, $fileContent);
        $fileContent = str_replace('XXXX13', date('d/m/Y'), $fileContent);

        $fileContent = str_replace('XXXX14', $order->zaku, $fileContent);
        $fileContent = str_replace('XXXX15', $order->platu, $fileContent);

        $fileContent = str_replace('XXXX19', $settings->get('gendirector'), $fileContent);
        $fileContent = str_replace('XXXX20', $settings->get('glavbuh'), $fileContent);

        $fileContent = str_replace('DDDDD55', $settings->get('primechanie'), $fileContent);

        $_cnt = 0;
        $_totalcount = 0;
        $_totalprice = 0;
        $_types = AK_Order_ZakazTypes::getPriceList();
        $_rows = '';

        if ($order->id) {
            $tpArray = $order->getTotalPrices();
        }
        else {
            $tpArray = AK_Order_Basket::getTotalPrices();
        }


        foreach ($tpArray as $_item) {
            $_cnt++;
            $addinfo = '';
            if ($_item['type'] == AK_Order_ZakazTypes::BASE_ITEM) {
                $addinfoA = array();
                foreach ($order->getZakazList() as $_z) {
                    if ($_z->typeId == $_item['type']) {
                        $addinfoA[] = $_z->text;
                    }
                }
                $addinfo = ' '.implode(', ',$addinfoA);
            }
            $currentRowContent = str_replace('TTTT1', $_cnt, $rowContent);
            $currentRowContent = str_replace('TTTT2', $_types[$_item['type']].$addinfo, $currentRowContent);
            $currentRowContent = str_replace('TTTT3', $_item['count'], $currentRowContent);
            $currentRowContent = str_replace('TTTT4', (null === $_item['price'])?'':($_item['price'].',00'), $currentRowContent);
            $currentRowContent = str_replace('TTTT5', $_item['pricecnt'].',00', $currentRowContent);
            $_rows.=$currentRowContent;

            $_totalcount = $_totalcount + $_item['count'];
            $_totalprice = $_totalprice + $_item['pricecnt'];

        }

        $fileContent = str_replace('INSERTROWSHERE', $_rows, $fileContent);
        $fileContent = str_replace('SSSSS1', $_totalcount, $fileContent);
        $fileContent = str_replace('XXXX17', $_totalprice.',00', $fileContent);
        $fileContent = str_replace('XXXX18', AK_Common_Functions::num2str($_totalprice.',00'), $fileContent);


        $tmpfname = tempnam(INVOICE_DIR."/tmp", "INV_BEZNAL_");
        $handle = fopen($tmpfname, "w");
        fwrite($handle, iconv("UTF-8", "CP1251", $fileContent));
        fclose($handle);

        if ($order->isBalans()) {
            $body='Ваш заказ на пополнение баланса принят и ожидает оплаты. Счет для оплаты находится во вложении.<br><br>';
            $body.='Страница заказа <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a><br><br>';
            $body.='Благодарим Вас за сотрудничество!<br>';
            $body.='С уважением,<br>';
            $body.='Администрация сайта: '.$order->placeCreated;
        }
        else {
            $body='Ваш заказ принят и ожидает оплаты. Счет для оплаты находится во вложении.<br><br>';
            $body.='Страница заказа <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a><br><br>';
            $body.='Благодарим Вас за сотрудничество!<br>';
            $body.='С уважением,<br>';
            $body.='Администрация сайта: '.$order->placeCreated;
        }

        $_variables = new AK_System_Variables();

        require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

        $mail = new PHPMailer();
        $body = eregi_replace("[\]",'',$body);

        $mail->From       = $_variables->get('email_online');
        $mail->FromName   = 'Администрация сайта '.SITE_NAME;
        $mail->Subject    = 'Заказ №'.$order->number.' принят на сайте '.SITE_NAME;

        $mail->AltBody = strip_tags(($body));
        $mail->MsgHTML($body);

        $mail->AddAttachment($tmpfname, 'invoice_'.$order->number.'.rtf');

        $mail->AddAddress($order->email, $order->company);
        $mail->Send();


//        $mail->ClearAddresses();
//        $mail->AddAddress($settings->get('adminemailforcopiesb2bbaseru'));
//        $mail->Send();

        unlink($tmpfname);
    }

    public function sendNalClient($order) {

        $fileContent = file_get_contents(INVOICE_DIR.'/invoice2.rtf');

        $settings = new AK_Order_Settings();

        $fileContent = str_replace('XXXXX1', $settings->get('organization'), $fileContent);
        $fileContent = str_replace('XXXXX2', $settings->get('inn').'/'.$settings->get('kpp'), $fileContent);
        $fileContent = str_replace('XXXXX3', $settings->get('receiverschet'), $fileContent);
        $fileContent = str_replace('XXXXX4', $settings->get('receiverbank'), $fileContent);
        $fileContent = str_replace('XXXXX5', $settings->get('receiver'), $fileContent);
        $fileContent = str_replace('XXXXX6', $settings->get('bik'), $fileContent);
        $fileContent = str_replace('XXXXX7', $settings->get('schet'), $fileContent);
        $fileContent = str_replace('XXXXX8', $settings->get(''), $fileContent);

        if ($order->isBalans()) {
            $body='Ваш заказ на пополнение баланса принят и ожидает оплаты. Квитанция для оплаты находится во вложении.<br><br>';
            $body.='Страница заказа <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a><br><br>';
            $body.='Благодарим Вас за сотрудничество!<br>';
            $body.='С уважением,<br>';
            $body.='Администрация сайта: '.$order->placeCreated;
        }
        else {
            $body='Ваш заказ принят и ожидает оплаты. Квитанция для оплаты находится во вложении.<br><br>';
            $body.='Страница заказа <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a><br><br>';
            $body.='Благодарим Вас за сотрудничество!<br>';
            $body.='С уважением,<br>';
            $body.='Администрация сайта: '.$order->placeCreated;
        }

        $_variables = new AK_System_Variables();

        require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

        $mail = new PHPMailer();
        $body = eregi_replace("[\]",'',$body);

        $mail->From       = $_variables->get('email_online');
        $mail->FromName   = 'Администрация сайта '.SITE_NAME;
        $mail->Subject    = 'Заказ №'.$order->number.' принят на сайте '.SITE_NAME;

        $mail->AltBody = strip_tags(($body));
        $mail->MsgHTML($body);

        $mail->AddAddress($order->email, $order->company);

        $_types = AK_Order_ZakazTypes::getPriceList();
        $cnt = 0;
        $tmpFiles = array();


        if ($order->id) {
            $tpArray = $order->getTotalPrices();
        }
        else {
            $tpArray = AK_Order_Basket::getTotalPrices();
        }

        foreach ($tpArray as $_item) {
            $tmpFileContent = str_replace('XXXXX9', $_types[$_item['type']].' ('.$_item['count'].') №'.$order->number, $fileContent);
            $tmpFileContent = str_replace('SSSSS', $_item['pricecnt'], $tmpFileContent);

            $tmpfname = tempnam(INVOICE_DIR."/tmp", "INV_NAL_");
            $tmpFiles[] = $tmpfname;
            $handle = fopen($tmpfname, "w");
            fwrite($handle, iconv("UTF-8", "CP1251", $tmpFileContent));
            fclose($handle);

            $cnt++;
            $mail->AddAttachment($tmpfname, 'invoice_'.$order->number.'_'.$cnt.'.rtf');

        }

        $mail->Send();

//        $mail->ClearAddresses();
//        $mail->AddAddress($settings->get('adminemailforcopiesb2bbaseru'));
//        $mail->Send();

        foreach ($tmpFiles as $tmpfname) {
            unlink($tmpfname);
        }
    }


    public function sendOrderCreatedClient($order) {


            $body='Ваш заказ принят и ожидает оплаты.<br><br>';
            $body.='Вы можете выбрать удобный способ оплаты и произвести платеж либо получить счет/квитанцию на странице заказа <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a><br><br>';
            $body.='Благодарим Вас за сотрудничество!<br>';
            $body.='С уважением,<br>';
            $body.='Администрация сайта: '.$order->placeCreated;


        $_variables = new AK_System_Variables();

        require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

        $mail = new PHPMailer();
        $body = eregi_replace("[\]",'',$body);

        $mail->From       = $_variables->get('email_online');
        $mail->FromName   = 'Администрация сайта '.$order->placeCreated;
        $mail->Subject    = 'Заказ №'.$order->number.' принят и ожидает оплаты';

        $mail->AltBody = strip_tags(($body));
        $mail->MsgHTML($body);

        $mail->AddAddress($order->email);
        $mail->Send();
    }

    public function sendEventCreatedClient($event) {

        $_db = Zend_Registry :: get('DBORDER');

        $sql = $_db->select()->distinct()->from('orders_users__accounts AS A', 'id')
            ->joinLeft('orders_users__monitoring_tarifs AS B', 'B.user_id = A.id', null)
            ->joinLeft('orders_users__kontragents AS C', 'C.user_id = A.id', null)
            ->where('C.kontragent_id = ?', $event->kontragentId)
            ->where('B.end_date_kurator <= ?', time());
        $res =  $_db->fetchCol($sql);

        $body='У контрагента внесенного в список мониторинга '.SITE_NAME.' произошло новое событие.<br>';
        $body.='Дата события: '.$event->getEventDateFormatted().'<br>';
        $body.='Тема события: '.$event->getEventTypeTitle().'<br>';
        $body.='<a href="'.SITE_URL.'/monitoring/event/'.$event->id.'/">подробнее</a>';

        $_variables = new AK_System_Variables();

        require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

        foreach ($res as $userId) {

            $user = new AK_Order_User('id', $userId);

            $mail = new PHPMailer();
            $body = eregi_replace("[\]",'',$body);

            $mail->From       = $_variables->get('email_online');
            $mail->FromName   = 'Администрация сайта '.SITE_NAME;
            $mail->Subject    = 'Новое событие';
            
            $mail->AltBody = strip_tags(($body));
            $mail->MsgHTML($body);

            $mail->AddAddress($user->email);
            $mail->Send();
        }


    }


    public function sendOrderCreatedKurator($order, $view) {

        $body='Принят новый заказ<br>';
        $body.='Для того чтобы перейти на станицу заказа перейдите по ссылке <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a><br>';
        $body.='Статус: '.$order->getStatusLabel();

        $_variables = new AK_System_Variables();
        $settings = new AK_Order_Settings();
        require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

        $mail = new PHPMailer();
        $body = eregi_replace("[\]",'',$body);

        $mail->From       = $_variables->get('email_online');
        $mail->FromName   = 'Администрация сайта '.SITE_NAME;
        $mail->Subject    = 'Заказ №'.$order->number.' принят на сайте '.SITE_NAME;

        $view->orderItem = $order;
        $body.= '<br />'.$view->getContents('order/order_info.tpl');
        $body.= '<p><b>Заказчик:</b>&nbsp;'.$order->company;
		//$body.= '</p>';//
		$body.= '<p><b>E-mail:</b>&nbsp;'.$order->email;

        $mail->AltBody = strip_tags(($body));
        $mail->MsgHTML($body);

        $mail->AddAddress($settings->get('adminemailforcopiesb2bbaseru'));
        $mail->Send();
    }

    public function sendOrderCreatedNoprice($order, $view) {

        $body='Принят новый заказ. Заказ ожидает оценки.<br>';
        $body.='Страница заказа <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a>';

        $_variables = new AK_System_Variables();
        $settings = new AK_Order_Settings();
        require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

        $mail = new PHPMailer();
        $body = eregi_replace("[\]",'',$body);

        $mail->From       = $_variables->get('email_online');
        $mail->FromName   = 'Администрация сайта '.SITE_NAME;
        $mail->Subject    = 'Заказ №'.$order->number.' ожидает оценки '.SITE_NAME;

        $view->orderItem = $order;
        $body.= '<br />'.$view->getContents('order/order_info.tpl');
        $body.= '<p><b>Заказчик:</b>&nbsp;'.$order->company;
		//$body.= '</p>';//
		$body.= '<p><b>E-mail:</b>&nbsp;'.$order->email;

        $mail->AltBody = strip_tags(($body));
        $mail->MsgHTML($body);

        $mail->AddAddress($settings->get('adminemailforcopiesb2bbaseru'));
        $mail->Send();
    }

    public function sendOrderViwed($order, $view) {

        $body='Заказ получен<br>';
        $body.='Страница заказа <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a>';

        $_variables = new AK_System_Variables();
        $settings = new AK_Order_Settings();
        require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

        $mail = new PHPMailer();
        $body = eregi_replace("[\]",'',$body);

        $mail->From       = $_variables->get('email_online');
        $mail->FromName   = 'Администрация сайта '.SITE_NAME;
        $mail->Subject    = 'Заказ №'.$order->number.' получен на сайте '.SITE_NAME;

        $view->orderItem = $order;
        $body.= '<br />'.$view->getContents('order/order_info.tpl');

        $mail->AltBody = strip_tags(($body));
        $mail->MsgHTML($body);

        $mail->AddAddress($settings->get('adminemailforcopiesb2bbaseru'));
        $mail->Send();
    }

    public function sendOrderPriceDetected($order) {

        $body='Ваш заказ оценен и будет предоставлен после его оплаты.<br><br>';
        $body.='Вы можете выбрать удобный способ оплаты и произвести платеж либо получить счет/квитанцию на странице заказа <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a><br><br>';
        $body.='Благодарим Вас за сотрудничество!<br>';
        $body.='С уважением,<br>';
        $body.='Администрация сайта: '.$order->placeCreated;

        $_variables = new AK_System_Variables();

        require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

        $mail = new PHPMailer();
        $body = eregi_replace("[\]",'',$body);

        $mail->From       = $_variables->get('email_online');
        $mail->FromName   = 'Администрация сайта '.$order->placeCreated;
        $mail->Subject    = 'Заказ №'.$order->number.' ожидает оплаты';

        $mail->AltBody = strip_tags(($body));
        $mail->MsgHTML($body);

        $mail->AddAddress($order->email);
        $mail->Send();
    }

    public function sendOrderReady($order) {

        $body='Ваш заказ исполнен.<br><br>';
        $body.='Заказ можно получить на странице заказа <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a><br><br>';
        $body.='Благодарим Вас за сотрудничество!<br>';
        $body.='С уважением,<br>';
        $body.='Администрация сайта: '.$order->placeCreated;

        $_variables = new AK_System_Variables();

        require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

        $mail = new PHPMailer();
        $body = eregi_replace("[\]",'',$body);

        $mail->From       = $_variables->get('email_online');
        $mail->FromName   = 'Администрация сайта '.$order->placeCreated;
        $mail->Subject    = 'Заказ №'.$order->number.' исполнен';

        $mail->AltBody = strip_tags(($body));
        $mail->MsgHTML($body);

        $mail->AddAddress($order->email);
        $mail->Send();
    }

    public function sendOrderPaidClient($order) {

        if ($order->isBalans()) {
            $body='Ваш баланс на сумму '.$order->price.' пополнен.<br><br>';
            $body.='Страница заказа <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a><br><br>';
            $body.='Благодарим Вас за сотрудничество!<br>';
            $body.='С уважением,<br>';
            $body.='Администрация сайта: '.$order->placeCreated;
        }
        else {
            $body='Ваш заказ оплачен и находится на исполнении. В ближайшее время Вы получите уведомление о его готовности.<br><br>';
            $body.='Страница заказа <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a><br><br>';
            $body.='Благодарим Вас за сотрудничество!<br>';
            $body.='С уважением,<br>';
            $body.='Администрация сайта: '.$order->placeCreated;
        }

        $_variables = new AK_System_Variables();

        require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

        $mail = new PHPMailer();
        $body = eregi_replace("[\]",'',$body);

        $mail->From       = $_variables->get('email_online');
        $mail->FromName   = 'Администрация сайта '.$order->placeCreated;
        $mail->Subject    = 'Заказ №'.$order->number.' оплачен';

        $mail->AltBody = strip_tags(($body));
        $mail->MsgHTML($body);

        $mail->AddAddress($order->email);
        $mail->Send();
    }

    public function sendOrderPaidKurator($order, $view) {

        if ($order->isBalans()) {
            $body='Клиент '.$order->company.'('.$order->email.') пополнил баланс на сумму '.$order->price.'. Платежная система '.$order->getMoneyLabel();
        }
        else {
            $body='Заказ оплачен<br>';
            $body.='Страница заказа <a href="'.SITE_URL.'/order/show/sc/'.$order->secretCode.'/">'.SITE_URL.'/order/show/sc/'.$order->secretCode.'</a>';
        }

        $_variables = new AK_System_Variables();
        $settings = new AK_Order_Settings();
        require_once(LIBRARY_DIR.'/phpMailer/class.phpmailer.php');

        $mail = new PHPMailer();
        $body = eregi_replace("[\]",'',$body);

        $mail->From       = $_variables->get('email_online');
        $mail->FromName   = 'Администрация сайта '.SITE_NAME;
        $mail->Subject    = 'Заказ №'.$order->number.' оплачен на сайте '.SITE_NAME;

        $view->orderItem = $order;
        $body.= '<br />'.$view->getContents('order/order_info.tpl');
        $body.= '<p><b>Заказчик:</b>&nbsp;'.$order->company;
		//$body.= '</p>';//
		$body.= '<p><b>E-mail:</b>&nbsp;'.$order->email;

        $mail->AltBody = strip_tags(($body));
        $mail->MsgHTML($body);

        $mail->AddAddress($settings->get('adminemailforcopiesb2bbaseru'));
        $mail->Send();
    }

}
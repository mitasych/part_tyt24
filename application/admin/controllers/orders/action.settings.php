<?php





$settings = new AK_Order_Settings();
if ($this->getRequest()->getParam('settings')) {
    $p = $this->getRequest()->getParam('settings');
    foreach ($p as $key=>$value) {
        $this->view->updateMessage = 'Изменения сохранены';
        $settings->set($key, $value);
    }
}

$this->view->settings = $settings;

//$settings2 = new AK_Order_SettingNotTest();
//return $settings2->get();
<?php

if (!empty($this->params['CHECK_ELEMENTS'])) {
    foreach($this->params['CHECK_ELEMENTS'] as &$_value){
        $currentItem = new AK_Menu_Link_Item(intval($_value));
        $currentItem->delete();
    }
}

$this->_redirect(MODULE_URL.'/menu/links.list/');
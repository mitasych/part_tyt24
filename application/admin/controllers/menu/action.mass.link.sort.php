<?php

if (!empty($this->params['CHECK_ELEMENTS']) && !empty($this->params['SORT_ELEMENTS'])) {
    
    foreach($this->params['SORT_ELEMENTS'] as $_key => &$_value){
        if (in_array($_key, $this->params['CHECK_ELEMENTS'])) {
          $currentItem = new AK_Menu_Link_Item(intval($_key));
          $currentItem->setQueue(intval($_value));
          $currentItem->save();
        }
    }
    
}

$this->_redirect(MODULE_URL.'/menu/links.list/');

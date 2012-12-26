<?php
        $this->params  = $this->getRequest()->getParams();
        
        if (!empty($this->params['CHECK_ELEMENTS']) && !empty($this->params['SORT_ELEMENTS'])) {

            foreach($this->params['SORT_ELEMENTS'] as $_key => &$_value) {
                if (in_array($_key, $this->params['CHECK_ELEMENTS'])) {
                    $currentItem = new AK_Order_Pay_Item(intval($_key));
                    $currentItem->order = $_value;
                    $currentItem->save();
                }
            }

        }

        $this->_redirect(MODULE_URL.'/orders/pay/');
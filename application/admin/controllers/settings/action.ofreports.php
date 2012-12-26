<?php

$_variables = new AK_System_Variables();

$form = new AK_Form('editItem', 'post', MODULE_URL.'/settings/ofreports/');

if ($form->isPostback()){
    $form->setDefaults($this->params);  
} else {
    $this->view->ofreports = $_variables->get('official_reports');
    $this->view->checked = $_variables->get('official_reports')==1 ? 'checked' : '';
}

if ($form->validate($this->params)){
// 	echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($this->params['ofreports']); echo'</pre>';die;
	$value = $this->params['ofreports'] ? 1 : 0;
    
    $_variables->set('official_reports', (int) $value, 'int');
    $this->_redirect(MODULE_URL.'/settings/');
}

$this->view->form = $form;

<?php
$url = substr($this->_request->getRequestUri(),15,999);

// можно обрабатывать куда ушли пользователи 
isset($this->params['to'])?$this->_redirect($url):$this->_redirect(SITE_URL);

?>

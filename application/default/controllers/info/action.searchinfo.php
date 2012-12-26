<?php

$this->view->searchinfo =  iconv('cp1251', 'utf-8', file_get_contents('http://customs.consultant.ru/info.asp'));
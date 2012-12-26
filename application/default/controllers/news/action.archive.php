<?php
$this->params['page'] = !empty($this->params['page'])?intval($this->params['page']):1;

$newsList = new AK_News_List();
$newsList = $newsList->setOrder('create_date DESC')->addWhere('is_active = 1')->setListSize(10)->setCurrentPage($this->params['page']+1); 

// Paging
        
$url = '/news/archive';
$cnt = $newsList->getCount()-10;
if ($cnt<0) $cnt=0;
$P = new AK_Common_Paging($cnt, 10, $url);
$this->view->paging = $P->makePaging($this->params['page']);
        
$newsList = $newsList->getList();

/*for ($i=0; $i<10; $i++)
{
    if (!empty($newsList))
    {
        $_tmp = array_shift($newsList);
    }
}*/

$this->view->newsList = $newsList;

       

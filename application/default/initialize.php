<?php
      $okato = (isset($this->params['okato']) && !empty($this->params['okato']) && ($this->params['okato'] !== 'sort') && ($this->params['okato'] !== 'all'))?$this->params['okato']:null;
      $okved = (isset($this->params['okved']) && !empty($this->params['okved']) && ($this->params['okved'] !== 'all'))?$this->params['okved']:null;
      $what  = isset($this->params['what'])?$this->params['what']:'';
      $where = isset($this->params['where'])?$this->params['where']:'';
      $page  = isset($this->params['page'])?$this->params['page']:1;
      $show  = isset($this->params['show'])?$this->params['show']:'';
      $show2 = isset($this->params['show2'])?$this->params['show2']:'';
      $sort  = isset($this->params['sort'])?$this->params['sort']:'';
      $sort2 = isset($this->params['sort2'])?$this->params['sort2']:'';
      $id    = isset($this->params['id'])?$this->params['id']:null;

      $filter = new Zend_Filter_Alpha(true);

      $where = $filter->filter((string)$where);
      $show = $filter->filter((string)$show);
      $show2 = $filter->filter((string)$show2);


      $filter = new Zend_Filter_Alnum();
      $what = $filter->filter((string)$what);
      $okved  = $filter->filter($okved);
      $okato  = $filter->filter($okato);
      $page   = $filter->filter($page);
      $sort   = $filter->filter($sort);
      $sort2  = $filter->filter($sort2);

      $filter = new Zend_Filter_Alpha();
if (isset($id))
{     
      $id[0]    = !empty($id[0])?$this->params['id']:null;
      $id[1]    = !empty($id[1])?$this->params['id']:null;
      $id = $filter->filter($id[0].$id[1]);
      if ($id=='') $id='*';
      $this->view->id = $id;
}






$this->view->sort = $sort;
$this->view->sort2 = $sort2;

?>

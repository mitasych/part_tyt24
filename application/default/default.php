<?php
//-------------------------------------------------------------------------------------------------------------------------------
// NEWS
//-------------------------------------------------------------------------------------------------------------------------------
  $old=1;
  $RequestUrl = $this->_request->getRequestUri();
  $this->view->RequestUrl = $RequestUrl;
  //$RequestUrl1 = $this->_request->getRequestUrl();
  //print $RequestUrl.'==';
  $_links = new AK_Menu_Link_List();
  $_links = $_links->addWhere("A.menu_id = 3")->addWhere("A.is_active = 1")->setOrder('A.queue ASC')->getList();

  foreach ($_links as $_key => &$_link)
  {
    if ($RequestUrl===$_link->getLink())
    {
    
    $newsList = new AK_News_List();
    $newsList = $newsList->addWhere('category_id = ?',$_link->getId())->setOrder('create_date DESC')->setCurrentPage(1)->setListSize(10)->getList();
    $this->view->news = $newsList;
    $old=0;
    }
  }
if ($old==1)
{
$_news = new AK_News_List();
$_news = $_news->setCurrentPage(1)->setListSize(3)->addWhere('A.is_active = ?',1)->setOrder('A.create_date DESC')->getList();

$this->view->news = $_news;
$this->view->variables = new AK_System_Variables();
//$this->view->RequestUrl = $RequestUrl;
}

$menulist = new AK_company_ListShort();
//$company_count = $menulist->getCount();
//формируем список предприятий для меню слева, первые 7 предприятий по id из базы.
$menulist = $menulist->setCurrentPage(1)->setListSize(7)->setOrder('A.id ASC')->getList();
$this->view->leftmenu = $menulist;
//$this->view->company_count = $company_count;

//Reports Left Menu
$reports = new AK_Order_Report_List();
$reports->addWhere('A.report_menu = 1');
$reports = $reports->getList(1);

$this->view->reportsMenu = $reports;

$this->view->controllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();

////-------------------------------------------------------------------------------------------------------------------------------
//LOGIN FORM
//-------------------------------------------------------------------------------------------------------------------------------
if (! $this->_user->isAuthenticated() /*&& !($controllerName =='users' && Warecorp::$actionName == 'login')*/) {
    $form = new AK_Form('loginForm', 'post', SITE_URL.'/users/login/');
    $this->view->enter_form = $form;
}
    /*  $okato = isset($this->params['okato'])?$this->params['okato']:'';
      $okved = isset($this->params['okved'])?$this->params['okved']:'';
      $what = isset($this->params['what'])?$this->params['what']:'';
      $where = isset($this->params['what'])?$this->params['what']:''; */
    
    $form = new AK_Form('searchForm', 'post', SITE_URL."/list/index/");
    $this->view->search_form = $form;

$this->view->Basket = new AK_Order_Basket;

if ($RequestUrl=='/')

{
 
    $left_banners = new AK_Banners_List();
    $left_banners = $left_banners->addWhere('A.isActive =?',1)->addWhere('A.position =?',0)->addWhere("(A.key = '' OR A.key = 'ALL')")->setOrder('A.priority DESC')->getList();

     foreach ($left_banners as $item)
        {  
            if ($item->isimage == 1)
                {   
                   $goal_banners_left[] = '<a href="'.SITE_URL.'/index/away/to/'.$item->image_href.'"><img src="'.IMG_URL2.'/'.$item->image_path.'" /></a>';
                   $item->count++;
                   $item->save();
                }
                 
            if ($item->isimage == 0)
                {
                  
                    $goal_banners_left[] = $item->code;
                    $item->count++;
                    $item->save();

                }

            if ($item->isimage == 2)
                {
                   $goal_banners_left[] = '<embed style="margin-bottom:10px" height="100" width="204" src="'.IMG_URL2.'/'.$item->image_path.'" quality="high"></embed>';
                   $item->count++;
                   $item->save();
                }
        }

    $left_down_banners = new AK_Banners_List();
    $left_down_banners = $left_down_banners->addWhere('A.isActive =?',1)->addWhere('A.position =?',2)->addWhere("(A.key = '' OR A.key = 'ALL')")->setOrder('A.priority DESC')->getList();

     foreach ($left_down_banners as $item)
        {
            if ($item->isimage == 1)
                {
                   $goal_banners_left_down[] = '<a class="banner" href="'.SITE_URL.'/index/away/to/'.$item->image_href.'"><img src="'.IMG_URL2.'/'.$item->image_path.'" /></a>';
                   $item->count++;
                   $item->save();
                }

            if ($item->isimage == 0)
                {
                    $goal_banners_left_down[] = $item->code;
                    $item->count++;
                    $item->save();

                }

            if ($item->isimage == 2)
                {
                   $goal_banners_left_down[] = '<embed style="margin-bottom:10px" height="100" width="204" src="'.IMG_URL2.'/'.$item->image_path.'" quality="high"></embed>';
                   $item->count++;
                   $item->save();
                }
        }


    $right_banners = new AK_Banners_List();
    $right_banners = $right_banners->addWhere('A.isActive =?',1)->addWhere('A.position =?',1)->addWhere("(A.key = '' OR A.key = 'ALL')")->setOrder('A.priority DESC')->getList();

     foreach ($right_banners as $item)
        {  
            if ($item->isimage == 1)
                {
                   $goal_banners_right[] = '<a href="'.SITE_URL.'/index/away/to/'.$item->image_href.'"><img src="'.IMG_URL2.'/'.$item->image_path.'" /></a>';
                   $item->count++;
                   $item->save();

                }

           if ($item->isimage == 0)
                {
                    $goal_banners_right[] = $item->code;
                    $item->count++;
                    $item->save();
                }

           if ($item->isimage == 2)
                {
                   $goal_banners_right[] = '<embed style="margin-bottom:10px" height="100" width="204" src="'.IMG_URL2.'/'.$item->image_path.'" quality="high"></embed>';
                   $item->count++;
                   $item->save();

                }

        }

     $right_down_banners = new AK_Banners_List();
     $right_down_banners = $right_down_banners->addWhere('A.isActive =?',1)->addWhere('A.position =?',3)->addWhere("(A.key = '' OR A.key = 'ALL')")->setOrder('A.priority DESC')->getList();
	$goal_banners_right_down = array();
     foreach ($right_down_banners as $item)
        {
            if ($item->isimage == 1)
                {
                   $goal_banners_right_down[] = '<a class="banner" href="'.SITE_URL.'/index/away/to/'.$item->image_href.'"><img src="'.IMG_URL2.'/'.$item->image_path.'" /></a>';
                   $item->count++;
                   $item->save();
                }

            if ($item->isimage == 0)
                {
                    $goal_banners_right_down[] = $item->code;
                    $item->count++;
                    $item->save();

                }

            if ($item->isimage == 2)
                {
                   $goal_banners_right_down[] = '<embed style="margin-bottom:10px" height="100" width="204" src="'.IMG_URL2.'/'.$item->image_path.'" quality="high"></embed>';
                   $item->count++;
                   $item->save();
                }
        }

}
else

{
    $left_banners = new AK_Banners_List();
    $left_banners = $left_banners->addWhere('A.isActive =?',1)->addWhere('A.position =?',0)->setOrder('A.priority DESC')->getList();
	$goal_banners_left = array();
    foreach ($left_banners as $item)
    if (strpos($RequestUrl,$item->key)!== false || $item->key=="ALL")
    {
        if ($item->isimage == 1)
                {
                   $goal_banners_left[] = '<a href="'.SITE_URL.'/index/away/to/'.$item->image_href.'"><img src="'.IMG_URL2.'/'.$item->image_path.'" /></a>';
                   $item->count++;
                   $item->save();
                }

            if ($item->isimage == 0)
                {

                    $goal_banners_left[] = $item->code;
                    $item->count++;
                    $item->save();

                }

            if ($item->isimage == 2)
                {
                   $goal_banners_left[] = '<embed style="margin-bottom:10px" height="100" width="204" src="'.IMG_URL2.'/'.$item->image_path.'" quality="high"></embed>';
                   $item->count++;
                   $item->save();
                }
    }

    $left_down_banners = new AK_Banners_List();
    $left_down_banners = $left_down_banners->addWhere('A.isActive =?',1)->addWhere('A.position =?',2)->setOrder('A.priority DESC')->getList();
	$goal_banners_left_down = array();
    foreach ($left_down_banners as $item)
    if (strpos($RequestUrl,$item->key)!== false || $item->key=="ALL")
    {
        if ($item->isimage == 1)
                {
                   $goal_banners_left_down[] = '<a class="banner" href="'.SITE_URL.'/index/away/to/'.$item->image_href.'"><img src="'.IMG_URL2.'/'.$item->image_path.'" /></a>';
                   $item->count++;
                   $item->save();
                }

            if ($item->isimage == 0)
                {
                    $goal_banners_left_down[] = $item->code;
                    $item->count++;
                    $item->save();

                }

            if ($item->isimage == 2)
                {
                   $goal_banners_left_down[] = '<embed style="margin-bottom:10px" height="100" width="204" src="'.IMG_URL2.'/'.$item->image_path.'" quality="high"></embed>';
                   $item->count++;
                   $item->save();
                }
    }


    $right_banners = new AK_Banners_List();
    $right_banners = $right_banners->addWhere('A.isActive =?',1)->addWhere('A.position =?',1)->setOrder('A.priority DESC')->getList();
	$goal_banners_right = array();
    foreach ($right_banners as $item)
	{
    if (!empty($item->key) && (strpos($RequestUrl,$item->key)!== false || $item->key=="ALL"))
    {
         if ($item->isimage == 1)
                {
                   $goal_banners_right[] = '<a href="'.SITE_URL.'/index/away/to/'.$item->image_href.'"><img src="'.IMG_URL2.'/'.$item->image_path.'" /></a>';
                   $item->count++;
                   $item->save();

                }

           if ($item->isimage == 0)
                {
                    $goal_banners_right[] = $item->code;
                    $item->count++;
                    $item->save();
                }

           if ($item->isimage == 2)
                {
                   $goal_banners_right[] = '<embed style="margin-bottom:10px" height="100" width="204" src="'.IMG_URL2.'/'.$item->image_path.'" quality="high"></embed>';
                   $item->count++;
                   $item->save();

                }
    }
    }
    
    $right_down_banners = new AK_Banners_List();
    $right_down_banners = $right_down_banners->addWhere('A.isActive =?',1)->addWhere('A.position =?',3)->setOrder('A.priority DESC')->getList();
	$goal_banners_right_down = array();
    foreach ($right_down_banners as $item)
    if (strpos($RequestUrl,$item->key)!== false || $item->key=="ALL")
    {
        if ($item->isimage == 1)
                {
                   $goal_banners_right_down[] = '<a class="banner" href="'.SITE_URL.'/index/away/to/'.$item->image_href.'"><img src="'.IMG_URL2.'/'.$item->image_path.'" /></a>';
                   $item->count++;
                   $item->save();
                }

            if ($item->isimage == 0)
                {
                    $goal_banners_right_down[] = $item->code;
                    $item->count++;
                    $item->save();

                }

            if ($item->isimage == 2)
                {
                   $goal_banners_right_down[] = '<embed style="margin-bottom:10px" height="100" width="204" src="'.IMG_URL2.'/'.$item->image_path.'" quality="high"></embed>';
                   $item->count++;
                   $item->save();
                }
    }


}
/*foreach($goal_banners_left as $item)
    echo $item;*/
$this->view->left_banners  = empty($goal_banners_left)?'':$goal_banners_left;
$this->view->right_banners = empty($goal_banners_right)?'':$goal_banners_right;
$this->view->left_down_banners = empty($goal_banners_left_down)?'':$goal_banners_left_down;
$this->view->right_down_banners = empty($goal_banners_right_down)?'':$goal_banners_right_down;
$this->view->sitemap = array ("А" , "Б" , "В" , "Г" , "Д" , "Е" , "Ё" , "Ж" , "З" , "И" , "К" , "Л" , "М" , "Н" , "О" , "П" , "Р" , "С" , "Т" , "У" , "Ф" , "Х" , "Ц" , "Ч" , "Ш" , "Щ" , "Э" , "Ю" , "Я" );

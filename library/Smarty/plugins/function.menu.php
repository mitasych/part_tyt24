<?php
// name, delimiter
function smarty_function_menu($params, &$smarty) {

    $_content = '';
   
    if (empty($params['name'])) return $_content;

    $_item = new AK_Menu_Item;
    if ($params['name']!='sub_top_menu')
    $_item->loadByField('alias', $params['name']);
    else
    $_item->loadByField('alias', 'top_menu');
    
    $_links = new AK_Menu_Link_List;
    $_links = $_links->addWhere('A.is_active = 1')->addWhere('A.menu_id = ?', $_item->getId())->setOrder('A.queue ASC')->getList();

	foreach($_links as $key => $link_item){
        $arViewPages = $link_item->getArViewPages();
        if (!empty($arViewPages) && !empty($params['alias'])) {
           	foreach($arViewPages as $block => $blockPage){
           		foreach ($blockPage as $page){
           			if ($block == 'view') {
		           		if (substr($page, -1) == '*') {
		           			$newPage=substr($page, 0, -1);
		           			if (!preg_match('|^'.$newPage.'|', $params['alias'])) {
		           				unset($_links[$key]);
		           			}
		           		}
		           		elseif ($page != $params['alias']) {
		           			unset($_links[$key]);
		           		}
           			}
           			elseif ($block == 'not_view') {
		           		if (substr($page, -1) == '*') {
		           			$newPage=substr($page, 0, -1);
		           			if (preg_match('|^'.$newPage.'|', $params['alias'])) {
		           				unset($_links[$key]);
		           			}
		           		}
		           		elseif ($page == $params['alias']) {
		           			unset($_links[$key]);
		           		}
           			}
           		}
           	}
        }
    }
    
    switch ($params['name']) {
        case 'note_head':
            
        
            
            $_sublinks = new AK_Menu_Sublink_List;
            $_sublinks = $_sublinks->addWhere('A.link_id = ?',$_SESSION['mySELECTED_MENU_ID'])->addWhere('A.note = 1')->setOrder('A.queue ASC')->getList();
           
            if(count($_sublinks)==0)
            {
            $_sublinks = new AK_Menu_Sublink_List;
            $_sublinks = $_sublinks->addWhere('A.note = 1')->setOrder('A.queue ASC')->setCurrentPage(1)->setListSize(5)->getList();
            
            }
            foreach ($_sublinks as $_key => &$_link) {
                $_content.='<li><a href="'.$_link->getLink().'">'.str_replace(' ',' ',$_link->getTitle()).'&nbsp;</a></li>';
            }
            $_content.='<li><a id="cab" href="#">Личный кабинет</a></li>';
            
            break;
        case 'title_head':
              $_variables = new AK_System_Variables();
              if($_SESSION['mySELECTED_MENU_ID']>0)
              {
                  
                  $_menu = new AK_Menu_Link_Item;
                  $_menu->loadByField('id', $_SESSION['mySELECTED_MENU_ID']);
                  $string = $_menu->getBrif();
                  if ($string=='') return $_variables->get('header');//'Желтые страницы России, СНГ и Европы. Предприятия и организации: Базы данных предприятий, товары и услуги, адреса и номера телефонов. Телефонный справочник.';
                      else
                  return $string ;
              }
                
            
              else
                  return $_variables->get('header');//'Желтые страницы России, СНГ и Европы. Предприятия и организации: Базы данных предприятий, товары и услуги, адреса и номера телефонов. Телефонный справочник.';
            break;


        case 'top_menu':
               $_cntr=0;
               if ($params['alias']=='/') {};
            foreach ($_links as $_key => &$_link) {
                $_cntr++;
                $_content.='<li';
                if ( count($_links) == $_cntr ) {
                    $_content.=' class="last"';
                }
                if ( $_cntr == 1 ) {
                    $_content.=' class="first"';
                }
                else
                    $_content.=' class="op"';
                if ($_link->getId()==$_SESSION['mySELECTED_MENU_ID']) $_content.=' id="active" ';
               
                $_content.='><a href="'.$_link->getLink().'">'.$_link->getTitle().'</a></li>';

                if (!empty($params['delimiter']) && isset($_links[$_key+1]) )
                    $_content.=$params['delimiter'];
                    }
            break;

            case 'sub_top_menu':
                $_cntr=0;
                $_content.='<ul id=submenu>';
                foreach ($_links as $_key => &$_link) {
                    $_cntr++;
                    $_content.='<li';
                    $_sublinks = new AK_Menu_Sublink_List;
				$_sublinks = $_sublinks->addWhere('A.link_id = ?', $_link->getId())->addWhere('A.note = 0')->setOrder('A.queue ASC')->getList();                 
                    if (!empty($_sublinks)) {

                    $_content.='<ul id="ul'.$_link->getId().'" class="submenu"">';// style="display:none;">';
                    foreach ($_sublinks as $_subkey => &$_sublink) {
                        $_addclass = '';
                        $_addclassli = '';
                        if ($_sublink->getIsRed()) {
                            $_addclass=' red';
                            $_addclassli=' class="red"';
                        }
                        //if ($_sublink->getParentLink()->getIsRed()) {
                        //    $_addclassli=' class="red"';
                        //}

                        $_content.='<li'.$_addclassli.'><a id="als'.$_sublink->getId().'" class="subm'.$_addclass.'" href="'.$_sublink->getLink().'">'.str_replace(' ',' ',$_sublink->getTitle()).'&nbsp;</a></li>';

                    }
                    $_content.='</ul></li>';
                }}
                $_content.='</ul>';
                break;

        case 'bottom_menu':
            $_cntr=0;
            foreach ($_links as $_key => &$_link) {
                $_cntr++;
                $_content.='<li';
                if ( count($_links) == $_cntr ) {
                    $_content.=' class="abox_last"';
                }
                $_content.='><a href="'.$_link->getLink().'">'.$_link->getTitle().'</a></li>';

                if (!empty($params['delimiter']) && isset($_links[$_key+1]) ) $_content.=$params['delimiter'];
            }
            break;

        case 'main_menu':

  if (!empty($params['external'])) {

$_sublinks = new AK_Menu_Sublink_List;
$_sublinks = $_sublinks->addWhere('A.is_show = ?', 1)->setOrder('A.position ASC')->getList();

$_links = new AK_Menu_Link_List;
$_links = $_links->addWhere('A.is_show = ?', 1)->setOrder('A.position ASC')->getList();


$alllinks = array();
foreach($_sublinks as $v) {
    $alllinks[] = $v;
}
foreach($_links as $v) {
    $alllinks[] = $v;
}


function cmp($a, $b) {
    if ($a->position == $b->position) {
        return 0;
    }
    return ($a->position < $b->position) ? -1 : 1;
}

usort($alllinks, "cmp");

                $_content.='<ul id="jsddm">';

                $_cntr=0;
                foreach ($alllinks as $_key => &$_link) {
                    //$_sublinks = new AK_Menu_Sublink_List;
                    //$_sublinks = $_sublinks->addWhere('A.link_id = ?', $_link->getId())->setOrder('A.queue ASC')->getList();

                    $_cntr++;


                        $_content.='<li><a target="_parent"';



                    if ($_link->getLink()) {
                        $_content.=' href="'.$_link->getLink();
                    }
                    else {
                        $_content.=' href="javascript:void(0);';
                    }

                    $_content.='" >'.$_link->getTitle().'</a>';

//                    if (!empty($_sublinks)) {
//                        $_content.='<ul>';
//                        foreach ($_sublinks as $_subkey => &$_sublink) {
//                            $_content.='<li><a target="_parent" href="'.$_sublink->getLink().'">'.str_replace(' ',' ',$_sublink->getTitle()).'&nbsp;</a></li>';
//
//                        }
//                        $_content.='</ul>';
//                    }

                    $_content.='</li>';


                }

                $_content.='</ul>';


            }

            else {

            $_content.='<div class="menu"><ul id="nav">';

            $_cntr=0;
            
            
            
            foreach ($_links as $_key => &$_link) {
            	
                $_sublinks = new AK_Menu_Sublink_List;
                $_sublinks = $_sublinks->addWhere('A.link_id = ?', $_link->getId())->setOrder('A.queue ASC')->getList();

                $_cntr++;

                if (false && $_link->getIsRed()) {// || ($_SERVER['REQUEST_URI'] == '/' && mb_strpos($_link->getTitle(), 'ВЭД', null, 'UTF-8'))) {
                    $_content.='<li class="red"><a';
                } else {
                    $_content.='<li><a';
                }
                
                
                if (!empty($_sublinks)) {
                    $_content.=' class="no_sub aul"';
                } else {
                    $_content.=' class="aul"';
                }
                
                if ( count($_links) == $_cntr ) {
                    $_content.=' style="height:22px;';
                    if (!($_link->getLink())) {
                        $_content.=' cursor:default;';
                    }
                    $_content.='"';
                } else {

                    if (!($_link->getLink())) {
                        $_content.=' style="cursor:default;"';
                    }
                }

                $_linkid = 'al'.$_link->getId();

                if ($_link->getLink()) {
                    $_content.=' href="'.$_link->getLink();
                } else {
                    $_content.=' href="javascript:void(0);';
                }

                $_content.='" id="'.$_linkid.'">'.$_link->getTitle().'</a>';

                if (!empty($_sublinks)) {
                    $_content.='<ul id="ul'.$_link->getId().'" class="submenu"">';// style="display:none;">';
                    foreach ($_sublinks as $_subkey => &$_sublink) {
                        $_addclass = '';
                        $_addclassli = '';
                        if ($_sublink->getIsRed()) {
                            $_addclass=' red';
                            $_addclassli=' class="red"';
                        }
                        //if ($_sublink->getParentLink()->getIsRed()) {
                        //    $_addclassli=' class="red"';
                        //}

                        $_content.='<li'.$_addclassli.'><a id="als'.$_sublink->getId().'" class="subm'.$_addclass.'" href="'.$_sublink->getLink().'">'.str_replace(' ',' ',$_sublink->getTitle()).'&nbsp;</a></li>';

                    }
                    $_content.='</ul>';
                }

                $_content.='</li>';//<img class="r_arrow" src="/images/right_arrow.gif" alt="" title="" />';


            }

            $_content.='</ul></div>';
            }
            break;

    }

    return $_content;
}
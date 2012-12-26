<?php
// name, delimiter
function smarty_function_breadcrumb($params, &$smarty) {
    
    $_SESSION['SELECTED_MENU_ID'] = 0;
    $_SESSION['SELECTED_SUBMENU_ID'] = 0;

    $_content = '';

    if (empty($params['controller'])) return $_content;
    if (empty($params['alias'])) return $_content;


    $_item = new AK_Menu_Sublink_Item;
    $_item->pkColName = 'link';
    $_item->loadByPk('/'.$params['controller'].'/'.$params['alias'].'/');

    if (!$_item->getId()) {
        $_item = new AK_Menu_Sublink_Item;
        $_item->pkColName = 'link';
        $_item->loadByPk('/'.$params['controller'].'/'.$params['alias']);
    }

    if (!$_item->getId()) {
        $_item = new AK_Menu_Link_Item;
        $_item->pkColName = 'link';
        $_item->loadByPk('/'.$params['controller'].'/'.$params['alias'].'/');
    }

    if (!$_item->getId()) {
        $_item = new AK_Menu_Link_Item;
        $_item->pkColName = 'link';
        $_item->loadByPk('/'.$params['controller'].'/'.$params['alias']);
    }

    if (!$_item->getId()) {
        if ($params['controller'] == 'articles') {
            $currentInfo = new AK_Article_Item();
            $currentInfo->loadByRewriteName($params['alias']);
            if ($currentInfo->getId()) {
                $_content.='<div class="breadcrumb"><a href="'.SITE_URL.'">Главная</a>';
                $_content.='<span>'.$currentInfo->getTitle().'</span>';
                $_content.='</div>';
            }
        }

        if ($params['controller'] == 'news') {
            $currentInfo = new AK_News_Item();
            $currentInfo->loadByRewriteName($params['alias']);
            if ($currentInfo->getId()) {
                $_content.='<div class="breadcrumb"><a href="'.SITE_URL.'">Главная</a>';
                $_content.='<span>'.$currentInfo->getTitle().'</span>';
                $_content.='</div>';
            } elseif (!empty($params['title']) || !empty($params['altTitle'])){
                 $_content.='<div class="breadcrumb"><a href="'.SITE_URL.'">Главная</a>';
                $_content.='<span>'.(empty($params['title'])?$params['altTitle']:$params['title']).'</span>';
                $_content.='</div>';
            }
        }

        if ($params['controller'] == 'info' && (!empty($params['title']) || !empty($params['altTitle']) )) {
            $_content.='<div class="breadcrumb"><a href="'.SITE_URL.'">Главная</a>';
            $_content.='<span>'.(empty($params['title'])?$params['altTitle']:$params['title']).'</span>';
            $_content.='</div>';
        }

        
    } else {
        $_content.='<div class="breadcrumb"><a href="'.SITE_URL.'">Главная</a>';

        if ($_item instanceof AK_Menu_Sublink_Item) {
            $_SESSION['SELECTED_SUBMENU_ID'] = $_item->getId();
            $_SESSION['SELECTED_MENU_ID'] = $_item->getParentLink()->getId();

            if ($_item->getParentLink()->getLink()) {
                $_content.='<a href="'.$_item->getParentLink()->getLink().'">'.$_item->getParentLink()->getTitle().'</a>';
                $_content.='<span>'.$_item->getTitle().'</span>';
            } else {
                $_content.='<span>'.$_item->getParentLink()->getTitle().': ';
                $_content.=$_item->getTitle().'</span>';
            }

        } else {
            $_SESSION['SELECTED_MENU_ID'] = $_item->getId();
            $_content.='<span>'.$_item->getTitle().'</span>';
        }
        
        $_content.='</div>';
    }

    return $_content;
}
<?php
// name, delimiter
function smarty_function_menuselect($params, &$smarty) {

    $_content = '';
    
    if (!empty($_SESSION['SELECTED_MENU_ID'])) {
        $_content.= '<script type="text/javascript">
            $(function () {
                $("#ul'.$_SESSION['SELECTED_MENU_ID'].'").css({"display": "block"});
             });
       </script>';
    }
    if (!empty($_SESSION['SELECTED_SUBMENU_ID'])) {
        $it = new AK_Menu_Sublink_Item($_SESSION['SELECTED_SUBMENU_ID']);
        $color = $it->getIsRed()?"#FE0000":"#0153A9";
        $_content.= '<script type="text/javascript">
            $(function () {
                $("#als'.$_SESSION['SELECTED_SUBMENU_ID'].'").css({"color": "'.$color.'"});
             });
       </script>';
    }

    $_content.= '<script type="text/javascript">
            $(".aul").click(function(){$(this).next("ul.submenu").toggle();})
       </script>';

    
    $_SESSION['SELECTED_MENU_ID'] = 0;
    $_SESSION['SELECTED_SUBMENU_ID'] = 0;
    return $_content;
}
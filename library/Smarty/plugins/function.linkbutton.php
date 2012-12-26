<?
    function smarty_function_linkbutton($params, &$smarty)
    {
        $params['name']     = ( !isset($params['name']) ) ? "ButtonLink" : $params['name'];
        $params['link']     = ( !isset($params['link']) ) ? "#" : $params['link'];
        $params['color']    = ( !isset($params['color'] ) ) ? 'orange' : $params['color'];
        $params['color']    = ( !in_array($params['color'], array('gray', 'green', 'orange', 'red')) ) ? 'orange' : $params['color'];
        $params['onclick']    = ( !isset($params['onclick'] ) ) ? null : $params['onclick'];

        $smarty->assign($params);
        $_content = $smarty->fetch("_design/buttons/link_button.tpl");
        return $_content;
    }
?>
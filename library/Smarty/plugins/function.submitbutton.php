<?php
    function smarty_function_submitbutton($params, &$smarty)
    {
        $params['name']     = ( !isset($params['name']) ) ? "ButtonSubmit" : $params['name'];
        $params['value']    = ( !isset($params['value']) ) ? null : $params['value'];
        $params['color']    = ( !isset($params['color'] ) ) ? 'orange' : $params['color'];
        $params['color']    = ( !in_array($params['color'], array('gray', 'green', 'orange', 'red')) ) ? 'orange' : $params['color'];

        $smarty->assign($params);
        $_content = $smarty->fetch("_design/buttons/submit_button.tpl");
        return $_content;
    }
?>
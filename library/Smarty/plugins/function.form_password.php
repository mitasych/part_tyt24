<?php

/**
 * Smarty form function for element <input type=text>
 *
 * @param array $params
 * @param object $smarty
 * @return string
 * @author Ivan Meleshko
 * @author Dmitry Kostikov
 */
function smarty_function_form_password($params, &$smarty)
{
    // form object verify
    if (!isset($smarty->_tpl_vars['wf_form_object'])) return 'Form object not found.';
    $form = $smarty->_tpl_vars['wf_form_object'];

    // element name verify
    if (!isset($params['name'])) return 'Name for field not found.';

    // element default value
    if (isset($form->_defaults[$params['name']]))
        $params['value'] = $form->_defaults[$params['name']];
        
    $content = '<input type="password"';
    foreach ($params as $k => &$v) $content .= ' '.$k.'="'.$v.'"';
    $content .= ' />';
    
    return $content;
}

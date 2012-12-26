<?php

/**
 * Smarty form function for element <input type=radio>
 *
 * @param array $params
 * @param object $smarty
 * @return string
 * @author Ivan Meleshko
 * @author Dmitry Kostikov
 */
function smarty_function_form_radio($params, &$smarty)
{
    // form object verify
    if (!isset($smarty->_tpl_vars['wf_form_object'])) return 'Form object not found.';
    $form = $smarty->_tpl_vars['wf_form_object'];

    // element name verify
    if (!isset($params['name'])) return 'Name for field not found.';

    // element business logic default value
    $value = (isset($form->_defaults[$params['name']])) ? $form->_defaults[$params['name']] : null;
    
    $content = '<input type=radio';
    foreach ($params as $k => &$v)
        if ('checked' == $k)
            $checked = $v;
        else
            $content .= ' '.$k.'="'.$v.'"';
    if ($value) {
        if ($params['value'] == $value) $content .=  ' checked';
    } else {
        if ($params['value'] == $checked) $content .=  ' checked';
    }
    $content .= '>';
    
    return $content;
}
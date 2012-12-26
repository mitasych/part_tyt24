<?php

/**
 * Smarty form function for element <input type=button>
 *
 * @param array $params
 * @param object $smarty
 * @return string
 * @author Ivan Meleshko
 * @author Dmitry Kostikov
 */
function smarty_function_form_button($params, &$smarty)
{
    // form object verify
    if (!isset($smarty->_tpl_vars['wf_form_object'])) return 'Form object not found.';
    $form = $smarty->_tpl_vars['wf_form_object'];

    // element default value
    if (isset($form->_defaults[$params['name']]))
        $params['value'] = $form->_defaults[$params['name']];
        
    $content = '<input type=button';
    foreach ($params as $k => &$v) $content .= ' '.$k.'="'.$v.'"';
    $content .= '>';
    
    return $content;
}
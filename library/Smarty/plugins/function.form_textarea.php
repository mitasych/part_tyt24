<?php

/**
 * Smarty form function for element <textarea></textarea>
 *
 * @param array $params
 * @param object $smarty
 * @return string
 * @author Ivan Meleshko
 * @author Dmitry Kostikov
 */
function smarty_function_form_textarea($params, &$smarty)
{
    // form object verify
    if (!isset($smarty->_tpl_vars['wf_form_object'])) return 'Form object not found.';
    $form = $smarty->_tpl_vars['wf_form_object'];
    
    // element name verify
    if (!isset($params['name'])) return 'Name for field not found.';
    
    // element default value
    
    //$value = isset($form->_defaults[$params['name']]) ? htmlspecialchars($form->_defaults[$params['name']]) : '';
    //$value = isset($params['value']) ? $params['value'] : $value;

    $value = isset($form->_defaults[$params['name']]) ? htmlspecialchars($form->_defaults[$params['name']]) : '';
    $value = (isset($params['value']) && !isset($form->_defaults[$params['name']]))  ? $params['value'] : $value;
    
    $content = '<textarea';
    foreach ($params as $k => &$v) if ('value' != $k) $content .= ' '.$k.'="'.$v.'"';
    $content .= '>'.$value.'</textarea>';
    
    return $content;
}

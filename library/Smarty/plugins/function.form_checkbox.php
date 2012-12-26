<?php

/**
 * Smarty form function for element <input type=checkbox>
 *
 * @param array $params
 * @param object $smarty
 * @return string
 * @author Ivan Meleshko
 * @author Dmitry Kostikov
 */
function smarty_function_form_checkbox($params, &$smarty)
{
    $checked = null;
    // form object verify
    if (!isset($smarty->_tpl_vars['wf_form_object'])) return 'Form object not found.';
    $form = $smarty->_tpl_vars['wf_form_object'];

    // element name verify
    if (!isset($params['name'])) return 'Name for field not found.';

    // element business logic default value
    //$value = (isset($form->_defaults[$params['name']])) ? $form->_defaults[$params['name']] : null;
    $_default = (isset($form->_defaults[$params['name']])) ? (empty($form->_defaults[$params['name']])?0:1) : null;

    $content = '<input type=checkbox';
    foreach ($params as $k => &$v)
        if ('checked' == $k)
            $checked = $v;
        else
            $content .= ' '.$k.'="'.$v.'"';
    
    if (isset($_default)){
        if (!empty($_default)) $content .=  ' checked="checked"';
    }
    else{
        if (!empty($checked)) $content .=  ' checked="checked"';
    }
    
    //if (!empty($value)) {
    //    $content .=  ' checked="checked"';
    //} else {
    //    if (!empty($checked)) $content .=  ' checked="checked"';
   // }

    $content .= ' />';
    
    return $content;
}

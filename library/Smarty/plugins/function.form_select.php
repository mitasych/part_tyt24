<?php

/**
 * Smarty form function for element <input type=text>
 *
 * @package Smarty
 * @param array $params
 * @param object $smarty
 * @return string
 * @author Ivan Meleshko
 * @author Dmitry Kostikov
 * 
 * @todo multiple selected feature
 */
function smarty_function_form_select($params, &$smarty)
{
    // form object verify
    if (!isset($smarty->_tpl_vars['wf_form_object'])) return 'Form object not found.';
    $form = $smarty->_tpl_vars['wf_form_object'];

    // element name verify
    if (!isset($params['name'])) return 'Name for field not found.';

    // element default value
    $selected = null;
    if (isset($form->_defaults[$params['name']])) $selected = $form->_defaults[$params['name']];
    elseif (isset($params['selected'])) $selected = $params['selected'];
    //if (isset($params['defaults'])) $selected = $params['defaults'];
    
    $content = '<select';
    
    foreach($params as $k => &$v)
        if ('options' != $k) $content .= ' '.$k.'="'.$v.'"';
    $content .= '>';
    if(isset($params['zero'])) $content .= '<option value="0">Не указывает на левое меню</option>';
    if (isset($form->_options[$params['name']])) {
        foreach($form->_options[$params['name']] as $k => $v){
            $content .= '<option value="'.$k.'"';
            if (is_array($selected)){
                $sel = false;
                foreach ($selected as $s) if ($s == $k) $sel = true;
                if ($sel) $content .= ' selected="selected"';
            } else {
                if ($selected == $k) $content .= ' selected="selected"';
            }
            $content .= '>'.$v.'</option>';
        }
    }

    if (isset($params['options']) && is_array($params['options'])) {
        $options = $params['options'];
        foreach($options as $k => $v){
            $content .= '<option value="'.$k.'"';
            if (is_array($selected)){
                $sel = false;
                foreach ($selected as $s) if ($s == $k) $sel = true;
                if ($sel) $content .= ' selected="selected"';
            } else {
                if ($selected == $k) $content .= ' selected="selected"';
            }
            $content .= '>'.$v.'</option>';
        }
    }
    
    $content .= '</select>';

    return $content;
}

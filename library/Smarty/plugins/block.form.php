<?php

/**
 * Smarty form block
 *
 * @param array $params
 * @param string $content
 * @param object $smarty
 * @return string
 * @author Ivan Meleshko
 */
function smarty_block_form($params, $content, &$smarty)
{
    if (!isset($params['from'])) return 'Form not set.';
    $form_object = $params['from'];
    if ( $content !== null )
    {
        unset($params['from']);
        $fields = '';
        foreach ($params as $k => &$v)
            $fields .= ' '.$k.'="'.$v.'"';
        $data = '<form name="'.$form_object->name.'" method="'.$form_object->method.'" action="'.$form_object->action.'"'.$fields.'>';
        $data .= '<input type="hidden" name="_wf__'.$form_object->name.'" value="1" />';
        return $data.$content.'</form>';
    } else {
        $smarty->assign("wf_form_object", $form_object);
    }
}


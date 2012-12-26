<?php

/**
 * Smarty form function
 * @param array $params
 * @param object $smarty
 * @return string
 * @author Artem Sukharev
 */
function smarty_function_form_errors_summary($params, &$smarty)
{
    if (!isset($smarty->_tpl_vars['wf_form_object'])) return 'Form object not found.';
    $form_object = $smarty->_tpl_vars['wf_form_object'];

    $scripts = array();
    $output_errors = array();
    if ( sizeof($form_object->getrules()) != 0 ) {
        foreach ( $form_object->getrules() as $_field => $_rules ) {
            if ( sizeof($_rules) != 0 ) {
                foreach ( $_rules as $_rule ) {
                    if ( $_rule['error'] ) {
                        $output_errors[] = $_rule['message'];
                    }
                }
            }
        }
    }

    $_content = '';
    if ( sizeof($output_errors) != 0 ) {
        $smarty->assign('errors', $output_errors);
        $_content = $smarty->fetch("_design/form/form_errors_summary.tpl");
    }

    return $_content;
}
<?php
/**
 * MosQUITo 17.09.2006
 * 
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

function smarty_modifier_endate($value)
{	
    $monthes = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October","November", "December");
    $d = getdate($value);
    return $d["mday"] . " " . $monthes[$d["mon"] - 1] . " " . $d["year"]; 
}
?>
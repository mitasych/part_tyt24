<?php
/**
 * MosQUITo 17.09.2006
 * 
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

function smarty_modifier_rudate($value)
{	
    $monthes = array("января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря");
    $d = getdate($value);
    return $d["mday"] . " " . $monthes[$d["mon"] - 1] . " " . $d["year"] . " г.";
}
?>
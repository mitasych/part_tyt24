<?php

//Проверяет наличие приставки http (https) и в случае отсутствия добавляет их. 

function smarty_modifier_site($string)
{
    if (!preg_match('/^(http(s?)\:\/\/){1}(.*)$/', $string) )
    {
        $string = 'http://'.$string ;
    }
    return $string;
}

?>

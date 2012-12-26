<?php

function smarty_modifier_numberformat($val)
{
    return number_format((int) $val, 0, ',', ' ');
}

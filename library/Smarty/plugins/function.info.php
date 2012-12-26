<?php
function smarty_function_info($params, &$smarty)
{
    if (empty($params['name'])) return '';

    $currentInfo = new AK_Article_Item();
    
    $currentInfo->loadByRewriteName($params['name']);
    
    if ($currentInfo->getIsActive() &&  !$currentInfo->getCategory()->getIsFree() )
    {
        if (!empty($params['what']) && $params['what']=='title') {
            return $currentInfo->getTitle();
        }
        return $currentInfo->getContent();
    }
    else
    {
        return '';
    }

}
?>

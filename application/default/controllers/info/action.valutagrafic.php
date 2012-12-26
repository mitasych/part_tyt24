<?php
$currentInfo = new AK_Article_Item();
$currentInfo->loadByRewriteName('valutagrafic');
$this->view->currentInfo = $currentInfo;

if ($currentInfo->getMetaTitle()) {
    $this->view->TITLE = $currentInfo->getMetaTitle();
} elseif ($currentInfo->getTitle()) $this->view->TITLE = $currentInfo->getTitle();
if ($currentInfo->getMetaKeywords()) {
    $this->view->KEYWORDS = $currentInfo->getMetaKeywords();
}
if ($currentInfo->getMetaDescription()) {
    $this->view->DESCRIPTION = $currentInfo->getMetaDescription();
}
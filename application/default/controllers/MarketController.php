<?php

 
class MarketController extends AK_Controller_Action {

    public function indexAction()
    {
        $this->view->categoryList = Tyt24_Models_MarketCategory::getMarketCategories();
        $this->view->regions = Tyt24_Models_Regions::getRegions();
    }
}

?>
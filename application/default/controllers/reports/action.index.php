<?php 

// $_links = new AK_Menu_Link_List;
// $_links = $_links->addWhere('A.is_show = ?', 1)->setOrder('A.position ASC')->getList();

$orders = new AK_Order_Report_List;
$orders->addWhere('A.main_page = 1');
$orders->setOrder('A.order');
$orders = $orders->getList(1);

$ordersNew = array();

foreach($orders as $key => $order){
	$sublinkEtity = new AK_Menu_Sublink_Item;
	$sublink = $sublinkEtity->getLinkByUrl($order->url);
	$order->menuLinkId = $sublink['link_id'];
	if ($order->menuLinkId) {
		$ordersNew[$order->menuLinkId]['orders'][] = $order;
		if (empty($ordersNew[$order->menuLinkId]['image'])) {
			$ordersNew[$order->menuLinkId]['image'] = $sublink['TL_image'];
		}
		if (empty($ordersNew[$order->menuLinkId]['title'])) {
			$ordersNew[$order->menuLinkId]['title'] = $sublink['TL_title'];
		}
		if (empty($ordersNew[$order->menuLinkId]['link'])) {
			$ordersNew[$order->menuLinkId]['link'] = $sublink['TL_link'];
		}
	}
}
// echo '<b>'.__FILE__.' -- '.__LINE__.'</b><pre>'; var_dump($ordersNew); echo'</pre>';die;
// $this->view->orders = $orders;
$this->view->orders = $ordersNew;

$_sys_variables = new AK_System_Variables();
$this->view->ofreports = $_sys_variables->get('official_reports');

// $this->view->alllinks = $_links;

$currentInfo = new AK_Article_Item();
$currentInfo->loadByRewriteName('profile');
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

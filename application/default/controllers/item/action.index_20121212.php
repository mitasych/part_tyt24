<?php
function delete_zero ($string)
{
    while($string[strlen($string)-1]=='0')
    {

        $string = substr($string, 0, -1);

    }
   return $string;
}

$id = isset($this->params['id'])?$this->params['id']:'';
// * если не нашли компанию возвращаем на list
$company = new AK_company_Item($id);
if($company->getId()=='')  $this->_redirect("/list/index/");
$this->view->TITLE = $company->getSingle_name();
$this->view->item = $company;
$this->view->id = $id;
$zerolevel_name = new AK_okved_Menu($company->getZerolevel_id());
$bradcrumb[] = array ("id" => $company->getZerolevel_id(), "name" => $zerolevel_name->getName()." >");
$firstlevel_name = new AK_okved_Menu($company->getFirstlevel_id());
$bradcrumb[] = array ("id" => $company->getFirstlevel_id(), "name" => $firstlevel_name->getName()." >");
$secondlevel_name = new AK_okved_Menu($company->getSecondlevel_id());
//$bradcrumb[] = array ("id" => $company->getSecondlevel_id(), "name" => $secondlevel_name->getName());
$this->view->menu = $bradcrumb;
$this->view->second = array("name" => $secondlevel_name->getName(), "id" => $secondlevel_name->getId()) ;


$okato = new AK_okato_List();

$okato_without_zero = delete_zero($company->getOkato());
$okato = $okato->addWhere('A.code LIKE ?',$okato_without_zero.'')->setListSize(1)->setCurrentPage(1)->getList();
if (count($okato)==0) {$okato = new AK_okato_List();$okato = $okato->addWhere('A.id = ?',12624)->setListSize(1)->setCurrentPage(1)->getList(); }

$parent_okato = new AK_okato_Item($okato[0]->getParent_id());
$bradcrumb_okato[] = array ("id" => $okato[0]->getId(), "name" => $okato[0]->getName());

$count=false;
while ($count!=true) // ищем субьект Фед. Округа
{
$subject_okato = new AK_okato_Item($parent_okato->getParent_id());

 if ($subject_okato->getCode()==null)
     $count=true;
 else 
     {
     $parent_okato = $subject_okato;
     //echo "<hr>".$parent_okato->getName();
     if (strpos($parent_okato->getName(),'/')==false) 
         $bradcrumb_okato[] = array ("id" => $parent_okato->getId(), "name" => $parent_okato->getShortName()." >", "title" => $parent_okato->getName());

     
     }
}
$this->view->menu_okato = $bradcrumb_okato;




$reports = new AK_Order_Report_List();
$reports->addWhere('A.active_company = 1');
$reports = $reports->getList(1);

$this->view->reports = $reports;

$pricesOutput = array();
$zakItems=array();
$this->view->select_co = 1;
foreach ($reports as $key=>$value) {
	if(!empty($this->params['id']) && $this->params['id'] == $value->id)
	$this->view->select_co = $value->country;
		
	$zakItems[$value->id] = $value->title_order;
    $pricesOutput[$value->id] = $value->getPricesOutputSimple();
}
$this->view->pricesOutput = $pricesOutput;
/*
$zakItems =  AK_Order_ZakazTypes::getPriceListCC();
$this->view->zakItems = $zakItems;
$pricesOutput = array();
foreach ($zakItems as $key=>$value) {
    $_price = new AK_Order_Prices($key);
    $pricesOutput[$key] = $_price->getPricesOutput();
}
$this->view->pricesOutput = $pricesOutput;*/


<?php

//header('Content-Type:  application/json; charset=utf-8');
        $db = Zend_Registry::get('DB');
        $select = $db->select();
        $select->from('okved_level as o',new Zend_Db_Expr('o.id as rub_id, o.name as rub_name, o.parent_id as rub_parent'));
        $select->join('link_okved as l','o.id = l.id_level',new Zend_Db_Expr('l.id_level as level, l.id_okved as link_id'));
        $select->join('class_company5_2 as c','l.id_okved = c.okved_id',new Zend_Db_Expr('c.okved_id as okid'));

       /* if(empty($okved)) {
            $select->where('parent_id IS NULL');
        }
        else {
            $select->where('parent_id = ?', $okved);
        }
        $data = $select->query()->fetchAll();*/


    $response->page       = 1;
    $response->total       = 3;
    $response->records   = 3;

    $rubric_mask = array_filter(explode('-',$_GET['rubric_mask']));
    $okved_mask = array_filter(explode('-', $_GET['okved_mask']));
    $sub_okved_mask = array_filter(explode('-',$_GET['sub_okved_mask']));

    if (!empty($rubric_mask) or !empty($okved_mask) or !empty($sub_okved_mask)) {   
    


    if (!empty($rubric_mask)) {
        $select->where("o.id IN (?)", $rubric_mask);
     }
    
    if (!empty($okved_mask)) {
        $select->orWhere("o.id IN (?)", $okved_mask);
    }

    if (!empty($sub_okved_mask)) {
        $select->orWhere("o.id IN (?)", $sub_okved_mask);
     }

    // if (!empty($_GET['region_mask'])){


     //}

    $i=0;
    print_r(count($select->query()->fetchAll()));
    //print_r($_GET);
    //print_r($rubric_mask);
   /* foreach ($select->query()->fetchAll() as $rezult) {

 
    $response->rows[$i]['id'] = $i;
    $response->rows[$i]['cell'] = array($rezult['rub_name'],'100','100');
    $i++;
    }*/




    echo Zend_Json::encode($response); 
    exit;
}
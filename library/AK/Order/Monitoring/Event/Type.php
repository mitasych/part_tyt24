<?php

class AK_Order_Monitoring_Event_Type extends AK_Data_EntityOrder {

    public $id;
    public $order;
    public $title;
    public $description;

    public function getColor() {
        if (!function_exists('tc')) {
            function tc($d) {

                $c = $d;
                return zc($c, 0);//, zc($c, 1), zc($c, 2), zc($c, 3)];
            }
            function zc($c, $i) {
                $d = "666666888888aaaaaabbbbbbdddddda32929cc3333d96666e69999f0c2c2b1365fdd4477e67399eea2bbf5c7d67a367a994499b373b3cca2cce1c7e15229a36633cc8c66d9b399e6d1c2f029527a336699668cb399b3ccc2d1e12952a33366cc668cd999b3e6c2d1f01b887a22aa9959bfb391d5ccbde6e128754e32926265ad8999c9b1c2dfd00d78131096184cb05288cb8cb8e0ba52880066aa008cbf40b3d580d1e6b388880eaaaa11bfbf4dd5d588e6e6b8ab8b00d6ae00e0c240ebd780f3e7b3be6d00ee8800f2a640f7c480fadcb3b1440edd5511e6804deeaa88f5ccb8865a5aa87070be9494d4b8b8e5d4d47057708c6d8ca992a9c6b6c6ddd3dd4e5d6c6274878997a5b1bac3d0d6db5a69867083a894a2beb8c1d4d4dae54a716c5c8d8785aaa5aec6c3cedddb6e6e41898951a7a77dc4c4a8dcdccb8d6f47b08b59c4a883d8c5ace7dcce";
                return "#" . substr($d, $c * 30 + $i * 6, 6);
            }

        }

        return tc($this->id*2);
    }

    public function __construct ($val = null) {
        parent::__construct('orders_monitoring__events_types', array(
            'id' => 'id' ,
            'order' => 'order',
            'title' => 'title',
            'description' => 'description'

        ));


        $this->load($val);
    }

    
    public function getTypeCountry($id) {
		if (empty($this->id))
			return false;
		
		$db = Zend_Registry::get('DBORDER');
		$query = $db->select();
		$query->from('orders_monitoring__eventType_connect_country AS A');
		$query->where('A.id_type = ?', $this->id);
		$query->where('A.id_country = ?', $id);
		$event = $db->fetchAll($query);
        if (empty($event)) {
			return false;
        } 
		else
		{
			return true;
		}
        

    }

    public function getTypeCountryList() {
		if (empty($this->id))
			return false;
		
		$db = Zend_Registry::get('DBORDER');
		$query = $db->select();
		$query->from('orders_monitoring__eventType_connect_country AS A');
		$query->where('A.id_type = ?', $this->id);
		$event = $db->fetchAll($query);
		foreach ( $event as &$item)
		{
			$item = new AK_Location_Country($item['id_country']);
		}
     //   print_r( $event);
        return $event;

    }
}

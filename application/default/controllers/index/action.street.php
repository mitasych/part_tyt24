<?php

      include_once(APP_DIR.'/default/initialize.php');
      $okato_item = new AK_okato_Item($okato);

      $this->view->name = $okato_item->getName();


?>

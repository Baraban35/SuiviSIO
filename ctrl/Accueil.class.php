<?php
include_once 'control.class.php';
class Accueil extends Control {

    public function __construct($util, $get=null) {
        parent::__construct($util);

        $data["auth"]=$this->setViewMenu();
        
        $this->view->init('corpsaccueil.php',$data);
        $this->setViewBas();
    }
}


?>

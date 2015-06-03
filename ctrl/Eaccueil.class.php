<?php
include_once 'control.class.php';

class Eaccueil extends Control {

    public function __construct($util, $get=null) {
        parent::__construct($util);
      
        $this->setViewMenu();
        
        $suff=$get["q"];
        
        $this->view->init('corpsaccueil'.$suff.'.php',null);
        $this->setViewBas();
    }
}


?>

<?php
include_once 'control.class.php';

class Bilan extends Control {

    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();


        $this->setViewMenu();

        if (isset($get["depuis"])) $depuis=$get["depuis"]; else $depuis=1;

        $model = new Model();
        $data["bilan"]=$model->getBilan($this->util->getId());

        $data["auth"]=$this->util->estAuthent();

        $this->view->init('bilan.php',$data);

        $this->setViewBas();
        $model->close();
    }
}


?>

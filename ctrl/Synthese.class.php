<?php
include_once 'control.class.php';

class Synthese extends Control {

    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();
        $model = new Model();

        //tableau reglementaire en premiere page
        $data["tableau"]=$model->getTableauSyntheseNew($util->getId());

        //puis une page par situation
        //pas vues dans cette version
        $data["synth"]=$model->getSynth($util->getId());
        $model->close();

        $data["auth"]=$this->util->estAuthent();
        $this->view->init('synthese.php',$data);



    }
}


?>

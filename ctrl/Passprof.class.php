<?php
include_once 'control.class.php';


class Passprof extends Control {

    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();
        $model = new Model();
        $data["auth"]=$this->util->estAuthent();

        if (!isset($get["num"])) {
          $data["liste"]=$model->getElevesGroupe($util->getNumGroupe());
          $data["droit"]=$this->util->estProf();
          $model->close();
          $this->setViewMenu();
          $this->view->init('passprof.php',$data);
          $this->setViewBas();
        } else {
          $l=$get["l"];
          if ($get["l"]=="p"){
          	$data["tableau"]=$model->getTableauSyntheseNew($get["num"]);
          	$data["synth"]=$model->getSynth($get["num"]);
          	$model->close();
          	$this->view->init('synthese.php',$data);
          } else {
          	$data["bilan"]=$model->getBilan($get["num"]);
          	$model->close();
          	$this->setViewMenu();
        	$this->view->init('bilan.php',$data);
        	$this->setViewBas();
          }
        }
    }
}


?>

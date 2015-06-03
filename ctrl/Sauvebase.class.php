<?php
include_once 'control.class.php';

class Sauvebase extends Control {



  public function __construct($util, $get=null) {
    parent::__construct($util);


    $this->model();

    $model = new Model();

    $data["nomfic"]=$model->exporter($util->getId());

    $this->setViewMenu();



    $this->view->init('sauvebase.php',$data);
    $this->setViewBas();
  }
}
?>

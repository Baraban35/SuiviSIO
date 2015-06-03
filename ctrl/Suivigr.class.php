<?php
include_once 'control.class.php';


class Suivigr extends Control {
    
    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();
        $model = new Model();
        $data["auth"]=$this->util->estAuthent();
        
        if (isset($get["num"])) {
          $num=$get["num"];
          $data["nom"]=$get["nom"];
          $data["eleves"]=$model->getElevesGroupe($num);
          $data["profs"]=$model->getProfsGroupe($num);
        } else
          $data["groupes"]=$model->getGroupes();

        $this->setViewMenu();
        $this->view->init('suivigr.php',$data);
        $model->close();
        $this->setViewBas();
        
                
    }
}


?>

<?php
include_once 'control.class.php';


class Finetude extends Control {
    
    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();
        $model = new Model();
        $data["auth"]=$this->util->estAuthent();
        
        if (isset($get["num"])) {
          $num=$get["num"];
          $data["nom"]=$get["nom"];
          $data["eleves"]=$model->getElevesGroupe($num);
          //$data["profs"]=$model->getProfsGroupe($num);
        } else {
          if (isset($get["etud"])) {
            foreach ($get["etud"] as $unetud) {
              $model->suppPersonne(2,$unetud);
            }
          }
          $data["groupes"]=$model->getGroupes();
        }
        $model->close();
        $this->setViewMenu();
        $this->view->init('finetude.php',$data);
        $this->setViewBas();
        
                
    }
}


?>

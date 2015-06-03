<?php
include_once 'control.class.php';

class Valid extends Control {

    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();


        $this->setViewMenu();
        
        if (isset($get["vers"])) $vers=$get["vers"]; else $vers=1;
        if (isset($get["depuis"])) $depuis=$get["depuis"]; else $depuis=1;

        $model = new Model();
        
        if (isset($get["enregistrer"])){ //on a cliqué un bouton enregistrer
          if (isset($get["li"])) //il y a des situs (inutile ici...)
            $model->validSitu($get["chk"],$this->util->getId(),$get["li"]);
        }

        $data["lessitus"]=$model->getSitus($util->getId(),$util->getNumGroupe(),$vers);
        $data["auth"]=$this->util->estAuthent();
        $data["vers"]=$vers;

        $data["type"]="V";//validations
        
        $this->view->init('dessitus.php',$data);
        $this->setViewBas();
        $model->close();
    }
}

?>

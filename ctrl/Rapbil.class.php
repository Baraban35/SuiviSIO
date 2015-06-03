<?php
include_once 'control.class.php';

class Rapbil extends Control {

    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();

        
        $this->setViewMenu();

        if (isset($get["depuis"])) $depuis=$get["depuis"]; else $depuis=1;
        
        $model = new Model();
        
        if (isset($get["t"])){
           $t=$get["t"];
           if (isset($get["a"])){
             $a=$get["a"];
             switch ($a){
              case "s"://suppression
                $model->supprimerDoc($get["iddoc"],$t,$this->util->getId());
                break;
              case "r"://restaure
                $model->restaurerDoc($get["iddoc"],$t,$this->util->getId());
                break;
              case "d"://detruire
                $model->detruireDoc($get["iddoc"],$t,$this->util->getId());
                break;
             }
          }
        }
        

        $data["liste"]=$model->getLesDoc($this->util->getId());
        
        $data["auth"]=$this->util->estAuthent();
        //$data["t"]=$t;
        
        $this->view->init('voircpt.php',$data);

        $this->setViewBas();
        $model->close();
    }
  }

?>

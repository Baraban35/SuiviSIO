<?php
include_once 'control.class.php';

class Suppr extends Control {

    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();
        
        $this->setViewMenu();
        
        if (!isset($get["vers"])) $vers=1; else $vers=$get["vers"];
        if (!isset($get["depuis"])) $depuis=1; else $depuis=$get["depuis"];
        
        $model = new Model();
        
        if (isset($get["num"])) $num=$get["num"]; else $num=null;
        if (isset($get["ty"])) $ty=$get["ty"]; else $ty=0;//rest par défaut
        if (!is_null($num)) {
          if ($ty==1){//on supprime
            $model->suppPersonne($vers,$num);
          } else { //restaure
            $model->restPersonne($vers,$num);
          }
        }
        $data["suppr"]=$model->getSuppr($vers);
        $data["vers"]=$vers;
        $data["auth"]=$this->util->estAuthent();    
        
        $model->close();
        
        $this->view->init('suppr.php',$data);
        $this->setViewBas();

    }
}

?>

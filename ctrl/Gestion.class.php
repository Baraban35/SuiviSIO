<?php
include_once 'control.class.php';


class Gestion extends Control {

    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();
        $model = new Model();

          if (isset($get["mode"])){
            $mode=$get["mode"];
            $numsitu=$get["numsitu"];

            switch ($mode){
              case 1:
                $model->supprSitu($numsitu);
                break;
              case 2:
                $model->recupSitu($numsitu);
                break;
              case 3:
                $model->destrucSitu($numsitu);
                break;
            }
          }
          $data["lessitusel"]=$model->getSitusEl($util->getId());

        $model->close();
        $this->setViewMenu();

        $data["auth"]=$this->util->estAuthent();

        $this->view->init('dessitusel.php',$data);

        $this->setViewBas();

    }
}


?>

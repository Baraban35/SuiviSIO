<?php
include_once 'control.class.php';

class Passeport extends Control {

    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();
        $model = new Model();
        if (isset($get["ep"])) $ep=$get["ep"]; else $ep=1;
        $data["passeport"]=$model->getPasseport($util->getId(),$ep,$util->estLibre());

        $model->close();

        $data["auth"]=$this->util->estAuthent();
        $this->view->init('passeport.php',$data);


    }
}


?>

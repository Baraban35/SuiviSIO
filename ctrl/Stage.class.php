<?php
include_once 'control.class.php';

class Stage extends Control {

    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();


        $this->setViewMenu();

        if (isset($get["depuis"])) $depuis=$get["depuis"]; else $depuis=1;
        if (isset($get["t"])) $t=$get["t"]; else $t="";

        if (isset($get["iddoc"])) $iddoc=$get["iddoc"]; else $iddoc=0;

        if (isset($get["e"])) $e=$get["e"]; else $e="t"; //fichier titre pas supprimé par defaut

        $model = new Model();
        if (!is_null($get["sauve"])) //enregistre
          $iddoc = $model->sauveDoc($e,$iddoc,$get["titre"],$get["el"],$this->util->getNom(), $this->util->getId(),$t);


        if ($iddoc!=0)//relit
          $data["doc"]=$model->getUnDoc($e,$iddoc, $this->util->getId(),$t);

        $data["auth"]=$this->util->estAuthent();
        $data["iddoc"]=$iddoc;
        $data["t"]=$t;
        $data["e"]=$e;

        $this->view->init('saisiecpt.php',$data);

        $this->setViewBas();
        $model->close();
    }
  }

?>

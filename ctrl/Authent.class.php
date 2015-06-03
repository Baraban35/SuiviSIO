<?php
include_once 'control.class.php';

class Authent extends Control {
//authentification en ouverture session
    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();

        $mel=$this->ha($get["login"]);
        $mdp=$this->ha($get["mdp"]);
        //$groupe=$this->ha($get["groupe"]);
        $data=null;

        if ($this->ctrlmel($mel)) {

          $model = new Model();

          //if ($mel!="" && $mdp!="" && $groupe!=""){ //3 champs remplis
          if ($mel!="" && $mdp!=""){ //2 champs remplis
          	  $crypte= new Crypte();
          	  if ($crypte->getCrypte()) $mdp=md5($mdp);
              //if ($tb=$model->getAuthent($mel,$mdp,$groupe)){
          	  if ($tb=$model->getAuthent($mel,$mdp)){
                $this->util->init($tb[0]["num"],$tb[0]["nom"],$tb[0]["prenom"],
                                  $tb[0]["niveau"],$tb[0]["groupes"]);
                $_SESSION['ctrl']=$this->util ;
              }
          }
          $model->close();
        }

        $this->setViewMenu();

        $suff="";
        if($this->util->estEtudiant()) $suff="e";

        if($this->util->estProf() || $this->util->estLecteur()) $suff="p";

        if($this->util->estAdmin()) $suff="a";


        $this->view->init('corpsaccueil'.$suff.'.php',$data);
        $this->setViewBas();
    }
}


?>

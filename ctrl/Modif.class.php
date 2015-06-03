<?php
include_once 'control.class.php';

class Modif extends Control {

    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();

        $model = new Model();


        $texte=null;

        if (isset($get["num"])) { //vient de l'ihm
          $num=$get["num"];
          $enregistrer=$get["envoi"];
          if (!is_null($enregistrer)){ //on a cliqué un bouton enregistrer

            $ret=false;
            $crypte = new Crypte();

            if ($num==1) { //prof ou lecteur
              //if (isset($get["auto"])) $a='O'; else $a='N';
              $nom=$this->ha($get["nom"]);
              $prenom=$this->ha($get["prenom"]);

              $mel=$this->ha($get["mel"]);

              if (isset($get["chmdp"]))
              	$mdp=$this->ha($get["mdp"]);
              else $mdp=null;

              if ($this->ctrlmel($mel)) {
                $ret=$model->majProf($get["numpers"],$nom,$prenom,$mel,$mdp,$crypte->getCrypte(),$crypte->getSmtp());
              }
            } else {
              if ($num==3) { //étudiant
                $nom=$this->ha($get["nom"]);
                $prenom=$this->ha($get["prenom"]);
                $mel=$this->ha($get["mel"]);
                $numexam=$this->ha($get["numexam"]);
                if (isset($get["chmdp"]))
                	$mdp=$this->ha($get["mdp"]);
                else $mdp=null;
                if ($this->ctrlmel($mel)) {
                  $ret=$model->majEleve($get["numpers"],$nom,$prenom,$mel,$mdp,$crypte->getCrypte(),$crypte->getSmtp(),$numexam);
                }
              }
            }
            if ($ret) $texte="Donn&eacute;es enregistr&eacute;es";
            else $texte="Donn&eacute;es incorrectes";
          }
        }

        if ($this->util->estProf() || $this->util->estLecteur()) {
          //prof ou lecteur
          $data["data"]=$model->getProfesseurModif($util->getId());
          $data["num"]=1;
        } else {
          if ($this->util->estEtudiant()) {
            //etudiant
            $data["data"]=$model->getEleveModif($util->getId());
            $data["num"]=3;
          }
        }
        $data["lngmdp"]=$model->getLng();
        $model->close();

        $data["messagetexte"]=$texte;
        $data["auth"]=$this->util->estAuthent();

        $this->setViewMenu();

        $this->view->init('modif.php',$data);
        $this->setViewBas();
    }
}



?>

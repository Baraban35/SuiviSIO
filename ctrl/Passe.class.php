<?php
include_once 'control.class.php';

class Passe extends Control {

    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();
        
        $model = new Model();

        $this->setViewMenu();
        
        $mess='';

        if(isset($get["envoi"])){ //bouton envoi
          $nb=0;
          
          if (isset($get["groupes"])){
            $ls=$get["groupes"];
            for ($i=0;$i<count($ls);$i++) { //pour chaque groupe
              $res=$model->getMelsElevesGroupe($ls[$i]);
              for ($j=0;$j<count($res);$j++){ //pour chaque élève j d'un groupe i
                $this->envoimel($res[$j]["mel"],$res[$j]["mdp"]);
                $nb++;
              }
            }
          }
          
          if (isset($get["professeurs"])){
            $ls=$get["professeurs"];
            for ($i=0;$i<count($ls);$i++) { //pour chaque prof
              $res=$model->getMelProfesseur($ls[$i]);
              $this->envoimel($res[0]["mel"],$res[0]["mdp"]);
              $nb++;
            }
          }
          
          if (isset($get["etudiants"])){
            $ls=$get["etudiants"];
            for ($i=0;$i<count($ls);$i++) { //pour chaque élève
              $res=$model->getMelEleve($ls[$i]);
              $this->envoimel($res[0]["mel"],$res[0]["mdp"]);
              $nb++;
            }          
          }
          $mess=$nb." message(s) envoy&eacute;(s)";
        } 
        
        $data=array("groupes"=>$model->getGroupes(),
                    "professeurs"=>$model->getProfesseurs(),
                    "etudiants"=>$model->getEtudiants(),
                    "messagetexte"=>$mess);
        $model->close();
        $data["auth"]=$this->util->estAuthent();
        $this->view->init('passe.php',$data);
        $this->setViewBas();
        
    }
    
    function envoimel($mel,$mdp){
      //echo $mel." - ".$mdp.'<br />';
      $txt ="Votre mot de passe pour le passeport informatique est : ".$mdp;
      $txt.="\nVotre identifiant est votre adresse mel (celle de cet envoi)";
      //$txt.="\nAdresse du site : "."www.passeport.fr";
      mail($mel, "[passeport]votre code", $txt);
    }
}


?>

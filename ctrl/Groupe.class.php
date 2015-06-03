<?php
include_once 'control.class.php';

class Groupe extends Control {
//le mot groupe utilisé en interne a été remplacé par "promotion" sur les ihm
    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();

        $texte=null;
        if (isset($get["num"])) $num=$get["num"]; else $num=null;
        $rech=false;
        // si null, vient de menua (menu admin)
        $model = new Model();
        $crypte= new Crypte();
        if (!is_null($num)){ //origine=clic un bouton enregistrer ou supprimer

          if (isset($get["envoi"])) $enregistrer=$get["envoi"]; else $enregistrer=null;
          if (!is_null($enregistrer)){ //on a cliquÃ© un bouton envoi

            switch ($num){
              case 1: //vient de la page groupe
                $nombouton = $get["envoi"];
                if ($nombouton=="Enregistrer"){
                  if ($get["nom"]!='' && $get['an']!=''){
                    if (preg_match("/^[0-9]{2}/",$get["an"])){
                      $nom=$this->ha($get["nom"]);
                      $an=$this->ha($get["an"]);
                      $parcours=$get["parcours"];

                      if (!isset($get["numgroupe"])){ //crÃ©ation groupe
                        if ($model->setGroupe($nom,$an,$parcours)) {
                          $texte='Groupe cr&eacute;&eacute;';
                        } else {
                          $texte='Ce groupe existe d&eacute;j&agrave;';
                        }
                      } else { //modif groupe
                        $numgroupe=$get["numgroupe"];
                        $rep=$model->modifGroupe($numgroupe,$nom,$an,$parcours);
                        $texte='Groupe modifi&eacute;';
                      }
                    }
                  }
                }
                if ($nombouton=="Supprimer"){
                  if (isset($get["numgroupe"])){
                    $numgroupe=$get["numgroupe"];

                    if ($numgroupe!=0){
                      $model->delGroupe($numgroupe);
                      $texte='Groupe supprim&eacute;';
                    }
                  }
                }
                break;
              case 2:  //vient bouton enregistrement prof
                $nombouton = $get["envoi"];
                if ($nombouton=="Enregistrer"){
                  $nom=$this->ha($get["nom"]);
                  $mel=$this->ha($get["mel"]);
                  if ($nom!='' && $mel !='' && $this->ctrlmel($mel)){
                    $prenom=$this->ha($get["prenom"]);
                    $niveau=$get["niveau"];

                    if (isset($get["chk"])) $chk=$get["chk"]; else $chk=array();

                    if (!isset($get["numprof"])){//crÃ©ation
                      $res=$model->setProf($nom,$prenom,$mel,$niveau,$crypte->getSmtp(),$crypte->getCrypte());
                      if ($res){
                        $numprof = $model->getId();
                        $model->affecteGroupe($numprof,$chk);
                      }
                    } else {//maj
                      $numprof=$get["numprof"];
                      if (isset($get["chmdp"]))
                      	$mdp=$this->ha($get["mdp"]);
                      else $mdp=null;
                      $res=$model->modifProf($numprof,$nom,$prenom,$mel,$niveau,$mdp,$crypte->getSmtp(),$crypte->getCrypte());
                      if ($res)
                        $model->modifAffecteGroupe($numprof,$chk);
                    }
                    if ($res)
                      $texte='donn&eacute;es enregistr&eacute;es';
                    else
                      $texte='pas d\'enregistrement (doublon)';
                  } else $texte='donn&eacute;es incorrectes';
                }
                if ($nombouton=="Supprimer"){
                  $numprof=$get["numprof"];
                  if (!is_null($numprof)){
                    if ($numprof!=0){
                      $model->suppProf($numprof);
                      $texte='Professeur supprim&eacute;';
                    }
                  }
                }
                break;
              case 3:  //vient bouton enregistrement Ã©tudiant
                $nombouton = $get["envoi"];
                if ($nombouton=="Enregistrer"){
                  $nom=$this->ha($get["nom"]);
                  $prenom=$this->ha($get["prenom"]);
                  $mel=$this->ha($get["mel"]);

                  if ($nom!='' && $mel !='' && $this->ctrlmel($mel)){
                    $groupe=$get["groupe"];
                    if ($groupe==0) $groupe='null';

                    if (!isset($get["numetud"])){
                      $res=$model->setEtudiant($nom,$prenom,$mel,$groupe,$crypte->getSmtp(),$crypte->getCrypte());
                    }else{
                      $numetud=$get["numetud"];
                      if (isset($get["chmdp"]))
                      	$mdp=$this->ha($get["mdp"]);
                      else $mdp=null;
                      $res=$model->modifEtudiant($numetud,$nom,$prenom,$mel,$groupe,$mdp,$crypte->getSmtp(),$crypte->getCrypte());
                    }
                    if ($res)
                      $texte='donn&eacute;es enregistr&eacute;es';
                    else
                      $texte='pas d\'enregistrement (doublon)';
                  } else $texte='donn&eacute;es incorrectes';
                }

                if ($nombouton=="Supprimer"){
                  $numetud=$get["numetud"];
                  if (!is_null($numetud)){
                    if ($numetud!=0){
                      $model->suppEtud($numetud);
                      $texte='&Eacute;tudiant supprim&eacute;';
                    }
                  }
                }
                break;
              case 4: //on vient page recherche objet
                $rech=true;
                $nombouton = $get["envoi"];
                if ($nombouton=="Rechercher"){
                    $codeobj=$get["groupes"];
                    if ($codeobj>0) $num=1;
                    else {
                      $codeobj=$get["professeurs"];
                      if ($codeobj>0) $num=2;
                      else {
                        $codeobj=$get["etudiants"];
                        $num=3;
                      }
                    }
                }
                break;

              case 5: //on vient page tÃ©lÃ©versement fichier Ã©lÃ¨ve
                $repfic = 'dirrw/upload/';
                $groupe=$get["groupes"];
                if ($groupe==0){
                  $texte="choisir le groupe d'affectation";
                }else{
                  $texte="";
                  if(empty($_FILES['fichier']['name'])){
                    $texte="aucun fichier s&eacute;lectionn&eacute;";
                  } else {
                    $tmp = $_FILES['fichier']['tmp_name'];
                    if( !is_uploaded_file($tmp) ){
                      $texte="fichier non trouv&eacute;";
                    } else {
                      $nf = $_FILES['fichier']['name'];
                      if ($nf!="noms.csv"){
                        $texte="ce nom de fichier ne convient pas";
                      } else{
                        if(!move_uploaded_file($tmp,$repfic.$nf)){
                          $texte="impossible de copier le fichier";
                        }else{
                          $texte= "le fichier a &eacute;t&eacute; t&eacute;l&eacute;vers&eacute;";
                          //$nb=$this->enregData($groupe);

                          //on lit le fichier de noms, on les enregistre dans la BD
                          // puis on efface le fichier
                          //on compte le nombre d'erreurs d'enregistrement
                          $flu = fopen("dirrw/upload/noms.csv","r");

                          $nb=0; //nb erreurs

                          while ($ligne = fgetcsv($flu, 140, ";")) {
                            $nom=$ligne[0];
                            $prenom=$ligne[1];
                            $mel=$ligne[2];
                            //tester vraisemblances : à faire pour plus tard...
                            if (!$model->setEtudiant($nom,$prenom,$mel,$groupe,$crypte->getSmtp(),$crypte->getCrypte())) $nb++;
                          }

                          fclose ($flu);
                          //supprimer fichier
                          unlink("dirrw/upload/noms.csv");


                          if ($nb==0){
                            $texte.= " et les donn&eacute;es mises &agrave; jour";
                          } else {
                            $texte.= " mais son contenu n'est pas correct (".$nb." probl&egrave;me(s))";
                          }
                        }
                      }
                    }
                  }
                }

                break;
              }
          }
        } //fin gestion bouton enregistrer ou supprimer
        else $num=1;

        $this->setViewMenu();


        switch ($num){
          case 1:
            if ($rech) {
              $data=array("groupe"=>$model->getGroupe($codeobj));
            } else{
              $data=array("groupes"=>$model->getGroupes());
            }
            break;
          case 2:
            if ($rech) {
              $data=array("professeur"=>$model->getProfesseur($codeobj),
                          "groupes"=>$model->getGroupesProf($codeobj));
            } else{
              $data=array("groupes"=>$model->getGroupes());
            }
            break;
          case 3:
            if ($rech) {
              $data=array("etudiant"=>$model->getEtudiant($codeobj),
                          "groupes"=>$model->getGroupes());
            } else{
              $data=array("groupes"=>$model->getGroupes());
            }
            break;
          case 4:
            $data=array("groupes"=>$model->getGroupes(),
                        "professeurs"=>$model->getProfesseurs(),
                        "etudiants"=>$model->getEtudiants());
            break;
          case 5:
            $data=array("groupes"=>$model->getGroupes());
        }

        $data["lng"]=$model->getLng();

        $model->close();
        $data["param"]=$num;

        $data["messagetexte"]=$texte;
        $data["auth"]=$this->util->estAuthent();

        $this->view->init('groupe'.$num.'.php',$data);
        $this->setViewBas();
    }


}


?>

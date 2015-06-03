<?php
include_once 'control.class.php';

class Sauve extends Control {

    public function __construct($util, $get=null) {
        parent::__construct($util);


        $this->model();

        $model = new Model();

        $nbsauve = 3; //nombre max de sauvegardes par étudiant

        $dec=0; //valeur indentation
        $decsup=2;  //incrément d'indentation

        $nt=$this->util->getId();
        $nf=substr('0000'.$nt,-4,4);

        $refsauve=uniqid();

        $repfic = 'dirrw/xml/';

        $extene='.xml';


        // ne conserve que nbsauve fichiers

        $dir=opendir($repfic);
        $fics=array();
        $nbfics=0;
        while ($fic=readdir($dir)){
          if (substr($fic,0,4)==$nf){
            $fics[]=$fic;
            $nbfics++;
          }
        }
        if ($nbfics>=$nbsauve){ //il y a trop de fichiers on en supprime nbsauve-1
          rsort($fics);
          for ($i=$nbsauve-1;$i<$nbfics;$i++){//normalement un seul à effacer
            unlink($repfic.$fics[$i]);
          }
        }

        closedir($dir);

        //sauvegarde, on en ajoute 1 dans le répertoire
        $nomfice=$repfic.$nf.$refsauve."G".$extene;

        $fic =fopen($nomfice,"w");

        $entete='<?xml version="1.0" encoding="ISO-8859-1"  standalone="yes" ?'.">\r\n";
        fputs($fic,$entete);
        fputs($fic,$this->lgx($dec,"suivicomp","","",1));
        $dec+=$decsup;


        fputs($fic,$this->lgx($dec,"sauvegarde","ref",$refsauve,2));
        $dec+=$decsup;
        fputs($fic,$this->lgx($dec,"ref","",$refsauve,3));
        fputs($fic,$this->lgx($dec,"datesv","",date("Y-m-d"),3));
        $dec-=$decsup;
        fputs($fic,$this->lgx($dec,"sauvegarde","","",4));

        $ligne=$model->getEtudiant($nt);

        fputs($fic,$this->lgx($dec,"etudiant","numero",$nt,2));
        $dec+=$decsup;
        fputs($fic,$this->lgx($dec,"nom","",$ligne[0]["nom"],3));
        fputs($fic,$this->lgx($dec,"prenom","",$ligne[0]["prenom"],3));
        fputs($fic,$this->lgx($dec,"mel","",$ligne[0]["mel"],3));

        $tbs=$model->getSituationsXML($nt);
        //chaque situation
        foreach($tbs as $situ){
          $ns=$situ["ref"];

          fputs($fic,$this->lgx($dec,"situation","ref",$ns,2));
          $dec+=$decsup;

          //chaque donnée d'une situ
          foreach($situ as $cle=>$val) fputs($fic,$this->lgx($dec,$cle,"",$val,3));


          //les commentaires
          $com=$model->getCommentaireSauve($ns);
          if (count($com>0)) {
            foreach($com as $valid){
              fputs($fic,$this->lgx($dec,"avisprof","","",1));

              $dec+=$decsup;
              //chaque donnée d'un comm
              foreach($valid as $cle=>$val){
                fputs($fic,$this->lgx($dec,$cle,"",$val,3));
              }
              $dec-=$decsup;

              fputs($fic,$this->lgx($dec,"avisprof","","",4));
            }
          }


          //les activites cit�es
          $tbp=$model->getActiviteCitee($ns);
          //chaque activite citee
          foreach($tbp as $act){
            $numact = $act["idActivite"];
            fputs($fic,$this->lgx($dec,"activitecitee","numero",$numact,2));

            $dec+=$decsup;
            //chaque donnée d'une activite citee
            foreach($act as $cle=>$val){
              fputs($fic,$this->lgx($dec,$cle,"",$val,3));
            }
            $dec-=$decsup;
            fputs($fic,$this->lgx($dec,"activitecitee","","",4));
          }

            //les productions
           $tbp = $model->getProduction($ns);
           //chaque production
           foreach($tbp as $prod){
             $nc=$prod["numero"];
             fputs($fic,$this->lgx($dec,"production","numero",$nc,2));
             $dec+=$decsup;
             //chaque donnée d'une production
             foreach($prod as $cle=>$val){
               fputs($fic,$this->lgx($dec,$cle,"",$val,3));
             }
             $dec-=$decsup;
             fputs($fic,$this->lgx($dec,"production","","",4));
           }


           //les typologies (types situation obligatoires)
           $tbp = $model->getTypologies($ns);
           //chaque typologie
           foreach($tbp as $typo){
             //$nc=$prod["numero"];
             fputs($fic,$this->lgx($dec,"typologie","","",1));
             $dec+=$decsup;
             //chaque donnée d'une typologie
             foreach($typo as $cle=>$val){
               fputs($fic,$this->lgx($dec,$cle,"",$val,3));
             }
             $dec-=$decsup;
             fputs($fic,$this->lgx($dec,"typologie","","",4));
           }




          $dec-=$decsup;
          fputs($fic,$this->lgx($dec,"situation","","",4));
        }//fin chaque situation

        $dec-=$decsup;
        fputs($fic,$this->lgx($dec,"etudiant","","",4));
        $dec-=$decsup;
        fputs($fic,$this->lgx($dec,"suivicomp","","",4));
        fclose($fic);



        $model->close();

        $this->setViewMenu();

        $data["fic"]=$nf.$refsauve."G".$extene;
        $data["auth"]=$this->util->estAuthent();

        $this->view->init('sauvee.php',$data);
        $this->setViewBas();
  }


  function lgx($distance,$balise,$attribut,$valeur,$type){
    $d=str_repeat(" ", $distance);
    $v=stripslashes($valeur);
    switch ($type) {
      case 1:
        $l=$d."<".$balise.">";
        break;
      case 2:
        $l=$d."<".$balise." ".$attribut.'="'.$v.'">';
        break;
      case 3:
        $l=$d."<".$balise.">".$v."</".$balise.">";
        break;
      case 4:
        $l=$d."</".$balise.">";
        break;
    }
    return $l."\r\n";
  }
}



?>

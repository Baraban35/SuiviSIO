<?php
include_once 'control.class.php';

class Recup extends Control {

    public function __construct($util, $get=null) {
        parent::__construct($util);

    //upload fichier par admin ou prof
      $repfic = 'dirrw/upload/';
      $me="";

      $np=$util->getId(); //numero prof ou admin

      if (isset($get["envoi"])) {
        if(empty($_FILES['fichier']['name'])){
          $me="aucun fichier s&eacute;lectionn&eacute;";
        } else {
          $tmp = $_FILES['fichier']['tmp_name'];
          if( !is_uploaded_file($tmp) ){
            $me="fichier non trouv&eacute;";
          } else {
            $nfo = $_FILES['fichier']['name']; //nom original
            $nf = preg_replace("/[^0-9a-fGxml.]/","_",$nfo);
            $rge="/^[0-9]{4}[0-9a-f]{13}G(.xml)$/";
            if (!preg_match($rge,$nf)){
                $me="ce nom de fichier ne convient pas";
            } else{
                if(!move_uploaded_file($tmp,$repfic.$nf)){
                  $me="impossible de copier le fichier";
                }else{
                  $me= "le fichier a &eacute;t&eacute; t&eacute;l&eacute;vers&eacute;";
                  $rep=$this->enregDataEtudXML($repfic,$nf);
                  if ($rep==''){
                    $me.= " et les donn&eacute;es mises &agrave; jour";
                  } else {
                    $me.= " mais son contenu n'est pas correct (".$rep.")";
                  }
                  if (file_exists($repfic.$nfo)) unlink($repfic.$nfo);
                }
            }
          }
        }
      }
      $data["messagetexte"]=$me;
      $data["auth"]=$this->util->estAuthent();
      $this->setViewMenu();
      $this->view->init('recup.php',$data);
      $this->setViewBas();
    }

  function enregDataEtudXML($repfic,$nf){
   $ok='';
   $this->model();
   $model = new Model();
   if($ch = implode("",file($repfic.$nf))) {
      $data='sauvegarde';
      $tb1 = preg_split("/<\/?".$data.".*>/",$ch);
      $dataSv = array("ref","datesv");
      foreach($dataSv as $balise){
        $tb2 = preg_split("/<\/?".$balise.">/",$tb1[1]);
        $res[] = $tb2[1];
      }
      $ref=$res[0];
      $datesv=$res[1];
      if (substr($nf,4,13)==$ref){
        $data='etudiant';
        $tb1 = preg_split("/<\/?".$data.".*>/",$ch);
        $ch=$tb1[1];

        $res=null;
        $dataEleve = array("nom","prenom","mel");
        foreach($dataEleve as $balise){
          $tb2 = preg_split("/<\/?".$balise.">/",$ch);
          $res[]=$tb2[1];
        }
        $ch=$tb2[2];
        //$nom=$res[0];
        //$prenom=$res[1];
        $mel=$res[2];

        $resmel=$model->existeMelEtudiant($mel);
        $num=$resmel[0]["num"];
        if (!is_null($num)){
          $model->supprSituEtudiantTout($num);
          $chSit="situation";
          $tb4 =  preg_split("/<\/?".$chSit.".*>/",$ch);
          for($i=1;$i<count($tb4)-1;$i+=2){ //itération sur situation
            $res=null;
            $dataSit= array("ref","codeType","codeLocalisation","codeSource","codeCadre","libcourt",
            "descriptif","contexte","datedebut","datefin","environnement","moyen","avisperso");
            foreach($dataSit as $balise){
              $tb2 = preg_split("/<\/?".$balise.">/",$tb4[$i]);
              $res[] = $tb2[1];
            }
            $ref=$model->creeSituation($res,$num);

            $chPro="avisprof";
            $tb5= preg_split("/<\/?".$chPro.".*>/",$tb4[$i]);
            for($j=1;$j<count($tb5)-1;$j+=2){
              $res=null;
              $dataPro= array("commentaire", "datecommentaire","numprof","nomprof","melprof");
              foreach($dataPro as $balise){
                $tb2 = preg_split("/<\/?".$balise.">/",$tb5[$j]);
                $res[] = $tb2[1];
              }
              $model->creeCommentaire($res,$ref);
            }

            $chPro="activitecitee";
            $tb5= preg_split("/<\/?".$chPro.".*>/",$tb4[$i]);
            for($j=1;$j<count($tb5)-1;$j+=2){
              $res=null;
              $dataPro= array("idActivite","commentaireactivite");
              foreach($dataPro as $balise){
                $tb2 = preg_split("/<\/?".$balise.">/",$tb5[$j]);
                $res[] = $tb2[1];
              }
              $model->creeActivitecitee($res,$ref);
            }

            $chPro="production";
            $tb5= preg_split("/<\/?".$chPro.".*>/",$tb4[$i]);
            for($j=1;$j<count($tb5)-1;$j+=2){
              $res=null;
              $dataPro= array("designation","adresse");
              foreach($dataPro as $balise){
                $tb2 = preg_split("/<\/?".$balise.">/",$tb5[$j]);
                $res[] = $tb2[1];
              }
              $model->creeProduction($res,$ref);
            }

            $chPro="typologie";
            $tb5= preg_split("/<\/?".$chPro.".*>/",$tb4[$i]);
            for($j=1;$j<count($tb5)-1;$j+=2){
              $res=null;
              $dataPro= array("codeTypologie");
              foreach($dataPro as $balise){
                $tb2 = preg_split("/<\/?".$balise.">/",$tb5[$j]);
                $res[] = $tb2[1];
              }
              $model->creeTypologie($res,$ref);
            }
          }
        }else $ok="mel &eacute;tudiant inconnu";
      } else $ok='mauvaise r&eacute;f&eacute;rence de fichier';
    }else $ok="erreur fichier serveur";
    $model->close();
    return $ok;
  }
}
?>

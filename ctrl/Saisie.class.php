<?php
include_once 'control.class.php';


class Saisie extends Control {

    private function dteusa($d){
      return substr($d,6,4)."-".substr($d,3,2)."-".substr($d,0,2);
    }

    private function nbJ($dd, $df) {
      $td = explode("-", $dd);
      $tf = explode("-", $df);
      $dif=mktime(0,0,0,$tf[1],$tf[2],$tf[0])-mktime(0,0,0,$td[1],$td[2],$td[0]);
      return $dif/86400;
    }


    public function __construct($util, $get=null) {
        parent::__construct($util);

        $this->model();
        $model = new Model();

        $this->setViewMenu();

        if (isset($get["vers"])) $vers=$get["vers"]; else $vers=1;
        if (isset($get["depuis"])) $depuis=$get["depuis"]; else $depuis=1;
        if (isset($get["numsitu"])) $numsitu=$get["numsitu"]; else $numsitu=0;
        if (isset($get["commenter"])) $commenter=$get["commenter"]; else $commenter="N";
        if (isset($get["modif"])) $modif=$get["modif"]; else $modif="n";

        //debut enregistrements
        if (isset($get["enregistrer"]) || $modif=="o"){ //cliquÃ© bouton enregistrer ou changement onglet
          switch ($depuis){
            case 1 : //Ã©cran description
            	if ($this->util->estEtudiant()){
	              $lc=$this->ha($get["libcourt"]);
	              $de=$this->ha($get["description"]);
	              $pa=$this->ha($get["lieu"]);
	              $lo=$this->ha($get["localisation"]);
	              $so=$this->ha($get["source"]);
	              $ca=$this->ha($get["cadre"]);

	              $dd=$this->dteusa($this->ha($get["datedebut"]));
	              $df=$this->dteusa($this->ha($get["datefin"]));
	              if ($this->nbJ($dd,$df)<0) $df=$dd;
	              $ty=$this->ha($get["typedecrit"]);
	              $te=$this->ha($get["techno"]);
	              $ac=$this->ha($get["acteur"]);
	              $sg=$this->ha($get["situoblig"]);
	              $to=array();
	              if ($sg=="O" && isset($get["typologie"])) $to=$get["typologie"];
	              $av=$this->ha($get["avisperso"]);

	              $ideleve=$this->util->getId();

	              if ($numsitu==0){ //enregistrer donnÃ©es
	                  $numsitu=$model->setDescription($lc,$de,$pa,$lo,$so,$ca,$to,$dd,$df,$ty,$te,$ac,$av,$ideleve);
	              } else { //modifier les donnÃ©es
	                  $model->updateDescription($numsitu,$lc,$de,$pa,$lo,$so,$ca,$to,$dd,$df,$ty,$te,$ac,$av);
	              }
            	}
	             break;

            case 2 : //Ã©cran caractÃ©risation
            	if ($this->util->estEtudiant()){
            		$activchoisies=$get["lesactivschoisies"];
              		$model->gereActivChoisie($numsitu,$activchoisies);
            	}
              	break;
            case 3 : //saisie reformulation
            	if ($this->util->estEtudiant()){
            		$lescom=$get["comm"];
            		$idact=$get["idact"];
            		for ($i=0 ; $i<count($lescom) ;$i++)
            			$model->enregReformul($numsitu,$this->ha($lescom[$i]),$idact[$i]);
            	}
            	break;

			case 4 : // productions
				if ($this->util->estEtudiant()){
	              $de=$get["designation"]; // tableau de dÃ©signations
	              $ad=$get["adresse"]; // tableau des adresses
	              $codeP=$get["codeP"]; //tableau des codes productions
	              if (isset($get["chksup"])) $chksup=$get["chksup"]; else $chksup=null;
	              //les tableaux ont la mÃªme taille, sauf chksup
	              $nb=count($de);

	              for ($i=0;$i<$nb-1;$i++)
	                $model->updateProduction($numsitu,$codeP[$i],$this->ha($de[$i]),$this->ha($ad[$i]));
	              if ($de[$nb-1]!="")
	                $model->ajouteProduction($numsitu,$this->ha($de[$nb-1]),$this->ha($ad[$i]));
	              for ($i=0;$i<count($chksup);$i++)
	                $model->supprProduction($numsitu,$chksup[$i]);
				}
	            break;
			case 5 : //commentaires prof(s)
                 if ($commenter =="P" && $this->util->estProf())
            		if ($numsitu>0){
            			$txt=$this->ha($get["commnew"]);
            			if ($txt!='') $model->setCommentaire($numsitu,$txt, $this->util->getId());
              			if (isset($get["chksup"])) $model->supprCommentaire($get["chksup"]);
              			if (isset($get["comm"])) $model->majCommentaire($get["commref"],$get["comm"]);
            		}
              	 break;
          }
        } //fin gestion du bouton enregistrer

		//préparation données ihm à afficher
        switch ($vers){
          case 1://données situation
            $data=array("typesitu"=>$model->getTypeSitu(),
                        "localisation"=>$model->getLocalisation(),
                        "source"=>$model->getSource(),
                        "cadre"=>$model->getCadre(),
                        "type"=>$model->getType(),
            			"typologie"=>$model->getTypologie());
            if ($numsitu!=0)
              $data["lasitu"]=$model->getSitu1($numsitu);
            break;

          case 2://sélection activités
          	$data=array("typeactiv"=>$model->getActivites(),
          				"lescomp"=>$model->getCompetences());
        	if ($numsitu!=0) {
              $data["lasitu"]=$model->getSitu3($numsitu);
              $data["lesactiv"]=$model->getSitu2($numsitu);
            }
            break;
          case 3 : //ecran reformulation activité(s) par élève
            if ($numsitu!=0)
              $data["lasitu"]=$model->getSitu3($numsitu);
              $data["lesactiv"]=$model->getSitu4($numsitu);
            break;

          case 4 ://saisie productions
            $data=array();
            if ($numsitu!=0) {
              $data["lasitu"]=$model->getSitu3($numsitu);
              $data["lesprod"]=$model->getProd($numsitu);
            }
            break;

		  case 5 ://saisie ou affichage commentaires profs
            $data=array();
            if ($numsitu!=0) {
              $data["lasitu"]=$model->getSitu3($numsitu);
              $data["lescomm"]=$model->getCommentaire($numsitu);
              $data["idprof"]=$this->util->getId();
            }
            break;
        }//fin préparations spécifiques

        //pour toutes les ihm :
        $data["etudiant"]=$model->getAuteurSitu($numsitu);
        $model->close();

        $data["numsitu"]=$numsitu;
        $data["commenter"]=$commenter;
        $data["auth"]=$this->util->estAuthent();

        //appel page spécifique avec $data
        $this->view->init('saisie'.$vers.'.php',$data);
        $this->setViewBas();
    }
}

?>

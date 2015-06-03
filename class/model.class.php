<?php
include_once 'modele.class.php';

class Model extends Modele {

  public function __construct() {
    parent::__construct();
  }

  private function existeMel($mel,$num){
  // recherche  s'il existe un mel identique    $mel
  //si $num=null recherche partout
  //si $num=integer recherche sauf pour $num (=si $num poss de ce mel, c'est normal)
    $req='select count(*) as nb from '.$this->pref.'professeur where
          mel="'.$mel.'"';
    if (!is_null($num)) $req.=' and num!='.$num;
    $res=$this->mysql->execSQLRes($req);

    if ($res[0]["nb"]>0) { //ce m ©l est d ©j   enregistr © dans prof
      return true;
    } else {
      $req='select count(*) as nb from '.$this->pref.'etudiant where mel="'.$mel.'"';
      if (!is_null($num)) $req.=' and num!='.$num;
      $res=$this->mysql->execSQLRes($req);
      if ($res[0]["nb"]>0) { //ce m ©l est d ©j   enregistr © dans etud
        return true;
      } else {
        return false;
      }
    }
  }

  public function exporter($id) {
  	//export journalier format script sql en compress 
	return $this->sauveTables($id);
  }

    public function getMDPGroupe($numgroupe){
    $req='select num,nom,prenom,mel,mdp
          from '.$this->pref.'etudiant E
          where numGroupe='.$numgroupe.
          ' and valide="O"
          order by 2,3';
    return $this->mysql->execSQLRes($req);
  }

/*
  public function getSituExtrait($cs,$choix,$an,$groupe) {
  //$cs commence par C (comp) ou S (situ) suivi de id (comp) ou ref (situ)
  //$choix = g (groupe) a (ann ©e) ou t (tout)
    $num=substr($cs,1); //id ou ref
    $table=substr($cs,0,1); //C ou S
    $req='select ref, descriptif,lieu,tache
         from '.$this->pref.'situation
         where valide="O"';

    if ($table=="S") { //Situ
      $req.=' and idActivite='.$num;
      if ($choix=="a")
        $req.=' and numEtudiant in
          (select num from '.$this->pref.'etudiant
           where numGroupe in
            (select num from '.$this->pref.'groupe
             where annee="'.$an.'"))';
      if ($choix=="g")
        $req.=' and numEtudiant in
          (select num from '.$this->pref.'etudiant
           where numGroupe ='.$groupe.')';
    } else { //Comp
      $req.=' and ref in (select refSituation
         from '.$this->pref.'competencecitee
          where idCompetence='.$num.')';
      if ($choix=="a")
        $req.=' and numEtudiant in
           (select num from '.$this->pref.'etudiant
            where numGroupe in
             (select num from '.$this->pref.'groupe
              where annee="'.$an.'"))';
      if ($choix=="g")
        $req.=' and numEtudiant in
           (select num from '.$this->pref.'etudiant
            where numGroupe ='.$groupe.')';
    }
    //echo $req;
    return $this->mysql->execSQLRes($req);
  }
*/
  public function getTouteSituComp(){
    $req='select id, nomenclature, libelle
        from '.$this->pref.'activite
        order by id';
    $tb = $this->mysql->execSQLRes($req);
    for ($i=0;$i<count($tb);$i++){
      $req='select id, nomenclature, libelle
          from '.$this->pref.'competence
          where idActivite='.$tb[$i]["id"].'
          order by id';
      $tb[$i]["comp"]=$this->mysql->execSQLRes($req);
    }
    return $tb;
  }

  public function getElevesGroupe($groupe){
    $req='select num, nom, prenom from '.$this->pref.'etudiant where valide="O" and numgroupe='.$groupe.' order by 2,3,1';
    return $this->mysql->execSQLRes($req);
  }

  public function getProfsGroupe($groupe){
    $req='select num, nom, prenom from '.$this->pref.'professeur,'
       .$this->pref.'exerce where valide="O" and num=numProfesseur
        and numgroupe='.$groupe.' order by 2,3,1';
    return $this->mysql->execSQLRes($req);
  }

  public function getMelsElevesGroupe($groupe){
    $req='select mel,mdp from '.$this->pref.'etudiant where valide="O" and numgroupe='.$groupe;
    return $this->mysql->execSQLRes($req);
  }

  public function getMelEleve($num){
    $req='select mel,mdp from '.$this->pref.'etudiant where num='.$num;
    return $this->mysql->execSQLRes($req);
  }

  public function getMelProfesseur($num){
    $req='select mel,mdp from '.$this->pref.'professeur where num='.$num;
    return $this->mysql->execSQLRes($req);
  }

  public function enregDemande($prof,$num){
    $req='select ref from '.$this->pref.'situation S left join '.$this->pref.'commentaire V on S.ref=V.refSituation
          where numEtudiant='.$num.' and (validation = "N" or validation is null)';

    $tb=$this->mysql->execSQLRes($req);
    for ($i=0;$i<count($tb);$i++){
      $req='update '.$this->pref.'situation set demandeVal='.$prof. ' where ref='.$tb[$i]["ref"];

      $this->mysql->execSQL($req);
    }
  }

  public function getBilanComp($processus,$groupe){


    $tb=$this->getElevesGroupe($groupe);


        $req='select C.id as id, C.nomenclature as nomen,
              trim(C.libelle) as lib,  length(trim(C.libelle)) as ln
            from '.$this->pref.'competence C, '.$this->pref.'activite A, '.$this->pref.'domaine D
            where idActivite=A.id and idDomaine=D.id and idProcessus='.$processus.
            ' order by id' ;

    $tbc=$this->mysql->execSQLRes($req);


    //pour chaque  ©l ¨ve recherche des validations par comp ©tence
    for($i=0;$i<count($tb);$i++){
      $valeurs=array();
      //pour chaque comp ©tence
      for ($j=0;$j<count($tbc);$j++){

        $req='select max(validation) as tt
              from '.$this->pref.'appreciation A, '.$this->pref.'competencecitee C, '
              .$this->pref.'activitecitee AC, '.$this->pref.'situation S
              where A.numCompetenceCitee=C.num
              and C.numActiviteCitee=AC.num
              and AC.refSituation=S.ref
              and S.valide="O"
              and S.numEtudiant='.$tb[$i]["num"].'
              and C.idCompetence='.$tbc[$j]["id"];

        $tbr=$this->mysql->execSQLRes($req);
        if($tbr[0]["tt"]==2){ //valid ©
          $valeurs[$j]="O"; // valid ©
        }else{
          if ($tbr[0]["tt"]==1){
            $valeurs[$j]="P";// en cours
          }else{
          $valeurs[$j]=" ";
          }
        }
        /*
        if($tbr[0]["tt"]==0){ //pas valid ©
          $valeurs[$j]=" "; // pas valid ©
        }else{
          $valeurs[$j]="O";//valid © au moins une fois
        }
        */
        $tb[$i]["valeurs"]=$valeurs;
      }
    }

    return array("el"=>$tb,"val"=>$tbc);
  }

  public function getBilanSitu($processus,$groupe){

    //r ©cup ¨re les  ©l ¨ves du groupe :num,nom,prenom
    $tb=$this->getElevesGroupe($groupe);

    //r ©cup ¨re toutes les situations de l'atelier :id,nomen,lib,ln
    $tbs=$this->getSitusAtelier($atelier);

    //pour chaque  ©l ¨ve, recherche de situations valid ©es
    for($i=0;$i<count($tb);$i++){
      $valeurs=array();
      //pour chaque situation
      for($j=0;$j<count($tbs);$j++){
        $req='select validation
              from '.$this->pref.'commentaire V, '.$this->pref.'situation S
              where V.refSituation=S.ref
              and validation="O"
              and S.valide="O"
              and S.numEtudiant='.$tb[$i]["num"].'
              and S.idActivite='.$tbs[$j]["id"];

        $tbr=$this->mysql->execSQLRes($req);

        if(count($tbr)==0){
          $valeurs[$j]="";
        }else{
          $valeurs[$j]="V";
        }
      }
      $tb[$i]["valeurs"]=$valeurs;
    }

    return array("el"=>$tb,"val"=>$tbs);
  }

  public function getCadre(){
    $req="select * from ".$this->pref."cadre";
    return $this->mysql->execSQLRes($req);
  }

  public function getActivites(){
    $req='select id, nomenclature as nomen, libelle as lib from '.$this->pref.'activite';
    return $this->mysql->execSQLRes($req);
  }

  public function setActivite($numsitu,$ac,$lc,$de,$me,$co,$an){
    $req= "insert into ".$this->pref."activitecitee (refSituation,idActivite,libcourt,
            descriptif,methode,contrainte,analyse) values(".$numsitu.",".$ac.
            ",'".$lc."','".$de."','".$me."','".$co."','".$an."')";
    $this->mysql->execSQL($req);
  }

  public function updateActivite($numsitu,$numactivcite,$ac,$lc,$de,$me,$co,$an){
    $req="update ".$this->pref."activitecitee set idActivite=".$ac.
            ", refSituation=".$numsitu.
            ", descriptif='".$de."', methode='".$me."', contrainte='".$co."', analyse='".$an.
            "', libcourt='".$lc."' where num=".$numactivcite;
    $this->mysql->execSQL($req);
  }

  public function getActivCite($numactivcite){
    $req="select A.libcourt as alibcourt, S.libcourt as slibcourt, A.descriptif,
      methode, contrainte, analyse, idActivite, refSituation
     from ".$this->pref."activitecitee A, ".$this->pref."situation S where
     refSituation=ref and num=".$numactivcite;
    return $this->mysql->execSQLRes($req);
  }

  public function getLesSitu($id){
    $req = "select ref, libcourt from ".$this->pref."situation where numEtudiant=".$id;
    return $this->mysql->execSQLRes($req);
  }

  public function getBilan($num){

    //r ©cup activit ©s
    $tb=$this->getActivites();

    //pour chaque activit ©
    for($i=0;$i<count($tb);$i++){

      //competences theoriques
      $req='select id as idC, nomenclature as nomenclatureC,
              libelle as libelleC
            from '.$this->pref.'competence
            where idActivite='.$tb[$i]["id"].' order by id' ;

      $tb1=$this->mysql->execSQLRes($req);

      //activit © cit ©e ?
      $req='select count(*) as nbcite
                from '.$this->pref.'activitecitee, '.$this->pref.'situation
                where ref=refSituation
                and numEtudiant='.$num.'
                and idActivite='.$tb[$i]["id"];
      $tb3=$this->mysql->execSQLRes($req);
      if ($tb3[0]["nbcite"]>0) $tb[$i]["cite"]="Oui&nbsp;(".$tb3[0]["nbcite"].")"; else $tb[$i]["cite"]="Non";
      $tb[$i]["competence"]=$tb1;
    }
    return $tb;
  }


  public function getTypeSitu(){
      $req='select id,nomenclature,libelle from '.$this->pref.'activite';
      return $this->mysql->execSQLRes($req);
  }


  public function getLocalisation(){
      $req='select code,libelle from '.$this->pref.'localisation';
      return $this->mysql->execSQLRes($req);
  }

  public function getSource(){
      $req='select code,libelle from '.$this->pref.'source';
      return $this->mysql->execSQLRes($req);
  }

  public function getType(){
      $req='select code,libelle from '.$this->pref.'type';
      return $this->mysql->execSQLRes($req);
  }

  public function getTypologie(){
      $req='select code,libelle from '.$this->pref.'typologie';
      return $this->mysql->execSQLRes($req);
  }

  public function getTypologies($ns){
  	$req='select codeTypologie from '.$this->pref.'esttypo where refSituation='.$ns;
  	return $this->mysql->execSQLRes($req);
  }

  public function getCompetences(){
	$req='select nomenclature, libelle, idActivite
	   from '.$this->pref.'competence';
	return $this->mysql->execSQLRes($req);
  }

  public function getCompetence($i){
      $req='select id, libelle, nomenclature
            from '.$this->pref.'competence C, '.$this->pref.'activitecitee A
            where C.idActivite=A.idActivite
            and num='.$i;

      return $this->mysql->execSQLRes($req);
  }

  public function getGroupes(){
      $req='select num,concat(nom,"-",annee," / ",nomenclature) as libelle
        from '.$this->pref.'groupe, '.$this->pref.'parcours where num>1 and id=idParcours order by 1';
      return $this->mysql->execSQLRes($req);
  }

  public function getGroupe($n){
    $req='select num, nom, annee, idParcours as parcours from '.$this->pref.'groupe where num='.$n;
    return $this->mysql->execSQLRes($req);
  }

  public function getProfesseurs(){
      $req='select num,concat(mid(prenom,1,1),". ",nom) as libelle
            from '.$this->pref.'professeur where num>1 and valide="O"';
      return $this->mysql->execSQLRes($req);
  }

  public function getSuppr($vers){
    if ($vers==1){//prof supprim ©s
      $req='select num,nom,prenom
            from '.$this->pref.'professeur where num>1 and valide="N"';
      $tb = $this->mysql->execSQLRes($req);
      for($i=0;$i<count($tb);$i++){
        $req='select count(*) as nb
              from '.$this->pref.'commentaire
              where numProfesseur='.$tb[$i]["num"];
        $res=$this->mysql->execSQLRes($req);
        $tb[$i]["nb"]=$res[0]["nb"];
        $req='select count(*) as nb
              from '.$this->pref.'appreciation
              where numProfesseur='.$tb[$i]["num"];
        $res=$this->mysql->execSQLRes($req);
        $tb[$i]["nb"]+=$res[0]["nb"];
      }
    } else {//etudiants supprim ©s
      $req='select num,nom,prenom
            from '.$this->pref.'etudiant
            where valide="N"';
      $tb = $this->mysql->execSQLRes($req);
      for($i=0;$i<count($tb);$i++){
        $req='select count(*) as nb
              from '.$this->pref.'situation
              where numEtudiant='.$tb[$i]["num"];
        $res=$this->mysql->execSQLRes($req);
        $tb[$i]["nb"]=$res[0]["nb"];
      }
    }
    return $tb;
  }

  public function restPersonne($vers,$num){
    if ($vers==1){// prof
      $req='update '.$this->pref.'professeur';
    } else {//$vers=2   ©tudiant
      $req='update '.$this->pref.'etudiant';
    }
    $req .= ' set valide="O" where num='.$num;
    $this->mysql->execSQL($req);
  }

  public function suppPersonne($vers,$num){
    if ($vers==1){// prof
      //supprime que le prof et son appartenance aux groupes
      //laisse ses commentaires avec numProfesseur    null
      $req='update '.$this->pref.'commentaire
            set numProfesseur=NULL where numProfesseur='.$num;
      $this->mysql->execSQL($req);
      $req='delete from '.$this->pref.'exerce
            where numProfesseur='.$num;
      $this->mysql->execSQL($req);
      $req='delete from '.$this->pref.'professeur
            where num='.$num;
      $this->mysql->execSQL($req);
    } else {//$vers=2 suppression de tout ce qui concerne l' ©tudiant
      $req='select ref from '.$this->pref.'situation
            where numEtudiant='.$num;
      $tb=$this->mysql->execSQLRes($req);
      foreach($tb as $situ){
		  $req='delete from '.$this->pref.'activitecitee
	              where refSituation='.$situ["ref"];
		  $this->mysql->execSQL($req);
		  $req='delete from '.$this->pref.'commentaire
	              where refSituation='.$situ["ref"];
	      $this->mysql->execSQL($req);
	      $req='delete from '.$this->pref.'esttypo
	              where refSituation='.$situ["ref"];
		  $this->mysql->execSQL($req);
		  $req='delete from '.$this->pref.'production
	              where refSituation='.$situ["ref"];
		  $this->mysql->execSQL($req);
      }
      $req='delete from '.$this->pref.'situation
            where numEtudiant='.$num;
      $this->mysql->execSQL($req);
      $req='delete from '.$this->pref.'etudiant
            where num='.$num;
      $this->mysql->execSQL($req);
    }
  }

  public function getNomsProfesseursDemande($groupe){
    $req='select num, nom, prenom from '.$this->pref.'professeur where autoriseMel="O" and
    num in (select numProfesseur from '.$this->pref.'exerce where numGroupe='.$groupe.')';
    return $this->mysql->execSQLRes($req);
  }

  public function getEtudiants(){
      $req='select num,concat(mid(prenom,1,1),". ",nom) as libelle
            from '.$this->pref.'etudiant where valide="O"';
      return $this->mysql->execSQLRes($req);
  }

  public function existeMelEtudiant($mel){
      $req='select num from '.$this->pref.'etudiant where valide="O" and mel="'.$mel.'"';

      return $this->mysql->execSQLRes($req);
  }

  public function setGroupe($n,$a,$p){
     if ($n=="admins") {
       return false;
     } else {
       $req='select count(*) as nb from '.$this->pref.'groupe where nom="'.$n.'" and annee='.$a;
       $res=$this->mysql->execSQLRes($req);
       if ($res[0]["nb"]>0) {
         return false;
       } else {
         $req='insert into '.$this->pref.'groupe(nom,annee,idParcours) values("'.$n.'","'.$a.'",'.$p.')';
         return $this->mysql->execSQL($req);
       }
     }
  }

  public function modifGroupe($num,$n,$a,$p){
    $req='update '.$this->pref.'groupe set nom="'.$n.'", annee="'.$a.'", idParcours='.$p.' where num='.$num.';';
     return $this->mysql->execSQL($req);
  }



  public function setProf($nom,$prenom,$mel,$niveau,$smtp,$crypte){
    if ($this->existeMel($mel,null)) { //ce m ©l est d ©j   enregistr ©
      return false;
    } else {
      if ($crypte && !$smtp)
      	$mdp=$this->mdpdefaut;
      else
        $mdp=$this->getmdp();
      if ($smtp)
      	mail($mel,"Votre mot de passe","Mot de passe pour le portefeuille SIO : ".$mdp);
      if ($crypte) $mdp=md5($mdp);
      $req='insert into '.$this->pref.'professeur(nom,prenom,mel,mdp,niveau) values
         ("'.$nom.'","'.$prenom.'","'.$mel.'","'.$mdp.'",'.$niveau.');';

      return $this->mysql->execSQL($req);
    }
  }

  public function majEleve($num,$nom,$pr,$mel,$mdp,$crypte,$smtp,$numexam) {
    $req='select numGroupe from '.$this->pref.'etudiant where num='.$num;
    $res=$this->mysql->execSQL($req);
    $gr=$res[0]["numGroupe"];
    if ($this->existeMel($mel,$num)) { //ce m ©l est d ©j   enregistr ©
      return false;
    } else {
       if ($mdp!=null){//veut changer mdp
      	if ($smtp)
      		mail($mel,"Votre mot de passe","Mot de passe pour le portefeuille SIO : ".$mdp);
      	if ($crypte) $mdp=md5($mdp);
      	$req='update '.$this->pref.'etudiant set nom="'.$nom.'", prenom="'.$pr.'", mdp="'.$mdp.'", mel="'.$mel.'", numexam="'.$numexam.'" where num='.$num;
       } else
        $req='update '.$this->pref.'etudiant set nom="'.$nom.'", prenom="'.$pr.'", mel="'.$mel.'", numexam="'.$numexam.'" where num='.$num;
      return $this->mysql->execSQL($req);
    }
  }


  public function majProf($num,$nom,$pr,$mel,$mdp,$crypte,$smtp) {
    //if ($this->existeMel($mel,null)) { //ce m l est d j  enregistr //ERREUR
    if ($this->existeMel($mel,$num)) { //ce m l est d j  enregistr 
      return false;
    } else {
      if ($mdp!=null){//veut changer mdp
      	if ($smtp)
      		mail($mel,"Votre mot de passe","Mot de passe pour le portefeuille SIO : ".$mdp);
      	if ($crypte) $mdp=md5($mdp);
      	$req='update '.$this->pref.'professeur set nom="'.$nom.'", prenom="'.$pr.'", mdp="'.$mdp.'", mel="'.$mel.'" where num='.$num;
      }else
      	$req='update '.$this->pref.'professeur set nom="'.$nom.'", prenom="'.$pr.'", mel="'.$mel.'" where num='.$num;
      return $this->mysql->execSQL($req);
    }
  }

  public function modifProf($num,$nom,$pr,$mel,$niveau,$mdp,$smtp,$crypte){
    if ($this->existeMel($mel,$num)) { //ce m ©l est d ©j   enregistr ©
      return false;
    } else {
      if ($mdp!=null){//veut changer mdp
      	if ($smtp)
      		mail($mel,"Votre mot de passe","Mot de passe pour le portefeuille SIO : ".$mdp);
      	if ($crypte) $mdp=md5($mdp);
      	$req='update '.$this->pref.'professeur set nom="'.$nom.'", prenom="'.$pr.'", mdp="'.$mdp.'", mel="'.$mel.'", niveau='.$niveau.' where num='.$num;
      } else {//pas changer mdp
      	$req='update '.$this->pref.'professeur set nom="'.$nom.'", prenom="'.$pr.'", mel="'.$mel.'", niveau='.$niveau.' where num='.$num;
      }
      return $this->mysql->execSQL($req);
    }
  }

  public function getProfesseur($n){
    $req='select num, nom, prenom, mel, niveau,mdp from '.$this->pref.'professeur where num='.$n.';';
    return $this->mysql->execSQLRes($req);
  }

  public function getProfesseurModif($n){
      $req='select num, nom, prenom, mel, mdp from '.$this->pref.'professeur where num='.$n.';';
    return $this->mysql->execSQLRes($req);
  }

  public function getEleveModif($n){
      $req='select num, nom, prenom, mel, mdp, numexam from '.$this->pref.'etudiant where num='.$n.';';
    return $this->mysql->execSQLRes($req);
  }

  public function suppProf($n){
    $req='update '.$this->pref.'professeur set valide="N" where num='.$n.';';
    return $this->mysql->execSQL($req);
  }

  public function suppEtud($n){
    $req='update '.$this->pref.'etudiant set valide="N" where num='.$n.';';
    return $this->mysql->execSQL($req);
  }

  public function getGroupesProf($n){
    $req='select num,numGroupe,concat(nom,"-",annee) as libelle
          from '.$this->pref.'groupe
          LEFT JOIN ( select * from '.$this->pref.'exerce where numProfesseur='.$n.') as tb
          ON '.$this->pref.'groupe.num=tb.numGroupe where '.$this->pref.'groupe.num>1;';
    return $this->mysql->execSQLRes($req);
  }

  public function getEtudiant($n){
    /*$req='select E.num, E.nom, E.prenom, E.mel, E.numGroupe, E.mdp, E.numexam, P.nomenclature
          from '.$this->pref.'etudiant E, '.$this->pref.'groupe G, '.$this->pref.'parcours P
          where E.numGroupe=G.num and G.idParcours=P.id and E.num='.$n.';';*/
	$req='select num, nom, prenom, mel, numGroupe, mdp, numexam
          from '.$this->pref.'etudiant E
          where  E.num='.$n.';';
    $res=$this->mysql->execSQLRes($req);
    if ($res[0]["numGroupe"]==null)
    	$res[0]["nomenclature"]="";
    else {
    	$req='select nomenclature from '.$this->pref.'parcours P, '.$this->pref.'groupe G
    	 where G.idParcours=P.id and G.num='.$res[0]["numGroupe"];
    	$tb=$this->mysql->execSQLRes($req);
    	$res[0]["nomenclature"]=$tb[0]["nomenclature"];
    }
    return $res;
  }

  public function getEtudiantSitu($numsitu){
    $req='select nom, prenom from '.$this->pref.'etudiant
         where num = (select numEtudiant from '.$this->pref.'situation where ref='.$numsitu.')';

         //echo $req;
    return $this->mysql->execSQLRes($req);
  }

  public function affecteGroupe($numprof,$numgroupes){
    $nb=count($numgroupes);
    for ($i=0;$i<$nb;$i++){
      $req='insert into '.$this->pref.'exerce values('.$numprof.','.$numgroupes[$i].');';
      $this->mysql->execSQL($req);
    }
  }

  public function modifAffecteGroupe($numprof,$numgroupes){
    $req='delete from '.$this->pref.'exerce where numProfesseur='.$numprof.';';
    $this->mysql->execSQL($req);
    $this->affecteGroupe($numprof,$numgroupes);
  }

  public function setEtudiant($nom,$prenom,$mel,$groupe,$smtp,$crypte){
    if ($this->existeMel($mel,null)) { //ce m ©l est d ©j   enregistr ©
      return false;
    } else {
      if ($crypte && !$smtp)
      	$mdp=$this->mdpdefaut;
      else
        $mdp=$this->getmdp();
      if ($smtp)
      	mail($mel,"Votre mot de passe","Mot de passe pour le portefeuille SIO : ".$mdp);
      if ($crypte) $mdp=md5($mdp);
      $req='insert into '.$this->pref.'etudiant (nom,prenom,mel,numGroupe,mdp) values
           ("'.$nom.'","'.$prenom.'","'.$mel.'",'.$groupe.',"'.$mdp.'");';
      return $this->mysql->execSQL($req);
    }
  }

  public function modifEtudiant($num,$nom,$pr,$mel,$groupe,$mdp,$smtp,$crypte){
    if ($this->existeMel($mel,$num)) {
      return false;
    } else {
      if ($mdp!=null){
      	if ($smtp)
      		mail($mel,"Votre mot de passe","Mot de passe pour le portefeuille SIO : ".$mdp);
      	if ($crypte) $mdp=md5($mdp);
      	$req='update '.$this->pref.'etudiant set nom="'.$nom.'", prenom="'.$pr.'",
          	mel="'.$mel.'", mdp="'.$mdp.'", numGroupe='.$groupe.' where num='.$num;
      } else {
      	$req='update '.$this->pref.'etudiant set nom="'.$nom.'", prenom="'.$pr.'",
          	mel="'.$mel.'", numGroupe='.$groupe.' where num='.$num;
      }
      $this->mysql->execSQL($req);
      return true;
    }
  }

  public function delGroupe($n){
    $req='delete from '.$this->pref.'exerce where numGroupe='.$n.';';
    $retp=$this->mysql->execSQL($req);
    $req='update '.$this->pref.'etudiant set numGroupe=NULL where numGroupe='.$n.';';
    $rete=$this->mysql->execSQL($req);
    $req='delete from '.$this->pref.'groupe where num='.$n.';';
    $retg=$this->mysql->execSQL($req);
    return $retp&&$rete&&$retg;
  }

  public function getAuthent($mel,$mdp){
	$req='select num, nom, prenom, niveau
          from '.$this->pref.'professeur P
          where mel="'.$mel.'" and mdp="'.$mdp.'"';
    $tb=$this->mysql->execSQLRes($req);


    if (count($tb)==1){
    	$req= "select num, nom, annee from ".$this->pref."groupe , ".$this->pref."exerce
    	       where num=numGroupe and numProfesseur=".$tb[0]["num"];
    	$tb[0]["groupes"]=$this->mysql->execSQLRes($req);
        return $tb;
    } else {
      $req='select num ,nom ,prenom
            from '.$this->pref.'etudiant
            where mel="'.$mel.'" and mdp="'.$mdp.'"';
      $tb=$this->mysql->execSQLRes($req);
      if (count($tb)==1){
        $tb[0]["niveau"]=3; //3=niveau  ©l ¨ve
        $req= "select G.num, G.nom, annee from ".$this->pref."groupe G, ".$this->pref."etudiant E
               where G.num=E.numgroupe and E.num=".$tb[0]["num"];
        $tb[0]["groupes"]=$this->mysql->execSQLRes($req);
        return $tb;
      } else return false;
    }
  }

  public function close(){
      $this->mysql->close();
  }
/*
  public function creeSituation($res,$num) {
    $req='insert into '.$this->pref.'situation (numEtudiant,codeNatureS,codeType,idActivite,
            descriptif,lieu,codeLocalisation,codeSource,dateDebut,
            dateFin,tache,objectif,acteur,moyen,
            resQuantitatif,resQualitatif,cloture,cleV)
             values('.$num.','.$res[1].','.$res[2].','.$res[3].
             ',"'.$res[4].'","'.$res[5].'",'.$res[6].','.$res[7].',"'.$res[8].'","'.
             $res[9].'","'.$res[10].'","'.$res[11].'","'.$res[12].'","'.$res[13].
             '","'.$res[14].'","'.$res[15].'","'.$res[16].'","'.$res[17].'")';
    $this->mysql->execSQL($req);
    return $this->mysql->insertId();
  }
*/

  public function setDescription($lc,$de,$pa,$lo,$so,$ca,$to, $dd,$df,$ty,$te,$ac,$av,$ideleve){
    $req='insert into '.$this->pref.'situation (numEtudiant, libcourt, descriptif,
          contexte, codeLocalisation, codeSource, codeCadre, datedebut, datefin, codeType, environnement,moyen,avisperso,datemodif)
          values ('.$ideleve.',"'.$lc.'","'.$de.'","'.$pa.'",'.$lo.','.$so.','.$ca.',"'.$dd.
          '","'.$df.'",'.$ty.',"'.$te.'","'.$ac.'","'.$av.'","'.$this->dtj().'")';
    $this->mysql->execSQL($req);
    $ref= $this->mysql->insertId();
    $this->setTypo($ref, $to);
    return $ref;
  }

  public function updateDescription($numsitu,$lc,$de,$pa,$lo,$so,$ca,$to,$dd,$df,$ty,$te,$ac,$av){
    $req='update '.$this->pref.'situation set descriptif="'.$de.
         '", libcourt="'.$lc.
         '", contexte="'.$pa.
         '", codeLocalisation='.$lo.
         ', codeSource='.$so.
         ', codeCadre='.$ca.
         ', dateDebut="'.$dd.
         '", dateFin="'.$df.
    	 '", environnement="'.$te.
    	 '", moyen="'.$ac.
    	 '", avisperso="'.$av.
         '", datemodif="'.$this->dtj().
         '", codeType='.$ty.' where ref='.$numsitu;
    $this->mysql->execSQL($req);
    $req='delete from '.$this->pref.'esttypo where refSituation='.$numsitu;
    $this->mysql->execSQL($req);
    $this->setTypo($numsitu, $to);
  }

  private function setTypo($numsitu, $to){
    foreach($to as $unto){
    	$req='insert into '.$this->pref.'esttypo values('.$numsitu.', '.$unto.')';
    	$this->mysql->execSQL($req);
    }
  }

  public function gereActivChoisie($numsitu,$activchoisies){
  	$tb2=explode(",",$activchoisies);

  	$req='select idActivite from '.$this->pref.'activitecitee
  	      where refSituation='.$numsitu;
  	$tb=$this->mysql->execSQLRes($req);
  	if (count($tb)==0){
  	  	for ($i=0 ; $i<count($tb2) ; $i++){
  			$req='insert into '.$this->pref.'activitecitee (idActivite, refSituation)
  		      values('.$tb2[$i].','.$numsitu.')';
  			//echo $req.'<br>';
  			$this->mysql->execSQL($req);
  		}
  	} else {//simule array_intersect et array_diff
  		for ($i=0 ; $i<count($tb2) ; $i++){
  			$maz = false;
  			$j=0;
  			while ($j<count($tb) && !$maz){
  				if ($tb2[$i] == $tb[$j]["idActivite"]){
  					$tb2[$i]=0;
  					$tb[$j]["idActivite"]=0;
  					$maz=true;
  				} else $j++;
  			}
  		}
  		for ($i=0 ; $i<count($tb) ; $i++){
  			if ($tb[$i]["idActivite"] !=0){
  				$req='delete from '.$this->pref.'activitecitee
  				where idActivite='.$tb[$i]["idActivite"]. ' and refSituation='.$numsitu;
  				//echo $req.'<br>';
  				$this->mysql->execSQL($req);
  			}
  		}
  		for ($i=0 ; $i<count($tb2) ; $i++){
  			if ($tb2[$i] !=0){
  				$req='insert into '.$this->pref.'activitecitee (idActivite, refSituation)
  		      		values('.$tb2[$i].','.$numsitu.')';
  				//echo $req.'<br>';
  				$this->mysql->execSQL($req);
  			}
  		}
  	}
	$this->majDateSitu($numsitu);
  }

  private function majDateSitu($numsitu){
  	$req='update '.$this->pref.'situation
  			set datemodif="'.$this->dtj().'"
  			where ref='.$numsitu;
  	$this->mysql->execSQL($req);
  }

  public function updateCaracterisation($numsitu,$ta,$ob,$ac,$mo,$rt,$rl){
    $req='update '.$this->pref.'situation set tache="'.$ta.
         '", objectif="'.$ob.
         '", moyen="'.$ac.
         '", moyen="'.$mo.
         '", dateModif="'.$this->dtj().
         '", resQuantitatif="'.$rt.
         '", resQualitatif="'.$rl.
         '" where ref='.$numsitu;

    return $this->mysql->execSQL($req);
  }


  public function getSitu1($i){
    $req='select libcourt, descriptif,
          contexte, codeLocalisation, codeSource, codeCadre,
          datedebut, datefin, codeType, environnement, moyen, avisperso
          from '.$this->pref.'situation
          where ref='.$i.';';
    $tb= $this->mysql->execSQLRes($req);
    $tb[0]["datedebut"]=$this->dtihm($tb[0]["datedebut"]);
    $tb[0]["datefin"]=$this->dtihm($tb[0]["datefin"]);
    $req= 'select count(*) as nb from '.$this->pref.'commentaire
           where refSituation='.$i;
    $tbc=$this->mysql->execSQLRes($req);
    $tb[0]["commentaire"]=$tbc[0]["nb"]>0;
    $req= 'select codeTypologie from '.$this->pref.'esttypo
          where refSituation='.$i.' order by 1';
    $tbt=$this->mysql->execSQLRes($req);

    $tb[0]["codeTypologie"]=$tbt;
    return $tb;
  }

  public function getSitu2($i){
    $req='select id, nomenclature as nomen, libelle as lib
        from '.$this->pref.'activite, '.$this->pref.'activitecitee
        where id=idActivite and refSituation='.$i;
    //echo $req.'<br>';
    return $this->mysql->execSQLRes($req);
  }

  public function getSitu3($i){
    $req='select libcourt
          from '.$this->pref.'situation
          where ref='.$i;
    return $this->mysql->execSQLRes($req);
  }

  public function getSitu4($i){
    $req='select id, nomenclature, libelle, commentaire
    		from '.$this->pref.'activite, '.$this->pref.'activitecitee
    		where id=idActivite
          	and refSituation='.$i;
    $tb=$this->mysql->execSQLRes($req);
    for ($i=0 ; $i<count($tb) ; $i++){
    	$req='select id,nomenclature,libelle from '.$this->pref.'competence
    	      where idActivite='.$tb[$i]["id"];
    	$tb[$i]["lescomp"]=$this->mysql->execSQLRes($req);
    }
    return $tb;
  }

  public function enregReformul($numsitu,$com,$id){
  	$req='update '.$this->pref.'activitecitee
  			  set commentaire="'.$com.'"
  		      where refSituation='.$numsitu.'
  		      and idActivite='.$id;
  	$this->mysql->execSQL($req);
  	$this->majDateSitu($numsitu);
  }

  public function getSitu5($i){
    $req='select S.descriptif as descriptif, TS.nomenclature as tsnomen,
          TS.libelle as tslib, C.nomenclature as cnomen, C.libelle as clib,
          CO.nomenclature as conomen, CO.libelle as colib,
          CC.descriptif as ccdescriptif
          from '.$this->pref.'situation S, '.$this->pref.'activite TS, '.$this->pref.'domaine C, '.$this->pref.'competencecitee CC, '.$this->pref.'competence CO
          where S.idActivite=TS.id
          and TS.idDomaine=C.id
          and CC.refSituation=S.ref
          and CC.idCompetence=CO.id
          and CC.num='.$i;
    return $this->mysql->execSQLRes($req);
  }

  public function getAuteurSitu($numsitu){
    $req='select nom, prenom
          from '.$this->pref.'etudiant, '.$this->pref.'situation
          where num=numEtudiant and ref='.$numsitu;
    $tb=$this->mysql->execSQLRes($req);
    if (count($tb)==1)
      return $tb[0]["prenom"]." ".$tb[0]["nom"];
    else return '';
  }

  public function getAuteurActivCite($numactivcite){
    $req='select nom, prenom
          from '.$this->pref.'etudiant E, '.$this->pref.'situation S, '.$this->pref.'activitecitee A
          where E.num=numEtudiant and ref=refSituation and A.num='.$numactivcite;
    $tb=$this->mysql->execSQLRes($req);
    if (count($tb)==1)
      return $tb[0]["prenom"]." ".$tb[0]["nom"];
    else return '';
  }



  public function getCompXML($i){
    $req='select num, idCompetence, cleA, descriptif
          from '.$this->pref.'competencecitee
          where refSituation='.$i;
    return $this->mysql->execSQLRes($req);
  }


  public function getSitusClEl($i){
    $req='select TS.id , ref, idCompetence, num, TS.nomenclature as tsnomen,
          C.nomenclature as cnomen, TS.libelle, S.descriptif, cloture
          from '.$this->pref.'competencecitee CC, '.$this->pref.'situation S, '
               .$this->pref.'activite TS, '.$this->pref.'competence C
          where CC.refSituation = S.ref
          and S.idActivite = TS.id
          and CC.idCompetence = C.id
          and S.numEtudiant='.$i.'
          and S.valide="O"
          order by TS.id, ref,idCompetence';
    //echo $req;
    $tb = $this->mysql->execSQLRes($req);

    for ($j=0;$j<count($tb);$j++){
      $tb[$j]["uneValidee"]="N";
    }

    for ($j=0;$j<count($tb);$j++){

      //compte nb validations
      $req='select count(*) as nb
            from '.$this->pref.'situation
            left join '.$this->pref.'commentaire
            on refSituation=ref
            where validation="O"
            and ref='.$tb[$j]["ref"];
      $tb1 = $this->mysql->execSQLRes($req);

      if ($tb1[0]["nb"]>0) {

        //d ©validation forc ©e pour  ©liminer la situation fausse    probl ¨me :
        //  celle o   valid=O et cloture=N
        if ($tb[$j]["cloture"]=="N") {
          //$req='update '.$this->pref.'commentaire set validation="N"
            //  where refSituation='.$tb[$j]["ref"];
          //$this->mysql->execSQL($req);

          $tb[$j]["validation"]="N";

        } else {
          $tb[$j]["validation"]="O";
          $tb[$j]["uneValidee"]="O";

          $idCompValide=$tb[$j]["idCompetence"];
          $refValide=$tb[$j]["ref"];

          //gestion des 'uneValidee'
          for ($k=0;$k<count($tb);$k++) {
            if (($tb[$k]["idCompetence"]==$idCompValide) && ($tb[$k]["ref"]!=$refValide)) {
              $refConcerne=$tb[$k]["ref"];
              for ($l=0;$l<count($tb);$l++) {
                if ($tb[$l]["ref"]==$refConcerne) {
               // echo ' $j='.$j.' $idCompValide='.$idCompValide.' $refValide='.$refValide.' $k='.$k.' $l='.$l.'<br>';
                  $tb[$l]["uneValidee"]="O";
                }
              }
            }
          }
          // fin gestion des 'uneValidee'

        }
      } else {
         $tb[$j]["validation"]="N";
        // echo '<br>';
      }



    }
      //retourne les ref des situations comportant de comp ©tences cit ©es >1 fois
    $req='select distinct refSituation
            from '.$this->pref.'competencecitee, '.$this->pref.'situation
            where numEtudiant='.$i.'
            and ref=refSituation
            and idCompetence in
                (select idCompetence
                from '.$this->pref.'competencecitee
                where refSituation in (select ref
                                       from '.$this->pref.'situation
                                       where numEtudiant='.$i.')
                group by idCompetence
                having count(*)>1)
            order by refSituation';
    $tb2=$this->mysql->execSQLRes($req);
    $refDouble=array();
    for ($j=0;$j<count($tb2);$j++)
      $refDouble[]=$tb2[$j]["refSituation"];

    for ($j=0;$j<count($tb);$j++)
      if (in_array($tb[$j]["ref"],$refDouble)) $tb[$j]["trait"]="O"; else $tb[$j]["trait"]="N";

    return $tb;
  }

  public function getSitusEl($i){
    $req='select ref, descriptif as liblong,libcourt as libT,valide
          from '.$this->pref.'situation
          where numEtudiant='.$i.' order by 1';
    $tb=$this->mysql->execSQLRes($req);
    for ($i=0;$i<count($tb);$i++){
    	$req='select count(*) as nb from '.$this->pref.'commentaire
    	      where refSituation='.$tb[$i]["ref"];
    	$tbc=$this->mysql->execSQLRes($req);
    	$tb[$i]["commentaire"]=$tbc[0]["nb"];
    	$req='select count(*) as nb from '.$this->pref.'activitecitee
    			where refSituation='.$tb[$i]["ref"];
    	$tbc=$this->mysql->execSQLRes($req);
    	$tb[$i]["activ"]=$tbc[0]["nb"];
    	$req='select count(*) as nb from '.$this->pref.'production
    			where refSituation='.$tb[$i]["ref"];
    	$tbc=$this->mysql->execSQLRes($req);
    	$tb[$i]["prod"]=$tbc[0]["nb"];
    }
    return $tb;
  }

  public function getActivsEl($i){
    $req='select ref, S.descriptif as liblong,S.libcourt as libT,A.valide as validea,validation,
          num, A.libcourt as libA
          from '.$this->pref.'situation S left join '.$this->pref.'activitecitee A
          on A.refSituation=ref left join '.$this->pref.'commentaire C
          on C.refSituation=ref
          where numEtudiant='.$i.' order by 1,6';
    return $this->mysql->execSQLRes($req);
  }

  public function supprSituEtudiant($num){
    $req='update '.$this->pref.'situation set valide="N" where numEtudiant='.$num.
         ' and ref not in(select refSituation from '.$this->pref.'commentaire where validation="O")';
    return $this->mysql->execSQL($req);
  }

  public function supprSituEtudiantTout($num){
    $req='select ref from '.$this->pref.'situation where numEtudiant='.$num;
    $tb=$this->mysql->execSQLRes($req);
    foreach($tb as $situ) $this->destrucSitu($situ["ref"]);
  }

  public function supprSitu($numsitu){
    $req='update '.$this->pref.'situation set valide="N" where ref='.$numsitu;
    $this->mysql->execSQL($req);
  }

  public function recupSitu($numsitu){
    $req='update '.$this->pref.'situation set valide="O" where ref='.$numsitu;
    $this->mysql->execSQL($req);
  }

  public function destrucSitu($numsitu){

    $req='delete from '.$this->pref.'commentaire where refSituation='.$numsitu;
    $this->mysql->execSQL($req);

    $req='delete from '.$this->pref.'esttypo where refSituation='.$numsitu;
    $this->mysql->execSQL($req);

    $req='delete from '.$this->pref.'production where refSituation='.$numsitu;
    $this->mysql->execSQL($req);

    $req='delete from '.$this->pref.'activitecitee where refSituation='.$numsitu;
    $this->mysql->execSQL($req);
    $req='delete from '.$this->pref.'situation where ref='.$numsitu;
    $this->mysql->execSQL($req);
  }

  public function creeSituation($res,$num) {
    $req='insert into '.$this->pref.'situation (numEtudiant, codeType, codeLocalisation,
    codeSource, codeCadre, libcourt, descriptif, contexte, datedebut, datefin, environnement,
    moyen, avisperso, datemodif) values('.$num.','.$res[1].','.$res[2].','.$res[3].
             ','.$res[4].',"'.$res[5].'","'.$res[6].'","'.$res[7].'","'.$res[8].'","'.
             $res[9].'","'.$res[10].'","'.$res[11].'","'.$res[12].'","'.$this->dtj().'")';

    $this->mysql->execSQL($req);
    return $this->mysql->insertId();
  }

  public function creeCommentaire($res,$ref){
  	$req='select num from '.$this->pref.'professeur where mel="'.$res[4].'"';

  	$tb=$this->mysql->execSQLRes($req);
  	if (count($tb)==0)
  		$req='insert into '.$this->pref.'commentaire (refSituation, commentaire, datecommentaire)
  		 values ('.$ref.',"'.$res[0].'","'.$res[1].'")';
  	else
  		$req='insert into '.$this->pref.'commentaire (refSituation, commentaire, datecommentaire,
  	 		numProfesseur) values ('.$ref.',"'.$res[0].'","'.$res[1].'",'.$num=$tb[0]["num"].')';

  	$this->mysql->execSQL($req);
  }

  public function creeActivitecitee($res,$ref){
  	$req='insert into '.$this->pref.'activitecitee (idActivite, refSituation, commentaire)
  	values ('.$res[0].','.$ref.',"'.$res[1].'")';
  	$this->mysql->execSQL($req);
  }

  public function supprActiv($num){
    $req='update '.$this->pref.'activitecitee set valide="N" where num='.$num;
    $this->mysql->execSQL($req);
  }

  public function recupActiv($num){
    $req='update '.$this->pref.'activitecitee set valide="O" where num='.$num;
    $this->mysql->execSQL($req);
  }

  public function destrucActiv($num){
    $req='delete from '.$this->pref.'production where numActiviteCitee='.$num;
    $this->mysql->execSQL($req);
    $req='delete from '.$this->pref.'competencecitee where numActiviteCitee='.$num;
    $this->mysql->execSQL($req);
    $req='delete from '.$this->pref.'activitecitee where num='.$num;
    $this->mysql->execSQL($req);
  }

  public function getProd($num){
    $req='select numero, designation, adresse
          from '.$this->pref.'production
          where refSituation='.$num;
    return $this->mysql->execSQLRes($req);
  }

  public function getComp4($i){
    $req='select num, idCompetence, descriptif, travail, commentaireCompetence, libelle
          from '.$this->pref.'competencecitee left join '.$this->pref.'appreciation
          on num=numCompetenceCitee left join '.$this->pref.'Niveau N
          on validation= N.code
          where numActiviteCitee='.$i;
    $tb= $this->mysql->execSQLRes($req);

    return $tb;
  }

  public function ajouteCompetenceCitee($numactivcite,$co,$de,$tr){
    $req="insert into ".$this->pref."competencecitee (idCompetence, numActiviteCitee, descriptif, travail) values (".
          $co.",".$numactivcite.",'".$de."','".$tr."')";
    $this->mysql->execSQL($req);
  }

  public function updateCompetenceCitee($num,$co,$de,$tr){
    $req="update ".$this->pref."competencecitee set idCompetence=".$co.", descriptif='".$de."'
          , travail='".$tr."' where num=".$num;
    $this->mysql->execSQL($req);
  }

  public function supprCompetenceCitee($i){
    $req = 'delete from '.$this->pref.'competencecitee where num='.$i;
    $this->mysql->execSQL($req);
    $req = 'delete from '.$this->pref.'appreciation where num='.$i;
    $this->mysql->execSQL($req);
  }

  public function getComp5($s){
    $req='select id, libelle, nomenclature
            from '.$this->pref.'competence C, '.$this->pref.'situation S
            where C.idActivite=S.idActivite
            and S.ref='.$s;
    $res=$this->mysql->execSQLRes($req);
    for($i=0; $i<count($res) ;$i++) {
      $req='select num, descriptif
              from '.$this->pref.'competencecitee
              where refSituation='.$s.' and
              idCompetence='.$res[$i]["id"];
      $res1=$this->mysql->execSQLRes($req);
      if (is_null($res1[0]["num"])) {
        $res[$i]["num"]=null;
        $res[$i]["descriptif"]=null;
      }else{
        $res[$i]["num"]=$res1[0]["num"];
        $res[$i]["descriptif"]=$res1[0]["descriptif"];
      }
    }
    return $res;
  }



  public function getId(){
    return $this->mysql->insertId();
  }

  public function updateProduction($numsitu,$codeP,$de,$ad){
    $req="update ".$this->pref."production set designation='".$de."', adresse='".$ad.
        "' where numero=".$codeP;
    $this->mysql->execSQL($req);
    $this->majDateSitu($numsitu);
  }

  public function creeTypologie($res,$ref){
    $req='insert into '.$this->pref.'esttypo (refSituation, codeTypologie)
          values ('.$ref.','.$res[0].')';

    $this->mysql->execSQL($req);
  }

  public function  creeProduction($res,$ref){
    $req='insert into '.$this->pref.'production (refSituation, designation, adresse)
          values ('.$ref.',"'.$res[0].'","'.$res[1].'")';

    $this->mysql->execSQL($req);
  }

  public function ajouteProduction($numsitu,$de,$ad){
    $req='insert into '.$this->pref.'production (refSituation,designation,adresse)
          values ('.$numsitu.',"'.$de.'","'.$ad.'")';
    $this->mysql->execSQL($req);
    $this->majDateSitu($numsitu);
  }
/*
  public function updateCompetenceCitee($codeC,$co,$de){
    $req='update '.$this->pref.'competencecitee set idCompetence='.$co.
          ', descriptif="'.$de.'" where num='.$codeC;
    return $this->mysql->execSQL($req);
  }
*/
  public function creeCompetence($res,$ref){
    $req='insert into '.$this->pref.'competencecitee (cleA,refSituation, idCompetence, descriptif)
          values ("'.$res[2].'",'.$ref.','.$res[1].',"'.$res[3].'")';
    return $this->mysql->execSQL($req);
  }
/*
  public function ajouteCompetenceCitee($numsitu,$co,$de){
    $req='insert into '.$this->pref.'competencecitee (cleA,refSituation, idCompetence, descriptif)
          values ("'.md5(uniqid()).'",'.$numsitu.','.$co.',"'.$de.'")';
    return $this->mysql->execSQL($req);
  }
*/

  public function majCompetenceCitee($n,$c,$d) {
   //numSitu, idCompetenceCitee, descriptif
   /*
    $req='select * from '.$this->pref.'competencecitee
       where idCompetence='.$c.'
       and refSituation='.$n;
    $res=$this->mysql->execSQLRes($req);
    if (is_null($res[0]["num"])) {
      //n'existe pas
      if ($d!=""){
        $req='insert into '.$this->pref.'competencecitee (cleA,refSituation, idCompetence, descriptif)
          values ("'.md5(uniqid()).'",'.$n.','.$c.',"'.$d.'")';
        $this->mysql->execSQL($req);
      }
    } else {
      //existe d ©j  
      if ($d==""){
        //supprime
        $req='delete from '.$this->pref.'competencecitee where refSituation='.$n.'
        and idCompetence='.$c;
        $this->mysql->execSQL($req);
      } else {
        //maj
        $req='update '.$this->pref.'competencecitee set
           descriptif="'.$d.'" where refSituation='.$n.'
           and idCompetence='.$c;
        $this->mysql->execSQL($req);
      }
    }
    */
    $req='delete from '.$this->pref.'competencecitee
       where refSituation='.$n;
    $this->mysql->execSQL($req);
    if ($d!=""){
      //$req='insert into '.$this->pref.'competencecitee (cleA,refSituation, idCompetence, descriptif)
      //    values ("'.md5(uniqid()).'",'.$n.','.$c.',"'.$d.'")';
      $req='insert into '.$this->pref.'competencecitee (refSituation, idCompetence, descriptif)
            values ('.$n.','.$c.',"'.$d.'")';
      //echo $req;
      $this->mysql->execSQL($req);
    }
    //decloture situ
    $this->gestcloture(0,$n);

  }
  public function setCommentaire($numsitu,$comm, $idProf){
    $req="insert into ".$this->pref."commentaire (refSituation, numProfesseur,
            commentaire, dateCommentaire) values
            (".$numsitu.",".$idProf.",'".$comm."','".$this->dtj()."')";
    $this->mysql->execSQL($req);
  }

  public function supprCommentaire($chksup){
  	foreach ($chksup as $unchksup){
  		$req='delete from '.$this->pref.'commentaire where numero='.$unchksup;
  		$this->mysql->execSQL($req);
  	}
  }

  public function majCommentaire($ref,$comm){
    for ($i=0; $i<count($ref) ; $i++){
  		$req='update '.$this->pref.'commentaire
  			  set commentaire="'.$comm[$i].'"
  			  where numero='.$ref[$i];
  		$this->mysql->execSQL($req);
  	}
  }
  public function getSitus($id,$gr,$t){
    //le prof voit tous les  ©tudiants de son groupe

    //$t=1 : situations r ©centes (dateModif > dateCommentaireLe+R cent) non comment es
    //$t=2 : situations r ©centes (dateModif > dateCommentaireLe+R cent)
    //$t=3 : non comment es
    //$t=4 : toutes

    $req='select max(dateCommentaire) as datemax from '.$this->pref.'commentaire
          where numProfesseur='.$id;
    $tb=$this->mysql->execSQLRes($req);
    $datemax=$tb[0]["datemax"];
	$req='select E.num, E.nom, E.prenom, S.ref, libcourt, descriptif
		            from '.$this->pref.'etudiant E join '.$this->pref.'situation S
		            on  S.numEtudiant=E.num
            		where  E.valide="O"
            		and S.valide="O"
            		and E.numGroupe='.$gr;

    	switch ($t) {
    		case 1 :
    			$req.=' and datemodif>="'.$datemax.'"
		         	    and S.ref not in
		         		  (select distinct refSituation from '.$this->pref.'commentaire)';
    			break;
    		case 2 :
		        $req.=' and datemodif>="'.$datemax.'"';
		        break;
    		case 3 :
    			$req.=' and S.ref not in
		         		  (select distinct refSituation from '.$this->pref.'commentaire)';
    			break;
    	}
    	$req.=' order by 2,3,1,4';
        $tb=$this->mysql->execSQLRes($req);
        for ($i=0;$i<count($tb);$i++){
        	$req='select count(*) as nb from '.$this->pref.'commentaire
        	      where refSituation='.$tb[$i]["ref"];
        	$tb1=$this->mysql->execSQLRes($req);
        	$tb[$i]["comm"]=$tb1[0]["nb"];
        	$req='select count(*) as nb from '.$this->pref.'activitecitee
        	      where refSituation='.$tb[$i]["ref"];
        	$tb1=$this->mysql->execSQLRes($req);
        	$tb[$i]["activ"]=$tb1[0]["nb"];
        }
        return $tb;
  }

  public function getNomenCompCitee($ref){
    $req='select nomenclature, num
          from '.$this->pref.'competence C, '.$this->pref.'competencecitee CC
          where C.id=CC.idCompetence
          and CC.refSituation='.$ref;

    return $this->mysql->execSQLRes($req);
  }


/*
  public function getVersion() {
    $req='select max(version) as derversion from '.$this->pref.'Version';
    $tb = $this->mysql->execSQLRes($req);
    return $tb[0]["derversion"];
  }
*/
  public function creeValidation($res,$np){
    $req='select ref from '.$this->pref.'situation where valide="O" and cleV="'.$res[0].'"';

    //echo $req.'<br>';

    $tb=$this->mysql->execSQLRes($req);
    if (count($tb)==1){
      $req='insert into '.$this->pref.'commentaire (refSituation,numProfesseur,validation,datevalidation)
            values ('.$tb[0]["ref"].','.$np.',"'.$res[1].'","'.$this->dtj().'")';

            //echo $req.'<br>';

      $this->mysql->execSQL($req);
    }
  }
/*
  public function gestcloture($t,$ref){
  //$t=0 : decloture $ref ; $t=1 : cloture $ref
    if ($t==0) $val="N"; else $val="O";
    $req='update '.$this->pref.'situation set cloture="'.$val.'" where ref='.$ref;
    $this->mysql->execSQL($req);
  }
*/
  public function validSitu($refs,$prof,$refli){

    //foreach ($refli as $ref) echo 'pr ©sente : '.$ref.'<br>';
    //foreach ($refs as $ref) echo '   valider : '.$ref.'<br>';


      //$refs = tableau des situ    valider
      //$refli = tableau de toutes les situs
      // celles qui sont dans $refli et pas dans $refs = validation="N"
      //celles qui sont dans $refs : validation="O"
      foreach($refli as $li){
        if (!isset($refs)) $refs=array();
        if (in_array($li, $refs, true)){//   valider
          if (count($this->getValid($li))==0){
            $req='insert into '.$this->pref.'commentaire (refSituation,numProfesseur,validation,dateCommentaire)
                values ('.$li.','.$prof.',"O","'.$this->dtj().'")';
                //echo 'A '.$req.'<br>';
                $this->mysql->execSQL($req);
          }else{
            $req='update '.$this->pref.'commentaire set numProfesseur='.$prof.
               ', validation="O",dateCommentaire="'.$this->dtj().
               '" where refSituation='.$li;
               //echo 'B '.$req.'<br>';
               $this->mysql->execSQL($req);
          }
        }else{//   d ©valider

          $req='select count(*) as validV
              from '.$this->pref.'commentaire
              where refSituation='.$li;

          $tbvali=$this->mysql->execSQLRes($req);
          if ($tbvali[0]["validV"]!=0){
            $req='update '.$this->pref.'commentaire set numProfesseur='.$prof.
               ', validation="N",dateCommentaire="'.$this->dtj().
               '" where refSituation='.$li;

            $this->mysql->execSQL($req);

          }
        }
        //echo $req.'<br>';
        $this->mysql->execSQL($req);
      }


  }

  public function getCommentaireSauve($numsitu){
    //join externe si le prof est parti (mais commentaire reste)
  	$req='select numero, commentaire, datecommentaire, coalesce(num,0) as numprof,
  			 coalesce(nom,"--") as nomprof, coalesce(prenom,"--") as prenomprof, coalesce(mel,"--") as melprof
    		 from '.$this->pref.'commentaire left outer join '.$this->pref.'professeur
    		 on numProfesseur=num
             where refSituation='.$numsitu.'
             order by 3 desc';
    return $this->mysql->execSQLRes($req);
  }

  public function getCommentaire($numsitu){
    $tb= $this->getCommentaireSauve($numsitu);
    for($i=0 ; $i<count($tb) ; $i++)
    	$tb[$i]["datecommentaire"]=$this->dtihm($tb[$i]["datecommentaire"]);
    return $tb;
  }

  public function creeAppreciation($res,$np){

    $req='select num from '.$this->pref.'competencecitee C, '.$this->pref.'situation S
          where C.refSituation=S.ref
          and S.valide="O"
          and cleA="'.$res[0].'"';

    $tb=$this->mysql->execSQLRes($req);
    if (count($tb)==1){
      $req='insert into '.$this->pref.'appreciation (numCompetenceCitee,numProfesseur, conceptualisation,
            variabilite, complexite, criticite, commentaireCompetence, commentaireSituation,
            dateAppreciation) values ('.$tb[0]["num"].','.$np.','.$res[1].','.$res[2].
            ','.$res[4].','.$res[5].
            ',"'.$res[3].'","'.$res[6].'","'.$this->dtj().'")';

      $this->mysql->execSQL($req);
    }
  }

  public function apprecCompet($i,$prof,$cc,$vc){
  //cc=comm compet  vc=valid compet
    if (count($this->getAppreciation($i))==0){
      $req='insert into '.$this->pref.'appreciation (numCompetenceCitee,numProfesseur,
            commentaireCompetence, validation, dateAppreciation) values
             ('.$i.','.$prof.',"'.$cc.'",'.$vc.',"'.$this->dtj().'")';
    }else{
      $req='update '.$this->pref.'appreciation set numProfesseur='.$prof.',commentaireCompetence="'.
           $cc.'", validation='.$vc.',dateAppreciation="'.$this->dtj().
           '" where numCompetenceCitee='.$i.'';
    }

    return $this->mysql->execSQL($req);
  }

  public function supprCompet($c){
    $req='delete from '.$this->pref.'appreciation where numCompetenceCitee='.$c;
    return $this->mysql->execSQL($req);
  }

  public function supprProduction($numsitu,$i){
    $req='delete from '.$this->pref.'production where numero='.$i;
    $this->mysql->execSQL($req);
    $this->majDateSitu($numsitu);
  }

  public function getTableauSyntheseNew($numeleve){//version qui met les activit s communes dans le tableau
  	//en dur pour rattraper le coup : les n  activit s communes   ajouter dans le tableau
  	//$actsisr="(35,36,40,41,42)";
  	//$actslam="(26,27)";
  	$actsisr="(35,36,40,41)";//version avs 02/2014
  	$actslam="(23,24,26,30)";//version avs 02/2014
    $req="select code, left(libelle,lngutile) as libelle from ".$this->pref."typologie order by 1";
    //$req="select code, libelle from ".$this->pref."typologie order by 1";
    $restypo=$this->mysql->execSQLRes($req);
    $tb["typologie"]=$restypo;

  	$req='select idParcours from '.$this->pref.'groupe G, '.$this->pref.'etudiant E
         where G.num=E.numGroupe and E.num='.$numeleve;
    $res=$this->mysql->execSQLRes($req);
    if (isset($res[0]["idParcours"])) $parc= $res[0]["idParcours"]; else $parc=0;

    //r cup re TOUS les processus
  	$req="select id, nomenclature, libelle from ".$this->pref."processus order by 1";
    $tbet=$this->mysql->execSQLRes($req);
    //efface libelle processus pour comp tences communes ajout es (colonne trop  troite)
    if ($parc==1) $tbet[3]["libelle"]="";
    if ($parc==2) $tbet[2]["libelle"]="";
    $nbp=count($tbet);// tjs 5 processus
    $nba=0;  // compte nb total activit s pour ces 5 processus = nb colonnes ds tableau synth se
    $ida=array();  //tableau d'id d'activit s   constuire
    for($i=0 ; $i<$nbp ; $i++){ //pour chaque processus r cup re les activit s
      if ($parc==1 && $i==3){//sisr et processus 4
      	$req="select A.id as id, A.nomenclature as nomenclature, left(A.libelle,lngutile) as libelle, 1 as idEpreuve
         from ".$this->pref."activite A
         where A.id in ".$actsisr." order by 1";
      }else{ if ($parc==2 && $i==2){//SLAM et processus 3
		      	$req="select A.id as id, A.nomenclature as nomenclature, left(A.libelle,lngutile) as libelle, 1 as idEpreuve
		         from ".$this->pref."activite A
		         where A.id in ".$actslam." order by 1";
      		}else{
			     $req="select A.id as id, A.nomenclature as nomenclature, left(A.libelle,lngutile) as libelle, idEpreuve
			         from ".$this->pref."activite A, ".$this->pref."domaine D, ".$this->pref."evalue E
			         where A.id=E.idActivite and E.idParcours=".$parc." and
			         A.idDomaine=D.id and D.idProcessus=".$tbet[$i]["id"]." order by 1";
			}
      }
      //echo "parc=".$parc."  i=".$i."  ".$req.'<br>';
      $tba=$this->mysql->execSQLRes($req);
	  $nbtba=count($tba); // nombre d'activit s par processus
	  for ($j=0; $j<$nbtba ; $j++) //pour chaque activit  du processus
		$ida[]=$tba[$j]["id"];//croissant

      $nba+=$nbtba;
      $tbet[$i]["act"]=$tba;
    }
    $tbet["nba"]=$nba;
    $tbet["nbp"]=$nbp;

    $req="select code, libelle from ".$this->pref."typesource order by 1";
    $res=$this->mysql->execSQLRes($req);
    //r cup re les situation ets /stage1 /stage2
    for ($src=0 ; $src<count($res) ; $src++){
	    $req="select ref, libcourt, datedebut, datefin from ".$this->pref."situation, ".$this->pref."source
	          where codeSource=code and numEtudiant=".$numeleve." and valide='O'
	          and  codeTypesource=".$res[$src]["code"]." order by 1";
    	$tbsit=$this->mysql->execSQLRes($req);

	    for ($i=0;$i<count($tbsit); $i++){
	      $req="select distinct idActivite from ".$this->pref."activitecitee
	            where refSituation=".$tbsit[$i]["ref"]." order by 1";//m' nerve, j'y arrive pas avec des left join...
	      $tbida=$this->mysql->execSQLRes($req);
	      $nbtbida=count($tbida);

	      $idac=array();
	      //remplit le tableau avec de X
	      for ($j=0 ; $j<count($ida); $j++) {
			$k=0; //pointe sur $tbida
			$v=$ida[$j];
			while ($k<$nbtbida && $tbida[$k]["idActivite"]!=$v) $k++;
			if ($k<$nbtbida) $idac[$j]="X"; else $idac[$j]=" ";
	      }
	      $tbsit[$i]["act"]=$idac;
	      $req="select codeTypologie from ".$this->pref."esttypo
	          where refSituation=".$tbsit[$i]["ref"]." order by 1";
	      $tbtypo=$this->mysql->execSQLRes($req);
	      $arraytypo=array();
	      $nbtbtypo= count($tbtypo);
	      for ($l=0 ; $l<count($restypo) ; $l++) {
	      	$k=0;
			$v=$restypo[$l]["code"];//normalement 1..4,  mais...
			while ($k<$nbtbtypo && $tbtypo[$k]["codeTypologie"]!=$v) $k++;
			if ($k<$nbtbtypo) $arraytypo[$l]="X"; else $arraytypo[$l]=" ";
	      }
	      $tbsit[$i]["typo"]=$arraytypo;
	    }

	    $tb["sit"][$src]=$tbsit;
	    $tb["libsit"][$src]=$res[$src]["libelle"];
    }
    $tb["et"]=$tbet;
    $tb["ident"]=$this->getEtudiant($numeleve);
	//exit;
    return $tb;
  }

  public function getTableauSyntheseNewV0($numeleve){
    $req="select code, left(libelle,lngutile) as libelle from ".$this->pref."typologie order by 1";
    //$req="select code, libelle from ".$this->pref."typologie order by 1";
    $restypo=$this->mysql->execSQLRes($req);
    $tb["typologie"]=$restypo;

  	$req='select idParcours from '.$this->pref.'groupe G, '.$this->pref.'etudiant E
         where G.num=E.numGroupe and E.num='.$numeleve;
    $res=$this->mysql->execSQLRes($req);
    if (isset($res[0]["idParcours"])) $parc= $res[0]["idParcours"]; else $parc=0;
    if ($parc==0)//parcours encore indiff renci 
  		$req="select id, nomenclature, libelle from ".$this->pref."processus order by 1";
  	else //SISR ou SLAM
  		$req="select id, nomenclature, libelle from ".$this->pref."processus, ".$this->pref."exploite
       		where idProcessus= id and idParcours=".$parc." order by 1";
    $tbet=$this->mysql->execSQLRes($req);
    $nbp=count($tbet);// 5=indiff renci , sinon 4
    $nba=0;  // compte nb total activit s pour ces 4 ou 5 processus = nb colonnes ds tableau synth se
    $ida=array();  //tableau d'id d'activit s   constuire
    for($i=0 ; $i<$nbp ; $i++){ //pour chaque processus r cup re les activit s
      /*
      $req="select A.id as id, A.nomenclature as nomenclature, left(A.libelle,lngutile) as libelle
         from ".$this->pref."activite A,".$this->pref."domaine D
         where idDomaine=D.id and idProcessus=".$tbet[$i]["id"]." order by 1";
         */
      $req="select A.id as id, A.nomenclature as nomenclature, left(A.libelle,lngutile) as libelle, idEpreuve
         from ".$this->pref."activite A, ".$this->pref."domaine D, ".$this->pref."evalue E
         where A.id=E.idActivite and E.idParcours=".$parc." and
         A.idDomaine=D.id and D.idProcessus=".$tbet[$i]["id"]." order by 1";
      $tba=$this->mysql->execSQLRes($req);
	  $nbtba=count($tba); // nombre d'activit s par processus
	  for ($j=0; $j<$nbtba ; $j++) //pour chaque activit  du processus
		$ida[]=$tba[$j]["id"];//croissant

      $nba+=$nbtba;
      $tbet[$i]["act"]=$tba;
    }
    $tbet["nba"]=$nba;
    $tbet["nbp"]=$nbp;

    $req="select code, libelle from ".$this->pref."typesource order by 1";
    $res=$this->mysql->execSQLRes($req);
    //r cup re les situation ets /stage1 /stage2
    for ($src=0 ; $src<count($res) ; $src++){
	    $req="select ref, libcourt, datedebut, datefin from ".$this->pref."situation, ".$this->pref."source
	          where codeSource=code and numEtudiant=".$numeleve." and valide='O'
	          and  codeTypesource=".$res[$src]["code"]." order by 1";
    	$tbsit=$this->mysql->execSQLRes($req);

	    for ($i=0;$i<count($tbsit); $i++){
	      $req="select distinct idActivite from ".$this->pref."activitecitee
	            where refSituation=".$tbsit[$i]["ref"]." order by 1";//m' nerve, j'y arrive pas avec des left join...
	      $tbida=$this->mysql->execSQLRes($req);
	      $nbtbida=count($tbida);

	      $idac=array();
	      //remplit le tableau avec de X
	      for ($j=0 ; $j<count($ida); $j++) {
			$k=0; //pointe sur $tbida
			$v=$ida[$j];
			while ($k<$nbtbida && $tbida[$k]["idActivite"]!=$v) $k++;
			if ($k<$nbtbida) $idac[$j]="X"; else $idac[$j]=" ";
	      }
	      $tbsit[$i]["act"]=$idac;
	      $req="select codeTypologie from ".$this->pref."esttypo
	          where refSituation=".$tbsit[$i]["ref"]." order by 1";
	      $tbtypo=$this->mysql->execSQLRes($req);
	      $arraytypo=array();
	      $nbtbtypo= count($tbtypo);
	      for ($l=0 ; $l<count($restypo) ; $l++) {
	      	$k=0;
			$v=$restypo[$l]["code"];//normalement 1..4,  mais...
			while ($k<$nbtbtypo && $tbtypo[$k]["codeTypologie"]!=$v) $k++;
			if ($k<$nbtbtypo) $arraytypo[$l]="X"; else $arraytypo[$l]=" ";
	      }
	      $tbsit[$i]["typo"]=$arraytypo;
	    }

	    $tb["sit"][$src]=$tbsit;
	    $tb["libsit"][$src]=$res[$src]["libelle"];
    }
    $tb["et"]=$tbet;
    $tb["ident"]=$this->getEtudiant($numeleve);
    return $tb;
  }

  public function getTableauSynthese($numeleve){
  //retourne les seules activites th ©o trait ©es par l'etudiant
    $req="select distinct id, nomenclature, libelle from ".$this->pref."activite, ".
      $this->pref."activitecitee, ".$this->pref."situation where
      refSituation=ref and idActivite=id
      and numEtudiant=".$numeleve." order by 1";
    $tbet = $this->mysql->execSQLRes($req);

    $tbact=array();
    foreach($tbet as $ligne)
       $tbact[]=$ligne["id"];

    $req="select ref, libcourt, dateDebut, dateFin, libelle from ".$this->pref."situation, ".
          $this->pref."type where codeType=code and numEtudiant=".$numeleve." order by 3";
    $tbsit= $this->mysql->execSQLRes($req);
    for ($i=0 ; $i<count($tbsit) ; $i++){
      $ref=$tbsit[$i]["ref"];
      $req="select idActivite, libcourt, descriptif from ".$this->pref."activitecitee
            where refSituation=".$ref. " order by 1";//peut-etre plusieurs fois la meme ????
      $tbacc=$this->mysql->execSQLRes($req);

      $tbaccid=array();
      foreach($tbacc as $ligne)
        $tbaccid[]=$ligne["idActivite"];

      $k=0;
      for ($j=0 ; $j<count($tbact) ; $j++){
        $idactivite=$tbact[$j];

        if ($tbaccid[$k]==$tbact[$j]){
            $tbsit[$i]["act"][$j][0]=$tbacc[$k];
            $k++;
            $nb=1;
            while ($tbaccid[$k]==$tbact[$j]){
              $tbsit[$i]["act"][$j][$nb]=$tbacc[$k];
              $k++;
              $nb++;
            }

        }else{
           $tbsit[$i]["act"][$j][0]=array();

        }
      }
    }
    $tb["et"]=$tbet;
    $tb["sit"]=$tbsit;
    return $tb;
  }

  public function getSynthese($etud){
//premiere version en texte
    $req="select ref, libcourt as libcs, descriptif as descs
          from ".$this->pref."situation
          where valide = 'O'
          and numEtudiant = ".$etud;

    $res=$this->mysql->execSQLRes($req);

    for ($i=0;$i<count($res);$i++){ //pour chaque situ cit ©e
      //ajoute les activites
      $refs=$res[$i]["ref"];
      $req='select num,libcourt as libca, descriptif as desca, concat(nomenclature," - ",trim(libelle)) as liba
            from '.$this->pref.'activitecitee, '.$this->pref.'activite
            where idActivite=id
            and refSituation='.$refs. ' order by 4';
      $resa = $this->mysql->execSQLRes($req);

      for ($j=0;$j<count($resa);$j++){ //pour chaque activite cit ©e
        //ajoute les comp ©tences cit ©es
        $refa=$resa[$j]["num"];
        $req='select travail, descriptif as descc, concat(nomenclature," - ",trim(libelle)) as libc
             from '.$this->pref.'competencecitee,'.$this->pref.'competence
             where  idCompetence=id
             and numActiviteCitee='.$refa.' order by 3';
        $resa[$j]["comp"]=$this->mysql->execSQLRes($req);

        //ajoute les productions
        $req='select designation
             from '.$this->pref.'production
             where numActiviteCitee='.$refa;
        $resa[$j]["prod"]=$this->mysql->execSQLRes($req);
      }
      $res[$i]["activ"]=$resa;

    }
    return $res;

  }

  public function getSynth($etud){
        //deuxieme version en tableau (quelques champs en + ou -
    $req="select ref, libcourt as libcs, descriptif as descs, datedebut, datefin
          from ".$this->pref."situation
          where valide = 'O'
          and numEtudiant = ".$etud;

    $res=$this->mysql->execSQLRes($req);

    for ($i=0;$i<count($res);$i++){ //pour chaque situ cit ©e
      //ajoute les activitescit es
      $refs=$res[$i]["ref"];
      $req='select commentaire, nomenclature as liba
            from '.$this->pref.'activitecitee, '.$this->pref.'activite
            where idActivite=id
            and refSituation='.$refs. ' order by 1';
      $resa = $this->mysql->execSQLRes($req);

      $res[$i]["activ"]=$resa;

    }
    return $res;
  }


  public function getSituationsXML($i){
    $req='select ref, codeType, codeLocalisation, codeSource, codeCadre, libcourt,
    	  descriptif, contexte, datedebut, datefin, environnement,  moyen, avisperso
         from '.$this->pref.'situation where valide="O" and numEtudiant='.$i;

    return $this->mysql->execSQLRes($req);
  }

    public function getValid($ref){
    $req='select validation, commentaireSituation
          from '.$this->pref.'commentaire
          where refSituation='.$ref;

         // echo $req;

    return $this->mysql->execSQLRes($req);
  }

    public function getActiviteCitee($ref){
    $req='select idActivite, commentaire as commentaireactivite
          from '.$this->pref.'activitecitee
          where refSituation='.$ref;
    return $this->mysql->execSQLRes($req);
  }

  public function getCompetenceCitee($numact){
        $req='select num, idCompetence, descriptif, travail
          from '.$this->pref.'competencecitee
          where numActiviteCitee='.$numact;
    return $this->mysql->execSQLRes($req);
  }

    public function getAppreciation($i){
    $req='select commentaireCompetence, validation
          from '.$this->pref.'appreciation
          where numCompetenceCitee='.$i;
    return $this->mysql->execSQLRes($req);
  }


    public function getProduction($i){
      $req='select numero, designation, adresse
            from '.$this->pref.'production
            where refSituation='.$i;

      return $this->mysql->execSQLRes($req);
  }

  public function getComps($numProf,$numGroupe,$vers,$processus){
    $req='select num, concat(nom," - ",prenom) as nomprenom
            from '.$this->pref.'etudiant
            where numGroupe='.$numGroupe.' order by 2';
    $tb=$this->mysql->execSQLRes($req);
    for ($i=0 ; $i<count($tb) ; $i++){
      $num=$tb[$i]["num"];
      $req='select count(distinct CC.idCompetence) as nbcomp from '.$this->pref.'situation S, '.
            $this->pref.'activitecitee AC, '.$this->pref.'competencecitee CC ';
      if ($processus!=0) $req.=', '.$this->pref.'activite A, '.$this->pref.'domaine D ';
      $req.='where S.numEtudiant='.$num.' and AC.refSituation=S.ref and CC.numActiviteCitee=AC.num';
      if ($processus!=0) $req.=' and AC.idActivite=A.id and A.idDomaine=D.id and D.idProcessus='.$processus;
      $tbc=$this->mysql->execSQLRes($req);
      $tb[$i]["nbcomp"]=$tbc[0]["nbcomp"];
      $req='select count(distinct CC.idCompetence) as nbcompval from '.$this->pref.'situation S, '.
            $this->pref.'activitecitee AC, '.$this->pref.'competencecitee CC, '.$this->pref.'appreciation AP ';
      if ($processus!=0) $req.=', '.$this->pref.'activite A, '.$this->pref.'domaine D ';
      $req.=' where S.numEtudiant='.$num.' and AC.refSituation=S.ref and CC.numActiviteCitee=AC.num
            and AP.numCompetenceCitee=CC.num and validation>=2';
      if ($processus!=0) $req.=' and AC.idActivite=A.id and A.idDomaine=D.id and D.idProcessus='.$processus;
      $tbc=$this->mysql->execSQLRes($req);
      $tb[$i]["nbcompval"]=$tbc[0]["nbcompval"];
    }
    return $tb;
  }

  public function getProcs(){
    $req="select * from ".$this->pref."processus";
    return $this->mysql->execSQLRes($req);
  }

  public function getNomProc($processus){
    $req="select libelle from ".$this->pref."processus where id=".$processus;
    $tb= $this->mysql->execSQLRes($req);
    return $tb[0]["libelle"];
  }

  public function getSesComps($numetud,$processus,$q){
    $cond="";
    if ($q=="n") $cond="not in";
    if ($q=="a") $cond="in";

    if ($processus!=0){
      if ($q!="t")
        //un processus, SOIT valid ©es SOIT non valid ©es
        $req="select distinct C.id, C.libelle, C.nomenclature from ".$this->pref."competence C, "
          .$this->pref."competencecitee CC, ".$this->pref."activitecitee AC, ".$this->pref."situation S, "
          .$this->pref."activite A, ".$this->pref."domaine D
          where C.idActivite=A.id and idDomaine=D.id and idProcessus=".$processus."
          and CC.num ".$cond."
          (select numCompetenceCitee from ".$this->pref."Appreciation  where validation >=2)
          and idCompetence=C.id and numActiviteCitee=AC.num and refSituation=S.ref
          and numEtudiant=".$numetud." order by 3";//pas terrible comme m ©thode...
      else
        //un processus, toutes
        $req="select distinct C.id, C.libelle, C.nomenclature from ".$this->pref."competence C, "
          .$this->pref."competencecitee CC, ".$this->pref."activitecitee AC, ".$this->pref."situation S, "
          .$this->pref."activite A, ".$this->pref."domaine D
          where C.idActivite=A.id and idDomaine=D.id and idProcessus=".$processus."
          and idCompetence=C.id and numActiviteCitee=AC.num and refSituation=S.ref
          and numEtudiant=".$numetud." order by 3";//pas terrible comme m ©thode...
    }else{
      if ($q!="t")
        //tous processus, SOIT valid ©es SOIT non valid ©es
        $req="select distinct C.id, C.libelle, C.nomenclature from ".$this->pref."competence C, "
          .$this->pref."competencecitee CC, ".$this->pref."activitecitee AC, ".$this->pref."situation S
          where idCompetence=C.id and numActiviteCitee=AC.num and refSituation=S.ref
          and CC.num ".$cond."
          (select numCompetenceCitee from ".$this->pref."Appreciation  where validation >=2)
          and numEtudiant=".$numetud." order by 3";//pas terrible comme m ©thode...
      else
        //tous processus, toutes
        $req="select distinct C.id, C.libelle, C.nomenclature from ".$this->pref."competence C, "
          .$this->pref."competencecitee CC, ".$this->pref."activitecitee AC, ".$this->pref."situation S
          where idCompetence=C.id and numActiviteCitee=AC.num and refSituation=S.ref
          and numEtudiant=".$numetud." order by 3";//pas terrible comme m ©thode...
   }


    $tb= $this->mysql->execSQLRes($req);
    for ($i=0;$i<count($tb);$i++){
      $req="select CC.num, CC.descriptif, AC.libcourt as alibcourt, S.libcourt as slibcourt
            from ".$this->pref."competencecitee CC, ".$this->pref."activitecitee AC, ".$this->pref."situation S
            where numActiviteCitee=AC.num and refSituation=S.ref
            and numEtudiant=".$numetud." and idCompetence=".$tb[$i]["id"]." order by 1";
      $tb[$i]["comp"]= $this->mysql->execSQLRes($req);
    }
    return $tb;
  }

  public function getUneComp($numcomp){
    $req="select descriptif, travail, libelle, nomenclature, coalesce(commentaireCompetence, '') as commentaire,
          coalesce(validation, 0) as validation from ".$this->pref."competencecitee
           join ".$this->pref."competence
          on idCompetence=id left join ".$this->pref."appreciation on num=numCompetenceCitee
          where num=".$numcomp;
    $tb=$this->mysql->execSQLRes($req);
    return $tb[0];
  }

  public function donneNiveaux(){
    $req="select * from ".$this->pref."niveau";
    return $this->mysql->execSQLRes($req);
  }

  public function apprecie($numprof, $num, $com, $valid){
    $req="select count(*) as nb from ".$this->pref."appreciation
          where numCompetenceCitee=".$num;
    $tb=$this->mysql->execSQLRes($req);
    if ($tb[0]["nb"]==0) {
      $req="insert into ".$this->pref."appreciation (numCompetenceCitee, commentaireCompetence,
            validation, dateAppreciation, numProfesseur) values
            (".$num.",'".$com."',".$valid.",'".$this->dtj()."',".$numprof.")";
    } else {
      $req="update ".$this->pref."appreciation set commentaireCompetence='".$com."',
            validation=".$valid.", dateAppreciation='".$this->dtj().
            "', numProfesseur=".$numprof." where numCompetenceCitee=".$num;
    }
    $this->mysql->execSQL($req);
  }
   public function getProcessus(){
    $req="select * from ".$this->pref."processus";
    return $this->mysql->execSQLRes($req);
   }

   public function sauveDoc($e,$iddoc,$titre,$el,$nom, $numeleve, $t){
   //iddoc=0 =enregistre ; <>0 = maj
   //$e=t : les fichiers ne sont pas pr ©supprimes
   //$e=u : ils sont marques
   //formats :
   //numeleve =repertoire perso dans dirrw/ficstage
   //__nom = fichier texte identifiant l'eleve pour le lecteur
   //r_xxx_c_numeleve = rapport contenu
   //r_xxx_t_numeleve = rapport titre
   //b_xxx_c_numeleve = bilan contenu
   //b_xxx_t_numeleve = bilan titre

   //r_xxx_r_numeleve = rapport reponse prof
   //b_xxx_r_numeleve = bilan reponse prof

   //r_xxx_d_numeleve = rapport contenu supprim © (en instance)
   //r_xxx_u_numeleve = rapport titre supprim © (en instance)
   //b_xxx_d_numeleve = bilan contenu supprim © (en instance)
   //b_xxx_u_numeleve = bilan titre supprim © (en instance)
   //r_xxx_s_numeleve = rapport reponse prof supprim © (en instance)
   //b_xxx_s_numeleve = bilan reponse prof supprim © (en instance)

   //la suppression definitive (destruction) efface les fichiers du SE

    if ($t!=""){
      $numeleve=substr('000'.$numeleve,-3,3);

      $rep='./dirrw/ficstage/'.$numeleve.'/';
      if (!@opendir($rep)){//cree repert eleve
        mkdir($rep);
        $fic=fopen($rep.'__'.$nom,"w");
        fputs($fic,$nom.'_'.$this->dtj());
        fclose($fic);
        $fic=fopen($rep.'index.htm',"w");
        fclose($fic);
      }

      if ($iddoc==0){
      //recherche n  suivant pour creation
        $directory=opendir($rep);
        $max=0;
        while($fichier = readdir($directory)) {
          if ($this->donneTypeFichier($fichier)==$t){
            $num=$this->donneNumFichier($fichier);
            if ($num>$max) $max=$num;
          }
        }
        $max++;
      } else $max=$iddoc; //maj

      $maxi=substr('000'.$max,-3,3);


      //cree fichier titre
      $nomfic=$this->donneNomFichier($rep, $t, $maxi, $numeleve, $e);

      //echo 'FIC='.$nomfic;//************************


      $fic=fopen($nomfic,"w");
      fputs($fic,$titre);
      fclose($fic);

      if ($e=="t") $f="c"; else $f="d";//on les conserve effac ©s si besoin
      //cree fichier contenu (zipper les gros ?)
      $nomfic=$this->donneNomFichier($rep, $t, $maxi, $numeleve, $f);
      $fic=fopen($nomfic,"w");
      fputs($fic,$el);
      fclose($fic);

      return $max;
    }else return 0;
   }

   public function getUnDoc($e,$iddoc, $numeleve,$t){
     if ($t!=""){
      $numeleve=substr('000'.$numeleve,-3,3);
      $rep='./dirrw/ficstage/'.$numeleve.'/';
      $iddoc=substr('000'.$iddoc,-3,3);
      if ($e=="t") $f="c"; else $f="d";

      $nomfic=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, $f);
      $fic=fopen($nomfic,"r");
      $cont="";
      while(!feof($fic)) {
		    $ligne = fgets($fic);
		    $cont .= $ligne;
	    }
	    fclose($fic);
	    //dezipper ?
	    $tb["cont"]=stripslashes($cont);


	    $nomfic=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, $e);
      $fic=fopen($nomfic,"r");
      $titre= fgets($fic);
	    fclose($fic);
	    $tb["titre"]=stripslashes($titre);

      return $tb;
     } else return null;
   }

   //formats li ©s
   private function donneNomFichier($rep, $t, $iddoc, $numeleve, $type){
   //&t=r ou b rapport / bilan
   //$type=c, t, r ou d, u, s contenu / titre / reponse / les m ªmes supprim ©s
      return $rep.$t.'_'.$iddoc.'_'.$type.'_'.$numeleve;
   }
   private function donneTypeFichier($nomfic){//r=rapport / b=bilan
      return substr($nomfic,0,1);
   }
   private function donneNumFichier($nomfic){
      return intval(substr($nomfic,2,3));
   }
   private function estFichierTitre($nomfic){
      $l=substr($nomfic,6,1);
      return ($l=="t" || $l=="u");
   }
    private function donneEtatFichier($nomfic){ //t=ok u=suppr
      return substr($nomfic,6,1);
   }
   private function dt($dte){
      return date("d/m/Y",$dte);
   }

   public function getLesDoc($numel){
   //r_xxx_c_numeleve = rapport contenu
   //r_xxx_t_numeleve = rapport titre
   //b_xxx_c_numeleve = bilan contenu
   //b_xxx_t_numeleve = bilan titre

   //r_xxx_r_numeleve = rapport reponse prof
   //b_xxx_r_numeleve = bilan reponse prof

   //r_xxx_d_numeleve = rapport contenu supprim © (en instance)
   //r_xxx_u_numeleve = rapport titre supprim © (en instance)
   //b_xxx_d_numeleve = bilan contenu supprim © (en instance)
   //b_xxx_u_numeleve = bilan titre supprim © (en instance)
   //r_xxx_s_numeleve = rapport reponse prof supprim © (en instance)
   //b_xxx_s_numeleve = bilan reponse prof supprim © (en instance)
      $numeleve=substr('000'.$numel,-3,3);
      $rep='./dirrw/ficstage/'.$numeleve.'/';
      $liste=array();

      if($directory=@opendir($rep)){
        $i=0;
        while($fichier = readdir($directory)) {
          if ($this->estFichierTitre($fichier)){
            $fic=fopen($rep.$fichier,"r");
            $ty=$this->donneTypeFichier($fichier);
            $liste[$ty][$i]["titre"]=stripslashes(fgets($fic));
            fclose($fic);
            $liste[$ty][$i]["etat"]=$this->donneEtatFichier($fichier);
            $liste[$ty][$i]["dte"]=$this->dt(filemtime($rep.$fichier));
            //$liste[$ty][$i]["taille"]=$this->filesize($fichier);
            $num=$this->donneNumFichier($fichier);
            $liste[$ty][$i]["num"]=$num;
            //reponse prof existe ?
            $iddoc=substr('000'.$num,-3,3);
            $fic=$this->donneNomFichier($rep, $ty, $iddoc, $numeleve, "r");
            $ficsup=$this->donneNomFichier($rep, $ty, $iddoc, $numeleve, "s");

            //joker ? : valable pour tout SE ?
            //$fic=$this->donneNomFichier($rep, $ty, $num, $numel, "?");
            $liste[$ty][$i]["rep"]= (file_exists($fic) || file_exists($ficsup));
            $i++;
          }
        }
      }
      return $liste;
   }

   public function supprimerDoc($iddoc,$t,$numeleve){
      $numeleve=substr('000'.$numeleve,-3,3);
      $rep='./dirrw/ficstage/'.$numeleve.'/';
      $iddoc=substr('000'.$iddoc,-3,3);
      $nomfictitre=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, "t");
      $nomficcontenu=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, "c");
      $nomficreponse=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, "r");
   //&t=r ou b rapport / bilan
   //$type=c, t, r ou d, u, s contenu / titre / reponse / les m ªmes supprim ©s
      $nomfictitresuppr=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, "u");
      $nomficcontenusuppr=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, "d");
      $nomficreponsesuppr=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, "s");
      rename($nomfictitre,$nomfictitresuppr);
      rename($nomficcontenu,$nomficcontenusuppr);
      @rename($nomficreponse,$nomficreponsesuppr);
   }

   public function restaurerDoc($iddoc,$t,$numeleve){
      $numeleve=substr('000'.$numeleve,-3,3);
      $rep='./dirrw/ficstage/'.$numeleve.'/';
      $iddoc=substr('000'.$iddoc,-3,3);
      $nomfictitre=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, "t");
      $nomficcontenu=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, "c");
      $nomficreponse=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, "r");
   //&t=r ou b rapport / bilan
   //$type=c, t, r ou d, u, s contenu / titre / reponse / les m ªmes supprim ©s
      $nomfictitresuppr=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, "u");
      $nomficcontenusuppr=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, "d");
      $nomficreponsesuppr=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, "s");
      rename($nomfictitresuppr,$nomfictitre);
      rename($nomficcontenusuppr,$nomficcontenu);
      @rename($nomficreponsesuppr,$nomficreponse);
   }

   public function detruireDoc($iddoc,$t,$numeleve){
      $numeleve=substr('000'.$numeleve,-3,3);
      $rep='./dirrw/ficstage/'.$numeleve.'/';
      $iddoc=substr('000'.$iddoc,-3,3);
      $nomfictitresuppr=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, "u");
      $nomficcontenusuppr=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, "d");
      $nomficreponsesuppr=$this->donneNomFichier($rep, $t, $iddoc, $numeleve, "s");
      unlink($nomfictitresuppr);
      unlink($nomficcontenusuppr);
      @unlink($nomficreponsesuppr);
   }

}
?>

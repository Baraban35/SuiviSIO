<?php

$debut='CREATE TABLE ';
$fin=')ENGINE=InnoDB DEFAULT CHARACTER SET UTF8 COLLATE UTF8_general_ci;';

$requete=array();

$requete["parcours"]='
   id SMALLINT PRIMARY KEY,
   nomenclature CHAR(4) NOT NULL,
   libelle VARCHAR(50) NOT NULL';

$requete["processus"]='
   id SMALLINT PRIMARY KEY,
   nomenclature CHAR(2) NOT NULL,
   libelle VARCHAR(60) NOT NULL';

$requete["exploite"]='
   idParcours SMALLINT,
   idProcessus SMALLINT,
   constraint  exploitePK PRIMARY KEY (idParcours, idProcessus)';

$requete["domaine"]='
   id SMALLINT PRIMARY KEY,
   idProcessus SMALLINT NOT NULL,
   nomenclature CHAR(4) NOT NULL,
   libelle VARCHAR(60) NOT NULL';

$requete["activite"]='
   id SMALLINT PRIMARY KEY,
   idDomaine SMALLINT NOT NULL,
   nomenclature CHAR(6) NOT NULL,
   lngutile SMALLINT NOT NULL,
   libelle VARCHAR(150) NOT NULL';

$requete["competence"]='
   id SMALLINT PRIMARY KEY,
   idActivite SMALLINT NOT NULL,
   nomenclature CHAR(9) NOT NULL,
   libelle VARCHAR(210) NOT NULL';

$requete["epreuve"]='
   id SMALLINT PRIMARY KEY,
   nomenclature CHAR(4) NOT NULL';

$requete["evalue"]='
   idParcours SMALLINT,
   idEpreuve SMALLINT,
   idActivite SMALLINT,
   constraint  evaluePK PRIMARY KEY (idParcours, idEpreuve, idActivite)';

$requete["localisation"]='
   code SMALLINT PRIMARY KEY,
   libelle CHAR(32) NOT NULL';

$requete["typesource"]='
   code SMALLINT PRIMARY KEY,
   libelle VARCHAR(70) NOT NULL';

$requete["source"]='
   code SMALLINT PRIMARY KEY,
   libelle CHAR(20) NOT NULL,
   codeTypesource SMALLINT';

$requete["type"]='
   code SMALLINT PRIMARY KEY,
   libelle CHAR(12) NOT NULL';

$requete["cadre"]='
   code SMALLINT PRIMARY KEY,
   libelle CHAR(20) NOT NULL';

$requete["typologie"]='
   code SMALLINT PRIMARY KEY,
   lngutile SMALLINT NOT NULL,
   libelle VARCHAR(85) NOT NULL';




$requete["etudiant"]='
   num INTEGER PRIMARY KEY AUTO_INCREMENT ,
   numGroupe INTEGER NULL,
   nom CHAR(32) NOT NULL,
   prenom CHAR(32) NOT NULL,
   mel CHAR(64) NOT NULL,
   mdp CHAR(32) NOT NULL,
   numexam CHAR(16) NULL,
   valide CHAR(1) NOT NULL DEFAULT "O"';

$requete["groupe"]='
   num INTEGER PRIMARY KEY AUTO_INCREMENT,
   nom CHAR(12) NULL,
   annee CHAR(2) NULL,
   idParcours SMALLINT DEFAULT 0';

$requete["professeur"]='
   num INTEGER PRIMARY KEY AUTO_INCREMENT ,
   nom CHAR(32) NOT NULL,
   prenom CHAR(32) NOT NULL,
   mel CHAR(64) NOT NULL,
   mdp CHAR(32) NOT NULL,
   niveau INTEGER NOT NULL,
   valide CHAR(1) DEFAULT "O"';

$requete["exerce"]='
   numProfesseur INTEGER NOT NULL,
   numGroupe INTEGER NOT NULL,
   constraint  exercePK PRIMARY KEY (numProfesseur, numGroupe)';



$requete["situation"]='
   ref INTEGER AUTO_INCREMENT PRIMARY KEY,
   numEtudiant INTEGER NOT NULL,
   codeLocalisation SMALLINT NOT NULL,
   codeSource SMALLINT NOT NULL,
   codeType SMALLINT NOT NULL,
   codeCadre SMALLINT NOT NULL,
   libcourt VARCHAR(64) NOT NULL,
   descriptif VARCHAR(255) NOT NULL,
   contexte VARCHAR(255) NULL,
   datedebut DATE,
   datefin DATE,
   environnement VARCHAR(255) NULL,
   moyen VARCHAR(255) NULL,
   avisperso VARCHAR(255) NULL,
   valide CHAR(1) NOT NULL  DEFAULT "O",
   datemodif DATE';

$requete["activitecitee"]='
   idActivite SMALLINT NOT NULL,
   refSituation INTEGER NOT NULL,
   commentaire VARCHAR(255) NULL,
   constraint  actcitPK PRIMARY KEY (idActivite, refSituation)';

$requete["production"]='
   numero INTEGER AUTO_INCREMENT PRIMARY KEY,
   refSituation INTEGER NOT NULL,
   designation VARCHAR(255) NULL,
   adresse VARCHAR(255) NULL';

$requete["commentaire"]='
   numero INTEGER AUTO_INCREMENT PRIMARY KEY,
   refSituation INTEGER,
   numProfesseur INTEGER NULL,
   commentaire VARCHAR(255) NULL,
   datecommentaire DATE';

$requete["esttypo"]='
   refSituation INTEGER,
   codeTypologie SMALLINT,
   constraint  esttypoPK PRIMARY KEY (refSituation, codeTypologie)';

?>


-- -----------------------------------------------------------------------------
--       TABLE : PORT_TYPE
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_TYPE
   (
    CODE INT(6)  NOT NULL,
    LIBELLE CHAR(12)  NOT NULL
,   CONSTRAINT PK_PORT_TYPE PRIMARY KEY (CODE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_TYPOLOGIE
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_TYPOLOGIE
   (
    CODE INT(6)  NOT NULL,
    LNGUTILE INT(6)  NOT NULL,
    LIBELLE VARCHAR(85)  NOT NULL
,   CONSTRAINT PK_PORT_TYPOLOGIE PRIMARY KEY (CODE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_CADRE
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_CADRE
   (
    CODE INT(6)  NOT NULL,
    LIBELLE CHAR(20)  NOT NULL
,   CONSTRAINT PK_PORT_CADRE PRIMARY KEY (CODE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_PARCOURS
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_PARCOURS
   (
    ID INT(6)  NOT NULL,
    NOMENCLATURE CHAR(4)  NOT NULL,
    LIBELLE VARCHAR(50)  NOT NULL
,   CONSTRAINT PK_PORT_PARCOURS PRIMARY KEY (ID)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_PROCESSUS
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_PROCESSUS
   (
    ID INT(6)  NOT NULL,
    NOMENCLATURE CHAR(2)  NOT NULL,
    LIBELLE VARCHAR(60)  NOT NULL
,   CONSTRAINT PK_PORT_PROCESSUS PRIMARY KEY (ID)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_PROFESSEUR
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_PROFESSEUR
   (
    NUM INT(11)  NOT NULL,
    NOM CHAR(32)  NOT NULL,
    PRENOM CHAR(32)  NOT NULL,
    MEL CHAR(64)  NOT NULL,
    MDP CHAR(32)  NOT NULL,
    NIVEAU INT(11)  NOT NULL,
    VALIDE CHAR(1) 
      DEFAULT 'O' NULL
,   CONSTRAINT PK_PORT_PROFESSEUR PRIMARY KEY (NUM)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_EPREUVE
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_EPREUVE
   (
    ID INT(6)  NOT NULL,
    NOMENCLATURE CHAR(4)  NOT NULL
,   CONSTRAINT PK_PORT_EPREUVE PRIMARY KEY (ID)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_GROUPE
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_GROUPE
   (
    NUM INT(11)  NOT NULL,
    NOM CHAR(12) 
      DEFAULT NULL,
    ANNEE CHAR(2) 
      DEFAULT NULL,
    IDPARCOURS INT(6) 
      DEFAULT 0
,   CONSTRAINT PK_PORT_GROUPE PRIMARY KEY (NUM)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_LOCALISATION
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_LOCALISATION
   (
    CODE INT(6)  NOT NULL,
    LIBELLE CHAR(32)  NOT NULL
,   CONSTRAINT PK_PORT_LOCALISATION PRIMARY KEY (CODE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_DOMAINE
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_DOMAINE
   (
    ID INT(6)  NOT NULL,
    IDPROCESSUS INT(6)  NOT NULL,
    NOMENCLATURE CHAR(4)  NOT NULL,
    LIBELLE VARCHAR(60)  NOT NULL
,   CONSTRAINT PK_PORT_DOMAINE PRIMARY KEY (ID)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_SOURCE
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_SOURCE
   (
    CODE INT(6)  NOT NULL,
    LIBELLE CHAR(20)  NOT NULL,
    CODETYPESOURCE INT(6) 
      DEFAULT NULL
,   CONSTRAINT PK_PORT_SOURCE PRIMARY KEY (CODE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_ACTIVITE
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_ACTIVITE
   (
    ID INT(6)  NOT NULL,
    IDDOMAINE INT(6)  NOT NULL,
    NOMENCLATURE CHAR(7)  NOT NULL,
    LNGUTILE INT(6)  NOT NULL,
    LIBELLE VARCHAR(150)  NOT NULL
,   CONSTRAINT PK_PORT_ACTIVITE PRIMARY KEY (ID)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_ACTIVITECITEE
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_ACTIVITECITEE
   (
    IDACTIVITE INT(6)  NOT NULL,
    REFSITUATION INT(11)  NOT NULL,
    COMMENTAIRE TEXT  NULL
,   CONSTRAINT PK_PORT_ACTIVITECITEE PRIMARY KEY (IDACTIVITE, REFSITUATION)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_ESTTYPO
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_ESTTYPO
   (
    REFSITUATION INT(11)  NOT NULL DEFAULT 0,
    CODETYPOLOGIE INT(6)  NOT NULL DEFAULT 0
,   CONSTRAINT PK_PORT_ESTTYPO PRIMARY KEY (REFSITUATION, CODETYPOLOGIE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_ETUDIANT
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_ETUDIANT
   (
    NUM INT(11)  NOT NULL,
    NUMGROUPE INT(11) 
      DEFAULT NULL,
    NOM CHAR(32)  NOT NULL,
    PRENOM CHAR(32)  NOT NULL,
    MEL CHAR(64)  NOT NULL,
    MDP CHAR(32)  NOT NULL,
    NUMEXAM CHAR(16) 
      DEFAULT NULL,
    VALIDE CHAR(1) NOT NULL DEFAULT 'O'
,   CONSTRAINT PK_PORT_ETUDIANT PRIMARY KEY (NUM)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_EVALUE
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_EVALUE
   (
    IDPARCOURS INT(6)  NOT NULL DEFAULT 0,
    IDEPREUVE INT(6)  NOT NULL DEFAULT 0,
    IDACTIVITE INT(6)  NOT NULL DEFAULT 0
,   CONSTRAINT PK_PORT_EVALUE PRIMARY KEY (IDPARCOURS, IDEPREUVE, IDACTIVITE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_EXERCE
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_EXERCE
   (
    NUMPROFESSEUR INT(11)  NOT NULL,
    NUMGROUPE INT(11)  NOT NULL
,   CONSTRAINT PK_PORT_EXERCE PRIMARY KEY (NUMPROFESSEUR, NUMGROUPE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_EXPLOITE
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_EXPLOITE
   (
    IDPARCOURS INT(6)  NOT NULL DEFAULT 0,
    IDPROCESSUS INT(6) NOT NULL DEFAULT 0
,   CONSTRAINT PK_PORT_EXPLOITE PRIMARY KEY (IDPARCOURS, IDPROCESSUS)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_PRODUCTION
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_PRODUCTION
   (
    NUMERO INT(11)  NOT NULL,
    REFSITUATION INT(11)  NOT NULL,
    DESIGNATION VARCHAR(1024) 
      DEFAULT NULL,
    ADRESSE VARCHAR(255) 
      DEFAULT NULL
,   CONSTRAINT PK_PORT_PRODUCTION PRIMARY KEY (NUMERO)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_SITUATION
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_SITUATION
   (
    REF INT(11)  NOT NULL,
    NUMETUDIANT INT(11)  NOT NULL,
    CODESOURCE INT(6)  NOT NULL,
    CODETYPE INT(6)  NOT NULL,
    CODECADRE INT(6)  NOT NULL,
    LIBCOURT VARCHAR(128)  NOT NULL,
    DESCRIPTIF TEXT	NOT NULL,
    CONTEXTE TEXT  NULL,
    DATEDEBUT DATE 
      DEFAULT NULL,
    DATEFIN DATE 
      DEFAULT NULL,
    ENVIRONNEMENT TEXT  NULL,
    MOYEN TEXT  NULL,
    AVISPERSO TEXT  NULL,
    VALIDE CHAR(1) NOT NULL DEFAULT 'O',
    DATEMODIF DATE 
      DEFAULT NULL,
    CODELOCALISATION INT(6)  NOT NULL
,   CONSTRAINT PK_PORT_SITUATION PRIMARY KEY (REF)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_COMMENTAIRE
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_COMMENTAIRE
   (
    NUMERO INT(11)  NOT NULL,
    REFSITUATION INT(11) 
      DEFAULT NULL,
    NUMPROFESSEUR INT(11) 
      DEFAULT NULL,
    COMMENTAIRE TEXT  NULL,
    DATECOMMENTAIRE DATE 
      DEFAULT NULL
,   CONSTRAINT PK_PORT_COMMENTAIRE PRIMARY KEY (NUMERO)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PORT_COMPETENCE
-- -----------------------------------------------------------------------------

CREATE TABLE PORT_COMPETENCE
   (
    ID INT(6)  NOT NULL,
    IDACTIVITE INT(6)  NOT NULL,
    NOMENCLATURE CHAR(9)  NOT NULL,
    LIBELLE VARCHAR(210)  NOT NULL
,   CONSTRAINT PK_PORT_COMPETENCE PRIMARY KEY (ID)  
   ) ;


-- -----------------------------------------------------------------------------
-- AJOUT DE LA CONTRAINTE AUTO_INCREMENT SUR CLES PRIMAIRES
-- -----------------------------------------------------------------------------

ALTER TABLE port_commentaire
  MODIFY numero int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE port_etudiant
  MODIFY num int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE port_groupe
  MODIFY num int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE port_production
  MODIFY numero int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE port_professeur
  MODIFY num int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE PORT_SITUATION
  MODIFY ref int(11) NOT NULL AUTO_INCREMENT;

-- -----------------------------------------------------------------------------
--       CREATION DES REFERENCES DE TABLE
-- -----------------------------------------------------------------------------

ALTER TABLE PORT_DOMAINE ADD (
     CONSTRAINT FK_DOMAINE_PROCESSUS
          FOREIGN KEY (IDPROCESSUS)
               REFERENCES PORT_PROCESSUS (ID))   ;

ALTER TABLE PORT_SOURCE ADD (
     CONSTRAINT FK_SOURCE_TYPE
          FOREIGN KEY (CODETYPESOURCE)
               REFERENCES PORT_TYPE (CODE))   ;

ALTER TABLE PORT_ACTIVITE ADD (
     CONSTRAINT FK_ACTIVITE_DOMAINE
          FOREIGN KEY (IDDOMAINE)
               REFERENCES PORT_DOMAINE (ID))   ;

ALTER TABLE PORT_ACTIVITECITEE ADD (
     CONSTRAINT FK_ACTIVITECITEE_SITUATION
          FOREIGN KEY (REFSITUATION)
               REFERENCES PORT_SITUATION (REF))   ;

ALTER TABLE PORT_ACTIVITECITEE ADD (
     CONSTRAINT PORT_ACTIVITECITEE_ACTIVITE
          FOREIGN KEY (IDACTIVITE)
               REFERENCES PORT_ACTIVITE (ID))   ;

ALTER TABLE PORT_ESTTYPO ADD (
     CONSTRAINT FK_ESTTYPO_SITUATION
          FOREIGN KEY (REFSITUATION)
               REFERENCES PORT_SITUATION (REF))   ;

ALTER TABLE PORT_ESTTYPO ADD (
     CONSTRAINT FK_ESTTYPO_TYPOLOGIE
          FOREIGN KEY (CODETYPOLOGIE)
               REFERENCES PORT_TYPOLOGIE (CODE))   ;

ALTER TABLE PORT_ETUDIANT ADD (
     CONSTRAINT FK_ETUDIANT_GROUPE
          FOREIGN KEY (NUMGROUPE)
               REFERENCES PORT_GROUPE (NUM))   ;

ALTER TABLE PORT_EVALUE ADD (
     CONSTRAINT FK_EVALUE_PARCOURS
          FOREIGN KEY (IDPARCOURS)
               REFERENCES PORT_PARCOURS (ID))   ;

ALTER TABLE PORT_EVALUE ADD (
     CONSTRAINT FK_EVALUE_EPREUVE
          FOREIGN KEY (IDEPREUVE)
               REFERENCES PORT_EPREUVE (ID))   ;

ALTER TABLE PORT_EVALUE ADD (
     CONSTRAINT FK_EVALUE_ACTIVITE
          FOREIGN KEY (IDACTIVITE)
               REFERENCES PORT_ACTIVITE (ID))   ;

ALTER TABLE PORT_EXERCE ADD (
     CONSTRAINT FK_EXERCE_PROFESSEUR
          FOREIGN KEY (NUMPROFESSEUR)
               REFERENCES PORT_PROFESSEUR (NUM))   ;

ALTER TABLE PORT_EXERCE ADD (
     CONSTRAINT FK_EXERCE_GROUPE
          FOREIGN KEY (NUMGROUPE)
               REFERENCES PORT_GROUPE (NUM))   ;

ALTER TABLE PORT_EXPLOITE ADD (
     CONSTRAINT FK_EXPLOITE_PARCOURS
          FOREIGN KEY (IDPARCOURS)
               REFERENCES PORT_PARCOURS (ID))   ;

ALTER TABLE PORT_EXPLOITE ADD (
     CONSTRAINT FK_EXPLOITE_PROCESSUS
          FOREIGN KEY (IDPROCESSUS)
               REFERENCES PORT_PROCESSUS (ID))   ;

ALTER TABLE PORT_PRODUCTION ADD (
     CONSTRAINT FK_PRODUCTION_SITUATION
          FOREIGN KEY (REFSITUATION)
               REFERENCES PORT_SITUATION (REF))   ;

ALTER TABLE PORT_SITUATION ADD (
     CONSTRAINT FK_SITUATION_ETUDIANT
          FOREIGN KEY (NUMETUDIANT)
               REFERENCES PORT_ETUDIANT (NUM))   ;

ALTER TABLE PORT_SITUATION ADD (
     CONSTRAINT FK_SITUATION_TYPE
          FOREIGN KEY (CODETYPE)
               REFERENCES PORT_TYPE (CODE))   ;

ALTER TABLE PORT_SITUATION ADD (
     CONSTRAINT FK_SITUATION_SOURCE
          FOREIGN KEY (CODESOURCE)
               REFERENCES PORT_SOURCE (CODE))   ;

ALTER TABLE PORT_SITUATION ADD (
     CONSTRAINT FK_SITUATION_CADRE
          FOREIGN KEY (CODECADRE)
               REFERENCES PORT_CADRE (CODE))   ;

ALTER TABLE PORT_SITUATION ADD (
     CONSTRAINT FK_PORT_SITUATION_PORT_LOCALIS
          FOREIGN KEY (CODELOCALISATION)
               REFERENCES PORT_LOCALISATION (CODE))   ;

ALTER TABLE PORT_COMMENTAIRE ADD (
     CONSTRAINT FK_COMMENTAIRE_SITUATION
          FOREIGN KEY (REFSITUATION)
               REFERENCES PORT_SITUATION (REF))   ;

ALTER TABLE PORT_COMPETENCE ADD (
     CONSTRAINT FK_COMPETENCE_ACTIVITE
          FOREIGN KEY (IDACTIVITE)
               REFERENCES PORT_ACTIVITE (ID))   ;


-- -----------------------------------------------------------------------------
--                FIN DE GENERATION
-- -----------------------------------------------------------------------------

